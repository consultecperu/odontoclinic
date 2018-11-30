<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Exception;
use Validator;
use Carbon\Carbon;
use App\Modulo;

class ModuloController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $modules = Modulo::orderBy('id','ASC')->get();               // cargo todos los modulos de la BD
        
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
                            'name' => $modulo->name,
                            'idmenu' => $menu->id,
                            'options' => $modulo
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
                        'name' => $subope['name'] ,
                        'idoption' => $subope['options']->id,
                        'options' => $mod
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
                            'name' => $option['name'],
                            'options' => $option,
                            'suboptions' => $content
                    );                 
                    array_push($opcioncompleta,$men_sub);
                    $content = array();
                }
            }
            $mencom = array(
                'name' => $menu->name,
                'idmenu' => $menu->id,
                'options' => $opcioncompleta
            );
            $opcioncompleta = array();
            array_push($menucompleto,$mencom);
        }

        return $menucompleto;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $modulos = Modulo::orderBy('id','ASC')->where('active',true)->get();
        return $modulos; 
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
            $rules =    ['name'     => 'required',
                        'idparent'  => 'required',
                        'type'      => 'required',
                        'orden'     => 'required'
                        ];
  
          $validator = Validator::make($request->all(), $rules);
          if ($validator->fails()) {
              return response()->json(['errors'=>$validator->errors()]);
          }
          /*-- validacion del Nombre de modulo--*/
          if($request->get('name')){
              $nom = $request->get('name');         
              $nommod = Modulo::where('name',$nom)->count();
              if($nommod > 0){
                  return response()->json(['errors'=>['Nombre de modulo ' => 'Ya existe un modulo con estos datos']]);
              }
          }        
  
          $modulo = new Modulo($request->all());
          //$modulo->name = Str::upper($modulo->name);
          $modulo->save();
  
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
