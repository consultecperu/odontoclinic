<template>
    <div class="row">
        <loading :active.sync="isLoading"
            :background-color="'#000'" 
            :color="'red'"
            :can-cancel="false" 
            :is-full-page="fullPage">
        </loading>  
        <div class="col">
            <!-- START DEFAULT DATATABLE -->
            <div class="card text-white bg-white mb-3">
                <div class="card-header">                        
                    <div class="col pl-0 pr-0">
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-add-user"></i></span> Nuevo Paciente</button>
                        <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
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
                    :lineNumbers="true"
                    styleClass="vgt-table condensed bordered striped">
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'btn'" class="center">
                                <button type="button" v-tooltip="'Ver Paciente'" class="btn btn-border btn-primary btn-xs" @click.prevent="verPaciente(props.row)">
                                    <i class="la la-file-text font-large"></i>
                                </button>                                                                
                                <button type="button" v-tooltip="'Eliminar Medico'" class="btn btn-border btn-danger btn-xs" @click.prevent="processDelete(props.row.id)">
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
            <!-- END DEFAULT DATATABLE -->                                   
        </div>
        <!-- Modal de Creacion de pacientes-->
        <modal name="paciente" :width="'80%'" height="auto" transition="pop-out" :scrollable="true" :clickToClose="false" @opened="openedFn()">
            <!-- form de registro de medicos -->
                <div class="card mb-0">
                    <div class="card-header pt-5 pb-5">
                        <div class="card-title">Registro de Paciente</div>
                    </div>
                    <form role="form" method="POST" v-on:submit.prevent="createPaciente">                    
                        <div class="card-body pt-5">
                            <div class="row pr-10 pl-10">
                                <div class="col-md-3 pt-10">
                                    <div class="card card-profile card-secondary">
                                        <div class="card-header" style="background-image: url('/img/blogpost.jpg')">
                                            <div class="profile-picture">
                                                <img v-if="dataPaciente.image" :src="dataPaciente.image" alt="Imagen de Perfil">
                                                <img v-if="!dataPaciente.image" src="/images/pacientes/no-image.jpg" alt="Imagen de Perfil">
                                            </div>
                                        </div>
                                        <div class="card-body">
                                            <div class="user-profile text-center pt-20">
                                                <div class="view-profile">
                                                    <input type="file" class="form-control form-control-file" id="uploadImg" name="uploadImg" accept="image/*" @change="onFileChange" >
                                                    <label for="uploadImg" class=" label-input-file text-white btn btn-icon btn-primary btn-block"><i class="la la-file-image-o"></i> Cargar Imagen</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                    
                                <div class="col-9">
                                    <div class="row">
                                        <div class="col-12 pl-0">
                                            <p class="form-control-static text-secondary font-weight-bold mb-0">Datos Personales</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group row pb-0 pt-0">
                                                <label for="historia" class="col-4 pr-0 pl-0">Historia Clínica </label>
                                                <div class="col-8 pr-0">
                                                    <input type="text" class="form-control form-control-sm border-odonto" id="historia" name="historia" v-model="dataPaciente.historia_clinica" disabled>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group row pb-0 pt-0">
                                                <label for="sede" class="col-4 pl-0">Sede </label>
                                                <div class="col-8 pr-0">
                                                    <input type="text" class="form-control form-control-sm border-odonto" id="sede" name="sede" v-model="dataPaciente.sede" disabled>
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
                                                    <input type="text" class="form-control form-control-sm border-odonto" id="edad" name="edad" v-model="dataPaciente.edad" disabled>
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
                                                <label for="carnet" class="col-4 pl-0">Nº Carnet </label>
                                                <div class="col-8 pr-0">
                                                    <input type="text" class="form-control form-control-sm border-odonto mayusculas" name="carnet" v-model="dataPaciente.numero_carnet">
                                                </div>                                                
                                            </div>                                            
                                        </div> 
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
                                                <select id="distrito" name="distrito" class="form-control form-control-sm border-odonto" v-model="dataPaciente.ubigeo_id">
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
                                    <div class="row">
                                        <div class="col-12 pl-0">
                                            <p class="form-control-static text-secondary font-weight-bold mb-0">Asignación del Paciente</p>
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
                                        <div class="col-12 pl-0">
                                            <p class="form-control-static text-secondary font-weight-bold mb-0">Asignación del Plan</p>
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
                                                <label for="plan" class="col-4">{{ dataPaciente.tipo == 1 ? 'Elige Plan' : 'Aseguradora'}}<span class="required-label"> *</span></label>
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
                                                <label for="empresa" class="col-4">Empresa<span class="required-label"> *</span></label>
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
                                                <label for="poliza" class="col-4">Poliza<span class="required-label"> *</span></label>
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
                        <div class="card-action pt-10 mb-20">
                            <button class="btn btn-danger float-right ml-10" @click.prevent="$modal.hide('paciente')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                            <button type="submit" class="btn btn-primary float-right" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        </div>
                    </form>                    
                </div>
            <!-- /. form de registro de medicos -->
        </modal>                          
    </div>     
