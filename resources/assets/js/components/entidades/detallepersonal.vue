<template>
    <div class="row">
        <div class="col-md-3">
            <div class="card card-profile card-secondary">
                <div class="card-header" style="background-image: url('/img/blogpost.jpg')">
                    <div class="profile-picture">
                        <img v-if="dataEmpleado.image" :src="dataEmpleado.image" alt="Imagen de Perfil">
                        <img v-if="!dataEmpleado.image" :src="'/images/' + dataEmpleado.foto" alt="Imagen de Perfil">                        
                    </div>
                </div>
                <div class="card-body">
                    <div class="user-profile text-center">
                        <div class="name">{{ dataEmpleado.numero_documento }}</div>
                        <div class="job">{{ dataEmpleado.nombre_completo }}</div>
                        <div class="desc">{{ dataEmpleado.cargo.nombre_cargo }}</div>

                        <div class="view-profile">
                            <input type="file" class="form-control form-control-file" id="uploadImg" name="uploadImg" accept="image/*" @change="onFileChange" >
                            <label for="uploadImg" class=" label-input-file text-white btn btn-icon btn-secondary btn-block"><i class="la la-file-image-o"></i> Cargar Imagen</label>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="row user-stats text-center">

                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <div class="card card-with-nav">
                <div class="card-header">
                    <div class="row">
                        <ul class="nav nav-tabs nav-line nav-color-secondary" role="tablist">
                            <li class="nav-item"> <a class="nav-link active show" data-toggle="tab" href="#datos" role="tab" aria-selected="true">Datos Personales</a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#horarios" role="tab" aria-selected="false" @click.prevent="BlankSede">Turnos Normales</a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#horespeciales" role="tab" aria-selected="false" @click.prevent="BlankSede">Turnos Especiales</a> </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="datos" role="tabpanel" aria-labelledby="datos-tab">
                            <form role="form" method="PUT" v-on:submit.prevent="updateEmpleado">                            
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default border border-primary">
                                            <label for="tipodoc" class="text-primary font-weight-bold">Tipo de Documento <span class="required-label"> *</span></label>
                                            <select class="form-control form-control-sm" id="tipodoc" v-model="dataEmpleado.tipodocumento_id">
                                                <option value="">-- Seleccione Tipo--</option>
                                                <option v-for="tipo in getDocumentosIdentidad" :value="tipo.id" :key="tipo.id">
                                                    {{ tipo.nombre_tipodocumento}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-group-default border border-primary" >
                                            <label for="numdoc" class="text-primary font-weight-bold">Num.Documento <span class="required-label"> *</span></label>
                                            <input type="text" class="form-control form-control-sm" name="numdoc" placeholder="Num.Documento" v-model="dataEmpleado.numero_documento" maxlength="9">
                                        </div>
                                    </div> 
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default border border-primary" >
                                            <label for="apepat" class="text-primary font-weight-bold">Apellido Paterno <span class="required-label"> *</span></label>
                                            <input type="text" class="form-control form-control-sm mayusculas" name="apepat" placeholder="Apellido Paterno" v-model="dataEmpleado.apellido_paterno">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-group-default border border-primary" >
                                            <label for="apemat" class="text-primary font-weight-bold">Apellido Materno <span class="required-label"> *</span></label>
                                            <input type="text" class="form-control form-control-sm mayusculas" name="apemat" placeholder="Apellido Materno" v-model="dataEmpleado.apellido_materno">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default border border-primary" >
                                            <label for="nombres" class="text-primary font-weight-bold">Nombres <span class="required-label"> *</span></label>
                                            <input type="text" class="form-control form-control-sm mayusculas" name="nombres" placeholder="Nombres" v-model="dataEmpleado.nombres">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default border border-primary">
                                            <label for="datepicker" class="text-primary font-weight-bold">Fecha de Nacimiento</label>
                                            <masked-input v-model="dataEmpleado.fecha_nacimiento" mask="11-11-1111" placeholder="DD-MM-YYYY" class="form-control"/>                                            
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-group-default border border-primary">
                                            <label for="tipodoc" class="text-primary font-weight-bold">Sexo <span class="required-label"> *</span></label>
                                            <select class="form-control form-control-sm" id="tipodoc" v-model="dataEmpleado.sexo">
                                                <option value="">-- Seleccione --</option>
                                                <option v-for="sexo in sexos" :value="sexo.id" :key="sexo.id">
                                                    {{ sexo.value}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default border border-primary" >
                                            <label for="telefono" class="text-primary font-weight-bold">Telefono</label>
                                            <input type="text" class="form-control form-control-sm" name="telefono" placeholder="Telefono" maxlength="8" v-model="dataEmpleado.telefono">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-group-default border border-primary" >
                                            <label for="celular" class="text-primary font-weight-bold">Celular</label>
                                            <input type="text" class="form-control form-control-sm" name="celular" placeholder="Celular" maxlength="9" v-model="dataEmpleado.celular">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default border border-primary" >
                                            <label for="email" class="text-primary font-weight-bold">Email <span class="required-label"> *</span></label>
                                            <input type="email" class="form-control form-control-sm" name="email" placeholder="Email" v-model="dataEmpleado.email">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-group-default border border-primary">
                                            <label for="estciv" class="text-primary font-weight-bold">Estado Civil</label>
                                            <select class="form-control form-control-sm" id="estciv" v-model="dataEmpleado.estadocivil_id">
                                                <option value="">-- Seleccione --</option>
                                                <option v-for="estado in estadosciviles" :value="estado.id" :key="estado.id">
                                                    {{ estado.nombre_estadocivil}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group form-group-default border border-primary">
                                            <label for="dtpingreso" class="text-primary font-weight-bold">Fecha de Ingreso</label>
                                            <masked-input v-model="dataEmpleado.fecha_ingreso" mask="11-11-1111" placeholder="DD-MM-YYYY" class="form-control"/>                                            
                                        </div>                                                
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group form-group-default border border-primary">
                                            <label for="basic" class="text-primary font-weight-bold">Departamento</label>
                                            <div class="select2-input">
                                                <select id="basic" name="basic" class="form-control form-control-sm border-primary" v-model="coddepa">
                                                    <option value="">--Seleccione--</option>
                                                    <option v-for="depa in departamentos" :value="depa.coddepa" :key="depa.id">
                                                        {{ depa.descripcion}}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group form-group-default border border-primary">
                                            <label for="basic2" class="text-primary font-weight-bold">Provincia</label>
                                            <div class="select2-input">
                                                <select id="basic2" name="basic2" class="form-control form-control-sm border-primary" v-model="codprov">
                                                    <option value="">--Seleccione--</option>
                                                    <option v-for="prov in provincias" :value="prov.codprov" :key="prov.id">
                                                        {{ prov.descripcion}}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="form-group form-group-default border border-primary">
                                            <label for="basic3" class="text-primary font-weight-bold">Distrito</label>
                                            <div class="select2-input">
                                                <select id="basic3" name="basic3" class="form-control form-control-sm border-primary" v-model="dataEmpleado.ubigeo_id">
                                                    <option value="">--Seleccione--</option>
                                                    <option v-for="dist in distritos" :value="dist.id" :key="dist.id">
                                                        {{ dist.descripcion}}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group form-group-default border border-primary" >
                                            <label for="direccion" class="text-primary font-weight-bold">Dirección</label>
                                            <input type="text" class="form-control form-control-sm" name="direccion" placeholder="Direccion" v-model="dataEmpleado.direccion">
                                        </div>                                                
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group border border-primary rounded pt-5">
                                            <label for="sede" class="text-primary font-weight-bold mb-0">Sede</label>
                                            <multiselect v-model="dataEmpleado.sedes" tag-placeholder="Agregar Sede" placeholder="Agregar Sede" label="nombre_sede" track-by="nombre_sede" :options="sedes" :multiple="true" :option-height="20" :taggable="true" @input="addSede" deselectLabel="Seleccione para eliminar" selectLabel="Presione para seleccionar" selectedLabel="Seleccionado"></multiselect>                                                    
                                        </div>
                                    </div>                                            
                                    <div class="col-6">
                                        <div class="form-group form-group-default border border-primary mb-0 pb-20">
                                            <label for="cargo" class="text-primary font-weight-bold">Cargo</label>
                                            <select class="form-control form-control-sm" id="cargo" v-model="dataEmpleado.cargo_id">
                                                <option value="">-- Seleccione --</option>
                                                <option v-for="cargo in cargos" :value="cargo.id" :key="cargo.id">
                                                    {{ cargo.nombre_cargo}}
                                                </option>
                                            </select>
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
                                        <div class="form-group form-group-default border border-primary" >
                                            <label for="usernme" class="text-primary font-weight-bold">Nombre de Usuario</label>
                                            <input type="text" class="form-control form-control-sm" name="username" placeholder="Nombre de usuario" v-model="dataEmpleado.username">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group form-group-default border border-primary">
                                            <label for="perfil" class="text-primary font-weight-bold">Perfil de Acceso</label>
                                            <select class="form-control form-control-sm" id="perfil" v-model="dataEmpleado.perfil_id" disabled>
                                                <option value="">-- Seleccione --</option>
                                                <option v-for="perfil in perfiles" :value="perfil.id" :key="perfil.id">
                                                    {{ perfil.nombre_perfil}}
                                                </option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="text-right mt-3 mb-3">
                                    <button tpe="submit" class="btn btn-primary" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                                    <button class="btn btn-danger">Cancelar</button>
                                </div> 
                            </form>
                        </div>
                        <div class="tab-pane" id="horarios" role="tabpanel" aria-labelledby="horarios-tab">
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
                                    <table class="table table-bordered table-head-bg-info table-bordered-bd-info mt-4">
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
                        <div class="tab-pane" id="horespeciales" role="tabpanel" aria-labelledby="horespeciales-tab">
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
                                    <table class="table table-bordered table-head-bg-info table-bordered-bd-info mt-4">
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
                     
                </div>
            </div>
        </div>
    </div>        
</template>
<script>
import mixin from '../../mixins.js'
import  {_} from 'vue-underscore'
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'detallepersonal',
    mixins: [mixin],
    mounted() {
        $('#sandbox-container input').datepicker({
            format: "dd/mm/yyyy",
            language: "es",
            multidate: true,
            daysOfWeekDisabled: "0,1",
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
                useracceso_id:datos.useracceso,
                estadocivil_id:datos.estadocivil_id,
                tipopagodoctor_id:datos.tipopagodoctor_id,
                porcentaje_interno:datos.porcentaje_interno,
                porcentaje_aseguradora:datos.porcentaje_aseguradora,
                fecha_ingreso:datos.fecha_ingreso,
                cargo_id:datos.cargo_id,
                user_id:datos.user_id,
                tipo:datos.tipo,
                username:datos.__user.name,
                perfil_id:datos.__user.perfil_id,
                acceso_system:datos.acceso_system,
                image:'', 
                sedes:datos.sedes,
                checkedSedes:[], 
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
        } 
    },
    data() {        
        return {
            isLoading: true,
            fullPage: true,  
             
            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos', 

            coddepa:'',
            codprov:'',

            dataEmpleado: {
                tipodocumento_id:'',
                numero_documento:'',
                nombres:'',
                apellido_paterno:'',
                apellido_materno:'',
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
                username:'',
                perfil_id:'',
                acceso_system:false,
                image:'', 
                sedes:[],
                checkedSedes:[]          
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
            dias_select:[],
            fechas_select:[],
            sexos :[
                { id : 'H' , value : 'Hombre'},
                { id : 'M' , value : 'Mujer'}
            ],  
            listTurnos:[],
            e_listTurnos:[],
            listSedes:[],
            dataTur:[],                             
            errors:[]                           
        }
    },
    computed: {
        ...mapState(['empleados','user_system','tipodocumentos','estadosciviles','sedes','cargos','perfiles','dias','horas']),
        ...mapGetters(['getPersonal','getMedicos','getDocumentosIdentidad','getubigeos','getEmpleadoById','getHorasAM','getHorasPM','getTurnosEmpleadoById','getTurnosEspEmpleadoById']),
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
            return this.getEmpleadoById(this.$route.params.personal)
        },  
        dataTurnosEmpleado: function(){
            return this.getTurnosEmpleadoById(this.$route.params.personal)
        }, 
        dataTurnosEspEmpleado: function(){
            return this.getTurnosEspEmpleadoById(this.$route.params.personal)
        },                                        
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
                        datita.empleado_id = self.$route.params.personal
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
                        datita.empleado_id = self.$route.params.personal
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
                this.notificaciones('El Personal fue actualizado con exito','la la-thumbs-up','success')                  
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
        }
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
</style>
