<template>
    <div class="row" style="position: relative;">
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
                                <button type="button" v-if="props.row.estadopresupuesto_id == 2" v-tooltip="'Ver Presupuesto'" class="btn btn-border btn-primary btn-xs" @click.prevent="verPresupuesto(props.row.id)">
                                    <i class="la la-eye font-large"></i>
                                </button> 
                                <button type="button" v-if="props.row.estadopresupuesto_id == 1" v-tooltip="'Iniciar Tratamiento'" class="btn btn-border btn-primary btn-xs" @click.prevent="iniciarTratamiento(props.row.id)">
                                    <i class="la la-check font-large"></i>
                                </button>                                 
                                <button type="button" v-if="props.row.estadopresupuesto_id == 2" v-tooltip="'Imprimir Presupuesto'" class="btn btn-border btn-warning btn-xs" @click.prevent="createPDF(props.row)">
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
        <!-- Inicio de Odontograma -->
        <div class="row" ref="printMe" style="position:absolute;top:0;left:0;right:0;margin:0 auto;width:100%;z-index:-1;">
            <div class="col-12">
                <p class="form-control-static text-center font-weight-bold mb-0" >BUCAL</p>
            </div>
            <div class="col-12">
                <div class="row">
                    <div class="col-1 d-flex align-items-center">
                        <div class="texto-vertical">
                            DERECHA
                        </div>
                    </div>
                    <div class="col-10">
                        <div class="row">
                            <div class="col-6 borde-derecho">
                                <div class="row d-flex justify-content-end" v-for="i in cuadrante_izquierdo_superior" :key="i">
                                    <div v-for="info in getDientesByCuadrante(i)" :key="info.id" class="dientito">
                                        <p class="form-control-static text-center mb-0" :id="'t'+info.id">{{ info.codigo }}</p>
                                        <input type="text" :id="'d'+info.id" class="texto-dientito" maxlength="3" v-model="dataPresupuesto.text_up_dent[info.id]"> 
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" height="64" :class="info.tipo" width="32" :id="info.id">
                                                <!-- Caras del diente -->
                                                <polygon points="6,38 30,38 24,44 12,44" :style="BuscoCara(info,'V')" /> <!-- CARA 1 Trapecio superior -->
                                                <polygon points="30,38 30,62 24,56 24,44" :style="BuscoCara(info,'M')"/> <!-- CARA 2 Trapecio lateral derecho -->
                                                <polygon points="30,62 6,62 12,56 24,56" :style="BuscoCara(info,'P')" /> <!-- CARA 3 Trapecio inferior -->
                                                <polygon points="6,62 12,56 12,44 6,38" :style="BuscoCara(info,'D')"/> <!-- CARA 4 trapecio lateral izquierdo-->
                                                <polygon points="12,44 24,44 24,56 12,56" :style="BuscoCara(info,'O')" /> <!-- CARA 5 Cuadrado Central -->
                                                <!-- Tratamientos / Estados del diente -->
                                                <polygon points="17,40 19,40 19,60 17,60" :style="[BuscoDiente(info,2) ? marcadoEndodonciaO : invisible]" />
                                                <circle cx="18" cy="50" r="10" :style="[BuscoDiente(info,3)  ? marcadoCoronaO : invisible]" />
                                                <polygon points="8,40 8,39 30,61 30,61" :style="[BuscoDiente(info,4) ? marcadoExodonciaO : invisible]" />                                    
                                                <polygon points="30,39 30,39 8,61 8,60" :style="[BuscoDiente(info,4) ? marcadoExodonciaO : invisible]" />
                                                <image v-if="BuscoDiente(info,5)" xlink:href="/img/odontograma/perno4.png" x=-2 y=10 width=26 height=26 class="perno" />
                                                <path d="M 8,50 a10,10 0 1,1 20,0" :style="[BuscoDiente(info,6) ? marcadoIonomeroO : invisible]" ></path>
                                                <text x=16 y=32 :style="[BuscoDiente(info,7) ? marcadoSellanteO : invisible]" >S</text>                                                                        
                                                <ellipse cx="18" cy="50" rx="12" ry="7" :style="[BuscoDiente(info,8) ? marcadoGeneralO : invisible]" />
                                                <line x1="6" y1="50" x2="30" y2="50" :style="[BuscoDiente(info,8) ? marcadoGeneralO : invisible]" />                                    
                                            </svg>                                                                                                                                            
                                        </div>                                            
                                    </div>                                          
                                </div>
                                                                    
                            </div>
                            <div class="col-6">
                                <div class="row" v-for="i in cuadrante_derecho_superior" :key="i">
                                    <div v-for="info in getDientesByCuadrante(i)" :key="info.id" class="dientito">
                                        <p class="form-control-static text-center mb-0" :id="'t'+info.id">{{ info.codigo }}</p>
                                        <input type="text" name="" :id="'d'+info.id" class="texto-dientito" maxlength="3" v-model="dataPresupuesto.text_up_dent[info.id]"> 
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" height="64" :class="info.tipo" width="32"  :id="info.id" >
                                                <!-- Caras del Diente -->
                                                <polygon points="6,38 30,38 24,44 12,44" :style="BuscoCara(info,'V')"/> <!-- CARA 1 Trapecio superior -->
                                                <polygon points="30,38 30,62 24,56 24,44" :style="BuscoCara(info,'M')"/> <!-- CARA 2 Trapecio lateral derecho -->
                                                <polygon points="30,62 6,62 12,56 24,56" :style="BuscoCara(info,'P')"/> <!-- CARA 3 Trapecio inferior -->
                                                <polygon points="6,62 12,56 12,44 6,38" :style="BuscoCara(info,'D')"/> <!-- CARA 4 trapecio lateral izquierdo-->
                                                <polygon points="12,44 24,44 24,56 12,56" :style="BuscoCara(info,'O')"/> <!-- CARA 5 Cuadrado Central -->
                                                <!-- Tratamientos / Estados del diente -->
                                                <polygon points="17,40 19,40 19,60 17,60" :style="[BuscoDiente(info,2) ? marcadoEndodonciaO : invisible]" />
                                                <circle cx="18" cy="50" r="10" :style="[BuscoDiente(info,3)  ? marcadoCoronaO : invisible]" />
                                                <polygon points="8,40 8,39 30,61 30,61" :style="[BuscoDiente(info,4) ? marcadoExodonciaO : invisible]" />                                    
                                                <polygon points="30,39 30,39 8,61 8,60" :style="[BuscoDiente(info,4) ? marcadoExodonciaO : invisible]" />
                                                <image v-if="BuscoDiente(info,5)" xlink:href="/img/odontograma/perno4.png" x=-2 y=10 width=26 height=26 class="perno" />
                                                <path d="M 8,50 a10,10 0 1,1 20,0" :style="[BuscoDiente(info,6) ? marcadoIonomeroO : invisible]" ></path>
                                                <text x=16 y=32 :style="[BuscoDiente(info,7) ? marcadoSellanteO : invisible]" >S</text>                                                                        
                                                <ellipse cx="18" cy="50" rx="12" ry="7" :style="[BuscoDiente(info,8) ? marcadoGeneralO : invisible]" />
                                                <line x1="6" y1="50" x2="30" y2="50" :style="[BuscoDiente(info,8) ? marcadoGeneralO : invisible]" />                                    
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row borde-inferior">
                            <div class="col-12">
                                <p class="form-control-static text-center font-weight-bold mb-0" >LINGUAL</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 borde-derecho">
                                <div class="row d-flex justify-content-end" v-for="i in cuadrante_izquierdo_inferior" :key="i">
                                    <div v-for="info in getDientesByCuadrante(i)" :key="info.id" class="dientito">
                                        <p class="form-control-static text-center mb-0" :id="'t'+info.id">{{ info.codigo }}</p>
                                        <input type="text" name="" :id="'d'+info.id" class="texto-dientito" maxlength="3" v-model="dataPresupuesto.text_up_dent[info.id]"> 
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" height="64" :class="info.tipo" width="32" :id="info.id">
                                                <!-- Caras del Diente -->
                                                <polygon points="6,38 30,38 24,44 12,44" :style="BuscoCara(info,'V')"/> <!-- CARA 1 Trapecio superior -->
                                                <polygon points="30,38 30,62 24,56 24,44" :style="BuscoCara(info,'M')"/> <!-- CARA 2 Trapecio lateral derecho -->
                                                <polygon points="30,62 6,62 12,56 24,56" :style="BuscoCara(info,'P')"/> <!-- CARA 3 Trapecio inferior -->
                                                <polygon points="6,62 12,56 12,44 6,38" :style="BuscoCara(info,'D')"/> <!-- CARA 4 trapecio lateral izquierdo-->
                                                <polygon points="12,44 24,44 24,56 12,56" :style="BuscoCara(info,'O')"/> <!-- CARA 5 Cuadrado Central -->
                                                <!-- Tratamientos / Estados del diente -->
                                                <polygon points="17,40 19,40 19,60 17,60" :style="[BuscoDiente(info,2) ? marcadoEndodonciaO : invisible]" />
                                                <circle cx="18" cy="50" r="10" :style="[BuscoDiente(info,3)  ? marcadoCoronaO : invisible]" />
                                                <polygon points="8,40 8,39 30,61 30,61" :style="[BuscoDiente(info,4) ? marcadoExodonciaO : invisible]" />                                    
                                                <polygon points="30,39 30,39 8,61 8,60" :style="[BuscoDiente(info,4) ? marcadoExodonciaO : invisible]" />
                                                <image v-if="BuscoDiente(info,5)" xlink:href="/img/odontograma/perno4.png" x=-2 y=10 width=26 height=26 class="perno" />
                                                <path d="M 8,50 a10,10 0 1,1 20,0" :style="[BuscoDiente(info,6) ? marcadoIonomeroO : invisible]" ></path>
                                                <text x=16 y=32 :style="[BuscoDiente(info,7) ? marcadoSellanteO : invisible]" >S</text>                                                                        
                                                <ellipse cx="18" cy="50" rx="12" ry="7" :style="[BuscoDiente(info,8) ? marcadoGeneralO : invisible]" />
                                                <line x1="6" y1="50" x2="30" y2="50" :style="[BuscoDiente(info,8) ? marcadoGeneralO : invisible]" />                                    
                                            </svg>
                                        </div>
                                    </div>
                                </div>                            
                            </div>
                            <div class="col-6">
                                <div class="row" v-for="i in cuadrante_derecho_inferior" :key="i">
                                    <div v-for="info in getDientesByCuadrante(i)" :key="info.id" class="dientito">
                                        <p class="form-control-static text-center mb-0" :id="'t'+info.id">{{ info.codigo }}</p>
                                        <input type="text" name="" :id="'d'+info.id" class="texto-dientito" maxlength="3" v-model="dataPresupuesto.text_up_dent[info.id]"> 
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" height="64" :class="info.tipo" width="32" :id="info.id">
                                                <!-- Caras del Diente-->
                                                <polygon points="6,38 30,38 24,44 12,44" :style="BuscoCara(info,'V')"/> <!-- CARA 1 Trapecio superior -->
                                                <polygon points="30,38 30,62 24,56 24,44" :style="BuscoCara(info,'M')"/> <!-- CARA 2 Trapecio lateral derecho -->
                                                <polygon points="30,62 6,62 12,56 24,56" :style="BuscoCara(info,'P')"/> <!-- CARA 3 Trapecio inferior -->
                                                <polygon points="6,62 12,56 12,44 6,38" :style="BuscoCara(info,'D')"/> <!-- CARA 4 trapecio lateral izquierdo-->
                                                <polygon points="12,44 24,44 24,56 12,56" :style="BuscoCara(info,'O')"/> <!-- CARA 5 Cuadrado Central -->
                                                <!-- Tratamientos / Estados del diente -->
                                                <polygon points="17,40 19,40 19,60 17,60" :style="[BuscoDiente(info,2) ? marcadoEndodonciaO : invisible]" />
                                                <circle cx="18" cy="50" r="10" :style="[BuscoDiente(info,3)  ? marcadoCoronaO : invisible]" />
                                                <polygon points="8,40 8,39 30,61 30,61" :style="[BuscoDiente(info,4) ? marcadoExodonciaO : invisible]" />                                    
                                                <polygon points="30,39 30,39 8,61 8,60" :style="[BuscoDiente(info,4) ? marcadoExodonciaO : invisible]" />
                                                <image v-if="BuscoDiente(info,5)" xlink:href="/img/odontograma/perno4.png" x=-2 y=10 width=26 height=26 class="perno" />
                                                <path d="M 8,50 a10,10 0 1,1 20,0" :style="[BuscoDiente(info,6) ? marcadoIonomeroO : invisible]" ></path>
                                                <text x=16 y=32 :style="[BuscoDiente(info,7) ? marcadoSellanteO : invisible]" >S</text>                                                                        
                                                <ellipse cx="18" cy="50" rx="12" ry="7" :style="[BuscoDiente(info,8) ? marcadoGeneralO : invisible]" />
                                                <line x1="6" y1="50" x2="30" y2="50" :style="[BuscoDiente(info,8) ? marcadoGeneralO : invisible]" />                                    
                                            </svg>
                                        </div>
                                    </div>
                                </div>                            
                            </div>
                        </div>
                    </div>
                    <div class="col-1 d-flex align-items-center">
                        <div class="texto-vertical">
                            IZQUIERDA
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <p class="form-control-static text-center font-weight-bold mb-0">BUCAL</p>
            </div>              
        </div>
        <!-- Fin de Odontograma -->                 
    </div>    
