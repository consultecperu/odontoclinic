<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Presupuestooperatoria;
use App\Presupuestooperatoriadetalle;
use Globales;   // helpers

class PresupuestosoperatoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pptosoperatorias = Presupuestooperatoria::with('paciente','empleado','estadopresupuesto','presupuestosoperatoriasdetalles','presupuestosoperatoriasdetalles.diente','presupuestosoperatoriasdetalles.tarifario.servicio','presupuestosoperatoriasdetalles.moneda','dientes')->orderBy('id','DESC')->where('activo',true)->get();
        return $pptosoperatorias;  
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
                      'plan_id'             => 'required',
                      'tipocambio_id'       => 'required',
                      'sede_id'             => 'required',
                      'user_id'             => 'required',
                      'pago_cliente'        => 'required',
                      'pago_aseguradora'    => 'required',
                      'pago_total'          => 'required'
                     ];

            if($request->has('fecha_registro')){
                $rules = array_add($rules, 'fecha_registro', 'date_format:d-m-Y');
            }                     
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }       
    
            $ppto = new Presupuestooperatoria($request->all());
            $ppto->fecha_registro = Globales::FormatFecYMD($request->get('fecha_registro'));
            $ppto->save();
            // Agregamos el detalle del presupuesto
            foreach ($request->get('detalle') as $det) {

                $rules2 = [ 'tarifario_id'      =>  'required',
                            'tarifa'            =>  'required',
                            'moneda_id'         =>  'required',
                            'empleado_id'       =>  'required',
                            'costo'             =>  'required',
                            'costo_base'        =>  'required',
                            'simbologia_id'     =>  'required'
                          ]; 
                          
                $validator2 = Validator::make($det, $rules2);
                if ($validator2->fails()) {
                    DB::rollback();
                    return response()->json(['errors'=>$validator2->errors()]);
                } 

                $pptodet = new Presupuestooperatoriadetalle($det);
                $pptodet->presupuestooperatoria_id = $ppto->id;
                $pptodet->save();
            }
            if($request->has('ausentes')){
                $ppto->dientes()->sync($request->get('ausentes'));
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
