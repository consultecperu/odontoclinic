<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Laboratoriotrabajo;
use App\Presupuestoperatoria;
use App\Presupuestooperatoriadetalle;
use App\Presupuestoortodoncia;
use App\Presupuestoortodonciadetalle;
use Globales;   // helpers

class LaboratoriotrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labtrabajos = Laboratoriotrabajo::with('laboratorioservicio','presupuestooperatoriadetalle','presupuestooperatoriadetalle.presupuestooperatoria.paciente','servicio','empleado')->orderBy('id','ASC')->where('activo',true)->get();
        return $labtrabajos;  
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
        //
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
    public function envioTrabajo(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $rules = [ 'fecha_envio'   =>  'required',
                       'fecha_entrega'  => 'required'
                    ]; 
          
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                DB::rollback();
                return response()->json(['errors'=>$validator->errors()]);
            }    

            foreach ($request->get('detalle') as $det) {
                // validando si hay saldo
                $labtra = Laboratoriotrabajo::findOrFail($det); 
                if($labtra->presupuestooperatoriadetalle_id != null){
                    $pptodet_ope = Presupuestooperatoriadetalle::with('presupuestooperatoria')->findOrFail($labtra->presupuestooperatoriadetalle_id);
                } elseif($labtra->presupuestoortodonciadetalle_id != null){
                    $pptodet_ort = Presupuestoortodonciadetalle::with('presupuestoortodoncia')->findOrFail($labtra->presupuestoortodonciadetalle_id);
                }
                // preguntar si el monto es menor igual saldo_lab
                // si es mayor - igual descontar del saldo_lab
                $labtra->seguimiento = 2;         
                $labtra->fecha_envio =  Globales::FormatFecYMD_hms($request->get('fecha_envio'));
                $labtra->fecha_entrega =  Globales::FormatFecYMD_hms($request->get('fecha_entrega'));                
                $labtra->save(); 
            }
            DB::commit();      
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }        
    } 
    public function recibirTrabajo(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $rules = [ 'fecha_recepcion'   =>  'required']; 
          
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                DB::rollback();
                return response()->json(['errors'=>$validator->errors()]);
            }    

            foreach ($request->get('detalle') as $det) {
                $labtra = Laboratoriotrabajo::findOrFail($det); 
                $labtra->seguimiento = 3;         
                $labtra->fecha_recepcion =  Globales::FormatFecYMD_hms($request->get('fecha_recepcion'));               
                $labtra->save(); 
            }
            DB::commit();      
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }        
    }    

}
