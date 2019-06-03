<template>
    <div class="row">
        <loading :active.sync="isLoading"
            :background-color="'#000'" 
            :color="'red'"
            :can-cancel="false" 
            :is-full-page="fullPage">
        </loading>        
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills nav-primary" id="pills-tab" role="tablist">
                        <li class="nav-item" @click.prevent="cambioTab(1)">
                            <a class="nav-link active" id="pills-separados-tab" data-toggle="pill" href="#pills-separados" role="tab" aria-controls="pills-separados" aria-selected="true">Trabajos Separados</a>
                        </li>
                        <li class="nav-item" @click.prevent="cambioTab(2)">
                            <a class="nav-link" id="pills-laboratorio-tab" data-toggle="pill" href="#pills-laboratorio" role="tab" aria-controls="pills-laboratorio" aria-selected="false">En Laboratorio</a>
                        </li>
                        <li class="nav-item" @click.prevent="cambioTab(3)">
                            <a class="nav-link" id="pills-recibidos-tab" data-toggle="pill" href="#pills-recibidos" role="tab" aria-controls="pills-recibidos" aria-selected="false">Trabajos Recibidos</a>
                        </li>
                        <li class="nav-item" @click.prevent="cambioTab(4)">
                            <a class="nav-link" id="pills-liquidados-tab" data-toggle="pill" href="#pills-liquidados" role="tab" aria-controls="pills-liquidados" aria-selected="false">Liquidados</a>
                        </li>                
                    </ul>
                    <div class="tab-content mb-3" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-separados" role="tabpanel" aria-labelledby="pills-separados-tab">
                            <div class="row">
                                <div class="col-2 pr-0">
									<div class="form-group form-floating-label">
										<select ref="sedes" class="form-control input-border-bottom" id="selectSedes" v-model="dataFiltro1.sede_id" @change.prevent="cargaDatos" required>
                                            <option value="0">--seleccione--</option>
                                            <option v-for="sed in sedes" :value="sed.id" :key="sed.id">
                                                {{ sed.nombre_sede}}
                                            </option>
										</select>
										<label for="selectSedes" class="placeholder">Sedes</label>
									</div>
                                </div>
                                <div class="col-3 pl-0 pr-0">
									<div class="form-group form-floating-label">
										<select ref="laboratorios" class="form-control input-border-bottom" id="selectLaboratorios" v-model="dataFiltro1.laboratorio_id" @change.prevent="cargaDatos" required>
                                            <option value="0">--seleccione--</option>
                                            <option v-for="lab in laboratorios" :value="lab.id" :key="lab.id">
                                                {{ lab.nombre_laboratorio}}
                                            </option>
										</select>
										<label for="selectLaboratorios" class="placeholder">Laboratorios</label>
									</div>
                                </div>
                                <div class="col-7 pr-0 pl-0">
                                    <div class="form-group row pt-0 d-inline">
                                        <label for="fecha" class="col-12 pl-10 mb-0 label-title">Fecha de Corte</label>
                                        <date-picker @change="cargaDatos" v-model="dataFiltro1.fecha_corte" :first-day-of-week="1" :lang="lang" format="DD-MM-YYYY"></date-picker>
                                    </div>

                                    <button type="button" class="btn btn-sm btn-success d-inline ml-5 mb-5 float-right mr-20" v-if="options.selection.length > 0" @click.prevent="enviar"><span class="btn-label"><i class="la la-level-up"></i></span>Mandar a Laboratorio</button>
                                    <button type="button" class="btn btn-sm btn-danger d-inline ml-5 mb-5 float-right" v-if="options.selection.length > 0" @click.prevent="noLiquidable"><span class="btn-label"><i class="la la-remove"></i></span>No Liquidable</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <datatable v-bind="options" :rowStyleClass="rowStyleClassFn"/>
                                </div>
                            </div>                                                                      
                        </div>
                        <div class="tab-pane fade" id="pills-laboratorio" role="tabpanel" aria-labelledby="pills-laboratorio-tab">
                            <div class="row">
                                <div class="col-2 pr-0">
									<div class="form-group form-floating-label">
										<select ref="sedes2" class="form-control input-border-bottom" id="selectSedes2" v-model="dataFiltro2.sede_id" @change.prevent="cargaDatos2" required>
                                            <option value="0">--seleccione--</option>
                                            <option v-for="sed2 in sedes" :value="sed2.id" :key="sed2.id">
                                                {{ sed2.nombre_sede}}
                                            </option>
										</select>
										<label for="selectSedes2" class="placeholder">Sedes</label>
									</div>
                                </div>
                                <div class="col-3 pl-0 pr-0">
									<div class="form-group form-floating-label">
										<select ref="laboratorios2" class="form-control input-border-bottom" id="selectLaboratorios2" v-model="dataFiltro2.laboratorio_id" @change.prevent="cargaDatos2" required>
                                            <option value="0">--seleccione--</option>
                                            <option v-for="lab2 in laboratorios" :value="lab2.id" :key="lab2.id">
                                                {{ lab2.nombre_laboratorio}}
                                            </option>
										</select>
										<label for="selectLaboratorios2" class="placeholder">Laboratorios</label>
									</div>
                                </div>
                                <div class="col-7 pr-0 pl-0">
                                    <div class="form-group row pt-0 d-inline">
                                        <label for="fecha" class="col-12 pl-10 mb-0 label-title">Fecha de Corte</label>
                                        <date-picker @change="cargaDatos2" v-model="dataFiltro2.fecha_corte" :first-day-of-week="1" :lang="lang" format="DD-MM-YYYY"></date-picker>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-success d-inline mr-20 mb-5 float-right" v-if="options_enviados.selection.length > 0" @click.prevent="recibidos"><span class="btn-label"><i class="la la-check-circle-o"></i></span>Marcar como Recibidos</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <datatable v-bind="options_enviados" :rowStyleClass="rowStyleClassFn_enviados"/>
                                </div>
                            </div>                            
                        </div>
                        <div class="tab-pane fade" id="pills-recibidos" role="tabpanel" aria-labelledby="pills-recibidos-tab">
                            <div class="row">
                                <div class="col-2 pr-0">
									<div class="form-group form-floating-label">
										<select ref="sedes3" class="form-control input-border-bottom" id="selectSedes3" v-model="dataFiltro3.sede_id" @change.prevent="cargaDatos3" required>
                                            <option value="0">--seleccione--</option>
                                            <option v-for="sed3 in sedes" :value="sed3.id" :key="sed3.id">
                                                {{ sed3.nombre_sede}}
                                            </option>
										</select>
										<label for="selectSedes3" class="placeholder">Sedes</label>
									</div>
                                </div>
                                <div class="col-3 pl-0 pr-0">
									<div class="form-group form-floating-label">
										<select ref="laboratorios3" class="form-control input-border-bottom" id="selectLaboratorios3" v-model="dataFiltro3.laboratorio_id" @change.prevent="cargaDatos3" required>
                                            <option value="0">--seleccione--</option>
                                            <option v-for="lab3 in laboratorios" :value="lab3.id" :key="lab3.id">
                                                {{ lab3.nombre_laboratorio}}
                                            </option>
										</select>
										<label for="selectLaboratorios3" class="placeholder">Laboratorios</label>
									</div>
                                </div>
                                <div class="col-7 pr-0 pl-0">
                                    <div class="form-group row pt-0 d-inline">
                                        <label for="fecha" class="col-12 pl-10 mb-0 label-title">Fecha de Corte</label>
                                        <date-picker @change="cargaDatos3" v-model="dataFiltro3.fecha_corte" :first-day-of-week="1" :lang="lang" format="DD-MM-YYYY"></date-picker>
                                    </div>
                                    <button type="button" class="btn btn-sm btn-success d-inline mr-20 mb-5 float-right" v-if="options_recibidos.selection.length > 0" @click.prevent="liquidar"><span class="btn-label"><i class="la la-check-circle-o"></i></span>Liquidar</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <datatable v-bind="options_recibidos" :rowStyleClass="rowStyleClassFn_recibidos"/>
                                </div>
                            </div>                            
                        </div>
                        <div class="tab-pane fade" id="pills-liquidados" role="tabpanel" aria-labelledby="pills-liquidados-tab">
                            <div class="row">
                                <div class="col-2 pr-0">
									<div class="form-group form-floating-label">
										<select ref="sedes4" class="form-control input-border-bottom" id="selectSedes4" v-model="dataFiltro4.sede_id" @change.prevent="cargaDatos4" required>
                                            <option value="0">--seleccione--</option>
                                            <option v-for="sed4 in sedes" :value="sed4.id" :key="sed4.id">
                                                {{ sed4.nombre_sede}}
                                            </option>
										</select>
										<label for="selectSedes4" class="placeholder">Sedes</label>
									</div>
                                </div>
                                <div class="col-3 pl-0 pr-0">
									<div class="form-group form-floating-label">
										<select ref="laboratorios4" class="form-control input-border-bottom" id="selectLaboratorios4" v-model="dataFiltro4.laboratorio_id" @change.prevent="cargaDatos4" required>
                                            <option value="0">--seleccione--</option>
                                            <option v-for="lab4 in laboratorios" :value="lab4.id" :key="lab4.id">
                                                {{ lab4.nombre_laboratorio}}
                                            </option>
										</select>
										<label for="selectLaboratorios4" class="placeholder">Laboratorios</label>
									</div>
                                </div>
                                <div class="col-7 pr-0 pl-0">
                                    <div class="form-group row pt-0 d-inline">
                                        <label for="fecha" class="col-12 pl-10 mb-0 label-title">Fecha de Corte</label>
                                        <date-picker @change="cargaDatos4" v-model="dataFiltro4.fecha_corte" :first-day-of-week="1" :lang="lang" format="DD-MM-YYYY"></date-picker>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <datatable v-bind="options_liquidados" :rowStyleClass="rowStyleClassFn_liquidados"/>
                                </div>
                            </div>                             
                        </div>
                    </div>  
                </div>
            </div>
        </div>
        <!-- PAGE CONTENT MODAL ENVIOS-->  
        <modal name="envio_laboratorio" :width="'35%'" height="auto" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de cargos -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Fecha de Entrega</div>
                    </div>
                    <div class="card-body">
                        <div class="col">
                            <div class="form-group row pt-0 d-inline">
                                <label for="fecha" class="col-12 pl-10 mb-0">Fecha de Entrega</label>
                                <date-picker v-model="dataFiltro1.fecha_entrega" :first-day-of-week="1" :lang="lang" format="DD-MM-YYYY"></date-picker> 
                            </div>                            
                        </div>  
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary" @click.prevent="enviarLaboratorio" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('envio_laboratorio')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de cargos -->
        </modal>           
    </div>    
