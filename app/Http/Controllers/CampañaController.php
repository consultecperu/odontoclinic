<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Campaña;

class CampañaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $campañas = Campaña::with('empresapaciente')->orderBy('id','ASC')->where('activo',true)->get();
        return $campañas;  
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
            $rules = ['nombre_campania'     => 'required',
                      'lugar'               => 'required',
                      'user_id'             => 'required',
                      'vigencia'            => 'required',
                      'fecha_realizacion'   => 'required',
                      'fecha_vencimiento'   => 'required'
                    ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }      
    
            $campaña = new Campaña($request->all());
            $campaña->contacto = Str::upper($campaña->contacto);            
            $campaña->save();
    
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
            $rules = ['nombre_campania'     => 'required',
                      'lugar'               => 'required',
                      'user_id'             => 'required',
                      'vigencia'            => 'required',
                      'fecha_realizacion'   => 'required',
                      'fecha_vencimiento'   => 'required'
                    ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $campaña = Campaña::find($id);
            $campaña->fill($request->all());
            $campaña->contacto = Str::upper($campaña->contacto);
            $campaña->save();
  
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
            $campaña = Campaña::findOrFail($id);         
            $campaña->activo = false;
            $campaña->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
