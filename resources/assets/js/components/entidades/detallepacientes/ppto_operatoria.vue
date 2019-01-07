<template>
    <div class="row">
        <div class="col-12">
            <div class="row">
				<button class="btn btn-info"><span class="btn-label"><i class="la la-info"></i></span>Tx sin Piezas</button>
				<button class="btn btn-success"><span class="btn-label"><i class="la la-check"></i></span>Grabar</button>
				<button class="btn btn-warning" v-if="!select_multi" @click.prevent="select_multi = true"><span class="btn-label"><i class="la la-exclamation-circle"></i></span>Seleccion Multiple</button>             
				<button class="btn btn-primary" v-if="select_multi" :disabled="!(multipiezas.length > 1)" @click.prevent="LoadServices"><span class="btn-label"><i class="la la-bookmark"></i></span>Cargar Servicios</button>
            </div>
            <div class="row">
                <div class="col-12">
                    <p class="form-control-static text-center font-weight-bold mb-0">BUCAL</p>
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
                                            <p class="form-control-static text-center mb-0" :class="{seleccionado:multipiezas.includes('t'+ info.id),'text-danger':multipiezas.includes('t'+ info.id)}" :id="'t'+info.id">{{ info.codigo }}</p>
                                            <input type="text" name="" :id="'d'+info.id" class="texto-dientito" maxlength="3"> 
                                            <div>
                                                <svg height="32" :class="info.tipo" width="32" v-tooltip.top-start="info.nombre_diente" :id="info.id" @click.prevent="ShowDiente(info)">
                                                    <polygon points="6,9 9,6 30,27 27,30" estado="4" value="6" class="ausente" />
                                                    <polygon points="27,6 30,9 9,30 6,27" estado="4" value="7" class="ausente" />
                                                    <circle cx="18" cy="18" r="10" estado="8" value="8" class="corona"/>
                                                    <circle cx="18" cy="18" r="12" estado="3" value="9" class="endodoncia"/>
                                                    <polygon points="30,6 24,6 6,16 6,19 28,19 6,30 12,30 30,22 30,17 8,17" estado="6" value="10" class="implante"/>
                                                    <polygon points="6,6 30,6 24,12 12,12" estado="0" value="1" class="diente" /> <!-- CARA 1 Trapecio superior -->
                                                    <polygon points="30,6 30,30 24,24 24,12" estado="0" value="2" class="diente" /> <!-- CARA 2 Trapecio lateral derecho -->
                                                    <polygon points="30,30 6,30 12,24 24,24" estado="0" value="3" class="diente" /> <!-- CARA 3 Trapecio inferior -->
                                                    <polygon points="6,30 12,24 12,12 6,6" estado="0" value="4" class="diente" /> <!-- CARA 4 trapecio lateral izquierdo-->
                                                    <polygon points="12,12 24,12 24,24 12,24" estado="0" value="5" class="diente" /> <!-- CARA 5 Cuadrado Central -->
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="row" v-for="i in cuadrante_derecho_superior" :key="i">
                                        <div v-for="info in getDientesByCuadrante(i)" :key="info.id" class="dientito">
                                            <p class="form-control-static text-center mb-0" :class="{seleccionado:multipiezas.includes('t'+ info.id),'text-danger':multipiezas.includes('t'+ info.id)}" :id="'t'+info.id">{{ info.codigo }}</p>
                                            <input type="text" name="" :id="'d'+info.id" class="texto-dientito" maxlength="3"> 
                                            <div>
                                                <svg height="32" :class="info.tipo" width="32" v-tooltip.top-start="info.nombre_diente" :id="info.id" @click.prevent="ShowDiente(info)">
                                                    <polygon points="6,9 9,6 30,27 27,30" estado="4" value="6" class="ausente" />
                                                    <polygon points="27,6 30,9 9,30 6,27" estado="4" value="7" class="ausente" />
                                                    <circle cx="18" cy="18" r="10" estado="8" value="8" class="corona"/>
                                                    <circle cx="18" cy="18" r="12" estado="3" value="9" class="endodoncia"/>
                                                    <polygon points="30,6 24,6 6,16 6,19 28,19 6,30 12,30 30,22 30,17 8,17" estado="6" value="10" class="implante"/>
                                                    <polygon points="6,6 30,6 24,12 12,12" estado="0" value="1" class="diente" /> <!-- CARA 1 Trapecio superior -->
                                                    <polygon points="30,6 30,30 24,24 24,12" estado="0" value="2" class="diente" /> <!-- CARA 2 Trapecio lateral derecho -->
                                                    <polygon points="30,30 6,30 12,24 24,24" estado="0" value="3" class="diente" /> <!-- CARA 3 Trapecio inferior -->
                                                    <polygon points="6,30 12,24 12,12 6,6" estado="0" value="4" class="diente" /> <!-- CARA 4 trapecio lateral izquierdo-->
                                                    <polygon points="12,12 24,12 24,24 12,24" estado="0" value="5" class="diente" /> <!-- CARA 5 Cuadrado Central -->
                                                </svg>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="row borde-inferior">
                                <div class="col-12">
                                    <p class="form-control-static text-center font-weight-bold mb-0">LINGUAL</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6 borde-derecho">
                                    <div class="row d-flex justify-content-end" v-for="i in cuadrante_izquierdo_inferior" :key="i">
                                        <div v-for="info in getDientesByCuadrante(i)" :key="info.id" class="dientito">
                                            <p class="form-control-static text-center mb-0" :class="{seleccionado:multipiezas.includes('t'+ info.id),'text-danger':multipiezas.includes('t'+ info.id)}" :id="'t'+info.id">{{ info.codigo }}</p>
                                            <input type="text" name="" :id="'d'+info.id" class="texto-dientito" maxlength="3"> 
                                            <div>
                                                <svg height="32" :class="info.tipo" width="32" v-tooltip.top-start="info.nombre_diente" :id="info.id" @click.prevent="ShowDiente(info)">
                                                    <polygon points="6,9 9,6 30,27 27,30" estado="4" value="6" class="ausente" />
                                                    <polygon points="27,6 30,9 9,30 6,27" estado="4" value="7" class="ausente" />
                                                    <circle cx="18" cy="18" r="10" estado="8" value="8" class="corona"/>
                                                    <circle cx="18" cy="18" r="12" estado="3" value="9" class="endodoncia"/>
                                                    <polygon points="30,6 24,6 6,16 6,19 28,19 6,30 12,30 30,22 30,17 8,17" estado="6" value="10" class="implante"/>
                                                    <polygon points="6,6 30,6 24,12 12,12" estado="0" value="1" class="diente" /> <!-- CARA 1 Trapecio superior -->
                                                    <polygon points="30,6 30,30 24,24 24,12" estado="0" value="2" class="diente" /> <!-- CARA 2 Trapecio lateral derecho -->
                                                    <polygon points="30,30 6,30 12,24 24,24" estado="0" value="3" class="diente" /> <!-- CARA 3 Trapecio inferior -->
                                                    <polygon points="6,30 12,24 12,12 6,6" estado="0" value="4" class="diente" /> <!-- CARA 4 trapecio lateral izquierdo-->
                                                    <polygon points="12,12 24,12 24,24 12,24" estado="0" value="5" class="diente" /> <!-- CARA 5 Cuadrado Central -->
                                                </svg>
                                            </div>
                                        </div>
                                    </div>                            
                                </div>
                                <div class="col-6">
                                    <div class="row" v-for="i in cuadrante_derecho_inferior" :key="i">
                                        <div v-for="info in getDientesByCuadrante(i)" :key="info.id" class="dientito">
                                            <p class="form-control-static text-center mb-0" :class="{seleccionado:multipiezas.includes('t'+ info.id),'text-danger':multipiezas.includes('t'+ info.id)}" :id="'t'+info.id">{{ info.codigo }}</p>
                                            <input type="text" name="" :id="'d'+info.id" class="texto-dientito" maxlength="3"> 
                                            <div>
                                                <svg height="32" :class="info.tipo" width="32" v-tooltip.top-start="info.nombre_diente" :id="info.id" @click.prevent="ShowDiente(info)">
                                                    <polygon points="6,9 9,6 30,27 27,30" estado="4" value="6" class="ausente" />
                                                    <polygon points="27,6 30,9 9,30 6,27" estado="4" value="7" class="ausente" />
                                                    <circle cx="18" cy="18" r="10" estado="8" value="8" class="corona"/>
                                                    <circle cx="18" cy="18" r="12" estado="3" value="9" class="endodoncia"/>
                                                    <polygon points="30,6 24,6 6,16 6,19 28,19 6,30 12,30 30,22 30,17 8,17" estado="6" value="10" class="implante"/>
                                                    <polygon points="6,6 30,6 24,12 12,12" estado="0" value="1" class="diente" /> <!-- CARA 1 Trapecio superior -->
                                                    <polygon points="30,6 30,30 24,24 24,12" estado="0" value="2" class="diente" /> <!-- CARA 2 Trapecio lateral derecho -->
                                                    <polygon points="30,30 6,30 12,24 24,24" estado="0" value="3" class="diente" /> <!-- CARA 3 Trapecio inferior -->
                                                    <polygon points="6,30 12,24 12,12 6,6" estado="0" value="4" class="diente" /> <!-- CARA 4 trapecio lateral izquierdo-->
                                                    <polygon points="12,12 24,12 24,24 12,24" estado="0" value="5" class="diente" /> <!-- CARA 5 Cuadrado Central -->
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
            <div class="row">
                <button type="button" id="ver">VER</button>
            </div>
        </div>
        <!-- PAGE CONTENT MODAL -->  
        <modal name="carga_servicios" :width="'70%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de servicios -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Presupuesto</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-12">
                                <div v-for="sim in simbolos" class="col-1 form-check form-check-inline pl-0" :key="sim.id" :class="{trata_selected:sim.id == selected}">
                                    <p-radio class="p-icon p-curve p-tada mr-0" :value="sim.id" name="radio66" color="primary-o" v-model="dataTratamiento.simbologia_id" @change="cambiotratamiento(sim.id)">
                                        <i slot="extra" class="icon la la-check"></i>                                
                                    </p-radio>
                                    <div>
                                        <svg height="42" width="42" v-tooltip.top="sim.nombre_simbologia" :id="infodent.id">
                                            <!-- Caras del Diente -->
                                            <polygon points="8,8 40,8 32,16 16,16" estado="0" value="1" class="_diente" /> <!-- CARA 1 Trapecio superior -->
                                            <polygon points="40,8 40,40 32,32 32,16" estado="0" value="2" class="_diente" /> <!-- CARA 2 Trapecio lateral derecho -->
                                            <polygon points="40,40 8,40 16,32 32,32" estado="0" value="3" class="_diente" /> <!-- CARA 3 Trapecio inferior -->
                                            <polygon points="8,40 16,32 16,16 8,8" estado="0" value="4" class="_diente" /> <!-- CARA 4 trapecio lateral izquierdo-->
                                            <polygon points="16,16 32,16 32,32 16,32" estado="0" value="5" class="_diente" /> <!-- CARA 5 Cuadrado Central -->
                                            <!-- Tratamientos / Estados del diente -->
                                            <polygon points="21,8 27,8 27,40 21,40" :class="[sim.id == 2 ? 'marcadoEndodoncia marcado' : 'endodoncia']"/>
                                            <circle cx="24" cy="24" r="13" estado="8" value="8" :class="[sim.id == 3 ? 'marcadoCorona marcado' : 'corona']"/>
                                            <polygon points="8,12 12,8 40,36 36,40" estado="4" value="6" :class="[sim.id == 4 ? 'marcadoExodoncia marcado' : 'exodoncia']"/>                                    
                                            <polygon points="36,8 40,12 12,40 8,36" estado="4" value="7" :class="[sim.id == 4 ? 'marcadoExodoncia marcado' : 'exodoncia']" />
                                            <image v-if="sim.id == 5" xlink:href="/img/odontograma/perno3.png" x=8 y=8 width=34 height=34 />
                                            <path d="M 10,25 a10,10 0 1,1 28,0" :class="[sim.id == 6 ? 'marcadoIonomero marcado' : 'ionomero']"></path>
                                            <text x=13 y=35 :class="[sim.id == 7 ? 'marcadoSellante marcado' : 'sellante']">S</text>                                                                        
                                            <ellipse cx="24" cy="20" rx="15" ry="9"  estado="10" value="11" :class="[sim.id == 8 ? 'marcadoGeneral marcado' : 'general']"/>
                                            <line x1="8" y1="20" x2="40" y2="20" :class="[sim.id == 8 ? 'marcadoGeneral marcado' : 'general']"/>                                    
                                            <text x=10 y=38 :class="[sim.id == 8 ? 'marcadoTextGeneral marcado' : 'sellante']">BOCA</text>                                                                        
                                        </svg>
                                    </div>

                                </div>
                            </div>                                                                                                                                                                           
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-primary btn-sm float-right" @click.prevent="$modal.show('tratamientos')">Buscar Servicios <i class="la flaticon-search-2"></i></button>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-3">
                                <svg height="202" :class="infodent.tipoDiente" width="202" :id="infodent.id">
                                    <!-- Caras del Diente -->                                        
                                    <polygon points="40,40 200,40 160,80 80,80" v-tooltip.top="'VESTIBULAR'" :class="[dataTratamiento.simbologia_id == 1 && multicaras.includes(1) ? 'marcadoRojo marcado' : 'diente']" @click.prevent="selectD(1)" /> <!-- CARA 1 Trapecio superior -->
                                    <polygon points="200,40 200,200 160,160 160,80" v-tooltip.right="'MESIAL'" :class="[dataTratamiento.simbologia_id == 1 && multicaras.includes(2) ? 'marcadoRojo marcado' : 'diente']" @click.prevent="selectD(2)" /> <!-- CARA 2 Trapecio lateral derecho -->
                                    <polygon points="200,200 40,200 80,160 160,160" v-tooltip.bottom="'PALATINO'" :class="[dataTratamiento.simbologia_id == 1 && multicaras.includes(3) ? 'marcadoRojo marcado' : 'diente']" @click.prevent="selectD(3)"/> <!-- CARA 3 Trapecio inferior -->
                                    <polygon points="40,200 80,160 80,80 40,40" v-tooltip.left="'DISTAL'" :class="[dataTratamiento.simbologia_id == 1 && multicaras.includes(4) ? 'marcadoRojo marcado' : 'diente']" @click.prevent="selectD(4)" /> <!-- CARA 4 trapecio lateral izquierdo-->
                                    <polygon points="80,80 160,80 160,160 80,160" v-tooltip.top="'OCLUSAL'" :class="[dataTratamiento.simbologia_id == 1 && multicaras.includes(5) ? 'marcadoRojo marcado' : 'diente']" @click.prevent="selectD(5)" /> <!-- CARA 5 Cuadrado Central -->
                                    <!-- Tratamientos del Diente -->
                                    <polygon points="115,45 127,45 127,195 115,195" :class="[dataTratamiento.simbologia_id == 2 ? 'marcadoEndodonciaD marcado' : 'endodoncia']"/>                                           
                                    <circle cx="120" cy="120" r="70" :class="[dataTratamiento.simbologia_id == 3 ? 'marcadoCoronaD marcado' : 'corona']"/>
                                    <polygon points="40,50 50,40 200,190 190,200" :class="[dataTratamiento.simbologia_id == 4 ? 'marcadoExodonciaD marcado' : 'exodoncia']"/>                                    
                                    <polygon points="190,40 200,50 50,200 40,190" :class="[dataTratamiento.simbologia_id == 4 ? 'marcadoExodonciaD marcado' : 'exodoncia']" />
                                    <image v-if="dataTratamiento.simbologia_id == 5" xlink:href="/img/odontograma/perno4.png" x=40 y=40 width=160 height=160 />                                        
                                    <path d="M 50,125 a40,40 0 1,1 140,0" :class="[dataTratamiento.simbologia_id == 6 ? 'marcadoIonomeroD marcado' : 'ionomero']"></path>
                                    <text x=80 y=170 :class="[dataTratamiento.simbologia_id == 7 ? 'marcadoSellanteD marcado' : 'sellante']">S</text>                                                                        
                                    <ellipse cx="120" cy="120" rx="75" ry="35"  :class="[dataTratamiento.simbologia_id == 8 ? 'marcadoGeneralD marcado' : 'general']"/>
                                    <line x1="45" y1="120" x2="195" y2="120" :class="[dataTratamiento.simbologia_id == 8 ? 'marcadoGeneralD marcado' : 'general']"/>                                    
                                </svg>
                            </div>
                            <div class="col-9">
                                <table class="table table-bordered table-sm table-head-bg-info table-bordered-bd-info mt-4">
                                    <thead>
                                        <tr>
                                            <th scope="col">Diente</th>
                                            <th scope="col">Servicio</th>
                                            <th scope="col">Moneda</th>
                                            <th scope="col">Deducible</th>
                                            <th scope="col">Coaseguro</th>
                                            <th scope="col">P.Aseg</th>     
                                            <th scope="col">C.Total</th>
                                            <th scope="col">Pago</th>                                                                                                                          
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr v-if="dataTratamiento.letras.length > 0">
                                            <td>{{ dataTratamiento.letras }}</td>
                                            <td>{{ dataTratamiento.nombre_servicio}}</td>
                                            <td>{{ dataTratamiento.nombre_moneda}}</td>
                                            <td>0</td>
                                            <td>0</td>  
                                            <td>0</td>   
                                            <td>{{ dataTratamiento.costo}}</td>  
                                            <td>{{ dataTratamiento.costo}}</td>                                                                                                                         
                                        </tr>
                                    </tbody>
                                </table>                                
                            </div>

                        </div>
                    </div>
                    <div class="card-action">
