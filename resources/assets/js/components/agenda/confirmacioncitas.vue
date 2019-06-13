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
                        <div class="row mt-20">
                            <div class="col-3">
                                <div class="form-group form-floating-label">
                                    <select ref="sedes" class="form-control input-border-bottom" id="selectSedes" v-model="dataFiltro.empleado_id" required>
                                        <option value="0">--Todos--</option>
                                        <option v-for="doc in doc_sede" :value="doc.id" :key="doc.id">
                                            {{ doc.nombre_completo}}
                                        </option>
                                    </select>
                                    <label for="selectSedes" class="placeholder">Odontólogos</label>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group row pt-0 d-inline">
                                    <label for="fecha" class="col-12 pl-10 mb-0 label-title">Desde: </label>
                                    <date-picker v-model="dataFiltro.fecha_desde" :first-day-of-week="1" :lang="lang" format="DD-MM-YYYY"></date-picker>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group row pt-0 d-inline">
                                    <label for="fecha" class="col-12 pl-10 mb-0 label-title">Hasta: </label>
                                    <date-picker v-model="dataFiltro.fecha_hasta" :first-day-of-week="1" :lang="lang" format="DD-MM-YYYY"></date-picker>
                                </div>
                            </div>
                            <div class="col-3 pl-0 pt-20">
                                <div class="form-group row pt-20npm d-inline">
                                    <button type="button" class="btn btn-sm btn-primary" @click.prevent="cargaDatosCitas"><span class="btn-label"><i class="la la-search-plus"></i></span>Consultar</button>
                                </div>
                            </div>
                        </div>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="citasOdo_Sede"
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
                                <button v-if="props.row.confirmado == 0" type="button" v-tooltip="'Confirmar Cita'" class="btn btn-primary btn-xs" @click.prevent="processConfirmacion(props.row)">
                                    <i class="la la-check font-large"></i>
                                </button>                                
                            </span>
                            <span v-else-if="props.column.field == 'confirmado'">
                                <span class="center badge-mini badge badge-danger" v-if="props.row.confirmado == 0" v-text="'NO'"></span>                                
                                <span class="center badge-mini badge badge-success" v-if="props.row.confirmado == 1" v-text="'SI'"></span>                                
                            </span> 
                            <span v-else-if="props.column.field == 'fecha'">
                                <strong>{{ props.row.fecha_cita}}</strong> {{ props.row.start }} - {{ props.row.end }}  
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
import mixin from '../../mixins.js'
import  {_} from 'vue-underscore'
import { mapState, mapGetters } from 'vuex'

export default {
    name: 'confirmacioncitas',
    mixins: [mixin],
    created(){
        this.$store.dispatch('LOAD_EMPLEADOS_LIST')
        this.$store.dispatch('LOAD_DATA_INIT_LIST') 
        this.$store.dispatch('LOAD_CITAS_LIST')             
    },
    data() {
        return {
            isLoading: false,
            fullPage: true, 
            
            dataFiltro:{
                empleado_id:'',
                fecha_desde:new Date(),
                fecha_hasta:new Date()
            },
            lang: {
                days: ['Dom', 'Lun', 'Mar', 'Mie', 'Jue', 'Vie', 'Sab'],
                months: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct', 'Nov', 'Dic'],
                pickers: ['next 7 days', 'next 30 days', 'previous 7 days', 'previous 30 days'],
                placeholder: {
                    date: 'Seleccione Dia',
                    dateRange: 'Select Date Range'
                }
            },
            columns: [
                {
                label: 'Paciente',
                field: 'paciente.nombre_completo',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },                 
                width:'25%',
                }, 
                {
                label: 'Doctor',
                field: 'empleado.nombre_completo',            
                width:'18%',
                },
                {
                label: 'Celular',
                field: 'paciente.celular',
                width:'7%',
                },                 
                {
                label: 'Fecha Cita',
                field: 'fecha',
                thClass: 'center',
                tdClass: 'left',                                
                width:'19%',
                }, 
                {
                label: 'Comentario',
                field: this.fieldFn,
                width:'17%',
                },
                {
                label: 'Confirmo',
                field: 'confirmado',
                thClass: 'center',
                tdClass: 'center',                
                width:'7%',
                },                                                                                                                                                                                                                        
                {
                label: 'Acción',
                field: 'btn',
                thClass: 'center',
                tdClass: 'center',
                html: true  ,
                width:'7%',  
                }                               
            ],
            citasOdo_Sede:[]

        }
    },
    computed: {
        ...mapState(['user_system','sede_system','especialidades','documentos','empleados','citas','confirmacioncitas']),
        ...mapGetters(['getMedicosSedes','getDocumentosIdentidad']),  
        doc_sede(){
            return this.getMedicosSedes(this.sede_system.id)
        },                        
    },
    methods: {
        cargaDatosCitas(){
            this.isLoading = true
            let ini = moment(this.dataFiltro.fecha_desde).format('DDMMYYYY')
            let fin = moment(this.dataFiltro.fecha_hasta).format('DDMMYYYY')            
            this.$store.dispatch('LOAD_CONFIRMACION_CITAS_LIST',{ empleado_id : this.dataFiltro.empleado_id , sede_id : this.sede_system.id , fecini : ini , fecfin : fin }).then(() => {
                this.citasOdo_Sede = this.confirmacioncitas
                this.isLoading = false
            })
        },
        processConfirmacion(param){ 
            this.$swal({
                title: 'Desea Confirmar esta cita?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, Confirmar!'
                }).then((result) => {
                    if (result.value) {
                        let data = {
                            cita_id : param.id,
                            fecha_incidencia : moment().format('DD-MM-YYYY HH:mm:ss'),
                            estadocita_id : 1,
                            confirmado : 1,
                            user_id:this.user_system.id 
                        }          
                        var url = '/api/citas/confirmar/' + param.id;
                        axios.put(url, data).then(response => {
                            if(typeof(response.data.errors) != "undefined"){
                                this.errors = response.data.errors;
                                var resultado = "";
                                for (var i in this.errors) {
                                    if (this.errors.hasOwnProperty(i)) {
                                        resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                                    }
                                }   
                                this.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                 
                                return;
                            }                
                            this.errors = [];
                            this.cargaDatosCitas()         
                            this.notificaciones('la cita fue confirmada con exito','la la-thumbs-up','success')                  
                        }).catch(error => {
                            this.errors = error.response.data.status;            
                            this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')
                        });                        
                    }
                });





        },                
        fieldFn(rowObj) {
            return rowObj.seguimientocitas[0].comentario
        }               
    }    

}
</script>
<style scoped>  
    .vld-overlay.is-full-page {
        z-index: 99999;
    }
    .form-control-sm {
        font-size: .680rem !important;
    }
    .table-sm th,
    .table-sm td {
        padding: 0.3rem !important; 
        font-size: 11px !important;
    } 
    td {
        vertical-align: middle !important;
    }
    .btn-xs {
        padding: 3px !important;
    }     
</style>

