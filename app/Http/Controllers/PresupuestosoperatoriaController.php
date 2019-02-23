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
        $pptosoperatorias = Presupuestooperatoria::with('paciente','paciente.pacienteplanes.plan','empleado','estadopresupuesto','tipocambio','presupuestosoperatoriasdetalles','presupuestosoperatoriasdetalles.diente','presupuestosoperatoriasdetalles.tarifario.servicio','presupuestosoperatoriasdetalles.moneda','presupuestosoperatoriasdetalles.recordatencionoperatorias','presupuestosoperatoriasdetalles.recordatencionoperatorias.empleado','dientes')->orderBy('id','DESC')->where('activo',true)->get();
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
        try {
            $ppto = Presupuestooperatoria::findOrFail($id);          
            $ppto->activo = false;
            $ppto->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }

    public function deleteitem(Request $request, $id)
    {
        try {
            DB::beginTransaction();             
            $pptodet = Presupuestooperatoriadetalle::findOrFail($request->get('idDetalle'));
            $pptodet->activo = false;
            $pptodet->user_id = $request->get('user_id');            
            $pptodet->save();

            $ppto = Presupuestooperatoria::findOrFail($id);
            $valor_total = Presupuestooperatoriadetalle::where(['activo' => true ,'presupuestooperatoria_id' => $id])->sum('costo');            
            $ppto->pago_cliente = $valor_total;            
            $ppto->pago_total = $valor_total;
            $ppto->user_id = $request->get('user_id');
            $ppto->save();             
            DB::commit();  
            return;  
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    } 
    
    public function additem(Request $request, $id)
    {
        try {
            DB::beginTransaction();             
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
                $pptodet->presupuestooperatoria_id = $id;
                $pptodet->save();
            }
            $ppto = Presupuestooperatoria::findOrFail($id);
            $valor_total = Presupuestooperatoriadetalle::where(['activo' => true ,'presupuestooperatoria_id' => $id])->sum('costo');            
            $ppto->pago_cliente = $valor_total;            
            $ppto->pago_total = $valor_total;
            $ppto->user_id = $request->get('user_id');
            $ppto->save();             
            DB::commit();  
            return;  
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    } 
    
    public function deleteTratamientosDiente(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            Presupuestooperatoriadetalle::where(['presupuestooperatoria_id' => $id, 'diente_id' => $request->get('diente_id')])->update(['activo' => false]);

            $ppto = Presupuestooperatoria::findOrFail($id);
            $valor_total = Presupuestooperatoriadetalle::where(['activo' => true ,'presupuestooperatoria_id' => $id])->sum('costo');            
            $ppto->pago_cliente = $valor_total;            
            $ppto->pago_total = $valor_total;
            $ppto->user_id = $request->get('user_id');

            DB::commit(); 
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }

    public function estadoDientesAusentes(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $ppto = Presupuestooperatoria::find($id);
            if (empty($request->get('ausentes'))) {
                $ppto->dientes()->detach();
            } else {
                $ppto->dientes()->sync($request->get('ausentes'));
            }
            DB::commit(); 
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }

    public function textoSuperiorDiente(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            Presupuestooperatoriadetalle::where(['presupuestooperatoria_id' => $id, 'diente_id' => $request->get('diente_id')])->update(['texto_diente' => $request->get('texto_diente')]);
            DB::commit(); 
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
    public function cambioEstado(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $ppto = Presupuestooperatoria::findOrFail($id);          
            $ppto->estadopresupuesto_id = $request->get('estadopresupuesto_id');
            $ppto->save(); 
            DB::commit();      
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
    public function descargaTx(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            foreach ($request->get('presupuestodetalles') as $det) {
                $pptodet = Presupuestooperatoriadetalle::findOrFail($det);
                if($pptodet->descargado == 0){
                    $pptodet->descargado = 1;
                    $pptodet->fecha_descarga = Globales::FormatFecYMD_hms($request->get('fecha_descarga'));
                    $pptodet->save();
                }
            } 
            DB::commit();      
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }        
    }
    public function descargaSaldo(Request $request, $id)
    {
        try {
            $TxPendiente = 0;
            foreach ($request->get('presupuestodetalles') as $det) {
                $pptodet = Presupuestooperatoriadetalle::findOrFail($det);
                if($pptodet->descargado == 0){
                    $TxPendiente += floatval($pptodet->costo);
                }
            }
            $ppto = Presupuestooperatoria::findOrFail($id);  
            if(floatval($ppto->saldo) < floatval($TxPendiente)){
                return response()->json(['errors'=>['Saldo' => 'El Saldo no cubre el pago de los tratamientos seleccionados']]);
            }
            //validando tratamientos si estan terminados  
            $sinTerminar = 0;
            foreach ($request->get('presupuestodetalles') as $det) {
                $pptodet = Presupuestooperatoriadetalle::findOrFail($det);
                if($pptodet->realizado <> 3){
                    $sinTerminar = 1;
                }
            }            
            if($sinTerminar == 1){
                return response()->json(['errors'=>['Terminados' => 'Algunos registros no estan terminados ... verifique por favor']]);
            }
            DB::beginTransaction();
            $descargado = 0;
            foreach ($request->get('presupuestodetalles') as $det) {
                $pptodet = Presupuestooperatoriadetalle::findOrFail($det);
                if($pptodet->descargado == 0){
                    $pptodet->fecha_descarga = Globales::FormatFecYMD_hms($request->get('fecha_descarga'));
                    $pptodet->descargado = 1;
                    $pptodet->pagado = 1;
                    $pptodet->tipo_pagado = 2;
                    $pptodet->save();
                }
            } 
            $ppto->saldo = floatval($ppto->saldo) - floatval($TxPendiente);
            $ppto->save();            
            DB::commit();                       
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }  
    }    
}