<!--                         <button class="btn btn-primary" @click.prevent="ActionCargo" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
 -->                        <button class="btn btn-danger" @click="salirDiente"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de servicios -->
        </modal>
        <modal id="tratamientos" name="tratamientos" :width="'60%'" height="auto" transition="pop-out" :scrollable="true" :clickToClose="false" >
           <div class="card mb-0">
                <div class="card-header">
                    <div class="card-title d-inline">Seleccione un Servicio</div>
                    <button type="button" class="close d-inline" aria-label="Close" @click.prevent="$modal.hide('tratamientos')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                     <div class="col">
                        <!-- START DEFAULT DATATABLE -->
                        <vue-good-table
                        :columns="columns_servicios"
                        :rows="tarifarios"
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
                        @on-row-click="selectServicio"
                        max-height="400px"
                        styleClass="vgt-table condensed bordered striped"> 
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'btn'" class="center">
                                <button type="button" data-toggle="tooltip" title="" class="btn btn-primary btn-xs" data-original-title="" @click.prevent="selectServicio(props.row)">
                                    Seleccionar
                                </button>                                                               
                            </span>
                            <span v-else>
                                {{props.formattedRow[props.column.field]}}
                            </span>
                        </template>                                                    
                        </vue-good-table>
                        <!-- END DEFAULT DATATABLE -->  
                     </div>
                </div>
            </div>                                
        </modal>           
    </div>
