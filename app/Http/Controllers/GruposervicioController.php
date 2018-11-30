<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Gruposervicio;

class GruposervicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $gruposervicios = Gruposervicio::orderBy('id','ASC')->where('activo',true)->get();
        return $gruposervicios;    
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
          $rules = ['nombre_gruposervicio' => 'required'];
  
          $validator = Validator::make($request->all(), $rules);
          if ($validator->fails()) {
              return response()->json(['errors'=>$validator->errors()]);
          }
          /*-- validacion del Nombre de grupo--*/
          if($request->get('nombre_gruposervicio')){
              $nom = Str::upper($request->get('nombre_gruposervicio'));         
              $nomgru = Gruposervicio::where('nombre_gruposervicio',$nom)->count();
              if($nomgru > 0){
                return response()->json(['errors'=>['Nombre de grupo de servicio' => 'Ya existe un grupo con estos datos']]);
              }
          }        
  
          $gruposervicio = new Gruposervicio($request->all());
          $gruposervicio->nombre_gruposervicio = Str::upper($gruposervicio->nombre_gruposervicio);
          $gruposervicio->save();
  
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
            $rules =    ['nombre_gruposervicio'     => 'required'];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $gruposervicio = Gruposervicio::find($id);
            $gruposervicio->fill($request->all());
            $gruposervicio->nombre_gruposervicio = Str::upper($gruposervicio->nombre_gruposervicio);
            $gruposervicio->save();
  
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
            $gruposervicio = Gruposervicio::findOrFail($id);
            $gruposervicio->activo = false;
            $gruposervicio->nombre_gruposervicio = $gruposervicio->nombre_gruposervicio . ' *** ' . Carbon::now()->timestamp;
            $gruposervicio->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
