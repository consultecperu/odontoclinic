<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\TipoCambio;

class TipocambioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tipocambios = TipoCambio::with('monedade','monedaa')->orderBy('fecha_registro','DESC')->where('activo',true)->get();
        return $tipocambios;  
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
            $rules = ['valor_compra'    => 'required',
                      'valor_venta'     => 'required',
                      'monedade_id'     => 'required',
                      'monedaa_id'      => 'required',
                      'tipo_cambio'     => 'required'
                      ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
            /*-- validacion del Nombre de empleado--*/
            if($request->get('fecha_registro')){       
                $fec = TipoCambio::where('fecha_registro',$request->get('fecha_registro'))->count();
                if($fec > 0){
                    return response()->json(['errors'=>['Fecha de Registro' => 'Ya existe un tipo de cambio para la fecha de hoy']]);
                }
            }        
    
            $tipocambio = new TipoCambio($request->all());
            $tipocambio->save();
    
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