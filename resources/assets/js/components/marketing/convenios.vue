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
                <div class="card-header pl-0 pr-0">                        
                    <div class="col">
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-agenda-1"></i></span> Nuevo Convenio</button>
                        <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="convenios"
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
                                <button type="button" class="btn btn-border btn-success btn-xs" v-tooltip="'Actualizar Convenio'" @click.prevent="processEdit(props)">
                                    <i class="la la-edit font-large"></i>
                                </button>                                
                                <button type="button" class="btn btn-border btn-danger btn-xs" v-tooltip="'Eliminar Convenio'" @click.prevent="processDelete(props.row.id)">
                                    <i class="la la-trash-o font-large"></i>
                                </button>                                
                            </span>
                            <span v-else-if="props.column.field == 'vigencia'">
                                <span class="center badge" :class="[props.row.vigencia == 1 ? 'badge-primary' : 'badge-danger']">{{ props.row.vigencia == 1 ? 'VIGENTE' : 'FINALIZADA'}}</span>
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
        <!-- form para seleccionar la empresa -->
        <modal id="empresas" name="empresas" width="50%" height="auto" :scrollable="true" :clickToClose="false">
            <div class="card mb-0">
                <div class="card-header">
                    <div class="card-title d-inline">Seleccione una Empresa</div>
                    <button type="button" class="close d-inline" aria-label="Close" @click.prevent="$modal.hide('empresas')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                     <div class="col">
                        <!-- START DEFAULT DATATABLE -->
                        <vue-good-table
                        :columns="columns_empresas"
                        :rows="empresapacientes"
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
                        @on-row-click="selectEmpresa"
                        max-height="400px"
                        styleClass="vgt-table condensed bordered striped"> 
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'btn'" class="center">
                                <button type="button" data-toggle="tooltip" title="" class="btn btn-primary btn-xs" data-original-title="" @click.prevent="selectEmpresa(props)">
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
        <modal name="convenio" :width="'40%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de convenios -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Registro de Nuevo Convenio</div>
                    </div>
                    <div class="card-body">
                        <div class="col-12 pl-10 pr-10">
                            <label for="basic" class="text-primary font-weight-bold pb-10">Empresa :</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control text-primary font-weight-bold" placeholder="Nombre de Empresa" aria-label="Recipient's username" aria-describedby="button-addon2" v-model="nom_emp" readonly>
                                <div class="input-group-append">
                                    <button class="btn btn-primary mr-5" type="button" id="button-addon2" @click.prevent="$modal.show('empresas')"><span class="btn-label"><i class="flaticon-multimedia"></i></span></button>
                                    <button class="btn btn-primary" type="button" id="button-addon3" @click.prevent="LoadFormEmpresa"><span class="btn-label"><i class="flaticon-add"></i></span></button>                                    
                                </div>
                            </div>                           
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group pt-0">
                                    <label for="" class="control-label">Fecha Inicio </label>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <masked-input v-model="dataConvenio.fecha_inicio" mask="11/11/1111" placeholder="DD/MM/YYYY" />
                                        </div>
                                    </div>
                                </div>                            
                            </div>  
                            <div class="col-6">
                                <div class="form-group pt-0 pl-0">
                                    <label for="" class="control-label">Fecha Finalización </label>
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 col-xs-12">
                                            <masked-input v-model="dataConvenio.fecha_finalizacion" mask="11/11/1111" placeholder="DD/MM/YYYY" />
                                        </div>
                                    </div>
                                </div>                            
                            </div>                          
                        </div>
                        <div class="col-12 pl-0 pr-0">
                            <div class="form-group pt-0">
                                <label for="nombre">Nombre del Contacto </label>
                                <input type="text" id="nombre" class="form-control form-control-sm mayusculas border border-primary" v-model="dataConvenio.contacto">
                            </div>                            
                        </div>                            
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group pt-0">
                                    <label for="nombre">Email </label>
                                    <input type="email" id="email" class="form-control form-control-sm mayusculas border border-primary" v-model="dataConvenio.email">
                                </div>  
                            </div>
                            <div class="col-6">
                                <div class="form-group pt-0">
                                    <label for="nombre">Teléfono </label>
                                    <input type="text" id="telefono" class="form-control form-control-sm border border-primary" maxlength="9" v-model="dataConvenio.telefono">
                                </div> 
                            </div>                          
                        </div>                     
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary" @click.prevent="ActionConvenio" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('convenio')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de convenios -->
        </modal> 
        <modal name="reg_empresa" :width="'35%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de empresas -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Registro de Nueva Empresa</div>
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                            <div class="form-group pt-0">
                                <label for="nombre">RUC</label>
                                <input type="text" id="ruc" class="form-control form-control-sm border border-primary" maxlength="11" v-model="dataEmpresa.ruc">
                            </div>                            
                        </div>
                        <div class="col-12">
                            <div class="form-group pt-0">
                                <label for="nombre">Razón Social </label>
                                <input type="text" id="razonsocial" class="form-control form-control-sm mayusculas border border-primary" v-model="dataEmpresa.razon_social">
                            </div>                            
                        </div>
                        <div class="col-12">
                            <div class="form-group pt-0">
                                <label for="nombre">Direccion </label>
                                <input type="text" id="direccion" class="form-control form-control-sm mayusculas border border-primary" v-model="dataEmpresa.direccion">
                            </div>                            
                        </div>                                                  
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary" @click.prevent="createEmpresa" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('reg_empresa')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de empresas -->
        </modal>                                 
    </div>     
