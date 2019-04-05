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
                    <div class="card-header">
                        <div class="card-title">Registro de Paciente</div>
                    </div>
                    <form role="form" method="POST" v-on:submit.prevent="createPaciente">                    
                        <div class="card-body">
                            <div class="row pr-10 pl-10">
                                <div class="col-md-3">
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
                                                    <label for="uploadImg" class=" label-input-file text-white btn btn-icon btn-secondary btn-block"><i class="la la-file-image-o"></i> Cargar Imagen</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                    
                                <div class="col-9">
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="form-control-static text-danger font-weight-bold">Datos Personales</p>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group form-group-default border border-primary" >
                                                <label for="historia" class="text-primary font-weight-bold">Historia Clínica <span class="required-label"> *</span></label>
                                                <input type="text" class="form-control form-control-sm" name="historia" placeholder="" v-model="dataPaciente.historia_clinica" disabled>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group form-group-default border border-primary">
                                                <label for="tipodoc" class="text-primary font-weight-bold">Tipo de Documento <span class="required-label"> *</span></label>
                                                <select class="form-control form-control-sm" id="tipodoc" v-model="dataPaciente.tipodocumento_id">
                                                    <option value="">-- Seleccione Tipo--</option>
                                                    <option v-for="tipo in getDocumentosIdentidad" :value="tipo.id" :key="tipo.id">
                                                        {{ tipo.nombre_tipodocumento}}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group form-group-default border border-primary" >
                                                <label for="numdoc" class="text-primary font-weight-bold">Num.Documento <span class="required-label"> *</span></label>
                                                <input type="text" class="form-control form-control-sm" name="numdoc" placeholder="Num.Documento" v-model="dataPaciente.numero_documento" maxlength="9">
                                            </div>
                                        </div>                                            
                                    </div>                                        
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group form-group-default border border-primary" >
                                                <label for="apepat" class="text-primary font-weight-bold">Apellido Paterno <span class="required-label"> *</span></label>
                                                <input type="text" class="form-control form-control-sm mayusculas" name="apepat" placeholder="Apellido Paterno" v-model="dataPaciente.apellido_paterno">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group form-group-default border border-primary" >
                                                <label for="apemat" class="text-primary font-weight-bold">Apellido Materno <span class="required-label"> *</span></label>
                                                <input type="text" class="form-control form-control-sm mayusculas" name="apemat" placeholder="Apellido Materno" v-model="dataPaciente.apellido_materno">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group form-group-default border border-primary" >
                                                <label for="nombres" class="text-primary font-weight-bold">Nombres <span class="required-label"> *</span></label>
                                                <input type="text" class="form-control form-control-sm mayusculas" name="nombres" placeholder="Nombres" v-model="dataPaciente.nombres">
                                            </div>
                                        </div>                                            
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group form-group-default border border-primary">
                                                <label for="tipodoc" class="text-primary font-weight-bold">Sexo <span class="required-label"> *</span></label>
                                                <select class="form-control form-control-sm" id="tipodoc" v-model="dataPaciente.sexo">
                                                    <option value="">-- Seleccione --</option>
                                                    <option v-for="sexo in sexos" :value="sexo.id" :key="sexo.id">
                                                        {{ sexo.value}}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group form-group-default border border-primary">
                                                <label for="datepicker" class="text-primary font-weight-bold">Fecha de Nacimiento</label>
                                                <masked-input v-model="dataPaciente.fecha_nacimiento" mask="11-11-1111" placeholder="DD-MM-YYYY" class="form-control"/>                                            
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group form-group-default border border-primary" >
                                                <label for="edad" class="text-primary font-weight-bold">Edad</label>
                                                <input type="text" class="form-control form-control-sm" name="edad" v-model="dataPaciente.edad" disabled>
                                            </div>
                                        </div>                                                                                       
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group form-group-default border border-primary" >
                                                <label for="telefono" class="text-primary font-weight-bold">Telefono</label>
                                                <input type="text" class="form-control form-control-sm" name="telefono" placeholder="Telefono" maxlength="8" v-model="dataPaciente.telefono">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group form-group-default border border-primary" >
                                                <label for="celular" class="text-primary font-weight-bold">Celular<span class="required-label"> *</span></label>
                                                <input type="text" class="form-control form-control-sm" name="celular" placeholder="Celular" maxlength="9" v-model="dataPaciente.celular">
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group form-group-default border border-primary" >
                                                <label for="telefono_mensajeria" class="text-primary font-weight-bold">Nº Mensajeria</label>
                                                <input type="text" class="form-control form-control-sm" name="telefono_mensajeria" placeholder="Tel.Mensajeria" v-model="dataPaciente.telefono_mensajeria">
                                            </div>
                                        </div>                                                                                        
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group form-group-default border border-primary" >
                                                <label for="email" class="text-primary font-weight-bold">Email </label>
                                                <input type="email" class="form-control form-control-sm" name="email" placeholder="Email" v-model="dataPaciente.email">
                                            </div>
                                        </div>                                             
                                        <div class="col-4">
                                            <div class="form-group form-group-default border border-primary">
                                                <label for="estciv" class="text-primary font-weight-bold">Estado Civil</label>
                                                <select class="form-control form-control-sm" id="estciv" v-model="dataPaciente.estadocivil_id">
                                                    <option value="">-- Seleccione --</option>
                                                    <option v-for="estado in estadosciviles" :value="estado.id" :key="estado.id">
                                                        {{ estado.nombre_estadocivil}}
                                                    </option>
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-4">
                                            <div class="form-group form-group-default border border-primary">
                                                <label for="captaciones" class="text-primary font-weight-bold">Captación<span class="required-label"> *</span></label>
                                                <select class="form-control form-control-sm" id="captaciones" v-model="dataPaciente.motivocaptacion_id">
                                                    <option value="">-- Seleccione --</option>
                                                    <option v-for="cap in motivocaptaciones" :value="cap.id" :key="cap.id">
                                                        {{ cap.nombre_motivocaptacion}}
                                                    </option>
                                                </select>
                                            </div>                                                
                                        </div>                                            
                                    </div>
                                    <div class="row">
                                        <div class="col-4">
                                            <div class="form-group form-group-default border border-primary" >
                                                <label for="carnet" class="text-primary font-weight-bold">Nº Carnet</label>
                                                <input type="text" class="form-control form-control-sm" name="carnet" placeholder="Carnet" v-model="dataPaciente.numero_carnet">
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="form-group form-group-default border border-primary" >
                                                <label for="observaciones" class="text-primary font-weight-bold">Observaciones</label>
                                                <input type="text" class="form-control form-control-sm" name="observaciones" placeholder="" v-model="dataPaciente.observaciones">
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
                                                    <select id="basic3" name="basic3" class="form-control form-control-sm border-primary" v-model="dataPaciente.ubigeo_id">
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
                                                <input type="text" class="form-control form-control-sm" name="direccion" placeholder="Direccion" v-model="dataPaciente.direccion">
                                            </div>                                                
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="form-control-static text-danger font-weight-bold">Asignación del Paciente</p>
                                        </div>
                                    </div>                                        
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group form-group-default border border-primary">
                                                <label for="medico" class="text-primary font-weight-bold">Médico<span class="required-label"> *</span></label>
                                                <select class="form-control form-control-sm" id="medico" v-model="dataPaciente.empleado_id">
                                                    <option value="">-- Seleccione --</option>
                                                    <option v-for="med in getMedicos" :value="med.id" :key="med.id">
                                                        {{ med.nombre_completo}}
                                                    </option>
                                                </select>
                                            </div>  
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group form-group-default border border-primary">
                                                <label for="asignacion" class="text-primary font-weight-bold">Asignación<span class="required-label"> *</span></label>
                                                <select class="form-control form-control-sm" id="asignacion" v-model="dataPaciente.asignacion_id">
                                                    <option value="">-- Seleccione --</option>
                                                    <option v-for="asig in asignaciones" :value="asig.id" :key="asig.id">
                                                        {{ asig.nombre_asignacion}}
                                                    </option>
                                                </select>
                                            </div>  
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <div class="col-12">
                                            <p class="form-control-static text-danger font-weight-bold">Asignación del Plan</p>
                                        </div>
                                    </div>                                        
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="form-group form-group-default border border-primary">
                                                <label for="tipoplan" class="text-primary font-weight-bold">Tipo Plan<span class="required-label"> *</span></label>
                                                <select class="form-control form-control-sm" id="tipoplan" v-model="dataPaciente.tipo" @change="SelectTipoPlan">
                                                    <option value="">-- Seleccione --</option>
                                                    <option v-for="tip in tipoplanes" :value="tip.id" :key="tip.id">
                                                        {{ tip.value}}
                                                    </option>
                                                </select>
                                            </div>                                              
                                        </div> 
                                        <div class="col-6">
                                            <div class="form-group form-group-default border border-primary">
                                                <label for="plan" class="text-primary font-weight-bold">{{ dataPaciente.tipo == 1 ? 'Elige Plan' : 'Aseguradora'}}<span class="required-label"> *</span></label>
                                                <select class="form-control form-control-sm" id="plan" v-model="dataPaciente.plan_id"  @change="SelectPlan">
                                                    <option value="">-- Seleccione --</option>
                                                    <option v-for="pla in getPlanes" :value="pla.id" :key="pla.id">
                                                        {{ pla.descripcion}}
                                                    </option>
                                                </select>
                                            </div>                                              
                                        </div>                                                                                                                                                    
                                    </div>
                                    <div class="row" v-show="dataPaciente.tipo == 2">
                                        <div class="col-6">
                                            <div class="form-group form-group-default border border-primary">
                                                <label for="empresa" class="text-primary font-weight-bold">Empresa<span class="required-label"> *</span></label>
                                                <select class="form-control form-control-sm" id="empresa" v-model="dataPaciente.empresapaciente_id" @change="SelectEmpresa">
                                                    <option value="">-- Seleccione --</option>
                                                    <option v-for="emp in empresapacientesplanes" :value="emp.empresapaciente.id" :key="emp.empresapaciente.id">
                                                        {{ emp.empresapaciente.razon_social}}
                                                    </option>
                                                </select>
                                            </div>                                              
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group form-group-default border border-primary">
                                                <label for="poliza" class="text-primary font-weight-bold">Poliza<span class="required-label"> *</span></label>
                                                <select class="form-control form-control-sm" id="poliza" v-model="dataPaciente.poliza_id">
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
                        <div class="card-action">
                            <button type="submit" class="btn btn-primary" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                            <button class="btn btn-danger" @click.prevent="$modal.hide('paciente')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
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
                empresapaciente_id:'',
                poliza_id:'',
                descripcion:'',
                image:'',
                edad:''
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
            errors:[]                                                
        }
    },
    computed: {
        ...mapState(['pacientes','user_system','tipodocumentos','estadosciviles','sedes','motivocaptaciones','asignaciones','parentescos','empresapacientesplanes','planes','polizas']),
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
                tipodocumento_id:'',
                numero_documento:'',
                sede_id:1,
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
                historiaclinica:'',
                observacion:'',
                apoderado:'',
                parentesco_apoderado_id:'',
                historial:'',
                user_id:this.user_system.id,
                tipo:1,
                plan_id:'',
                empresapaciente_id:'',
                poliza_id:'',
                descripcion:'',
                image:'',
                edad:''
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
</style>
