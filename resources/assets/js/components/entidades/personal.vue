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
                    <div class="col">
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-user-5"></i></span> Nuevo Personal</button>
                        <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    title="Listado de Personal"
                    :columns="columns"
                    :rows="getPersonal"
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
                                <button type="button" data-toggle="tooltip" title="" class="btn btn-border btn-primary btn-xs" data-original-title="Ver Detalle" @click.prevent="verPersonal(props.row.id)">
                                    <i class="la la-file-text font-large"></i>
                                </button>                                 
                                <button type="button" data-toggle="tooltip" title="" class="btn btn-border btn-success btn-xs" data-original-title="Actualizar Personal" @click.prevent="processEdit(props)">
                                    <i class="la la-edit font-large"></i>
                                </button>                                
                                <button type="button" data-toggle="tooltip" title="" class="btn btn-border btn-danger btn-xs" data-original-title="Eliminar Personal" @click.prevent="processDelete(props.row.id)">
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
        <!-- PAGE CONTENT MODAL -->  
        <modal name="personal" :width="'50%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de cargos -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Registro de Personal</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nombre">Nombre de Cargo</label>
                            <input type="text" id="nombre" placeholder="Nombre de Cargo" class="form-control input-sm mayusculas" v-model="dataCargo.nombre_cargo">
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary" @click.prevent="ActionCargo" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('cargo')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de cargos -->
        </modal>                         
    </div>  
</template>
<script>
import mixin from '../../mixins.js'
import  {_} from 'vue-underscore'
import MaskedInput from 'vue-masked-input'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'personal',
    mixins: [mixin],
    mounted() {
        this.$store.dispatch('LOAD_DATA_INIT_LIST')
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
            columns: [
                {
                label: 'Doc',
                field: 'tipodocumento.abreviatura',
                width:'10%',
                }, 
                {
                label: 'Número',
                field: 'numero_documento',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },             
                width:'15%',
                },
                {
                label: 'Empleado',
                field: 'nombre_completo',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },                 
                width:'20%',
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
                label: 'Cargo',
                field: 'cargo.nombre_cargo',
                width:'10%',
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

            dataEmpleado : {
                empresapaciente_id:'',                
                contacto:'',
                user_id:'',
                vigencia:'',
                fecha_inicio:'',
                fecha_finalizacion:'',
                email:'',
                telefono:''
            },                   
            errors:[]                                    
            
        }
    },
    computed: {
        ...mapState(['empleados','user_system']),
        ...mapGetters(['getPersonal','getMedicos'])    
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
        verPersonal: function(id){
            this.$router.push({ name: 'detallepersonal', params: { personal: id }})
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
</style>
