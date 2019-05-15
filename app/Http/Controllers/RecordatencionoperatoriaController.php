<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Recordatencionoperatoria;
use App\Presupuestooperatoriadetalle;
use App\Laboratoriotrabajo;
use Globales;   // helpers

class RecordatencionoperatoriaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $recoperatorias = Recordatencionoperatoria::with('empleado','laboratorio','material')->orderBy('id','DESC')->where('activo',true)->get();
        return $recoperatorias;  

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
            $rules = ['presupuestooperatoriadetalle_id' => 'required',
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
    
            $recope = new Recordatencionoperatoria($request->all());
            $recope->fecha_realizacion = Globales::FormatFecYMD_hms($request->get('fecha_realizacion'));            
            $recope->save();

            Presupuestooperatoriadetalle::where(['id' => $request->get('presupuestooperatoriadetalle_id'),'realizado' => 1])->update(['realizado' => 2]);

            if($request->filled('laboratorio_id')){

                $rules2 = [ 'presupuestooperatoriadetalle_id'   =>  'required',
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

                //Presupuestooperatoriadetalle::where(['id' => $request->get('presupuestooperatoriadetalle_id')])->update(['laboratorio_id' => $request->get('laboratorio_id'),'monto_lab' => $request->get('monto_lab')]);                
                $pptodet = Presupuestooperatoriadetalle::findOrFail($request->get('presupuestooperatoriadetalle_id'));
                $pptodet->laboratorio_id = $request->get('laboratorio_id');           
                $pptodet->monto_lab = $pptodet->monto_lab != null ? (floatval($pptodet->monto_lab) + floatval($request->get('monto_lab'))) : $request->get('monto_lab') ;
                $pptodet->user_id = $request->get('user_id');
                $pptodet->save();
            }

            if($request->filled('material_id')){
                Presupuestooperatoriadetalle::where(['id' => $request->get('presupuestooperatoriadetalle_id')])->update(['material_id' => $request->get('material_id'),'monto_mat' => $request->get('monto_mat')]);
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
            $pptodet = Presupuestooperatoriadetalle::findOrFail($id);         
            $pptodet->realizado = 3;
            $pptodet->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }        
    }    
}
