<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Laboratoriotrabajo;
use App\Liquidacionortodoncia;
use App\Liquidacionortodonciadetalle;
use App\Liquidacionortodonciatransaccione;
use App\Liquidacionortodonciafactura;
use App\Presupuestoortodonciadetalle;
use App\Transacciondoctor;
use App\Tipocambio;
use Globales;   // helpers

class LiquidacionortodonciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $liqortodoncias = Liquidacionortodoncia::with('empleado','sede','user.__empleado')->orderBy('id','ASC')->where('activo',true)->get();
        return $liqortodoncias;  
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
            $rules = ['empleado_id'             => 'required',
                      'sede_id'                 => 'required',
                      'monto_total_atenciones'  => 'required',
                      'monto_total_abonos'      => 'required',
                      'monto_total_descuentos'  => 'required',
                      'monto_total_liquidar'    => 'required',
                      'tipo'                    => 'required',
                      'moneda_id'               => 'required',
                      'user_id'                 => 'required'
                     ];

            if($request->has('fecha_corte')){
                $rules = array_add($rules, 'fecha_corte', 'date_format:d-m-Y H:i:s');
            }                     
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }       

            if(floatval($request->get('monto_total_liquidar')) > 700){
                $monto_total = floatval($request->get('monto_total_liquidar'));
                $detraccion = $monto_total * 0.12;
                $monto_liquidable = floatval($monto_total) - floatval($detraccion);
            }else{
                $monto_liquidable = 0;
                $detraccion = 0;
            }
    
            $liqort = new Liquidacionortodoncia($request->all());
            $liqort->fecha_corte = Globales::FormatFecYMD_hms($request->get('fecha_corte'));
            $liqort->monto_liquidable = $monto_liquidable;
            $liqort->detraccion = $detraccion;
            $liqort->save();
            // Agregamos el detalle de la liquidacion 
            foreach ($request->get('detalle') as $det) {

                $rules2 = [ 'presupuestoortodonciadetalle_id'  =>  'required']; 
                          
                $validator2 = Validator::make($det, $rules2);
                if ($validator2->fails()) {
                    DB::rollback();
                    return response()->json(['errors'=>$validator2->errors()]);
                } 

                $liqortdet = new Liquidacionortodonciadetalle($det);
                $liqortdet->liquidacionortodoncia_id = $liqort->id;
                $liqortdet->save();
                Presupuestoortodonciadetalle::where(['id' => $det['presupuestoortodonciadetalle_id'], 'activo' => true])->update(['liquidado' => 1]);            

            }
            foreach ($request->get('transacciones') as $tra) {

                $rules3 = [ 'id'  =>  'required']; 
                          
                $validator3 = Validator::make($tra, $rules3);
                if ($validator3->fails()) {
                    DB::rollback();
                    return response()->json(['errors'=>$validator3->errors()]);
                } 

                $liqorttra = new Liquidacionortodonciatransaccione();
                $liqorttra->liquidacionortodoncia_id = $liqort->id;
                $liqorttra->transacciondoctor_id = $tra['id'];
                $liqorttra->save();
                Transacciondoctor::where(['id' => $tra['id'], 'activo' => true])->update(['liquidado' => 1 , 'liquidacionortodoncia_id' => $liqort->id]);            

            }  
            // actualizar el estado de liquidado de presupuestodetalle 
            // actualizar el estado de liquidado de transacciones doctor
            // actualizar el estado de liquidacionoperatoria_id de transacciones doctor
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

    public function carga_liquidaciones_sede($sed,$fecini,$fecfin)
    {
        $fec_ini = Carbon::create(substr($fecini,4,4), substr($fecini,2,2),substr($fecini,0,2),0,0);
        $fec_fin = Carbon::create(substr($fecfin,4,4), substr($fecfin,2,2),substr($fecfin,0,2),23,59);
        $datos_liq = array();
        $liqort = Liquidacionortodoncia::where(['sede_id' => $sed , 'activo' => true])->whereDate('fecha_corte','>=',$fec_ini)->whereDate('fecha_corte','<=',$fec_fin)->orderBy('id','DESC')->get();
        
        if(!empty($liqort)){
            foreach ($liqort as $liq) {
                $moneda = 's/.';
                $tipo_cambio = TipoCambio::where('fecha_registro',date('Y-m-d'));
                $_monto_liquidar = floatval($liq->monto_total_liquidar);
                $_monto_liquidable = floatval($liq->monto_liquidable);
                $_detraccion = floatval($liq->detraccion);
                //$_monto_liquidar = number_format($_monto_liquidar,2);                  
                if($liq->moneda_id == 2){
                    $_monto_liquidar = floatval($liq->monto_total_liquidar) * $tipo_cambio;
                    //$_monto_liquidar = number_format($_monto_liquidar,2);                       
                }
                $nro_liq = "0000000000".$liq->id;
                $nro_liq = substr($nro_liq,-10);
                $item = array(
                    'id' => $liq->id,
                    'numero_liquidacion' => $nro_liq,
                    'fecha_liquidacion' => date('d-m-Y', strtotime($liq->fecha_corte)),
                    'fecha_cancelacion' => $liq->fecha_cancelacion == null ? null : date('d-m-Y', strtotime($liq->fecha_cancelacion)),
                    'sede' => $liq->sede->nombre_sede,
                    'empleado' => $liq->empleado->nombre_completo,
                    'usuario' => $liq->user->__empleado->nombre_completo,
                    'moneda' => $moneda,
                    'total' =>  $_monto_liquidar,
                    'monto_liquidable' => $_monto_liquidable,
                    'detraccion' => $_detraccion,
                    'estado' => $liq->pagado == 0 ? 'NO PAGADO': 'PAGADO',
                    'facturas' => $liq->liquidacionortodonciasfacturas
                );
                array_push($datos_liq,$item);                    
            }
        }
        return $datos_liq;        
    }
    public function facturarLiquidacion(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $rules = [ 'fecha_cancelacion'  => 'required',
                       'serie'              => 'required',
                       'numero'             => 'required',
                       'monto'              => 'required'              
                     ]; 
          
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                DB::rollback();
                return response()->json(['errors'=>$validator->errors()]);
            }    

            $liqort = Liquidacionortodoncia::findOrFail($id); 
            $liqort->pagado = 1;         
            $liqort->fecha_cancelacion =  Globales::FormatFecYMD_hms($request->get('fecha_cancelacion'));               
            $liqort->save();             

            $liqortfac = new Liquidacionortodonciafactura($request->all());
            $liqortfac->liquidacionortodoncia_id = $id; 
            $liqortfac->save();

            DB::commit();      
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }        
    }

}
