<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Turno;

class TurnoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $turnos = Turno::with('sede','dia','horaini1','horafin1','horaini2','horafin2')->orderBy('id','ASC')->where('activo',true)->get();
        return $turnos;
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
            $rules = ['empleado_id'   => 'required',
                        'dia_id'        => 'required',
                        'sede_id'       => 'required',
                        'user_id'       => 'required'                                                           
                        ];
            for ($i=0; $i < count($request->all()) ; $i++) { 
                $validator = Validator::make($request->all()[$i], $rules);
                if ($validator->fails()) {
                    return response()->json(['errors'=>$validator->errors()]);
                }
            }
            $deletedRows = Turno::where('empleado_id', $request->all()[0]['empleado_id'])->where('sede_id', $request->all()[0]['sede_id'])->delete();

            for ($i=0; $i < count($request->all()) ; $i++) { 
                $turno = new Turno($request->all()[$i]);
                $turno->save();
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
}
