<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\TipoCambio;
use Globales;

class TipocambioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipocambios = TipoCambio::with('monedade','monedaa')->orderBy('fecha_registro','DESC')->where('activo',true)->get();
        return $tipocambios;  
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
            $rules = ['valor_compra'    => 'required',
                      'valor_venta'     => 'required',
                      'monedade_id'     => 'required',
                      'monedaa_id'      => 'required',
                      'tipo_cambio'     => 'required'
                      ];

            if($request->has('fecha_registro')){
                $rules = array_add($rules, 'fecha_registro', 'date_format:d-m-Y');
            }    
            
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
            /*-- validacion del Nombre de empleado--*/
            if($request->get('fecha_registro')){       
                $fec = TipoCambio::where('fecha_registro',Globales::FormatFecYMD($request->get('fecha_registro')))->count();
                if($fec > 0){
                    return response()->json(['errors'=>['Fecha de Registro' => 'Ya existe un tipo de cambio para la fecha de hoy']]);
                }
            }        
    
            $tipocambio = new TipoCambio($request->all());
            $tipocambio->fecha_registro = Globales::FormatFecYMD($request->get('fecha_registro'));
            $tipocambio->save();
    
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

    public function addMensual(Request $request)
    {
        $dias = cal_days_in_month(CAL_GREGORIAN, $request->get('mes'), $request->get('anio'));

        DB::beginTransaction();    
        try {
            $rules = ['valor_compra'    => 'required',
                      'valor_venta'     => 'required',
                      'monedade_id'     => 'required',
                      'monedaa_id'      => 'required',
                      'tipo_cambio'     => 'required',
                      'mes'             => 'required',
                      'anio'            => 'required'
                      ];  
            
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
       
            $dt = Carbon::createFromDate($request->get('anio'), $request->get('mes'), 1);
            for ($i=1; $i <= $dias ; $i++) {                 
                /*-- validacion de la fecha de registro --*/     
                $fec = TipoCambio::where(['fecha_registro' => $dt, 'activo' => true])->count();
                if($fec > 0){
                    //return response()->json(['errors'=>['Fecha de Registro' => 'Ya existe un tipo de cambio para la fecha de hoy']]);
                    $tc = TipoCambio::where(['fecha_registro' => $dt, 'activo' => true])->first();
                    TipoCambio::where('id',$tc->id)->update(['activo' => false]);

                }             
                $tipocambio = new TipoCambio($request->all());
                $tipocambio->fecha_registro = $dt;
                $tipocambio->save();  
                $dt->addDay();                             
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
}