</template>
<script>
import mixin from '../../mixins.js'
import  {_} from 'vue-underscore'
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'pacientes',
    mixins: [mixin],
    mounted() {
        this.$store.dispatch('LOAD_DATA_INIT_PACIENTES_LIST')
        this.$store.dispatch('LOAD_SEDES_LIST')      
        this.$store.dispatch('LOAD_EMPLEADOS_LIST')   
        this.$store.dispatch('LOAD_PLANES_LIST')     
        this.$store.dispatch('LOAD_POLIZAS_LIST')    
        this.$store.dispatch('LOAD_PACIENTES_LIST').then(() => {
            this.isLoading = false
        })                              
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
            coddist:'',            
            columns: [
                {
                label: 'Doc',
                field: 'tipodocumento.abreviatura',
                thClass: 'center',
                tdClass: 'center',
                width:'10%',
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
                label: 'Hist.Clinica',
                field: 'historiaclinica',
                tdClass: 'center',                
                width:'10%',
                },                 
                {
                label: 'Paciente',
                field: 'nombre_completo',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },                 
                width:'60%',
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
            dataPaciente: {
                historiaclinica:'',
                sede:'',
                tipodocumento_id:'',
                numero_documento:'',
                apellido_paterno:'',
                apellido_materno:'',
                nombres:'',  
                sede_id:'',                              
                sexo:'',
                fecha_nacimiento:'',
                edad:'',
                apoderado:'',
                parentesco_apoderado_id:'',  
                telefono:'',
                celular:'',
                email:'',                
                estadocivil_id:'',
                motivocaptacion_id:'', 
                convenio_id:'',
                campania_id:'', 
                carnet:'',  
                telefono_mensajeria:'', 
                observacion:'',                                                                                            
                ubigeo_id:'',
                direccion:'',
                empleado_id:'', 
                asignacion_id:'', 
                tipo:'' ,
                plan_id:'',                                              
                titular:'',
                mensajeria:'',
                foto:'',
                condicion_id:'',
                fecha_ingreso:'',
                nombre_completo:'',
                historial:'',
                user_id:'',
                empresapaciente_id:'',
                poliza_id:'',
                image:''
            }, 
            sexos :[
                { id : 'H' , value : 'Hombre'},
                { id : 'M' , value : 'Mujer'}
            ], 
            tipoplanes:[
                {id: 1 , value : 'PLANES MULTIDENT'},
                {id: 2 , value : 'SEGUROS'}
            ], 
            menor_edad:false,
            getPlanes:[], 
            polizaspac:[],             
            errors:[]                                                
        }
    },
    computed: {
        ...mapState(['pacientes','user_system','sede_system','tipodocumentos','estadosciviles','sedes','motivocaptaciones','asignaciones','parentescos','empresapacientesplanes','planes','polizas','convenios','campañas']),
        ...mapGetters(['getubigeos','getMedicos','getDocumentosIdentidad','getplanes_aseguradoras','getPolizas']),
        departamentos: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.codprov == '00').filter((ubigeo) => ubigeo.coddist == '00');
        },
        provincias: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.coddepa == this.coddepa).filter((ubigeo) => ubigeo.codprov != '00').filter((ubigeo) => ubigeo.coddist == '00');
        },
        distritos: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.coddepa == this.coddepa).filter((ubigeo) => ubigeo.codprov == this.codprov).filter((ubigeo) => ubigeo.coddist != '00');
        }             
    }, 
    watch: {
        'dataPaciente.fecha_nacimiento' (newVal,oldVal) {
            if(moment(newVal,'DD-MM-YYYY',true).isValid()){
                this.dataPaciente.edad = moment().diff(moment(newVal, "DD-MM-YYYY"), 'years')
            }
            
        },
        'dataPaciente.edad' (newVal,oldVal) { 
            if(newVal < 18){
                this.menor_edad = true
            }else{
                this.menor_edad = false
            }
        },           
        'dataPaciente.celular'(newVal,oldVal){
            this.dataPaciente.telefono_mensajeria = newVal
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
        LoadForm: function(){  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')         

            this.dataPaciente = {
                historiaclinica:'',
                sede:this.sede_system.nombre_sede,                
                tipodocumento_id:'',
                numero_documento:'',
                sede_id:this.sede_system.id,
                nombres:'',
                apellido_paterno:'',
                apellido_materno:'',
                fecha_nacimiento:moment().format('DD-MM-YYYY'),
                sexo:'H',
                ubigeo_id:'',
                direccion:'',
                telefono:'',
                celular:'',                
                email:'',                
                estadocivil_id:'',
                motivocaptacion_id:'',
                telefono_mensajeria:'',
                titular:1,
                mensajeria:'',
                foto:'no-image.jpg',
                condicion_id:'',
                empleado_id:'',
                asignacion_id:'',
                fecha_ingreso:moment().format('DD-MM-YYYY'),
                nombre_completo:'',
                carnet:'',
                convenio_id:'',
                campania_id:'',
                observacion:'',
                apoderado:'',
                parentesco_apoderado_id:'',
                historial:'',
                user_id:this.user_system.id,
                tipo:1,
                plan_id:'',
                empresapaciente_id:'',
                poliza_id:'',
                image:'',
                edad:0
            }           
            this.SelectTipoPlan()
            this.$modal.show('paciente')                                                
        },         
        createPaciente: function(){
            var url = '/api/pacientes';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataPaciente).then(response => {
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
            //this.$modal.hide('paciente');   
            this.notificaciones('Nuevo Paciente creado con exito','la la-thumbs-up','success')   
            this.$swal({
                title: 'Desea Generar el Número de Historia Clinica?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, Generar!'
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true
                        var url = '/api/pacientes/actualizahc/' + response.data.idpaciente;
                        axios.put(url,this.dataPaciente).then(response=> {
                            this.isLoading = false
                            this.$swal(
                            'Actualizado!',
                            'La información fue registrada correctamente.',
                            'success'
                            )                                              
                        });
                    }
                });
            this.$modal.hide('paciente');                         
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           
            });
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
                        var url = '/api/pacientes/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_PACIENTES_LIST').then(() => {
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
        verPaciente: function(row){
            this.$router.push({ name: 'datos', params: { idpaciente: row.id }})
        },  
        openedFn () {
            $(".form-group-default .form-control").focus(function(){
                $(this).parent().addClass("active");
            }).blur(function(){
                $(this).parent().removeClass("active");
            })                      
        },       
        onFileChange(e) {
            let files = e.target.files || e.dataTransfer.files;
            if (!files.length) {
                this.dataPaciente.image = null;
                return;
            }
            this.createImage(files[0]);
        },
        createImage(file) {
            let reader = new FileReader();
            let vm = this;
            reader.onload = (e) => {
                vm.dataPaciente.image = e.target.result;
            };
            reader.readAsDataURL(file);
        }, 
        SelectTipoPlan(){
            this.getPlanes = this.planes.filter((pla) => pla.tipo == this.dataPaciente.tipo)
        },
        SelectPlan(){
            var self = this
            this.$store.dispatch('LOAD_EMPRESAPACIENTES_PLANES_EMPRESAS_LIST',{ id : this.dataPaciente.plan_id}).then(() => {
                this.isLoading = false
            })            
            _.each(this.planes , function(value,key){
                if(value.id == self.dataPaciente.plan_id){
                    self.dataPaciente.descripcion = value.descripcion 
                    return
                }
            })
        },
        SelectEmpresa(){
            this.polizaspac = this.getPolizas(this.dataPaciente.empresapaciente_id,this.dataPaciente.plan_id)       
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
    .form-control:disabled, .form-control[readonly] {
        border-color :#c1c4c7  !important;
    }  
    .pl-12 {
        padding-left: 12px !important;        
    } 
    .border-odonto {
        border-color: #c1c4c7 !important;
    }       
</style>
