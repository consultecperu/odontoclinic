<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Sede;

class SedeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sedes = Sede::with('ubigeo')->orderBy('id','ASC')->where('activo',true)->get();
        return $sedes;  
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
            $rules =    ['nombre_sede'      => 'required',
                        'ubigeo_id'             => 'required',
                        'user_id'               => 'required'
                        ];
  
          $validator = Validator::make($request->all(), $rules);
          if ($validator->fails()) {
              return response()->json(['errors'=>$validator->errors()]);
          }
          /*-- validacion del Nombre de sede--*/
          if($request->get('nombre_sede')){
              $nom = $request->get('nombre_sede');         
              $nomsed = Sede::where('nombre_sede',$nom)->count();
              if($nomsed > 0){
                  return response()->json(['errors'=>['Nombre de sede ' => 'Ya existe una sede con estos datos']]);
              }
          }        
  
          $sede = new Sede($request->all());
          $sede->nombre_sede = Str::upper($sede->nombre_sede);
          $sede->save();
  
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
            $rules =    ['nombre_sede'      => 'required',
                        'ubigeo_id'             => 'required',
                        'user_id'               => 'required'
                        ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $sede = Sede::find($id);
            $sede->fill($request->all());
            $sede->nombre_sede = Str::upper($sede->nombre_sede);
            $sede->save();
  
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
            $sede = Sede::findOrFail($id);
            $sede->nombre_sede = $sede->nombre_sede . ' *** ' . Carbon::now()->timestamp;            
            $sede->activo = false;
            $sede->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
