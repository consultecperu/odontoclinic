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
                        <button type="button" class="btn btn-primary float-right" @click.prevent="NuevoPresupuesto"><span class="btn-label"><i class="flaticon-profile"></i></span> Nuevo Presupuesto</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="ppto_operatoria_paciente"
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
                                <button type="button" v-if="props.row.estadopresupuesto_id == 2" v-tooltip="'Ver Presupuesto'" class="btn btn-border btn-primary btn-xs" @click.prevent="verPpto(props.row)">
                                    <i class="la la-eye font-large"></i>
                                </button> 
                                <button type="button" v-if="props.row.estadopresupuesto_id == 1" v-tooltip="'Iniciar Tratamiento'" class="btn btn-border btn-primary btn-xs" @click.prevent="verPpto(props.row)">
                                    <i class="la la-check font-large"></i>
                                </button>                                 
                                <button type="button" v-if="props.row.estadopresupuesto_id == 2" v-tooltip="'Imprimir Presupuesto'" class="btn btn-border btn-warning btn-xs" @click.prevent="imprimirPpto(props.row)">
                                    <i class="la la-print font-large"></i>
                                </button>                                                                                               
                                <button type="button" v-tooltip="'Eliminar Presupuesto'" class="btn btn-border btn-danger btn-xs" @click.prevent="processDelete(props.row.id)">
                                    <i class="la la-trash-o font-large"></i>
                                </button>   
                                <button type="button" v-if="props.row.estadopresupuesto_id == 1" v-tooltip="'Editar Presupuesto'" class="btn btn-border btn-success btn-xs" @click.prevent="processEdit(props.row.id)">
                                    <i class="la la-pencil font-large"></i>
                                </button>                                                             
                            </span>
                            <span v-else-if="props.column.field == 'estadopresupuesto.nombre_estadopresupuesto'">
                                <span class="center badge" :class="{'badge-danger' : props.row.estadopresupuesto.nombre_estadopresupuesto == 'PENDIENTE','badge-primary' : props.row.estadopresupuesto.nombre_estadopresupuesto == 'PROCESO' , 'badge-success' : props.row.estadopresupuesto.nombre_estadopresupuesto == 'COMPLETADO' }">{{ props.row.estadopresupuesto.nombre_estadopresupuesto }}</span>                                
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
    </div>    
</template>
<script>
import mixin from '../../../mixins.js'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'lista_ppto_operatoria',
    mixins: [mixin],
    created() {  
        this.$store.dispatch('LOAD_TIPOCAMBIOS_LIST')
        this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST').then(() => {
            this.isLoading = false
        })                              
    },
    data(){
        return {
            isLoading: true,
            fullPage: true,
            columns: [
                {
                label: 'Codigo',
                field: 'id',
                tdClass: 'center',
                width:'10%',
                }, 
                {
                label: 'Odontologo Encargado',
                field: 'empleado.nombre_completo',            
                width:'33%',
                },
                {
                label: 'Fecha Registro',
                field: 'fecha_registro',
                tdClass: 'center',
                type: 'date',
                dateInputFormat: 'YYYY-MM-DD hh:mm:ss', 
                dateOutputFormat: 'DD-MM-YYYY',                 
                width:'10%',
                },                 
                {
                label: 'Total',
                field: 'pago_total', 
                type:'decimal',
                thClass: 'center',                
                tdClass: 'center',                               
                width:'12%',
                }, 
                {
                label: 'Estado',
                field: 'estadopresupuesto.nombre_estadopresupuesto',                
                width:'15%',
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

        }
    },
    computed:{
        ...mapState(['user_system','presupuestos_operatorias']),
        ...mapGetters(['getpptoOperatoriaPaciente','getTipoCambioHoy']),             
        ppto_operatoria_paciente(){
            return this.getpptoOperatoriaPaciente(this.$route.params.idpaciente)
        }        
    },
    methods:{
        NuevoPresupuesto(){
            let tipcam = this.getTipoCambioHoy
            if(tipcam == undefined){
                this.notificaciones('Debe registrar el Tipo de cambio de Hoy','la la-thumbs-o-down','danger')
                return
            }
            this.$router.push({ name: 'ppto-operatoria' , params: { idpresupuesto: null } })
        },
        processEdit(param){
            this.$router.push({ name: 'ppto-operatoria' , params: { idpresupuesto: param } })
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


