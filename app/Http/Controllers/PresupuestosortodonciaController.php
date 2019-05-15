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
use App\TipoCambio;
use App\Tarifario;
use App\Materialservicio;
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
        $pptosortodoncias = Presupuestoortodoncia::with('paciente','paciente.pacienteplanes.plan','plan','empleado','estadopresupuesto','tipocambio','presupuestosortodonciasdetalles','presupuestosortodonciasdetalles.tarifario.servicio','presupuestosortodonciasdetalles.tarifario.servicio.laboratorioservicios.laboratorio','presupuestosortodonciasdetalles.material','presupuestosortodonciasdetalles.tarifario.servicio.materialservicios.material','presupuestosortodonciasdetalles.moneda','presupuestosortodonciasdetalles.recordatencionortodoncias','tarifario.servicio')->orderBy('id','DESC')->where('activo',true)->get();
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
            // sacamos el valor del material si es que lo hay en el tratamiento
            $tipo_cambio = TipoCambio::where('fecha_registro',date('Y-m-d'))->first();
            $_tarifa = Tarifario::findOrFail($request->get('tarifario_id')); 
            $_material = Materialservicio::with('material')->where(['servicio_id' => $_tarifa->servicio_id , 'activo' => true])->first();

            if(!empty($_material)){
                $_costo_mat = $_material->material->costo;
                $_id_mat = $_material->material_id;
                if($_material->material->moneda_id == 2){
                    $_costo_mat = floatval($_costo_mat) * floatval($tipo_cambio->tipo_cambio);
                }
                $_costo_mat = number_format($_costo_mat,2);
            }
            // Agregamos el detalle de la cuota inicial al presupuesto
            $pptodet = new Presupuestoortodonciadetalle();
            $pptodet->presupuestoortodoncia_id = $ppto->id;            
            $pptodet->tarifario_id = $request->get('tarifario_id');
            $pptodet->moneda_id = 1;   
            $pptodet->empleado_id = $request->get('empleado_id');                     
            $pptodet->costo = $request->get('cuota_inicial');
            $pptodet->costo_base = $request->get('cuota_inicial_base');            
            $pptodet->tipoplan = 1;
            $pptodet->realizado = 1;
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
                $pptodet->realizado = 1;
                $pptodet->descargado = 0;
                $pptodet->pagado = 0;
                $pptodet->tipo_pagado = 0;                 
                $pptodet->adicional = 0;
                $pptodet->numero_cuota = $i;
                $pptodet->descripcion = "CONTROL MENSUAL ".$i." de ".$request->get('cuotas');
                $pptodet->user_id = $request->get('user_id');
                if(!empty($_material)){
                    if($_costo_mat > 0){
                        $pptodet->material_id = $_id_mat;
                        if(floatval($_costo_mat) > floatval($request->get('control_mensual'))){
                            $pptodet->monto_mat = floatval($request->get('control_mensual'));
                            $pptodet->monto_mat = number_format($pptodet->monto_mat,2);
                            $_costo_mat -= floatval($request->get('control_mensual'));
                        }else{
                            $pptodet->monto_mat = floatval($_costo_mat);
                            $pptodet->monto_mat = number_format($pptodet->monto_mat,2);
                            $_costo_mat = 0.00;                        
                        }
                    }
                }
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
            $ppto = Presupuestoortodoncia::findOrFail($id);          
            $ppto->activo = false;
            $ppto->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }

    public function cambioEstado(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            $ppto = Presupuestoortodoncia::findOrFail($id);          
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
                $pptodet = Presupuestoortodonciadetalle::findOrFail($det);
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
                $pptodet = Presupuestoortodonciadetalle::findOrFail($det);
                if($pptodet->descargado == 0){
                    $TxPendiente += floatval($pptodet->costo);
                }
            }
            $ppto = Presupuestoortodoncia::findOrFail($id);  
            if(floatval($ppto->saldo) < floatval($TxPendiente)){
                return response()->json(['errors'=>['Saldo' => 'El Saldo no cubre el pago de los tratamientos seleccionados']]);
            }
            //validando tratamientos si estan terminados  
            $sinTerminar = 0;
            foreach ($request->get('presupuestodetalles') as $det) {
                $pptodet = Presupuestoortodonciadetalle::findOrFail($det);
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
                $pptodet = Presupuestoortodonciadetalle::findOrFail($det);
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
    
    public function addAdicionales(Request $request, $id)
    {
        try {
            DB::beginTransaction();
            foreach ($request->get('items') as $det) {
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
                $pptodet->presupuestoortodoncia_id = $id;
                $pptodet->save();
            }  

            $ppto = Presupuestoortodoncia::findOrFail($id);
            $ppto->total_soles = floatval($ppto->total_soles) + floatval($request->get('total_soles'));
            $ppto->total_dolares = floatval($ppto->total_dolares) + floatval($request->get('total_dolares'));
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

    public function liquidacion_doctor($emp,$sed,$fec)
    {
        $fec_cor = Carbon::create(substr($fec,4,4), substr($fec,2,2),substr($fec,0,2));
        // filtramos los presupuestosoperatoriasdetalle por medico , sede y por fecha y que no esten liquidados
        $datos_ppto = array();
        //$pptodet = Presupuestooperatoriadetalle::where(['empleado_id' => $emp , 'sede_id' => $sed , 'realizado' => 3,'descargado' => 1,'liquidado' => 0, 'activo' => true])->whereDate('fecha_descarga','<=',$fec);
        $pptodet = Presupuestoortodonciadetalle::where(['empleado_id' => $emp , 'realizado' => 3,'descargado' => 1,'liquidado' => 0, 'activo' => true])->whereDate('fecha_descarga','<=',$fec_cor)->get();
        //$pptodet = Presupuestooperatoriadetalle::where('activo',true)->get();
        //return $pptodet;
        
        if(!empty($pptodet)){
            foreach ($pptodet as $det) {
                // recorremos los seleccionados
                $moneda = 's/.';
                //$costo_total = floatval($det->monto_efectivo) + floatval($det->monto_tarjeta);
                $tipo_cambio = TipoCambio::where('fecha_registro',date('Y-m-d'));
                $monto_tarjeta = $det->monto_tarjeta == null ? 0 : floatval($det->monto_tarjeta);
                //$monto_tarjeta = number_format($monto_tarjeta,2);
                $monto_efectivo = $det->monto_efectivo == null ? 0 : floatval($det->monto_efectivo);
                //$monto_efectivo = number_format($monto_efectivo);
                $costo_total = floatval($monto_tarjeta) + floatval($monto_efectivo);
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
/*                 if($det->caras != null){
                    $superf = strlen($det->caras) == 5 ? 'PZA.': $det->caras;
                }else{
                    $superf = '';
                } */

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
                    $servicio = array(
                        'paciente_id' => $det->presupuestoortodoncia->paciente_id,
                        'presupuestoortodonciadetalle_id' => $det->id,
                        'presupuesto_id' => $det->presupuestoortodoncia->id,
                        'paciente' => $det->presupuestoortodoncia->paciente->nombre_completo,
                        'nombre_servicio' => $det->descripcion,
                        //'pieza' =>  $det->diente_id == null ? '' : $det->diente->codigo,
                        //'superficie' => $superf,
                        'fecha' => date('d-m-Y', strtotime($det->fecha_descarga)),
                        'costo' => floatval($costo_total),
                        'monto_efectivo' => $det->monto_efectivo != null ? $det->monto_efectivo : 0.00,
                        'monto_tarjeta' => $det->monto_tarjeta != null ? $det->monto_tarjeta : 0.00,
                        'moneda' => $moneda,
                        'comision' => (int)$comision,
                        'plan' => $plan, //'PART',
                        'comision_tarjeta' => $comision_tarjeta,
                        'tipo_pago' => Globales::tipo_pago($det->monto_efectivo,$det->monto_tarjeta,$det->tipopago_id),
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
