<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Recordatencionortodoncia;
use App\Presupuestoortodonciadetalle;
use Globales;   // helpers

class RecordatencionortodonciaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recortodoncias = Recordatencionortodoncia::with('empleado','laboratorio','material')->orderBy('id','DESC')->where('activo',true)->get();
        return $recortodoncias;  
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
            $rules = ['presupuestoortodonciadetalle_id' => 'required',
                      'descripcion'                     => 'required',
                      'empleado_id'                     => 'required',
                      'user_id'                         => 'required'    
                    ];

            if($request->has('fecha_realizacion')){
                $rules = array_add($rules, 'fecha_realizacion', 'date_format:d-m-Y H:i:s');
            }                    
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }    
    
            $recorto = new Recordatencionortodoncia($request->all());
            $recorto->fecha_realizacion = Globales::FormatFecYMD_hms($request->get('fecha_realizacion'));            
            $recorto->save();

            Presupuestoortodonciadetalle::where(['id' => $request->get('presupuestoortodonciadetalle_id'),'realizado' => 1])->update(['realizado' => 2]);
            
            if($request->filled('laboratorio_id')){

                $rules2 = [ 'presupuestoortodonciadetalle_id'   =>  'required',
                            'servicio_id'                       =>  'required',
                            'empleado_id'                       =>  'required',
                            'sede_id'                           =>  'required',
                            'laboratorioservicio_id'            =>  'required',
                            'user_id'                           =>  'required',
                            'fecha_separacion'                  =>  'required'
                          ]; 
                          
                $validator2 = Validator::make($request->all(), $rules2);
                if ($validator2->fails()) {
                    DB::rollback();
                    return response()->json(['errors'=>$validator2->errors()]);
                }  
                $labtra = new Laboratoriotrabajo($request->all());
                $labtra->fecha_separacion = Globales::FormatFecYMD_hms($request->get('fecha_separacion'));            
                $labtra->save();                

                Presupuestoortodonciadetalle::where(['id' => $request->get('presupuestoortodonciadetalle_id')])->update(['laboratorio_id' => $request->get('laboratorio_id'),'monto_lab' => $request->get('monto_lab')]);
            }

            if($request->filled('material_id')){
                Presupuestoortodonciadetalle::where(['id' => $request->get('presupuestoortodonciadetalle_id')])->update(['material_id' => $request->get('material_id'),'monto_mat' => $request->get('monto_mat')]);
            }            
    
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
        //
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
    public function finalizaTratamiento(Request $request, $id)
    {
        try {
            $pptodet = Presupuestoortodonciadetalle::findOrFail($id);         
            $pptodet->realizado = 3;
            $pptodet->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }        
    }     
}
