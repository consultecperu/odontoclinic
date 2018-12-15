<template>
    <div class="row">
        <div class="col-md-3">
            <div class="card card-profile card-secondary">
                <div class="card-header" style="background-image: url('/img/blogpost.jpg')">
                    <div class="profile-picture">
                        <img :src="'/img/' + dataEmpleado.foto" alt="Profile Picture">
                    </div>
                </div>
                <div class="card-body">
                    <div class="user-profile text-center">
                        <div class="name">{{ dataEmpleado.numero_documento }}</div>
                        <div class="job">{{ dataEmpleado.nombre_completo }}</div>
                        <div class="desc">{{ dataEmpleado.cargo.nombre_cargo }}</div>

                        <div class="view-profile">
                            <a href="#" class="btn btn-secondary btn-block">Cambiar Imagen</a>
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
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#horarios" role="tab" aria-selected="false">Horarios</a> </li>
                            <li class="nav-item"> <a class="nav-link" data-toggle="tab" href="#settings" role="tab" aria-selected="false">Settings</a> </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane active" id="datos" role="tabpanel" aria-labelledby="datos-tab">
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
                                        <input type="text" class="form-control form-control-sm" name="numdoc" placeholder="Num.Documento" v-model="dataEmpleado.numero_documento">
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
                                        <input type="text" class="form-control" id="datepicker" name="datepicker" placeholder="Fecha de Nacimiento" v-model="dataEmpleado.fecha_nacimiento">
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
                                        <input type="text" class="form-control" id="dtpingreso" name="dtpingreso" placeholder="Fecha de Ingreso" v-model="dataEmpleado.fecha_ingreso">
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
                                        <input type="text" class="form-control form-control-sm" name="username" placeholder="Nombre de usuario" v-model="dataEmpleado.__user.name">
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group form-group-default border border-primary">
                                        <label for="perfil" class="text-primary font-weight-bold">Perfil de Acceso</label>
                                        <select class="form-control form-control-sm" id="perfil" v-model="dataEmpleado.__user.perfil_id">
                                            <option value="">-- Seleccione --</option>
                                            <option v-for="perfil in perfiles" :value="perfil.id" :key="perfil.id">
                                                {{ perfil.nombre_perfil}}
                                            </option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="text-right mt-3 mb-3">
                                <button class="btn btn-success">Actualizar</button>
                                <button class="btn btn-danger">Cancelar</button>
                            </div> 
                        </div>
                        <div class="tab-pane" id="horarios" role="tabpanel" aria-labelledby="horarios-tab">
                            <div class="row">
                                <div class="col-4">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group pl-0">
                                                <label for="tipodoc" class="text-primary font-weight-bold">Sede <span class="required-label"> *</span></label>
                                                <select class="form-control form-control-sm" id="tipodoc" v-model="dataHorario.sede_id">
                                                    <option value="">-- Seleccione Sede--</option>
                                                    <option v-for="sed in sedes" :value="sed.id" :key="sed.id">
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
                                                <select class="custom-select" size="6" multiple>
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
                                                <select class="form-control form-control-sm" id="tipodoc" v-model="dataHorario.hor1ini_id">
                                                    <option value="">desde</option>
                                                    <option v-for="hor in getHorasAM" :value="hor.id" :key="hor.id">
                                                        {{ hor.nombre_hora}}
                                                    </option>
                                                </select>                                                 
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group pl-0">
                                                <select class="form-control form-control-sm" id="tipodoc" v-model="dataHorario.hor1fin_id">
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
                                                <select class="form-control form-control-sm" id="tipodoc" v-model="dataHorario.hor2ini_id">
                                                    <option value="">desde</option>
                                                    <option v-for="hor in getHorasPM" :value="hor.id" :key="hor.id">
                                                        {{ hor.nombre_hora}}
                                                    </option>
                                                </select>                                              
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="form-group pl-0">
                                                <select class="form-control form-control-sm" id="tipodoc" v-model="dataHorario.hor2fin_id">
                                                    <option value="">hasta</option>
                                                    <option v-for="hor in getHorasPM" :value="hor.id" :key="hor.id">
                                                        {{ hor.nombre_hora}}
                                                    </option>
                                                </select>                                               
                                            </div>
                                        </div>
                                    </div> 
                                    <div class="row">
                                        <button type="button" class="btn btn-primary btn-block">AGREGAR HORARIO</button>
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
                                            <tr>
                                                <td>Lunes</td>
                                                <td>08:00</td>
                                                <td>08:30</td>
                                                <td>14:00</td>
                                                <td>16:00</td>
                                                <td><button type="button" class="btn btn-border btn-danger btn-xs" v-tooltip="'Eliminar'" ><i class="la la-trash-o font-large"></i></button></td>
                                            </tr>
                                            <tr>
                                                <td>Martes</td>
                                                <td>08:00</td>
                                                <td>08:30</td>
                                                <td>14:00</td>
                                                <td>16:00</td>
                                                <td><button type="button" class="btn btn-border btn-danger btn-xs" v-tooltip="'Eliminar'" ><i class="la la-trash-o font-large"></i></button></td>

                                            </tr>
                                            <tr>
                                                <td>Miercoles</td>
                                                <td>08:00</td>
                                                <td>08:30</td>
                                                <td>14:00</td>
                                                <td>16:00</td>
                                                <td><button type="button" class="btn btn-border btn-danger btn-xs" v-tooltip="'Eliminar'" ><i class="la la-trash-o font-large"></i></button></td>

                                            </tr>                                                                                        
                                        </tbody>
                                    </table>
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
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'detallepersonal',
    mixins: [mixin],
    mounted() {
        $(".form-group-default .form-control").focus(function(){
            $(this).parent().addClass("active");
        }).blur(function(){
            $(this).parent().removeClass("active");
        })             

        this.$store.dispatch('LOAD_DATA_INIT_LIST')
        this.$store.dispatch('LOAD_EMPLEADOS_LIST').then(() => {
            this.isLoading = false
        }) 
                               
    }, 
    beforeMount() {
        if(typeof this.dataEmpleado != 'undefined'){
            //this.show = false
            if(this.dataEmpleado.ubigeo_id != null){
                this.coddep = this.dataEmpleado.ubigeo.coddepa;
                this.codpro = this.dataEmpleado.ubigeo.codprov;
                this.coddis = this.dataEmpleado.ubigeo.coddist;          
                this.coddepa = (this.departamentos.find(depa => depa.coddepa == this.dataEmpleado.ubigeo.coddepa)).coddepa
                    if(this.codpro != '00'){
                        this.codprov = (this.provincias.find(provi => provi.codprov == this.dataEmpleado.ubigeo.codprov)).codprov
                    }
                    if(this.coddis != '00'){
                        this.dataEmpleado.ubigeo_id = this.distritos.find(dist => dist.value == this.dataEmpleado.ubigeo_id)
                    }
            }
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

            coddep:'',
            codpro:'',
            coddis:'',

            dataHorario : {
                sede_id:'',
                dia:'',
                hor1ini_id:'',
                hor1fin_id:'',
                hor2ini_id:'',
                hor2fin_id:''
            },
            
/*             dataEmpleado : {
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
                estado_civil:'',
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
            },  */
            sexos :[
                { id : 'H' , value : 'Hombre'},
                { id : 'M' , value : 'Mujer'}
            ],                               
            errors:[]                           
        }
    },
    computed: {
        ...mapState(['empleados','user_system','tipodocumentos','estadosciviles','sedes','cargos','perfiles']),
        ...mapGetters(['getPersonal','getMedicos','getDocumentosIdentidad','getubigeos','getEmpleadoById','getHorasAM','getHorasPM']),
        departamentos: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.codprov == '00').filter((ubigeo) => ubigeo.coddist == '00');
        },
        provincias: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.coddepa == this.coddepa).filter((ubigeo) => ubigeo.codprov != '00').filter((ubigeo) => ubigeo.coddist == '00');
        },
        distritos: function(){
            return this.getubigeos.filter((ubigeo) => ubigeo.coddepa == this.coddepa).filter((ubigeo) => ubigeo.codprov == this.codprov).filter((ubigeo) => ubigeo.coddist != '00');
        },
        dataEmpleado: function(){
            return this.getEmpleadoById(this.$route.params.personal);
        },                       
    },
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
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
</style>
