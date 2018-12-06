<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Convenio;
use Globales;

class ConvenioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $convenios = Convenio::with('empresapaciente')->orderBy('id','ASC')->where('activo',true)->get();
        return $convenios;  
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
            $rules = ['empresapaciente_id'  => 'required',
                      'user_id'             => 'required',
                      'vigencia'            => 'required',
                      'fecha_inicio'        => 'required',
                      'fecha_finalizacion'  => 'required'
                    ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
            /*-- validacion de convenios con esta empresa--*/
            if($request->get('empresapaciente_id')){  
                $idemp = $request->get('empresapaciente_id');
                $conv = Convenio::where('empresapaciente_id',$idemp)->whereDate('fecha_finalizacion',">=",Carbon::today()->toDateString())->count();
                if($conv > 0){
                    return response()->json(['errors'=>['Convenios' => 'Existe algun convenio con esta empresa que aun esta activo ... no puede grabar mas convenios con esta empresa']]);
                }
            }        
    
            $convenio = new Convenio($request->all());
            $convenio->contacto = Str::upper($convenio->contacto);            
            $convenio->save();
    
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
            $rules = ['empresapaciente_id'  => 'required',
                      'user_id'             => 'required',
                      'vigencia'            => 'required',
                      'fecha_inicio'        => 'required',
                      'fecha_finalizacion'  => 'required'
                    ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $convenio = Convenio::find($id);
            $convenio->fill($request->all());
            $convenio->contacto = Str::upper($convenio->contacto);
            $convenio->save();
  
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
            $convenio = Convenio::findOrFail($id);         
            $convenio->activo = false;
            $convenio->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
