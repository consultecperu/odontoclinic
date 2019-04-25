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

                                    <button type="button" class="btn btn-sm btn-success d-inline ml-5 mb-5 float-right mr-20" v-if="seleccionados.length > 0" @click.prevent="enviar"><span class="btn-label"><i class="la la-level-up"></i></span>Mandar a Laboratorio</button>
                                    <button type="button" class="btn btn-sm btn-danger d-inline ml-5 mb-5 float-right" v-if="seleccionados.length > 0" @click.prevent="noLiquidable"><span class="btn-label"><i class="la la-remove"></i></span>No Liquidable</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div>
                                        <v2-table :data="rows" ref="table1"
                                                border 
                                                stripe 
                                                height="210"
                                                :lazy-load="true"
                                                :loading="loading" 
                                                :default-sort='{prop: "presupuesto_id", order: "descending"}' 
                                                @sort-change="handleSortChange" 
                                                :row-class-name="getRowClassName"
                                                :total="total"
                                                :cell-height="34"
                                                :col-height="30"                                                
                                                :shown-pagination="true"
                                                :pagination-info="paginationInfo"
                                                @page-change="handlePageChange"
                                                @select-change="handleSelectChange">
                                            <div slot="empty"></div>
                                            <v2-table-column type="selection" width="45"></v2-table-column>                              
                                            <v2-table-column label="ID" width="92" prop="id"></v2-table-column>
                                            <v2-table-column label="Presupuesto" prop="presupuesto_id" width="110" sortable></v2-table-column>
                                            <v2-table-column label="Paciente" prop="paciente" width="300" align="left" sortable></v2-table-column>
                                            <v2-table-column label="Servicio" prop="servicio" width="350" align="left" sortable></v2-table-column>
                                            <v2-table-column label="Fase" prop="fase" align="left"></v2-table-column>
                                            <v2-table-column label="Pieza" prop="pieza" width="100" align="left" sortable></v2-table-column>
                                            <v2-table-column label="Total" prop="total" width="100" align="right">
                                                <template slot-scope="scope">
                                                    <div>{{scope.row.total | formatMoney}}</div> 
                                                </template>                                                
                                            </v2-table-column>
                                            <v2-table-column label="Doctor" prop="doctor" width="350" align="left" sortable></v2-table-column>
                                            <v2-table-column label="Fecha Separacion" prop="fecha_separacion" align="left" width="150" sortable fixed="right"></v2-table-column>
                                        </v2-table> 
                                    </div>
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
                                    <button type="button" class="btn btn-sm btn-success d-inline mr-20 mb-5 float-right" v-if="seleccionados.length > 0" @click.prevent="recibidos"><span class="btn-label"><i class="la la-check-circle-o"></i></span>Marcar como Recibidos</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div>
                                        <v2-table :data="rows2" ref="table2"
                                                border 
                                                stripe 
                                                height="220"
                                                :loading="loading2" 
                                                :default-sort='{prop: "presupuesto_id", order: "descending"}' 
                                                @sort-change="handleSortChange2" 
                                                :total="total2"
                                                :shown-pagination="true"
                                                :pagination-info="paginationInfo2"
                                                @page-change="handlePageChange2"
                                                @select-change="handleSelectChange2">
                                            <div slot="empty"></div>
                                            <v2-table-column type="selection" width="45"></v2-table-column>                              
                                            <v2-table-column label="ID" width="92" prop="id"></v2-table-column>
                                            <v2-table-column label="Presupuesto" prop="presupuesto_id" width="110" sortable></v2-table-column>
                                            <v2-table-column label="Paciente" prop="paciente" width="300" align="left" sortable></v2-table-column>
                                            <v2-table-column label="Servicio" prop="servicio" width="350" align="left" sortable></v2-table-column>
                                            <v2-table-column label="Fase" prop="fase" align="left"></v2-table-column>
                                            <v2-table-column label="Pieza" prop="pieza" width="100" align="left" sortable></v2-table-column>
                                            <v2-table-column label="Total" prop="total" width="100" align="right">
                                                <template slot-scope="scope">
                                                    <div>{{scope.row.total | formatMoney}}</div> 
                                                </template>                                                 
                                            </v2-table-column>
                                            <v2-table-column label="Doctor" prop="doctor" width="350" align="left" sortable></v2-table-column>
                                            <v2-table-column label="Fecha de Envio" prop="fecha_envio" align="left" width="150" sortable fixed="right"></v2-table-column>
                                            <v2-table-column label="Fecha de Entrega" prop="fecha_entrega" align="left" width="150" sortable fixed="right"></v2-table-column>
                                        </v2-table> 
                                    </div>
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
                                    <button type="button" class="btn btn-sm btn-success d-inline mr-20 mb-5 float-right" v-if="seleccionados.length > 0" @click.prevent="liquidar"><span class="btn-label"><i class="la la-check-circle-o"></i></span>Liquidar</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <div>
                                        <v2-table :data="rows3" ref="table3"
                                                border 
                                                stripe 
                                                height="220"
                                                :loading="loading3" 
                                                :default-sort='{prop: "presupuesto_id", order: "descending"}' 
                                                @sort-change="handleSortChange3" 
                                                :total="total3"
                                                :shown-pagination="true"
                                                :pagination-info="paginationInfo3"
                                                @page-change="handlePageChange3"
                                                @select-change="handleSelectChange3">
                                            <div slot="empty"></div>
                                            <v2-table-column type="selection" width="45"></v2-table-column>                              
                                            <v2-table-column label="ID" width="92" prop="id"></v2-table-column>
                                            <v2-table-column label="Presupuesto" prop="presupuesto_id" width="110" sortable></v2-table-column>
                                            <v2-table-column label="Paciente" prop="paciente" width="300" align="left" sortable></v2-table-column>
                                            <v2-table-column label="Servicio" prop="servicio" width="350" align="left" sortable></v2-table-column>
                                            <v2-table-column label="Fase" prop="fase" align="left"></v2-table-column>
                                            <v2-table-column label="Pieza" prop="pieza" width="100" align="left" sortable></v2-table-column>
                                            <v2-table-column label="Total" prop="total" width="100" align="right">
                                                <template slot-scope="scope">
                                                    <div>{{scope.row.total | formatMoney}}</div> 
                                                </template>                                                 
                                            </v2-table-column>
                                            <v2-table-column label="Doctor" prop="doctor" width="350" align="left" sortable></v2-table-column>
                                            <v2-table-column label="Fecha de Recepcion" prop="fecha_recepcion" align="left" width="150" sortable fixed="right"></v2-table-column>
                                        </v2-table> 
                                    </div>
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
                                    <div>
                                        <v2-table :data="rows4" ref="table4"
                                                border 
                                                stripe 
                                                height="220"
                                                :loading="loading4" 
                                                :default-sort='{prop: "presupuesto_id", order: "descending"}' 
                                                @sort-change="handleSortChange4" 
                                                :total="total4"
                                                :shown-pagination="true"
                                                :pagination-info="paginationInfo4"
                                                @page-change="handlePageChange4"
                                                @select-change="handleSelectChange4">
                                            <div slot="empty"></div>
                                            <v2-table-column type="selection" width="45"></v2-table-column>                              
                                            <v2-table-column label="Nro. Liquidación" width="150" prop="codigo"></v2-table-column>
                                            <v2-table-column label="Sede" prop="sede" width="200" sortable></v2-table-column>
                                            <v2-table-column label="Monto" prop="monto" width="100" align="right">
                                                <template slot-scope="scope">
                                                    <div>{{scope.row.monto | formatMoney}}</div> 
                                                </template>                                                 
                                            </v2-table-column>
                                            <v2-table-column label="Estado" prop="pagado" width="250" align="center">
                                                <template slot-scope="scope">
                                                    <span class="center badge" :class="{'badge-danger' : scope.row.pagado == 0,'badge-primary' : scope.row.pagado == 1 }">{{scope.row.pagado == 0 ? 'PENDIENTE': 'PAGADO' }}</span>                                
                                                </template>                                                
                                            </v2-table-column>
                                            <v2-table-column label="Fecha Liquidación" prop="fecha_liquidacion" width="200" align="left" sortable></v2-table-column>
                                            <v2-table-column label="Accion" prop="accion" width="100" align="center">
                                                <template slot-scope="scope">
                                                    <button type="button" class="btn btn-success btn-xs" v-tooltip="'Imprimir'" @click.prevent="imprimirLiquidacion(scope.row)">
                                                        <i class="la la-print font-large"></i>
                                                    </button>                                
                                                </template>                                                 
                                            </v2-table-column>
                                        </v2-table> 
                                    </div>
                                </div>                         
                            </div> 
                        </div>
                    </div>  
                </div>
            </div>
        </div>
        <!-- PAGE CONTENT MODAL ATENCIONES-->  
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
import DatePicker from 'vue2-datepicker'
import mixin from '../../mixins.js'
import  {_} from 'vue-underscore'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'liquidacionlaboratorio',
    mixins: [mixin],
    created(){
        this.$store.dispatch('LOAD_LABORATORIOS_LIST')        
        this.$store.dispatch('LOAD_SEDES_LIST') 
        this.$store.dispatch('LOAD_LABORATORIO_TRABAJOS_LIST') 
        this.$store.dispatch('LOAD_LIQUIDACION_LABORATORIOS_LIST') 
    },    
    data(){
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
            tableDate:[],
            loading: false,
            currentPage: 1,
            total: 10, 
            paginationInfo: {
                text: '<strong>Total 0 registros - 10 reg. x Página</strong>',
                pageSize:10,
                nextPageText:'Sig.',
                prevPageText:'Ant.'               
            },                      
            rows:[], 

            tableDate2:[],
            loading2: false,
            //currentPage: 1,
            total2: 10, 
            paginationInfo2: {
                text: '<strong>Total 0 registros - 10 reg. x Página</strong>',
                pageSize:10,
                nextPageText:'Sig.',
                prevPageText:'Ant.'               
            },                      
            rows2:[], 

            tableDate3:[],
            loading3: false,
            //currentPage: 1,
            total3: 10, 
            paginationInfo3: {
                text: '<strong>Total 0 registros - 10 reg. x Página</strong>',
                pageSize:10,
                nextPageText:'Sig.',
                prevPageText:'Ant.'               
            },                      
            rows3:[], 

            tableDate4:[],
            loading4: false,
            //currentPage: 1,
            total4: 10, 
            paginationInfo4: {
                text: '<strong>Total 0 registros - 10 reg. x Página</strong>',
                pageSize:10,
                nextPageText:'Sig.',
                prevPageText:'Ant.'               
            },                      
            rows4:[],             

            cambio:1,
            seleccionados:[],              
            color_selected:[],
            items_separados:[]          
        }
    },
    computed: {
        ...mapState(['user_system','sede_system','laboratorios','sedes','laboratoriotrabajos','liquidacionlaboratorios']),
        ...mapGetters(['getubigeos']),                                         
    },
    components: { DatePicker }, 
    methods:{
        cargaDatos(){           // separados
            this.loading = true
            let self = this
            this.tableDate = []
            let filtrados = this.laboratoriotrabajos.filter(labt => labt.laboratorioservicio.laboratorio_id == this.dataFiltro1.laboratorio_id && labt.seguimiento == 1 && labt.liquidable == 1 && labt.sede_id == this.dataFiltro1.sede_id && moment(labt.fecha_separacion,'DD-MM-YYYY').isSameOrBefore(moment(this.dataFiltro1.fecha_corte,'DD-MM-YYYY')))
            //let filtrados = this.laboratoriotrabajos.filter(labt => labt.laboratorioservicio.laboratorio_id == this.dataLiquidacion.laboratorio_id && labt.sede_id == this.dataLiquidacion.sede_id && moment(labt.fecha_separacion,'DD-MM-YYYY').isSameOrBefore(moment(this.dataLiquidacion.fecha_corte,'DD-MM-YYYY')))
            _.each(filtrados, function(value,key){
                let files= {
                    id:value.id,
                    presupuesto_id:value.presupuestooperatoriadetalle.presupuestooperatoria_id,
                    paciente:value.presupuestooperatoriadetalle.presupuestooperatoria.paciente.nombre_completo,
                    servicio:value.laboratorioservicio.nombre_servicio,
                    pieza:value.presupuestooperatoriadetalle.letras,
                    total:value.costo,
                    doctor:value.empleado.nombre_completo,
                    fase:value.fase_id,
                    fecha_separacion:value.fecha_separacion
                }
                let copyfile = _.clone(files)
                self.tableDate.push(copyfile)
            })
            this.getTableData()            
        },
        getRowClassName ({row, rowIndex}) {
            let encontrado = this.seleccionados.filter(sel => sel.presupuestooperatoriadetalle_id == row.presupuestooperatoriadetalle_id)      
            if(encontrado.length > 0){
                return 'seleccionado'
            }
            return 'no-seleccionado'
        },        
        cargaDatos2(){              // enviados
            this.loading2 = true
            let self = this
            this.tableDate2 = []
            let filtrados = this.laboratoriotrabajos.filter(labt => labt.laboratorioservicio.laboratorio_id == this.dataFiltro2.laboratorio_id && labt.seguimiento == 2 && labt.liquidable == 1 && labt.sede_id == this.dataFiltro2.sede_id && moment(labt.fecha_separacion,'DD-MM-YYYY').isSameOrBefore(moment(this.dataFiltro2.fecha_corte,'DD-MM-YYYY')))
            //let filtrados = this.laboratoriotrabajos.filter(labt => labt.laboratorioservicio.laboratorio_id == this.dataLiquidacion.laboratorio_id && labt.sede_id == this.dataLiquidacion.sede_id && moment(labt.fecha_separacion,'DD-MM-YYYY').isSameOrBefore(moment(this.dataLiquidacion.fecha_corte,'DD-MM-YYYY')))
            _.each(filtrados, function(value,key){
                let files= {
                    id:value.id,
                    presupuesto_id:value.presupuestooperatoriadetalle.presupuestooperatoria_id,
                    paciente:value.presupuestooperatoriadetalle.presupuestooperatoria.paciente.nombre_completo,
                    servicio:value.laboratorioservicio.nombre_servicio,
                    pieza:value.presupuestooperatoriadetalle.letras,
                    total:value.costo,
                    doctor:value.empleado.nombre_completo,
                    fase:value.fase_id,
                    fecha_envio:value.fecha_envio,
                    fecha_entrega:value.fecha_entrega
                }
                let copyfile = _.clone(files)
                self.tableDate2.push(copyfile)
            })
            this.getTableData2()            
        },   
        cargaDatos3(){              //recibidos
            this.loading3 = true
            let self = this
            this.tableDate3 = []
            let filtrados = this.laboratoriotrabajos.filter(labt => labt.laboratorioservicio.laboratorio_id == this.dataFiltro3.laboratorio_id && labt.seguimiento == 3 && labt.liquidable == 1 && labt.sede_id == this.dataFiltro3.sede_id && moment(labt.fecha_separacion,'DD-MM-YYYY').isSameOrBefore(moment(this.dataFiltro3.fecha_corte,'DD-MM-YYYY')))
            //let filtrados = this.laboratoriotrabajos.filter(labt => labt.laboratorioservicio.laboratorio_id == this.dataLiquidacion.laboratorio_id && labt.sede_id == this.dataLiquidacion.sede_id && moment(labt.fecha_separacion,'DD-MM-YYYY').isSameOrBefore(moment(this.dataLiquidacion.fecha_corte,'DD-MM-YYYY')))
            _.each(filtrados, function(value,key){
                let files= {
                    id:value.id,
                    presupuesto_id:value.presupuestooperatoriadetalle.presupuestooperatoria_id,
                    paciente:value.presupuestooperatoriadetalle.presupuestooperatoria.paciente.nombre_completo,
                    servicio:value.laboratorioservicio.nombre_servicio,
                    pieza:value.presupuestooperatoriadetalle.letras,
                    total:value.costo,
                    doctor:value.empleado.nombre_completo,
                    fase:value.fase_id,
                    fecha_recepcion:value.fecha_recepcion
                }
                let copyfile = _.clone(files)
                self.tableDate3.push(copyfile)
            })
            this.getTableData3()            
        }, 
        cargaDatos4(){              //liquidados
            this.loading4 = true
            let self = this
            this.tableDate4 = []
            let filtrados = this.liquidacionlaboratorios.filter(labt => labt.laboratorio_id == this.dataFiltro4.laboratorio_id && labt.sede_id == this.dataFiltro4.sede_id && moment(labt.fecha_liquidacion,'DD-MM-YYYY').isSameOrBefore(moment(this.dataFiltro4.fecha_corte,'DD-MM-YYYY')))
            //let filtrados = this.laboratoriotrabajos.filter(labt => labt.laboratorioservicio.laboratorio_id == this.dataLiquidacion.laboratorio_id && labt.sede_id == this.dataLiquidacion.sede_id && moment(labt.fecha_separacion,'DD-MM-YYYY').isSameOrBefore(moment(this.dataLiquidacion.fecha_corte,'DD-MM-YYYY')))
            _.each(filtrados, function(value,key){
                let files= {
                    id:value.id,
                    codigo:value.codigo,
                    sede:value.sede.nombre_sede,
                    monto:value.monto,
                    pagado:value.pagado,
                    fecha_liquidacion:value.fecha_liquidacion,
                    accion:''
                }
                let copyfile = _.clone(files)
                self.tableDate4.push(copyfile)
            })
            this.getTableData4()            
        },               
        getTableData(){
            this.rows = this.tableDate
            this.$refs.table1.updateScrollbar(true);
            this.paginationInfo.text = `<strong>Total `+ this.rows.length+` registros - `+ this.paginationInfo.pageSize+` reg. x página</strong>`
            this.loading = false
        },
        getTableData2(){
            this.rows2 = this.tableDate2
            this.$refs.table2.updateScrollbar(true);
            this.paginationInfo2.text = `<strong>Total `+ this.rows2.length+` registros - `+ this.paginationInfo2.pageSize+` reg. x página</strong>`
            this.loading2 = false
        },
        getTableData3(){
            this.rows3 = this.tableDate3
            this.$refs.table3.updateScrollbar(true);
            this.paginationInfo3.text = `<strong>Total `+ this.rows3.length+` registros - `+ this.paginationInfo3.pageSize+` reg. x página</strong>`
            this.loading3 = false
        },   
        getTableData4(){
            this.rows4 = this.tableDate4
            this.$refs.table4.updateScrollbar(true);
            this.paginationInfo4.text = `<strong>Total `+ this.rows4.length+` registros - `+ this.paginationInfo4.pageSize+` reg. x página</strong>`
            this.loading4 = false
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
            _.each(this.seleccionados, function(value,key){
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
                this.isLoading = false
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')                  
                this.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                              
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
            this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')           
            this.isLoading = false
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
                        _.each(this.seleccionados, function(value,key){
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
                            this.isLoading = false
                            this.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                              
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
                        _.each(this.seleccionados, function(value,key){
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
        // Modulo de Separados
        handleSortChange( {prop, order}) {
            this.loading = true;
            let list = [].concat(this.rows);
            list.sort((item1, item2) => {
                let val1 = '';
                let val2 = '';

                if (prop === 'fecha_separacion') {
                    val1 = new Date(item1[prop]).getTime();
                    val2 = new Date(item2[prop]).getTime();
                    if (order === 'descending') {
                    return val2 < val1 ? -1 : 1
                    }
                    return val1 < val2 ? -1 : 1
                }

                if (prop === 'presupuesto_id' || prop === 'paciente' || prop === 'servicio' || prop === 'doctor' || prop === 'pieza') {
                    val1 = item1[prop];
                    val2 = item2[prop]
                    if (order === 'descending') {
                    return val2 < val1 ? -1 : 1
                    }
                    return val1 < val2 ? -1 : 1
                }
            });
            setTimeout (() => {
                this.loading = false;
                this.rows = [].concat(list);
            }, 2000);
        },
        handlePageChange(page) {
            this.currentPage = page;
            this.loading = true;
            let start = (page - 1) * 10 + 1;

            const list = this.rows.map(item => {
                return Object.assign({}, item, {
                    name: `test${start++}`
                });
            });

            setTimeout(() => {
                this.loading = false;
                this.rows = [].concat(list);
            }, 2000);  
        },
        handleSelectChange (rows) {
            console.log(rows);
            this.seleccionados = rows
        },
        // Modulo de En Laboratorio
        handleSortChange2( {prop, order}) {
            this.loading2 = true;
            let list = [].concat(this.rows2);
            list.sort((item1, item2) => {
                let val1 = '';
                let val2 = '';

                if (prop === 'fecha_envio' || prop === 'fecha_entrega') {
                    val1 = new Date(item1[prop]).getTime();
                    val2 = new Date(item2[prop]).getTime();
                    if (order === 'descending') {
                    return val2 < val1 ? -1 : 1
                    }
                    return val1 < val2 ? -1 : 1
                }

                if (prop === 'presupuesto_id' || prop === 'paciente' || prop === 'servicio' || prop === 'doctor' || prop === 'pieza') {
                    val1 = item1[prop];
                    val2 = item2[prop]
                    if (order === 'descending') {
                    return val2 < val1 ? -1 : 1
                    }
                    return val1 < val2 ? -1 : 1
                }
            });
            setTimeout (() => {
                this.loading2 = false;
                this.rows2 = [].concat(list);
            }, 2000);
        },
        handlePageChange2(page) {
            this.currentPage = page;
            this.loading2 = true;
            let start = (page - 1) * 10 + 1;

            const list = this.rows2.map(item => {
                return Object.assign({}, item, {
                    name: `test${start++}`
                });
            });

            setTimeout(() => {
                this.loading2 = false;
                this.rows2 = [].concat(list);
            }, 2000);  
        },
        handleSelectChange2 (rows) {
            console.log(rows);
            this.seleccionados = rows
        },
        // Modulo de recibidos
        handleSortChange3( {prop, order}) {
            // Customize your sorting method. Maybe it will get data from server.
            this.loading3 = true;
            let list = [].concat(this.rows3);
            list.sort((item1, item2) => {
                let val1 = '';
                let val2 = '';

                if (prop === 'fecha_recepcion') {
                    val1 = new Date(item1[prop]).getTime();
                    val2 = new Date(item2[prop]).getTime();
                    if (order === 'descending') {
                    return val2 < val1 ? -1 : 1
                    }
                    return val1 < val2 ? -1 : 1
                }

                if (prop === 'presupuesto_id' || prop === 'paciente' || prop === 'servicio' || prop === 'doctor' || prop === 'pieza') {
                    val1 = item1[prop];
                    val2 = item2[prop]
                    if (order === 'descending') {
                    return val2 < val1 ? -1 : 1
                    }
                    return val1 < val2 ? -1 : 1
                }
            });
            setTimeout (() => {
                this.loading3 = false;
                this.rows3 = [].concat(list);
            }, 2000);
        },
        handlePageChange3(page) {
            this.currentPage = page;
            this.loading3 = true;
            let start = (page - 1) * 10 + 1;

            const list = this.rows3.map(item => {
                return Object.assign({}, item, {
                    name: `test${start++}`
                });
            });

            setTimeout(() => {
                this.loading3 = false;
                this.rows3 = [].concat(list);
            }, 2000);  
        },
        handleSelectChange3 (rows) {
            console.log(rows);
            this.seleccionados = rows
        },
        // Modulo de liquidados
        handleSortChange4( {prop, order}) {
            // Customize your sorting method. Maybe it will get data from server.
            this.loading4 = true;
            let list = [].concat(this.rows4);
            list.sort((item1, item2) => {
                let val1 = '';
                let val2 = '';

                if (prop === 'fecha_liquidacion') {
                    val1 = new Date(item1[prop]).getTime();
                    val2 = new Date(item2[prop]).getTime();
                    if (order === 'descending') {
                    return val2 < val1 ? -1 : 1
                    }
                    return val1 < val2 ? -1 : 1
                }

                if (prop === 'sede') {
                    val1 = item1[prop];
                    val2 = item2[prop]
                    if (order === 'descending') {
                    return val2 < val1 ? -1 : 1
                    }
                    return val1 < val2 ? -1 : 1
                }
            });
            setTimeout (() => {
                this.loading4 = false;
                this.rows4 = [].concat(list);
            }, 2000);
        },
        handlePageChange4(page) {
            this.currentPage = page;
            this.loading4 = true;
            let start = (page - 1) * 10 + 1;

            const list = this.rows4.map(item => {
                return Object.assign({}, item, {
                    name: `test${start++}`
                });
            });

            setTimeout(() => {
                this.loading4 = false;
                this.rows4 = [].concat(list);
            }, 2000);  
        },
        handleSelectChange4 (rows) {
            console.log(rows);
            this.seleccionados = rows
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
            this.paginationInfo = {
                text: '<strong>Total 0 registros - 10 reg. x Página</strong>',
                pageSize:10,
                nextPageText:'Sig.',
                prevPageText:'Ant.'               
            }             
            this.paginationInfo2 = {
                text: '<strong>Total 0 registros - 10 reg. x Página</strong>',
                pageSize:10,
                nextPageText:'Sig.',
                prevPageText:'Ant.'               
            } 
            this.paginationInfo3 = {
                text: '<strong>Total 0 registros - 10 reg. x Página</strong>',
                pageSize:10,
                nextPageText:'Sig.',
                prevPageText:'Ant.'               
            }                         
        }                                             
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
</style>

<style scoped>
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


</style>

