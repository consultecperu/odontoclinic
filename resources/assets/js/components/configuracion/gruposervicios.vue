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
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-layers-1"></i></span> Nuevo Grupo</button>
                        <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    title="Listado de Grupo de Servicios"
                    :columns="columns"
                    :rows="gruposervicios"
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
                                <button type="button" data-toggle="tooltip" title="" class="btn btn-border btn-success btn-xs" data-original-title="Actualizar Grupo" @click.prevent="processEdit(props)">
                                    <i class="la la-edit font-large"></i>
                                </button>                                
                                <button type="button" data-toggle="tooltip" title="" class="btn btn-border btn-danger btn-xs" data-original-title="Eliminar Grupo" @click.prevent="processDelete(props.row.id)">
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
        <modal name="gruposervicio" :width="'50%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de gruposervicios -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title text-primary">{{ labelAccion }} de Grupo de Servicio</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nombre" class="text-primary">Nombre de Grupo de Servicio</label>
                            <input type="text" id="nombre" placeholder="Nombre de Grupo" class="form-control input-sm mayusculas" v-model="dataGruposervicio.nombre_gruposervicio">
                        </div>
                        <div class="form-check form-check-inline">
                            <div class="custom-control custom-radio">
                                <input type="radio" id="operatoria" name="customRadio" class="custom-control-input" value=1 v-model="dataGruposervicio.tipo" :checked="dataGruposervicio.tipo == 1" />
                                <label class="custom-control-label" for="operatoria">Operatoria</label>
                            </div>
                            <div class="custom-control custom-radio">
                                <input type="radio" id="ortodoncia" name="customRadio" class="custom-control-input" value=2 v-model="dataGruposervicio.tipo" :checked="dataGruposervicio.tipo == 2"/>
                                <label class="custom-control-label" for="ortodoncia">Ortodoncia</label>
                            </div>
                        </div>                        
                      
                    </div>                    
                    <div class="card-action">
                        <button class="btn btn-primary" @click.prevent="ActionGrupo" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('gruposervicio')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de perfiles -->
        </modal>                         
    </div>      
</template>
<script>
import mixin from '../../mixins.js'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'gruposervicios',
    mixins: [mixin],     
    mounted() {
        this.showToolTips()
        this.$store.dispatch('LOAD_GRUPOSERVICIOS_LIST').then(() => {
            this.isLoading = false
        })                          
    },     
    data() {
        return {
            isLoading: true,
            fullPage: true,
                        
            searchText: '', // If value is falsy, reset searchText & searchItem
            labelAccion:'',

            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos',             
            columns: [
                {
                label: 'Nombre de Grupo',
                field: 'nombre_gruposervicio',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'70%',
                },                                                                                                                                           
                {
                label: 'Acción',
                thClass: 'center',
                field: 'btn',
                tdClass: 'center',
                html: true  ,
                width:'30%',  
                }                               
            ],  
            dataGruposervicio : {
                nombre_gruposervicio:'',
                tipo: 1,
                user_id:''
            },                                                               
            errors:[]                          
        }
    },
    computed: {
        ...mapState(['gruposervicios','user_system']),
    }, 
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },           
        LoadForm: function(){     
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')                      
            this.dataGruposervicio = {
                nombre_gruposervicio:'',
                tipo: 1,
                user_id: this.user_system.id
            }  
            this.labelAccion = 'Registro'         
            this.$modal.show('gruposervicio')
        }, 
        ActionGrupo: function(){
            if(typeof(this.dataGruposervicio.id) === "undefined"){
                this.createGruposervicio()
            }else{
                this.updateGruposervicio()
            }
        },
        createGruposervicio: function(){
            var url = '/api/gruposervicios';
            this.StatusForm(true,'la la-spinner','Procesando')           
            axios.post(url, this.dataGruposervicio).then(response => {
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
            this.$store.dispatch('LOAD_GRUPOSERVICIOS_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')                           
            this.$modal.hide('gruposervicio');
            this.notificaciones('Nuevo Grupo de Servicio creado con exito','la la-thumbs-up','success')                  
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')                     
            });
        },
        updateGruposervicio: function(){
            var url = '/api/gruposervicios/'+this.dataGruposervicio.id;
            this.StatusForm(true,'la la-spinner','Procesando')            
            axios.put(url, this.dataGruposervicio).then(response => {
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
                this.$store.dispatch('LOAD_GRUPOSERVICIOS_LIST')                  
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')                            
                this.$modal.hide('gruposervicio'); 
                this.notificaciones('el Grupo de servicio fue actualizado con exito','la la-thumbs-up','success')                                       

            }).catch(error => {
                this.errors = error.response.data.status;
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')                              
               
            });
        },
        processEdit(params){
            var datagru = []
            datagru = _.clone(params.row)
            this.dataGruposervicio = {
                id:datagru.id,
                tipo:datagru.tipo,
                nombre_gruposervicio:datagru.nombre_gruposervicio 
                                          
            }     
            this.labelAccion = 'Actualización'       
            this.$modal.show('gruposervicio')
        
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
                        var url = '/api/gruposervicios/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_GRUPOSERVICIOS_LIST').then(() => {
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

    .form-control {
        border-color: #177DFF !important;
    }    
</style>
