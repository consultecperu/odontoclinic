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
    Route::put('/users/accesos/{id}','UserController@updateaccesos');     
    // modulos
    Route::resource('modulos','ModuloController');
    // accesos
    Route::resource('accesos','AccesoController');    
    Route::get('/accesos/usuario/{id}','AccesoController@listaAccesosUsuario'); 
    Route::put('/accesos/estados/{id}','AccesoController@updateAccesosEstados');        
    // cargos
    Route::resource('cargos','CargoController');    
    // grupo de servicios
    Route::resource('gruposervicios','GruposervicioController');  
    // laboratorios
    Route::resource('laboratorios','LaboratorioController');
    Route::resource('laboratorioservicios','LaboratorioservicioController');
    Route::put('/laboratorioservicios/agregarserviciomultident/{id}', 'LaboratorioservicioController@AgregarServicioMultident'); 
    Route::put('/laboratorioservicios/eliminarserviciomultident/{id}', 'LaboratorioservicioController@EliminarServicioMultident');                
    // monedas
    Route::resource('monedas','MonedaController');   
    // materiales
    Route::resource('materiales','MaterialController');
    Route::resource('materialservicios','MaterialservicioController');       
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
    Route::get('/empresapacientes/empresas/{id}','EmpresapacienteController@listaempresas');    
    Route::delete('/empresapacientes/aseguradoras/{id}','EmpresapacienteController@destroyaseguradora');  
    // polizas
    Route::resource('polizas','PolizaController'); 
    Route::get('/polizas/detalle/{empid}/{plaid}','PolizaController@showpoliza');   
    Route::get('/planpolizas','PolizaController@cargaplanpolizas');   
    // convenios
    Route::resource('convenios','ConvenioController');  
    // campañas
    Route::resource('campanias','CampañaController');     
    // canjes
    Route::resource('canjes','CanjeController');
    Route::put('/canjes/autorizar/{id}','CanjeController@autorizarCanjes'); 
    // empleados
    Route::resource('empleados','EmpleadoController'); 
    // turnos
    Route::resource('turnos','TurnoController');  
    // turnos-especiales
    Route::resource('turnos-especiales','TurnoEspecialController');   
    // permisos
    Route::resource('permisos','PermisoController');    
    // pacientes
    Route::resource('pacientes','PacienteController');  
    Route::put('/pacientes/actualizahc/{id}','PacienteController@ActualizaHC');      
    Route::put('/pacientes/actualizafoto/{id}','PacienteController@ActualizaFoto');  
    // dependientes
    Route::resource('dependientes','DependienteController'); 
    Route::post('/dependientes/relacion', 'DependienteController@relacion'); 
    // derivaciones
    Route::resource('derivaciones','DerivacionController');  
    // dientes
    Route::resource('dientes','DienteController');   
    // ppto operatoria
    Route::resource('presupuestos-operatorias','PresupuestosoperatoriaController');
    Route::put('/presupuestosoperatoriasdetalles/delete/{id}','PresupuestosoperatoriaController@deleteitem');        
    Route::put('/presupuestosoperatoriasdetalles/add/{id}','PresupuestosoperatoriaController@additem');  
    Route::put('/presupuestosoperatoriasdetalles/deltradie/{id}','PresupuestosoperatoriaController@deleteTratamientosDiente');
    Route::put('/presupuestosoperatoriasdetalles/estdieaus/{id}','PresupuestosoperatoriaController@estadoDientesAusentes');              
    Route::put('/presupuestosoperatorias/cambioestado/{id}','PresupuestosoperatoriaController@cambioEstado');              
    // ppto ortodoncia
    Route::resource('presupuestos-ortodoncias','PresupuestosortodonciaController'); 
    // tipo cambios
    Route::resource('tipocambios','TipocambioController');   
    // record atencion
    Route::resource('recordatencion-operatorias','RecordatencionoperatoriaController');                                                                                                                              
});
