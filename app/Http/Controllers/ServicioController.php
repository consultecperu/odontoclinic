<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Servicio;
use App\Serviciodetalle;
use App\ServicioLaboratorio;

class ServicioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $servicios = Servicio::with('gruposervicios','simbologia','serviciodetalle','materialservicios')->orderBy('nombre_servicio','ASC')->where('activo',true)->get();
        return $servicios; 
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
            $rules = ['nombre_servicio'   => 'required',
                        'tipo'              => 'required',
                        'user_id'           => 'required'
                    ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }
    
            /*-- validacion del Nombre de servicio--*/
            if($request->get('nombre_servicio')){
                $nom = Str::upper($request->get('nombre_servicio'));         
                $nomser = Servicio::where('nombre_servicio',$nom)->count();
                if($nomser > 0){
                    return response()->json(['errors'=>['Nombre de servicio' => 'Ya existe un servicio con estos datos']]);
                }
            }           
          
            $servicio = new Servicio($request->all());   
            $servicio->nombre_servicio = Str::upper($servicio->nombre_servicio);
            $servicio->save();

            if($request->get('tipo') == 2 && !empty($request->get('parentid_ortodoncia'))){
                $serdet = new Serviciodetalle();
                $serdet->servicio_id = $servicio->id;
                $serdet->control_ortodoncia = $request->get('control_ortodoncia');
                $serdet->cuota_inicial = $request->get('cuota_inicial');
                $serdet->ortofacil = $request->get('ortofacil');
                $serdet->save();
            }
 
            // actualiza los gruposervicios
            $servicio->gruposervicios()->sync($request->get('dataGrupos'));           

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
        DB::beginTransaction(); 

        try {
            $rules = ['nombre_servicio'     => 'required',
                      'tipo'                => 'required',
                      'user_id'             => 'required'
                    ];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $servicio = Servicio::find($id);
            $servicio->fill($request->all());
            $servicio->nombre_servicio = Str::upper($servicio->nombre_servicio);
            $servicio->save();

            if($request->get('tipo') == 2 && !empty($request->get('parentid_ortodoncia'))){
                $serviciodet = Serviciodetalle::where('servicio_id',$id)->first(); 
                $serviciodet->control_ortodoncia = $request->get('control_ortodoncia');
                $serviciodet->cuota_inicial = $request->get('cuota_inicial');
                $serviciodet->ortofacil = $request->get('ortofacil'); 
                $serviciodet->save();                                 
            }    
            
            $servicio->gruposervicios()->sync($request->get('dataGrupos'));                
  
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
            $servicio = Servicio::findOrFail($id);
            $servicio->nombre_servicio = $servicio->nombre_servicio . ' *** ' . Carbon::now()->timestamp;            
            $servicio->activo = false;
            $servicio->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }
}