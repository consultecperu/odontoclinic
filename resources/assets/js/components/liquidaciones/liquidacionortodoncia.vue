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
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-trabfinalizado-tab" data-toggle="pill" href="#pills-trabfinalizado" role="tab" aria-controls="pills-trabfinalizado" aria-selected="true">POR TRABAJO FINALIZADO</a>
                        </li>            
                    </ul>
                    <div class="tab-content mb-3" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-trabfinalizado" role="tabpanel" aria-labelledby="pills-trabfinalizado-tab">
                            <div class="row">
                                <div class="col-4">
									<div class="form-group form-floating-label">
										<select ref="sedes" class="form-control input-border-bottom" id="selectSedes" v-model="dataFiltro.sede_id" @change.prevent="cargaDatos" required>
                                            <option value="0">--seleccione--</option>
                                            <option v-for="sed in sedes" :value="sed.id" :key="sed.id">
                                                {{ sed.nombre_sede}}
                                            </option>
										</select>
										<label for="selectSedes" class="placeholder">Sedes</label>
									</div>
                                </div>
                                <div class="col-4">
									<div class="form-group form-floating-label">
										<select ref="laboratorios" class="form-control input-border-bottom" id="selectLaboratorios" v-model="dataFiltro.empleado_id" @change.prevent="cargaDatos" required>
                                            <option value="0">--seleccione--</option>
                                            <option v-for="med in getMedicos" :value="med.id" :key="med.id">
                                                {{ med.nombre_completo}}
                                            </option>
										</select>
										<label for="selectLaboratorios" class="placeholder">Odontólogos</label>
									</div>
                                </div>
                                <div class="col-4">
                                    <div class="form-group row pt-0 d-inline">
                                        <label for="fecha" class="col-12 pl-10 mb-0 label-title">Fecha de Corte</label>
                                        <date-picker @change="cargaDatos" v-model="dataFiltro.fecha_corte" :first-day-of-week="1" :lang="lang" format="DD-MM-YYYY"></date-picker>
                                    </div>
                                </div>

                                <ul class="nav nav-pills nav-primary" id="pills-tab" role="tablist">
                                    <li class="nav-item">
                                        <a class="nav-link active" id="pills-produccion-tab" data-toggle="pill" href="#pills-produccion" role="tab" aria-controls="pills-produccion" aria-selected="true">PRODUCCION</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" id="pills-abonodescuentos-tab" data-toggle="pill" href="#pills-abonodescuentos" role="tab" aria-controls="pills-abonodescuentos" aria-selected="false">ABONOS Y DESCUENTOS</a>
                                    </li>
                                </ul>
                                <div class="tab-content mb-3" id="pills-tabContent">
                                    <div class="tab-pane fade show active" id="pills-produccion" role="tabpanel" aria-labelledby="pills-produccion-tab">
                                        <div class="row">
                                            <div class="col-12">
                                                <div>
                                                    <v2-table :data="rows" ref="table1"
                                                            border 
                                                            stripe 
                                                            height="220"
                                                            :loading="loading" 
                                                            :default-sort='{prop: "presupuesto_id", order: "descending"}' 
                                                            @sort-change="handleSortChange" 
                                                            :total="total"
                                                            :shown-pagination="true"
                                                            :pagination-info="paginationInfo"
                                                            @page-change="handlePageChange"
                                                            @select-change="handleSelectChange">
                                                        <div slot="empty"></div>
                                                        <v2-table-column type="selection" width="45"></v2-table-column>                              
                                                        <v2-table-column label="Ppto" prop="presupuesto_id" width="110" sortable></v2-table-column>
                                                        <v2-table-column label="Paciente" prop="paciente" width="300" align="left" sortable></v2-table-column>
                                                        <v2-table-column label="Pieza" prop="pieza" width="100" align="left" sortable></v2-table-column>
                                                        <v2-table-column label="Superf." prop="superficie" width="100" align="left" sortable></v2-table-column>
                                                        <v2-table-column label="Servicio" prop="servicio" width="350" align="left" sortable></v2-table-column>
                                                        <v2-table-column label="Plan" prop="plan" align="left"></v2-table-column>
                                                        <v2-table-column label="Fecha Descarga" prop="fecha_descarga" align="left"></v2-table-column>
                                                        <v2-table-column label="% Dr." prop="porcentaje" align="left"></v2-table-column>
                                                        <v2-table-column label="Tipo Pago" prop="tipo_pago" align="left"></v2-table-column>
                                                        <v2-table-column label="Mon." prop="moneda" align="left"></v2-table-column>
                                                        <v2-table-column label="Total" prop="total" width="100" align="right">
                                                            <template slot-scope="scope">
                                                                <div>{{scope.row.total | formatMoney}}</div> 
                                                            </template>                                                
                                                        </v2-table-column>
                                                        <v2-table-column label="Monto Efectivo" prop="monto_efectivo" align="left">
                                                            <template slot-scope="scope">
                                                                <div>{{scope.row.monto_efectivo | formatMoney}}</div> 
                                                            </template>                                                              
                                                        </v2-table-column>
                                                        <v2-table-column label="Monto Tarjeta" prop="monto_tarjeta" align="left">
                                                            <template slot-scope="scope">
                                                                <div>{{scope.row.monto_tarjeta | formatMoney}}</div> 
                                                            </template>                                                              
                                                        </v2-table-column>
                                                        <v2-table-column label="Ret.Banco" prop="retencion" align="left">
                                                            <template slot-scope="scope">
                                                                <div>{{scope.row.retencion | formatMoney}}</div> 
                                                            </template>                                                              
                                                        </v2-table-column>
                                                        <v2-table-column label="Sunat Ret." prop="sunat" align="left">
                                                            <template slot-scope="scope">
                                                                <div>{{scope.row.sunat | formatMoney}}</div> 
                                                            </template>                                                              
                                                        </v2-table-column>
                                                        <v2-table-column label="LAB" prop="laboratorio" align="left">
                                                            <template slot-scope="scope">
                                                                <div>{{scope.row.laboratorio | formatMoney}}</div> 
                                                            </template>                                                              
                                                        </v2-table-column>
                                                        <v2-table-column label="Mats.DR." prop="materiales" align="left">
                                                            <template slot-scope="scope">
                                                                <div>{{scope.row.materiales | formatMoney}}</div> 
                                                            </template>                                                              
                                                        </v2-table-column>
                                                        <v2-table-column label="Neto" prop="neto" width="350" align="left" sortable>
                                                            <template slot-scope="scope">
                                                                <div>{{scope.row.neto | formatMoney}}</div> 
                                                            </template>                                                              
                                                        </v2-table-column>
                                                    </v2-table> 
                                                </div>
                                            </div>                         
                                        </div>                                                      
                                    </div>
                                    <div class="tab-pane fade" id="pills-abonodescuentos" role="tabpanel" aria-labelledby="pills-abonodescuentos-tab">
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
                                                        <v2-table-column label="Tipo" width="92" prop="id"></v2-table-column>
                                                        <v2-table-column label="Concepto" prop="concepto" width="110" sortable></v2-table-column>
                                                        <v2-table-column label="Descripcion" prop="descripcion" width="300" align="left" sortable></v2-table-column>
                                                        <v2-table-column label="Fecha" prop="fecha" width="350" align="left" sortable></v2-table-column>
                                                        <v2-table-column label="Monto" prop="monto" align="left" fixed="right">
                                                            <template slot-scope="scope">
                                                                <div>{{scope.row.monto | formatMoney}}</div> 
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
                </div>
            </div>
        </div>        
    </div>
