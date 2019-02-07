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
}
