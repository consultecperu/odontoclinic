<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Perfile;

class PerfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $perfiles = Perfile::with('modules')->orderBy('id','ASC')->where('activo',true)->get();
        return $perfiles;          
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
          $rules = ['nombre_perfil' => 'required'];
  
          $validator = Validator::make($request->all(), $rules);
          if ($validator->fails()) {
              return response()->json(['errors'=>$validator->errors()]);
          }
          /*-- validacion del Nombre de empleado--*/
          if($request->get('nombre_perfil')){
              $nom = Str::upper($request->get('nombre_perfil'));         
              $nomper = Perfile::where('nombre_perfil',$nom)->count();
              if($nomper > 0){
                  return response()->json(['errors'=>['Nombre de perfil ' => 'Ya existe un perfil con estos datos']]);
              }
          }        
  
          $perfil = new Perfile($request->all());
          $perfil->nombre_perfil = Str::upper($perfil->nombre_perfil);
          $perfil->save();
  
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
        $modules = Perfile::find($id)->modules()->orderBy('id','ASC')->get();
        //$modules = Module::all();               // cargo todos los modulos de la BD        
        $menus = array();
        $options = array();
        $suboptions = array();
        $content =  array();
        $menucompleto = array();
        $opcioncompleta = array();
        // consulto todos los parent 0
        foreach ($modules as $modul) {
            if($modul->idparent == 0){
                array_push($menus,$modul);      // cargo todos los parent 0 en el array $menus
            }
        }
        // consulto 1 a 1 los parents correspondientes a cada parent 0
        foreach ($menus as $menu) {
            foreach ($modules as $modulo) {
                if($modulo->idparent == $menu->id){
                    $option = array(
                            'name'          => $modulo->name,
                            'id'            => $modulo->id,
                            'idmenu'        => $menu->id,
                            'icono'         => $modulo->icono,
                            'name_router'   => $modulo->name_router,
                            'name_template' => $modulo->name_template,
                            'options'       => $modulo
                    );
                    array_push($options,$option);       // cargo los hijos de cada parent 0 en el array $options

                }
            }
        }
        // consulto 1 a 1 si los hijos tiene mas desendientes
        foreach ($options as $subope) {
            foreach ($modules as $mod) {
                if($subope['options']->id == $mod->idparent){
                    $sub = array(
                        'name'          => $subope['name'] ,
                        'idoption'      => $subope['options']->id,                 
                        'options'       => $mod
                    );
                    array_push($suboptions,$sub);   // lo cargo en el array $suboptions
                }
            }
        }

        // enlazamos menu - option
        foreach ($menus as $menu) {
            foreach ($options as $option) {
                if($option['idmenu'] == $menu->id){
                    foreach ($suboptions as $sop) {     // enlazamos opciones con subopciones
                        if($option['options']->id == $sop['idoption']){
                            array_push($content,$sop);
                        }
                    }   
                    $men_sub = array(
                            'name'          => $option['name'],
                            'id'            => $option['id'],
                            'icono'         => $option['icono'],
                            'name_router'   => $option['name_router'],
                            'name_template' => $option['name_template'],
                            'options'       => $option,
                            'suboptions'    => $content
                    );                 
                    array_push($opcioncompleta,$men_sub);
                    $content = array();
                }

            }
            $mencom = array(
                'name'          => $menu->name,
                'idmenu'        => $menu->id,
                'icono'         => $menu->icono,
                'name_router'   => $menu->name_router,
                'name_template' => $menu->name_template,
                'options'       => $opcioncompleta
            );
            $opcioncompleta = array();
            array_push($menucompleto,$mencom);
        }

        return $menucompleto;        

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
            $rules =    ['nombre_perfil'     => 'required'];
    
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['errors'=>$validator->errors()]);
            }

            $perfil = Perfile::find($id);
            $perfil->fill($request->all());
            $perfil->nombre_perfil = Str::upper($perfil->nombre_perfil);
            $perfil->save();
  
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
            $perfil = Perfile::findOrFail($id);
            $perfil->nombre_perfil = $perfil->nombre_perfil . ' *** ' . Carbon::now()->timestamp;            
            $perfil->activo = false;
            $perfil->save();            
        } catch (Exception $e) {
            return response()->json(
                ['status' => $e->getMessage()], 422
            );
        }
    }

    public function updateModules(Request $request, $id)
    {
        $perfil = Perfile::find($id);
        // actualiza los modulos
        $perfil->modules()->sync($request->get('checkedRol'));
    } 
    
    public function cargaModules($id)
    {
        $modules = Role::find($id)->modules()->orderBy('id','ASC')->get();
        //$modules = Module::all();               // cargo todos los modulos de la BD        
        $menus = array();
        $options = array();
        $suboptions = array();
        $content =  array();
        $menucompleto = array();
        $opcioncompleta = array();
        // consulto todos los parent 0
        foreach ($modules as $modul) {
            if($modul->idparent == 0){
                array_push($menus,$modul);      // cargo todos los parent 0 en el array $menus
            }
        }
        // consulto 1 a 1 los parents correspondientes a cada parent 0
        foreach ($menus as $menu) {
            foreach ($modules as $modulo) {
                if($modulo->idparent == $menu->id){
                    $option = array(
                            'name'          => $modulo->name,
                            'id'            => $modulo->id,
                            'idmenu'        => $menu->id,
                            'icono'         => $modulo->icono,
                            'name_router'   => $modulo->name_router,
                            'name_template' => $modulo->name_template,
                            'options'       => $modulo
                    );
                    array_push($options,$option);       // cargo los hijos de cada parent 0 en el array $options

                }
            }
        }
        // consulto 1 a 1 si los hijos tiene mas desendientes
        foreach ($options as $subope) {
            foreach ($modules as $mod) {
                if($subope['options']->id == $mod->idparent){
                    $sub = array(
                        'name'          => $subope['name'] ,
                        'idoption'      => $subope['options']->id,                 
                        'options'       => $mod
                    );
                    array_push($suboptions,$sub);   // lo cargo en el array $suboptions
                }
            }
        }

        // enlazamos menu - option
        foreach ($menus as $menu) {
            foreach ($options as $option) {
                if($option['idmenu'] == $menu->id){
                    foreach ($suboptions as $sop) {     // enlazamos opciones con subopciones
                        if($option['options']->id == $sop['idoption']){
                            array_push($content,$sop);
                        }
                    }   
                    $men_sub = array(
                            'name'          => $option['name'],
                            'id'            => $option['id'],
                            'icono'         => $option['icono'],
                            'name_router'   => $option['name_router'],
                            'name_template' => $option['name_template'],
                            'options'       => $option,
                            'suboptions'    => $content
                    );                 
                    array_push($opcioncompleta,$men_sub);
                    $content = array();
                }

            }
            $mencom = array(
                'name'          => $menu->name,
                'idmenu'        => $menu->id,
                'icono'         => $menu->icono,
                'name_router'   => $menu->name_router,
                'name_template' => $menu->name_template,
                'options'       => $opcioncompleta
            );
            $opcioncompleta = array();
            array_push($menucompleto,$mencom);
        }

        return $menucompleto;        
    }

}
