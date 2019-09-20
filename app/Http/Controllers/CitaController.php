<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Cita;
use App\Seguimientocita;
use App\Paciente;
use App\Pacienteplan;
use Globales;   // helpers

class CitaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $citas = Cita::with('empleado','estadocita','seguimientocitas.estadocita','seguimientocitas.user.__empleado')->orderBy('fecha_cita','DESC')->where('activo',true)->get();
        return $citas;   
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

            if($request->filled('data_paciente')){

                $rules = ['tipodocumento_id'    => 'required',
                          'numero_documento'    => 'required',
                          'sede_id'             => 'required',
                          'sexo'                => 'required',
                          'empleado_id'         => 'required',
                          'apellido_paterno'    => 'required',
                          'apellido_materno'    => 'required',
                          'nombres'             => 'required',
                          'user_id'             => 'required'        
               ];
                     
                $validator = Validator::make($request->get('data_paciente'), $rules);
                if ($validator->fails()) {
                    return response()->json(['errors'=>$validator->errors()]);
                } 
                $ver_paciente = $request->get('data_paciente');
                /*-- validacion del numero de documento --*/
                if($ver_paciente['numero_documento']){
                    $numdoc = $ver_paciente['numero_documento'];
                    $empcon = Paciente::where('numero_documento',$numdoc)->where('activo',true)->count();
                    if($empcon > 0){
                        return response()->json(['errors'=>['Número de Documento' => 'Ya existe un paciente con este numero de DNI : '.$request->get('dni')]]);
                    }
                }            
                /*-- validacion del Nombre de paciente--*/
                $nom = Str::upper($ver_paciente['nombres']).' '.Str::upper($ver_paciente['apellido_paterno']).' '.Str::upper($ver_paciente['apellido_materno']);         
                $nompac = Paciente::where('nombre_completo',$nom)->where('activo',true)->count();
                if($nompac > 0){
                    return response()->json(['errors'=>['Nombre de Paciente' => 'Ya existe un paciente con estos datos']]);
                }
                $paciente = new Paciente($request->get('data_paciente'));  
                $paciente->fecha_nacimiento = date('Y-m-d');
                $paciente->fecha_ingreso = date('Y-m-d');
                $paciente->nombres = Str::upper($paciente->nombres);
                $paciente->apellido_paterno = Str::upper($paciente->apellido_paterno);
                $paciente->apellido_materno = Str::upper($paciente->apellido_materno);               
                $paciente->nombre_completo = Str::upper($paciente->nombres).' '.Str::upper($paciente->apellido_paterno).' '.Str::upper($paciente->apellido_materno);
                $paciente->save();

                $pacienteplan = new Pacienteplan($request->get('data_paciente'));
                $pacienteplan->paciente_id = $paciente->id;
                $pacienteplan->save();
            }

            $rules2 = [
                       'empleado_id'     => 'required',
                       'start'           => 'required',
                       'end'             => 'required',
                       'fecha_cita'      => 'required',
                       'sede_id'         => 'required',
                       'user_id'         => 'required'        
                     ];

            if(!$request->filled('data_paciente')){
                $rules2 = array_add($rules2, 'paciente_id', 'required');
            }                       
            if($request->has('fecha_cita')){
                $rules2 = array_add($rules2, 'fecha_cita', 'date_format:d-m-Y');
            }                       
            $validator2 = Validator::make($request->all(), $rules2);
            if ($validator2->fails()) {
                return response()->json(['errors'=>$validator2->errors()]);
            }      
    
            $cita = new Cita($request->all());
            if($request->filled('data_paciente')){
                $cita->paciente_id = $paciente->id;
            }
            $cita->fecha_cita = Globales::FormatFecYMD($request->get('fecha_cita'));   
            $cita->save();

            $segcita = new Seguimientocita();
            $segcita->cita_id = $cita->id;
            $segcita->fecha_incidencia = Globales::FormatFecYMD_hms($request->get('fecha_incidencia'));
            $segcita->estadocita_id = 1;
            $segcita->empleado_id = $request->get('empleado_id');
            $segcita->reprogramado = 0;
            $segcita->eliminado = 0;
            $segcita->comentario = $request->get('comentario');
            $segcita->user_id = $request->get('user_id');
            $segcita->save();
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
    public function cargacitas($fecini,$fecfin)
    {    
        $dat_ini = Carbon::create(substr($fecini,4,4), substr($fecini,2,2),substr($fecini,0,2));        
        $dat_fin = Carbon::create(substr($fecfin,4,4), substr($fecfin,2,2),substr($fecfin,0,2));        
        // actualizando el estado no se presento
        $citas_nsp = Cita::where('estadocita_id',1)->where('activo',true)->whereDate('fecha_cita', '>=',$dat_ini)->whereDate('fecha_cita','<=',$dat_fin)->get();        
        if($citas_nsp){
            foreach ($citas_nsp as $cit)
            {
                $minutos = Globales::DifMinutos($cit->fecha_cita,$cit->end);
                if( $minutos <= -1 )
                {
                    Cita::where('id',$cit->id)->update(['estadocita_id' => 6]);
                }
            } 
        }
        // cargando las citas    
        $citas = Cita::with('paciente','empleado','seguimientocitas')->orderBy('id','ASC')->where('activo',true)->whereDate('fecha_cita', '>=',$dat_ini)->whereDate('fecha_cita','<=',$dat_fin)->get();
        return $citas;         
    }  
    public function cargacitasconsultorios($fec)
    {    
        $dat_fec = Carbon::create(substr($fec,4,4), substr($fec,2,2),substr($fec,0,2));             
        // actualizando el estado no se presento
        $citas_nsp = Cita::where('estadocita_id',1)->where('activo',true)->whereDate('fecha_cita', '=',$dat_fec)->get();        
        if($citas_nsp){
            foreach ($citas_nsp as $cit)
            {
                $minutos = Globales::DifMinutos($cit->fecha_cita,$cit->end);
                if( $minutos <= -1 )
                {
                    Cita::where('id',$cit->id)->update(['estadocita_id' => 6]);
                }
            } 
        }
        // cargando las citas    
        $citas = Cita::with('paciente','empleado','seguimientocitas')->orderBy('id','ASC')->where('activo',true)->whereDate('fecha_cita', '=',$dat_fec)->get();
        return $citas;         
    }  
    public function cargaconfirmacioncitas($empleado_id,$sede_id,$fecini,$fecfin)
    {    
        $dat_ini = Carbon::create(substr($fecini,4,4), substr($fecini,2,2),substr($fecini,0,2));        
        $dat_fin = Carbon::create(substr($fecfin,4,4), substr($fecfin,2,2),substr($fecfin,0,2));        
        // cargando las citas    
        if($empleado_id == 0 ){
            $citas = Cita::with('paciente','empleado','seguimientocitas')->orderBy('id','ASC')->where('activo',true)->whereDate('fecha_cita', '>=',$dat_ini)->whereDate('fecha_cita','<=',$dat_fin)->where(['sede_id' => $sede_id])->get();

        }else{
            $citas = Cita::with('paciente','empleado','seguimientocitas')->orderBy('id','ASC')->where('activo',true)->whereDate('fecha_cita', '>=',$dat_ini)->whereDate('fecha_cita','<=',$dat_fin)->where(['empleado_id' => $empleado_id , 'sede_id' => $sede_id])->get();
        }
        return $citas;         
    }  
    
    public function cambioestadocitas(Request $request)
    {
        DB::beginTransaction();    

        try {
            $rules = ['cita_id'             => 'required',
                      'fecha_incidencia'    => 'required',
                      'estadocita_id'       => 'required',
                      'user_id'             => 'required'    
                     ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }     
            
            if($request->get('estadocita_id') == 5){
                Cita::where(['id' => $request->get('cita_id')])->update(['estadocita_id' => $request->get('estadocita_id'), 'activo' => false]);
            }else{
                Cita::where(['id' => $request->get('cita_id')])->update(['estadocita_id' => $request->get('estadocita_id')]);
            }
    
            $segcita = new Seguimientocita($request->all());
            $segcita->fecha_incidencia = Globales::FormatFecYMD_hms($request->get('fecha_incidencia'));
            $segcita->save();
    
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
    
    public function reprogramarcitas(Request $request,$id)
    {
        DB::beginTransaction();    
        try {

            $rules = ['comentario'   => 'required'];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }              
            $cita = Cita::findOrFail($id); 
            $cita->reprogramado = 1;
            $cita->estadocita_id = 1;
            $cita->fecha_cita = $request->get('fecha_nueva'); 
            $cita->start = $request->get('start_nueva');
            $cita->end = $request->get('end_nueva');     
            $cita->save(); 

            $segcita = new Seguimientocita($request->all());
            $segcita->fecha_incidencia = Globales::FormatFecYMD_hms($request->get('fecha_incidencia'));
            $segcita->save();
    
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

    public function modificarcitas(Request $request,$id)
    {
        DB::beginTransaction();    
        try {
            $rules = ['comentario'   => 'required'];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }             
            $cita = Cita::findOrFail($id); 
            //$cita->reprogramado = 1;
            //$cita->fecha_cita = $request->get('fecha_nueva'); 
            //$cita->start = $request->get('start_nueva');
            $cita->end = $request->get('end_nueva');     
            $cita->save(); 

            $segcita = new Seguimientocita($request->all());
            $segcita->fecha_incidencia = Globales::FormatFecYMD_hms($request->get('fecha_incidencia'));
            $segcita->save();
    
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
    
    public function confirmarcitas(Request $request,$id)
    {
        DB::beginTransaction();    
        try {         
            $cita = Cita::findOrFail($id); 
            $cita->confirmado = true;     
            $cita->save(); 

            $segcita = new Seguimientocita($request->all());
            $segcita->fecha_incidencia = Globales::FormatFecYMD_hms($request->get('fecha_incidencia'));
            $segcita->save();
    
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
    
    public function ActualizarAgenda()
    {
        
        $citas = Cita::where(['estadocita_id' => 1,'activo' => true])->get();
        foreach ($citas as $cit)
        {
            if(Globales::DiffMinutes($cit->fecha_cita,$cit->start) > 5 )
            {
                Cita::where('id',$cit->id)->update(['estadocita_id' => 6]);
            }
        }
    }
    public function cargaseguimientocitas($sede_id,$fecini,$fecfin)
    {    
        $dat_ini = Carbon::create(substr($fecini,4,4), substr($fecini,2,2),substr($fecini,0,2));        
        $dat_fin = Carbon::create(substr($fecfin,4,4), substr($fecfin,2,2),substr($fecfin,0,2));        
        // cargando las citas    
        if($sede_id == 0 ){
            $citas = Cita::with('paciente','empleado','seguimientocitas')->orderBy('id','ASC')->where('activo',true)->whereDate('fecha_cita', '>=',$dat_ini)->whereDate('fecha_cita','<=',$dat_fin)->get();

        }else{
            $citas = Cita::with('paciente','empleado','seguimientocitas')->orderBy('id','ASC')->where('activo',true)->whereDate('fecha_cita', '>=',$dat_ini)->whereDate('fecha_cita','<=',$dat_fin)->where(['sede_id' => $sede_id])->get();
        }
        return $citas;         
    }     
}
