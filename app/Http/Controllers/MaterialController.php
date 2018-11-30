<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Materiale;

class MaterialController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $materiales = Materiale::with('moneda')->orderBy('id','ASC')->where('activo',true)->get();
        return $materiales;  
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
            $rules =    ['nombre_material'      => 'required',
                        'devolucion'            => 'required',
                        'moneda_id'             => 'required',
                        'costo'                 => 'required',
                        'user_id'               => 'required'
                        ];
  
          $validator = Validator::make($request->all(), $rules);
          if ($validator->fails()) {
              return response()->json(['errors'=>$validator->errors()]);
          }
          /*-- validacion del Nombre de material--*/
          if($request->get('nombre_material')){
              $nom = $request->get('nombre_material');         
              $nommat = Materiale::where('nombre_material',$nom)->count();
              if($nommat > 0){
                  return response()->json(['errors'=>['Nombre de material ' => 'Ya existe un material con estos datos']]);
              }
          }        
  
          $material = new Materiale($request->all());
          $material->nombre_material = Str::upper($material->nombre_material);
          $material->save();
  
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
            $rules =    ['nombre_material'      => 'required',
                        'devolucion'            => 'required',
                        'moneda_id'             => 'required',
                        'costo'                 => 'required',
                        'user_id'               => 'required'
                        ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $material = Materiale::find($id);
            $material->fill($request->all());
            $material->nombre_material = Str::upper($material->nombre_material);
            $material->save();
  
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
            $material = Materiale::findOrFail($id);
            $material->nombre_material = $material->nombre_material . ' *** ' . Carbon::now()->timestamp;            
            $material->activo = false;
            $material->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