</template>
<script>
import mixin from '../../../mixins.js'
import  {_} from 'vue-underscore'
//import '../../jquery-js/jquery-odontograma.js'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'ppto-operatoria',
    mixins: [mixin],   
    created() {
        this.$store.dispatch('LOAD_DIENTES_LIST') 
        this.$store.dispatch('LOAD_SIMBOLOGIAS_LIST')   
        this.$store.dispatch('LOAD_TARIFARIOS_LIST')                          
    },     
    data(){
        return {
            isLoading: true,
            fullPage: true,

            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos', 

            columns_servicios: [
                {
                label: 'Servicio',
                field: 'servicio.nombre_servicio',
                width:'30%',
                }, 
                {
                label: 'Costo',
                field: 'costo',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },             
                width:'15%',
                },
                {
                label: 'Moneda',
                field: 'moneda.nombre_moneda',
                width:'15%',
                },                 
                {
                label: 'Pago',
                field: 'plan.descripcion',
                filterOptions: {
                    enabled: false, 
                    placeholder: 'Buscar', 
                },                 
                width:'20%',
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
            dataTratamiento:{
                simbologia_id:'',
                letras:'',
                servicio_id:'',
                nombre_servicio:'',
                moneda_id:'',
                nombre_moneda:'',
                costo:''

            },
            denteselect:'',
            infodent:'',
            multipiezas:[],
            multicaras:[],
            letrascaras:[],
            select_multi: false,
            selected: undefined,
            cuadrante_izquierdo_superior:[1,5],
            cuadrante_derecho_superior:[2,6],
            cuadrante_izquierdo_inferior:[8,4],
            cuadrante_derecho_inferior:[7,3]
        }
    },
    computed: {
        ...mapState(['dientes','simbologias','tarifarios']),
        ...mapGetters(['getDientesByCuadrante']),  
        simbolos(){
            return _.sortBy(this.simbologias, 'id');
        },                 
    },  
    watch:{
        'dataTratamiento.simbologia_id' (newVal,oldVal){
            if(newVal != 1){
                this.multicaras =[]
            }
        }
    },  
    methods: {
        ShowDiente(params){
            console.log("seleccion multiple",this.select_multi)
            this.infodent = params
            if(this.select_multi){
                if(this.multipiezas.includes('t'+params.id)){
                    this.multipiezas.splice(this.multipiezas.indexOf('t'+params.id), 1)
                }else{
                    this.multipiezas.push('t'+params.id) 
                }  
            }else{
                this.LoadServices()
            }          
        },
        LoadServices(){
            this.dataTratamiento = {
                simbologia_id:'',
                letras:'',
                servicio_id:'',
                nombre_servicio:'',
                moneda_id:'',
                nombre_moneda:'',
                costo:''                
            }
            this.$modal.show('carga_servicios') 
        },
        cambiotratamiento(param){
            console.log('params',param)
            this.selected = param
        },
        selectServicio(row){
            let letras = ''
            console.log("servicio")            
            if(this.multicaras.includes(5)) letras += 'O'
            if(this.multicaras.includes(1)) letras += 'V'
            if(this.multicaras.includes(3)) letras += 'P'
            if(this.multicaras.includes(2)) letras += 'M'
            if(this.multicaras.includes(4)) letras += 'D'
            this.dataTratamiento.letras = this.infodent.codigo + '_' + letras
            this.dataTratamiento.servicio_id = row.id
            this.dataTratamiento.nombre_servicio = row.servicio.nombre_servicio
            this.dataTratamiento.costo = row.costo
            this.dataTratamiento.nombre_moneda = row.moneda.nombre_moneda
            this.$modal.hide('tratamientos');            
        },
        selectD(param){
            if(this.dataTratamiento.simbologia_id != 1) return
            if(this.multicaras.includes(param)){
                this.multicaras.splice(this.multicaras.indexOf(param), 1)
            }else{
                this.multicaras.push(param) 
            }          
            console.log("multicaras",this.multicaras)    
        },
        salirDiente(){
            this.multipiezas = []
            this.$modal.hide('carga_servicios')
        }     
    }
}
</script>
<style scoped>
    .desabilitado{
        fill:black;
        stroke:black;
        stroke-width:1px;
        opacity: 0.3;
    }
    .marcadoAzul
    {
        fill:none;
        stroke:blue;
        stroke-width:3px;
    }
    .marcadoCorona
    {
        cursor:pointer; 
        cursor: hand ;  
        fill:none;
        stroke:dimgrey;
        stroke-width:4px;        
    }
    .marcadoCoronaD
    {
        cursor:pointer; 
        cursor: hand ;  
        fill:none;
        stroke:red;
        stroke-width:8px;        
    }    
    .marcadoVerde
    {
        fill:green;
        stroke:black;
        stroke-width:1px;
    }
    .marcadoMorado
    {
        fill:#CC66CC;
        stroke:black;
        stroke-width:1px;
    }
    .marcadoMarron{
        fill:#CC6600;
        stroke:black;
        stroke-width:1px;
    }
    .marcadoAmarillo{
        fill:yellow;
        stroke:black;
        stroke-width:1px;
    }
    .marcadoRojo{
        fill:red;
        stroke:black;
        stroke-width:1px;
    }
    .marcadoNaranja{
        fill:orange;
        stroke:black;
        stroke-width:1px;
    }
    .marcadoTomate{
        fill:tomato;
        stroke:black;
        stroke-width:1px;
    }
    .marcadoEndodoncia, .marcadoExodoncia{
        cursor:pointer; 
        cursor: hand ;          
        fill:dimgrey;
        stroke:dimgrey;
        stroke-width:1px;        
    }
    .marcadoEndodonciaD, .marcadoExodonciaD{
        cursor:pointer; 
        cursor: hand ;          
        fill:red;
        stroke:red;
        stroke-width:1px;        
    }    
    .marcadoIonomero{
        cursor:pointer; 
        cursor: hand ;          
        stroke : dimgrey;
        fill-opacity : 0;
        stroke-width: 4px 
    }
    .marcadoIonomeroD{
        cursor:pointer; 
        cursor: hand ;          
        stroke : red;
        fill-opacity : 0;
        stroke-width: 8px 
    }    
    .marcadoSellante{
        cursor:pointer; 
        cursor: hand ;          
        font-weight: bold;
        fill : dimgrey;
        stroke : dimgrey;
        stroke-width: 2px;
        font-size : 2.5em;
    }
    .marcadoSellanteD{
        cursor:pointer; 
        cursor: hand ;          
        font-weight: bold;
        fill : red;
        stroke : red;
        font-size : 10em;
    }    
    .marcadoGeneral{
        cursor:pointer; 
        cursor: hand ;          
        fill:none;
        stroke:dimgrey;
        stroke-width:3px;        
    }
    .marcadoGeneralD{
        cursor:pointer; 
        cursor: hand ;          
        fill:none;
        stroke:red;
        stroke-width:8px;        
    }    
    .marcadoTextGeneral{
        cursor:pointer; 
        cursor: hand ;          
        fill : black;
        stroke : black;
        stroke-width: 1px;
        font-size : 0.7em;        
    }
    ._diente{
        cursor:pointer; 
        cursor: hand ;         
        fill-opacity:0;
        stroke:rgb(224, 219, 219);
        stroke-width:1px;
    }
    .diente{
        cursor:pointer; 
        cursor: hand ;         
        fill-opacity:0;
        stroke:dimgrey;
        stroke-width:1px;
    }    
    .ausente, .corona, .endodoncia, .implante, .ionomero, .sellante, .general, .exodoncia
    {
        fill:none;
        opacity: 0;
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
    .v--modal-overlay {
        z-index:9000;     
    }    
    .vld-overlay.is-full-page {
        z-index: 99999;
    }
    .trata_selected {
        border-top:2px solid red;
    }
    #tratamientos {
        z-index: 9999999;
    }
</style>


