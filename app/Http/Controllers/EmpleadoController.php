<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Empleado;

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleados = Empleado::orderBy('id','ASC')->where('activo',true)->get();
        return $empleados;  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estadosciviles = EstadoCivile::where('activo',true)->orderBy('id','ASC')->get();
        $ubigeos = Ubigeo::where('activo',true)->orderBy('nombre','ASC')->get();
        $tipodocumentos = Tipodocumento::where('activo',true)->orderBy('nombre','ASC')->get();
        $tipocontratos = Tipocontrato::where('activo',true)->orderBy('nombre','ASC')->get();
        $tipopagodoctores = Tipopagodoctore::where('activo',true)->orderBy('nombre','ASC')->get();
        $cargos = Cargo::where('activo',true)->orderBy('nombre','ASC')->get();

        return [
              'estadosciviles'          => $estadosciviles,
              'ubigeos'                 => $ubigeos,
              'tipodocumentos'          => $tipodocumentos,
              'tipocontratos'           => $tipocontratos,
              'tipopagodoctores'        => $tipopagodoctores,
              'cargos'                  => $cargos
          ];
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
}
