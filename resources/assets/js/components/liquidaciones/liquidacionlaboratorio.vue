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
                    <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="pills-separados-tab" data-toggle="pill" href="#pills-separados" role="tab" aria-controls="pills-separados" aria-selected="true">Trabajos Separados</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-laboratorio-tab" data-toggle="pill" href="#pills-laboratorio" role="tab" aria-controls="pills-laboratorio" aria-selected="false">En Laboratorio</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-recibidos-tab" data-toggle="pill" href="#pills-recibidos" role="tab" aria-controls="pills-recibidos" aria-selected="false">Trabajos Recibidos</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="pills-liquidados-tab" data-toggle="pill" href="#pills-liquidados" role="tab" aria-controls="pills-liquidados" aria-selected="false">Liquidados</a>
                        </li>                
                    </ul>
                    <div class="tab-content mb-3" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-separados" role="tabpanel" aria-labelledby="pills-separados-tab">
                            <div class="row">
                                <div class="col-2 pr-0">
									<div class="form-group form-floating-label">
										<select ref="sedes" class="form-control input-border-bottom" id="selectSedes" v-model="dataLiquidacion.sede_id" @change.prevent="cargaDatos" required>
                                            <option value="0">--Todas--</option>
                                            <option v-for="sed in sedes" :value="sed.id" :key="sed.id">
                                                {{ sed.nombre_sede}}
                                            </option>
										</select>
										<label for="selectSedes" class="placeholder">Sedes</label>
									</div>
                                </div>
                                <div class="col-3 pl-0 pr-0">
									<div class="form-group form-floating-label">
										<select ref="laboratorios" class="form-control input-border-bottom" id="selectLaboratorios" v-model="dataLiquidacion.laboratorio_id" @change.prevent="cargaDatos" required>
                                            <option value="0">--Todas--</option>
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
                                        <date-picker @change="cargaDatos" v-model="dataLiquidacion.fecha_corte" :first-day-of-week="1" :lang="lang" format="DD-MM-YYYY"></date-picker>
                                    </div>
