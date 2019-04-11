<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Exception;
use Validator;
use Image;
use Carbon\Carbon;
use App\Paciente;
use App\Estadocivile;
use App\Ubigeo;
use App\Tipodocumento;
use App\Motivocaptacion;
use App\Parentesco;
use App\Asignacion;
use App\Pacienteplan;
use App\Historiaclinica;
use App\Convenio;
use App\Campaña;
use Globales;   // helpers

class PacienteController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pacientes = Paciente::with('tipodocumento','sede','pacienteplanes','pacienteplanes.plan','pacienteplanes.empresapaciente','pacienteplanes.poliza','empleado','ubigeo')->orderBy('id','DESC')->where('activo',true)->get();
        return $pacientes;  
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
        $motivocaptaciones = Motivocaptacion::where('activo',true)->orderBy('nombre_motivocaptacion','ASC')->get();
        $parentescos = Parentesco::orderBy('id','ASC')->where('activo',true)->get();
        $asignaciones = Asignacion::orderBy('id','ASC')->where('activo',true)->get();
        $convenios = Convenio::orderBy('id','ASC')->where('activo',true)->get();
        $campañas = Campaña::orderBy('id','ASC')->where('activo',true)->get();

        return [
              'estadosciviles'          => $estadosciviles,
              'ubigeos'                 => $ubigeos,
              'tipodocumentos'          => $tipodocumentos,
              'motivocaptaciones'       => $motivocaptaciones,
              'parentescos'             => $parentescos,
              'asignaciones'            => $asignaciones,
              'convenios'               => $convenios,
              'campañas'                => $campañas
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
        DB::beginTransaction();    

        try {
            $rules = ['tipodocumento_id'        => 'required',
                      'numero_documento'        => 'required',
                      'sede_id'                 => 'required',
                      'nombres'                 => 'required',
                      'apellido_paterno'        => 'required',
                      'apellido_materno'        => 'required',
                      'sexo'                    => 'required',
                      'empleado_id'             => 'required',
                      'asignacion_id'           => 'required',
                      'user_id'                 => 'required',
                      'plan_id'                 => 'required',
                      'tipo'                    => 'required'
                      ];

            if($request->get('tipo') == 2){
                $rules = array_add($rules, 'empresapaciente_id', 'required');
                $rules = array_add($rules, 'poliza_id', 'required');
            }    
            if($request->has('fecha_nacimiento')){
                $rules = array_add($rules, 'fecha_nacimiento', 'date_format:d-m-Y');
            }
            if($request->has('fecha_ingreso')){
                $rules = array_add($rules, 'fecha_ingreso', 'date_format:d-m-Y');
            }            
/*             if($request->get('image')){
                $rules = array_add($rules, 'image', 'image64:jpeg,jpg,png');
            }   */  
/*             $messages = ['fecha_nacimiento.date_format' => 'Formato de fecha invalido',
            'image.image64' => 'formato de imagen invalido'];    */                          
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
            /*-- validacion del numero de documento --*/
            if($request->get('numero_documento')){
                $numdoc = $request->get('numero_documento');
                $empcon = Paciente::where('numero_documento',$numdoc)->where('activo',true)->count();
                if($empcon > 0){
                    return response()->json(['errors'=>['Número de Documento' => 'Ya existe un paciente con este numero de DNI : '.$request->get('dni')]]);
                }
            }            
            /*-- validacion del Nombre de paciente--*/
            $nom = Str::upper($request->get('nombres')).' '.Str::upper($request->get('apellido_paterno')).' '.Str::upper($request->get('apellido_materno'));         
            $nomemp = Paciente::where('nombre_completo',$nom)->where('activo',true)->count();
            if($nomemp > 0){
                return response()->json(['errors'=>['Nombre de Paciente' => 'Ya existe un paciente con estos datos']]);
            }
            /*-- Validacion de la imagen --*/
            if($request->get('image')){
                $imageData = $request->get('image');
                $fileName = $request->get('numero_documento') . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($request->get('image'))->save(public_path('images/pacientes/').$fileName);
            }          
            $paciente = new Paciente($request->all());
            if(isset($fileName)){
                $paciente->foto = $fileName;
            }            
            $paciente->fecha_nacimiento = Globales::FormatFecYMD($request->get('fecha_nacimiento'));
            $paciente->fecha_ingreso = Globales::FormatFecYMD($request->get('fecha_ingreso'));
            $paciente->nombres = Str::upper($paciente->nombres);
            $paciente->apellido_paterno = Str::upper($paciente->apellido_paterno);
            $paciente->apellido_materno = Str::upper($paciente->apellido_materno);
            $paciente->nombre_completo = Str::upper($paciente->nombres).' '.Str::upper($paciente->apellido_paterno).' '.Str::upper($paciente->apellido_materno);                                              
            $paciente->save();
            /** --- creamos los datos en la tabla paciente_plan---**/
            $pacienteplan = new Pacienteplan($request->all());
            $pacienteplan->paciente_id = $paciente->id;
            $pacienteplan->save();
            DB::commit();        
            //return;   
            return response()->json(['idpaciente' => $paciente->id], 200);                     
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
            $rules = ['tipodocumento_id'        => 'required',
                      'numero_documento'        => 'required',
                      'sede_id'                 => 'required',
                      'nombres'                 => 'required',
                      'apellido_paterno'        => 'required',
                      'apellido_materno'        => 'required',
                      'sexo'                    => 'required',
                      'empleado_id'             => 'required',
                      'asignacion_id'           => 'required',
                      'user_id'                 => 'required',
                      'plan_id'                 => 'required',
                      'tipo'                    => 'required'
                      ];
            if($request->get('tipo') == 2){
                $rules = array_add($rules, 'empresapaciente_id', 'required');
                $rules = array_add($rules, 'poliza_id', 'required');
            }    
            if($request->has('fecha_nacimiento')){
                $rules = array_add($rules, 'fecha_nacimiento', 'date_format:d-m-Y');
            }
            if($request->has('fecha_ingreso')){
                $rules = array_add($rules, 'fecha_ingreso', 'date_format:d-m-Y');  
            }  
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
            $paciente = Paciente::find($id);
            $paciente->fill($request->all());   
            $paciente->fecha_nacimiento = Globales::FormatFecYMD($request->get('fecha_nacimiento'));
            $paciente->fecha_ingreso = Globales::FormatFecYMD($request->get('fecha_ingreso'));
            $paciente->nombres = Str::upper($paciente->nombres);
            $paciente->apellido_paterno = Str::upper($paciente->apellido_paterno);
            $paciente->apellido_materno = Str::upper($paciente->apellido_materno);
            $paciente->nombre_completo = Str::upper($paciente->nombres).' '.Str::upper($paciente->apellido_paterno).' '.Str::upper($paciente->apellido_materno);                                              
            $paciente->save();
            /** --- actualizamos los datos en la tabla paciente_plan---**/
            $pacienteplan = Pacienteplan::find($request->get('pacienteplanid'));
            $pacienteplan->tipo = $request->get('tipo');
            $pacienteplan->plan_id = $request->get('plan_id');
            $pacienteplan->descripcion = $request->get('descripcion');
            $pacienteplan->empresapaciente_id = ($request->get('empresapaciente_id')) ? $request->get('empresapaciente_id') : null;
            $pacienteplan->poliza_id = ($request->get('poliza_id')) ?  $request->get('poliza_id') : null;            
            $pacienteplan->save();            

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
            $paciente = Paciente::findOrFail($id);  
            $paciente->nombre_completo = $paciente->nombre_completo . ' *** ' . Carbon::now()->timestamp;            
            $paciente->activo = false;
            $paciente->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }

    public function ActualizaHC(Request $request, $id)
    {
        try {
            $paciente = Paciente::find($id);
            if($paciente->historiaclinica == null){
                $paciente->historiaclinica = Globales::HC_Correlativo($request->get('sede_id'));
                $paciente->save(); 
            }
            return;
        } catch (Exception $e) {
            return response()->json(
                ['errors' => $e->getMessage()], 422
            );
        }
       
    }
    public function ActualizaFoto(Request $request, $id)
    {
        try {
            /*-- Validacion de la imagen --*/
            if($request->get('image')){
                $imageData = $request->get('image');
                $fileName = $request->get('numero_documento') . '.' . explode('/', explode(':', substr($imageData, 0, strpos($imageData, ';')))[1])[1];
                Image::make($request->get('image'))->save(public_path('images/pacientes/').$fileName);         
            } 
            $paciente = Paciente::find($id);
            if(isset($fileName)){
                $paciente->foto = $fileName;
                $paciente->save(); 
            }  
        } catch (Exception $e) {
            return response()->json(
                ['errors' => $e->getMessage()], 422
            );
        }
                   
    }

    public function Actualizacelular(Request $request, $id)
    {
        try {
            $paciente = Paciente::find($id);
            $paciente->celular = $request->get('celular');
            $paciente->save();  
        } catch (Exception $e) {
            return response()->json(
                ['errors' => $e->getMessage()], 422
            );
        }
      
    }    
}
