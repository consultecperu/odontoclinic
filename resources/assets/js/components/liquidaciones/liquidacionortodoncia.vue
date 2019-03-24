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
                            </div>
                            <div class="row">
                                <div class="col-12">
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
                                                            <v2-table-column label="Servicio" prop="nombre_servicio" width="350" align="left" sortable></v2-table-column>
                                                            <v2-table-column label="Plan" prop="plan" align="left"></v2-table-column>
                                                            <v2-table-column label="Fecha Descarga" prop="fecha" align="left" sortable></v2-table-column>
                                                            <v2-table-column label="% Dr." prop="comision" align="left"></v2-table-column>
                                                            <v2-table-column label="Tipo Pago" prop="tipo_pago" align="left"></v2-table-column>
                                                            <v2-table-column label="Mon." prop="moneda" align="left"></v2-table-column>
                                                            <v2-table-column label="Total" prop="costo" width="100" align="right">
                                                                <template slot-scope="scope">
                                                                    <div>{{scope.row.costo | formatMoney}}</div> 
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
                                                            <v2-table-column label="Ret.Banco" prop="comision_tarjeta" align="left">
                                                                <template slot-scope="scope">
                                                                    <div>{{scope.row.comision_tarjeta | formatMoney}}</div> 
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
                                                            <v2-table-column label="Mats.DR." prop="mat_doctor" align="left">
                                                                <template slot-scope="scope">
                                                                    <div>{{scope.row.mat_doctor | formatMoney}}</div> 
                                                                </template>                                                              
                                                            </v2-table-column>
                                                            <v2-table-column label="Neto" prop="neto" width="100" align="right" fixed="right">
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
                                                <div class="col-12 mb-10 mt-10">
                                                    <button type="button" class="btn btn-sm btn-warning float-right ml-10" :disabled="seleccionados2 == 0"><i class="la la-remove"></i>Eliminar</button>
                                                    <button type="button" class="btn btn-sm btn-danger float-right ml-10" :disabled="dataFiltro.sede_id == 0 || dataFiltro.empleado_id == 0" @click.prevent="agregaDescuento"><i class="la la-minus"></i> Agregar Descuentos</button>
                                                    <button type="button" class="btn btn-sm btn-primary float-right" :disabled="dataFiltro.sede_id == 0 || dataFiltro.empleado_id == 0" @click.prevent="agregaAbono"><i class="la la-plus"></i> Agregar Abonos</button>
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
                                                            <v2-table-column label="Tipo" width="92" prop="tipo" align="left"></v2-table-column>
                                                            <v2-table-column label="Concepto" prop="concepto" width="200" align="left" sortable></v2-table-column>
                                                            <v2-table-column label="Descripcion" prop="descripcion" width="300" align="left" sortable></v2-table-column>
                                                            <v2-table-column label="Fecha" prop="fecha" width="150" align="left" sortable></v2-table-column>
                                                            <v2-table-column label="Monto" prop="monto" align="right">
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
        <modal name="transacciones" :width="'35%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de transacciones -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Agregar {{ textTransaccion }}</div>
                    </div>
                    <div class="card-body">
                        <!-- Cabecera de los servicios-->
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="basic" class="text-primary font-weight-bold">Concepto :</label>
                                    <div class="select2-input">
                                        <select id="basic" v-if="textTransaccion == 'Abono'" name="basic" class="form-control form-control-sm" v-model="dataTransaccion.concepto_id">
                                            <option value="">--seleccione--</option>
                                            <option v-for="con in getConceptosAbonos" :value="con.id" :key="con.id">
                                                {{ con.nombre_concepto}}
                                            </option>                                                        
                                        </select>
                                        <select id="basic" v-if="textTransaccion == 'Descuento'" name="basic" class="form-control form-control-sm" v-model="dataTransaccion.concepto_id">
                                            <option value="">--seleccione--</option>
                                            <option v-for="con in getConceptosDescuentos" :value="con.id" :key="con.id">
                                                {{ con.nombre_concepto}}
                                            </option>                                                        
                                        </select>                                        
                                    </div>                                            
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <div class="form-group">
                                    <label for="basic" class="text-primary font-weight-bold">Descripcion :</label>
                                    <input type="text" class="form-control form-control-sm" name="descripcion" v-model="dataTransaccion.descripcion">
                                </div>
                            </div>
                        </div> 
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="datepicker" class="text-primary font-weight-bold">Fecha</label>
                                    <masked-input v-model="dataTransaccion.fecha" mask="11-11-1111" placeholder="DD-MM-YYYY" class="form-control form-control-sm"/>                                            
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="form-group">
                                    <label for="basic" class="text-primary font-weight-bold">Total :</label>
                                    <input type="number" step="0.01" class="form-control form-control-sm" name="total" v-model="dataTransaccion.total">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary float-right ml-10" @click.prevent="createTransaccion" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger float-right" @click="$modal.hide('transacciones')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de cargos -->
        </modal>


    </div>
