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
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-user-5"></i></span> Nuevo Cargo</button>
                        <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="cargos"
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
                                <button type="button" class="btn btn-border btn-success btn-xs" v-tooltip="'Actualizar Cargo'" @click.prevent="processEdit(props)">
                                    <i class="la la-edit font-large"></i>
                                </button>                                
                                <button type="button" class="btn btn-border btn-danger btn-xs" v-tooltip="'Eliminar Cargo'" @click.prevent="processDelete(props.row.id)">
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
        <modal name="cargo" :width="'35%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de cargos -->
                <div class="card mb-0">
                    <div class="card-header bg-primary pb-10 pt-10">
                        <div class="card-title pl-10 text-white">{{ labelAccion }} de Cargo</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group pt-0">
                            <label for="nombre" class="text-primary font-weight-bold mb-0">Nombre de Cargo <span class="required-label">(*)</span></label>
                            <input type="text" id="nombre" class="form-control form-control-sm border border-primary input-sm mayusculas" v-model="dataCargo.nombre_cargo">
                        </div>
                    </div>
                    <div class="card-action pt-20 pb-20">
                        <button class="btn btn-danger float-right ml-10" @click="$modal.hide('cargo')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                        <button class="btn btn-primary float-right" @click.prevent="ActionCargo" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                    </div>
                </div>
            <!-- /. form de registro de cargos -->
        </modal>                         
    </div>    
</template>
<script>
import mixin from '../../mixins.js'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'cargos',
    mixins: [mixin],
    mounted() {      
        this.$store.dispatch('LOAD_CARGOS_LIST').then(() => {
            this.isLoading = false
        })                          
    },     
    data() {
        return {
            isLoading: true,
            fullPage: true,

            labelAccion: '',
            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos',             
            columns: [
                {
                label: 'Nombre de Cargo',
                field: 'nombre_cargo',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'70%',
                },                                                                                                                                           
                {
                label: 'Acción',
                field: 'btn',
                tdClass: 'center',
                html: true  ,
                width:'30%',  
                }                               
            ],  
            dataCargo : {
                nombre_cargo:'',
                user_id:''
            },                                                               
            errors:[] ,
        }
    },
    computed: {
        ...mapState(['cargos','user_system']),
    }, 
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },
        LoadForm: function(){  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')         

            this.dataCargo = {
                nombre_cargo:'',
                user_id: this.user_system.id
            }
            this.labelAccion = "Registro"           
            this.$modal.show('cargo')
        }, 
        ActionCargo: function(){
            if(typeof(this.dataCargo.id) === "undefined"){
                this.createCargo()
            }else{
                this.updateCargo()
            }
        },
        createCargo: function(){
            var url = '/api/cargos';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataCargo).then(response => {
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

            this.$store.dispatch('LOAD_CARGOS_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('cargo');   
            //this.notificaciones('Nuevo cargo creado con exito','la la-thumbs-up','success')       
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')           

            });
        },
        updateCargo: function(){
            var url = '/api/cargos/'+this.dataCargo.id; 
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.put(url, this.dataCargo).then(response => {
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

                this.$store.dispatch('LOAD_CARGOS_LIST')                  
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
                this.$modal.hide('cargo');  
                //this.notificaciones('el Cargo fue actualizado con exito','la la-thumbs-up','success')                  
            }).catch(error => {
                this.errors = error.response.data.status;  
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')
            });
        },
        processEdit(params){
            var datacar = []
            datacar = _.clone(params.row)
            this.dataCargo = {
                id:datacar.id,
                nombre_cargo:datacar.nombre_cargo 
                                          
            }    
            this.labelAccion = "Actualizacíon"        
            this.$modal.show('cargo')
        
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
                        var url = '/api/cargos/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_CARGOS_LIST').then(() => {
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
</style>
