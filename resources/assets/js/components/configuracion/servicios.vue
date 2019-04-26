<template>
    <div class="col">
        <loading :active.sync="isLoading"
            :background-color="'#000'" 
            :color="'red'"
            :can-cancel="false" 
            :is-full-page="fullPage">
        </loading>         
        <ul class="nav nav-pills nav-primary" id="pills-tab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="pills-operatoria-tab" data-toggle="pill" href="#pills-operatoria" role="tab" aria-controls="pills-operatoria" aria-selected="true">Operatoria</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="pills-ortodoncia-tab" data-toggle="pill" href="#pills-ortodoncia" role="tab" aria-controls="pills-ortodoncia" aria-selected="false">Ortodoncia</a>
            </li>
        </ul>
        <div class="tab-content mb-3" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-operatoria" role="tabpanel" aria-labelledby="pills-operatoria-tab">
                <div class="col pl-0">
                    <!-- START DEFAULT DATATABLE -->
                    <div class="card text-white bg-white mb-3">
                        <div class="card-header pl-0 pr-0">                        
                            <div class="col">
                                <button type="button" class="btn btn-primary float-right" @click.prevent="LoadFormOper"><span class="btn-label"><i class="flaticon-circle"></i></span> Nuevo Servicio</button>
                                <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                            </div>                                                        
                        </div>
                        <div class="card-body">
                            <vue-good-table
                            :columns="columns"
                            :rows="getservicios_operatoria"
                            :paginationOptions="{
                                enabled: true,
                                dropdownAllowAll: false,
                                nextLabel: 'Sig',
                                prevLabel: 'Ant',
                                rowsPerPageLabel: 'Registros por Pagina',
                                ofLabel: 'de',
                                allLabel: 'Todos',
                            }"
                            @on-row-dblclick="processEdit"
                            :rowStyleClass="'enlace'"
                            :lineNumbers="true"
                            styleClass="vgt-table condensed bordered striped">
                                <template slot="table-row" slot-scope="props">
                                    <span v-if="props.column.field == 'btn'" class="center">
                                        <button type="button" class="btn btn-border btn-success btn-xs" v-tooltip="'Actualizar Servicio'" @click.prevent="processEdit(props)">
                                            <i class="la la-edit font-large"></i>
                                        </button>                                
                                        <button type="button" class="btn btn-border btn-danger btn-xs" v-tooltip="'Eliminar Servicio'" @click.prevent="processDelete(props.row.id)">
                                            <i class="la la-trash-o font-large"></i>
                                        </button>                                
                                    </span>
                                    <span v-else-if="props.column.field == 'laboratorio'" class="center">
                                        <span class="center badge" :class="[props.row.laboratorio == 1 ? 'badge-primary' : 'badge-danger']">{{ props.row.laboratorio == 1 ? 'SI' : 'NO'}}</span>
                                    </span>
                                    <span v-else-if="props.column.field == 'materiales'" class="center">
                                        <span class="center badge" :class="[props.row.materiales == 1 ? 'badge-primary' : 'badge-danger']">{{ props.row.materiales == 1 ? 'SI' : 'NO'}}</span>
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
            <div class="tab-pane fade" id="pills-ortodoncia" role="tabpanel" aria-labelledby="pills-ortodoncia-tab">
                <div class="col pl-0">
                    <!-- START DEFAULT DATATABLE -->
                    <div class="card text-white bg-white mb-3">
                        <div class="card-header pl-0 pr-0">                        
                            <div class="col">
                                <button type="button" class="btn btn-primary float-right" @click.prevent="LoadFormOrto"><span class="btn-label"><i class="flaticon-circle"></i></span> Nuevo Servicio</button>
                                <button type="button" class="btn btn-primary btn-border" @click.prevent="showSearch(columns)"><span class="btn-label"><i class="flaticon-search-2"></i></span> Buscar</button>
                            </div>                                                        
                        </div>
                        <div class="card-body">
                            <vue-good-table
                            :columns="columns"
                            :rows="getservicios_ortodoncia"
                            :paginationOptions="{
                                enabled: true,
                                dropdownAllowAll: false,
                                nextLabel: 'Sig',
                                prevLabel: 'Ant',
                                rowsPerPageLabel: 'Registros por Pagina',
                                ofLabel: 'de',
                                allLabel: 'Todos',
                            }"
                            @on-row-dblclick="processEdit"
                            :rowStyleClass="'enlace'"
                            :lineNumbers="true"
                            styleClass="vgt-table condensed bordered striped">
                                <template slot="table-row" slot-scope="props">
                                    <span v-if="props.column.field == 'btn'" class="center">
                                        <button type="button" class="btn btn-border btn-success btn-xs" v-tooltip="'Actualizar Servicio'" @click.prevent="processEdit(props)">
                                            <i class="la la-edit font-large"></i>
                                        </button>                                
                                        <button type="button" class="btn btn-border btn-danger btn-xs" v-tooltip="'Eliminar Servicio'" @click.prevent="processDelete(props.row.id)">
                                            <i class="la la-trash-o font-large"></i>
                                        </button>                                
                                    </span>
                                    <span v-else-if="props.column.field == 'laboratorio'" class="center">
                                        <span class="center badge" :class="[props.row.laboratorio == 1 ? 'badge-primary' : 'badge-danger']">{{ props.row.laboratorio == 1 ? 'SI' : 'NO'}}</span>
                                    </span>
                                    <span v-else-if="props.column.field == 'materiales'" class="center">
                                        <span class="center badge" :class="[props.row.materiales == 1 ? 'badge-primary' : 'badge-danger']">{{ props.row.materiales == 1 ? 'SI' : 'NO'}}</span>
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
        </div>
        <!-- PAGE CONTENT MODAL -->  
        <modal name="servicio" :width="'50%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de servicios -->
                <div class="card mb-0">
                    <div class="card-header bg-primary pt-10 pb-10">
                        <div class="card-title text-white">{{ labelAccion }} de Servicio</div>
                    </div>
                    <div class="card-body pt-0">
                        <div class="form-group">
                            <label for="nombre" class="text-primary font-weight-bold mb-0">Nombre de Servicio</label>
                            <input type="text" id="nombre" class="form-control form-control-sm border border-primary mayusculas" v-model="dataServicio.nombre_servicio">
                        </div>
                        <div class="form-check pt-0 pb-0" v-if="!showGroups">
                            <label class="form-check-label">
                                <input class="form-check-input" type="checkbox" v-model="showService"/>
                                <span class="form-check-sign text-primary font-weight-bold">Depende de otro Servicio</span>
                            </label>
                        </div> 
                        <div class="form-group pt-0 pb-0" v-if="showService">
                            <label for="basic" class="text-primary font-weight-bold">Servicios :</label>
                            <div class="select2-input">
                                <select id="basic" name="basic" class="form-control form-control-sm border border-primary" v-model="dataServicio.parentid_ortodoncia" @change="MuestraImagen(dataServicio.simbologia_id)">
                                    <option v-for="servicio in getservicios_ortodoncia_main" :value="servicio.id" :key="servicio.id">
                                        {{ servicio.nombre_servicio}}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="row pt-10" v-if="!showGroups">
                            <div class="col-4">
                                <div class="form-check col-6 pt-0 pb-0">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" v-model="dataServicio.control_ortodoncia" true-value=1 false-value=0 />
                                        <span class="form-check-sign text-primary font-weight-bold">Control Ortodoncia</span>
                                    </label>
                                </div>                             
                            </div> 
                            <div class="col-4">
                                <div class="form-check col-6 pt-0 pb-0">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" v-model="dataServicio.cuota_inicial" true-value=1 false-value=0 />
                                        <span class="form-check-sign text-primary font-weight-bold">Cuota Inicial</span>
                                    </label>
                                </div>                             
                            </div>  
                            <div class="col-4">
                                <div class="form-check col-6 pt-0 pb-0">
                                    <label class="form-check-label">
                                        <input class="form-check-input" type="checkbox" v-model="dataServicio.ortofacil" true-value=1 false-value=0 />
                                        <span class="form-check-sign text-primary font-weight-bold">Ortofacil</span>
                                    </label>
                                </div>                             
                            </div>                                                                                     
                        </div>                                                
                        <div class="row pl-20" v-if="showGroups">
                            <span class="col-12 pb-0 pl-10">
                                <label class="text-primary font-weight-bold mb-0">Grupos :</label>
                            </span>
                            <div class="form-check col-6 pt-0 pb-0" v-for="grupo in gruposervicios" :key="grupo.id" >
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" :id="grupo.id" :value="grupo.id" v-model="dataServicio.dataGrupos" />
                                    <span class="form-check-sign text-primary">{{ grupo.nombre_gruposervicio }}</span>
                                </label>
                            </div>                             
                        </div>
                        <div class="row pl-20 pb-20 pt-20">
                            <div class="col-8 pl-5">
                                <label for="basic" class="text-primary font-weight-bold pb-0">Simbología :</label>
                                <div class="select2-input">
                                    <select id="basic" name="basic" class="form-control form-control-sm border border-primary" v-model="dataServicio.simbologia_id" @change="MuestraImagen(dataServicio.simbologia_id)">
                                        <option value="">-- seleccione --</option>
                                        <option v-for="simbolo in simbologias" :value="simbolo.id" :key="simbolo.id">
                                            {{ simbolo.nombre_simbologia}}
                                        </option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-4 pr-20">
                                <img v-if="rutaSimbolo != ''" :src="'/img/odontograma/'+rutaSimbolo" alt="" class="float-right pr-10">
                            </div>
                        </div>
                        <div class="row pl-20">
                            <div class="form-check col-4 pt-0 pb-0" >
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" v-model="dataServicio.laboratorio" true-value=1 false-value=0 />
                                    <span class="form-check-sign text-primary font-weight-bold">Aplica Laboratorio</span>
                                </label>
                            </div>   
                            <div class="form-check col-4 pt-0 pb-0" >
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" v-model="dataServicio.materiales" true-value=1 false-value=0 />
                                    <span class="form-check-sign text-primary font-weight-bold">Aplica Materiales</span>
                                </label>
                            </div> 
                            <div class="form-check col-4 pt-0 pb-0" >
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" value="" v-model="dataServicio.pago_doctor" true-value=1 false-value=0 />
                                    <span class="form-check-sign text-primary font-weight-bold">Liquidar al Doctor</span>
                                </label>
                            </div>                               
                        </div>                
                    </div>
                    <div class="card-action pt-20 pb-20">
                        <button class="btn btn-danger float-right ml-10" @click="$modal.hide('servicio')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                        <button class="btn btn-primary float-right" @click.prevent="ActionServicio" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                    </div>
                </div>
            <!-- /. form de registro de servicio -->
        </modal>  
    </div>   
