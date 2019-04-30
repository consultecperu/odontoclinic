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
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-profile"></i></span> Nuevo Médico</button>
                        <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="getMedicos"
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
                                <button type="button" v-tooltip="'Ver Medico'" class="btn btn-border btn-primary btn-xs" @click.prevent="verMedico(props.row.id)">
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
        <!-- Modal de Creacion de empleados-->
        <modal name="empleado" :width="'70%'" height="auto" transition="pop-out" :scrollable="true" :clickToClose="false" @opened="openedFn()">
            <!-- form de registro de medicos -->
                <div class="card mb-0">
                    <div class="card-header bg-primary pt-5 pb-5">
                        <div class="card-title text-white">Registro de Nuevo Odontólogo</div>
                    </div>
                        <form role="form" method="POST" v-on:submit.prevent="createEmpleado">                    
                            <div class="card-body pb-0">
                                <div class="row pr-10 pl-10">
                                    <div class="col-md-3">
                                        <div class="card card-profile card-primary">
                                            <div class="card-header">
                                                <div class="profile-picture">
                                                    <img v-if="dataEmpleado.image" :src="dataEmpleado.image" alt="Imagen de Perfil">
                                                    <img v-if="!dataEmpleado.image" src="/images/no-image.jpg" alt="Imagen de Perfil">
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
                                        <div class="row">
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
                                        <div class="row">
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
                                        <div class="row pb-10 pt-20">
                                            <div class="col-6">
                                                <label for="">Acceso al Sistema</label>
                                                <toggle-button :sync="true" :labels="{checked: 'SI', unchecked: 'NO'}" :color="{checked: '#005FD8', unchecked: '#FF0000', disabled: '#CCCCCC'}" v-model="dataEmpleado.acceso_system"/>                                
                                            </div>
                                        </div>
                                        <div class="row pb-10" v-show="dataEmpleado.acceso_system">
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
<!--                                             <div class="col-6">
                                                <div class="form-group form-group-default border border-primary">
                                                    <label for="perfil" class="text-primary font-weight-bold">Perfil de Acceso</label>
                                                    <select class="form-control form-control-sm" id="perfil" v-model="dataEmpleado.perfil_id" disabled>
                                                        <option value="">-- Seleccione --</option>
                                                        <option v-for="perfil in perfiles" :value="perfil.id" :key="perfil.id">
                                                            {{ perfil.nombre_perfil}}
                                                        </option>
                                                    </select>
                                                </div>
                                            </div> -->
                                        </div>                                      
                                    </div>
                                </div>

                            </div>
                            <div class="card-action pt-10 mb-20">
                                <button type="button" class="btn btn-danger float-right ml-10" @click.prevent="$modal.hide('empleado')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
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
    name: 'medicos',
    mixins: [mixin],
    mounted() {
        this.$store.dispatch('LOAD_DATA_INIT_LIST')
        this.$store.dispatch('LOAD_SEDES_LIST')
        this.$store.dispatch('LOAD_CARGOS_LIST')                
        this.$store.dispatch('LOAD_EMPLEADOS_LIST').then(() => {
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
                width:'7%',
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
                label: 'COP',
                field: 'COP',
                width:'7%',
                },                 
                {
                label: 'Empleado',
                field: 'nombre_completo',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },                 
                width:'31%',
                }, 
                {
                label: 'Teléfono',
                field: 'telefono',
                width:'15%',
                },
                {
                label: 'Email',
                field: 'email',
                width:'20%',
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
                useracceso_id:'',
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
                ruc:'',
                razon_social:'',
                sedes:[],
                checkedSedes:[],
                especialidades:[],
                checkedEspecialidades:[]     
            }, 
            sexos :[
                { id : 'H' , value : 'Hombre'},
                { id : 'M' , value : 'Mujer'}
            ],                
            errors:[]                                    
            
        }
    },
    computed: {
        ...mapState(['empleados','user_system','tipodocumentos','tipopagodoctores','tipocontratos','estadosciviles','especialidades','sedes','cargos','perfiles']),
        ...mapGetters(['getPersonal','getMedicos','getDocumentosIdentidad','getubigeos','getPerfilMedico']),
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

            this.dataEmpleado = {
                tipodocumento_id:'',
                numero_documento:'',
                nombres:'',
                apellido_paterno:'',
                apellido_materno:'',
                fecha_nacimiento:moment().format('DD/MM/YYYY'),
                sexo:'H',
                direccion:'',
                telefono:'',
                celular:'',
                email:'',
                foto:'no-image.jpg',
                ubigeo_id:'',
                COP:'',
                nconsultorio:'',
                tipocontrato_id:'',
                useracceso_id:'',
                estadocivil_id:'',
                tipopagodoctor_id:'',
                porcentaje_interno:'',
                porcentaje_aseguradora:'',
                fecha_ingreso:moment().format('DD/MM/YYYY'),
                cargo_id:'',
                user_id:this.user_system.id,
                tipo:1,
                username:'',
                perfil_id:this.getPerfilMedico.id,
                image:'',
                ruc:'',
                razon_social:'', 
                sedes:[],
                checkedSedes:[],
                especialidades:[],
                checkedEspecialidades:[]    
            }           
            this.$modal.show('empleado')                                                
        },         
        createEmpleado: function(){
            var url = '/api/empleados';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataEmpleado).then(response => {
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

            this.$store.dispatch('LOAD_EMPLEADOS_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('empleado');   
            this.notificaciones('Nuevo Personal creado con exito','la la-thumbs-up','success')       
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
                        var url = '/api/empleados/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_EMPLEADOS_LIST').then(() => {
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
        verMedico: function(id){
            this.$router.push({ name: 'detallemedicos', params: { medico: id }})
        },  
        openedFn () {
            $(".form-group-default .form-control").focus(function(){
                $(this).parent().addClass("active");
            }).blur(function(){
                $(this).parent().removeClass("active");
            })                      
        },
        addSede (row) {
            let list=[];
            let ised = _.size(row)
            if(ised > 0){
                row.map(function(value, key) {
                    list.push(value.id)
                }) 
            } 
            this.dataEmpleado.checkedSedes = list          
        },
        addEspecialidad (row) {
            let list=[];
            let ised = _.size(row)
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
