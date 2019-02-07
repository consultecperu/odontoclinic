<template>
    <div class="row">
        <loading :active.sync="isLoading"
            :background-color="'#000'" 
            :color="'red'"
            :can-cancel="false" 
            :is-full-page="fullPage">
        </loading>          
        <div class="col-12 bg-white ml-10 pt-20">
            <div class="row">
                <div class="col-12">
                    <p class="form-control-static text-danger font-weight-bold">DATOS DEL PACIENTE</p>
                </div>
            </div>             
            <div class="row">
                <div class="col-4">
                    <div class="form-group form-group-default" >
                        <label for="historia" class="text-primary font-weight-bold">Paciente </label>
                        <p class="form-control-static mb-0" v-text="dataPaciente.nombre_completo"></p>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group form-group-default" >
                        <label for="historia" class="text-primary font-weight-bold">Num. Historia </label>
                        <p class="form-control-static text-center mb-0" v-text="dataPaciente.historiaclinica"></p>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group form-group-default" >
                        <label for="historia" class="text-primary font-weight-bold">T.C </label>
                        <p class="form-control-static mt-5 mb-0" v-text="dataPaciente.tipocambio"></p>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group form-group-default" >
                        <label for="historia" class="text-primary font-weight-bold">Fecha </label>
                        <p class="form-control-static mt-5 mb-0" v-text="dataPaciente.fecha"></p>
                    </div>
                </div>                 
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="form-group form-group-default" >
                        <label for="historia" class="text-primary font-weight-bold">Empresa </label>
                        <p class="form-control-static text-truncate mb-0" v-text="dataPaciente.empresa"></p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group form-group-default" >
                        <label for="historia" class="text-primary font-weight-bold">Plan </label>
                        <p class="form-control-static text-truncate mb-0" v-text="dataPaciente.plan"></p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group form-group-default" >
                        <label for="aseguradora" class="text-primary font-weight-bold">Aseguradora </label>
                        <p class="form-control-static text-truncate mb-0" v-text="dataPaciente.aseguradora"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-8">
                    <div class="form-group form-group-default" >
                        <label for="medicos" class="text-primary font-weight-bold">Profesional </label>
                        <select class="form-control mt-5" id="medicos" v-model="dataPaciente.empleado_id" @change.prevent="CambioMedico(dataPresupuesto.empleado_id)">
                            <option value="">-- Seleccione --</option>
                            <option v-for="med in getMedicos" :value="med.id" :key="med.id">
                                {{ med.nombre_completo}}
                            </option>
                        </select>                                
                    </div>
                </div>               
            </div>
            <div class="row">
                <div class="col-9">
                    <div class="card">
<!--                         <div class="card-header">
                            <h4 class="card-title">Nav Pills (Horizontal Tabs)</h4>
                        </div> -->
                        <div class="card-body">
                            <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-tx-pendientes-tab" data-toggle="pill" href="#pills-tx-pendientes" role="tab" aria-controls="pills-tx-pendientes" aria-selected="true">TX Pendientes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-tx-realizados-tab" data-toggle="pill" href="#pills-tx-realizados" role="tab" aria-controls="pills-tx-realizados" aria-selected="false">TX Realizados</a>
                                </li>
                            </ul>
                            <div class="tab-content mb-3" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-tx-pendientes" role="tabpanel" aria-labelledby="pills-tx-pendientes-tab">
                                    <vue-good-table
                                    ref="tabla_detalle"
                                    :columns="columns"
                                    :rows="presupuestoOperatoriaById.presupuestosoperatoriasdetalles"
                                    :paginationOptions="{
                                        enabled: true,
                                        dropdownAllowAll: false,
                                        nextLabel: 'Sig',
                                        prevLabel: 'Ant',
                                        rowsPerPageLabel: 'Registros por Pagina',
                                        ofLabel: 'de',
                                        allLabel: 'Todos',
                                    }"
                                    @on-selected-rows-change="selectionChanged"
                                    :selectOptions="{
                                        enabled: true,
                                        selectOnCheckboxOnly: false, // only select when checkbox is clicked instead of the row
                                        selectionInfoClass: 'custom-class',
                                        selectionText: 'registros seleccionados',
                                        clearSelectionText: 'borrar seleccionados',
                                    }"                                    
                                    :rowStyleClass="rowStyleClassFn"                                    
                                    :lineNumbers="true"
                                    styleClass="vgt-table condensed bordered striped">
                                        <template slot="table-row" slot-scope="props">
                                            <span v-if="props.column.field == 'pagado'" class="center">
                                                <span class="center badge" :class="{'badge-danger' : props.row.pagado == 0 ,'badge-primary' : props.row.pagado == 1 }">{{ props.row.pagado == 0 ? 'NO' : 'SI' }}</span>             
                                            </span>
                                            <span v-else-if="props.column.field == 'realizado'">
                                                <span class="center badge badge-danger" v-if="props.row.realizado == 1" v-text="'PENDIENTE'">pendiente</span>                                
                                                <span class="center badge badge-primary" v-if="props.row.realizado == 2" v-text="'EN PROCESO'">proceso</span>                                
                                                <span class="center badge badge-success" v-if="props.row.realizado == 3" v-text="'TERMINADO'">terminado</span>                                
                                            </span>
                                            <span v-else>
                                                {{props.formattedRow[props.column.field]}}
                                            </span>
                                        </template>                                                         
                                    </vue-good-table>

                                </div>
                                <div class="tab-pane fade" id="pills-tx-realizados" role="tabpanel" aria-labelledby="pills-tx-realizados-tab">
