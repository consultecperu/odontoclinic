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
                        <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="citasPacienteById"
                    :paginationOptions="{
                        enabled: true,
                        dropdownAllowAll: false,
                        nextLabel: 'Sig',
                        prevLabel: 'Ant',
                        rowsPerPageLabel: 'Registros por Pagina',
                        ofLabel: 'de',
                        allLabel: 'Todos',
                    }"
                    :rowStyleClass="'enlace-mini'"
                    :lineNumbers="true"
                    styleClass="vgt-table condensed bordered striped">
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'btn'">
                                <button type="button" v-tooltip="'Ver Historial'" class="btn btn-info btn-xs" @click.prevent="verHistorial(props.row)">
                                    <i class="la la-eye font-large"></i>
                                </button>                             
                            </span>
                            <span v-else-if="props.column.field == 'estadocita.nombre_estadocita'" class="center">
                                <span class="center badge-mini badge badge-success">{{ props.row.estadocita.nombre_estadocita }}</span>             
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
        <modal name="historial_seguimiento" :width="'60%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- modal seguimiento de citas -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Historial de seguimiento de Cita</div>
                    </div>
                    <div class="card-body">
                        <div class="row pl-20" v-if="reprogramaciones_cita.length > 0">
                            <label class="text-primary font-weight-bold">Reprogramaciones : </label>
                        </div>
                        <div class="row" v-if="reprogramaciones_cita.length > 0">
                            <div class="col-12">
                                <table class="table table-bordered table-sm table-head-bg-info table-bordered-bd-info">
                                    <thead>
                                        <tr>
                                            <th scope="col"> * </th>
                                            <th scope="col">Fecha Incidencia</th>
                                            <th scope="col">Fecha / Hora Anterior</th>
                                            <th scope="col">Fecha / Hora Reprogramada</th>
                                            <th scope="col">Usuario</th>                                                                                                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(cit, index) in reprogramaciones_cita" :key="cit.id">
                                            <td>{{ index+1 }}</td>
                                            <td>{{ cit.fecha_incidencia }}</td>
                                            <td>{{ cit.fecha_anterior + ' / ' + cit.start_anterior + ' - ' + cit.end_anterior}}</td> 
                                            <td>{{ cit.fecha_nueva + ' / ' + cit.start_nueva + ' - ' + cit.end_nueva}}</td>  
                                            <td>{{ cit.user.__empleado.nombre_completo}}</td>                                                                                                                    
                                        </tr>
                                    </tbody>
                                </table>                                
                            </div>                       
                        </div>
                        <div class="row pl-20">
                            <label class="text-primary font-weight-bold">Historial de la cita : </label>
                        </div>                        
                        <div class="row">
                            <div class="col-12">
                                <table class="table table-bordered table-sm table-head-bg-info table-bordered-bd-info">
                                    <thead>
                                        <tr>
                                            <th scope="col"> * </th>
                                            <th scope="col">Fecha Incidencia</th>
                                            <th scope="col">Estado cita</th>
                                            <th scope="col">Usuario</th>                                                                                                                        
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-for="(cit, index) in seguimiento_cita" :key="cit.id">
                                            <td>{{ index+1 }}</td>
                                            <td>{{ cit.fecha_incidencia }}</td>
                                            <td>{{ cit.estadocita.nombre_estadocita}}</td> 
                                            <td>{{ cit.user.__empleado.nombre_completo}}</td>                                                                                                                    
                                        </tr>
                                    </tbody>
                                </table>                            
                            </div>
                        </div>                                          
                    </div>
                    <div class="card-action pt-15 pb-15">
                        <button class="btn btn-warning float-right" @click="$modal.hide('historial_seguimiento')"><span class="btn-label"><i class="la la-times-circle"></i> Cerrar</span></button>
                    </div>
                </div>
            <!-- /. modal seguimiento de citas -->
        </modal>                                  
    </div>        
</template>
<script>
import mixin from '../../../mixins.js'
import  {_} from 'vue-underscore'
import { mapState, mapGetters } from 'vuex'
export default {
    name:'citaspacientes',
    mixins: [mixin], 
    mounted(){          
        this.$store.dispatch('LOAD_CITAS_LIST').then(() => {
            this.isLoading = false
        })        
    },     
    data(){
        return {
            isLoading: true,
            fullPage: true, 
            
            columns: [
                {
                    label: 'ID',
                    field: 'id',
                    thClass: 'center',
                    tdClass: 'center',                    
                    width:'8%',
                }, 
                {
                    label: 'Odontólogo encargado',
                    field: 'empleado.nombre_completo',
                    filterOptions: {
                        enabled: false, 
                        placeholder: 'Buscar', 
                    },             
                    width:'35%',
                },
                
                {
                    label: 'Fecha cita',
                    field: 'fecha_cita', 
                    thClass: 'center',
                    tdClass: 'center',                                   
                    width:'15%',
                }, 
                {
                    label: 'Hora',
                    field: this.fieldFn,
                    thClass: 'center',
                    tdClass: 'center',                    
                    width:'20%',
                },                                                                                                                                                                                                                                       
                {
                    label: 'Estado',
                    field: 'estadocita.nombre_estadocita',
                    thClass: 'center',
                    tdClass: 'center',
                    width:'12%',  
                },
                {
                    label: 'Accion',
                    field: 'btn',
                    thClass: 'center',
                    tdClass: 'center',
                    html: true  ,
                    width:'10%',  
                }                                                
            ],
            reprogramaciones_cita :[],
            seguimiento_cita:[]            
        }
    },
    computed: {
        ...mapState(['user_system','tipodocumentos','estadosciviles','sedes','motivocaptaciones','asignaciones','parentescos','empresapacientesplanes','planes','polizas','pacientes','convenios','derivaciones','servicios','seguimientocitas']),
        ...mapGetters(['getubigeos','getMedicos','getDocumentosIdentidad','getplanes_aseguradoras','getPolizas','getPacienteById','getDependientesById','getSeguimientoPlanesbyPaciente','getcitasPacienteById']),           
        citasPacienteById(){
            return this.getcitasPacienteById(this.$route.params.idpaciente)
        }
                                        
    },  
    methods: {
        fieldFn(rowObj) {
            return rowObj.start + ' - ' + rowObj.end
        },
        verHistorial(param){
            let self = this
            self.reprogramaciones_cita = []
            self.seguimiento_cita = []
            _.each(param.seguimientocitas, function(value,key){
                if(value.reprogramado == 1){
                    self.reprogramaciones_cita.push(value)
                }else{
                    self.seguimiento_cita.push(value)
                }
            })
            this.$modal.show('historial_seguimiento')            
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
    .table-sm th,
    .table-sm td {
        padding: 0.3rem !important; 
        font-size: 11px !important;
    } 
    .btn-xs {
        padding: 3px !important;
    } 
</style>