</template>
<script>
import DatePicker from 'vue2-datepicker'
import mixin from '../../mixins.js'
import MaskedInput from 'vue-masked-input'
import  {_} from 'vue-underscore'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'liquidacionortodoncia',
    mixins: [mixin],
    created(){
        this.$store.dispatch('LOAD_EMPLEADOS_LIST')        
        this.$store.dispatch('LOAD_SEDES_LIST')
        this.$store.dispatch('LOAD_PRESUPUESTOS_ORTODONCIAS_DETALLES_LIST') 
        this.$store.dispatch('LOAD_CONCEPTOS_LIST')
        this.$store.dispatch('LOAD_TRANSACCIONES_DOCTOR_LIST')
    }, 
    data(){
        return {
            isLoading: false,
            fullPage: true,
            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos',
            textTransaccion: 'Abono',

            dataFiltro:{
                empleado_id:0,
                sede_id:0,
                fecha_corte:new Date()
            },
            dataTransaccion:{
               empleado_id:'',
               sede_id:'',
               moneda_id:1,
               concepto_id:'',
               fecha:moment().format('DD/MM/YYYY'),
               descripcion:'',
               total:'',
               ind_liquidacion:0,
               liquidado:0,
               origen:2,        // 1. operatoria 2.ortodoncia
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
            loading2:false,
            currentPage: 1,
            total: 10, 
            total2: 10,
            paginationInfo: {
                text: '<strong>Total 0 registros - 10 reg. x Página</strong>',
                pageSize:10,
                nextPageText:'Sig.',
                prevPageText:'Ant.'               
            },                      
            rows:[],  
            paginationInfo2: {
                text: '<strong>Total 0 registros - 10 reg. x Página</strong>',
                pageSize:10,
                nextPageText:'Sig.',
                prevPageText:'Ant.'               
            }, 
            rows2:[],
            seleccionados:[],
            seleccionados2:[]                                  
        }
    },
    computed: {
        ...mapState(['user_system','sede_system','sedes','empleados','presupuestos_ortodoncias_detalles','conceptos','transacciones_doctor','preliquidaciondoctor_ortodoncia']),
        ...mapGetters(['getMedicos','getConceptosAbonos','getConceptosDescuentos']),                                              
    },
    components: { DatePicker ,  MaskedInput  },     
    methods:{
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },          
        cargaDatos(){           // separados
            this.loading = true
            let fec_cor = moment(this.dataFiltro.fecha_corte).format('DDMMYYYY')
            this.$store.dispatch('LOAD_PRELIQUIDACIONES_ORTODONCIAS_DOCTORES_LIST',{ empleado_id : this.dataFiltro.empleado_id , sede_id : this.dataFiltro.sede_id , fecha_corte : fec_cor}).then(() => {
                this.isLoading = false
                console.log('traigo datos',this.preliquidaciondoctor_ortodoncia)
                this.rows = this.preliquidaciondoctor_ortodoncia
                this.$refs.table1.updateScrollbar(true);
                this.paginationInfo.text = `<strong>Total `+ this.rows.length+` registros - `+ this.paginationInfo.pageSize+` reg. x página</strong>`
                this.loading = false            
            }) 
            this.cargaDatos2()                
        },
/*         getTableData(){
            this.rows = this.tableDate
            this.$refs.table1.updateScrollbar(true);
            this.paginationInfo.text = `<strong>Total `+ this.rows.length+` registros - `+ this.paginationInfo.pageSize+` reg. x página</strong>`
            this.loading = false
        }, */
        handleSortChange( {prop, order}) {
            this.loading = true;
            let list = [].concat(this.rows);
            list.sort((item1, item2) => {
                let val1 = '';
                let val2 = '';

                if (prop === 'fecha') {
                    val1 = new Date(item1[prop]).getTime();
                    val2 = new Date(item2[prop]).getTime();
                    if (order === 'descending') {
                    return val2 < val1 ? -1 : 1
                    }
                    return val1 < val2 ? -1 : 1
                }

                if (prop === 'presupuesto_id' || prop === 'paciente' || prop === 'nombre_servicio' || prop === 'superficie' || prop === 'pieza') {
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
        cargaDatos2(){           // separados
            this.loading2 = true
            let self = this
            this.tableDate2 = []
            let filtrados = this.transacciones_doctor.filter(trad => trad.sede_id == this.dataFiltro.sede_id && trad.empleado_id == this.dataFiltro.empleado_id && moment(trad.fecha,'DD-MM-YYYY').isSameOrBefore(moment(this.dataFiltro.fecha_corte,'DD-MM-YYYY')))
            _.each(filtrados, function(value,key){
                let files= {
                    id:value.id,
                    tipo:value.concepto.type == 1 ? 'ABONO': 'DESCUENTO',
                    concepto:value.concepto.nombre_concepto,
                    descripcion:value.descripcion,
                    fecha:value.fecha,
                    monto:value.total
                }
                let copyfile = _.clone(files)
                self.tableDate2.push(copyfile)
            })
            this.getTableData2()            
        },
        getTableData2(){
            this.rows2 = this.tableDate2
            this.$refs.table2.updateScrollbar(true);
            this.paginationInfo2.text = `<strong>Total `+ this.rows2.length+` registros - `+ this.paginationInfo2.pageSize+` reg. x página</strong>`
            this.loading2 = false
        },        
        handleSortChange2( {prop, order}) {
            this.loading2 = true;
            let list = [].concat(this.rows2);
            list.sort((item1, item2) => {
                let val1 = '';
                let val2 = '';

                if (prop === 'fecha') {
                    val1 = new Date(item1[prop]).getTime();
                    val2 = new Date(item2[prop]).getTime();
                    if (order === 'descending') {
                    return val2 < val1 ? -1 : 1
                    }
                    return val1 < val2 ? -1 : 1
                }

                if (prop === 'tipo' || prop === 'concepto' || prop === 'monto') {
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
            this.currentPage2 = page;
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
            this.seleccionados2 = rows
        }, 
        agregaDescuento(){
            this.dataTransaccion ={
               empleado_id:this.dataFiltro.empleado_id,
               sede_id:this.dataFiltro.sede_id,
               moneda_id:1,
               concepto_id:'',
               fecha:moment().format('DD/MM/YYYY'),
               descripcion:'',
               total:'',
               ind_liquidacion:0,
               liquidado:0,
               origen:2,        // 1. operatoria 2.ortodoncia
               user_id:this.user_system.id 
            }              
            this.textTransaccion = "Descuento"
            this.$modal.show('transacciones');
        },
        agregaAbono(){
            this.dataTransaccion ={
               empleado_id:this.dataFiltro.empleado_id,
               sede_id:this.dataFiltro.sede_id,
               moneda_id:1,
               concepto_id:'',
               fecha:moment().format('DD/MM/YYYY'),
               descripcion:'',
               total:'',
               ind_liquidacion:0,
               liquidado:0,
               origen:2,        // 1. operatoria 2.ortodoncia
               user_id:this.user_system.id 
            }           
            this.textTransaccion = "Abono"
            this.$modal.show('transacciones')
        },
        createTransaccion: function(){
            var url = '/api/transaccionesdoctor';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataTransaccion).then(response => {
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
            this.$store.dispatch('LOAD_TRANSACCIONES_DOCTOR_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            //this.$modal.hide('paciente');   
            this.notificaciones('Nuevo registro creado con exito','la la-thumbs-up','success')   
            this.$modal.hide('transacciones');                         
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')           
            });
        },

    },
    filters: {
      formatMoney (val) {
        return parseFloat(val).toFixed(2)
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

