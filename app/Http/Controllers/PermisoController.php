<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use Globales;
use App\Permiso;

class PermisoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $permisos = Permiso::with('sede','empleado','_horaini','_horafin')->orderBy('id','ASC')->where('activo',true)->get();
        return $permisos; 
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
            $rules = [  'empleado_id'   => 'required',
                        'sede_id'       => 'required',
                        'tipopermiso'   => 'required',
                        'user_id'       => 'required'
                        ];

            if($request->get('tipopermiso') == 1){  //por dias
                $rules = array_add($rules, 'fecha_inicio', 'required|date_format:d-m-Y');
                $rules = array_add($rules, 'fecha_fin', 'required|date_format:d-m-Y');
            }else{                                  // por horas
                $rules = array_add($rules, 'fecha_inicio', 'required|date_format:d-m-Y');
                $rules = array_add($rules, 'horaini', 'required');
                $rules = array_add($rules, 'horafin', 'required');
            }                       
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }      
    
            $permiso = new Permiso($request->all());
            if($request->has('fecha_inicio')){
                $permiso->fecha_inicio = Globales::FormatFecYMD($request->get('fecha_inicio'));   
            }
            if($request->has('fecha_fin')){
                $permiso->fecha_fin = Globales::FormatFecYMD($request->get('fecha_fin'));   
            }         
            $permiso->save();
    
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
        DB::beginTransaction(); 

        try {
            $rules = [  'empleado_id'   => 'required',
                        'sede_id'       => 'required',
                        'tipopermiso'   => 'required',
                        'user_id'       => 'required'
                        ];

            if($request->get('tipopermiso') == 1){  //por dias
                $rules = array_add($rules, 'fecha_inicio', 'required|date_format:d-m-Y');
                $rules = array_add($rules, 'fecha_fin', 'required|date_format:d-m-Y');
            }else{                                  // por horas
                $rules = array_add($rules, 'fecha_inicio', 'required|date_format:d-m-Y');
                $rules = array_add($rules, 'horaini', 'required');
                $rules = array_add($rules, 'horafin', 'required');
            }                       
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            } 

            $permiso = Permiso::find($id);
            $permiso->fill($request->all());
            if($request->has('fecha_inicio')){
                $permiso->fecha_inicio = Globales::FormatFecYMD($request->get('fecha_inicio'));   
            }
            if($request->has('fecha_fin')){
                $permiso->fecha_fin = Globales::FormatFecYMD($request->get('fecha_fin'));   
            }              
            $permiso->save();
  
            DB::commit();           
            return;
        } catch (Exception $e) {
            DB::rollback();          
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }

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
            $permiso = Permiso::findOrFail($id);       
            $permiso->activo = false;
            $permiso->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
