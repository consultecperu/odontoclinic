<template>
    <div class="tab-pane fade show active" id="v-pills-datos" role="tabpanel" aria-labelledby="v-pills-datos-tab">
        <loading :active.sync="isLoading"
            :background-color="'#000'" 
            :color="'red'"
            :can-cancel="false" 
            :is-full-page="fullPage">
        </loading> 
        <div class="card card-with-nav pb-10">
            <div class="card-header">
                <div class="row">
                    <ul class="nav nav-tabs nav-line nav-color-danger" role="tablist">
                        <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#datos" role="tab" aria-selected="true">Datos Personales</a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#planes" role="tab" aria-selected="false" @click.prevent="CargaDatosTitular">Asignaciones / Planes</a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#dependientes" role="tab" aria-selected="false" @click.prevent="CargaDatosTitular">Dependientes</a> </li>
                        <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#derivaciones" role="tab" aria-selected="false" @click.prevent="CargaDatosTitular">Derivaciones</a> </li>
                    </ul>
                </div>
            </div>
            <div class="card-body">
                <div class="tab-content">
                    <div class="tab-pane active" id="datos" role="tabpanel" aria-labelledby="datos-tab">
                        <form role="form" method="PUT" v-on:submit.prevent="updatePaciente">                    
                            <div class="card-body mb-20">
                                <div class="row pr-20 pl-20">                                   
                                    <div class="col-12 pl-20 pr-20">
                                        <div class="row">
                                            <div class="col-12 pl-10">
                                                <p class="form-control-static text-primary font-weight-bold mb-10">Datos Personales</p>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group row pb-0 pt-0">
                                                    <label for="historia" class="col-4 pr-0 pl-0">Historia Clínica </label>
                                                    <div class="col-8 pr-0">
                                                        <input type="text" class="form-control form-control-sm border-odonto text-danger text-center font-weight-bold mb-0" id="edad" name="edad" v-model="dataPaciente.historiaclinica" disabled>                                                        
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group row pb-0 pt-0">
                                                    <label for="sede" class="col-4 pl-0">Sede </label>
                                                    <div class="col-8 pr-0">
                                                        <input type="text" class="form-control form-control-sm border-odonto text-danger text-center font-weight-bold mb-0" id="edad" name="edad" v-model="dataPaciente.sede.nombre_sede" disabled>                                                        
                                                    </div>
                                                </div>                                              
                                            </div>
                                        </div> 
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group row pt-5 pb-0">
                                                    <label for="tipodoc" class="col-4 pl-0">Tipo de Documento <span class="required-label"> *</span></label>
                                                    <div class="col-8 pr-0">
                                                        <select class="form-control form-control-sm border-odonto" id="tipodoc" v-model="dataPaciente.tipodocumento_id">
                                                            <option value="">-- Seleccione Tipo--</option>
                                                            <option v-for="tipo in getDocumentosIdentidad" :value="tipo.id" :key="tipo.id">
                                                                {{ tipo.nombre_tipodocumento}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>                                             
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group row pb-0 pt-5">
                                                    <label for="numdocumento" class="col-4 pl-0">Num.Documento <span class="required-label"> *</span></label>
                                                    <div class="col-8 pr-0">
                                                        <input type="text" class="form-control form-control-sm border-odonto" id="numdocumento" name="numdocumento" v-model="dataPaciente.numero_documento" maxlength="8">
                                                    </div>                                                
                                                </div>
                                            </div>                                           
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group row pb-0 pt-5">
                                                    <label for="apepat" class="col-4 pl-0">Apellido Paterno <span class="required-label"> *</span></label>
                                                    <div class="col-8 pr-0">
                                                        <input type="text" class="form-control form-control-sm border-odonto mayusculas" id="ape_paterno" name="ape_paterno" v-model="dataPaciente.apellido_paterno">
                                                    </div>                                                
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group row pb-0 pt-5">
                                                    <label for="apemat" class="col-4 pl-0">Apellido Materno <span class="required-label"> *</span></label>
                                                    <div class="col-8 pr-0">
                                                        <input type="text" class="form-control form-control-sm border-odonto mayusculas" id="ape_materno" name="numdocumento" v-model="dataPaciente.apellido_materno">
                                                    </div>                                                
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group row pb-0 pt-5">
                                                    <label for="nombres" class="col-4 pl-0">Nombres <span class="required-label"> *</span></label>
                                                    <div class="col-8 pr-0">
                                                        <input type="text" class="form-control form-control-sm border-odonto mayusculas" id="nombres" name="nombres" v-model="dataPaciente.nombres">
                                                    </div>                                                
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group row pt-5 pb-0">
                                                    <label for="tipodoc" class="col-4 pl-0">Sexo <span class="required-label"> *</span></label>
                                                    <div class="col-8 pr-0">
                                                        <select class="form-control form-control-sm border-odonto" id="sexo" v-model="dataPaciente.sexo">
                                                            <option value="">-- Seleccione Sexo--</option>
                                                            <option v-for="sexo in sexos" :value="sexo.id" :key="sexo.id">
                                                                {{ sexo.value}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group row pt-5 pb-0">
                                                    <label for="datepicker" class="col-4 pl-0">Fecha de Nacimiento</label>
                                                    <div class="col-8 pr-0">
                                                        <masked-input v-model="dataPaciente.fecha_nacimiento" mask="11-11-1111" placeholder="DD-MM-YYYY" class="form-control form-control-sm border-odonto"/>                                                                                                
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group row pt-5 pb-0">
                                                    <label for="sede" class="col-4 pl-0">Edad </label>
                                                    <div class="col-8 pr-0">
                                                        <input type="text" class="form-control form-control-sm border-odonto font-weight-bold" id="edad" name="edad" v-model="dataPaciente.edad" disabled>
                                                    </div>
                                                </div>  
                                            </div>
                                        </div>                                        
                                        <div class="row" v-if="menor_edad">
                                            <div class="col-6">
                                                <div class="form-group row pb-0 pt-5">
                                                    <label for="apoderado" class="col-4 pl-0">Apoderado </label>
                                                    <div class="col-8 pr-0">
                                                        <input type="text" class="form-control form-control-sm border-odonto mayusculas" id="apoderado" name="apoderado" v-model="dataPaciente.apoderado">
                                                    </div>                                                
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group row pt-5 pb-0">
                                                    <label for="tipodoc" class="col-4 pl-0">Parentesco </label>
                                                    <div class="col-8 pr-0">
                                                        <select class="form-control form-control-sm border-odonto" id="sexo" v-model="dataPaciente.parentesco_apoderado_id">
                                                            <option value="">-- Seleccione --</option>
                                                            <option v-for="parent in parentescos" :value="parent.id" :key="parent.id">
                                                                {{ parent.nombre_parentesco}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group row pb-0 pt-5">
                                                    <label for="telefono" class="col-4 pl-0">Teléfono </label>
                                                    <div class="col-8 pr-0">
                                                        <input type="text" class="form-control form-control-sm border-odonto mayusculas" id="telefono" name="telefono" v-model="dataPaciente.telefono" maxlength="7">
                                                    </div>                                                
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group row pb-0 pt-5">
                                                    <label for="celular" class="col-4 pl-0">Celular <span class="required-label"> *</span></label>
                                                    <div class="col-8 pr-0">
                                                        <input type="text" class="form-control form-control-sm border-odonto mayusculas" id="celular" name="celular" v-model="dataPaciente.celular" maxlength="9">
                                                    </div>                                                
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group row pb-0 pt-5">
                                                    <label for="email" class="col-4 pl-0">Email </label>
                                                    <div class="col-8 pr-0">
                                                        <input type="text" class="form-control form-control-sm border-odonto mayusculas" id="email" name="email" v-model="dataPaciente.email">
                                                    </div>                                                
                                                </div>
                                            </div>
                                            <div class="col-6">
                                                <div class="form-group row pt-5 pb-0">
                                                    <label for="estadocivil" class="col-4 pl-0">Estado Civil </label>
                                                    <div class="col-8 pr-0">
                                                        <select class="form-control form-control-sm border-odonto" id="estadocivil" v-model="dataPaciente.estadocivil_id">
                                                            <option value="">-- Seleccione --</option>
                                                            <option v-for="est in estadosciviles" :value="est.id" :key="est.id">
                                                                {{ est.nombre_estadocivil}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div> 
                                            </div>
                                        </div>                                                                                
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group row pt-5 pb-0">
                                                    <label for="captacion" class="col-4 pl-0">Captación <span class="required-label"> *</span></label>
                                                    <div class="col-8 pr-0">
                                                        <select class="form-control form-control-sm border-odonto" id="captacion" v-model="dataPaciente.motivocaptacion_id">
                                                            <option value="">-- Seleccione --</option>
                                                            <option v-for="cap in motivocaptaciones" :value="cap.id" :key="cap.id">
                                                                {{ cap.nombre_motivocaptacion}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="col-6" v-if="dataPaciente.motivocaptacion_id == 15">
                                                <div class="form-group row pt-5 pb-0">
                                                    <label for="convenio" class="col-4 pl-0">Convenios <span class="required-label"> *</span></label>
                                                    <div class="col-8 pr-0">
                                                        <select class="form-control form-control-sm border-odonto" id="convenio" v-model="dataPaciente.convenio_id">
                                                            <option value="">-- Seleccione --</option>
                                                            <option v-for="conv in convenios" :value="conv.id" :key="conv.id">
                                                                {{ conv.empresapaciente.razon_social}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="col-6"  v-if="dataPaciente.motivocaptacion_id == 3">
                                                <div class="form-group row pt-5 pb-0">
                                                    <label for="campania" class="col-4 pl-0">Campañas <span class="required-label"> *</span></label>
                                                    <div class="col-8 pr-0">
                                                        <select class="form-control form-control-sm border-odonto" id="campania" v-model="dataPaciente.campania_id">
                                                            <option value="">-- Seleccione --</option>
                                                            <option v-for="camp in campañas" :value="camp.id" :key="camp.id">
                                                                {{ camp.nombre_campania}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div> 
                                            </div>                                        
                                        </div>
                                        <div class="row">
                                            <div class="col-6">
                                                <div class="form-group row pb-0 pt-5">
                                                    <label for="num_mensajeria" class="col-4 pl-0">Nº Mensajeria </label>
                                                    <div class="col-8 pr-0">
                                                        <input type="text" class="form-control form-control-sm border-odonto mayusculas" name="telefono_mensajeria" v-model="dataPaciente.telefono_mensajeria" maxlength="9">
                                                    </div>                                                
                                                </div>                                            
                                            </div>                                                                                        
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group row pb-0 pt-5">
                                                    <label for="observaciones" class="col-2 pl-0">Observaciones </label>
                                                    <div class="col-10 pr-0 pl-12">
                                                        <input type="text" class="form-control form-control-sm border-odonto mayusculas" name="observaciones" v-model="dataPaciente.observaciones">
                                                    </div>                                                
                                                </div>
                                            </div>
                                        </div>                                        
                                        <div class="row pt-5">
                                            <div class="col-2 pl-10">
                                                <label for="direccion" class="pl-0">Depart./ Prov./ Dist.</label>
                                            </div>
                                            <div class="col-3 pr-0 pl-20">
                                                <div class="select2-input">
                                                    <select id="departamento" name="departamento" class="form-control form-control-sm border-odonto" v-model="coddepa" @change.prevent="cambioDepartamento">
                                                        <option value="">--Seleccione--</option>
                                                        <option v-for="depa in departamentos" :value="depa.coddepa" :key="depa.id">
                                                            {{ depa.descripcion}}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-4">
                                                <div class="select2-input">
                                                    <select id="provincia" name="provincia" class="form-control form-control-sm border-odonto" v-model="codprov" @change.prevent="cambioProvincia">
                                                        <option value="">--Seleccione--</option>
                                                        <option v-for="prov in provincias" :value="prov.codprov" :key="prov.id">
                                                            {{ prov.descripcion}}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="col-3 pr-10 pl-0">
                                                <div class="select2-input">
                                                    <select id="distrito" name="distrito" class="form-control form-control-sm border-odonto" v-model="dataPaciente.ubigeo_id" @change.prevent="cambioDistrito">
                                                        <option value="">--Seleccione--</option>
                                                        <option v-for="dist in distritos" :value="dist.id" :key="dist.id">
                                                            {{ dist.descripcion}}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="form-group row pb-0 pt-5">
                                                    <label for="direccion" class="col-2 pl-0">Dirección </label>
                                                    <div class="col-10 pr-0 pl-12">
                                                        <input type="text" class="form-control form-control-sm border-odonto mayusculas" name="direccion" v-model="dataPaciente.direccion">
                                                    </div>                                                
                                                </div>
                                            </div>
                                        </div>                                                                                                                                                          
                                    </div>
                                </div>
                            </div>
                            <div class="card-action pr-20 pt-20 pl-20">
                                <button type="submit" class="btn btn-primary float-right" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                                <button type="button" class="btn btn-success" @click.prevent="imprimirFicha"><span class="btn-label"><i class="la la-print"></i> Imprimir</span></button>                                
                            </div>
                        </form> 
                    </div>
                    <div class="tab-pane" id="planes" role="tabpanel" aria-labelledby="planes-tab">
                        <div class="card-body mb-20">
                            <div class="row pl-20 pr-20">
                                <div class="col-12 pl-20 pr-20">
                                    <div class="row">
                                        <div class="col-12 pl-10">
                                            <p class="form-control-static text-primary font-weight-bold mb-0">Asignación del Paciente</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group row pb-0 pt-5">
                                                <label for="medico" class="col-4 pl-0">Médico<span class="required-label"> *</span></label>
                                                <div class="col-8 pr-0">
                                                    <select class="form-control form-control-sm border-odonto" id="medico" v-model="dataPaciente.empleado_id">
                                                        <option value="">-- Seleccione --</option>
                                                        <option v-for="med in getMedicos" :value="med.id" :key="med.id">
                                                            {{ med.nombre_completo}}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>  
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group row pb-0 pt-5">
                                                <label for="asignacion" class="col-4 pl-0">Asignación<span class="required-label"> *</span></label>
                                                <div class="col-8 pr-0">
                                                    <select class="form-control form-control-sm border-odonto" id="asignacion" v-model="dataPaciente.asignacion_id">
                                                        <option value="">-- Seleccione --</option>
                                                        <option v-for="asig in asignaciones" :value="asig.id" :key="asig.id">
                                                            {{ asig.nombre_asignacion}}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>  
                                        </div>
                                    </div>                                       
                                    <div class="row">
                                        <div class="col-12 pl-10">
                                            <p class="form-control-static text-primary font-weight-bold mb-0">Asignación del Plan</p>
                                        </div>
                                    </div>                                        
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group row pb-0 pt-5">
                                                <label for="tipoplan" class="col-4 pl-0">Tipo Plan<span class="required-label"> *</span></label>
                                                <div class="col-8 pr-0">
                                                    <select class="form-control form-control-sm border-odonto" id="tipoplan" v-model="dataPaciente.tipo" @change="SelectTipoPlan">
                                                        <option value="">-- Seleccione --</option>
                                                        <option v-for="tip in tipoplanes" :value="tip.id" :key="tip.id">
                                                            {{ tip.value}}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>                                              
                                        </div> 
                                        <div class="col-6">
                                            <div class="form-group row pb-0 pt-5">
                                                <label for="plan" class="col-4 pl-0">{{ dataPaciente.tipo == 1 ? 'Elige Plan' : 'Aseguradora'}}<span class="required-label"> *</span></label>
                                                <div class="col-8 pr-0">
                                                    <select class="form-control form-control-sm border-odonto" id="plan" v-model="dataPaciente.plan_id"  @change="SelectPlan">
                                                        <option value="">-- Seleccione --</option>
                                                        <option v-for="pla in getPlanes" :value="pla.id" :key="pla.id">
                                                            {{ pla.descripcion}}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>                                              
                                        </div>                                                                                                                                                    
                                    </div>
                                    <div class="row" v-show="dataPaciente.tipo == 2">
                                        <div class="col-6">
                                            <div class="form-group row pb-0 pt-5">
                                                <label for="empresa" class="col-4 pl-0">Empresa<span class="required-label"> *</span></label>
                                                <div class="col-8 pr-0">
                                                    <select class="form-control form-control-sm border-odonto" id="empresa" v-model="dataPaciente.empresapaciente_id" @change="SelectEmpresa">
                                                        <option value="">-- Seleccione --</option>
                                                        <option v-for="emp in empresapacientesplanes" :value="emp.empresapaciente.id" :key="emp.empresapaciente.id">
                                                            {{ emp.empresapaciente.razon_social}}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>                                              
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group row pb-0 pt-5">
                                                <label for="poliza" class="col-4 pl-0">Poliza<span class="required-label"> *</span></label>
                                                <div class="col-8 pr-0">
                                                    <select class="form-control form-control-sm border-odonto" id="poliza" v-model="dataPaciente.poliza_id">
                                                        <option value="">-- Seleccione --</option>
                                                        <option v-for="pol in polizaspac" :value="pol.id" :key="pol.id">
                                                            {{ pol.codigo }} - {{pol.plane.descripcion }}-DED {{ pol.deducible }}-COAS {{ pol.coaseguro }} %- {{ pol.planpoliza.nombre_planpoliza}}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>                                                                                                                                                                               
                                    </div> 
                                </div>
                            </div>
                        </div>
                        <div class="card-action pr-20 pt-20 mb-30">
                            <button type="button" class="btn btn-primary float-right" :disabled="ShowIcon" @click.prevent="updatePlanesPaciente"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        </div>
                        <div class="clearfix"></div> 
                        <div class="row pl-20 pr-20">
                            <table class="table table-bordered table-sm table-head-bg-info table-bordered-bd-info">
                                <thead>
                                    <tr>
                                        <th scope="col">Item</th>
                                        <th scope="col">Fecha</th>
                                        <th scope="col">Tipo</th>
                                        <th scope="col">Plan</th>
                                        <th scope="col">Empresa_Paciente</th>
                                        <th scope="col">Poliza</th>
                                        <th scope="col">Usuario</th>                                                                                                                             
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr v-for="(seg, index) in SeguimientoPlanes" :key="seg.id">
                                        <td align="center"> {{ index + 1 }}</td>
                                        <td>{{ seg.fecha }}</td>
                                        <td>{{ seg.tipo == 1 ? 'PART.' : 'SEG.' }}</td> 
                                        <td>{{ seg.plan.descripcion }}</td>
                                        <td>{{ seg.tipo == 1 ? '-' : seg.empresapaciente.razon_social }}</td>
                                        <td align="center">{{ seg.tipo == 1 ? '-' : seg.poliza.codigo }}</td>  
                                        <td>{{ seg.user.__empleado.nombre_completo}}</td>                                                                                                                         
                                    </tr>
                                    <tr v-if="SeguimientoPlanes.length == 0">
                                        <td colspan="7" class="text-center">NO EXISTEN DATOS DE CAMBIOS ...</td>                                           
                                    </tr>
                                </tbody>
                            </table>                                
                        </div> 
                    </div>                      
                    <div class="tab-pane" id="dependientes" role="tabpanel" aria-labelledby="dependientes-tab">
                        <div class="row">
                            <div class="col-12">
                                <!-- START DEFAULT DATATABLE -->
                                <div class="card text-white bg-white mb-3">
                                    <div class="card-header">                        
                                        <div class="col pl-0 pr-0 pt-10">
                                            <button type="button" class="btn btn-primary float-right" @click.prevent="LoadFormDependiente"><span class="btn-label"><i class="flaticon-profile"></i></span> Agregar Familia / Dependiente</button>
                                            <button type="button" class="btn btn-success float-right mr-10" @click.prevent="LoadFormRelacionar"><span class="btn-label"><i class="flaticon-profile"></i></span> Relacionar Dependiente</button>
                                            <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                                        </div>                                                        
                                    </div>
                                    <div class="card-body">
                                        <div class="col-12 pt-10">
                                            <vue-good-table
                                            :columns="columns"
                                            :rows="dependientes"
                                            :paginationOptions="{
                                                enabled: true,
                                                dropdownAllowAll: false,
                                                nextLabel: 'Sig',
                                                prevLabel: 'Ant',
                                                rowsPerPageLabel: 'Registros por Pagina',
                                                ofLabel: 'de',
                                                allLabel: 'Todos',
                                            }"
                                            :rowStyleClass="'enlace'"
                                            :lineNumbers="true"
                                            styleClass="vgt-table condensed bordered striped">
                                                <template slot="table-row" slot-scope="props">
                                                    <span v-if="props.column.field == 'btn'" class="center">
                                                        <button type="button" v-tooltip="'Editar Dependiente'" class="btn btn-border btn-primary btn-xs" @click.prevent="processEdit(props.row)">
                                                            <i class="la la-file-text font-large"></i>
                                                        </button>                                                                
                                                        <button type="button" v-tooltip="'Eliminar Dependiente'" class="btn btn-border btn-danger btn-xs" @click.prevent="processDelete(props.row.id)">
                                                            <i class="la la-trash-o font-large"></i>
                                                        </button>                                
                                                    </span>
                                                    <span v-else>
                                                        {{props.formattedRow[props.column.field]}}
                                                    </span>
                                                </template>                                                         
                                            </vue-good-table>
                                        </div>

                                    </div>
                                </div>
                                <!-- END DEFAULT DATATABLE -->                                   
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="derivaciones" role="tabpanel" aria-labelledby="derivaciones-tab">  
                        <div class="row">
                            <div class="col-12">
                                <!-- START DEFAULT DATATABLE -->
                                <div class="card text-white bg-white mb-3">
                                    <div class="card-header">                        
                                        <div class="col pl-0 pr-0 pt-10">
                                            <button type="button" class="btn btn-primary float-right" @click.prevent="LoadFormDerivacion"><span class="btn-label"><i class="flaticon-repeat"></i></span> Agregar Derivación</button>
                                        </div>                                                        
                                    </div>
                                    <div class="card-body">
                                        <div class="col-12 pt-10">
                                            <vue-good-table
                                            :columns="columns_derivaciones"
                                            :rows="derivaciones"
                                            :paginationOptions="{
                                                enabled: true,
                                                dropdownAllowAll: false,
                                                nextLabel: 'Sig',
                                                prevLabel: 'Ant',
                                                rowsPerPageLabel: 'Registros por Pagina',
                                                ofLabel: 'de',
                                                allLabel: 'Todos',
                                            }"
                                            @on-row-dblclick="processEdit"
                                            :rowStyleClass="'enlace'"
                                            :lineNumbers="true"
                                            styleClass="vgt-table condensed bordered striped">
                                                <template slot="table-row" slot-scope="props">
                                                    <span v-if="props.column.field == 'btn'" class="center">                               
                                                        <button type="button" class="btn btn-border btn-success btn-xs" v-tooltip="'Editar Derivación'" @click.prevent="processEditDerivacion(props)">
                                                            <i class="la la-edit font-large"></i>
                                                        </button>                                
                                                    </span>
                                                    <span v-else-if="props.column.field == 'indicador'">
                                                        <span v-if="props.row.indicador == 1" class="center badge badge-danger">{{ 'DERIVADO' }}</span>
                                                        <span v-if="props.row.indicador == 2" class="center badge badge-primary">{{ 'RECIBIDO' }}</span>
                                                        <span v-if="props.row.indicador == 3" class="center badge badge-warnning">{{ 'DEVUELTO'}}</span>
                                                    </span>
                                                    <span v-else>
                                                        {{props.formattedRow[props.column.field]}}
                                                    </span>
                                                </template>                                                         
                                            </vue-good-table>
                                        </div>
                                    </div>
                                </div>
                                <!-- END DEFAULT DATATABLE --> 
                            </div>
                        </div>
                    </div>                                    
                </div>                            
            </div>
        </div> 
        <!-- Modal de Creacion de dependientes -->
        <modal name="dependiente" :width="'80%'" height="auto" transition="pop-out" :scrollable="true" :clickToClose="false" @opened="openedFn()">
            <!-- form de registro de dependientes -->
                <div class="card mb-0">
                    <div class="card-header bg-primary pt-10 pb-10">
                        <div class="card-title text-white">{{ labelAccion }} de Dependiente</div>
                    </div>
                    <form role="form" method="POST" v-on:submit.prevent="actionDependiente">                    
                        <div class="card-body">
                            <div class="row pr-10 pl-10">
                                <div class="col-md-3">
                                    <div class="card card-profile card-primary">
                                        <div class="card-header">
                                            <div class="profile-picture">
                                                <img v-if="dataDependiente.image" :src="dataDependiente.image" alt="Imagen de Perfil">
                                                <img v-if="!dataDependiente.image" :src="'/images/pacientes/' + dataDependiente.foto" alt="Imagen de Perfil">                                                
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="user-profile text-center pt-20">
                                                <div class="name text-danger text-center font-weight-bold">{{ dataDependiente.historiaclinica }}</div>
                                                <div class="job">{{ dataDependiente.nombre_completo }}</div>
                                                <div class="desc">{{ dataDependiente.numero_documento}}</div>                                                
                                                <div class="view-profile">
                                                    <input type="file" class="form-control form-control-file" id="uploadImgDep" name="uploadImgDep" accept="image/*" @change="onFileChangeDep" >
                                                    <label for="uploadImgDep" class=" label-input-file text-white btn btn-sm btn-icon btn-info"><i class="la la-file-image-o"></i> Cargar Imagen</label>
                                                </div>
                                                <div class="seperator-solid"></div>                                                
                                            </div>
                                        </div>
                                        <div class="card-footer pl-10 pr-10">
											<div class="nav flex-column nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
												<a class="nav-link border-odonto active" id="v-pills-datosdep-tab" data-toggle="pill" href="#v-pills-datosdep" role="tab" aria-controls="v-pills-datosdep" aria-selected="true">Datos Personales</a>
												<a class="nav-link border-odonto" id="v-pills-planesdep-tab" data-toggle="pill" href="#v-pills-planesdep" role="tab" aria-controls="v-pills-planesdep" aria-selected="false">Asignaciones / Planes</a>
											</div>                                            
                                        </div>                                        
                                    </div>
                                </div>                                    
                                <div class="col-9">
                                    <div class="tab-content" id="v-pills-tabContent">
                                        <div class="tab-pane fade show active" id="v-pills-datosdep" role="tabpanel" aria-labelledby="v-pills-datosdep-tab">
                                            <div class="row">
                                                <div class="col-12">
                                                    <p class="form-control-static text-info font-weight-bold">Datos Personales</p>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group row pt-5 pb-0">
                                                        <label for="parentesco" class="col-4">Parentesco <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <select class="form-control form-control-sm border-odonto" id="parentesco" v-model="dataDependiente.parentesco_id">
                                                                <option value="">-- Seleccione --</option>
                                                                <option v-for="par in parentescos" :value="par.id" :key="par.id">
                                                                    {{ par.nombre_parentesco}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>                                             
                                                </div>                                        
                                                <div class="col-6">
                                                    <div class="form-group row pt-5 pb-0">
                                                        <label for="tipodoc" class="col-4">Tipo Documento <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <select class="form-control form-control-sm border-odonto" id="tipodoc" v-model="dataDependiente.tipodocumento_id">
                                                                <option value="">-- Seleccione Tipo--</option>
                                                                <option v-for="tipo in getDocumentosIdentidad" :value="tipo.id" :key="tipo.id">
                                                                    {{ tipo.nombre_tipodocumento}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>                                             
                                                </div>                                                                                 
                                            </div>                                        
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="numdocumento" class="col-4">Num.Documento <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto" id="numdocumento" name="numdocumento" v-model="dataDependiente.numero_documento" maxlength="8">
                                                        </div>                                                
                                                    </div>
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="apepat" class="col-4">Apellido Paterno <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto mayusculas" id="ape_paterno" name="apepat" v-model="dataDependiente.apellido_paterno">
                                                        </div>                                                
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="apemat" class="col-4">Apellido Materno <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto mayusculas" id="ape_materno" name="apemat" v-model="dataDependiente.apellido_materno">
                                                        </div>                                                
                                                    </div>
                                                </div>                                                                                  
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="nombres" class="col-4">Nombres <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto mayusculas" id="nombres" name="nombres" v-model="dataDependiente.nombres">
                                                        </div>                                                
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group row pt-5 pb-0">
                                                        <label for="sexo" class="col-4">Sexo <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <select class="form-control form-control-sm border-odonto" id="sexo" v-model="dataDependiente.sexo">
                                                                <option value="">-- Seleccione Sexo--</option>
                                                                <option v-for="sexo in sexos" :value="sexo.id" :key="sexo.id">
                                                                    {{ sexo.value}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div> 
                                                </div>                                                                                     
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group row pt-5 pb-0">
                                                        <label for="datepicker" class="col-4">Fecha Nacimiento</label>
                                                        <div class="col-8 pr-0">
                                                            <masked-input v-model="dataDependiente.fecha_nacimiento" mask="11-11-1111" placeholder="DD-MM-YYYY" class="form-control form-control-sm border-odonto"/>                                                                                                
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group row pt-5 pb-0">
                                                        <label for="sede" class="col-4">Edad </label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto" id="edad" name="edad" v-model="dataDependiente.edad" disabled>
                                                        </div>
                                                    </div>  
                                                </div>
                                            </div>
                                            <div class="row"> 
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="telefono" class="col-4">Teléfono </label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto" id="telefono" name="telefono" v-model="dataDependiente.telefono" maxlength="7">
                                                        </div>                                                
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="celular" class="col-4">Celular <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto" id="celular" name="celular" v-model="dataDependiente.celular" maxlength="9">
                                                        </div>                                                
                                                    </div>
                                                </div>                                                                                        
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="num_mensajeria" class="col-4">Nº Mensajeria </label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto" name="telefono_mensajeria" v-model="dataDependiente.telefono_mensajeria" maxlength="9">
                                                        </div>                                                
                                                    </div>                                            
                                                </div>                                         
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="email" class="col-4">Email </label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto" id="email" name="email" v-model="dataDependiente.email">
                                                        </div>                                                
                                                    </div>
                                                </div>                                         
                                            </div>
                                            <div class="row"> 
                                                <div class="col-6">
                                                    <div class="form-group row pt-5 pb-0">
                                                        <label for="estadocivil" class="col-4">Estado Civil </label>
                                                        <div class="col-8 pr-0">
                                                            <select class="form-control form-control-sm border-odonto" id="estadocivil" v-model="dataDependiente.estadocivil_id">
                                                                <option value="">-- Seleccione --</option>
                                                                <option v-for="est in estadosciviles" :value="est.id" :key="est.id">
                                                                    {{ est.nombre_estadocivil}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="carnet" class="col-4">Nº Carnet </label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto mayusculas" name="carnet" v-model="dataDependiente.numero_carnet">
                                                        </div>                                                
                                                    </div>                                            
                                                </div>                                                                                                                                                                    
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group row pt-5 pb-0">
                                                        <label for="captacion" class="col-4">Captación <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <select class="form-control form-control-sm border-odonto" id="captacion" v-model="dataDependiente.motivocaptacion_id">
                                                                <option value="">-- Seleccione --</option>
                                                                <option v-for="cap in motivocaptaciones" :value="cap.id" :key="cap.id">
                                                                    {{ cap.nombre_motivocaptacion}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div> 
                                                </div> 
                                                <div class="col-6" v-if="dataPaciente.motivocaptacion_id == 15">
                                                    <div class="form-group row pt-5 pb-0">
                                                        <label for="convenio" class="col-4">Convenios <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <select class="form-control form-control-sm border-odonto" id="convenio" v-model="dataDependiente.convenio_id">
                                                                <option value="">-- Seleccione --</option>
                                                                <option v-for="conv in convenios" :value="conv.id" :key="conv.id">
                                                                    {{ conv.empresapaciente.razon_social}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <div class="col-6"  v-if="dataPaciente.motivocaptacion_id == 3">
                                                    <div class="form-group row pt-5 pb-0">
                                                        <label for="campania" class="col-4">Campañas <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <select class="form-control form-control-sm border-odonto" id="campania" v-model="dataDependiente.campania_id">
                                                                <option value="">-- Seleccione --</option>
                                                                <option v-for="camp in campañas" :value="camp.id" :key="camp.id">
                                                                    {{ camp.nombre_campania}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div>
                                            <div class="row">  
                                                <div class="col-12">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="observaciones" class="col-2">Observaciones </label>
                                                        <div class="col-10 pr-0 pl-12">
                                                            <input type="text" class="form-control form-control-sm border-odonto mayusculas" name="observaciones" v-model="dataDependiente.observaciones">
                                                        </div>                                                
                                                    </div>
                                                </div>                                                                                                                                                                    
                                            </div>
                                            <div class="row pt-5">
                                                <div class="col-2 pl-10">
                                                    <label for="direccion">Depart./ Prov./ Dist.</label>
                                                </div>
                                                <div class="col-3 pr-0 pl-20">
                                                    <div class="select2-input">
                                                        <select id="departamento" name="departamento" class="form-control form-control-sm border-odonto" v-model="coddepa">
                                                            <option value="">--Seleccione--</option>
                                                            <option v-for="depa in departamentos" :value="depa.coddepa" :key="depa.id">
                                                                {{ depa.descripcion}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-4">
                                                    <div class="select2-input">
                                                        <select id="provincia" name="provincia" class="form-control form-control-sm border-odonto" v-model="codprov">
                                                            <option value="">--Seleccione--</option>
                                                            <option v-for="prov in provincias" :value="prov.codprov" :key="prov.id">
                                                                {{ prov.descripcion}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-3 pr-10 pl-0">
                                                    <div class="select2-input">
                                                        <select id="distrito" name="distrito" class="form-control form-control-sm border-odonto" v-model="dataDependiente.ubigeo_id">
                                                            <option value="">--Seleccione--</option>
                                                            <option v-for="dist in distritos" :value="dist.id" :key="dist.id">
                                                                {{ dist.descripcion}}
                                                            </option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="direccion" class="col-2">Dirección </label>
                                                        <div class="col-10 pr-0 pl-12">
                                                            <input type="text" class="form-control form-control-sm border-odonto mayusculas" name="direccion" v-model="dataDependiente.direccion">
                                                        </div>                                                
                                                    </div>
                                                </div>                                        
                                            </div>                                            
                                        </div>
                                        <div class="tab-pane fade" id="v-pills-planesdep" role="tabpanel" aria-labelledby="v-pills-planesdep-tab">
                                            <div class="row">
                                                <div class="col-12 pl-0">
                                                    <p class="form-control-static text-info font-weight-bold mb-0">Asignación del Paciente</p>
                                                </div>
                                            </div>                                        
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="medico" class="col-4">Médico<span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <select class="form-control form-control-sm border-odonto" id="medico" v-model="dataDependiente.empleado_id">
                                                                <option value="">-- Seleccione --</option>
                                                                <option v-for="med in getMedicos" :value="med.id" :key="med.id">
                                                                    {{ med.nombre_completo}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>  
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="asignacion" class="col-4">Asignación<span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <select class="form-control form-control-sm border-odonto" id="asignacion" v-model="dataDependiente.asignacion_id">
                                                                <option value="">-- Seleccione --</option>
                                                                <option v-for="asig in asignaciones" :value="asig.id" :key="asig.id">
                                                                    {{ asig.nombre_asignacion}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>  
                                                </div>
                                            </div> 
                                            <div class="row">
                                                <div class="col-12 pl-0">
                                                    <p class="form-control-static text-info font-weight-bold mb-0">Asignación del Plan</p>
                                                </div>
                                            </div>                                        
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="tipoplan" class="col-4">Tipo Plan<span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <select class="form-control form-control-sm border-odonto" id="tipoplan" v-model="dataDependiente.tipo" @change="SelectTipoPlanDep">
                                                                <option value="">-- Seleccione --</option>
                                                                <option v-for="tip in tipoplanes" :value="tip.id" :key="tip.id">
                                                                    {{ tip.value}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>                                              
                                                </div> 
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="plan" class="col-4">{{ dataDependiente.tipo == 1 ? 'Elige Plan' : 'Aseguradora'}}<span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <select class="form-control form-control-sm border-odonto" id="plan" v-model="dataDependiente.plan_id"  @change="SelectPlanDep">
                                                                <option value="">-- Seleccione --</option>
                                                                <option v-for="pla in getPlanesDep" :value="pla.id" :key="pla.id">
                                                                    {{ pla.descripcion}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>                                              
                                                </div>                                                                                                                                                                            
                                            </div>
                                            <div class="row" v-show="dataDependiente.tipo == 2">
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="empresa" class="col-4">Empresa<span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <select class="form-control form-control-sm border-odonto" id="empresa" v-model="dataDependiente.empresapaciente_id" @change="SelectEmpresaDep">
                                                                <option value="">-- Seleccione --</option>
                                                                <option v-for="emp in empresapacientesplanes" :value="emp.empresapaciente.id" :key="emp.empresapaciente.id">
                                                                    {{ emp.empresapaciente.razon_social}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>                                              
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="poliza" class="col-4">Poliza<span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <select class="form-control form-control-sm border-odonto" id="poliza" v-model="dataDependiente.poliza_id">
                                                                <option value="">-- Seleccione --</option>
                                                                <option v-for="pol in polizaspac" :value="pol.id" :key="pol.id">
                                                                    {{ pol.codigo }} - {{pol.plane.descripcion }}-DED {{ pol.deducible }}-COAS {{ pol.coaseguro }} %- {{ pol.planpoliza.nombre_planpoliza}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>                                                                                                                                                                                                                                                                                                                                                             
                                            </div>                                         
                                        </div>
                                    </div>                                                                                                                                                          
                                </div>
                            </div>
                        </div>
                        <div class="card-action pt-10 mb-20">
                            <button class="btn btn-danger float-right ml-10" @click.prevent="$modal.hide('dependiente')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                            <button type="submit" class="btn btn-primary float-right" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        </div>
                    </form>                    
                </div>
            <!-- /. form de registro de dependientes -->
        </modal> 
        <!-- PAGE CONTENT MODAL -->  
        <modal name="relacionar" :width="'40%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de campañas -->
                <div class="card mb-0">
                    <div class="card-header bg-primary pt-5 pb-5">
                        <div class="card-title text-white"> Relacionar Familiares / Dependientes </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <label for="basic" class="text-primary font-weight-bold pb-10">Paciente <span class="required-label"> *</span></label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control text-primary font-weight-bold" placeholder="Nombre de Paciente" aria-label="Recipient's username" aria-describedby="button-addon2" v-model="nom_pac" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-danger mr-5" type="button" id="button-addon2" @click.prevent="$modal.show('pacientesdep')"><span class="btn-label"><i class="flaticon-multimedia"></i></span></button>
                                    </div>
                                </div>                           
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group form-group-default border border-primary">
                                    <label for="tipodoc" class="text-primary font-weight-bold">Parentesco <span class="required-label"> *</span></label>
                                    <select class="form-control form-control-sm" id="tipodoc" v-model="dataRelDep.parentesco_id">
                                        <option value="">-- Seleccione --</option>
                                        <option v-for="par in parentescos" :value="par.id" :key="par.id">
                                            {{ par.nombre_parentesco}}
                                        </option>
                                    </select>
                                </div>  
                            </div>                         
                        </div>                                                                         
                    </div>
                    <div class="card-action pr-20">
                        <button class="btn btn-danger float-right ml-10" @click="$modal.hide('relacionar')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                        <button class="btn btn-primary float-right" @click.prevent="createRelacion" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                    </div>
                </div>
            <!-- /. form de registro de campañas -->
        </modal>         
        <modal name="pacientesdep" :width="'60%'" height="auto" transition="pop-out" :scrollable="true" :clickToClose="false" >
           <div class="card mb-0">
                <div class="card-header bg-primary pt-5 pb-5">
                    <div class="card-title d-inline text-white">Seleccione un Paciente</div>
                    <button type="button" class="close d-inline" aria-label="Close" @click.prevent="$modal.hide('pacientesdep')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                     <div class="col">
                        <!-- START DEFAULT DATATABLE -->
                        <vue-good-table
                        :columns="columns_pacientes"
                        :rows="pacientes"
                        :paginationOptions="{
                            enabled: true,
                            dropdownAllowAll: false,
                            nextLabel: 'Sig',
                            prevLabel: 'Ant',
                            rowsPerPageLabel: 'Registros por Pagina',
                            ofLabel: 'de',
                            allLabel: 'Todos',
                        }"
                        :rowStyleClass="'enlace'"
                        @on-row-click="selectPaciente"
                        max-height="400px"
                        styleClass="vgt-table condensed bordered striped"> 
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'btn'" class="center">
                                <button type="button" data-toggle="tooltip" title="" class="btn btn-primary btn-xs" data-original-title="" @click.prevent="selectPaciente(props)">
                                    Seleccionar
                                </button>                                                               
                            </span>
                            <span v-else>
                                {{props.formattedRow[props.column.field]}}
                            </span>
                        </template>                                                    
                        </vue-good-table>
                        <!-- END DEFAULT DATATABLE -->  
                     </div>
                </div>
            </div>                                
        </modal> 
        <!-- form para seleccionar el servicio -->
        <modal id="servicios" name="servicios" width="50%" height="auto" :scrollable="true" :clickToClose="false">
            <div class="card mb-0">
                <div class="card-header">
                    <div class="card-title d-inline">Seleccione un Tratamiento</div>
                    <button type="button" class="close d-inline" aria-label="Close" @click.prevent="$modal.hide('servicios')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                     <div class="col">
                        <!-- START DEFAULT DATATABLE -->
                        <vue-good-table
                        :columns="columns_servicios"
                        :rows="servicios"
                        :paginationOptions="{
                            enabled: true,
                            dropdownAllowAll: false,
                            nextLabel: 'Sig',
                            prevLabel: 'Ant',
                            rowsPerPageLabel: 'Registros por Pagina',
                            ofLabel: 'de',
                            allLabel: 'Todos',
                        }"
                        :rowStyleClass="'enlace'"
                        @on-row-click="selectServicio"
                        max-height="400px"
                        styleClass="vgt-table condensed bordered striped"> 
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'btn'" class="center">
                                <button type="button" data-toggle="tooltip" title="" class="btn btn-primary btn-xs" data-original-title="" @click.prevent="selectServicio(props)">
                                    Seleccionar
                                </button>                                                               
                            </span>
                            <span v-else>
                                {{props.formattedRow[props.column.field]}}
                            </span>
                        </template>                                                    
                        </vue-good-table>
                        <!-- END DEFAULT DATATABLE -->  
                     </div>
                </div>
            </div>                                
        </modal>          
        <!-- PAGE CONTENT MODAL -->  
        <modal name="derivacion" :width="'50%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de campañas -->
                <div class="card mb-0">
                    <div class="card-header bg-primary pt-10 pb-10">
                        <div class="card-title text-white">{{ labelAccion }} Derivación</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group form-group-default border border-primary">
                                    <label for="tipodoc" class="text-primary font-weight-bold">Dr. que deriva : <span class="required-label"> *</span></label>
                                    <select class="form-control form-control-sm" id="tipodoc" v-model="dataDerivacion.empleadoderivante_id">
                                        <option value="">-- Seleccione --</option>
                                        <option v-for="med in getMedicos" :value="med.id" :key="med.id">
                                            {{ med.nombre_completo}}
                                        </option>
                                    </select>
                                </div>                             
                            </div>
                            <div class="col-6">
                                <div class="form-group form-group-default border border-primary">
                                    <label for="tipodoc" class="text-primary font-weight-bold">Deriva a : <span class="required-label"> *</span></label>
                                    <select class="form-control form-control-sm" id="tipodoc" v-model="dataDerivacion.empleadoderivado_id">
                                        <option value="">-- Seleccione --</option>
                                        <option v-for="med in getMedicos" :value="med.id" :key="med.id">
                                            {{ med.nombre_completo}}
                                        </option>
                                    </select>
                                </div>                             
                            </div>                                                        
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <label for="basic" class="text-primary font-weight-bold pb-10">Tratamiento :</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control text-primary font-weight-bold" placeholder="Nombre de Tratamiento" aria-label="Recipient's username" aria-describedby="button-addon2" v-model="nom_ser" readonly>
                                    <div class="input-group-append">
                                        <button class="btn btn-danger mr-5" type="button" id="button-addon2" @click.prevent="$modal.show('servicios')"><span class="btn-label"><i class="flaticon-multimedia"></i></span></button>
                                    </div>
                                </div>                           
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group pt-0 pl-0 pr-0">
                                    <label for="motivo" class="text-primary font-weight-bold">Motivo <span class="required-label"> *</span></label>
                                    <textarea class="form-control form-control-sm border border-primary" id="comment" rows="3" v-model="dataDerivacion.motivo">

                                    </textarea>
                                </div>                                
                            </div>
                        </div>                                          
                    </div>
                    <div class="card-action pt-15 pb-15 pr-20">
                        <button class="btn btn-danger float-right ml-10" @click="$modal.hide('derivacion')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                        <button class="btn btn-primary float-right" @click.prevent="ActionDerivacion" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                    </div>
                </div>
            <!-- /. form de registro de campañas -->
        </modal>                       
    </div>
</template>
<script>
import mixin from '../../../mixins.js'
import  {_} from 'vue-underscore'
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'datos',
    mixins: [mixin], 
    created() {
        this.CargaDatosTitular()
    }, 
    mounted(){   
        this.$store.dispatch('LOAD_SERVICIOS_LIST')     
        this.$store.dispatch('LOAD_SEDES_LIST')      
        this.$store.dispatch('LOAD_EMPLEADOS_LIST')   
        this.$store.dispatch('LOAD_PLANES_LIST')    
        this.$store.dispatch('LOAD_POLIZAS_LIST')   
        this.$store.dispatch('LOAD_DERIVACIONES_LIST') 
        this.$store.dispatch('LOAD_DEPENDIENTES_LIST')  
        this.$store.dispatch('LOAD_SEGUIMIENTO_PLANES_LIST') 
        this.$store.dispatch('LOAD_CAMPAÑAS_LIST')  
        this.$store.dispatch('LOAD_CONVENIOS_LIST')     
        this.$store.dispatch('LOAD_DATA_INIT_PACIENTES_LIST').then(() => {
            this.isLoading = false
        })        
    },          
    data(){
        return {
            isLoading: true,
            fullPage: true,

            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos', 
            labelAccion:'',

            coddepa:'',
            codprov:'',
            coddist:'', 
            columns: [
                {
                label: 'Doc',
                field: 'pacientedependiente.tipodocumento.abreviatura',
                width:'8%',
                }, 
                {
                label: 'Número',
                field: 'pacientedependiente.numero_documento',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },             
                width:'10%',
                },
                
                {
                label: 'Dependiente',
                field: 'pacientedependiente.nombre_completo',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },                 
                width:'45%',
                }, 
                {
                label: 'Parentesco',
                field: 'parentesco.nombre_parentesco',
                width:'20%',
                },                                                                                                                                                                                                                                       
                {
                label: 'Acción',
                field: 'btn',
                thClass: 'center',
                tdClass: 'center',
                html: true  ,
                width:'17%',  
                }                               
            ],
            columns_pacientes: [
                {
                label: 'Doc',
                field: 'tipodocumento.abreviatura',
                width:'8%',
                }, 
                {
                label: 'Número',
                field: 'numero_documento',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },             
                width:'10%',
                },
                
                {
                label: 'Paciente',
                field: 'nombre_completo',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },                 
                width:'57%',
                },                                                                                                                                                                                                                                       
                {
                label: 'Acción',
                field: 'btn',
                thClass: 'center',
                tdClass: 'center',
                html: true  ,
                width:'25%',  
                }                               
            ],            
            dataPaciente: {
                tipodocumento_id:'',
                numero_documento:'',
                sede_id:'',
                nombres:'',
                apellido_paterno:'',
                apellido_materno:'',
                fecha_nacimiento:'',
                sexo:'',
                ubigeo_id:'',
                direccion:'',
                telefono:'',
                celular:'',                
                email:'',                
                estadocivil_id:'',
                motivocaptacion_id:'',
                telefono_mensajeria:'',
                titular:'',
                mensajeria:'',
                foto:'',
                condicion_id:'',
                empleado_id:'',
                asignacion_id:'',
                fecha_ingreso:'',
                nombre_completo:'',
                carnet:'',
                convenio_id:'',
                campania_id:'',
                historiaclinica:'',
                observacion:'',
                apoderado:'',
                parentesco_apoderado_id:'',
                historial:'',
                user_id:'',
                tipo:'' ,
                plan_id:'',
                pacienteplanid:'',
                empresapaciente_id:'',
                poliza_id:'',
                descripcion:'',
                image:'',
                edad:''
            }, 
            dataDependiente: {
                tipodocumento_id:'',
                numero_documento:'',
                sede_id:'',
                nombres:'',
                apellido_paterno:'',
                apellido_materno:'',
                fecha_nacimiento:'',
                sexo:'',
                ubigeo_id:'',
                direccion:'',
                telefono:'',
                celular:'',                
                email:'',                
                estadocivil_id:'',
                motivocaptacion_id:'',
                telefono_mensajeria:'',
                titular:'',
                mensajeria:'',
                foto:'no-image.jpg',
                condicion_id:'',
                empleado_id:'',
                asignacion_id:'',
                fecha_ingreso:'',
                nombre_completo:'',
                carnet:'',
                convenio_id:'',
                campania_id:'',
                historiaclinica:'',
                observacion:'',
                apoderado:'',
                parentesco_apoderado_id:'',
                historial:'',
                user_id:'',
                tipo:'' ,
                plan_id:'',
                empresapaciente_id:'',
                poliza_id:'',         
                descripcion:'',
                image:'',
                edad:'',
                parentesco_id:''
            },
            dataRelDep:{
                pacientetitular_id:'',
                pacientedependiente_id:'',
                parentesco_id:''
            },
            sexos :[
                { id : 'H' , value : 'Hombre'},
                { id : 'M' , value : 'Mujer'}
            ], 
            tipoplanes:[
                {id: 1 , value : 'PLANES MULTIDENT'},
                {id: 2 , value : 'SEGUROS'}
            ], 
            getPlanes:[], 
            polizaspac:[],  
            getPlanesDep:[], 
            polizaspacDep:[],
            nom_pac:[],
            menor_edad:false,  
            
            // Derivaciones
            columns_derivaciones: [
                {
                label: 'Doctor que deriva',
                field: 'empleadoderivante.nombre_completo',
                width:'32%',
                }, 
                {
                label: 'Derivado a',
                field: 'empleadoderivado.nombre_completo',             
                width:'25%',
                },
                
                {
                label: 'Fec. Registro',
                field: 'fecha_registro',   
                type: 'date',
                dateInputFormat: 'YYYY-MM-DD', 
                dateOutputFormat: 'DD-MM-YYYY', 
                thClass:'center',
                tdClass:'center',                             
                width:'18%',
                }, 
                {
                label: 'Estado',
                field: 'indicador',
                thClass:'center',
                tdClass:'center',                 
                width:'15%',
                },                                                                                                                                                                                                                                       
                {
                label: 'Acción',
                field: 'btn',
                thClass: 'center',
                tdClass: 'center',
                html: true  ,
                width:'10%',  
                }                               
            ],
            columns_servicios: [
                {
                label: 'Tratamiento',
                field: 'nombre_servicio',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },                
                width:'75%',
                },                                                                                                                                                                                                                                                       
                {
                label: 'Acción',
                field: 'btn',
                thClass: 'center',
                tdClass: 'center',
                html: true  ,
                width:'25%',  
                }                               
            ], 
            dataDerivacion: {
                empleadoderivante_id:'',
                empleadoderivado_id:'',
                paciente_id:'',
                servicio_id:'',
                user_id:'',
                fecha_registro:'',
                indicador:1
            },
            nom_ser:'',
            // fin derivaciones
            // asignaciones / planes
            dataPlanesPac: {                 
                paciente_id:'',
                empleado_id:'',
                asignacion_id:'', 
                pacienteplanid: '',
                tipo:'',
                plan_id:'',
                empresapaciente_id:'',
                poliza_id:'',
                descripcion: '',
                user_id:'',
                cambio_planes: 0
            }, 
            dataPlanesPacAnt: {
                paciente_id:'',
                empleado_id:'',
                asignacion_id:'', 
                pacienteplanid: '',
                tipo:'',
                plan_id:'',
                empresapaciente_id:'',
                poliza_id:'',
                descripcion: '',
                user_id:''
            }          

        }
    },
    computed: {
        ...mapState(['user_system','tipodocumentos','estadosciviles','sedes','motivocaptaciones','asignaciones','parentescos','empresapacientesplanes','planes','polizas','pacientes','convenios','derivaciones','servicios','campañas']),
        ...mapGetters(['getubigeos','getMedicos','getDocumentosIdentidad','getplanes_aseguradoras','getPolizas','getPacienteById','getDependientesById','getSeguimientoPlanesbyPaciente']),
        departamentos: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.codprov == '00').filter((ubigeo) => ubigeo.coddist == '00');
        },
        provincias: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.coddepa == this.coddepa).filter((ubigeo) => ubigeo.codprov != '00').filter((ubigeo) => ubigeo.coddist == '00');
        },
        distritos: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.coddepa == this.coddepa).filter((ubigeo) => ubigeo.codprov == this.codprov).filter((ubigeo) => ubigeo.coddist != '00');
        },             
        PacienteById(){
            return this.getPacienteById(this.$route.params.idpaciente)
        },    
        dependientes(){
            return this.getDependientesById(this.$route.params.idpaciente)
        },
        SeguimientoPlanes(){
            return this.getSeguimientoPlanesbyPaciente(this.$route.params.idpaciente)
        }                                           
    },
    watch: {
        'dataPaciente.fecha_nacimiento' (newVal,oldVal) {
            if(moment(newVal,'DD-MM-YYYY',true).isValid()){
                this.dataPaciente.edad = moment().diff(moment(newVal, "DD-MM-YYYY"), 'years')
            }            
        },
        'dataPaciente.celular'(newVal,oldVal){
            this.dataPaciente.telefono_mensajeria = newVal
        },
        'dataPaciente.tipo' (newVal,oldVal){
            this.getPlanes = this.planes.filter((pla) => pla.tipo == newVal)
        },
        'dataPaciente.plan_id' (newVal,oldVal){
            this.SelectPlan()
        },
        'dataPaciente.empresapaciente_id' (newVal,oldVal){
            this.polizaspac = this.getPolizas(this.dataPaciente.empresapaciente_id,this.dataPaciente.plan_id)       
        },
        'dataPaciente.edad' (newVal,oldVal) { 
            if(newVal < 18){
                this.menor_edad = true
            }else{
                this.menor_edad = false
            }
        },         
        'dataDependiente.fecha_nacimiento' (newVal,oldVal) {
            if(moment(newVal,'DD-MM-YYYY',true).isValid()){
                this.dataDependiente.edad = moment().diff(moment(newVal, "DD-MM-YYYY"), 'years')
            }            
        },
        'dataDependiente.celular'(newVal,oldVal){
            this.dataDependiente.telefono_mensajeria = newVal
        },
        'dataDependiente.tipo' (newVal,oldVal){
            this.getPlanesDep = this.planes.filter((pla) => pla.tipo == newVal)
        },
        'dataDependiente.empresapaciente_id' (newVal,oldVal){
            this.polizaspacDep = this.getPolizas(this.dataDependiente.empresapaciente_id,this.dataDependiente.plan_id)       
        }
    }, 
    components: {
      MaskedInput 
    }, 
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },
        CargaDatosTitular(){
            if(typeof this.PacienteById != 'undefined'){
                var datos = []
                datos = _.clone(this.PacienteById)
                this.dataPaciente = {
                    id:datos.id,
                    tipodocumento_id:datos.tipodocumento_id,
                    numero_documento:datos.numero_documento,
                    sede_id:datos.sede_id,
                    nombres:datos.nombres,
                    apellido_paterno:datos.apellido_paterno,
                    apellido_materno:datos.apellido_materno,
                    fecha_nacimiento:datos.fecha_nacimiento,
                    sexo:datos.sexo,
                    ubigeo_id:datos.ubigeo_id,
                    direccion:datos.direccion,
                    telefono:datos.telefono,
                    celular:datos.celular,                
                    email:datos.email,                
                    estadocivil_id:datos.estadocivil_id,
                    motivocaptacion_id:datos.motivocaptacion_id,
                    telefono_mensajeria:datos.telefono_mensajeria,
                    titular:datos.titular,
                    mensajeria:datos.mensajeria,
                    foto:datos.foto,
                    condicion_id:datos.condicion_id,
                    empleado_id:datos.empleado_id,
                    asignacion_id:datos.asignacion_id,
                    fecha_ingreso:datos.fecha_ingreso,
                    nombre_completo:datos.nombre_completo,
                    carnet:datos.carnet,
                    convenio_id:datos.convenio_id,
                    campania_id:datos.campania_id,
                    historiaclinica:datos.historiaclinica,
                    observacion:datos.observacion,
                    apoderado:datos.apoderado,
                    parentesco_apoderado_id:datos.parentesco_apoderado_id,
                    historial:datos.historial,
                    user_id:datos.user_id,
                    // --- datos de planes paciente ---//
                    pacienteplanid: datos.pacienteplanes.id,
                    tipo:datos.pacienteplanes.tipo,
                    plan_id:datos.pacienteplanes.plan_id,
                    empresapaciente_id:datos.pacienteplanes.empresapaciente_id,
                    poliza_id:datos.pacienteplanes.poliza_id,
                    descripcion:datos.pacienteplanes.descripcion,
                    image:'',
                    sede:datos.sede,
                    ubigeo:datos.ubigeo,
                    edad: moment().diff(moment(datos.fecha_nacimiento, "DD-MM-YYYY"), 'years')                   
                } 
                this.dataPlanesPac = {
                    paciente_id:datos.id,
                    empleado_id:datos.empleado_id,
                    asignacion_id:datos.asignacion_id, 
                    pacienteplanid: datos.pacienteplanes.id,
                    tipo:datos.pacienteplanes.tipo,
                    plan_id:datos.pacienteplanes.plan_id,
                    empresapaciente_id:datos.pacienteplanes.empresapaciente_id,
                    poliza_id:datos.pacienteplanes.poliza_id, 
                    descripcion:datos.pacienteplanes.descripcion,  
                    user_id:datos.user_id             
                }
                this.dataPlanesPacAnt = {
                    paciente_id:datos.id,
                    empleado_id:datos.empleado_id,
                    asignacion_id:datos.asignacion_id, 
                    pacienteplanid: datos.pacienteplanes.id,
                    tipo:datos.pacienteplanes.tipo,
                    plan_id:datos.pacienteplanes.plan_id,
                    empresapaciente_id:datos.pacienteplanes.empresapaciente_id,
                    poliza_id:datos.pacienteplanes.poliza_id, 
                    descripcion:datos.pacienteplanes.descripcion,  
                    user_id:datos.user_id             
                }                                   
                if(this.dataPaciente.tipo == 1){
                    this.dataPaciente.empresapaciente_id = null
                    this.dataPaciente.poliza_id = null
                } 
                if(this.dataPaciente.ubigeo_id != null){   
                    this.coddepa = (this.departamentos.find(depa => depa.coddepa == this.dataPaciente.ubigeo.coddepa)).coddepa
                    this.codprov = (this.provincias.find(provi => provi.codprov == this.dataPaciente.ubigeo.codprov)).codprov
                }else{
                    //this.dataPaciente.ubigeo_id = ''
                }                                            
            } 
            
        },
        LoadFormRelacionar(){
            this.nom_pac = ''
            this.dataRelDep.parentesco_id = ''
            this.$modal.show('relacionar') 
        },
        LoadFormDependiente: function(){  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')   
            this.labelAccion = "Registro"      

            this.dataDependiente = {
                tipodocumento_id:'',
                numero_documento:'',
                sede_id:1,
                nombres:'',
                apellido_paterno:'',
                apellido_materno:'',
                fecha_nacimiento:moment().format('DD-MM-YYYY'),
                sexo:'H',
                ubigeo_id:this.dataPaciente.ubigeo_id,
                direccion:this.dataPaciente.direccion,
                telefono:this.dataPaciente.telefono,
                celular:this.dataPaciente.celular,                
                email:this.dataPaciente.email,                
                estadocivil_id:'',
                motivocaptacion_id:this.dataPaciente.motivocaptacion_id,
                telefono_mensajeria:'',
                titular:0,
                mensajeria:'',
                foto:'no-image.jpg',
                condicion_id:'',
                empleado_id:this.dataPaciente.empleado_id,
                asignacion_id:this.dataPaciente.asignacion_id,
                fecha_ingreso:moment().format('DD-MM-YYYY'),
                nombre_completo:'',
                carnet:'',
                convenio_id:this.dataPaciente.convenio_id,
                campania_id:this.dataPaciente.campania_id,
                historiaclinica:'',
                observacion:'',
                apoderado:'',
                parentesco_apoderado_id:'',
                historial:'',
                user_id:this.user_system.id,
                tipo:this.dataPaciente.tipo,
                plan_id:this.dataPaciente.plan_id,
                empresapaciente_id:this.dataPaciente.empresapaciente_id,
                poliza_id:this.dataPaciente.poliza_id,
                descripcion:this.dataPaciente.descripcion,
                image:'',
                edad:0 ,
                parentesco_id:''           
            }   
            if(this.dataPaciente.ubigeo_id != null){   
                this.coddepa = (this.departamentos.find(depa => depa.coddepa == this.dataPaciente.ubigeo.coddepa)).coddepa
                this.codprov = (this.provincias.find(provi => provi.codprov == this.dataPaciente.ubigeo.codprov)).codprov
            }   
            if(this.dataPaciente.sexo == 'H'){
                this.dataDependiente.apellido_paterno = this.dataPaciente.apellido_paterno
            }else{
                this.dataDependiente.apellido_materno = this.dataPaciente.apellido_paterno
            }                   
            this.SelectTipoPlanDep()
            this.$modal.show('dependiente')                                                
        },   
        actionDependiente (){
            if(typeof(this.dataDependiente.id) === "undefined"){
                this.createDependiente()
            }else{
                this.updateDependiente()
            }
        },                     
        updatePaciente: function(){
            var url = '/api/pacientes/'+this.dataPaciente.id;
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.put(url, this.dataPaciente).then(response => {
            if(typeof(response.data.errors) != "undefined"){
                this.errors = response.data.errors;
                var resultado = "";
                for (var i in this.errors) {
                    if (this.errors.hasOwnProperty(i)) {
                        resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                    }
                }
                this.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')                
                return;
            }
            this.$store.dispatch('LOAD_PACIENTES_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')               
            this.notificaciones('Paciente actualizado con exito','la la-thumbs-up','success')   
            this.$modal.hide('paciente');                         
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           
            });
        },
        createDependiente: function(){
            this.dataDependiente.pacientetitular_id = this.$route.params.idpaciente
            var url = '/api/dependientes';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataDependiente).then(response => {
            if(typeof(response.data.errors) != "undefined"){
                this.errors = response.data.errors;
                var resultado = "";
                for (var i in this.errors) {
                    if (this.errors.hasOwnProperty(i)) {
                        resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                    }
                }
                this.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')                
                return;
            }
            this.isLoading = true
            this.$store.dispatch('LOAD_PACIENTES_LIST').then(() => {
                this.$store.dispatch('LOAD_DEPENDIENTES_LIST')
                this.isLoading = false
            })                
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
            this.notificaciones('Nuevo Dependiente creado con exito','la la-thumbs-up','success')   
            this.$modal.hide('dependiente');                         
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           
            });
        },
        updateDependiente: function(){
            this.dataDependiente.pacientetitular_id = this.$route.params.idpaciente            
            var url = '/api/dependientes/'+this.dataDependiente.id;
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.put(url, this.dataDependiente).then(response => {
            if(typeof(response.data.errors) != "undefined"){
                this.errors = response.data.errors;
                var resultado = "";
                for (var i in this.errors) {
                    if (this.errors.hasOwnProperty(i)) {
                        resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                    }
                }
                this.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')                
                return;
            }
            this.isLoading = true
            this.$store.dispatch('LOAD_PACIENTES_LIST').then(() => {
                this.$store.dispatch('LOAD_DEPENDIENTES_LIST').then(() => {
                    this.isLoading = false
                })
            })   
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')               
            this.notificaciones('Dependiente actualizado con exito','la la-thumbs-up','success')   
            this.$modal.hide('dependiente');                         
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           
            });
        },
        processEdit(params){
            var datadep = []
            datadep = this.getPacienteById(params.pacientedependiente_id)
            this.dataDependiente = {
                id:datadep.id,
                tipodocumento_id:datadep.tipodocumento_id,
                numero_documento:datadep.numero_documento,
                sede_id:datadep.sede_id,
                nombres:datadep.nombres,
                apellido_paterno:datadep.apellido_paterno,
                apellido_materno:datadep.apellido_materno,
                fecha_nacimiento:datadep.fecha_nacimiento,
                sexo:datadep.sexo,
                ubigeo_id:datadep.ubigeo_id,
                direccion:datadep.direccion,
                telefono:datadep.telefono,
                celular:datadep.celular,                
                email:datadep.email,                
                estadocivil_id:datadep.estadocivil_id,
                motivocaptacion_id:datadep.motivocaptacion_id,
                telefono_mensajeria:datadep.telefono_mensajeria,
                titular:datadep.titular,
                mensajeria:datadep.mensajeria,
                foto:null,
                condicion_id:datadep.condicion_id,
                empleado_id:datadep.empleado_id,
                asignacion_id:datadep.asignacion_id,
                fecha_ingreso:datadep.fecha_ingreso,
                nombre_completo:datadep.nombre_completo,
                carnet:datadep.carnet,
                convenio_id:datadep.convenio_id,
                campania_id:datadep.campania_id,
                historiaclinica:datadep.historiaclinica,
                observacion:datadep.observacion,
                apoderado:datadep.apoderado,
                parentesco_apoderado_id:datadep.parentesco_apoderado_id,
                historial:datadep.historial,
                user_id:this.user_system.id,
                // --- datos de planes paciente ---//
                tipo:datadep.pacienteplanes.tipo,
                plan_id:datadep.pacienteplanes.plan_id,
                empresapaciente_id:datadep.pacienteplanes.empresapaciente_id,
                poliza_id:datadep.pacienteplanes.poliza_id,
                descripcion:datadep.pacienteplanes.descripcion,
                image:null,
                sede:datadep.sede,
                ubigeo:datadep.ubigeo, 
                parentesco_id:params.parentesco_id,
                foto:datadep.foto,
                edad: moment().diff(moment(datadep.fecha_nacimiento, "DD-MM-YYYY"), 'years')                                  
            }   

            if(this.dataDependiente.tipo == 1){
                this.dataDependiente.empresapaciente_id = null
                this.dataDependiente.poliza_id = null
            } 
            if(this.dataDependiente.ubigeo_id != null){   
                this.coddepa = (this.departamentos.find(depa => depa.coddepa == this.dataDependiente.ubigeo.coddepa)).coddepa
                this.codprov = (this.provincias.find(provi => provi.codprov == this.dataDependiente.ubigeo.codprov)).codprov
            }               
            this.labelAccion = "Actualización"         
            this.$modal.show('dependiente')        
        },
        processDelete(id){
            this.$swal({
                title: 'Desea eliminar este registro?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, eliminar!'
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true
                        var url = '/api/dependientes/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_DEPENDIENTES_LIST').then(() => {
                                this.isLoading = false
                                this.$swal(
                                'Eliminado!',
                                'Este registro fue eliminado.',
                                'success'
                                )
                            })                    
                        });
                    }
                });
        }, 
        createRelacion: function(){
            this.dataRelDep.pacientetitular_id = this.$route.params.idpaciente
            this.dataRelDep.user_id = this.user_system.id
            var url = '/api/dependientes/relacion';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataRelDep).then(response => {
            if(typeof(response.data.errors) != "undefined"){
                this.errors = response.data.errors;
                var resultado = "";
                for (var i in this.errors) {
                    if (this.errors.hasOwnProperty(i)) {
                        resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                    }
                }
                this.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')                
                return;
            }
            this.isLoading = true
            this.$store.dispatch('LOAD_DEPENDIENTES_LIST').then(() => {
                this.isLoading = false
            })                
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
            this.notificaciones('Se Agregro el Dependiente con exito','la la-thumbs-up','success')   
            this.$modal.hide('relacionar');                         
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           
            });
        },
        SelectTipoPlan(){
            this.getPlanes = this.planes.filter((pla) => pla.tipo == this.dataPaciente.tipo)
            this.dataPaciente.plan_id = ''
            if(this.dataPaciente.tipo == 1){
                this.dataPaciente.empresapaciente_id = '';
                this.dataPaciente.poliza_id = '';
            }
        },
        SelectPlan(){
            var self = this
            this.$store.dispatch('LOAD_EMPRESAPACIENTES_PLANES_EMPRESAS_LIST',{ id : this.dataPaciente.plan_id}).then(() => {
                this.isLoading = false
            })
            this.dataPaciente.empresapaciente_id = '' 
            this.dataPaciente.poliza_id = ''           
            _.each(this.planes , function(value,key){
                if(value.id == self.dataPaciente.plan_id){
                    self.dataPaciente.descripcion = value.descripcion 
                    return
                }
            })
        },
        SelectEmpresa(){
            this.polizaspac = this.getPolizas(this.dataPaciente.empresapaciente_id,this.dataPaciente.plan_id)       
        },
        SelectTipoPlanDep(){
            this.getPlanesDep = this.planes.filter((pla) => pla.tipo == this.dataDependiente.tipo)
            if(this.dataDependiente.tipo == 1){
                this.dataDependiente.empresapaciente_id = null;
                this.dataDependiente.poliza_id = null;
            }
        },
        SelectPlanDep(){
            var self = this
            this.$store.dispatch('LOAD_EMPRESAPACIENTES_PLANES_EMPRESAS_LIST',{ id : this.dataDependiente.plan_id}).then(() => {
                this.isLoading = false
            })            
            _.each(this.planes , function(value,key){
                if(value.id == self.dataDependiente.plan_id){
                    self.dataDependiente.descripcion = value.descripcion 
                    return
                }
            })
        },
        SelectEmpresaDep(){
            this.polizaspacDep = this.getPolizas(this.dataDependiente.empresapaciente_id,this.dataDependiente.plan_id)       
        },        
        openedFn () {
            $(".form-group-default .form-control").focus(function(){
                $(this).parent().addClass("active");
            }).blur(function(){
                $(this).parent().removeClass("active");
            })                      
        },        
        onFileChangeDep(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) {
                this.dataDependiente.image = null;
                //this.imagenPerfil = null
                return;
            }
            this.createImageDep(files[0]);
        },
        createImageDep(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.dataDependiente.image = e.target.result;
                //vm.imagenPerfil = vm.dataPacienteMain.image
            };
            reader.readAsDataURL(file); 
        }, 
        selectPaciente: function(params){
            this.dataRelDep.pacientedependiente_id = params.row.id
            this.nom_pac = params.row.nombre_completo
            this.$modal.hide('pacientesdep')           
        }, 
        cambioDepartamento(){
            if(this.coddepa == ""){
                this.dataPaciente.ubigeo_id = null
            }
        },
        cambioProvincia(){
            if(this.codprov == ""){
                this.dataPaciente.ubigeo_id = null
            }            
        },
        cambioDistrito(){
            if(this.coddist == ""){
                this.dataPaciente.ubigeo_id = null
            }             
        },
        // Derivaciones
        LoadFormDerivacion: function(){  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos') 
            this.labelAccion = "Agregar"  
            this.nom_ser = ''      

            this.dataDerivacion = {
                empleadoderivante_id:'',
                empleadoderivado_id:'',
                paciente_id:this.$route.params.idpaciente,
                servicio_id:'',
                user_id:this.user_system.id,
                fecha_registro:moment().format('DD-MM-YYYY'),
                indicador:1  
            }                    
            this.$modal.show('derivacion')                                                
        },  
        ActionDerivacion: function(){
            if(typeof(this.dataDerivacion.id) === "undefined"){
                this.createDerivacion()
            }else{
                this.updateDerivacion()
            }
        },               
        createDerivacion: function(){
            var url = '/api/derivaciones';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataDerivacion).then(response => {
            if(typeof(response.data.errors) != "undefined"){
                this.errors = response.data.errors;
                var resultado = "";
                for (var i in this.errors) {
                    if (this.errors.hasOwnProperty(i)) {
                        resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                    }
                }
                this.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')                
                return;
            }

            this.$store.dispatch('LOAD_DERIVACIONES_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('derivacion');   
            this.notificaciones('Derivación creada con exito','la la-thumbs-up','success')       
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           

            });
        },
        updateDerivacion: function(){
            var url = '/api/derivaciones/'+this.dataDerivacion.id; 
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.put(url, this.dataDerivacion).then(response => {
                if(typeof(response.data.errors) != "undefined"){
                    this.errors = response.data.errors;
                    var resultado = "";
                    for (var i in this.errors) {
                        if (this.errors.hasOwnProperty(i)) {
                            resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                        }
                    }   
                    this.StatusForm(false,'la la-cloud-download','Grabar Datos')
                    this.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                 
                    return;
                }
                this.$store.dispatch('LOAD_DERIVACIONES_LIST')                  
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
                this.$modal.hide('derivacion');  
                this.notificaciones('Derivacion actualizada con exito','la la-thumbs-up','success')                  
            }).catch(error => {
                this.errors = error.response.data.status;  
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')
            });
        },
        processEditDerivacion(params){
            var datader = []
            datader = _.clone(params.row)
            this.dataDerivacion = {
                id:datader.id,
                empleadoderivante_id:datader.empleadoderivante_id,
                empleadoderivado_id:datader.empleadoderivado_id,
                paciente_id:datader.paciente_id,
                servicio_id:datader.servicio_id,
                user_id:datader.user_id,
                fecha_registro:datader.fecha_registro,
                indicador:datader.indicador,
                motivo:datader.motivo                         
            }     
            this.nom_ser = datader.servicio.nombre_servicio  
            this.labelAccion = "Actualizar"     
            this.$modal.show('derivacion')        
        },
        processDeleteDerivacion(id){
            this.$swal({
                title: 'Desea eliminar este registro?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, eliminar!'
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true
                        var url = '/api/derivaciones/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_DERIVACIONES_LIST').then(() => {
                                this.isLoading = false
                                this.$swal(
                                'Eliminado!',
                                'Este registro fue eliminado.',
                                'success'
                                )
                            })                    
                        });
                    }
                });
        }, 
        selectServicio: function(params){
            this.dataDerivacion.servicio_id = params.row.id
            this.nom_ser = params.row.nombre_servicio
            this.$modal.hide('servicios')           
        },
        updatePlanesPaciente: function(){
            this.dataPlanesPac = {
                paciente_id:this.$route.params.idpaciente,
                empleado_id:this.dataPaciente.empleado_id,
                asignacion_id:this.dataPaciente.asignacion_id, 
                pacienteplanid: this.dataPaciente.pacienteplanid,
                tipo:this.dataPaciente.tipo,
                plan_id:this.dataPaciente.plan_id,
                empresapaciente_id:this.dataPaciente.empresapaciente_id,
                poliza_id:this.dataPaciente.poliza_id, 
                descripcion:this.dataPaciente.descripcion,
                user_id:this.user_system.id             
            }

            if(this.dataPlanesPac.tipo != this.dataPlanesPacAnt.tipo || this.dataPlanesPac.plan_id != this.dataPlanesPacAnt.plan_id || this.dataPlanesPac.empresapaciente_id != this.dataPlanesPacAnt.empresapaciente_id || this.dataPlanesPac.poliza_id != this.dataPlanesPacAnt.poliza_id ){
                this.dataPlanesPac.cambio_planes = 1
            }
            var url = '/api/pacientes/actualizaplanes/'+this.dataPlanesPac.paciente_id;
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.put(url, this.dataPlanesPac).then(response => {
            if(typeof(response.data.errors) != "undefined"){
                this.errors = response.data.errors;
                var resultado = "";
                for (var i in this.errors) {
                    if (this.errors.hasOwnProperty(i)) {
                        resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                    }
                }
                this.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')                
                return;
            }
            this.$store.dispatch('LOAD_SEGUIMIENTO_PLANES_LIST') 
            this.$store.dispatch('LOAD_PACIENTES_LIST').then(() => {
                this.CargaDatosTitular() 
            })                      
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')               
            this.notificaciones('Planes del paciente actualizado con exito','la la-thumbs-up','success')   
            this.$modal.hide('paciente');                         
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           
            });
        }, 
        imprimirFicha(){
            //window.open('http://localhost/dsa/public/muestra/informeMuestra/' + id + ',' + '_blank');  
            window.open('http://localhost:8000/api/reportes/pacientes/ficha/'+ this.$route.params.idpaciente);          
        }                                       

    }            
}
</script>
<style scoped>
    .v--modal-overlay {
        z-index:9000;     
    }    
    .vld-overlay.is-full-page {
        z-index: 99999;
    }
    input[type="file"] {
        display: none;
    }  
    .form-group-default {
        margin-top:0px !important;
    } 
    .form-control-sm {
        font-size: .680rem !important;
    }
    .form-group-default label:not(.error) {
        font-size: 9.5px !important;
    }  
    .card.card-with-nav .card-body {
        padding:5px 0px !important;
    } 
    .pl-12 {
        padding-left: 12px !important;        
    } 
    .border-odonto {
        border-color: #c1c4c7 !important;
    }  
    #servicios {
        z-index:999999;
    } 
    .table-sm th,
    .table-sm td {
        padding: 0.3rem !important; 
        font-size: 11px !important;
    }                
</style>


