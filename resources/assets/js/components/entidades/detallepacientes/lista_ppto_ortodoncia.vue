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
                        <button type="button" class="btn btn-primary float-right" @click.prevent="NuevoPresupuesto"><span class="btn-label"><i class="flaticon-list"></i></span> Nuevo Presupuesto</button>
                    </div>                                                        
                </div>
                <div class="card-body">
                    <vue-good-table
                    :columns="columns"
                    :rows="ppto_ortodoncia_paciente"
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
                                <button type="button" v-tooltip="'Imprimir Presupuesto'" class="btn btn-border btn-warning btn-xs" @click.prevent="ImprimirPresupuesto(props.row)">
                                    <i class="la la-print font-large"></i>
                                </button>                                                                                               
                                <button type="button" v-tooltip="'Eliminar Presupuesto'" class="btn btn-border btn-danger btn-xs" @click.prevent="processDelete(props.row.id)">
                                    <i class="la la-trash-o font-large"></i>
                                </button>   
<!--                                 <button type="button" v-if="props.row.estadopresupuesto_id == 1" v-tooltip="'Editar Presupuesto'" class="btn btn-border btn-success btn-xs" @click.prevent="processEdit(props.row.id)">
                                    <i class="la la-pencil font-large"></i>
                                </button>  -->                                                            
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
import jsPDF from 'jspdf'
import html2canvas from 'html2canvas'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'lista_ppto_ortodoncia',
    mixins: [mixin],
    created() {  
        this.$store.dispatch('LOAD_TIPOCAMBIOS_LIST')
        this.$store.dispatch('LOAD_PRESUPUESTOS_ORTODONCIAS_LIST').then(() => {
            this.isLoading = false
        })                              
    },
    data(){
        return {
            isLoading: true,
            fullPage: true,
            
            columns: [
                {
                label: 'Num.',
                field: 'id',
                tdClass: 'center',
                width:'8%',
                }, 
                {
                label: 'Odontologo Encargado',
                field: 'empleado.nombre_completo',            
                width:'30%',
                },
                {
                label: 'Tratamiento',
                field: 'tarifario.servicio.nombre_servicio',            
                width:'20%',
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
                label: 'Estado',
                field: 'estadopresupuesto.nombre_estadopresupuesto',                
                width:'12%',
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
            errors:[]

        }
    },
    computed:{
        ...mapState(['user_system','presupuestos_ortodoncias']),
        ...mapGetters(['getpptoOrtodonciaPaciente','getTipoCambioHoy']),             
        ppto_ortodoncia_paciente(){
            return this.getpptoOrtodonciaPaciente(this.$route.params.idpaciente)
        }        
    },
    methods:{
        NuevoPresupuesto(){
            let tipcam = this.getTipoCambioHoy
            if(tipcam == undefined){
                this.notificaciones('Debe registrar el Tipo de cambio de Hoy','la la-thumbs-o-down','danger')
                return
            }
            this.$router.push({ name: 'ppto-ortodoncia' , params: { idpresupuesto: null } })
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
                        var url = '/api/presupuestosortodoncias/cambioestado/' + param;
                        axios.put(url,this.dataPresupuesto).then(response=> {
                            this.$store.dispatch('LOAD_PRESUPUESTOS_ORTODONCIAS_LIST').then(() => {
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
            this.$router.push({ name: 'ver-ppto-ortodoncia' , params: { idpresupuesto: param } })
        },        
        ImprimirPresupuesto(param){
            let total_cuotas = (parseFloat(param.control_mensual) * parseFloat(param.cuotas)).toFixed(2)
            var doc = new jsPDF();
            var img = new Image()
            img.src = '/img/logo/multident.png'
            doc.addImage(img, 'png', 150, 10, 45, 5)                    
            doc.setFontSize(12)
            doc.setFont("helvetica")
            doc.setFontType("bold")
            doc.text(60,25,"PRESUPUESTO DE ORTODONCIA Nº")
            doc.text(138,25, param.id.toString())
            doc.setFontSize(9) 
            doc.setFontType("normal")                               
            doc.text(10,35,'Historia Clinica :')
            doc.setFontType("bold")  
            doc.text(40,35, param.paciente.historiaclinica.toString()) 
            doc.setFontType("normal")              
            doc.text(150,35, 'Fecha:')
            doc.setFontType("bold")                     
            doc.text(165,35, param.fecha_registro) 
            doc.setFontType("normal")                                    
            doc.text(10,40,'Paciente:')
            doc.setFontType("bold") 
            doc.text(40,40, param.paciente.nombre_completo )
            doc.setFontType("normal")                     
            doc.text(10,45,'Doctor:')
            doc.setFontType("bold")                     
            doc.text(40,45, param.empleado.nombre_completo) 
            doc.setFontSize(8)
            doc.setFontType("normal") 
            doc.text(10,50,'TX de Ortodoncia:')
            doc.setFontType("bold")            
            doc.text(40,50, param.tarifario.servicio.nombre_servicio)                                        
            // DETALLE DEL PRESUPUESTO
            doc.setFontSize(12)
            doc.setFontType("bold")             
            doc.text(75,60,'Detalle del Presupuesto')
            doc.setFontType("normal") 
            doc.setFontSize(7)                                
            doc.line(8,67 , 205 ,67)
            doc.text(190,71 , 'TARIFA')                                    
            doc.line(8,73 , 205 ,73)                      
            doc.text(11,77, 'Cantidad')
            doc.text(80,77,'Concepto')
            doc.text(170,77,'P.Unitario')
            doc.text(195,77,'S/.')
            doc.line(8,79 , 205,79)
            // Carga de Datos
            doc.text(14,83,'1','center')
            doc.text(30,83,'CUOTA INICIAL')   
            doc.text(180,83, parseFloat(param.cuota_inicial).toFixed(2),'right')   
            doc.text(200,83, parseFloat(param.cuota_inicial).toFixed(2),'right') 
            doc.line(8,85 , 205,85) 
            doc.text(14,89, param.cuotas.toString(),'center')
            doc.text(30,89,'CONTROL MENSUAL')   
            doc.text(180,89, parseFloat(param.control_mensual).toFixed(2),'right')   
            doc.text(200,89, total_cuotas,'right')  
            doc.line(8,91 , 205,91)                                                 
            let y = 89
            let y2 
            param.presupuestosortodonciasdetalles.map(function(value, key) {
                if(value.adicional == 1){
                    y += 6
                    doc.text(14,y , '1' ,'center')
                    doc.text(30,y,value.tarifario.servicio.nombre_servicio)
                    doc.text(180,y,parseFloat(value.costo).toFixed(2),'right')
                    doc.text(200,y,parseFloat(value.costo).toFixed(2),'right')
                    y2 = y + 2
                    doc.line(8,y2 , 205,y2)
                }
            })   
            doc.line(8,67 ,8,y2)
            doc.line(25,73, 25,y2)
            doc.line(165,73 , 165,y2)
            doc.line(185,67 ,185,y2)
            doc.line(205,67 , 205,y2)
            y2 += 10
            doc.text(10,y2,'Observaciones')
            y2 += 5
            doc.text(25,y2, param.observaciones == null ? '' : param.observaciones)
            y2 +=25
            doc.line(8,y2, 75,y2)
            doc.line(145,y2 ,205,y2)  
            y2 +=5          
            doc.setFontSize(9)
            doc.setFontType("bold")                    
            doc.text(13,y2, 'Firma del Odontólogo tratante')
            doc.text(145,y2,'Firma del Paciente - Apoderado') 
                             
            this.isLoading = false
            window.open(doc.output('bloburl'),'_blank') 
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
                        var url = '/api/presupuestos-ortodoncias/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_PRESUPUESTOS_ORTODONCIAS_LIST').then(() => {
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

