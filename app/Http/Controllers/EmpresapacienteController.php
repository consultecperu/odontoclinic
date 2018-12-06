<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Empresapaciente;
use App\EmpresapacientePlane;

class EmpresapacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresapacientes = Empresapaciente::orderBy('id','ASC')->where('activo',true)->get();
        return $empresapacientes; 
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
            $rules = ['razon_social'    => 'required',
                      'ruc'             => 'required',
                      'user_id'         => 'required'
                    ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
            /*-- validacion de la Razon Social--*/
            if($request->get('razon_social')){
                $nom = Str::upper($request->get('razon_social'));         
                $nomemp = Empresapaciente::where('razon_social',$nom)->count();
                if($nomemp > 0){
                    return response()->json(['errors'=>['Nombre de Empresa' => 'Ya existe una empresa con estos datos']]);
                }
            }        
    
            $empresapaciente = new Empresapaciente($request->all());
            $empresapaciente->razon_social = Str::upper($empresapaciente->razon_social);
            $empresapaciente->save();
    
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
            $rules = ['razon_social'    => 'required',
                      'ruc'             => 'required',
                      'user_id'         => 'required'
                    ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $empresapaciente = Empresapaciente::find($id);
            $empresapaciente->fill($request->all());
            $empresapaciente->razon_social = Str::upper($empresapaciente->razon_social);
            $empresapaciente->save();
  
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
            $empresapaciente = Empresapaciente::findOrFail($id);
            $empresapaciente->razon_social = $empresapaciente->razon_social . ' *** ' . Carbon::now()->timestamp;            
            $empresapaciente->activo = false;
            $empresapaciente->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }

    public function listaaseguradoras($id){
        $empresapacienteplan = EmpresapacientePlane::with('plane')->where('empresapaciente_id',$id)->where('activo',true)->get();
        return $empresapacienteplan; 
    }

    public function addaseguradora(Request $request)
    {
        try {
            // agrega las aseguradoras
            $empresapacienteplan = new EmpresapacientePlane($request->all());
            $empresapacienteplan->save(); 
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }       
    }

    public function destroyaseguradora($id)
    {
        try {
            $empresapacienteplan = EmpresapacientePlane::findOrFail($id);
            $empresapacienteplan->activo = false;
            $empresapacienteplan->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }    
}
