<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Plane;

class PlaneController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $planes = Plane::orderBy('descripcion','ASC')->where('activo',true)->get();
        return $planes;   
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
          $rules = ['user_id'       =>  'required',
                    'descripcion'   =>  'required',
                    'ruc'           =>  'required'
                    ];
  
          $validator = Validator::make($request->all(), $rules);
          if ($validator->fails()) {
              return response()->json(['errors'=>$validator->errors()]);
          }
          /*-- validacion del Nombre de plan--*/
          if($request->get('descripcion')){
              $nom = Str::upper($request->get('descripcion'));         
              $nompla = Plane::where('descripcion',$nom)->count();
              if($nompla > 0){
                  return response()->json(['errors'=>['Nombre de Plan' => 'Ya existe un plan con estos datos']]);
              }
          }        
  
          $plan = new Plane($request->all());
          $plan->descripcion = Str::upper($plan->descripcion);
          $plan->abreviatura = Str::upper($plan->abreviatura);
          $plan->save();
  
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
            $rules = ['user_id'         =>  'required',
                      'descripcion'     =>  'required',
                      'ruc'             =>  'required'
                     ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $plan = Plane::find($id);
            $plan->fill($request->all());
            $plan->descripcion = Str::upper($plan->descripcion);
            $plan->abreviatura = Str::upper($plan->abreviatura);
            $plan->save();
  
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
            $plan = Plane::findOrFail($id);
            $plan->descripcion = $cargo->descripcion . ' *** ' . Carbon::now()->timestamp;            
            $plan->activo = false;
            $plan->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
