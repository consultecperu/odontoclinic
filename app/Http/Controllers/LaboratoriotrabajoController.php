<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Laboratoriotrabajo;
use Globales;   // helpers

class LaboratoriotrabajoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $labtrabajos = Laboratoriotrabajo::with('laboratorioservicio','presupuestooperatoriadetalle','presupuestooperatoriadetalle.presupuestooperatoria.paciente','servicio','empleado')->orderBy('id','ASC')->where('activo',true)->get();
        return $labtrabajos;  
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
        //
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
    public function envioTrabajo(Request $request, $id)
    {
        try {
            DB::beginTransaction();

            $rules = [ 'fecha_envio'   =>  'required']; 
          
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                DB::rollback();
                return response()->json(['errors'=>$validator->errors()]);
            }    

            foreach ($request->get('detalle') as $det) {
                $labtra = Laboratoriotrabajo::findOrFail($det); 
                $labtra->seguimiento = 2;         
                $labtra->fecha_envio =  Globales::FormatFecYMD_hms($request->get('fecha_envio'));
                $labtra->save(); 
            }
            DB::commit();      
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }        
    }    
}
