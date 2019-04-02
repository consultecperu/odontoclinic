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
                <div class="card-header pr-0"> 
				    <div class="card-category">Material :</div>                    
                    <div class="card-title">{{ material.nombre_material}} </div> 
                    <div class="col border-top pt-20 pl-0">
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-add"></i></span> Agregar Servicio</button>
                        <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="detalle_material"
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
                                <button type="button" class="btn btn-border btn-danger btn-xs" v-tooltip="'Eliminar Servicio'" @click.prevent="processDelete(props.row.id)">
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
        <modal name="servicio" :width="'35%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de planes -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">{{ labelAccion }} Servicio</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12 pb-10">
                                <label for="basic" class="text-primary font-weight-bold pb-10">Servicio <span class="required-label"> *</span></label>
                                <div class="select2-input">
                                    <select id="basic" name="basic" class="form-control form-control-sm border border-primary" v-model="dataMatservicio.servicio_id">
                                        <option value="">--Seleccione Servicio--</option>
                                        <option v-for="serv in servicio_materiales" :value="serv.id" :key="serv.id">
                                            {{ serv.nombre_servicio}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary" @click.prevent="createServicio" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('servicio')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
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
    name: 'detalle_materiales',
    mixins: [mixin],  
    mounted() {  
        this.$store.dispatch('LOAD_MATERIALES_LIST')            
        this.$store.dispatch('LOAD_SERVICIOS_LIST')              
        this.$store.dispatch('LOAD_MATERIALSERVICIOS_LIST').then(() => {
            this.isLoading = false
        })                             
    },
    data() {
        return {
            isLoading: true,
            fullPage: true,

            labelAccion:'',
            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos',  
            columns: [
                {
                label: 'Servicio',
                field: 'servicio.nombre_servicio',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'80%',
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
            dataMatservicio : {
                material_id:'',
                servicio_id:'',
                user_id:''
            },                                                      
            errors:[] ,              

        }
    },
    computed: {
        ...mapState(['servicios','user_system','materialservicios','materiales']),
        detalle_material(){
            if(this.materialservicios.length > 0){
                return this.materialservicios.filter((mat) => mat.material_id == this.$route.params.material)
            }
            return []
        },
        material(){
            return this.materiales.find((mat) => mat.id == this.$route.params.material)
        },
        servicio_materiales(){
            return this.servicios.filter((ser) => ser.materiales == 1)
        }       
    },
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },
        LoadForm: function(){  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')         

            this.dataMatservicio = {
                material_id:this.$route.params.material,
                servicio_id:'',
                user_id:this.user_system.id
            }   
            this.labelAccion = "Añadir"    
            this.$modal.show('servicio')
        }, 
        createServicio: function(){
            var url = '/api/materialservicios';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataMatservicio).then(response => {
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

            this.$store.dispatch('LOAD_MATERIALSERVICIOS_LIST')   
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('servicio');   
            this.notificaciones('Nuevo Servicio agregado con exito','la la-thumbs-up','success')       
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
                        var url = '/api/materialservicios/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_MATERIALSERVICIOS_LIST').then(() => {
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