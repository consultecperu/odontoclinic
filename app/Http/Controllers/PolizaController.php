<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Poliza;
use App\Planpoliza;

class PolizaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $polizas = Poliza::with('moneda','planpoliza')->orderBy('id','ASC')->where('activo',true)->get();
        return $polizas;   
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
                $rules = ['codigo'                => 'required',
                            'vigencia_del'          => 'required',
                            'vigencia_al'           => 'required',
                            'moneda_id'             => 'required',
                            'deducible'             => 'required',
                            'coaseguro'             => 'required',
                            'user_id'               => 'required',
                            'plane_id'              => 'required',
                            'planpoliza_id'         => 'required',
                            'empresapaciente_id'    => 'required'
                            ];
        
                $validator = Validator::make($request->all(), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors'=>$validator->errors()]);
                }
                /*-- validacion del poliza--*/        
                $pol = Poliza::where('plane_id',$request->get('plane_id'))->where('planpoliza_id',$request->get('planpoliza_id'))->where('empresapaciente_id',$request->get('empresapaciente_id'))->where('codigo',$request->get('codigo'))->count();
                if($pol > 0){
                    return response()->json(['errors'=>['Datos de Poliza' => 'Ya existe una poliza con estos datos']]);
                }    
                $poliza = new Poliza($request->all());
                $poliza->save();
        
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

    public function showpoliza($empid,$plaid)
    {
        $polizas = Poliza::orderBy('id','ASC')->where('empresapaciente_id',$empid)->where('plane_id',$plaid)->where('activo',true)->get();
        return $polizas;         
    }

    public function cargaplanpolizas()
    {
        $planpolizas = Planpoliza::orderBy('id','ASC')->where('activo',true)->get();
        return $planpolizas;          
    }
}