<!--                                     <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
                                    <p>The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn’t listen. She packed her seven versalia, put her initial into the belt and made herself on the way.
                                    </p> -->
                                </div>
                            </div>
                            <div class="row text-center">
                                <div class="col-12">
                                    <button class="btn btn-primary btn-sm" :disabled="color_selected.length == 0" @click.prevent="$modal.show('pago_directo')"><span class="btn-label"><i class="la la-money"></i></span>Pago Directo</button>
                                    <button class="btn btn-primary btn-sm" :disabled="color_selected.length == 0"><span class="btn-label"><i class="la la-download"></i></span>Descarga TX</button>
                                    <button class="btn btn-primary btn-sm" :disabled="color_selected.length == 0"><span class="btn-label"><i class="la la-sort-amount-asc"></i></span>Descarga con Saldo</button>
                                    <button class="btn btn-primary btn-sm" :disabled="color_selected.length == 0" @click.prevent="RealizarTratamiento"><span class="btn-label"><i class="la la-pencil-square"></i></span>Realizar Tratamiento</button>             
                                </div>
                            </div>
                        </div>
                    </div>
                </div> 
                <div class="col-3">
                    <button class="btn btn-primary btn-block btn-sm"><span class="btn-label"><i class="la la-money"></i></span>Pago Adelantado</button>
                    <button class="btn btn-primary btn-block btn-sm"><span class="btn-label"><i class="la la-list-ul"></i></span>Ver Odontograma</button>
                    <button class="btn btn-primary btn-block btn-sm"><span class="btn-label"><i class="la la-pencil-square"></i></span>Record de Atención</button>
                    <button class="btn btn-primary btn-block btn-sm"><span class="btn-label"><i class="la la-calculator"></i></span>Estado de Cuenta</button>             
                    <button class="btn btn-primary btn-block btn-sm"><span class="btn-label"><i class="la la-print"></i></span>Imprimir Presupuesto</button>
                </div>
            </div>                                 
            <div class="row">
                <div class="col-12">
                    <p>Total Abonado Soles</p>
                    <p>Total Abonado Dolares</p>
                </div> 
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-sm table-head-bg-info table-bordered-bd-info">
                        <thead>
                            <tr>
                                <th scope="col">Nº</th>
                                <th scope="col">Doc</th>
                                <th scope="col">Número</th>
                                <th scope="col">Fecha</th>    
                                <th scope="col" align="right">Monto</th>                                                                                                                      
                            </tr>
                        </thead>
                        <tbody>
