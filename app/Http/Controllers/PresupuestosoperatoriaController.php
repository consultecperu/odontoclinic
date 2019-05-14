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
use App\TipoCambio;
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
        $pptosoperatorias = Presupuestooperatoria::with('paciente','paciente.pacienteplanes.plan','poliza.empresapaciente','plan','empleado','estadopresupuesto','tipocambio','presupuestosoperatoriasdetalles','presupuestosoperatoriasdetalles.diente','presupuestosoperatoriasdetalles.laboratorio','presupuestosoperatoriasdetalles.tarifario.servicio','presupuestosoperatoriasdetalles.tarifario.servicio.laboratorioservicios.laboratorio','presupuestosoperatoriasdetalles.material','presupuestosoperatoriasdetalles.tarifario.servicio.materialservicios.material','presupuestosoperatoriasdetalles.moneda','presupuestosoperatoriasdetalles.recordatencionoperatorias','presupuestosoperatoriasdetalles.recordatencionoperatorias.empleado','dientes')->orderBy('id','DESC')->where('activo',true)->get();
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
            //return;
            return response()->json(['idpresupuesto' => $ppto->id], 200);   
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

    public function deleteitem_masivo(Request $request, $id)
    {
        try {
            DB::beginTransaction();     
            foreach ($request->get('detalle') as $det) {
                $pptodet = Presupuestooperatoriadetalle::findOrFail($det);
                $pptodet->activo = false;
                $pptodet->user_id = $request->get('user_id');            
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

    public function descuento_masivo(Request $request, $id)
    {
        try {
            DB::beginTransaction();     
            foreach ($request->get('detalle') as $det) {
                $pptodet = Presupuestooperatoriadetalle::findOrFail($det['id']);
                $pptodet->costo = $det['costo'];
                $pptodet->descuento = floatval($pptodet->descuento) + floatval($det['descuento']);
                $pptodet->user_id = $request->get('user_id');            
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
            // verificando si el saldo cubre el pago de los tratamientos
            $saldo_total = floatval($ppto->saldo) + floatval($ppto->saldo_tarjeta);
            if(floatval($saldo_total) < floatval($TxPendiente)){
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
            $tarjeta_id = $ppto->tipopago_id;
            $valor_saldo_efectivo = $ppto->saldo;
            $valor_saldo_tarjeta = $ppto->saldo_tarjeta;
            foreach ($request->get('presupuestodetalles') as $det) {
                $pptodet = Presupuestooperatoriadetalle::findOrFail($det);
                if($pptodet->descargado == 0){
                    $pptodet->fecha_descarga = Globales::FormatFecYMD_hms($request->get('fecha_descarga'));
                    $pptodet->descargado = 1;
                    $pptodet->pagado = 1;
                    $pptodet->tipo_pagado = 2;
                    // rutina para aplicar el pago de los tratamientos con este descarga (con saldo)
                    if($valor_saldo_tarjeta > 0){
                        $pptodet->tipopago_id = $tarjeta_id;
                        if($valor_saldo_tarjeta >= $pptodet->costo){
                            $pptodet->monto_tarjeta = $pptodet->costo;
                            $pptodet->monto_efectivo = 0;
                            $valor_saldo_tarjeta = floatval($valor_saldo_tarjeta) - floatval($pptodet->costo);
                        }else{
                            $pptodet->monto_tarjeta = $valor_saldo_tarjeta;
                            $pptodet->monto_efectivo = floatval($pptodet->costo) - floatval($valor_saldo_tarjeta);
                            $valor_saldo_efectivo = floatval($valor_saldo_efectivo) - (floatval($pptodet->costo) - floatval($valor_saldo_tarjeta));
                            $valor_saldo_tarjeta = 0;
                        } 
                    }else{
                        if($valor_saldo_efectivo >= $pptodet->costo){
                            $pptodet->tipopago_id = 1;
                            $pptodet->monto_efectivo = $pptodet->costo;
                            $pptodet->monto_tarjeta = 0;
                            $valor_saldo_efectivo = floatval($valor_saldo_efectivo) - floatval($pptodet->costo);
                        }  
                    } 
                    $pptodet->save();
                }
            } 
            //$ppto->saldo = floatval($ppto->saldo) - floatval($TxPendiente);
            $ppto->saldo = floatval($valor_saldo_efectivo);
            $ppto->saldo_tarjeta = floatval($valor_saldo_tarjeta);
            $ppto->saldo_lab = floatval($ppto->saldo_lab) - floatval($valor_saldo_efectivo) - floatval($valor_saldo_tarjeta);
            $ppto->save();            
            DB::commit();                       
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }  
    } 
    
    public function liquidacion_doctor($emp,$sed,$fec)
    {
        $fec_cor = Carbon::create(substr($fec,4,4), substr($fec,2,2),substr($fec,0,2));
        // filtramos los presupuestosoperatoriasdetalle por medico , sede y por fecha y que no esten liquidados
        $datos_ppto = array();
        //$pptodet = Presupuestooperatoriadetalle::where(['empleado_id' => $emp , 'sede_id' => $sed , 'realizado' => 3,'descargado' => 1,'liquidado' => 0, 'activo' => true])->whereDate('fecha_descarga','<=',$fec);
        $pptodet = Presupuestooperatoriadetalle::where(['empleado_id' => $emp , 'realizado' => 3,'descargado' => 1,'liquidado' => 0, 'activo' => true])->whereDate('fecha_descarga','<=',$fec_cor)->get();
        //$pptodet = Presupuestooperatoriadetalle::where('activo',true)->get();
        //return $pptodet;
        
        if(!empty($pptodet)){
            foreach ($pptodet as $det) {
                // recorremos los seleccionados
                $moneda = 's/.';
                //$costo_total = floatval($det->monto_efectivo) + floatval($det->monto_tarjeta);
                $tipo_cambio = TipoCambio::where('fecha_registro',date('Y-m-d'));
                $monto_tarjeta = $det->monto_tarjeta == null ? 0.00 : floatval($det->monto_tarjeta);
                //$monto_tarjeta = number_format($monto_tarjeta,2);
                $monto_efectivo = $det->monto_efectivo == null ? 0.00 : floatval($det->monto_efectivo);
                //$monto_efectivo = number_format($monto_efectivo,2);
                $costo_total = (float)$monto_efectivo + (float)$monto_tarjeta;
                //$costo_total = number_format($costo_total,2);

                if($det->moneda_id == 2){
                    $costo_total = $costo_total * $tipo_cambio;
                    //$costo_total = number_format($costo_total,2);

                    $monto_tarjeta = floatval($monto_tarjeta) * $tipo_cambio;
                    //$monto_tarjeta = number_format($monto_tarjeta,2);

                    $monto_efectivo = floatval($monto_efectivo) * $tipo_cambio;
                    //$monto_efectivo = number_format($monto_efectivo,2);                    
                }

                if($det->material_id != null){
                    $devolucionMat = $det->material->devolucion;
                }else{
                    $devolucionMat = false;
                }

                if($det->monto_tarjeta != null && $det->monto_tarjeta != 0){
                    $comision_tarjeta = Globales::comision_tarjeta($det->monto_tarjeta,$det->tipopago->comision);
                }else{
                    $comision_tarjeta = 0;
                }
                if($det->caras != null){
                    $superf = strlen($det->caras) == 5 ? 'PZA.': $det->caras;
                }else{
                    $superf = '';
                }

                $sunat = Globales::comision_sunat($costo_total,18,$det->empleado->tipocontrato_id);
                $lab = $det->monto_lab == null ? 0 : $det->monto_lab;
                $matDoctor = $det->monto_mat == null ? 0 : $det->monto_mat;
                $matProveedor = 0.00;
                $comision = $det->empleado->porcentaje_interno;
                $descuentos = [$comision_tarjeta,$sunat,$lab,$matDoctor,$matProveedor];
                $tmpNeto = Globales::pago_doctor($costo_total, $comision , $descuentos, $matDoctor, $devolucionMat); 
                $neto = number_format($tmpNeto, 2, '.', '');
                $plan = 'PART.';

                $status = Globales::quitar_servicios_liquidacion($det->tarifario->servicio_id);
                if($status){
                    //dd($costo_total);
                    $servicio = array(
                        'paciente_id' => $det->presupuestooperatoria->paciente_id,
                        'presupuestooperatoriadetalle_id' => $det->id,
                        'presupuesto_id' => $det->presupuestooperatoria->id,
                        'paciente' => $det->presupuestooperatoria->paciente->nombre_completo,
                        'nombre_servicio' => $det->tarifario->servicio->nombre_servicio,
                        'pieza' =>  $det->diente_id == null ? '' : $det->diente->codigo,
                        'superficie' => $superf,
                        'fecha' => date('d-m-Y', strtotime($det->fecha_descarga)),
                        'costo' => $costo_total,
                        'monto_efectivo' => $det->monto_efectivo != null ? $det->monto_efectivo : 0.00,
                        'monto_tarjeta' => $det->monto_tarjeta != null ? $det->monto_tarjeta : 0.00,
                        'moneda' => $moneda,
                        'comision' => (int)$comision,
                        'plan' => $plan, //'PART',
                        'comision_tarjeta' => $comision_tarjeta,
                        'tipo_pago' => Globales::tipo_pago($det->monto_efectivo,$det->monto_tarjeta,$det->tipopago_id),    // entero
                        'type_cash' => Globales::type_cash($det->monto_efectivo,$det->monto_tarjeta,$det->tipopago_id),    // letras
                        'sunat' => $sunat,
                        'laboratorio' => $lab,
                        'material_doctor' => $matDoctor,
                        'material_proveedor' => 0.00,
                        'neto' => floatval($neto)
                    );
                    array_push($datos_ppto,$servicio);                    
                }
            }
        }

        return $datos_ppto;

    }
}
