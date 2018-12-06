<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::post('login', 'AuthenticateController@login');

// Routes

Route::middleware(['auth'])->group(function(){
    Route::post('logout', 'AuthenticateController@logout');  
    Route::put('/perfiles/updateModules/{id}', 'PerfileController@updateModules');
    Route::get('/perfiles/cargaModules/{id}', 'PerfileController@cargaModules');          
    // perfiles
    Route::resource('perfiles','PerfileController');
    // usuarios
    Route::resource('users','UserController');       
    // modulos
    Route::resource('modulos','ModuloController');
    // cargos
    Route::resource('cargos','CargoController');    
    // grupo de servicios
    Route::resource('gruposervicios','GruposervicioController');  
    // laboratorios
    Route::resource('laboratorios','LaboratorioController');  
    // monedas
    Route::resource('monedas','MonedaController');   
    // materiales
    Route::resource('materiales','MaterialController');  
    // sedes
    Route::resource('sedes','SedeController');  
    // ubigeos
    Route::resource('ubigeos','UbigeoController');  
    // empresas administradoras
    Route::resource('empresas','EmpresaAdministradoraController');      
    // servicios
    Route::resource('servicios','ServicioController');
    // simbologias
    Route::resource('simbologias','SimbologiaController');  
    // planes
    Route::resource('planes','PlaneController');    
    // tarifarios
    Route::resource('tarifarios','TarifarioController');    
    // empresapacientes
    Route::resource('empresapacientes','EmpresapacienteController'); 
    Route::post('/empresapacientes/aseguradoras', 'EmpresapacienteController@addaseguradora'); 
    Route::get('/empresapacientes/aseguradoras/{id}','EmpresapacienteController@listaaseguradoras');
    Route::delete('/empresapacientes/aseguradoras/{id}','EmpresapacienteController@destroyaseguradora');  
    // polizas
    Route::resource('polizas','PolizaController'); 
    Route::get('/polizas/detalle/{empid}/{plaid}','PolizaController@showpoliza');   
    Route::get('/planpolizas','PolizaController@cargaplanpolizas');   
    // convenios
    Route::resource('convenios','ConvenioController');  
    // campañas
    Route::resource('campanias','CampañaController');                                                                     
});