<!--                             <tr v-for="(serv, index) in lista_general_presupuesto" :key="serv.id">
                                <td width="5%" align="center">{{ index+1 }}</td>
                                <td width="60%">{{ serv.nombre_servicio}}</td>
                                <td width="15%">{{ serv.nombre_moneda}}</td>  
                                <td width="10%" align="right">{{ parseFloat(serv.costo).toFixed(2)}}</td>                                                                                                                       
                            </tr>
                            <tr v-if="lista_general_presupuesto.length == 0">
                                <td colspan="8" class="text-center">NO HAY SERVICIOS CARGADOS ...</td>                                           
                            </tr> -->
                        </tbody>
                    </table> 
                </div>                               
            </div>          
        </div> 
        <!-- PAGE CONTENT MODAL ATENCIONES-->  
        <modal name="record_atencion" :width="'65%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de cargos -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Realización de Tratamientos</div>
                    </div>
                    <div class="card-body">
                        <div v-for="rec in seleccionados" :key="rec.id">
                            <!-- Cabecera de los servicios-->
                            <div class="row">
                                <div class="col-7">
                                    <p class="form-control-static"><span class="font-weight-bold">Tratamiento : </span>{{ rec.letras + ' / ' + rec.tarifario.servicio.nombre_servicio }}</p>
                                </div>
                                <div class="col-3">
                                    <p class="form-control-static"><span class="font-weight-bold">Estado : </span>
                                        <span class="badge badge-warning" v-if="rec.realizado == 1">Pendiente</span>
                                        <span class="badge badge-primary" v-if="rec.realizado == 2">En Proceso</span>
                                        <span class="badge badge-success" v-if="rec.realizado == 3">Terminado</span>
                                    </p>
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-primary btn-xs float-right" v-tooltip.top="'Agregar Evolución'" @click.prevent="numid = rec.id"><i class="la la-plus"></i></button>
                                    <button class="btn btn-success btn-xs float-right mr-10" v-tooltip.top="'Finalizar Tratamiento'"><i class="la la-check"></i></button>
                                </div>
                            </div>
                            <!-- Record de Atenciones -->
                            <template v-if="rec.recordatencionoperatorias.length > 0">
                                <div class="row" v-for="(ate, index) in rec.recordatencionoperatorias" :key="ate.id">
                                    <div class="col-1 text-right">
                                        {{ index+1 }}
                                    </div>
                                    <div class="col-11">
                                        <p class="form-control-static mb-0"><span class="font-weight-bold">Fecha de Registro :</span>{{ ate.fecha_realizacion }}</p>
                                        <p class="form-control-static"><span class="font-weight-bold">Descripcion :</span>{{ ate.descripcion }}</p>
                                    </div>
                                </div>
                            </template>
                            <div class="row" v-if="rec.recordatencionoperatorias.length == 0">
                                <div class="col-12 text-center">
                                    <p class="form-control-static">No hay evoluciones registradas</p>
                                </div>
                            </div>                        
                            <!-- Nuevo Record -->
                            <transition name="expand">               
                                <div class="row" v-if="rec.id == numid">
                                    <div class="col-12">                                    
                                        <div class="form-group form-group-default">
                                            <label for="descripcion" class="text-primary font-weight-bold">Descripcion</label>
                                            <textarea name="descripcion" id="descripcion" rows="4" v-model="dataServicio.descripcion[rec.id]"></textarea>
                                            <button type="button" class="btn btn-danger btn-sm float-right" @click.prevent="numid = 0"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                                            <button type="button" class="btn btn-primary btn-sm float-right mr-10" @click.prevent="GrabarRecord(rec)" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                                        </div>                                                                                     
                                    </div>
                                </div>
                            </transition>
                        </div>  
                    </div>
                    <div class="card-action">
                        <button class="btn btn-warning float-right" @click="$modal.hide('record_atencion')"><span class="btn-label"><i class="la la-times-circle"></i> Salir</span></button>
                    </div>
                </div>
            <!-- /. form de registro de cargos -->
        </modal>     
        <!-- PAGE CONTENT MODAL PAGO DIRECTO-->  
        <modal name="pago_directo" :width="'70%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de cargos -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">
                            <p class="float-left font-weight-bold">
                                PAGO TOTAL :
                            </p>
                            <p class="float-right font-weight-bold">
                                TIPO DE CAMBIO :
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5 border border-default">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="basic" class="text-primary font-weight-bold">Moneda :</label>
                                            <div class="select2-input">
                                                <select id="basic" name="basic" class="form-control form-control-sm">
                                                    <option value="">--seleccione--</option>
