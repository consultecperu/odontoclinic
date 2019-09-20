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
Route::get('sessionActiva','AuthenticateController@sessionActiva');

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
    Route::put('/pacientes/actualizacelular/{id}', 'PacienteController@Actualizacelular');
    Route::put('/pacientes/actualizaplanes/{id}', 'PacienteController@ActualizaPlanesPaciente');
    Route::get('/seguimientoplanes','PacienteController@seguimientoplanes');
    // imagenes y documentos de pacientes
    Route::post('/uploadPdf','PacienteController@uploadPdf'); 
    Route::post('/uploadImages','PacienteController@uploadImages');   
    Route::get('/listarPDF/{id}','PacienteController@listarPDF');
    Route::get('/listarImages/{id}','PacienteController@listarImages');      
    Route::post('/deletePDF','PacienteController@destroy_file');     
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
    Route::put('/presupuestosoperatoriasdetalles/descargatx/{id}','PresupuestosoperatoriaController@descargaTx');              
    Route::put('/presupuestosoperatoriasdetalles/descargasaldo/{id}','PresupuestosoperatoriaController@descargaSaldo');              
    Route::put('/presupuestosoperatoriasdetalles/texsupdie/{id}','PresupuestosoperatoriaController@textoSuperiorDiente');
    Route::get('/presupuestosoperatoriasdetalles/liquidacion-doctor/{empleado}/{sede}/{fechacorte}','PresupuestosoperatoriaController@liquidacion_doctor');
    Route::put('/presupuestosoperatoriasdetalles/delete_masivo/{id}','PresupuestosoperatoriaController@deleteitem_masivo');        
    Route::put('/presupuestosoperatoriasdetalles/descuento_masivo/{id}','PresupuestosoperatoriaController@descuento_masivo');        

    Route::get('presupuestos-operatorias/detalles','PresupuestosoperatoriaController@listaDetalles');    
    // ppto ortodoncia
    Route::resource('presupuestos-ortodoncias','PresupuestosortodonciaController'); 
    Route::put('/presupuestosortodoncias/cambioestado/{id}','PresupuestosortodonciaController@cambioEstado');              
    Route::put('/presupuestosortodonciasdetalles/descargatx/{id}','PresupuestosortodonciaController@descargaTx');              
    Route::put('/presupuestosortodonciasdetalles/descargasaldo/{id}','PresupuestosortodonciaController@descargaSaldo');              
    Route::put('/presupuestosortodonciasdetalles/addadicionales/{id}','PresupuestosortodonciaController@addAdicionales');              
    Route::get('/presupuestosortodonciasdetalles/liquidacion-doctor/{empleado}/{sede}/{fechacorte}','PresupuestosortodonciaController@liquidacion_doctor');

    Route::get('presupuestos-ortodoncias/detalles','PresupuestosortodonciaController@listaDetalles'); 
    // tipo cambios
    Route::resource('tipocambios','TipocambioController');
    Route::post('/addMensual','TipocambioController@addMensual');   
    // tipo pagos
    Route::resource('tipopagos','TipopagoController');     
    // record atencion operatoria
    Route::resource('recordatencion-operatorias','RecordatencionoperatoriaController'); 
    Route::put('recordatencion-operatorias/finalizar/{id}','RecordatencionoperatoriaController@finalizaTratamiento');
    // record atencion ortodoncia
    Route::resource('recordatencion-ortodoncias','RecordatencionortodonciaController'); 
    Route::put('recordatencion-ortodoncias/finalizar/{id}','RecordatencionortodonciaController@finalizaTratamiento');
    // pagos
    Route::resource('pagos','PagoController');    
    // citas
    Route::resource('citas','CitaController');      
    Route::get('/citas/fechas/{fecini}/{fecfin}','CitaController@cargacitas'); 
    Route::get('/citas/consultorios/fechas/{fecha}','CitaController@cargacitasconsultorios');     
    Route::post('/citas/cambioestado', 'CitaController@cambioestadocitas'); 
    Route::put('/citas/reprogramacion/{id}', 'CitaController@reprogramarcitas'); 
    Route::put('/citas/confirmar/{id}', 'CitaController@confirmarcitas');        
    Route::put('/citas/modificacion/{id}', 'CitaController@modificarcitas'); 
    Route::get('/citas/confirmacion/{empleado_id}/{sede_id}/{fecini}/{fecfin}','CitaController@cargaconfirmacioncitas');     
    Route::get('/citas/seguimiento/{sede_id}/{fecini}/{fecfin}','CitaController@cargaseguimientocitas');     
    // laboratoriotrabajos
    Route::resource('laboratoriotrabajos','LaboratoriotrabajoController'); 
    Route::put('/laboratoriotrabajos/envio/{id}', 'LaboratoriotrabajoController@envioTrabajo');   
    Route::put('/laboratoriotrabajos/recibir/{id}', 'LaboratoriotrabajoController@recibirTrabajo');
    // liquidacionlaboratorios 
    Route::resource('liquidacionlaboratorios','LiquidacionlaboratorioController'); 
    Route::put('/liquidacionlaboratorios/facturar/{id}', 'LiquidacionlaboratorioController@facturarLiquidacion');                                                                                                                                             
    // conceptos
    Route::resource('conceptos','ConceptoController');
    // transacciones doctor
    Route::resource('transaccionesdoctor','TransacciondoctorController');
    // liquidacion operatoria
    Route::resource('liquidacionoperatoria','LiquidacionoperatoriaController');
    Route::get('/liquidacionesoperatorias/sedes/{sede}/{fechadesde}/{fechahasta}','LiquidacionoperatoriaController@carga_liquidaciones_sede');
    Route::put('/liquidacionesoperatorias/facturar/{id}', 'LiquidacionoperatoriaController@facturarLiquidacion');                                                                                                                                             
    // liquidacion ortodoncia
    Route::resource('liquidacionortodoncia','LiquidacionortodonciaController');
    Route::get('/liquidacionesortodoncias/sedes/{sede}/{fechadesde}/{fechahasta}','LiquidacionortodonciaController@carga_liquidaciones_sede');
    Route::put('/liquidacionesortodoncias/facturar/{id}', 'LiquidacionortodonciaController@facturarLiquidacion');                                                                                                                                             
    // reportes en pdf
    Route::get('/reportes/pacientes/ficha/{id}','ReportePacienteController@imprimir_ficha');

});