<!--                                     <button type="button" class="btn btn-sm btn-primary d-inline ml-10 mb-5" @click.prevent="cargaDatos"><span class="btn-label"><i class="la la-search"></i></span>Buscar</button> -->
                                    <button type="button" class="btn btn-sm btn-success d-inline ml-5 mb-5 float-right mr-20" v-if="seleccionados" @click.prevent="enviar"><span class="btn-label"><i class="la la-level-up"></i></span>Mandar a Laboratorio</button>
                                    <button type="button" class="btn btn-sm btn-danger d-inline ml-5 mb-5 float-right" v-if="seleccionados" @click.prevent="noLiquidable"><span class="btn-label"><i class="la la-remove"></i></span>No Liquidable</button>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <v-table   
                                        is-vertical-resize
                                        style="width:100%"
                                        is-horizontal-resize
                                        :vertical-resize-offset='5'
                                        :height='335'
                                        :min-height='335'                                                          
                                        :columns="tableConfig.columns"
                                        :table-data="tableConfig.tableData"
                                        row-hover-color="#eee"
                                        row-click-color="#edf7ff"
                                        :select-all="selectALL"
                                        :select-change="selectChange"
                                        :select-group-change="selectGroupChange"
                                        :paging-index="(pageIndex-1)*pageSize"
                                    ></v-table>
                                    <div class="mt-20 mb-20 float-right">
                                        <v-pagination @page-change="pageChange" @page-size-change="pageSizeChange" :total="tableDate.length" :page-size="pageSize" :layout="['prev', 'pager', 'next', 'sizer', 'total']"></v-pagination>
                                    </div>
                                </div>                                
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-laboratorio" role="tabpanel" aria-labelledby="pills-laboratorio-tab">
                            <p>Even the all-powerful Pointing has no control about the blind texts it is an almost unorthographic life One day however a small line of blind text by the name of Lorem Ipsum decided to leave for the far World of Grammar.</p>
                            <p>The Big Oxmox advised her not to do so, because there were thousands of bad Commas, wild Question Marks and devious Semikoli, but the Little Blind Text didn’t listen. She packed her seven versalia, put her initial into the belt and made herself on the way.
                            </p>
                        </div>
                        <div class="tab-pane fade" id="pills-recibidos" role="tabpanel" aria-labelledby="pills-recibidos-tab">
                            <p>Pityful a rethoric question ran over her cheek, then she continued her way. On her way she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word "and" and the Little Blind Text should turn around and return to its own, safe country.</p>

                            <p> But nothing the copy said could convince her and so it didn’t take long until a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged her into their agency, where they abused her for their</p>
                        </div>
                        <div class="tab-pane fade" id="pills-liquidados" role="tabpanel" aria-labelledby="pills-liquidados-tab">
                            <p>Pityful a rethoric question ran over her cheek, then she continued her way. On her way she met a copy. The copy warned the Little Blind Text, that where it came from it would have been rewritten a thousand times and everything that was left from its origin would be the word "and" and the Little Blind Text should turn around and return to its own, safe country.</p>

                            <p> But nothing the copy said could convince her and so it didn’t take long until a few insidious Copy Writers ambushed her, made her drunk with Longe and Parole and dragged her into their agency, where they abused her for their</p>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
        <!-- PAGE CONTENT MODAL ATENCIONES-->  
        <modal name="envio_laboratorio" :width="'35%'" :height="'300px'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de cargos -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Fecha de Entrega</div>
                    </div>
                    <div class="card-body">
                        <div class="col">
                            <div class="form-group row pt-0 d-inline">
                                <label for="fecha" class="col-12 pl-10 mb-0">Fecha de Entrega</label>
                                <date-picker v-model="dataLiquidacion.fecha_entrega" :first-day-of-week="1" :lang="lang" format="DD-MM-YYYY"></date-picker>
                            </div>                            
                        </div>  
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary" @click.prevent="envioLaboratorio" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
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
    },    
    data(){
        return {
            isLoading: false,
            fullPage: true,
            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos', 

            dataLiquidacion:{
                laboratorio_id:'',
                sede_id:'',
                fecha_corte:moment().format('DD-MM-YYYY'),
                fecha_entrega:moment().format('DD-MM-YYYY')
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
            pageIndex:1,
            pageSize:10,            
            tableConfig: {
                multipleSort: false,
                tableData: [],
                columns: [
                        {width: 60, titleAlign: 'center',columnAlign:'center',type: 'selection'},
                        {field: 'id', title: 'ID', width: 100, titleAlign: 'center', columnAlign: 'center'},
                        {field: 'presupuesto_id', title: 'Presupuesto', width: 120, titleAlign: 'center', columnAlign: 'center'},
                        {field: 'paciente', title: 'Paciente', width: 250, titleAlign: 'left', columnAlign: 'left'},
                        {field: 'servicio', title: 'Servicio', width: 250, titleAlign: 'left', columnAlign: 'left'},
                        {field: 'fase', title: 'Fase', width: 150, titleAlign: 'left', columnAlign: 'left'},
                        {field: 'pieza', title: 'Pieza', width: 150, titleAlign: 'left', columnAlign: 'left'}, 
                        {field: 'total', title: 'Total', width: 100, titleAlign: 'center', columnAlign: 'center'},
                        {field: 'doctor', title: 'Doctor', width: 250, titleAlign: 'left', columnAlign: 'left'},
                        {field: 'fecha_separacion', title: 'Fecha Separacion', width: 150, titleAlign: 'center', columnAlign: 'center',isFrozen: true} 
                        ],
            },      
            seleccionados:false,              
            color_selected:[],
            items_separados:[]          
        }
    },
    computed: {
        ...mapState(['user_system','sede_system','laboratorios','sedes','laboratoriotrabajos']),
        ...mapGetters(['getubigeos']),                                         
    },
    components: { DatePicker }, 
    methods:{
        cargaDatos(){
            this.isLoading = true
            let self = this
            this.tableDate = []
            this.seleccionados = false
            let filtrados = this.laboratoriotrabajos.filter(labt => labt.laboratorioservicio.laboratorio_id == this.dataLiquidacion.laboratorio_id && labt.seguimiento == 1 && labt.liquidable == 1 && labt.sede_id == this.dataLiquidacion.sede_id && moment(labt.fecha_separacion,'DD-MM-YYYY').isSameOrBefore(moment(this.dataLiquidacion.fecha_corte,'DD-MM-YYYY')))
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
                    fecha_separacion:value.fecha_separacion,
                    _checked:false
                }
                let copyfile = _.clone(files)
                self.tableDate.push(copyfile)
            })
            this.getTableData()            
        },
        getTableData(){
            this.tableConfig.tableData = this.tableDate.slice((this.pageIndex-1)*this.pageSize,(this.pageIndex)*this.pageSize)            
            this.isLoading = false
        },
        pageChange(pageIndex){
                this.pageIndex = pageIndex;
                this.getTableData();
                console.log(pageIndex)
        },
        pageSizeChange(pageSize){
            this.pageIndex = 1;
            this.pageSize = pageSize;
            this.getTableData();
        },
        sortChange(params){

            if (params.height.length > 0){

                this.tableConfig.tableData.sort(function (a, b) {

                    if (params.height === 'asc'){

                        return a.height - b.height;
                    }else if(params.height === 'desc'){

                            return b.height - a.height;
                    }else{

                        return 0;
                    }
                });
            }
        },  
        selectALL(selection){
            let self = this      
            if(selection.length > 0){
                _.each(this.tableConfig.tableData, function(value,key){
                    self.tableConfig.tableData[key]._checked = true
                })
            }else{
                _.each(this.tableConfig.tableData, function(value,key){
                    self.tableConfig.tableData[key]._checked = false
                })                
            }
            this.seleccionados = this.verificarSeleccionados()
        },
        selectChange(selection,rowData){
            let self = this
            _.each(this.tableConfig.tableData, function(value,key){
                if(value.id == rowData.id){
                    self.tableConfig.tableData[key]._checked = !self.tableConfig.tableData[key]._checked
                }
            })
            this.seleccionados = this.verificarSeleccionados()                    
        },
        selectGroupChange(selection){
            console.log('select-group-change',selection);
        }, 
        verificarSeleccionados(){
            let self = this
            let valor = false
            _.each(this.tableConfig.tableData, function(value,key){
                if(self.tableConfig.tableData[key]._checked){
                    valor = true
                    return
                }
            })
            return valor
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
        envioLaboratorio(){
            let datos = {
                id:this.dataLiquidacion.laboratorio_id,
                fecha_envio : moment().format('DD-MM-YYYY hh:mm:ss'),
                fecha_entrega: moment(this.dataLiquidacion.fecha_entrega).format('DD-MM-YYYY hh:mm:ss'),
                detalle:[]
            }
            _.each(this.tableConfig.tableData, function(value,key){
                if(value._checked){
                    datos.detalle.push(value.id)
                }
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

        }                           
    }           
}
</script>
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
</style>

