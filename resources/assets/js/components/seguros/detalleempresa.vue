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
                    <div class="col border-top pt-20">
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-add"></i></span> Agregar Aseguradora</button>
                        <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="empresapacientesplanes"
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
                                <button type="button" class="btn btn-border btn-danger btn-xs" v-tooltip="'Eliminar Tarifario'" @click.prevent="processDelete(props.row.id)">
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
        <modal name="aseguradora" :width="'50%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de planes -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Añadir Servicio al Plan</div>
                    </div>
                    <div class="card-body">

                        <div class="row">
                            <span class="col-12 pb-10">
                                <label class="text-primary font-weight-bold">Aseguradora :</label>
                            </span>                            
                            <div class="col">
                                <autocomplete class="border border-primary rounded"
                                ref="autocomplete"
                                placeholder="Buscar Servicio"
                                :source="getplanes_aseguradoras"
                                input-class="form-control form-control-sm"
                                results-value="id"
                                results-display="descripcion"
                                @selected="selectidAseguradora">
                                </autocomplete>                                
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary" @click.prevent="createAseguradora" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('aseguradora')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de planes -->
        </modal>  
                                 
    </div>       
</template>
<script>
import mixin from '../../mixins.js'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'detalle_empresas',
    mixins: [mixin],  
    mounted() {        
        this.$store.dispatch('LOAD_EMPRESAPACIENTES_PLANES_LIST',{ id : this.$route.params.empresa }).then(() => {
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
                label: 'RUC',
                field: 'plane.ruc',
                width:'20%',
                },                 
                {
                label: 'Nombre Aseguradora',
                field: 'plane.descripcion',
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
                width:'20%',  
                }                               
            ],  
            dataAseguradora : {
                empresapaciente_id:'',
                plane_id:''
            },                                                      
            errors:[] ,              

        }
    },
    computed: {
        ...mapState(['empresapacientes','user_system','empresapacientesplanes']),
        ...mapGetters(['getplanes_aseguradoras']),           
    },
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },
        LoadForm: function(){  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')         

            this.dataAseguradora = {
                empresapaciente_id:this.$route.params.empresa,
                plane_id:''
            }       
            this.$modal.show('aseguradora')
        }, 
        createAseguradora: function(){
            var url = '/api/empresapacientes/aseguradoras';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataAseguradora).then(response => {
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

            this.$store.dispatch('LOAD_EMPRESAPACIENTES_PLANES_LIST',{ id : this.$route.params.empresa })   
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('aseguradora');   
            this.notificaciones('Nueva Aseguradora agregada con exito','la la-thumbs-up','success')       
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
                        var url = '/api/empresapacientes/aseguradoras/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_EMPRESAPACIENTES_PLANES_LIST',{ id : this.$route.params.empresa }).then(() => {
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
        selectidAseguradora (group) {
            this.dataAseguradora.plane_id = group.value
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
