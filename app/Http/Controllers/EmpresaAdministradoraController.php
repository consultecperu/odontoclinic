<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Empresaadministradora;

class EmpresaAdministradoraController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empresas = Empresaadministradora::with('ubigeo')->orderBy('id','ASC')->where('activo',true)->get();
        return $empresas; 
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
            $rules =    ['nombre_empresa'       => 'required',
                        'ruc'                   => 'required',
                        'representante_legal'   => 'required',
                        'ubigeo_id'             => 'required',
                        'user_id'               => 'required',
                        'telefono'              => 'required',
                        'celular'               => 'required'
                        ];
  
          $validator = Validator::make($request->all(), $rules);
          if ($validator->fails()) {
              return response()->json(['errors'=>$validator->errors()]);
          }
          /*-- validacion del Nombre de empresa--*/
          if($request->get('nombre_empresa')){
              $nom = $request->get('nombre_empresa');         
              $nomemp = Empresaadministradora::where('nombre_empresa',$nom)->count();
              if($nomemp > 0){
                  return response()->json(['errors'=>['Nombre de Empresa ' => 'Ya existe una empresa con estos datos']]);
              }
          }        
  
          $empresa = new Empresaadministradora($request->all());
          $empresa->nombre_empresa = Str::upper($empresa->nombre_empresa);
          $empresa->save();
  
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
            $rules =    ['nombre_empresa'      => 'required',
                        'ruc'                   => 'required',
                        'representante_legal'   => 'required',
                        'ubigeo_id'             => 'required',
                        'user_id'               => 'required'
                        ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $empresa = Empresaadministradora::find($id);
            $empresa->fill($request->all());
            $empresa->nombre_empresa = Str::upper($empresa->nombre_empresa);
            $empresa->save();
  
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
            $empresa = Empresaadministradora::findOrFail($id);
            $empresa->nombre_empresa = $empresa->nombre_empresa . ' *** ' . Carbon::now()->timestamp;            
            $empresa->activo = false;
            $empresa->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}