</template>
<script>
import mixin from '../../mixins.js'
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'convenios',
    mixins: [mixin],
    mounted() {  
        this.$store.dispatch('LOAD_EMPRESAPACIENTES_LIST')
        this.$store.dispatch('LOAD_CONVENIOS_LIST').then(() => {
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
            columns: [
                {
                label: 'Empresa',
                field: 'empresapaciente.razon_social',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'30%',
                }, 
                {
                label: 'Fecha Inicio',
                field: 'fecha_inicio',
                type: 'date',
                dateInputFormat: 'YYYY-MM-DD', 
                dateOutputFormat: 'DD-MM-YYYY', 
                thClass:'center',
                tdClass:'center',               
                width:'13%',
                },
                {
                label: 'Fecha Final',
                field: 'fecha_finalizacion',
                type: 'date',
                dateInputFormat: 'YYYY-MM-DD', 
                dateOutputFormat: 'DD-MM-YYYY',
                thClass:'center', 
                tdClass:'center',                 
                width:'13%',
                }, 
                {
                label: 'Contacto',
                field: 'contacto',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'19%',
                },
                {
                label: 'Estado',
                field: 'vigencia',
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
            columns_empresas: [
                {
                label: 'RUC',
                field: 'ruc',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },                
                width:'20%',
                },                 
                {
                label: 'Razón Social',
                field: 'razon_social',
                filterOptions: {
                    enabled: true, 
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
                width:'20%',  
                }                               
            ],
            dataConvenio : {
                empresapaciente_id:'',                
                contacto:'',
                user_id:'',
                vigencia:'',
                fecha_inicio:'',
                fecha_finalizacion:'',
                email:'',
                telefono:''
            },
            dataEmpresa : {
                ruc:'',
                razon_social:'',
                ubigeo_id:'',
                direccion:'',
                telefono:'',
                celular:'',
                email:'',
                user_id:'',
                codigo:'',
            },              
            nom_emp:'',  
            emp_id:'',                      
            errors:[]                                    
        }
    },
    computed: {
        ...mapState(['empresapacientes','user_system','convenios'])      
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
            this.nom_emp = ''

            this.dataConvenio = {
                empresapaciente_id:'',                
                contacto:'',
                user_id:this.user_system.id,
                vigencia:1,
                fecha_inicio:'',
                fecha_finalizacion:'',
                email:'',
                telefono:''
            }           
            this.$modal.show('convenio')
        }, 
        LoadFormEmpresa: function(){  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')         
            this.nom_emp = ''
            this.dataEmpresa = {
                ruc:'',
                razon_social:'',
                ubigeo_id:'',
                direccion:'',
                telefono:'',
                celular:'',
                email:'',
                user_id:this.user_system.id,
                codigo:'',
            }           
            this.$modal.show('reg_empresa')
        },         
        ActionConvenio: function(){
            if(typeof(this.dataConvenio.id) === "undefined"){
                this.createConvenio()
            }else{
                this.updateConvenio()
            }
        },
        createConvenio: function(){
            var url = '/api/convenios';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataConvenio).then(response => {
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

            this.$store.dispatch('LOAD_CONVENIOS_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('convenio');   
            this.notificaciones('Nuevo Convenio creado con exito','la la-thumbs-up','success')       
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           

            });
        },
        updateConvenio: function(){
            var url = '/api/convenios/'+this.dataConvenio.id; 
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.put(url, this.dataConvenio).then(response => {
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

                this.$store.dispatch('LOAD_CONVENIOS_LIST')                  
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
                this.$modal.hide('convenio');  
                this.notificaciones('El Convenio fue actualizado con exito','la la-thumbs-up','success')                  
            }).catch(error => {
                this.errors = error.response.data.status;  
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')
            });
        },
        processEdit(params){
            var datacon = []
            datacon = _.clone(params.row)
            this.dataConvenio = {
                id:datacon.id,
                empresapaciente_id:datacon.empresapaciente_id,                
                contacto:datacon.contacto,
                user_id:this.user_system.id,
                vigencia:datacon.vigencia,
                fecha_inicio:moment(datacon.fecha_inicio).format("DD/MM/YYYY"),
                fecha_finalizacion:moment(datacon.fecha_finalizacion).format("DD/MM/YYYY"),
                email:datacon.email,
                telefono:datacon.telefono                                 
            } 
            this.nom_emp = datacon.empresapaciente.razon_social          
            this.$modal.show('convenio')
        
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
                        var url = '/api/convenios/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_CONVENIOS_LIST').then(() => {
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
        createEmpresa: function(){
            var url = '/api/empresapacientes';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataEmpresa).then(response => {
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

            this.$store.dispatch('LOAD_EMPRESAPACIENTES_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('reg_empresa');   
            this.notificaciones('Nueva Empresa creada con exito','la la-thumbs-up','success')       
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           

            });
        },        
        selectEmpresa: function(params){
            this.dataConvenio.empresapaciente_id = params.row.id
            this.nom_emp = params.row.razon_social
            this.$modal.hide('empresas')           
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
    #empresas {
        z-index:999999;
    }
</style>