</template>
<script>
import mixin from '../../../mixins.js'
import  {_} from 'vue-underscore'
import jsPDF from 'jspdf'
import html2canvas from 'html2canvas'
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
    mounted(){
        this.cambioTipo(1)
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
            lista_general_presupuesto:[],             
            odontograma:[],
            cuadrante_izquierdo_superior:[1,5],
            cuadrante_derecho_superior:[2,6],
            cuadrante_izquierdo_inferior:[8,4],
            cuadrante_derecho_inferior:[7,3],   
            list_dent_missing:[],  
            
            dataPresupuesto:{
                fecha_registro:'',
                paciente_id:'',
                empleado_id:'',
                moneda_id:'',
                numero_prespuesto:'',
                plan_id:'',
                poliza_id:'',
                tipo_presupuesto:'',
                estado_seguimiento:'',
                observaciones:'',
                estadopresupuesto_id:'',
                tipocambio_id:'',
                sede_id:'',
                pago_cliente:'',
                pago_aseguradora:'',
                pago_total:'',
                user_id:'',
                saldo:'',
                detalle:[],
                ausentes:[],
                text_up_dent:[]
            },
            dataPaciente:{
                id:'',
                nombre_completo:'',
                historiaclinica:'',
                empresa:'',
                plan:'',
                aseguradora:'',
                empleado:'',
                fecha:'',
                tipocambio:''
            },            
            dataTratamiento:{
                id:'',
                idppto:'',
                tarifario_id:'',
                diente_id: '',
                diente_codigo: '',
                texto_diente:'',
                caras: '',
                simbologia: '',
                letras : '',
                servicio_id : '',
                nombre_servicio : '',
                costo_base:'',
                costo : '',
                moneda_id:'',
                nombre_moneda : '',
                descuento:'',
                activo:''
            },
            
            diente: {
                cursor:'pointer', 
                cursor: 'hand' ,        
                fillOpacity:'0',
                stroke:'dimgrey',
                strokeWidth:'1px'                
            },

            deshabilitado: {
                fill:'dimgrey',
                stroke: 'rgb(71, 71, 71)',
                strokeWidth:'1px',
                opacity: '0.3'
            },

            invisible: {
                fill:'none',
                opacity: '0'                
            },
            
            marcadoRojo: {
                cursor:'pointer', 
                cursor: 'hand' ,          
                fill:'red',
                stroke:'dimgrey',
                strokeWidth:'1px'
            },
            
            marcadoCoronaO: {
                cursor:'pointer', 
                cursor: 'hand' , 
                fill:'none',
                stroke:'red',
                strokeWidth:'2px'                          
            },
            
            marcadoEndodonciaO: {
                cursor:'pointer', 
                cursor: 'hand' ,          
                fill:'red',
                stroke:'red',
                strokeWidth:'1px'                 
            },
            
            marcadoExodonciaO: {
                cursor:'pointer', 
                cursor: 'hand' ,          
                fill:'red',
                stroke:'red',
                strokeWidth:'1px'                      
            },
            
            marcadoIonomeroO: {
                cursor:'pointer', 
                cursor: 'hand' ,         
                stroke : 'red',
                fillOpacity : '0',
                strokeWidth: '2px'               
            },
            
            marcadoSellanteO: {
                cursor:'pointer', 
                cursor: 'hand' ,          
                fontWeight: 'normal',
                fill : 'red',
                stroke : 'red',
                strokeWidth: '1px',
                fontSize : '2em'             
            },
            
            marcadoGeneralO: {
                cursor:'pointer', 
                cursor: 'hand' ,         
                fill:'none',
                stroke:'red',
                strokeWidth:'1px'        
            }            

        }
    },
    computed:{
        ...mapState(['user_system','presupuestos_operatorias']),
        ...mapGetters(['getDientesByCuadrante','getpptoOperatoriaPaciente','getTipoCambioHoy']),             
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
        iniciarTratamiento(param){
            this.$swal({
                title: 'Desea iniciar el tratamiento del presupuesto?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, Iniciar!'
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true
                        this.dataPresupuesto.estadopresupuesto_id = 2
                        var url = '/api/presupuestosoperatorias/cambioestado/' + param;
                        axios.put(url,this.dataPresupuesto).then(response=> {
                            this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST').then(() => {
                                this.isLoading = false
                                this.$swal(
                                'Actualizado!',
                                'Este registro fue actualizado.',
                                'success'
                                )
                            })                    
                        });
                    }
                });
        },
        verPresupuesto(param){
            this.$router.push({ name: 'ver-ppto-operatoria' , params: { idpresupuesto: param } })
        },
        cambioTipo(param){
            this.lista_general_presupuesto = []
            if(param == 1) this.odontograma = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32]
            if(param == 2) this.odontograma = [33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52]
            if(param == 3) this.odontograma = [1,2,3,14,15,16,17,18,19,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52]
        },
        BuscoDiente(param,numsim){
            let valor = false
            if(this.lista_general_presupuesto.length == 0) return valor
            let serdent = this.lista_general_presupuesto.filter(ser => ser.diente_id == param.id)
            if(serdent.length > 0){
                serdent.map(function(value, key) {
                    if(value.simbologia == numsim){
                        valor = true
                        return
                    }
                })
            }
            return valor
        },  
        BuscoCara(param,cara){
            let encontrado;
            //let valor = 'deshabilitado'
            let valor = this.deshabilitado
            self = this
            if(this.contains(this.odontograma,param.id)){
                //valor = 'diente'     
                valor = self.diente           
                encontrado = self.lista_general_presupuesto.filter(ser => ser.diente_id == param.id)
                if(encontrado.length > 0){                 
                    encontrado.map(function(value, key) {
                        if((value.simbologia == 1) && (value.caras.indexOf(cara)) >-1) {
                            //valor = 'marcadoRojo marcado'
                            valor = self.marcadoRojo
                            return
                        }
                    })
                }
            }
            return valor
        },                
        processEdit(param){
            this.$router.push({ name: 'ppto-operatoria' , params: { idpresupuesto: param } })
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
                        var url = '/api/presupuestos-operatorias/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST').then(() => {
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
        createPDF (param) {
            let self = this
            self.lista_general_presupuesto = []         
            this.dataPaciente = {
                id:param.paciente_id,
                nombre_completo:param.paciente.nombre_completo,
                historiaclinica:param.paciente.historiaclinica,
                empresa:param.paciente.pacienteplanes.tipo == 1 ? '-' : param.paciente.pacienteplanes.empresapaciente.razon_social,
                plan:param.paciente.pacienteplanes.plan.descripcion ,
                aseguradora:param.paciente.pacienteplanes.plan.descripcion ,
                empleado_id:param.paciente.empleado_id,
                fecha:moment(param.fecha_registro).format('DD-MM-YYYY'),
                tipocambio:param.tipocambio.tipo_cambio
            } 
            param.presupuestosoperatoriasdetalles.map(function(value, key) {
                let datadet = []
                self.dataTratamiento = {
                    id: value.id,
                    idppto:value.presupuestooperatoria_id,
                    tarifario_id : value.tarifario_id,
                    diente_id: value.diente_id,
                    diente_codigo: value.diente.codigo,
                    texto_diente:value.texto_diente,
                    caras:value.caras,
                    simbologia:value.simbologia_id,
                    letras:value.letras,
                    servicio_id:value.tarifario.servicio_id,
                    nombre_servicio:value.tarifario.servicio.nombre_servicio,
                    costo_base:value.costo_base,
                    costo:value.costo,
                    moneda_id:value.moneda_id,
                    nombre_moneda:value.moneda.nombre_moneda,
                    descuento:value.descuento,
                    activo:value.activo
                }
                if(self.dataTratamiento.activo){
                    datadet = _.clone(self.dataTratamiento)
                    self.lista_general_presupuesto.push(datadet)
                }
            })
            param.dientes.map(function(value, key) {
                self.list_dent_missing.push(value.id)
                self.odontograma = _.reject(self.odontograma, function(d){ return d == value.id })                    
            }) 
            this.$swal({
                title: 'Desea imprimir este Presupuesto?',
                text: "Impresión del Presupuesto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, imprimir!'
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true   
                        self.take(this.$refs.printMe)
                    }
                });

        },
        take(targetElem) {
            let self = this
            // Primero renderiza todos los SVGs a los lienzos
            var elements = $(targetElem).find('svg').map(function() {
                var svg = $(this);
                var canvas = $('<canvas id="canvas"></canvas>');
                svg.replaceWith(canvas);
                var serializer = new XMLSerializer();
                var svgString = serializer.serializeToString(svg[0]);
                canvg(canvas[0], svgString);
                return {
                    svg: svg,
                    canvas: canvas
                };
            });
            $(targetElem).imagesLoaded(function() {
                // En este punto, el contenedor no tiene SVG, solo tiene HTML y lienzos.
                html2canvas($(targetElem)[0]).then(function(canvas) {
                    // reemplazar los svg originales
                    elements.each(function() {
                        this.canvas.replaceWith(this.svg);
                    });
                    // Poner el lienzo creado en una imagen.
                    var imgData = canvas.toDataURL("image/png");
                    var doc = new jsPDF();
                    var img = new Image()
                    img.src = '/img/logo/multident.png'
                    doc.addImage(img, 'png', 150, 10, 45, 5)                    
                    doc.setFontSize(12)
                    doc.setFont("helvetica")
                    doc.setFontType("bold")
                    doc.text(15,15,"PRESUPUESTO Nº 1265")
                    doc.setFontSize(8)                   
                    doc.text(15,20,'FECHA :')
                    doc.text(40,20, self.dataPaciente.fecha)
                    doc.setFontType("normal")   
                    doc.text(85,20,'H.C Nº :')
                    doc.text(100,20, self.dataPaciente.historiaclinica.toString())  
                    doc.text(150,20, 'Sede:')
                    doc.setFontType("bold")                     
                    doc.text(165,20, 'MAYOLO') 
                    doc.setFontType("normal")                                    
                    doc.text(15,25,'Paciente:')
                    doc.setFontSize(6)
                    doc.setFontType("bold") 
                    doc.text(40,25, self.dataPaciente.nombre_completo )
                    doc.setFontSize(8)
                    doc.setFontType("normal")                     
                    doc.text(85,25,'Doctor:')
                    doc.setFontSize(6)
                    doc.setFontType("bold")                     
                    //doc.text(100,25, self.PacienteById.empleado.nombre_completo) 
                    doc.setFontSize(8)
                    doc.setFontType("normal")                                         
                    doc.text(15,29,'Comp.de Seguros:')
                    doc.text(40,29 , self.dataPaciente.plan)
                    doc.text(85,29,'Empresa:')
                    doc.text(100,29 , self.dataPaciente.empresa)                    
                    doc.setFontType("bold")                    
                    doc.text(25,36,'FORMA DE PAGO')
                    doc.setFontType("normal")                    
                    doc.text(15,40,'Deducible X Pza.')
                    doc.text(15,45,'Coaseguro %')
                    doc.setFontSize(14)
                    doc.setFontType("bold")                     
                    doc.text(80,55,'O D O N T O G R A M A')
                    doc.setLineWidth(0.5);
                    doc.line(80, 56, 135, 56);
                    doc.setFontType("normal")                     
                    doc.addImage(imgData, 'png', 20, 61, 180, 100)
                    // DETALLE DEL PRESUPUESTO
                    doc.setFontSize(7)
                    doc.setFontType("normal")                     
                    doc.line(8,170 , 205 ,170)
                    doc.text(8,174 , 'Pieza')
                    doc.text(23,174,'Superficie')
                    doc.text(85,174 , 'Tratamientos')
                    doc.text(145,174,'Deducible')  
                    doc.text(165,174 , 'CoaSeguro')
                    doc.text(198,174,'TOTAL','right')                                      
                    doc.line(8,176 , 205 ,176)
                    doc.setFontSize(8)
                    doc.setFontType("bold")                      
                    doc.text(8,180, 'TRATAMIENTOS PARTICULARES')
                    // Carga de Datos
                    doc.setFontSize(7)
                    doc.setFontType("normal")                      
                    let y = 180
                    self.lista_general_presupuesto.map(function(value, key) {
                        y += 4
                        doc.text(8,y,value.diente_codigo)
                        doc.text(23,y,value.caras)
                        doc.text(38,y,value.nombre_servicio)
                        doc.text(145,y,'0.00')
                        doc.text(165,y,'0.00')
                        doc.text(198,y,parseFloat(value.costo).toFixed(2),'right')
                    }) 
                    y += 2 
                    doc.line(8,y , 205 ,y)
                    y += 5
                    doc.setFontSize(8)
                    doc.setFontType("bold")                     
                    doc.text(80,y,'TOTAL TRATAMIENTOS PARTICULARES')
                    //doc.text(198,y,self.costoTotal,'right')
                    y += 8
                    doc.text(140,y,'TOTAL A CANCELAR')
                    doc.line(185,y , 205,y)
                    doc.line(205,y-4 , 205, y)
                    y += 30
                    doc.line(8,y, 75,y)
                    doc.line(145,y ,205,y)
                    y += 5
                    doc.setFontSize(9)
                    doc.setFontType("bold")                    
                    doc.text(13,y, 'Firma del Odontólogo tratante')
                    doc.text(145,y,'Firma del Paciente - Apoderado')
                    doc.setFontSize(6)
                    doc.setFontType("normal")                     
                    y += 12
                    doc.text(13,y , 'Nota:')
                    y += 3
                    doc.text(18,y ,'- Los precios incluyen IGV')
                    y += 3
                    doc.text(18,y ,'- Presupuesto válido por 90 dias sin iniciar tratamiento')
                    y += 3
                    doc.text(18,y ,'- Los tratamientos optativos no estan incluidos en el Total a pagar por el paciente')
                    y += 3
                    doc.text(18,y ,'- Cancelar el total de los deducibles y coaseguro de los tratamientos terminados')
                    y += 3
                    doc.text(18,y, '- Consulte por el financiamiento odontólogico')
                    y += 3
                    doc.text(18,y, '- El precio de los servicios optativos es por pieza')
                    //doc.save('sample-file.pdf'); 
                    self.isLoading = false
                    window.open(doc.output('bloburl'),'_blank') 
                    self.$router.push({ name: 'lista-ppto-operatoria' })
                    //window.open(strurl,'_blank')                   
                })
            })
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
    .dientito {
        width: 36px !important;
        margin:0px !important;
        display: inline-block;
    }
    .texto-dientito {
        width: 32px !important;
        margin-left: 3px !important;
        font-size: 10px !important;
        font-weight: 600;
        text-align: center;
        text-transform:uppercase;
    }
    .borde-derecho {
        border-right: 3px black solid;
        padding-right: 20px;
    }
    .borde-inferior{
        border-bottom:3px black solid;
    }  
    .texto-vertical {
        width:10px;
        word-wrap: break-word;
        text-align:center;
        font-weight: 600;
    }   
    .seleccionado {
        border-top:1px solid red;
    }

    .screen-reader {
        border: 0;
        clip: rect(0 0 0 0);
        height: 1px;
        margin: -1px;
        overflow: hidden;
        padding: 0;
        position: absolute;
        white-space: nowrap;
        width: 1px;
    }    

</style>