</template>
<script>
import Vue from 'vue'
import uniq from 'lodash/uniq'
import orderBy from 'lodash/orderBy'

//import DatePicker from 'vue2-datepicker'
import mixin from '../../mixins.js'
import  {_} from 'vue-underscore'
import { mapState, mapGetters } from 'vuex'
import components from './comps/'

const typeOf = o => Object.prototype.toString.call(o).slice(8, -1).toLowerCase()
const purify = o => JSON.parse(JSON.stringify(o)) // purify data

export default {
    name: 'liquidacionlaboratorio',
    //name: 'FriendsTable', // `name` is required as a recursive component
    mixins: [mixin],
    props: ['row'],
    created(){
        this.$store.dispatch('LOAD_LABORATORIOS_LIST')        
        this.$store.dispatch('LOAD_SEDES_LIST') 
        this.$store.dispatch('LOAD_LABORATORIO_TRABAJOS_LIST') 
        this.$store.dispatch('LOAD_LIQUIDACION_LABORATORIOS_LIST') 
        this.options_liquidados.xprops.eventbus
            .$on('RELOAD', this.loadData) // namespace prefix is free!
            .$on('RELOAD2', function (row) {
                /* do something */
                console.log("fila",row)
            })        
        },  
    data(){
        const amINestedComp = !!this.row
        return {
            isLoading: false,
            fullPage: true,
            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos', 

            dataFiltro1:{
                laboratorio_id:0,
                sede_id:0,
                fecha_corte:new Date(),
                fecha_entrega:new Date()
            }, 
            dataFiltro2:{
                laboratorio_id:0,
                sede_id:0,
                fecha_corte:new Date(),
            },  
            dataFiltro3:{
                laboratorio_id:0,
                sede_id:0,
                fecha_corte:new Date(),
            },
            dataFiltro4:{
                laboratorio_id:0,
                sede_id:0,
                fecha_corte:new Date(),
            },                                             
            dataLiquidarItems :{
                fecha_liquidacion:'',
                laboratorio_id:'',
                sede_id:'',
                monto:'',
                moneda_id:'',
                pagado:0,
                comentario:'',
                user_id:''
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
            
            //cambio:1,
            /** test vue2-datatables */
            options: {
                fixHeaderAndSetBodyMaxHeight: 200,
                HeaderSettings: false,
                tblStyle: 'table-layout: fixed', // must
                tblClass: 'table-bordered table-sm table-hover',
                selection:[],
                columns: [
                    { title: 'ID', field: 'id', sortable: true , tdClass: 'text-center' ,colStyle: { width : '80px'} },
                    { title: 'Presupuesto', field: 'presupuesto_id', tdClass: 'text-center', sortable: true , colStyle: { width : '120px'} },
                    { title: 'Paciente', field: 'paciente', sortable: true, colStyle: { width : '300px'} },
                    { title: 'Servicio', field: 'servicio', sortable: true, colStyle: { width : '250px'} },
                    { title: 'Fase', field: 'fase', colStyle: { width : '100px'}},
                    { title: 'Pieza', field: 'pieza', colStyle: { width : '150px'} },
                    { title: 'Total', field: 'total', sortable: true, tdClass: 'text-center' , colStyle: { width : '100px'} },
                    { title: 'Doctor', field: 'doctor', sortable: true , colStyle: { width : '250px'} }, 
                    { title: 'Fecha Separación', field: 'fecha_separacion', colStyle: { width : '150px'}, fixed : 'right' },                                        
                    ],
                data: [],
                //summary: {},
                total: 0,
                query: {}                
            },
            options_enviados: {
                fixHeaderAndSetBodyMaxHeight: 200,
                HeaderSettings: false,
                tblStyle: 'table-layout: fixed', // must
                tblClass: 'table-bordered table-sm table-hover',
                selection:[],
                columns: [
                    { title: 'ID', field: 'id', sortable: true , tdClass: 'text-center' ,colStyle: { width : '80px'} },
                    { title: 'Presupuesto', field: 'presupuesto_id', tdClass: 'text-center', sortable: true , colStyle: { width : '120px'} },
                    { title: 'Paciente', field: 'paciente', sortable: true, colStyle: { width : '300px'} },
                    { title: 'Servicio', field: 'servicio', sortable: true, colStyle: { width : '250px'} },
                    { title: 'Fase', field: 'fase', colStyle: { width : '100px'}},
                    { title: 'Pieza', field: 'pieza', colStyle: { width : '150px'} },
                    { title: 'Total', field: 'total', sortable: true, tdClass: 'text-center' , colStyle: { width : '100px'} },
                    { title: 'Doctor', field: 'doctor', sortable: true , colStyle: { width : '250px'} }, 
                    { title: 'Fecha de Envio', field: 'fecha_envio', colStyle: { width : '150px'}, fixed : 'right' },                                        
                    { title: 'Fecha de Entrega', field: 'fecha_entrega', colStyle: { width : '150px'}, fixed : 'right' },                                        
                    ],
                data: [],
                total: 0,
                query: {}                
            },
            options_recibidos: {
                fixHeaderAndSetBodyMaxHeight: 200,
                HeaderSettings: false,
                tblStyle: 'table-layout: fixed', // must
                tblClass: 'table-bordered table-sm table-hover',
                selection:[],
                columns: [
                    { title: 'ID', field: 'id', sortable: true , tdClass: 'text-center' ,colStyle: { width : '80px'} },
                    { title: 'Presupuesto', field: 'presupuesto_id', tdClass: 'text-center', sortable: true , colStyle: { width : '120px'} },
                    { title: 'Paciente', field: 'paciente', sortable: true, colStyle: { width : '300px'} },
                    { title: 'Servicio', field: 'servicio', sortable: true, colStyle: { width : '250px'} },
                    { title: 'Fase', field: 'fase', colStyle: { width : '100px'}},
                    { title: 'Pieza', field: 'pieza', colStyle: { width : '150px'} },
                    { title: 'Total', field: 'total', sortable: true, tdClass: 'text-center' , colStyle: { width : '100px'} },
                    { title: 'Doctor', field: 'doctor', sortable: true , colStyle: { width : '250px'} }, 
                    { title: 'Fecha de Recepcion', field: 'fecha_recepcion', colStyle: { width : '150px'}, fixed : 'right' },                                        
                    ],
                data: [],
                total: 0,
                query: {}                
            },
            options_liquidados: {
                //supportBackup: true,
                supportNested: true,
                tblClass: 'table-bordered table-sm table-hover',   
                //tblStyle: 'table-layout: fixed', // must    
                tblStyle: 'color: #666',                                         
                //fixHeaderAndSetBodyMaxHeight: 200,
                HeaderSettings: false,
                pageSizeOptions: [10, 50, 75, 100, 150],
                columns: (() => {
                    const cols = [
                    { title: 'Codigo', field: 'codigo', thClass: 'center', tdClass: 'center', sortable: true , colStyle: { width : '150px'} },
                    { title: 'Sede', field: 'sede', sortable: true, colStyle: { width : '200px'} },
                    { title: 'Monto', field: 'monto', thClass: 'center', tdClass: 'center', colStyle: { width : '150px'} },
                    { title: 'Pagado', field: 'pagado', tdComp: 'IP' ,visible: 'true', tdClass : 'center' , thClass : 'center', colStyle: { width : '200px'}},
                    { title: 'FechaLiquidacion', field: 'fecha_liquidacion', colStyle: { width : '200px'} },
                    { title: 'Accion', tdComp: 'Opt', visible: 'true' , tdClass : 'center' , thClass : 'center', colStyle: { width : '100px'} }
                    ]
                    return cols                   
                })(),                    
                data: [],
                total: 0,
                selection:[],
                //query: {},
                query: amINestedComp ? { id: this.row.friends } : {},
                xprops: {
                    eventbus: new Vue()
                }                               
            }                                    

        }
    },
    computed: {
        ...mapState(['user_system','sede_system','laboratorios','sedes','laboratoriotrabajos','liquidacionlaboratorios']),
        ...mapGetters(['getubigeos'])                                              
    },
    watch : {
        'options.query': {
            handler (query) {
                let self = this
                this.mockData(query).then(({ rows, total }) => {
                    self.options.data = rows
                    self.options.total = total
                })
            },
            deep: true
        },
        'options_enviados.query': {
            handler (query) {
                let self = this
                this.mockData_enviados(query).then(({ rows, total }) => {
                    self.options_enviados.data = rows
                    self.options_enviados.total = total
                })
            },
            deep: true
        }, 
        'options_recibidos.query': {
            handler (query) {
                let self = this
                this.mockData_recibidos(query).then(({ rows, total }) => {
                    self.options_recibidos.data = rows
                    self.options_recibidos.total = total
                })
            },
            deep: true
        },  
        'options_liquidados.query': {
            handler () {
                let self = this
                this.mockData_liquidados(this.options_liquidados.query).then(({ rows, total }) => {
                    self.options_liquidados.data = rows
                    self.options_liquidados.total = total
                })                
            },
            deep: true            
        },                         
    },
    //components: { DatePicker , comps}, 
    components,
    methods:{
        loadData(){
            alert("hola")
        },      
        cargaDatos(){           // separados
            let self = this
            this.options.data = []
            let filtrados = this.laboratoriotrabajos.filter(labt => labt.laboratorioservicio.laboratorio_id == this.dataFiltro1.laboratorio_id && labt.seguimiento == 1 && labt.liquidable == 1 && labt.sede_id == this.dataFiltro1.sede_id && moment(labt.fecha_separacion,'DD-MM-YYYY').isSameOrBefore(moment(this.dataFiltro1.fecha_corte,'DD-MM-YYYY')))
            _.each(filtrados, function(value,key){
                let files= {
                    id:value.id,
                    presupuestooperatoriadetalle_id:value.presupuestooperatoriadetalle_id,
                    presupuestoortodonciadetalle_id:value.presupuestoortodonciadetalle_id,
                    presupuesto_id:value.presupuestooperatoriadetalle_id != null ? value.presupuestooperatoriadetalle.presupuestooperatoria_id : value.presupuestoortodonciadetalle.presupuestoortodoncia_id,
                    paciente:value.presupuestooperatoriadetalle_id != null ? value.presupuestooperatoriadetalle.presupuestooperatoria.paciente.nombre_completo : value.presupuestoortodonciadetalle.presupuestoortodoncia.paciente.nombre_completo,
                    servicio:value.laboratorioservicio.nombre_servicio,
                    fase:value.fase_id,
                    pieza:value.presupuestooperatoriadetalle.letras,
                    total:parseFloat(value.costo).toFixed(2),
                    doctor:value.empleado.nombre_completo,
                    fecha_separacion:value.fecha_separacion
                }
                let copyfile = _.clone(files)
                self.options.data.push(copyfile)
            }) 
            self.options.total = self.options.data.length                   
        },    
        mockData(query){
            query = purify(query)
            const { limit = 10, offset = 0, sort = '', order = '' } = query
            let rows = this.options.data
            let columns = ['id', 'presupuesto_id', 'paciente', 'servicio', 'pieza', 'doctor']
            columns.forEach(field => {
                switch (typeOf(query[field])) {
                case 'array':
                    rows = rows.filter(row => query[field].includes(row[field]))
                    break
                case 'string':
                    rows = rows.filter(row => row[field].toLowerCase().includes(query[field].toLowerCase()))
                    break
                default:
                    // nothing to do
                    break
                }
            })
            if (sort) {
                rows = orderBy(rows, sort, order)
            }
            const res = {
                rows: rows.slice(offset, offset + limit),
                total: rows.length
            }
            return Promise.resolve(purify(res))
        },       
        cargaDatos2(){              // enviados
            let self = this
            this.options_enviados.data = []
            let filtrados = this.laboratoriotrabajos.filter(labt => labt.laboratorioservicio.laboratorio_id == this.dataFiltro2.laboratorio_id && labt.seguimiento == 2 && labt.liquidable == 1 && labt.sede_id == this.dataFiltro2.sede_id && moment(labt.fecha_separacion,'DD-MM-YYYY').isSameOrBefore(moment(this.dataFiltro2.fecha_corte,'DD-MM-YYYY')))
            _.each(filtrados, function(value,key){
                let files= {
                    id:value.id,
                    presupuestooperatoriadetalle_id:value.presupuestooperatoriadetalle_id,
                    presupuestoortodonciadetalle_id:value.presupuestoortodonciadetalle_id,
                    presupuesto_id:value.presupuestooperatoriadetalle_id != null ? value.presupuestooperatoriadetalle.presupuestooperatoria_id : value.presupuestoortodonciadetalle.presupuestoortodoncia_id,
                    paciente:value.presupuestooperatoriadetalle_id != null ? value.presupuestooperatoriadetalle.presupuestooperatoria.paciente.nombre_completo : value.presupuestoortodonciadetalle.presupuestoortodoncia.paciente.nombre_completo,
                    servicio:value.laboratorioservicio.nombre_servicio,
                    pieza:value.presupuestooperatoriadetalle.letras,
                    total:value.costo,
                    doctor:value.empleado.nombre_completo,
                    fase:value.fase_id,
                    fecha_envio:value.fecha_envio,
                    fecha_entrega:value.fecha_entrega
                }
                let copyfile = _.clone(files)
                self.options_enviados.data.push(copyfile)
            })
            self.options_enviados.total = self.options_enviados.data.length           
        },  
        mockData_enviados(query){
            query = purify(query)
            const { limit = 10, offset = 0, sort = '', order = '' } = query
            let rows = this.options_enviados.data
            let columns = ['id', 'presupuesto_id', 'paciente', 'servicio', 'pieza', 'doctor']
            columns.forEach(field => {
                switch (typeOf(query[field])) {
                case 'array':
                    rows = rows.filter(row => query[field].includes(row[field]))
                    break
                case 'string':
                    rows = rows.filter(row => row[field].toLowerCase().includes(query[field].toLowerCase()))
                    break
                default:
                    // nothing to do
                    break
                }
            })
            if (sort) {
                rows = orderBy(rows, sort, order)
            }
            const res = {
                rows: rows.slice(offset, offset + limit),
                total: rows.length
            }
            return Promise.resolve(purify(res))
        },       
        cargaDatos3(){              //recibidos
            let self = this
            this.options_recibidos.data = []
            let filtrados = this.laboratoriotrabajos.filter(labt => labt.laboratorioservicio.laboratorio_id == this.dataFiltro3.laboratorio_id && labt.seguimiento == 3 && labt.liquidable == 1 && labt.sede_id == this.dataFiltro3.sede_id && moment(labt.fecha_separacion,'DD-MM-YYYY').isSameOrBefore(moment(this.dataFiltro3.fecha_corte,'DD-MM-YYYY')))
            _.each(filtrados, function(value,key){
                let files= {
                    id:value.id,
                    presupuestooperatoriadetalle_id:value.presupuestooperatoriadetalle_id,
                    presupuestoortodonciadetalle_id:value.presupuestoortodonciadetalle_id,
                    presupuesto_id:value.presupuestooperatoriadetalle_id != null ? value.presupuestooperatoriadetalle.presupuestooperatoria_id : value.presupuestoortodonciadetalle.presupuestoortodoncia_id,
                    paciente:value.presupuestooperatoriadetalle_id != null ? value.presupuestooperatoriadetalle.presupuestooperatoria.paciente.nombre_completo : value.presupuestoortodonciadetalle.presupuestoortodoncia.paciente.nombre_completo,
                    servicio:value.laboratorioservicio.nombre_servicio,
                    pieza:value.presupuestooperatoriadetalle.letras,
                    total:value.costo,
                    doctor:value.empleado.nombre_completo,
                    fase:value.fase_id,
                    fecha_recepcion:value.fecha_recepcion
                }
                let copyfile = _.clone(files)
                self.options_recibidos.data.push(copyfile)
            })
            self.options_recibidos.total = self.options_recibidos.data.length          
        }, 
        mockData_recibidos(query){
            query = purify(query)
            const { limit = 10, offset = 0, sort = '', order = '' } = query
            let rows = this.options_recibidos.data
            let columns = ['id', 'presupuesto_id', 'paciente', 'servicio', 'pieza', 'doctor']
            columns.forEach(field => {
                switch (typeOf(query[field])) {
                case 'array':
                    rows = rows.filter(row => query[field].includes(row[field]))
                    break
                case 'string':
                    rows = rows.filter(row => row[field].toLowerCase().includes(query[field].toLowerCase()))
                    break
                default:
                    // nothing to do
                    break
                }
            })
            if (sort) {
                rows = orderBy(rows, sort, order)
            }
            const res = {
                rows: rows.slice(offset, offset + limit),
                total: rows.length
            }
            return Promise.resolve(purify(res))
        },                
        cargaDatos4(){              //liquidados
            let self = this
            this.options_liquidados.data = []
            let filtrados = this.liquidacionlaboratorios.filter(labt => labt.laboratorio_id == this.dataFiltro4.laboratorio_id && labt.sede_id == this.dataFiltro4.sede_id && moment(labt.fecha_liquidacion,'DD-MM-YYYY').isSameOrBefore(moment(this.dataFiltro4.fecha_corte,'DD-MM-YYYY')))
            _.each(filtrados, function(value,key){
                let files= {
                    id:value.id,
                    codigo:value.codigo,
                    sede:value.sede.nombre_sede,
                    monto:parseFloat(value.monto).toFixed(2),
                    pagado:value.pagado,
                    fecha_liquidacion:value.fecha_liquidacion,
                    accion:''
                }
                let copyfile = _.clone(files)
                self.options_liquidados.data.push(copyfile)
            })
            self.options_liquidados.total = self.options_liquidados.data.length
         
        },
        mockData_liquidados(query){
            query = purify(query)
            const { limit = 10, offset = 0, sort = '', order = '' } = query
            let rows = this.options_liquidados.data
            let columns = ['codigo', 'sede', 'pagado']
            columns.forEach(field => {
                switch (typeOf(query[field])) {
                case 'array':
                    rows = rows.filter(row => query[field].includes(row[field]))
                    break
                case 'string':
                    rows = rows.filter(row => row[field].toLowerCase().includes(query[field].toLowerCase()))
                    break
                default:
                    // nothing to do
                    break
                }
            })
            if (sort) {
                rows = orderBy(rows, sort, order)
            }
            const res = {
                rows: rows.slice(offset, offset + limit),
                total: rows.length
            }
            return Promise.resolve(purify(res))
        },                        
        handleQueryChange () {
            let self = this
            this.mockData_liquidados(this.options_liquidados.query).then(({ rows, total }) => {
                self.options_liquidados.data = rows
                self.options_liquidados.total = total
            })
        },                        
        enviar(){         
            this.$swal({
                title: 'Desea enviar estos registros?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, enviar!'
                }).then((result) => {
                    if (result.value) {
                        this.$modal.show('envio_laboratorio');                         
                    }
                });
        },
        enviarLaboratorio(){
            let datos = {
                id:this.dataFiltro1.laboratorio_id,
                fecha_envio : moment().format('DD-MM-YYYY hh:mm:ss'),
                fecha_entrega: moment(this.dataFiltro1.fecha_entrega).format('DD-MM-YYYY hh:mm:ss'),
                detalle:[]
            }
            _.each(this.options.selection, function(value,key){
                datos.detalle.push(value.id)
            })
            this.isLoading = true
            var url = '/api/laboratoriotrabajos/envio/'+datos.id;
            axios.put(url, datos).then(response => {
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
                this.isLoading = false
                return;
            }
            this.$store.dispatch('LOAD_LABORATORIO_TRABAJOS_LIST').then(() => {
                this.cargaDatos() 
                this.isLoading = false
            })  
            this.$modal.hide('envio_laboratorio') 
            this.errors = [];  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')                        
            this.notificaciones('Datos actualizados con exito','la la-thumbs-up','success')                         
            }).catch(error => {
            this.errors = error.response.data.status;
            this.$modal.hide('envio_laboratorio') 
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')   
            this.isLoading = false                   
            this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')           
            });

        },
        noLiquidable(){

        },
        recibidos(){
            this.$swal({
                title: 'Marcar como trabajos recibidos?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, recibir!'
                }).then((result) => {
                    if (result.value) {
                        // Registro de Recibidos
                        let datos = {
                            id:this.dataFiltro2.laboratorio_id,
                            fecha_recepcion : moment().format('DD-MM-YYYY hh:mm:ss'),
                            detalle:[]
                        }
                        _.each(this.options_enviados.selection, function(value,key){
                            datos.detalle.push(value.id)
                        })
                        this.isLoading = true
                        var url = '/api/laboratoriotrabajos/recibir/'+datos.id;
                        axios.put(url, datos).then(response => {
                        if(typeof(response.data.errors) != "undefined"){
                            this.errors = response.data.errors;
                            var resultado = "";
                            for (var i in this.errors) {
                                if (this.errors.hasOwnProperty(i)) {
                                    resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                                }
                            }
                            this.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                              
                            this.isLoading = false
                            return;
                        }
                        this.$store.dispatch('LOAD_LABORATORIO_TRABAJOS_LIST').then(() => {
                            this.cargaDatos2() 
                            this.isLoading = false
                        })  
                        this.errors = [];                        
                        this.notificaciones('Datos actualizados con exito','la la-thumbs-up','success')                         
                        }).catch(error => {
                        this.errors = error.response.data.status;                 
                        this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')           
                        this.isLoading = false
                        });
                    }
                });
        },
        liquidar(){
            this.$swal({
                title: 'Desea Liquidar estos registros?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, liquidar!'
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true
                        let montoTotal = 0
                        let datos = {
                            fecha_liquidacion : moment().format('DD-MM-YYYY hh:mm:ss'),
                            laboratorio_id:this.dataFiltro3.laboratorio_id,
                            sede_id:this.dataFiltro3.sede_id,
                            monto:0,
                            moneda_id:1,
                            pagado:0,
                            comentario:'',
                            user_id:this.user_system.id,               
                            detalle:[]
                        }
                        _.each(this.options_recibidos.selection, function(value,key){
                            datos.detalle.push(value.id)
                            montoTotal += parseFloat(value.total)                
                        })
                        datos.monto = parseFloat(montoTotal).toFixed(2)
                        var url = '/api/liquidacionlaboratorios';
                        axios.post(url, datos).then(response => {
                        if(typeof(response.data.errors) != "undefined"){
                            this.errors = response.data.errors;
                            var resultado = "";
                            for (var i in this.errors) {
                                if (this.errors.hasOwnProperty(i)) {
                                    resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                                }
                            }
                            this.isLoading = false
                            this.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                              
                            return;
                        }
                        this.$store.dispatch('LOAD_LABORATORIO_TRABAJOS_LIST').then(() => {
                            this.$store.dispatch('LOAD_LIQUIDACION_LABORATORIOS_LIST')
                            this.cargaDatos3() 
                            this.isLoading = false
                        })  
                        this.errors = [];                        
                        this.notificaciones('Datos actualizados con exito','la la-thumbs-up','success')                         
                        }).catch(error => {
                        this.errors = error.response.data.status;                 
                        this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')           
                        this.isLoading = false
                        });                        
                    }
                });
        },
        cambioTab(param){
            this.dataFiltro1 = {
                laboratorio_id:0,
                sede_id:0,
                fecha_corte:new Date(),
                fecha_entrega:new Date()
            } 
            this.dataFiltro2 = {
                laboratorio_id:0,
                sede_id:0,
                fecha_corte:new Date(),
            }  
            this.dataFiltro3 = {
                laboratorio_id:0,
                sede_id:0,
                fecha_corte:new Date(),
            }
            this.dataFiltro4 = {
                laboratorio_id:0,
                sede_id:0,
                fecha_corte:new Date(),
            },                                             

            this.rows = []
            this.rows2 = []
            this.rows3 = []
                       
        },
        seleccion(param){
            console.log("items",param)
        },
        rowStyleClassFn(row){
            let encontrado = this.options.selection.filter(sel => sel.id == row.id)      
            if(encontrado.length > 0){
                return 'bg-info text-white'
            }
            return 'text-black'
        },  
        rowStyleClassFn_enviados(row){
            let encontrado = this.options_enviados.selection.filter(sel => sel.id == row.id)      
            if(encontrado.length > 0){
                return 'bg-info text-white'
            }
            return 'text-black'
        }, 
        rowStyleClassFn_recibidos(row){
            let encontrado = this.options_recibidos.selection.filter(sel => sel.id == row.id)      
            if(encontrado.length > 0){
                return 'bg-info text-white'
            }
            return 'text-black'
        },  
        rowStyleClassFn_liquidados(row){
            let encontrado = this.options_liquidados.selection.filter(sel => sel.id == row.id)      
            if(encontrado.length > 0){
                return 'bg-info text-white'
            }
            return 'text-black'
        },                                                                  
    },
    filters: {
      formatMoney (val) {
        return parseFloat(val).toFixed(2)
      }
    }              
}
</script>
<style>
    .v--modal-overlay .v--modal-box {
        overflow: visible !important;
    }
    th, td { white-space: nowrap; } 
    .-page-size-select {
        padding: .375rem .75rem !important; 
    }  
    .table-sm td, .table-sm th {
        padding: .3rem !important;
    }                  
</style>

<style scoped>
@import 'http://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css';
    .label-title {
        font-size: 85% !important;
    }
    .v--modal-overlay {
        z-index:9000;
    }  
    .vld-overlay.is-full-page {
        z-index: 99999;
    }
    /* --- div Resumen --*/
    .transfer-to {
        line-height: 30px;        
    }      
    .transfer-to .sub {
        font-size: 14px;
        margin-bottom: 8px;
        font-weight: 600;
        padding: 10px !important;
    }
    .transfer-to .account-transfer>div {
        display: flex;
        justify-content: space-between;
    }     
    .transfer-to .account-transfer>div span:first-child {
        font-weight: 600;
        color: #333;
        font-size: 12px;
    }
    .transfer-to .account-transfer>div span:last-child {
        font-size: 12px;
    }  
    .btn .btn-label i {
        margin-left: 0 !important;
        margin-right: 0 !important;
    } 
    select.input-sm {
        height: 30px;
        line-height: 30px;
    } 
   
   
</style>

