<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Image;
use Carbon\Carbon;
use App\Empleado;
use App\Estadocivile;
use App\Ubigeo;
use App\Tipodocumento;
use App\Tipocontrato;
use App\Tipopagodoctore;
use App\Cargo;
use App\Perfile;
use App\Hora;
use App\User;
use Globales; // son los helpers

class EmpleadoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $empleados = Empleado::with('tipodocumento','cargo','ubigeo','__user','__user.perfile','sedes')->orderBy('id','ASC')->where('activo',true)->get();
        return $empleados;  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $estadosciviles = Estadocivile::where('activo',true)->orderBy('id','ASC')->get();
        $ubigeos = Ubigeo::orderBy('id','ASC')->where('activo',true)->get();
        $tipodocumentos = Tipodocumento::where('activo',true)->orderBy('nombre_tipodocumento','ASC')->get();
        $tipocontratos = Tipocontrato::where('activo',true)->orderBy('nombre_tipocontrato','ASC')->get();
        $tipopagodoctores = Tipopagodoctore::where('activo',true)->orderBy('nombre_tipopagodoctor','ASC')->get();
        $cargos = Cargo::where('activo',true)->orderBy('nombre_cargo','ASC')->get();
        $perfiles = Perfile::where('activo',true)->orderBy('id','ASC')->get();
        $horas = Hora::where('activo',true)->orderBy('id','ASC')->get();        

        return [
              'estadosciviles'          => $estadosciviles,
              'ubigeos'                 => $ubigeos,
              'tipodocumentos'          => $tipodocumentos,
              'tipocontratos'           => $tipocontratos,
              'tipopagodoctores'        => $tipopagodoctores,
              'cargos'                  => $cargos,
              'perfiles'                => $perfiles,
              'horas'                   => $horas
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
        //dd($request);
        DB::beginTransaction();    

        try {
            $rules = ['tipodocumento_id'    =>  'required',
                      'numero_documento'    =>  'required',
                      'apellido_paterno'    =>  'required',
                      'apellido_materno'    =>  'required',
                      'nombres'             =>  'required',
                      'sexo'                =>  'required',
                      'email'               =>  'required',
                      'checkedSedes'        =>  'required'
                     ];

            if($request->has('fecha_nacimiento')){
                $rules = array_add($rules, 'fecha_nacimiento', 'date_format:d/m/Y');
            }
            if($request->get('image')){
                $rules = array_add($rules, 'image', 'image64:jpeg,jpg,png');
            }    
            $messages = ['fecha_nacimiento.date_format' => 'Formato de fecha invalido',
            'image.image64' => 'formato de imagen invalido'];                             
    
            $validator = Validator::make($request->all(), $rules ,$messages);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
            /*-- validacion del numero de documento --*/
            if($request->get('numero_documento')){
                $numdoc = $request->get('numero_documento');
                $empcon = Empleado::where('numero_documento',$numdoc)->count();
                if($empcon > 0){
                    return response()->json(['errors'=>['Número de Documento' => 'Ya existe un empleado con este numero de DNI : '.$request->get('dni')]]);
                }
            }            
            /*-- validacion del Nombre de empleado--*/
            $nom = Str::upper($request->get('nombres')).' '.Str::upper($request->get('apellido_paterno')).' '.Str::upper($request->get('apellido_materno'));         
            $nomemp = Empleado::where('nombre_completo',$nom)->count();
            if($nomemp > 0){
                return response()->json(['errors'=>['Nombre de Empleado' => 'Ya existe un empleado con estos datos']]);
            }
            /*-- Validacion de la imagen --*/
            if($request->get('image')){
                $imageData = $request->get('image');
                $fileName = $request->get('numero_documento') . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($request->get('image'))->save(public_path('images/').$fileName);
            }          
            $empleado = new Empleado($request->all());
            if(isset($fileName)){
                $empleado->foto = $fileName;
            }            
            $empleado->fecha_nacimiento = Globales::FormatFecYMD($request->get('fecha_nacimiento'));
            $empleado->fecha_ingreso = Globales::FormatFecYMD($request->get('fecha_ingreso'));
            $empleado->nombres = Str::upper($empleado->nombres);
            $empleado->apellido_paterno = Str::upper($empleado->apellido_paterno);
            $empleado->apellido_materno = Str::upper($empleado->apellido_materno);
            $empleado->nombre_completo = Str::upper($empleado->nombres).' '.Str::upper($empleado->apellido_paterno).' '.Str::upper($empleado->apellido_materno);                                    
            $empleado->save();
            /** --- Creamos el Usuario para el personal--- **/
            if($request->get('acceso_system')){
                $rules2 = [ 'username'      =>  'required',
                            'email'         =>  'required',
                            'perfil_id'     =>  'required'
                          ]; 
                          
                $validator2 = Validator::make($request->all(), $rules2);
                if ($validator2->fails()) {
                    DB::rollback();
                    return response()->json(['errors'=>$validator2->errors()]);
                }  
                /** --- validamos el nombre de usuario ----**/
                if($request->get('username')){
                    $usu = $request->get('username');
                    $usucon = User::where('name',$usu)->count();
                    if($usucon > 0){
                        DB::rollback();
                        return response()->json(['errors'=>['Nombre de Usuario' => 'Ya existe un Usuario con este username']]);
                    }
                }                 
                $usuario = new User();
                $usuario->name = $request->get('username');
                $usuario->email = $request->get('email');
                $usuario->password = bcrypt('secreto');
                $usuario->perfil_id = $request->get('perfil_id');
                $usuario->acceso = true;
                $usuario->fecha_vencimiento = Carbon::now()->format('Y-m-d'); 
                $usuario->empleado_id = $empleado->id;
                $usuario->save();         
            }
            /** --- creamos los registros en la tabla pivot empleado_sede**/
            if($request->get('checkedSedes')){
                $empleado->sedes()->sync($request->get('checkedSedes'));  
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
