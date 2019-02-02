<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Presupuestoortodoncia;
use App\Presupuestoortodonciadetalle;
use Globales;   // helpers

class PresupuestosortodonciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pptosortodoncias = Presupuestoortodoncia::with('paciente','empleado','estadopresupuesto','presupuestosortodonciasdetalles','presupuestosortodonciasdetalles.tarifario.servicio','presupuestosortodonciasdetalles.moneda','tarifario.servicio')->orderBy('id','DESC')->where('activo',true)->get();
        return $pptosortodoncias;  
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
            $rules = ['paciente_id'         => 'required',
                      'empleado_id'         => 'required',
                      'tarifario_id'        => 'required',
                      'cuotas'              => 'required',
                      'cuota_inicial'       => 'required',
                      'control_mensual'     => 'required',
                      'tipocambio_id'       => 'required',
                      'sede_id'             => 'required',
                      'user_id'             => 'required',
                     ];

            if($request->has('fecha_registro')){
                $rules = array_add($rules, 'fecha_registro', 'date_format:d-m-Y');
            }                     
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }       
    
            $ppto = new Presupuestoortodoncia($request->all());
            $ppto->fecha_registro = Globales::FormatFecYMD($request->get('fecha_registro'));
            $ppto->save();
            // Agregamos el detalle de la cuota inicial al presupuesto
            $pptodet = new Presupuestoortodonciadetalle();
            $pptodet->presupuestoortodoncia_id = $ppto->id;            
            $pptodet->tarifario_id = $request->get('tarifario_id');
            $pptodet->moneda_id = 1;   
            $pptodet->empleado_id = $request->get('empleado_id');                     
            $pptodet->costo = $request->get('cuota_inicial');
            $pptodet->costo_base = $request->get('cuota_inicial_base');            
            $pptodet->tipoplan = 1;
            $pptodet->realizado = 0;
            $pptodet->descargado = 0;
            $pptodet->pagado = 0;
            $pptodet->tipo_pagado = 0; 
            $pptodet->adicional = 0;
            $pptodet->numero_cuota = 0;
            $pptodet->descripcion = "CUOTA INICIAL";
            $pptodet->user_id = $request->get('user_id');
            $pptodet->save();
            // Agregamos el detalle de las cuotas mensuales al presupuesto
            for ($i=1; $i <= $request->get('cuotas') ; $i++) { 
                $pptodet = new Presupuestoortodonciadetalle();
                $pptodet->presupuestoortodoncia_id = $ppto->id;                
                $pptodet->tarifario_id = $request->get('tarifario_id');
                $pptodet->moneda_id = 1;
                $pptodet->empleado_id = $request->get('empleado_id');
                $pptodet->costo = $request->get('control_mensual');
                $pptodet->costo_base = $request->get('control_mensual_base');
                $pptodet->tipoplan = 1;
                $pptodet->realizado = 0;
                $pptodet->descargado = 0;
                $pptodet->pagado = 0;
                $pptodet->tipo_pagado = 0;                 
                $pptodet->adicional = 0;
                $pptodet->numero_cuota = $i;
                $pptodet->descripcion = "CONTROL MENSUAL ".$i." de ".$request->get('cuotas');
                $pptodet->user_id = $request->get('user_id');
                $pptodet->save();
            }
            // Agregamos el detalle de los adicionales del presupuesto
            foreach ($request->get('detalle') as $det) {
                $rules2 = [ 'tarifario_id'      =>  'required',
                            'moneda_id'         =>  'required',
                            'empleado_id'       =>  'required',
                            'costo'             =>  'required',
                            'costo_base'        =>  'required',
                            'adicional'         =>  'required'
                          ]; 
                          
                $validator2 = Validator::make($det, $rules2);
                if ($validator2->fails()) {
                    DB::rollback();
                    return response()->json(['errors'=>$validator2->errors()]);
                } 

                $pptodet = new Presupuestoortodonciadetalle($det);
                $pptodet->presupuestoortodoncia_id = $ppto->id;
                $pptodet->save();
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
