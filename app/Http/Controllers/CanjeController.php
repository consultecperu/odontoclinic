<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Canje;

class CanjeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $canjes = Canje::orderBy('id','ASC')->where('activo',true)->get();
        return $canjes;    
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
            $rules = ['motivo_canje'        => 'required',
                      'genera_canje_a'      => 'required',
                      'tipo_canje'          => 'required',
                      'numero_certificado'  => 'required',
                      'otorgar_a'           => 'required',
                      'user_id'             => 'required'
                     ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
            /*-- validacion del numero de certificado--*/
            if($request->get('numero_certificado')){
                $num = $request->get('numero_certificado');         
                $numcan = Canje::where('numero_certificado',$num)->count();
                if($numcan > 0){
                    return response()->json(['errors'=>['Numero de Certificado' => 'Ya existe un certificado con estos datos']]);
                }
            }        
  
            $canje = new Canje($request->all());
            $canje->motivo_canje = Str::upper($canje->motivo_canje);
            $canje->save();
    
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
            $rules = ['motivo_canje'        => 'required',
                      'genera_canje_a'      => 'required',
                      'tipo_canje'          => 'required',
                      'numero_certificado'  => 'required',
                      'otorgar_a'           => 'required',
                      'user_id'             => 'required'
                     ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $canje = Canje::find($id);
            $canje->fill($request->all());
            $canje->motivo_canje = Str::upper($canje->motivo_canje);
            $canje->save();
    
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
            $canje = Canje::findOrFail($id);           
            $canje->activo = false;
            $canje->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }

    public function autorizarCanjes(Request $request, $id)
    {
        DB::beginTransaction(); 
        try {

            $canje = Canje::findOrFail($id);
            $canje->estado = 'autorizado';
            $canje->save();
    
            DB::commit();           
            return;
        } catch (Exception $e) {
            DB::rollback();          
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }

}
