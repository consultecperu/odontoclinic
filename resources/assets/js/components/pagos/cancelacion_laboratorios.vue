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

                    <div class="tab-pane fade show active" id="pills-separados" role="tabpanel" aria-labelledby="pills-separados-tab">
                        <div class="row">
                            <div class="col-2 pr-0">
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
                            <div class="col-3 pl-0">
                                <div class="form-group form-floating-label">
                                    <select ref="laboratorios" class="form-control input-border-bottom" id="selectLaboratorios" v-model="dataFiltro.laboratorio_id" @change.prevent="cargaDatos" required>
                                        <option value="0">--seleccione--</option>
                                        <option v-for="lab in laboratorios" :value="lab.id" :key="lab.id">
                                            {{ lab.nombre_laboratorio}}
                                        </option>
                                    </select>
                                    <label for="selectLaboratorios" class="placeholder">Laboratorios</label>
                                </div>
                            </div>
                            <div class="col-3 pr-0 pl-0">
                                <div class="form-group pt-0 pr-0">
                                    <label for="fecha" class="col-12 pl-0 mb-0 label-title">Desde :</label>
                                    <date-picker @change="cargaDatos" v-model="dataFiltro.fecha_desde" :first-day-of-week="1" :lang="lang" format="DD-MM-YYYY"></date-picker>
                                </div>
                            </div>
                            <div class="col-3 pr-0 pl-0">
                                <div class="form-group pt-0 pl-0">
                                    <label for="fecha" class="col-12 pl-0 mb-0 label-title">Hasta :</label>
                                    <date-picker @change="cargaDatos" v-model="dataFiltro.fecha_hasta" :first-day-of-week="1" :lang="lang" format="DD-MM-YYYY"></date-picker>
                                </div>
                            </div>                            
                        </div>
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
                                            @page-change="handlePageChange">
                                        <div slot="empty"></div>
                                        <v2-table-column label="Nro. Liquidación" width="110" prop="codigo"></v2-table-column>
                                        <v2-table-column label="Fecha Liquidación" prop="fecha_liquidacion" width="130" align="left" sortable></v2-table-column>
                                        <v2-table-column label="Sede" prop="sede" width="150" sortable></v2-table-column>
                                        <v2-table-column label="Laboratorio" prop="laboratorio" width="200" align="left" sortable></v2-table-column>
                                        <v2-table-column label="Moneda" prop="moneda" width="80" align="left"></v2-table-column>
                                        <v2-table-column label="Total" prop="total" width="80" align="right">
                                            <template slot-scope="scope">
                                                <div>{{scope.row.monto | formatMoney}}</div> 
                                            </template>                                                 
                                        </v2-table-column>
                                        <v2-table-column label="Estado" prop="pagado" width="130" align="center">
                                            <template slot-scope="scope">
                                                <span class="center badge" :class="{'badge-danger' : scope.row.pagado == 0,'badge-primary' : scope.row.pagado == 1 }">{{scope.row.pagado == 0 ? 'PENDIENTE': 'PAGADO' }}</span>                                
                                            </template>                                                
                                        </v2-table-column>
                                        <v2-table-column label="Accion" prop="accion" width="100" align="center">
                                            <template slot-scope="scope">
                                                <button type="button" class="btn btn-success btn-xs" v-if="scope.row.pagado == 0" v-tooltip="'Pagar'" @click.prevent="pagarLiquidacion(scope.row)">
                                                    <i class="la la-money font-large"></i>
                                                </button> 
                                                <button type="button" class="btn btn-primary btn-xs" v-if="scope.row.pagado == 1" v-tooltip="'Ver Detalle'" @click.prevent="verLiquidacion(scope.row)">
                                                    <i class="la la-eye font-large"></i>
                                                </button>                                                
                                                <button type="button" class="btn btn-warning btn-xs" v-tooltip="'Imprimir'" @click.prevent="imprimirLiquidacion(scope.row)">
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
        <!-- PAGE CONTENT MODAL PAGO LIQUIDACION -->  
        <modal name="pago_laboratorio" :width="'45%'" height="auto" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de cargos -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Cancelación de Laboratorio</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3 pr-0">
                                <div class="form-group pt-0 pr-0 pl-0" >
                                    <label for="monto_facturar" class="font-weight-bold mb-0">Monto a Facturar</label>
                                    <input type="text" class="form-control form-control-sm text-right" name="monto_facturar" v-model="dataPago.monto" disabled>
                                </div>
                            </div>
                            <div class="col-3">
                                <div class="form-group pt-0 pl-0 pr-0" >
                                    <label for="numero_facturas" class="font-weight-bold mb-0">Nº Facturas</label>
                                    <input type="number" class="form-control form-control-sm text-center" name="numero_facturas" v-model="dataPago.numero_facturas" disabled/>
                                </div>
                            </div>
                            <div class="col-3 pl-0">
                                <button type="button" class="btn btn-primary btn-sm mt-20" @click.prevent="generar = true"><span class="btn-label"><i class="la la-file-text"></i></span> Generar</button>  
                            </div>
                        </div>
                        <div class="row mt-20 mb-10">
                            <div class="col-12">
                                <p class="form-control-static text-center text-white bg-primary pb-5 pt-5">Lista de Facturas</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-1">
                                <p class="form-control-static font-weight-bold float-right">#</p>
                            </div>
                            <div class="col-8">
                                <p class="form-control-static font-weight-bold">Nro. Factura (serie - correlativo)</p>
                            </div>
                            <div class="col-3">
                                <p class="form-control-static font-weight-bold text-right">Monto</p>
                            </div>
                        </div>
                        <div class="row" v-if="generar">
                            <div class="col-1">
                                <p class="form-control-static font-weight-bold float-right">1</p>
                            </div>
                            <div class="col-3 pr-0">
                                <input type="text" class="form-control form-control-sm" v-model="dataPago.serie" maxlength="6"/>
                            </div>
                            <div class="col-5 pl-5 pr-0">
                                <input type="text" class="form-control form-control-sm" v-model="dataPago.numero" maxlength="15"/>
                            </div>                            
                            <div class="col-3 pl-5">
                                <input type="text" class="form-control form-control-sm text-right" v-model="dataPago.monto" disabled/>
                            </div>
                        </div>                        
                    </div>
                    <div class="card-action pr-20">
                        <button class="btn btn-danger float-right ml-10" @click="$modal.hide('pago_laboratorio')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                        <button class="btn btn-primary float-right" @click.prevent="facturarLiquidacion" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                    </div>
                </div>
            <!-- /. form de registro de cargos -->
        </modal>  
        <!-- PAGE CONTENT MODAL DETALLE PAGO-->  
        <modal name="detalle_pago" :width="'45%'" height="auto" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de cargos -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Datos de la Cancelación Laboratorio</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group form-inline p-0">
                            <div class="col-md-4">
                                <p class="form-control-static font-weight-bold mb-0">Nro. Liquidación</p>
                            </div>
                            <div class="col-md-8 p-0">
                                <p class="form-control-static mb-0">{{ datos.codigo}}</p>
                            </div>
                        </div>
                        <div class="form-group form-inline p-0">
                            <div class="col-md-4">
                                <p class="form-control-static font-weight-bold mb-0">Monto facturado</p>
                            </div>                            
                            <div class="col-md-8 p-0">
                                <p class="form-control-static mb-0">{{ datos.monto | formatMoney}}</p>
                            </div>
                        </div>
                        <div class="form-group form-inline p-0">
                            <div class="col-md-4">
                                <p class="form-control-static font-weight-bold mb-0">Fecha de Cancelación</p>
                            </div>                            
                            <div class="col-md-8 p-0">
                                <p class="form-control-static mb-0">{{ datos.fecha_liquidacion}}</p>
                            </div>
                        </div>
                        <div class="form-group form-inline p-0">
                            <div class="col-md-4">
                                <p class="form-control-static font-weight-bold mb-0">Usuario responsable</p>
                            </div>                            
                            <div class="col-md-8 p-0">
                                <p class="form-control-static mb-0">{{ datos.usuario}}</p>
                            </div>
                        </div> 
                        <div class="row mt-20 mb-10">
                            <div class="col-12">
                                <p class="form-control-static text-center text-white bg-primary pb-5 pt-5">Lista de Facturas</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-1">
                                <p class="form-control-static font-weight-bold float-right">#</p>
                            </div>
                            <div class="col-8">
                                <p class="form-control-static font-weight-bold">Nro. Factura (serie - correlativo)</p>
                            </div>
                            <div class="col-3">
                                <p class="form-control-static font-weight-bold text-right">Monto</p>
                            </div>
                        </div>
                        <div class="row" v-for="(fac, index) in datos.facturas" :key="fac.id">
                            <div class="col-1">
                                <p class="form-control-static float-right">{{index+1}}</p>
                            </div>
                            <div class="col-3 pr-0">
                                <p class="form-control-static border border-default pl-10 pr-10">{{ fac.serie}}</p>
                            </div>
                            <div class="col-5 pl-5 pr-0">
                                <p class="form-control-static border border-default pl-10 pr-10">{{ fac.numero}}</p>
                            </div>                            
                            <div class="col-3 pl-5">
                                <p class="form-control-static border border-default pl-10 pr-10 float-right">{{ fac.monto | formatMoney}}</p>
                            </div>
                        </div>                                              
                    </div>
                    <div class="card-action pr-20">
                        <button class="btn btn-danger float-right ml-10" @click="$modal.hide('detalle_pago')"><span class="btn-label"><i class="la la-times-circle"></i> Cerrar</span></button>
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
    name: 'pagosliquidacionlaboratorio',
    mixins: [mixin],
    created(){
        this.$store.dispatch('LOAD_LABORATORIOS_LIST')        
        this.$store.dispatch('LOAD_SEDES_LIST') 
        this.$store.dispatch('LOAD_LIQUIDACION_LABORATORIOS_LIST') 
    },     
    data(){
        return {
            isLoading: false,
            fullPage: true,
            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos', 

            dataFiltro:{
                laboratorio_id:0,
                sede_id:0,
                fecha_desde:new Date(),
                fecha_hasta:new Date()
            },
            dataPago:{
                liquidacionlaboratorio_id:'',
                monto:'',
                numero_facturas:1,
                serie:'',
                numero:'',
                fecha_cancelacion:moment().format('DD-MM-YYYY hh:mm:ss'),
                tipodocumento_id:6
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
            generar: false,
            datos:[]                     
        }
    },
    computed: {
        ...mapState(['user_system','sede_system','laboratorios','sedes','liquidacionlaboratorios']),
        ...mapGetters(['getubigeos']),                                         
    },
    components: { DatePicker }, 
    methods:{
        cargaDatos(){              //liquidados
            this.loading = true
            let self = this
            this.tableDate = []
            let filtrados = this.liquidacionlaboratorios.filter(labt => labt.laboratorio_id == this.dataFiltro.laboratorio_id && labt.sede_id == this.dataFiltro.sede_id && moment(labt.fecha_liquidacion,'DD-MM-YYYY').isSameOrBefore(moment(this.dataFiltro.fecha_desde,'DD-MM-YYYY')))
            _.each(filtrados, function(value,key){
                let files= {
                    id:value.id,
                    codigo:value.codigo,
                    sede:value.sede.nombre_sede,
                    laboratorio:value.laboratorio.nombre_laboratorio,
                    monto:value.monto,
                    pagado:value.pagado,
                    fecha_liquidacion:value.fecha_liquidacion,
                    fecha_cancelacion:value.fecha_cancelacion,
                    usuario:value.user.__empleado.nombre_completo,
                    accion:'',
                    facturas:value.liquidacionlaboratoriofacturas
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
        pagarLiquidacion(param){
            this.dataPago.monto = parseFloat(param.monto).toFixed(2)
            this.dataPago.liquidacionlaboratorio_id = param.id
            this.dataPago.serie = ''
            this.dataPago.numero = ''
            this.generar = false
            this.$modal.show('pago_laboratorio')
        },
        verLiquidacion(param){
            this.datos = param
            console.log("data",this.datos)
            this.$modal.show('detalle_pago')
        },
        facturarLiquidacion(){
            this.$swal({
                title: 'Desea Pagar esta liquidación?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, Pagar!'
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true
                        var url = '/api/liquidacionlaboratorios/facturar/'+ this.dataPago.liquidacionlaboratorio_id;
                        axios.put(url, this.dataPago).then(response => {
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
                        this.$store.dispatch('LOAD_LIQUIDACION_LABORATORIOS_LIST').then(() => {
                            this.cargaDatos() 
                            this.isLoading = false
                        })  
                        this.errors = []; 
                        this.$modal.hide('pago_laboratorio')                       
                        this.notificaciones('Datos actualizados con exito','la la-thumbs-up','success')                         
                        }).catch(error => {
                        this.errors = error.response.data.status;                 
                        this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')           
                        this.isLoading = false
                        });                        
                    }
                });

        }

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

