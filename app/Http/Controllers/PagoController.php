<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Pago;
use App\Presupuestooperatoria;
use App\Presupuestooperatoriadetalle;
use App\Presupuestoortodoncia;
use App\Presupuestoortodonciadetalle;
use Globales;   // helpers


class PagoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pagos = Pago::with('tipodocumento')->orderBy('id','ASC')->where('activo',true)->get();
        return $pagos;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        DB::beginTransaction();    
        try {
            $rules = ['sede_id'             => 'required',
                      'ptoventa'            => 'required',
                      'origen'              => 'required',
                      'empleado_id'         => 'required',
                      'tipodocumento_id'    => 'required',
                      'serie'               => 'required',
                      'valor'               => 'required',
                      'igv'                 => 'required',
                      'user_id'             => 'required',
                      'fecha_pago'          => 'required',
                      'moneda_id'           => 'required',
                      'tipocambio_id'       => 'required',
                      'tipo'                => 'required',
                      ];
            if($request->has('fecha_pago')){
                $rules = array_add($rules, 'fecha_pago', 'date_format:d-m-Y H:i:s');
            }                      
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
            // validando que el pago adelantado no sea mayor que el saldo pendiente del presupuesto
            if($request->get('origen') == 1){       // operatoria
                $TxPendiente = 0;
                $pptodet =  Presupuestooperatoriadetalle::where(['presupuestooperatoria_id' => $request->get('presupuestooperatoria_id'),'activo' => true])->get();       
                foreach ($pptodet as $value) {
                    if($value->pagado == 0){
                        $TxPendiente += floatval($value->costo);
                    }
                }
                $ppto = Presupuestooperatoria::findOrFail($request->get('presupuestooperatoria_id'));
                $debe = floatval($TxPendiente) - floatval($ppto->saldo);
                if(floatval($request->get('total')) > floatval($debe)){
                    return response()->json(['errors'=>'El Pago adelantado no puede ser mayor al pendiente del Presupuesto']);
                }                 
            }
            if($request->get('origen') == 2){       // ortodoncia
                $TxPendiente = 0;
                $pptodet =  Presupuestoortodonciadetalle::where(['presupuestoortodoncia_id' => $request->get('presupuestoortodoncia_id'),'activo' => true])->get();       
                foreach ($pptodet as $value) {
                    if($value->pagado == 0){
                        $TxPendiente += floatval($value->costo);
                    }
                }
                $ppto = Presupuestoortodoncia::findOrFail($request->get('presupuestoortodoncia_id'));
                $debe = floatval($TxPendiente) - floatval($ppto->saldo);
                if(floatval($request->get('total')) > floatval($debe)){
                    return response()->json(['errors'=>'El Pago adelantado no puede ser mayor al pendiente del Presupuesto']);
                } 
            }             
            /*-- crear el pago --*/           
            $pago = new Pago($request->all());
            $pago->fecha_pago = Globales::FormatFecYMD_hms($request->get('fecha_pago'));   
            $pago->numero = Globales::comprobantesedes_correlativo($request->get('sede_id'),$request->get('tipodocumento_id'),$request->get('ptoventa'),$request->get('serie'));         
            $pago->save();

            if($request->get('origen') == 1){       // operatoria
                if($request->get('tipo') == 1){     // pago directo
                    /*-- actualizar los registros detalle de operatorias --*/
                    foreach ($request->get('presupuestodetalles') as $det) {
                        Presupuestooperatoriadetalle::where(['id' => $det, 'activo' => true])->update(['pagado' => 1,'tipo_pagado' => 1,'pago_id' => $pago->id]);
                    }
                }else{  // pago adelantado
                    /*-- Carga el saldo en el presupuesto --*/
                    $ppto = Presupuestooperatoria::findOrFail($request->get('presupuestooperatoria_id'));
                    $ppto->saldo = floatval($ppto->saldo) + floatval($request->get('total'));
                    $ppto->save();
                }                  
            }
            if($request->get('origen') == 2){       // ortodoncia
                if($request->get('tipo') == 1){     // pago directo
                    /*-- actualizar los registros detalle de ortodoncias --*/
                    foreach ($request->get('presupuestodetalles') as $det) {
                        Presupuestoortodonciadetalle::where(['id' => $det, 'activo' => true])->update(['pagado' => 1,'tipo_pagado' => 1,'pago_id' => $pago->id]);
                    }
                }else{  // pago adelantado
                    /*-- Carga el saldo en el presupuesto --*/
                    $ppto = Presupuestoortodoncia::findOrFail($request->get('presupuestoortodoncia_id'));
                    $ppto->saldo = floatval($ppto->saldo) + floatval($request->get('total'));
                    $ppto->save();
                } 
            }
   
            DB::commit();        
            return;
        }
        catch(Exception $e){
            DB::rollback();
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