</template>
<script>
import mixin from '../../mixins.js'
import  {_} from 'vue-underscore'
import { mapState, mapGetters } from 'vuex'
export default {
    name:'servicios',
    mixins: [mixin],
    mounted() {
        this.$store.dispatch('LOAD_GRUPOSERVICIOS_LIST')
        this.$store.dispatch('LOAD_SIMBOLOGIAS_LIST')
        this.$store.dispatch('LOAD_SERVICIOS_LIST').then(() => {
            this.isLoading = false
        })                       
    },      
    data(){
        return {
            isLoading: true,
            fullPage: true,

            labelAccion : '',
            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos',             
            columns: [
                {
                label: 'Nombre de Servicio',
                field: 'nombre_servicio',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'30%',
                },
                {
                label: 'Grupo',
                field: this.fieldFn,
                width:'25%',
                },
                {
                label: 'Laboratorio',
                field: 'laboratorio',
                thClass: 'center',
                tdClass: 'center',
                width:'10%',
                },
                {
                label: 'Material',
                field: 'materiales',
                thClass: 'center',
                tdClass: 'center',
                width:'10%',
                },                                                                                                                                                                                           
                {
                label: 'Simbologia',
                field: 'simbologia.nombre_simbologia',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },
                width:'10%',
                },                                                                                                                                                                                           
                {
                label: 'Acción',
                field: 'btn',
                tdClass: 'center',
                html: true  ,
                width:'15%',  
                }                               
            ],
            dataServicio:{
                nombre_servicio:'',
                user_id:'',
                simbologia_id:'',
                tipo:'',
                parentid_ortodoncia:'',
                laboratorio:'',
                materiales:'',
                pago_doctor:'',
                exodoncia:'',
                control_ortodoncia:'',      //  serviciodetalles
                cuota_inicial:'',           //  serviciodetalles
                ortofacil:'',               //  serviciodetalles
                dataGrupos:[]                
            },

            rutaSimbolo:'',
            showGroups: true ,
            showService: false,
            
            errors:[]
        }
    },
    computed: {
        ...mapState(['servicios','gruposervicios','simbologias','user_system']),
        ...mapGetters(['getservicios_operatoria','getservicios_ortodoncia','getservicios_ortodoncia_main','getgruposervicios_operatoria']),        
    },
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },
        LoadFormOper: function(){  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')   
            this.rutaSimbolo = ''      
            this.showGroups = true
            this.showService = false
            this.dataServicio = {
                nombre_servicio:'',
                simbologia_id:'',
                tipo:1,
                parentid_ortodoncia:'',
                laboratorio: 0,
                materiales: 0 , 
                exodoncia: 0,
                pago_doctor: 0,
                control_ortodoncia: 0,      //  serviciodetalles
                cuota_inicial: 0,           //  serviciodetalles
                ortofacil: 0,               //  serviciodetalles  
                dataGrupos:[],                            
                user_id: this.user_system.id
            }   
            this.labelAccion = "Registro"        
            this.$modal.show('servicio')
        }, 
        LoadFormOrto: function(){  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')
            this.rutaSimbolo = ''                     
            this.showGroups = false
            this.showService = false            
            this.dataServicio = {
                nombre_servicio:'',
                simbologia_id:'',
                tipo:2,
                parentid_ortodoncia:'',
                laboratorio:0,
                materiales:0 , 
                exodoncia:0,
                pago_doctor:0,
                control_ortodoncia:0,      //  serviciodetalles
                cuota_inicial:0,           //  serviciodetalles
                ortofacil:0 ,               //  serviciodetalles   
                dataGrupos:[],                            
                user_id: this.user_system.id
            }   
            this.labelAccion = "Registro"        
            this.$modal.show('servicio')
        },         
        ActionServicio: function(){
            if(typeof(this.dataServicio.id) === "undefined"){
                this.createServicio()
            }else{
                this.updateServicio()
            }
        },
        createServicio: function(){
            var url = '/api/servicios';
            this.CargaExodoncia()
            this.StatusForm(true,'la la-spinner','Procesando') 
            if(this.dataServicio.tipo === 2){
                this.CargaOrtodoncia()
            }   
            axios.post(url, this.dataServicio).then(response => {
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
            this.$store.dispatch('LOAD_SERVICIOS_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('servicio');   
            this.notificaciones('Nuevo servicio creado con exito','la la-thumbs-up','success')       
            }).catch(error => {
            this.errors = error.response.data.status;           
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')           
            });
        },
        updateServicio: function(){
            var url = '/api/servicios/'+this.dataServicio.id; 
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.put(url, this.dataServicio).then(response => {
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
                    return;
                }

                this.$store.dispatch('LOAD_SERVICIOS_LIST')                  
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
                this.$modal.hide('servicio');  
                this.notificaciones('el Servicio fue actualizado con exito','la la-thumbs-up','success')                  
            }).catch(error => {
                this.errors = error.response.data.status;  
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')
            });
        },
        processEdit(params){
            var dataser = []
            dataser = _.clone(params.row)
            this.showGroups = true
            this.showService = false
            this.dataServicio = {
                id:dataser.id,
                nombre_servicio:dataser.nombre_servicio,
                simbologia_id:dataser.simbologia_id,
                tipo:dataser.tipo,
                parentid_ortodoncia:dataser.parentid_ortodoncia,
                laboratorio:dataser.laboratorio,
                materiales:dataser.materiales , 
                pago_doctor:dataser.pago_doctor,              
                user_id: dataser.user_id                                                         
            }  
            if(dataser.tipo == 2){
                this.dataServicio.control_ortodoncia = dataser.serviciodetalle.control_ortodoncia
                this.dataServicio.cuota_inicial = dataser.serviciodetalle.cuota_inicial
                this.dataServicio.ortofacil = dataser.serviciodetalle.ortofacil
                this.showGroups = false
                if(dataser.parentid_ortodoncia > 0){
                    this.showService = true
                }
            }            
            var list=[];
            var imod = _.size(params.row.gruposervicios)
            if(imod > 0){
                params.row.gruposervicios.map(function(value, key) {
                    list.push(value.id)
                }) 
            }   
            this.dataServicio.dataGrupos = list  
            this.labelAccion = "Actualización"
            if(dataser.simbologia_id != null){
                this.MuestraImagen(dataser.simbologia.id)
            }         
            this.$modal.show('servicio')
        
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
                        var url = '/api/servicios/' + id;
                        axios.delete(url).then(response=> {
                            this.$store.dispatch('LOAD_SERVICIOS_LIST').then(() => {
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
        MuestraImagen: function(id){            
            var img = _.find(this.simbologias, function(sim){ return sim.id  === id })
            this.rutaSimbolo = img.imagen
        },
        CargaExodoncia: function(){
            this.dataServicio.exodoncia = 0
            var exoid = _.find(this.gruposervicios, function(gru){ return gru.nombre_gruposervicio  === 'EXODONCIA' })
            if(exoid != undefined){
                var id_ex = _.find(this.dataServicio.dataGrupos, function(gru){ return gru  === exoid })
                if(id_ex != undefined){
                    this.dataServicio.exodoncia = 1
                }
            }
        },
        CargaOrtodoncia: function(){
            var ortid = _.find(this.gruposervicios, function(gru){ return gru.nombre_gruposervicio  === 'ORTODONCIA' })
            this.dataServicio.dataGrupos.push(ortid.id)
        },        
        fieldFn(rowObj) {
            var list = [];
            rowObj.gruposervicios.map(function(value, key) {
                list.push(value.nombre_gruposervicio)
            }) 
            return list.join(' - ')         
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

    .hide-border {
        border-color:white !important;
    }
    .badge {
        border-radius: 3px !important;
    }
</style>
