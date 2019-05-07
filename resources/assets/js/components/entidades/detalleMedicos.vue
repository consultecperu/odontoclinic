<template>
    <div class="row">
        <div class="col-md-3">
            <div class="card card-profile card-primary pb-20">
                <div class="card-header">
                    <div class="profile-picture">
                        <img v-if="dataEmpleado.image" :src="dataEmpleado.image" alt="Imagen de Perfil">
                        <img v-if="!dataEmpleado.image" :src="'/images/' + dataEmpleado.foto" alt="Imagen de Perfil">                        
                    </div>
                </div>
                <div class="card-body pb-0">
                    <div class="user-profile text-center">
                        <!-- <div class="name">{{ dataEmpleado.numero_documento }}</div> -->
                        <div class="job">{{ dataEmpleado.nombre_completo }}</div>
                        <div class="desc">ODONTOLOGO</div>

                        <div class="view-profile">
                            <input type="file" class="form-control form-control-file" id="uploadImg" name="uploadImg" accept="image/*" @change="onFileChange" >
                            <label for="uploadImg" class=" label-input-file text-white btn btn-icon btn-sm btn-primary"><i class="la la-file-image-o"></i> Cargar Imagen</label>
                        </div>
                        <div class="seperator-solid"></div>                        
                    </div>
                </div>
                <div class="card-footer pt-0 pb-20">
                    <div class="row">
                        <div class="col-12 pl-10 pr-10">
                            <div class="nav flex-column nav-pills nav-primary" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                                <a class="nav-link active border-odonto pt-5 pb-5" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">Datos Generales</a>
                                <a class="nav-link border-odonto pt-5 pb-5" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">Liquidación Operatoria</a>
                                <a class="nav-link border-odonto pt-5 pb-5" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">Liquidación Ortodoncia</a>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="col-md-9 pl-0">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab">
                    <div class="card card-with-nav">
                        <div class="card-header">
                            <div class="row">
                                <ul class="nav nav-tabs nav-line nav-color-primary" role="tablist">
                                    <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#datos" role="tab" aria-selected="true">Datos Personales</a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#horarios" role="tab" aria-selected="false" @click.prevent="BlankSede">Turnos Normales</a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#horespeciales" role="tab" aria-selected="false" @click.prevent="BlankSede">Turnos Especiales</a> </li>
                                    <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#permisos" role="tab" aria-selected="true">Permisos</a> </li>
                                </ul>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="tab-content pr-10 pl-10 pt-10">
                                <div class="tab-pane active" id="datos" role="tabpanel" aria-labelledby="datos-tab">
                                    <form role="form" method="PUT" v-on:submit.prevent="updateEmpleado">
                                        <div class="col-12">
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group row pt-5 pb-0">
                                                        <label for="tipodoc" class="col-4 pl-0">Tipo de Documento <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <select class="form-control form-control-sm border-odonto" id="tipodoc" v-model="dataEmpleado.tipodocumento_id">
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
                                                            <input type="text" class="form-control form-control-sm border-odonto" id="numdocumento" name="numdocumento" v-model="dataEmpleado.numero_documento" maxlength="8">
                                                        </div>                                                
                                                    </div>
                                                </div>                                              
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="apepat" class="col-4 pl-0">Apellido Paterno <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto mayusculas" id="ape_paterno" name="ape_paterno" v-model="dataEmpleado.apellido_paterno">
                                                        </div>                                                
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="apemat" class="col-4 pl-0">Apellido Materno <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto mayusculas" id="ape_materno" name="numdocumento" v-model="dataEmpleado.apellido_materno">
                                                        </div>                                                
                                                    </div>
                                                </div>                                             
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="nombres" class="col-4 pl-0">Nombres <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto mayusculas" id="nombres" name="nombres" v-model="dataEmpleado.nombres">
                                                        </div>                                                
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="nombres" class="col-4 pl-0">COP <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto mayusculas" id="cop" name="cop" v-model="dataEmpleado.COP">
                                                        </div>                                                
                                                    </div>
                                                </div>                                                                                        
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group row pt-5 pb-0">
                                                        <label for="datepicker" class="col-4 pl-0">Fecha Nacimiento</label>
                                                        <div class="col-8 pr-0">
                                                            <masked-input v-model="dataEmpleado.fecha_nacimiento" mask="11-11-1111" placeholder="DD-MM-YYYY" class="form-control form-control-sm border-odonto"/>                                                                                                
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group row pt-5 pb-0">
                                                        <label for="tipodoc" class="col-4 pl-0">Sexo <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <select class="form-control form-control-sm border-odonto" id="sexo" v-model="dataEmpleado.sexo">
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
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="telefono" class="col-4 pl-0">Teléfono </label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto" id="telefono" name="telefono" v-model="dataEmpleado.telefono" maxlength="7">
                                                        </div>                                                
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="celular" class="col-4 pl-0">Celular <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto" id="celular" name="celular" v-model="dataEmpleado.celular" maxlength="9">
                                                        </div>                                                
                                                    </div>
                                                </div>                                            
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="email" class="col-4 pl-0">Email <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto" id="email" name="email" v-model="dataEmpleado.email">
                                                        </div>                                                
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group row pt-5 pb-0">
                                                        <label for="estadocivil" class="col-4 pl-0">Estado Civil </label>
                                                        <div class="col-8 pr-0">
                                                            <select class="form-control form-control-sm border-odonto" id="estadocivil" v-model="dataEmpleado.estadocivil_id">
                                                                <option value="">-- Seleccione --</option>
                                                                <option v-for="est in estadosciviles" :value="est.id" :key="est.id">
                                                                    {{ est.nombre_estadocivil}}
                                                                </option>
                                                            </select>
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
                                                        <select id="distrito" name="distrito" class="form-control form-control-sm border-odonto" v-model="dataEmpleado.ubigeo_id">
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
                                                            <input type="text" class="form-control form-control-sm border-odonto mayusculas" name="direccion" v-model="dataEmpleado.direccion">
                                                        </div>                                                
                                                    </div>
                                                </div>                                            
                                            </div> 
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group row pt-5 pb-0">
                                                        <label for="datepicker" class="col-4 pl-0">Fecha de Ingreso</label>
                                                        <div class="col-8 pr-0">
                                                            <masked-input v-model="dataEmpleado.fecha_ingreso" mask="11-11-1111" placeholder="DD-MM-YYYY" class="form-control form-control-sm border-odonto"/>                                                                                                
                                                        </div>
                                                    </div>
                                                </div>  
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="consultorio" class="col-4 pl-0">Nro. Consultorio </label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto" id="consultorio" name="consultorio" v-model="dataEmpleado.numero_consultorio">
                                                        </div>                                                
                                                    </div>
                                                </div>                                                                                                                                  
                                            </div>
                                            <div class="row pb-15">
                                                <div class="col-12">
                                                    <div class="form-group row pb-0 pt-10">
                                                        <label for="especialidades" class="col-2 pl-0">Especialidades <span class="required-label"> *</span></label>
                                                        <div class="col-10 pr-0 pl-10">
                                                            <multiselect v-model="dataEmpleado.especialidades" tag-placeholder="Agregar Especialidades" placeholder="Agregar Especialidad" label="nombre_especialidad" track-by="nombre_especialidad" :options="especialidades" :multiple="true" :option-height="15" :taggable="true" @input="addEspecialidad" deselectLabel="Seleccione para eliminar" selectLabel="Presione para seleccionar" selectedLabel="Seleccionado"></multiselect>                                                    
                                                        </div>
                                                    </div>
                                                </div> 
                                            </div>
                                            <div class="row">  
                                                <div class="col-12">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="sede" class="col-2 pl-0">Sedes <span class="required-label"> *</span></label>
                                                        <div class="col-10 pr-0 pl-10">
                                                            <multiselect v-model="dataEmpleado.sedes" tag-placeholder="Agregar Sede" placeholder="Agregar Sede" label="nombre_sede" track-by="nombre_sede" :options="sedes" :multiple="true" :option-height="15" :taggable="true" @input="addSede" deselectLabel="Seleccione para eliminar" selectLabel="Presione para seleccionar" selectedLabel="Seleccionado"></multiselect>                                                                                                            
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">  
                                                <div class="col-6">
                                                    <div class="form-group row pt-5 pb-0">
                                                        <label for="estadocivil" class="col-4 pl-0">Tipo Pago <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <select class="form-control form-control-sm border-odonto" id="estadocivil" v-model="dataEmpleado.tipopagodoctor_id">
                                                                <option value="">-- Seleccione --</option>
                                                                <option v-for="tippag in tipopagodoctores" :value="tippag.id" :key="tippag.id">
                                                                    {{ tippag.nombre_tipopagodoctor}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-6">
                                                    <div class="form-group row pt-5 pb-0">
                                                        <label for="estadocivil" class="col-4 pl-0">Tipo Contrato <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <select class="form-control form-control-sm border-odonto" id="tipocontrato" v-model="dataEmpleado.tipocontrato_id">
                                                                <option value="">-- Seleccione --</option>
                                                                <option v-for="tipcon in tipocontratos" :value="tipcon.id" :key="tipcon.id">
                                                                    {{ tipcon.nombre_tipocontrato}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div> 
                                                </div>                                                                                                                                 
                                            </div>
                                            <div class="row">
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="ruc" class="col-4 pl-0">RUC <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto" id="ruc" name="consultorio" v-model="dataEmpleado.ruc" maxlength="11">
                                                        </div>                                                
                                                    </div>
                                                </div>  
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="razon_social" class="col-4 pl-0">Razón social <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm mayusculas border-odonto" id="razon_social" name="consultorio" v-model="dataEmpleado.razon_social">
                                                        </div>                                                
                                                    </div>
                                                </div>                                                                                                                                                                         
                                            </div>                                                                                    
                                            <div class="row pb-15">
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="email" class="col-4 pl-0">% Planes Internos <span class="required-label"> *</span> </label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto" id="porcetanjeinterno" name="porcentajeinterno" v-model="dataEmpleado.porcentaje_interno">
                                                        </div>                                                
                                                    </div>
                                                </div>    
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="email" class="col-4 pl-0">% Aseguradoras<span class="required-label"> *</span> </label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto" id="porcetanjeaseguradora" name="porcentajeaseguradora" v-model="dataEmpleado.porcentaje_aseguradora">
                                                        </div>                                                
                                                    </div>
                                                </div>                                             
                                            </div>                                       
                                            <div class="row pb-20 pt-20">
                                                <div class="col-6">
                                                    <label for="">Acceso al Sistema</label>
                                                    <toggle-button :sync="true" :labels="{checked: 'SI', unchecked: 'NO'}" :color="{checked: '#005FD8', unchecked: '#FF0000', disabled: '#CCCCCC'}" v-model="dataEmpleado.acceso_system"/>                                
                                                </div>
                                            </div>
                                            <div class="row" v-show="dataEmpleado.acceso_system">
                                                <div class="col-6">
                                                    <div class="form-group row pb-0 pt-5">
                                                        <label for="email" class="col-4 pl-0">Nombre Usuario <span class="required-label"> *</span></label>
                                                        <div class="col-8 pr-0">
                                                            <input type="text" class="form-control form-control-sm border-odonto" id="username" name="username" v-model="dataEmpleado.username">
                                                        </div>                                                
                                                    </div>
                                                </div>  
                                                <div class="col-6">
                                                    <div class="form-group row pt-5 pb-0">
                                                        <label for="estadocivil" class="col-4 pl-0">Perfil de Acceso </label>
                                                        <div class="col-8 pr-0">
                                                            <select class="form-control form-control-sm border-odonto" id="tipocontrato" v-model="dataEmpleado.perfil_id" disabled>
                                                                <option value="">-- Seleccione --</option>
                                                                <option v-for="perfil in perfiles" :value="perfil.id" :key="perfil.id">
                                                                    {{ perfil.nombre_perfil}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div> 
                                                </div>
                                            </div> 
                                            <div class="text-right mt-3 mb-3">
                                                <button tpe="submit" class="btn btn-primary float-right" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
    <!--                                             <button class="btn btn-danger">Cancelar</button> -->
                                            </div>                                             
                                        </div>                            

                                    </form>
                                </div>
                                <div class="tab-pane" id="horarios" role="tabpanel" aria-labelledby="horarios-tab">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group pl-0">
                                                            <label for="tipodoc" class="text-primary font-weight-bold">Sede <span class="required-label"> *</span></label>
                                                            <select class="form-control form-control-sm" id="tipodoc" v-model="dataHorario.sede_id" @change="cargaTurnos(dataHorario.sede_id)">
                                                                <option value="">-- Seleccione Sede--</option>
                                                                <option v-for="sed in dataEmpleado.sedes" :value="sed.id" :key="sed.id">
                                                                    {{ sed.nombre_sede}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group pl-0">
                                                            <label for="tipodoc" class="text-primary font-weight-bold">Dias <span class="required-label"> *</span></label>
                                                            <select class="custom-select" size="6" multiple v-model="dias_select">
                                                                <option value="1">Lunes</option>
                                                                <option value="2">Martes</option>
                                                                <option value="3">Miercoles</option>
                                                                <option value="4">Jueves</option>
                                                                <option value="5">Viernes</option>
                                                                <option value="6">Sabado</option>                                            
                                                            </select> 
                                                        </div>
                                                    </div>                                       
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class="text-primary font-weight-bold">Mañana</label>
                                                    </div>                                        
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group pl-0">
                                                            <select class="form-control form-control-sm sansSerif" id="horaini1" v-model="dataHorario.horaini1" @change="onSelectChange($event,1)">
                                                                <option value="">desde</option>
                                                                <option v-for="hor in getHorasAM" :value="hor.id" :key="hor.id">
                                                                    {{ hor.nombre_hora}}
                                                                </option>
                                                            </select>                                                 
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group pl-0">
                                                            <select class="form-control form-control-sm sansSerif" id="horafin1" v-model="dataHorario.horafin1" @change="onSelectChange($event,2)">
                                                                <option value="">hasta</option>
                                                                <option v-for="hor in getHorasAM" :value="hor.id" :key="hor.id">
                                                                    {{ hor.nombre_hora}}
                                                                </option>
                                                            </select>                                               
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class="text-primary font-weight-bold">Tarde</label>
                                                    </div>                                        
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group pl-0">
                                                            <select class="form-control form-control-sm sansSerif" id="horaini2" v-model="dataHorario.horaini2" @change="onSelectChange($event,3)">
                                                                <option value="">desde</option>
                                                                <option v-for="hor in getHorasPM" :value="hor.id" :key="hor.id">
                                                                    {{ hor.nombre_hora}}
                                                                </option>
                                                            </select>                                              
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group pl-0">
                                                            <select class="form-control form-control-sm sansSerif" id="horafin2" v-model="dataHorario.horafin2" @change="onSelectChange($event,4)">
                                                                <option value="">hasta</option>
                                                                <option v-for="hor in getHorasPM" :value="hor.id" :key="hor.id">
                                                                    {{ hor.nombre_hora}}
                                                                </option>
                                                            </select>                                               
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="row">
                                                    <button type="button" class="btn btn-primary btn-block" @click.prevent="addHorario(1)">AGREGAR HORARIO</button>
                                                </div>                                   

                                            </div>
                                            <div class="col-8">
                                                <table class="table table-sm table-bordered table-head-bg-info table-bordered-bd-info mt-4">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Dia</th>
                                                            <th scope="col">Mañana de</th>
                                                            <th scope="col">Hasta</th>
                                                            <th scope="col">Tarde de</th>
                                                            <th scope="col">Hasta</th> 
                                                            <th scope="col">Accion</th>                                                                                                                     
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item,index) in listTurnos" :key="item.dia_id">
                                                            <td>{{ item._dia }}</td>
                                                            <td>{{ item.horaini1 != '' ? item._horaini1.format('HH:mm') : '' }}</td>
                                                            <td>{{ item.horafin1 != '' ? item._horafin1.format('HH:mm') : '' }}</td>
                                                            <td>{{ item.horaini2 != '' ? item._horaini2.format('HH:mm') : '' }}</td>
                                                            <td>{{ item.horafin2 != '' ? item._horafin2.format('HH:mm') : '' }}</td>
                                                            <td class="center"><button type="button" class="btn btn-danger btn-xs font-weight-bold" v-tooltip="'Eliminar'"  @click.prevent="ProcessDelete(index)">X</button></td>
                                                        </tr>                                                                                       
                                                    </tbody>
                                                </table>
                                                <div class="row" v-if="listTurnos.length > 0">
                                                    <div class="col-12">
                                                        <button class="btn btn-success float-right font-weight-bold" :disabled="ShowIcon" @click.prevent="createTurno"><span class="btn-label"><i :class="[IconClass]"></i></span>{{ labelButton }}</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="tab-pane" id="horespeciales" role="tabpanel" aria-labelledby="horespeciales-tab">
                                    <div class="col-12">
                                        <div class="row">
                                            <div class="col-4">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="form-group pl-0">
                                                            <label for="tipodoc" class="text-primary font-weight-bold">Sede <span class="required-label"> *</span></label>
                                                            <select class="form-control form-control-sm" id="tipodoc" v-model="dataHorario.sede_id" @change="e_cargaTurnos(dataHorario.sede_id)">
                                                                <option value="">-- Seleccione Sede--</option>
                                                                <option v-for="sed in dataEmpleado.sedes" :value="sed.id" :key="sed.id">
                                                                    {{ sed.nombre_sede}}
                                                                </option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="datepick" class="text-primary font-weight-bold">Seleccione la Fecha <span class="required-label"> *</span></label>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div id="sandbox-container">
                                                            <input type="text" class="form-control" id="fechas">
                                                        </div>
                                                    </div>                                       
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class="text-primary font-weight-bold">Mañana</label>
                                                    </div>                                        
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group pl-0">
                                                            <select class="form-control form-control-sm sansSerif" id="e_horaini1" v-model="dataHorario.horaini1" @change="onSelectChange($event,1)">
                                                                <option value="">desde</option>
                                                                <option v-for="hor in getHorasAM" :value="hor.id" :key="hor.id">
                                                                    {{ hor.nombre_hora}}
                                                                </option>
                                                            </select>                                                 
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group pl-0">
                                                            <select class="form-control form-control-sm sansSerif" id="e_horafin1" v-model="dataHorario.horafin1" @change="onSelectChange($event,2)">
                                                                <option value="">hasta</option>
                                                                <option v-for="hor in getHorasAM" :value="hor.id" :key="hor.id">
                                                                    {{ hor.nombre_hora}}
                                                                </option>
                                                            </select>                                               
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-12">
                                                        <label for="" class="text-primary font-weight-bold">Tarde</label>
                                                    </div>                                        
                                                </div>
                                                <div class="row">
                                                    <div class="col-6">
                                                        <div class="form-group pl-0">
                                                            <select class="form-control form-control-sm sansSerif" id="e_horaini2" v-model="dataHorario.horaini2" @change="onSelectChange($event,3)">
                                                                <option value="">desde</option>
                                                                <option v-for="hor in getHorasPM" :value="hor.id" :key="hor.id">
                                                                    {{ hor.nombre_hora}}
                                                                </option>
                                                            </select>                                              
                                                        </div>
                                                    </div>
                                                    <div class="col-6">
                                                        <div class="form-group pl-0">
                                                            <select class="form-control form-control-sm sansSerif" id="e_horafin2" v-model="dataHorario.horafin2" @change="onSelectChange($event,4)">
                                                                <option value="">hasta</option>
                                                                <option v-for="hor in getHorasPM" :value="hor.id" :key="hor.id">
                                                                    {{ hor.nombre_hora}}
                                                                </option>
                                                            </select>                                               
                                                        </div>
                                                    </div>
                                                </div> 
                                                <div class="row">
                                                    <button type="button" class="btn btn-primary btn-block" @click.prevent="addHorario(2)">AGREGAR HORARIO</button>
                                                </div>                                   

                                            </div>
                                            <div class="col-8">
                                                <table class="table table-sm table-bordered table-head-bg-info table-bordered-bd-info mt-4">
                                                    <thead>
                                                        <tr>
                                                            <th scope="col">Dia</th>
                                                            <th scope="col">Mañana de</th>
                                                            <th scope="col">Hasta</th>
                                                            <th scope="col">Tarde de</th>
                                                            <th scope="col">Hasta</th> 
                                                            <th scope="col">Accion</th>                                                                                                                     
                                                        </tr>
                                                    </thead>
                                                    <tbody>
                                                        <tr v-for="(item,index) in e_listTurnos" :key="item.fecha">
                                                            <td>{{ item.fecha }}</td>
                                                            <td>{{ item.horaini1 != '' ? item._horaini1.format('HH:mm') : '' }}</td>
                                                            <td>{{ item.horafin1 != '' ? item._horafin1.format('HH:mm') : '' }}</td>
                                                            <td>{{ item.horaini2 != '' ? item._horaini2.format('HH:mm') : '' }}</td>
                                                            <td>{{ item.horafin2 != '' ? item._horafin2.format('HH:mm') : '' }}</td>
                                                            <td class="center"><button type="button" class="btn btn-danger btn-xs font-weight-bold" v-tooltip="'Eliminar'"  @click.prevent="ProcessDelete(index)">X</button></td>
                                                        </tr>                                                                                       
                                                    </tbody>
                                                </table>
                                                <div class="row" v-if="e_listTurnos.length > 0">
                                                    <div class="col-12">
                                                        <button class="btn btn-success float-right font-weight-bold" :disabled="ShowIcon" @click.prevent="e_createTurno"><span class="btn-label"><i :class="[IconClass]"></i></span>{{ labelButton }}</button>
                                                    </div>
                                                </div>
                                            </div>                                
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane" id="permisos" role="tabpanel" aria-labelledby="permisos">
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group pl-0">
                                                <label for="tipodoc" class="text-primary font-weight-bold">Sede </label>
                                                <select class="form-control form-control-sm" id="tipodoc" v-model="dataPermiso.sede_id" @change="cargaPermisos(dataPermiso.sede_id)">
                                                    <option value="">-- Seleccione Sede--</option>
                                                    <option v-for="sed in dataEmpleado.sedes" :value="sed.id" :key="sed.id">
                                                        {{ sed.nombre_sede}}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-8 pt-30" v-show="dataPermiso.sede_id">
                                            <button type="button" class="btn btn-primary float-right" @click.prevent="LoadFormPermiso"><span class="btn-label"><i class="flaticon-chat-2"></i></span> Nuevo Permiso</button>
                                        </div>
                                    </div> 
                                    <div class="seperator-solid"></div>                                   
                                    <div class="row">
                                        <div class="col-12">
                                            <vue-good-table
                                            :columns="columns"
                                            :rows="permisosByDoctores"
                                            :paginationOptions="{
                                                enabled: true,
                                                dropdownAllowAll: false,
                                                nextLabel: 'Sig',
                                                prevLabel: 'Ant',
                                                rowsPerPageLabel: 'Registros por Pagina',
                                                ofLabel: 'de',
                                                allLabel: 'Todos',
                                            }"
                                            @on-row-dblclick="processEditPermiso"
                                            :rowStyleClass="'enlace'"
                                            :lineNumbers="true"
                                            styleClass="vgt-table condensed bordered striped">
                                                <template slot="table-row" slot-scope="props">
                                                    <span v-if="props.column.field == 'btn'" class="center">
                                                        <button type="button" class="btn btn-border btn-success btn-xs" v-tooltip="'Actualizar Permiso'" @click.prevent="processEditPermiso(props)">
                                                            <i class="la la-edit font-large"></i>
                                                        </button>                                
                                                        <button type="button" class="btn btn-border btn-danger btn-xs" v-tooltip="'Eliminar Permiso'" @click.prevent="processDeletePermiso(props.row.id)">
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
                            </div>                            
                        </div>
                    </div>
                </div>
                <div class="tab-pane fade" id="v-pills-profile" role="tabpanel" aria-labelledby="v-pills-profile-tab">
                    <div class="card card-with-nav">
                        <div class="card-header">
                        </div> 
                        <div class="card-body"> 
                            <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
                            <p>The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn’t listen. She packed her seven versalia, put her initial into the belt and made herself on the way.
                            </p>                               
                        </div>                                           
                    </div>

                </div>
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab">
                    <div class="card card-with-nav">
                        <div class="card-header">

                        </div>
                        <div class="card-body">
                            <p>Pityful a rethoric question ran over her cheek, then she continued her way. On her way she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word "and" and the Little Blind Text should turn around and return to its own, safe country.</p>

                            <p> But nothing the copy said could convince her and so it didn’t take long until a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged her into their agency, where they abused her for their</p>

                        </div>
                    </div>
                </div>
            </div>            
        </div>
        <!-- PAGE CONTENT MODAL -->  
        <modal name="permiso" :width="'40%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false" @opened="openedFn()">
            <!-- form de registro de empresas -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">{{ labelAccion }} de Permiso</div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="tipopermiso" class="text-primary font-weight-bold">Tipo Permiso </label>
                                    <select class="form-control form-control-sm border border-primary" id="tipopermiso" v-model="dataPermiso.tipopermiso">
                                        <option value="">-- Tipo de Permiso--</option>
                                        <option v-for="tip in tipopermisos" :value="tip.id" :key="tip.id">
                                            {{ tip.nombre_permiso}}
                                        </option>
                                    </select>
                                </div>
                            </div>                            
                        </div>
                        <div class="row pl-10 pr-10" v-show="dataPermiso.tipopermiso == 1">
                            <div class="col-6">
                                <label for="fechaini" class="text-primary font-weight-bold">Desde </label>
                                <div id="sandbox-container2">
                                    <input type="text" class="form-control form-control-sm border border-primary" id="fechaini">
                                </div>
                            </div>
                            <div class="col-6">
                                <label for="fechafin" class="text-primary font-weight-bold">Hasta </label>
                                <div id="sandbox-container3">
                                    <input type="text" class="form-control form-control-sm border border-primary" id="fechafin">
                                </div>
                            </div>
                        </div>
                        <div class="row pl-10 pr-10" v-show="dataPermiso.tipopermiso == 2">
                            <div class="col-6">
                                <label for="fechauni" class="text-primary font-weight-bold">Fecha </label>
                                <div id="sandbox-container4">
                                    <input type="text" class="form-control form-control-sm border border-primary" id="fechauni">
                                </div>                                
                            </div>
                        </div>
                        <div class="row" v-show="dataPermiso.tipopermiso == 2">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="horaini" class="text-primary font-weight-bold">Desde </label>
                                    <select class="form-control form-control-sm sansSerif border border-primary" id="horaini" v-model="dataPermiso.horaini" @change="onSelectChangePermiso($event,1)">
                                        <option value="">desde</option>
                                        <option v-for="hor in horas" :value="hor.id" :key="hor.id">
                                            {{ hor.nombre_hora}}
                                        </option>
                                    </select>                                                 
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="horafin" class="text-primary font-weight-bold">Hasta </label>
                                    <select class="form-control form-control-sm sansSerif border border-primary" id="horafin" v-model="dataPermiso.horafin" @change="onSelectChangePermiso($event,2)">
                                        <option value="">hasta</option>
                                        <option v-for="hor in horas" :value="hor.id" :key="hor.id">
                                            {{ hor.nombre_hora}}
                                        </option>
                                    </select>                                               
                                </div>
                            </div>                            
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="motivo" class="text-primary font-weight-bold">Motivo <span class="required-label"> *</span></label>
                                    <textarea class="form-control form-control-sm border border-primary" id="motivo" rows="4" v-model="dataPermiso.motivo"></textarea>                                
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-check">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" v-model="dataPermiso.lucro_cesante"/>
                                        <span class="form-check-sign text-primary font-weight-bold">Aplica Lucro Cesante</span>
                                    </label>
                                </div> 
                            </div>
                        </div>                      
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary" @click.prevent="ActionPermiso" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('permiso')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de empresas -->
        </modal>          
    </div>
            
</template>
<script>
import mixin from '../../mixins.js'
import  {_} from 'vue-underscore'
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'detallemedicos',
    mixins: [mixin],
    mounted() {
        $('#sandbox-container input').datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            multidate: true,
            todayHighlight: true,
            daysOfWeekDisabled: "0",
            daysOfWeekHighlighted: "0,1"
        });
                    
        $(".form-group-default .form-control").focus(function(){
            $(this).parent().addClass("active");
        }).blur(function(){
            $(this).parent().removeClass("active");
        })             

        this.$store.dispatch('LOAD_TURNOS_LIST')
        this.$store.dispatch('LOAD_TURNOS_ESPECIALES_LIST')        
        this.$store.dispatch('LOAD_DATA_INIT_LIST')
        this.$store.dispatch('LOAD_PERMISOS_LIST')
        this.$store.dispatch('LOAD_EMPLEADOS_LIST').then(() => {
            this.isLoading = false
        }) 
                               
    }, 
    beforeMount() {
        if(typeof this.EmpleadoById != 'undefined'){
            var datos = []
            datos = _.clone(this.EmpleadoById)
            this.dataEmpleado = {
                id: datos.id,
                tipodocumento_id:datos.tipodocumento_id,
                numero_documento:datos.numero_documento,
                nombres:datos.nombres,
                apellido_paterno:datos.apellido_paterno,
                apellido_materno:datos.apellido_materno,
                nombre_completo:datos.nombre_completo,
                fecha_nacimiento:datos.fecha_nacimiento,
                sexo:datos.sexo,
                direccion:datos.direccion,
                telefono:datos.telefono,
                celular:datos.celular,
                email:datos.email,
                foto:datos.foto,
                ubigeo_id:datos.ubigeo_id,
                COP:datos.COP,
                nconsultorio:datos.nconsultorio,
                tipocontrato_id:datos.tipocontrato_id,
                tipocontrato:datos.tipocontrato,
                useracceso_id:datos.useracceso,
                estadocivil_id:datos.estadocivil_id,
                tipopagodoctor_id:datos.tipopagodoctor_id,
                tipopagodoctor:datos.tipopagodoctor,
                porcentaje_interno:datos.porcentaje_interno,
                porcentaje_aseguradora:datos.porcentaje_aseguradora,
                fecha_ingreso:datos.fecha_ingreso,
                cargo_id:datos.cargo_id,
                user_id:datos.user_id,
                tipo:datos.tipo,
                ruc:datos.ruc,
                razon_social:datos.razon_social,
                username:datos.__user.name,
                perfil_id:datos.__user.perfil_id,
                acceso_system:datos.acceso_system,
                image:'', 
                sedes:datos.sedes,
                checkedSedes:[], 
                especialidades:datos.especialidades,
                checkedEspecialidades:[],
                ubigeo:datos.ubigeo,
                cargo:datos.cargo,
                tipodocumento:datos.tipodocumento       
            }             
            if(this.dataEmpleado.ubigeo_id != null){     
                this.coddepa = (this.departamentos.find(depa => depa.coddepa == this.dataEmpleado.ubigeo.coddepa)).coddepa
                this.codprov = (this.provincias.find(provi => provi.codprov == this.dataEmpleado.ubigeo.codprov)).codprov
                //this.dataEmpleado.ubigeo_id = this.distritos.find(dist => dist.id == this.dataEmpleado.ubigeo_id)
            }  
            var self = this
            this.dataEmpleado.sedes.map(function(value, key) {
                self.dataEmpleado.checkedSedes.push(value.id)
            })  
            this.dataEmpleado.especialidades.map(function(value, key) {
                self.dataEmpleado.checkedEspecialidades.push(value.id)
            })                      
        } 
    },
    data() {        
        return {
            isLoading: true,
            fullPage: true,  
             
            labelAccion: '',
            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos',  

            coddepa:'',
            codprov:'',
            columns: [
                {
                label: 'Sede',
                field: 'sede.nombre_sede',
                width:'30%',
                },  
                {
                label: 'Fecha',
                field: 'fecha_inicio',
                width:'20%',
                },  
                {
                label: 'Motivo Permiso',
                field: 'motivo',                
                width:'35%',
                },                                                                                                                                                         
                {
                label: 'Acción',
                field: 'btn',
                tdClass: 'center',
                thClass: 'center',
                html: true  ,
                width:'15%',  
                }                               
            ],
            dataEmpleado: {
                id:'',
                tipodocumento_id:'',
                numero_documento:'',
                nombres:'',
                apellido_paterno:'',
                apellido_materno:'',
                nombre_completo:'',
                fecha_nacimiento:'',
                sexo:'',
                direccion:'',
                telefono:'',
                celular:'',
                email:'',
                foto:'',
                ubigeo_id:'',
                COP:'',
                nconsultorio:'',
                tipocontrato_id:'',
                useracceo_id:'',
                estadocivil_id:'',
                tipopagodoctor_id:'',
                porcentaje_interno:'',
                porcentaje_aseguradora:'',
                fecha_ingreso:'',
                cargo_id:'',
                user_id:'',
                tipo:'',
                ruc:'',
                razon_social:'',
                username:'',
                perfil_id:'',
                acceso_system:false,
                image:'', 
                sedes:[],
                checkedSedes:[],
                especialidades:[],
                checkedEspecialidades:[],
                ubigeo:[],
                cargos:[],
                tipodocumento:[]          
            }, 
            dataHorario : {
                empleado_id:'',
                sede_id:'',
                user_id:'',
                dia_id:'',
                _dia:'',
                fecha:'',
                horaini1:'',
                _horaini1:'',
                horafin1:'',
                _horafin1:'',
                horaini2:'',
                _horaini2:'',
                horafin2:'',
                _horafin2:''
            }, 
            dataPermiso: {
                empleado_id:'',
                sede_id:'',
                fecha_inicio:'',
                fecha_fin:'',
                motivo:'',
                user_id:'',
                tipopermiso:'',
                horaini:'',
                _horaini:'',
                horafin:'',
                _horafin:'',
                lucro_cesante:false
            },          
            dias_select:[],
            fechas_select:[],
            sexos :[
                { id : 'H' , value : 'Hombre'},
                { id : 'M' , value : 'Mujer'}
            ],  
            tipopermisos :[
                { id : 1 , nombre_permiso : 'Por Dias'},
                { id : 2 , nombre_permiso : 'Por Horas'}
            ],              
            listTurnos:[],
            e_listTurnos:[],
            listSedes:[],
            mySede:'',
            dataTur:[],  
            permisosByDoctores:[],                           
            errors:[]                           
        }
    },
    computed: {
        ...mapState(['empleados','user_system','tipodocumentos','tipopagodoctores','tipocontratos','estadosciviles','sedes','especialidades','cargos','perfiles','dias','horas']),
        ...mapGetters(['getPersonal','getMedicos','getDocumentosIdentidad','getubigeos','getEmpleadoById','getHorasAM','getHorasPM','getTurnosEmpleadoById','getTurnosEspEmpleadoById','getPermisosByDoc']),
        departamentos: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.codprov == '00').filter((ubigeo) => ubigeo.coddist == '00')
        },
        provincias: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.coddepa == this.coddepa).filter((ubigeo) => ubigeo.codprov != '00').filter((ubigeo) => ubigeo.coddist == '00')
        },
        distritos: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.coddepa == this.coddepa).filter((ubigeo) => ubigeo.codprov == this.codprov).filter((ubigeo) => ubigeo.coddist != '00')
        },
        EmpleadoById: function(){
            return this.getEmpleadoById(this.$route.params.medico)
        },  
        dataTurnosEmpleado: function(){
            return this.getTurnosEmpleadoById(this.$route.params.medico)
        }, 
        dataTurnosEspEmpleado: function(){
            return this.getTurnosEspEmpleadoById(this.$route.params.medico)
        }, 
        permisosByDoc(){
            return this.getPermisosByDoc(this.$route.params.medico)
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
        addHorario(op) {        
            // validacion preliminares del turno
            if(!this.dataHorario.sede_id){
                this.notificaciones('Debe Seleccionar la sede del turno','la la-thumbs-o-down','danger')           
                return 
            }
            if(op == 1){    // turnos normales
                if(this.dias_select.length == 0){
                    this.notificaciones('Debe Seleccionar al menos un dia de la semana','la la-thumbs-o-down','danger')           
                    return 
                } 
            }else{
                this.fechas_select = ($('#fechas').val()).split(",")
                if(this.fechas_select.length == 0){
                    this.notificaciones('Debe Seleccionar al menos una fecha','la la-thumbs-o-down','danger')           
                    return 
                } 
            }
            if((!this.dataHorario.horaini1 || !this.dataHorario.horafin1) && (!this.dataHorario.horaini2 || !this.dataHorario.horafin2)){
                this.notificaciones('Debe Seleccionar al menos un Turno mañana o tarde','la la-thumbs-o-down','danger')           
                return
            }
            var self = this
            if(op == 1){
                _.each(self.dias_select , function(value,key){
                    // verificamos si el dia existe en la grilla
                    var enc = _.find(self.listTurnos, function(val){
                        return val.dia_id == value
                    });
                    if(typeof enc == 'undefined'){
                        let datita = []
                        datita = _.clone(self.dataHorario)
                        let day = self.dias.find(dia => dia.id == value)
                        datita.dia_id = day.id
                        datita._dia = day.nombre_dia
                        datita.empleado_id = self.$route.params.medico
                        datita.user_id = self.user_system.id  
                        self.listTurnos.push(datita)
                    }
                })
                self.listTurnos = _.sortBy(self.listTurnos,'dia_id')
            }else{
                _.each(self.fechas_select , function(value,key){
                    // verificamos si el dia existe en la grilla
                    var enc = _.find(self.e_listTurnos, function(val){
                        return val.fecha == value
                    });
                    if(typeof enc == 'undefined'){
                        let datita = []
                        datita = _.clone(self.dataHorario)
                        datita.fecha = value
                        datita.empleado_id = self.$route.params.medico
                        datita.user_id = self.user_system.id  
                        self.e_listTurnos.push(datita)
                    }
                })
                self.e_listTurnos = _.sortBy(self.e_listTurnos,'fecha')
                $('#fechas').val('')
            }
            this.clearControls()
        },
        createTurno: function(){
            var url = '/api/turnos';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.listTurnos).then(response => {
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

            this.$store.dispatch('LOAD_TURNOS_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('empleado');   
            this.notificaciones('Turnos creados con exito','la la-thumbs-up','success')       
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           

            });
        }, 
        e_createTurno: function(){
            var url = '/api/turnos-especiales';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.e_listTurnos).then(response => {
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

            this.$store.dispatch('LOAD_TURNOS_ESPECIALES_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('empleado');   
            this.notificaciones('Turnos creados con exito','la la-thumbs-up','success')       
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           

            });
        },  
        updateEmpleado: function(){
            var url = '/api/empleados/'+this.dataEmpleado.id; 
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.put(url, this.dataEmpleado).then(response => {
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

                this.$store.dispatch('LOAD_EMPLEADOS_LIST')                  
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
                this.$modal.hide('aseguradora');  
                this.notificaciones('El Médico fue actualizado con exito','la la-thumbs-up','success')                  
            }).catch(error => {
                this.errors = error.response.data.status;  
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')
            });
        },                           
        addSede (row) {
            var list=[];
            var ised = _.size(row)
            if(ised > 0){
                row.map(function(value, key) {
                    list.push(value.id)
                }) 
            } 
            this.dataEmpleado.checkedSedes = list          
        },
        addEspecialidad (row) {
            var list=[];
            var ised = _.size(row)
            if(ised > 0){
                row.map(function(value, key) {
                    list.push(value.id)
                }) 
            } 
            this.dataEmpleado.checkedEspecialidades = list          
        },        
        onFileChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) {
                this.dataEmpleado.image = null;
                return;
            }
            this.createImage(files[0]);
        },
        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.dataEmpleado.image = e.target.result;
            };
            reader.readAsDataURL(file);
        }, 
        onSelectChange(event,num){
            let valor =  moment(event.target.options[event.target.options.selectedIndex].text,'HH:mm')
            if(num == 1) {this.dataHorario._horaini1 = valor}
            if(num == 2) {this.dataHorario._horafin1 = valor}       
            if(num == 3) {this.dataHorario._horaini2 = valor}
            if(num == 4) {this.dataHorario._horafin2 = valor}

            if((typeof this.dataHorario._horaini1 != 'undefined') && (typeof this.dataHorario._horafin1 != 'undefined')){
                if(this.dataHorario._horaini1._isValid && this.dataHorario._horafin1._isValid){
                    if(this.dataHorario._horafin1.diff(this.dataHorario._horaini1,'minutes') <= 0){
                        this.notificaciones('TURNO MAÑANA : La hora inicial no puede ser igual o mayor a la hora final','la la-thumbs-o-down','danger')                
                        this.dataHorario.horaini1 = ''
                        $("#horaini1").focus()
                        return
                    } 
                }
            }
            if(typeof this.dataHorario._horaini2 != 'undefined' && typeof this.dataHorario._horafin2 != 'undefined'){
                if(this.dataHorario._horaini2._isValid && this.dataHorario._horafin2._isValid){                 
                    if(this.dataHorario._horafin2.diff(this.dataHorario._horaini2,'minutes') <= 0){
                        this.notificaciones('TURNO TARDE : La hora inicial no puede ser igual o mayor a la hora final','la la-thumbs-o-down','danger')                
                        this.dataHorario.horaini2 = ''
                        $("#horaini2").focus()
                        return
                    } 
                }   
            }                    
        },
        ProcessDelete(val){
            this.listTurnos.splice(val, 1);
        },
        e_ProcessDelete(val){
            this.e_listTurnos.splice(val, 1);
        },        
        cargaTurnos(ised){
            var self = this            
            this.listTurnos = []
            this.dataTur = []
            _.each(this.dataTurnosEmpleado.filter((tur) => tur.sede_id == ised) , function(value,key){
                let datitaget =[]
                datitaget = _.clone(value)
                self.dataTur = _.clone(self.dataHorario)
                self.dataTur = {
                    empleado_id:datitaget.empleado_id,
                    sede_id:datitaget.sede_id,
                    user_id:datitaget.user_id,
                    dia_id:datitaget.dia_id,
                    _dia:datitaget.dia.nombre_dia,
                    horaini1:datitaget.horaini1 == null ? '' : datitaget.horaini1.id ,
                    _horaini1:datitaget.horaini1 == null ? '' : moment(datitaget.horaini1.nombre_hora,"HH:mm"),
                    horafin1:datitaget.horafin1 == null ? '' : datitaget.horafin1.id,
                    _horafin1:datitaget.horafin1 == null ? '' : moment(datitaget.horafin1.nombre_hora,"HH:mm"),
                    horaini2:datitaget.horaini2 == null ? '' : datitaget.horaini2.id,
                    _horaini2:datitaget.horaini2 == null ? '' : moment(datitaget.horaini2.nombre_hora,"HH:mm"),
                    horafin2:datitaget.horafin2 == null ? '' : datitaget.horafin2.id,
                    _horafin2:datitaget.horafin2 == null ? '': moment(datitaget.horafin2.nombre_hora,"HH:mm")                   
                }
                self.listTurnos.push(self.dataTur)
            })
            this.clearControls()
        },
        e_cargaTurnos(ised){
            var self = this            
            this.e_listTurnos = []
            this.dataTur = []
            _.each(this.dataTurnosEspEmpleado.filter((tur) => tur.sede_id == ised) , function(value,key){
                let datitaget =[]
                datitaget = _.clone(value)
                self.dataTur = _.clone(self.dataHorario)
                self.dataTur = {
                    empleado_id:datitaget.empleado_id,
                    sede_id:datitaget.sede_id,
                    user_id:datitaget.user_id,
                    fecha:datitaget.fecha,
                    horaini1:datitaget.horaini1 == null ? '' : datitaget.horaini1.id ,
                    _horaini1:datitaget.horaini1 == null ? '' : moment(datitaget.horaini1.nombre_hora,"HH:mm"),
                    horafin1:datitaget.horafin1 == null ? '' : datitaget.horafin1.id,
                    _horafin1:datitaget.horafin1 == null ? '' : moment(datitaget.horafin1.nombre_hora,"HH:mm"),
                    horaini2:datitaget.horaini2 == null ? '' : datitaget.horaini2.id,
                    _horaini2:datitaget.horaini2 == null ? '' : moment(datitaget.horaini2.nombre_hora,"HH:mm"),
                    horafin2:datitaget.horafin2 == null ? '' : datitaget.horafin2.id,
                    _horafin2:datitaget.horafin2 == null ? '': moment(datitaget.horafin2.nombre_hora,"HH:mm")                   
                }
                self.e_listTurnos.push(self.dataTur)
            })
            this.clearControls()
        },
        cargaPermisos(ised){
            this.mySede = ised
            this.permisosByDoctores = this.permisosByDoc.filter((perm) => perm.sede_id == ised )
        },
        clearControls(){
            this.dataHorario.horaini1 = ''
            this.dataHorario.horafin1 = ''
            this.dataHorario.horaini2 = ''
            this.dataHorario.horafin2 = '' 
            this.dias_select = []
            this.fechas_select = []                       
        },
        BlankSede(){
            this.dataHorario.sede_id =''
            this.listTurnos = []
            this.e_listTurnos = []
            this.clearControls()
        },
        openedFn () {
            var self = this
            $('#sandbox-container2 input').datepicker({
                format: "dd-mm-yyyy",
                language: "es",
                todayHighlight: true,
                daysOfWeekDisabled: "0",
                daysOfWeekHighlighted: "0,1",
                autoclose:true
            }).on('changeDate', function (ev) {
                self.dataPermiso.fecha_inicio = $('#fechaini').val()                
            })
            $('#sandbox-container3 input').datepicker({
                format: "dd-mm-yyyy",
                language: "es",
                todayHighlight: true,                
                daysOfWeekDisabled: "0",
                daysOfWeekHighlighted: "0,1",
                autoclose:true
            }).on('changeDate', function (ev) {
                self.dataPermiso.fecha_fin = $('#fechafin').val()                
            })
            $('#sandbox-container4 input').datepicker({
                format: "dd-mm-yyyy",
                language: "es",
                todayHighlight: true,                
                daysOfWeekDisabled: "0",
                daysOfWeekHighlighted: "0,1",
                autoclose:true
            }).on('changeDate', function (ev) {
                self.dataPermiso.fecha_inicio = $('#fechauni').val()                
            })  
            if(typeof self.dataPermiso.id != 'undefined'){
                if(self.dataPermiso.tipopermiso == 1){
                    let feci = moment(self.dataPermiso.fecha_inicio,'DD-MM-YYYY')
                    $('#sandbox-container2 input').datepicker("update", new Date(feci.year(),feci.month(),feci.date()))                 
                    let fecf = moment(self.dataPermiso.fecha_fin,'DD-MM-YYYY')
                    $('#sandbox-container3 input').datepicker("update", new Date(fecf.year(),fecf.month(),fecf.date()))                 
                }else{
                    let fecu = moment(self.dataPermiso.fecha_inicio,'DD-MM-YYYY')
                    $('#sandbox-container4 input').datepicker("update", new Date(fecu.year(),fecu.month(),fecu.date()))                 
                }
            }                                
        },        
        LoadFormPermiso: function(){  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')         

            this.dataPermiso = {
                empleado_id:this.$route.params.medico,
                sede_id:this.mySede,
                fecha_inicio:'',
                fecha_fin:'',
                motivo:'',
                user_id:this.user_system.id,
                tipopermiso:'',
                horaini:'',
                horafin:'',
                lucro_cesante:false
            } 
            this.labelAccion = "Registro"       
            this.$modal.show('permiso')
        },         
        ActionPermiso: function(){
            if(typeof(this.dataPermiso.id) === "undefined"){
                this.createPermiso()
            }else{
                this.updatePermiso()
            }
        },
        createPermiso: function(){
            var url = '/api/permisos';
            this.StatusForm(true,'la la-spinner','Procesando')         
            axios.post(url, this.dataPermiso).then(response => {
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
            this.$store.dispatch('LOAD_PERMISOS_LIST').then(() => {
                this.cargaPermisos(this.mySede)
            })    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')                 
            this.$modal.hide('permiso');
            this.notificaciones('Nuevo Permiso creado con exito','la la-thumbs-up','success')            
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')                     
            });
        },
        updatePermiso: function(){
            var url = '/api/permisos/'+this.dataPermiso.id;
            this.StatusForm(true,'la la-spinner','Procesando')          
            axios.put(url, this.dataPermiso).then(response => {
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
                this.$store.dispatch('LOAD_PERMISOS_LIST').then(() => {
                    this.cargaPermisos(this.mySede)
                })                  
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.$modal.hide('permiso');
                this.notificaciones('el Permiso fue actualizado con exito','la la-thumbs-up','success')                                       

            }).catch(error => {
                this.errors = error.response.data.status;
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')                              
            });
        },
        processEditPermiso(params){
            var dataper = []
            dataper = _.clone(params.row)
 
            this.dataPermiso = {
                id:dataper.id,
                empleado_id:dataper.empleado_id,
                sede_id:dataper.sede_id,
                fecha_inicio:dataper.fecha_inicio,
                fecha_fin:dataper.fecha_fin,
                motivo:dataper.motivo,
                user_id:dataper.user_id,
                tipopermiso:dataper.tipopermiso,
                horaini:dataper.horaini,
                horafin:dataper.horafin,
                lucro_cesante:dataper.lucro_cesante
            }        
            this.labelAccion = "Actualización"                       
            this.$modal.show('permiso')       
        },
        processDeletePermiso(id){
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
                        var url = '/api/permisos/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_PERMISOS_LIST').then(() => {
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
        onSelectChangePermiso(event,num){
            let valor =  moment(event.target.options[event.target.options.selectedIndex].text,'HH:mm')
            if(num == 1) {this.dataPermiso._horaini = valor}
            if(num == 2) {this.dataPermiso._horafin = valor}       
            if((typeof this.dataPermiso._horaini != 'undefined') && (typeof this.dataPermiso._horafin != 'undefined')){
                if(this.dataPermiso._horaini._isValid && this.dataPermiso._horafin._isValid){
                    if(this.dataPermiso._horafin.diff(this.dataPermiso._horaini,'minutes') <= 0){
                        this.notificaciones('La hora inicial no puede ser igual o mayor a la hora final','la la-thumbs-o-down','danger')                
                        this.dataPermiso.horaini = ''
                        $("#horaini").focus()
                        return
                    } 
                }
            }                   
        },
    },        
    
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
    .sandbox-form label, .sandbox-form span {
        display: inline-block;
        margin: .5em .5em;
        vertical-align: middle;
    }
    .sandbox-form span label {
        vertical-align: baseline !important;
    }
    .datepicker .green {color: #0F0;}   
    .sansSerif {
        font-family:sans-serif !important;
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
    .table-sm th,
    .table-sm td {
        padding: 0.3rem !important; 
        font-size: 11px !important;
    } 
    .btn-xs {
        padding: 3px !important;
    }         
</style>
