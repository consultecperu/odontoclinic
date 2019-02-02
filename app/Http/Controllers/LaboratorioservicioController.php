<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Laboratorioservicio;

class LaboratorioservicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labservicios = Laboratorioservicio::with('moneda','laboratorio','servicios')->orderBy('id','ASC')->where('activo',true)->get();
        return $labservicios;   
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

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
            $rules = ['laboratorio_id'  => 'required',
                      'moneda_id'       => 'required',
                      'user_id'         => 'required'
                      ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
            /*-- validacion del Nombre de servicio--*/
            if($request->get('nombre_servicio')){
                $nom = Str::upper($request->get('nombre_servicio'));         
                $nomser = Laboratorioservicio::where('nombre_servicio',$nom)->count();
                if($nomser > 0){
                    return response()->json(['errors'=>['Nombre de servicio' => 'Ya existe un servicio con estos datos']]);
                }
            }        
    
            $labservicio = new Laboratorioservicio($request->all());
            $labservicio->nombre_servicio = Str::upper($labservicio->nombre_servicio);
            $labservicio->save();
    
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
            $rules = ['laboratorio_id'  => 'required',
                      'moneda_id'       => 'required',
                      'user_id'         => 'required'
                      ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $labservicio = Laboratorioservicio::find($id);
            $labservicio->fill($request->all());
            $labservicio->nombre_servicio = Str::upper($labservicio->nombre_servicio);
            $labservicio->save();
  
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
            $labservicio = Laboratorioservicio::findOrFail($id);
            $labservicio->nombre_servicio = $labservicio->nombre_servicio . ' *** ' . Carbon::now()->timestamp;            
            $labservicio->activo = false;
            $labservicio->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }

    public function AgregarServicioMultident(Request $request, $id)
    {
        $labservicio = Laboratorioservicio::find($id);
        // agrega los servicios 
        $labservicio->servicios()->attach($request->get('servicio_id'), ['user_id' => $request->get('user_id')]);     
    } 
    public function EliminarServicioMultident(Request $request, $id)
    {
        $labservicio = Laboratorioservicio::find($id);
        // elimina los servicios 
        $labservicio->servicios()->detach($request->get('servicio_id'));     
    }         
}