<!--                                                     <option v-for="servicio in getservicios_ortodoncia_main" :value="servicio.id" :key="servicio.id">
                                                        {{ servicio.nombre_servicio}}
                                                    </option>
 -->                                                </select>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <p class="form-control-static">EFECTIVO</p>                                            
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <input type="text" id="valor_efectivo" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <p class="form-control-static">VUELTO</p>                                            
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <input type="text" id="valor_efectivo" class="form-control form-control-sm" disabled>
                                        </div>
                                    </div>
                                </div> 
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="tarjeta" class="text-primary font-weight-bold">Tarjeta :</label>
                                            <div class="select2-input">
                                                <select id="tarjeta" name="tarjeta" class="form-control form-control-sm">
                                                    <option value="">--seleccione</option>
<!--                                                     <option v-for="servicio in getservicios_ortodoncia_main" :value="servicio.id" :key="servicio.id">
                                                        {{ servicio.nombre_servicio}}
                                                    </option>
 -->                                                </select>
                                            </div>                                          
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <input type="text" id="valor_efectivo_tarjeta" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>                                                               
                            </div>
                            <div class="col-7 border border-default">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="form-group">
                                            <label for="documento" class="text-primary font-weight-bold">Documento Multident</label>
                                            <div class="select2-input">
                                                <select id="documento" name="documento" class="form-control form-control-sm">
                                                    <option value="">--seleccione--</option>
<!--                                                     <option v-for="servicio in getservicios_ortodoncia_main" :value="servicio.id" :key="servicio.id">
                                                        {{ servicio.nombre_servicio}}
                                                    </option>
 -->                                                </select>
                                            </div>                                          
                                        </div>                                        
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-4">
                                        <div class="form-group">
                                            <label for="ruc" class="text-primary font-weight-bold">Facturar a:</label>
                                            <input type="text" id="ruc" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="group-form">
                                            <label for="ruc" class="text-primary font-weight-bold">Empresa</label>
                                            <div class="input-group mb-3">
                                                <input type="text" class="form-control form-control-sm font-weight-bold" placeholder="Empresa" aria-label="Recipient's username" aria-describedby="button-addon2" readonly>
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary btn-xs mr-5" type="button" id="button-addon2" @click.prevent="$modal.show('empresas')"><span class="btn-label"><i class="flaticon-multimedia"></i></span></button>
                                                    <button class="btn btn-primary btn-xs" type="button" id="button-addon3" @click.prevent="LoadFormEmpresa"><span class="btn-label"><i class="flaticon-add"></i></span></button>                                    
                                                </div>
                                            </div>                                              
                                        </div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="ruc" class="text-primary font-weight-bold">Precios Soles:</label>
                                            <input type="text" id="ruc" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="form-group">
                                            <label for="ruc" class="text-primary font-weight-bold">Precio Dolares:</label>
                                            <input type="text" id="ruc" class="form-control form-control-sm">
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-warning float-right" @click="$modal.hide('pago_directo')"><span class="btn-label"><i class="la la-times-circle"></i> Salir</span></button>
                    </div>
                </div>
            <!-- /. form de registro de cargos -->
        </modal>                                                     
    </div>    
