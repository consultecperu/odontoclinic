<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Laboratorio;

class LaboratorioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $laboratorios = Laboratorio::orderBy('id','ASC')->where('activo',true)->get();
        return $laboratorios;   
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
          $rules = ['nombre_laboratorio' => 'required'];
  
          $validator = Validator::make($request->all(), $rules);
          if ($validator->fails()) {
              return response()->json(['errors'=>$validator->errors()]);
          }
          /*-- validacion del Nombre de laboratorio--*/
          if($request->get('nombre_laboratorio')){
              $nom = Str::upper($request->get('nombre_laboratorio'));         
              $nomlab = Laboratorio::where('nombre_laboratorio',$nom)->count();
              if($nomlab > 0){
                  return response()->json(['errors'=>['Nombre de laboratorio' => 'Ya existe un laboratorio con estos datos']]);
              }
          }        
  
          $laboratorio = new Laboratorio($request->all());
          $laboratorio->nombre_laboratorio = Str::upper($laboratorio->nombre_laboratorio);
          $laboratorio->save();
  
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
            $rules =    ['nombre_laboratorio'     => 'required'];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $laboratorio = Laboratorio::find($id);
            $laboratorio->fill($request->all());
            $laboratorio->nombre_laboratorio = Str::upper($laboratorio->nombre_laboratorio);
            $laboratorio->save();
  
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
            $laboratorio = Laboratorio::findOrFail($id);
            $laboratorio->nombre_laboratorio = $laboratorio->nombre_laboratorio . ' *** ' . Carbon::now()->timestamp;            
            $laboratorio->activo = false;
            $laboratorio->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
