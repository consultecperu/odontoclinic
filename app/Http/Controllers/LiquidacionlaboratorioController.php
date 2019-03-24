<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Laboratoriotrabajo;
use App\Liquidacionlaboratorio;
use App\Liquidacionlaboratoriodetalle;
use App\Liquidacionlaboratoriofactura;
use Globales;   // helpers

class LiquidacionlaboratorioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $liqlaboratorios = Liquidacionlaboratorio::with('laboratorio','liquidacionlaboratoriodetalles','liquidacionlaboratoriofacturas','sede','user.__empleado')->orderBy('id','ASC')->where('activo',true)->get();
        return $liqlaboratorios;  
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
            $rules = ['fecha_liquidacion'   => 'required',
                      'laboratorio_id'      => 'required',
                      'sede_id'             => 'required',
                      'moneda_id'           => 'required',
                      'user_id'             => 'required'
                      ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }        
    
            $liqlab = new Liquidacionlaboratorio($request->all());
            $liqlab->fecha_liquidacion =  Globales::FormatFecYMD_hms($request->get('fecha_liquidacion')); 
            $liqlab->save();

            foreach ($request->get('detalle') as $det) {
                $liqlabdet = new Liquidacionlaboratoriodetalle();
                $liqlabdet->liquidacionlaboratorio_id = $liqlab->id;
                $liqlabdet->laboratoriotrabajo_id = $det;
                $liqlabdet->user_id = $request->get('user_id');                      
                $liqlabdet->save(); 

                $labtra = Laboratoriotrabajo::findOrFail($det); 
                $labtra->seguimiento = 4;         
                $labtra->liquidado =  1;
                $labtra->fecha_liquidacion =  Globales::FormatFecYMD_hms($request->get('fecha_liquidacion'));                
                $labtra->save();                 
            } 
            $liqcod = Liquidacionlaboratorio::findOrFail($liqlab->id); 
            $liqcod->codigo = substr('0000000000'.$liqcod->id,-10);
            $liqcod->save();

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

            $liqlab = Liquidacionlaboratorio::findOrFail($id); 
            $liqlab->pagado = 1;         
            $liqlab->fecha_cancelacion =  Globales::FormatFecYMD_hms($request->get('fecha_cancelacion'));               
            $liqlab->save();             

            $liqlabfac = new Liquidacionlaboratoriofactura($request->all());
            $liqlabfac->liquidacionlaboratorio_id = $id; 
            $liqlabfac->save();

            DB::commit();      
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }        
    }
}