</template>
<script>
import DatePicker from 'vue2-datepicker'
import mixin from '../../mixins.js'
import  {_} from 'vue-underscore'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'liquidacionortodoncia',
    mixins: [mixin],
    created(){
        this.$store.dispatch('LOAD_EMPLEADOS_LIST')        
        this.$store.dispatch('LOAD_SEDES_LIST')
        this.$store.dispatch('LOAD_PRESUPUESTOS_ORTODONCIAS_DETALLES_LIST') 
    }, 
    data(){
        return {
            isLoading: false,
            fullPage: true,
            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos',

            dataFiltro:{
                empleado_id:0,
                sede_id:0,
                fecha_corte:new Date()
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
        }
    },
    computed: {
        ...mapState(['user_system','sede_system','sedes','empleados','presupuestos_operatorias_detalles']),
        ...mapGetters(['getMedicos']),                                              
    },
    components: { DatePicker },     
    methods:{
        cargaDatos(){           // separados
            this.loading = true
            let self = this
            this.tableDate = []
            let filtrados = this.laboratoriotrabajos.filter(labt => labt.laboratorioservicio.laboratorio_id == this.dataFiltro1.laboratorio_id && labt.seguimiento == 1 && labt.liquidable == 1 && labt.sede_id == this.dataFiltro1.sede_id && moment(labt.fecha_separacion,'DD-MM-YYYY').isSameOrBefore(moment(this.dataFiltro1.fecha_corte,'DD-MM-YYYY')))
            _.each(filtrados, function(value,key){
                let files= {
                    id:value.id,
                    presupuesto_id:'',
                    paciente:'',
                    pieza:'',
                    superficie:'',
                    servicio:'',
                    plan:'',
                    fecha_descarga:'',
                    porcentaje:'',
                    tipo_pago:'',
                    moneda:'',
                    total:'',
                    monto_efectivo:'',
                    monto_tarjeta:'',
                    retencion:'',
                    sunat:'',
                    laboratorio:'',
                    materiales:'',
                    neto:''
                }
                let copyfile = _.clone(files)
                self.tableDate.push(copyfile)
            })
            this.getTableData()            
        },
        getTableData(){
            this.rows = this.tableDate
            this.$refs.table1.updateScrollbar(true);
            this.paginationInfo.text = `<strong>Total `+ this.rows.length+` registros - `+ this.paginationInfo.pageSize+` reg. x página</strong>`
            this.loading = false
        },
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
            this.seleccionados = rows
        },
    },
    filters: {
      formatMoney (val) {
        return parseFloat(val).toFixed(2)
      }
    }      
}
</script>