</template>
<script>
import mixin from '../../../mixins.js'
import  {_} from 'vue-underscore'
import jsPDF from 'jspdf'
import html2canvas from 'html2canvas'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'ver-ppto-operatoria',
    mixins: [mixin],  
    created(){
        //this.dataDetalleOperatoria = _.clone(this.presupuestoOperatoriaById.presupuestosoperatoriasdetalles)
        this.dataPaciente = {
            id:this.presupuestoOperatoriaById.paciente_id,
            nombre_completo:this.presupuestoOperatoriaById.paciente.nombre_completo,
            historiaclinica:this.presupuestoOperatoriaById.paciente.historiaclinica,
            empresa:this.presupuestoOperatoriaById.paciente.pacienteplanes.tipo == 1 ? '-' : this.presupuestoOperatoriaById.paciente.pacienteplanes.empresapaciente.razon_social,
            plan:this.presupuestoOperatoriaById.paciente.pacienteplanes.plan.descripcion ,
            aseguradora:this.presupuestoOperatoriaById.paciente.pacienteplanes.plan.descripcion ,
            empleado_id:this.presupuestoOperatoriaById.paciente.empleado_id,
            fecha:moment(this.presupuestoOperatoriaById.fecha_registro).format('DD-MM-YYYY'),
            tipocambio:this.presupuestoOperatoriaById.tipocambio.tipo_cambio,
            empleado_id:this.presupuestoOperatoriaById.empleado_id
        } 
    },
    data(){
        return {
            isLoading: false,
            fullPage: true,

            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos', 

            columns: [
                {
                label: 'Pieza',
                field: 'letras',               
                width:'15%',
                }, 
                {
                label: 'Servicio',
                field: 'tarifario.servicio.nombre_servicio',           
                width:'40%',
                },
                {
                label: 'Pagado',
                field: 'pagado',
                thClass: 'center',
                tdClass: 'center',                
                width:'15%',
                },                 
                {
                label: 'Estado',
                field: 'realizado', 
                thClass: 'center',
                tdClass: 'center',                               
                width:'20%',
                },                                                                                                                                                                                                                       
                {
                label: 'Total',
                field: 'costo',
                type:'decimal',
                width:'10%',  
                }                               
            ],
            dataPaciente:{
                id:'',
                nombre_completo:'',
                historiaclinica:'',
                empresa:'',
                plan:'',
                aseguradora:'',
                empleado:'',
                fecha:'',
                tipocambio:'',
                empleado_id:''
            },
            dataRecord:{
                presupuestooperatoriadetalle_id:'',
                fase_id:'',
                descripcion:'',
                realizado:'',
                comentario:'',
                empleado_id:'',
                fecha_realizacion:'',
                user_id:'',
                laboratorio_id:'',
                material:''
            },
            dataDetalleOperatoria:[],
            seleccionados:[],
            color_selected:[],
            dataServicio:{
                detalle:'',
                estado:'',
                descripcion:[]
            },
            numid:''
        }
    },
    computed: {
        ...mapState(['user_system']),
        ...mapGetters(['getMedicos','getTipoCambioHoy','getPresupuestoOperatoriaById']), 
        presupuestoOperatoriaById(){
            if(this.$route.params.idpresupuesto != undefined){
                return this.getPresupuestoOperatoriaById(this.$route.params.idpresupuesto)                 
            }
            return []        
        }                 
    }, 
    methods:{
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },        
        selectionChanged(param){
            this.color_selected = param.selectedRows
        },
        rowStyleClassFn(row){
            let encontrado = this.color_selected.filter(sel => sel.id == row.id)      
            if(encontrado.length > 0){
                return 'seleccionado'
            }
            return 'no-seleccionado'
        },
        RealizarTratamiento(){
            this.seleccionados = this.$refs['tabla_detalle'].selectedRows
            this.$modal.show('record_atencion')
        },
        GrabarRecord(param){
            this.dataRecord = {
                presupuestooperatoriadetalle_id:param.id,
                fase_id:'',
                descripcion:this.dataServicio.descripcion[param.id],
                realizado:1,
                comentario:'',
                empleado_id:this.dataPaciente.empleado_id,
                fecha_realizacion:moment().format('DD-MM-YYYY hh:mm:ss'),
                user_id:this.user_system.id,
                laboratorio_id:'',
                material:''                
            }

            var url = '/api/recordatencion-operatorias';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataRecord).then(response => {
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
            let copy_seleccionados = _.clone(this.seleccionados)
            this.seleccionados = []
            this.color_selected = []
            this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST').then(() => {
                this.numid = 0
                let self = this
                //this.$refs['tabla_detalle'].unselectAllInternal(true)  
                _.each(copy_seleccionados, function(value,key){
                    _.each(self.presupuestoOperatoriaById.presupuestosoperatoriasdetalles, function(value2,key2){
                        if(value2.id == value.id){
                            self.seleccionados.push(value2)
                        }
                    })
                })

            })    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.notificaciones('Nueva atención creada con exito','la la-thumbs-up','success')       
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           

            });
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
    #descripcion {
        width: 100% !important;
    } 
    .expand-enter-active, .expand-leave-active {
        transition: all .3s ease;
        height: 180px;
        overflow: hidden;
    }
    .expand-enter, .expand-leave-to {
        height: 0;
        opacity: 0;
    }    
</style>



