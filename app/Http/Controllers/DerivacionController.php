<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Derivacion;
use Globales;   // helpers

class DerivacionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $derivaciones = Derivacion::with('empleadoderivante','empleadoderivado','servicio')->orderBy('id','ASC')->where('activo',true)->get();
        return $derivaciones;  
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
            $rules = ['paciente_id'             => 'required',
                      'empleadoderivante_id'    => 'required',
                      'empleadoderivado_id'     => 'required',
                      'servicio_id'             => 'required',
                      'user_id'                 => 'required',
                      'fecha_registro'          => 'required|date_format:d-m-Y'
                      ];
  
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }      
            /*-- validacion de los medicos --*/
            if($request->get('empleadoderivante_id') == $request->get('empleadoderivado_id') ){
                return response()->json(['errors'=>['Medicos' => 'No se puede derivar al mismo Médico']]);
            }     
            $derivacion = new Derivacion($request->all());
            $derivacion->fecha_registro = Globales::FormatFecYMD($request->get('fecha_registro'));            
            $derivacion->save();
    
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
            $rules = ['paciente_id'             => 'required',
                      'empleadoderivante_id'    => 'required',
                      'empleadoderivado_id'     => 'required',
                      'servicio_id'             => 'required',
                      'user_id'                 => 'required',
                      'fecha_registro'          => 'required|date_format:d-m-Y'
                      ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $derivacion = Derivacion::find($id);
            $derivacion->fill($request->all());
            $derivacion->fecha_registro = Globales::FormatFecYMD($request->get('fecha_registro'));              
            $derivacion->save();
  
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
        //
    }
}
