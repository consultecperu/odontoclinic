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
                <div class="card-header pr-0 pt-0"> 
				    <div class="card-category">Laboratorio :</div>                    
                    <div class="card-title">{{ laboratorio.nombre_laboratorio}} </div> 
                    <div class="card-category mt-0 pb-10">Servicio :<span class="font-weight-bold">{{ nombre_servicio }}</span></div>
                    <div class="col border-top pt-20 pl-0">
                        <button type="button" class="btn btn-primary float-right" @click.prevent="LoadForm"><span class="btn-label"><i class="flaticon-add"></i></span> Agregar Servicio Multident</button>
                        <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="detalle_laboratorio_multident"
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
                                <button type="button" class="btn btn-border btn-danger btn-xs" v-tooltip="'Eliminar Servicio'" @click.prevent="processDelete(props.row)">
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
                        <div class="card-title">Agregar Servicio Multident</div>
                    </div>
                    <div class="card-body">
                        <div class="row pl-20">
                            <div class="col-12 pl-6 pb-10 pr-30">
                                <label for="basic" class="text-primary font-weight-bold pb-10">Servicio Multident <span class="required-label"> *</span></label>
                                <div class="select2-input">
                                    <select id="basic" name="basic" class="form-control form-control-sm border border-primary" v-model="dataLabser_servicio.servicio_id">
                                        <option value="">--Seleccione--</option>
                                        <option v-for="serlab in servicioslab" :value="serlab.id" :key="serlab.id">
                                            {{ serlab.nombre_servicio}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary" @click.prevent="AgregarServicioMultident" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
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
    name: 'detalle_laboratorios_multident',
    mixins: [mixin],  
    mounted() {  
        this.$store.dispatch('LOAD_SERVICIOS_LIST') 
        this.$store.dispatch('LOAD_LABORATORIOS_LIST')                        
        this.$store.dispatch('LOAD_LABORATORIOSERVICIOS_LIST').then(() => {
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
                field: 'nombre_servicio',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'90%',
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
            dataLabser_servicio : {
                id:'',
                servicio_id:'',
                user_id:''
            },                                                      
            errors:[] ,              

        }
    },
    computed: {
        ...mapState(['laboratorios','servicios','user_system','laboratorioservicios']),
        detalle_laboratorio_multident(){
            let labserv = this.laboratorioservicios.find((labser) => labser.id == this.$route.params.laboratorioservicio)
            if(labserv.servicios.length > 0){
                return labserv.servicios
            }
            return []
        },
        servicioslab(){
            return this.servicios.filter((ser) => ser.laboratorio == 1)
        },
        laboratorio(){
            return this.laboratorios.find((lab) => lab.id == this.$route.params.laboratorio)
        },
        nombre_servicio() {
            let nomser = this.laboratorioservicios.find((labser) => labser.id == this.$route.params.laboratorioservicio)
            return nomser.nombre_servicio
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

            this.dataLabser_servicio = {
                id:this.$route.params.laboratorioservicio,
                servicio_id:'',
                user_id:this.user_system.id
            },                
            this.$modal.show('servicio')
        }, 
        AgregarServicioMultident(){
            var url = '/api/laboratorioservicios/agregarserviciomultident/'+ this.dataLabser_servicio.id
            axios.put(url,this.dataLabser_servicio).then(response => {
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
                this.$store.dispatch('LOAD_LABORATORIOSERVICIOS_LIST')                  
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
                this.$modal.hide('servicio');
                this.notificaciones('el Servicio fue agregado con exito','la la-thumbs-up','success')                   
            }).catch(error => {
                this.errors = error.response.data.status;
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')                                             
            });
        },         
        processDelete(param){
            this.dataLabser_servicio = {
                id:this.$route.params.laboratorioservicio,
                servicio_id:param.pivot.servicio_id,
                user_id:this.user_system.id
            }
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
                        var url = '/api/laboratorioservicios/eliminarserviciomultident/' + this.$route.params.laboratorioservicio
                        axios.put(url , this.dataLabser_servicio).then(response=> {
                            this.$store.dispatch('LOAD_LABORATORIOSERVICIOS_LIST').then(() => {
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

    .pl-6 {
        padding-left: 6px !important;
    }
</style>
