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
                <div class="col-4">
                    <div class="form-group form-group-default" >
                        <label for="historia" class="text-primary font-weight-bold">Num. Historia </label>
                        <p class="form-control-static text-center mb-0" v-text="dataPaciente.historiaclinica"></p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group form-group-default" >
                        <label for="historia" class="text-primary font-weight-bold">T.C </label>
                        <p class="form-control-static mt-5 mb-0" v-text="dataPaciente.tipocambio"></p>
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
                        <select class="form-control mt-5" id="medicos" v-model="dataPresupuesto.empleado_id" @change.prevent="CambioMedico(dataPresupuesto.empleado_id)">
                            <option value="">-- Seleccione --</option>
                            <option v-for="med in MedicosOrtodoncias" :value="med.id" :key="med.id">
                                {{ med.nombre_completo}}
                            </option>
                        </select>                                
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group form-group-default" >
                        <label for="historia" class="text-primary font-weight-bold">Fecha </label>
                        <p class="form-control-static mt-5 mb-0" v-text="dataPaciente.fecha"></p>
                    </div>
                </div>                
            </div>
            <div class="row">
                <div class="col-12">
                    <p class="form-control-static text-danger font-weight-bold pt-20">DATOS DEL TRATAMIENTO</p>
                </div>
            </div>            
            <div class="row">
                <div class="col-8">
                    <div class="form-group form-group-default" >
                        <label for="tratamientos" class="text-primary font-weight-bold">TX de Ortodoncia <span class="required-label"> *</span></label>
                        <select class="form-control mt-5" id="tratamientos" v-model="dataPresupuesto.tarifario_id" @change.prevent="Cambiotarifario(dataPresupuesto.tarifario_id)">
                            <option value="">-- Seleccione --</option>
                            <option v-for="tra in TratamientosOrtodoncia" :value="tra.id" :key="tra.id">
                                {{ tra.servicio.nombre_servicio}}
                            </option>
                        </select>                                
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group form-group-default mb-5 pb-10" >
                        <label for="moneda" class="text-primary font-weight-bold">Moneda </label>
                        <p class="form-control-static mb-0" v-text="dataPresupuesto.moneda"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-4">
                    <div class="form-group form-group-default" >
                        <label for="cuota_inicial" class="text-primary font-weight-bold">Cuota Inicial <span class="required-label"> *</span></label>
                        <input type="text" class="form-control form-control-sm" name="cuota_inicial" v-model="dataPresupuesto.valor_cuota">
                    </div> 
                </div>
                <div class="col-4">
                    <div class="form-group form-group-default" >
                        <label for="control_mensual" class="text-primary font-weight-bold">Control Mensual <span class="required-label"> *</span></label>
                        <input type="text" class="form-control form-control-sm" name="control_mensual" v-model="dataPresupuesto.valor_control">
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group form-group-default" >
                        <label for="cuotas" class="text-primary font-weight-bold">Cuotas <span class="required-label"> *</span></label>
                        <input type="text" class="form-control form-control-sm" name="cuotas" v-model="dataPresupuesto.cuotas">
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group form-group-default" >
                        <label for="observaciones" class="text-primary font-weight-bold">Observaciones</label>
                        <textarea name="observaciones" id="observaciones" rows="5" v-model="dataPresupuesto.observaciones"></textarea>
                    </div>                    
                </div>
            </div> 
            <div class="row">
                <div class="col-12">
                    <p class="form-control-static text-danger font-weight-bold pt-20">SERVICIOS ADICIONALES</p>
                </div>
            </div>                       
            <div class="row">
                <div class="col-12">
                    <button type="button" class="btn btn-primary btn-sm float-right mb-10" @click.prevent="CargaTratamientos"><span class="btn-label"><i class="flaticon-add"></i></span> Agregar Servicio</button>
                </div> 
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-sm table-head-bg-info table-bordered-bd-info">
                        <thead>
                            <tr>
                                <th scope="col">#</th>
                                <th scope="col">Servicio</th>
                                <th scope="col">Moneda</th>    
                                <th scope="col" align="right">Costo</th> 
                                <th scope="col"></th>                                                                                                                         
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(serv, index) in lista_general_presupuesto" :key="serv.id">
                                <td width="5%" align="center">{{ index+1 }}</td>
                                <td width="60%">{{ serv.nombre_servicio}}</td>
                                <td width="15%">{{ serv.nombre_moneda}}</td>  
                                <td width="10%" align="right">{{ parseFloat(serv.costo).toFixed(2)}}</td> 
                                <td width="10%" align="center"><button type="button" v-tooltip="'Eliminar Item'" class="btn btn-danger btn-xs" @click.prevent="borrarItem(index)">
                                        <i class="la la-trash-o font-large"></i>
                                    </button>
                                    <button type="button" v-tooltip="'Descuento'" class="btn btn-success btn-xs" @click.prevent="AplicaDescuento(serv,index)">
                                        <i class="la la-calculator font-large"></i>
                                    </button>
                                </td>                                                                                                                        
                            </tr>
                            <tr v-if="lista_general_presupuesto.length == 0">
                                <td colspan="8" class="text-center">NO HAY SERVICIOS CARGADOS ...</td>                                           
                            </tr>
                        </tbody>
                    </table> 
                </div>                               
            </div>
            <div class="row">
                <div class="col-12 text-center">
                    <button type="button" class="btn btn-success btn-sm mb-10" @click.prevent="CrearDatosPpto" :disabled="lista_general_presupuesto.length == 0 || dataPresupuesto.empleado_id == '' || dataPresupuesto.tarifario_id == '' || dataPresupuesto.valor_cuota == '' || dataPresupuesto.valor_control == '' || dataPresupuesto.cuotas == ''"><span class="btn-label"><i class="flaticon-inbox"></i></span> Grabar Presupuesto</button>
                </div>            
            </div>            
        </div>
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
                        :rows="TratamientosAdicionales"
                        :paginationOptions="{
                            enabled: true,
                            dropdownAllowAll: false,
                            nextLabel: 'Sig',
                            prevLabel: 'Ant',
                            rowsPerPageLabel: 'Registros por Pagina',
                            ofLabel: 'de',
                            allLabel: 'Todos',
                        }"
                        @on-row-dblclick="selectServicio"
                        :rowStyleClass="'enlace'"
                        max-height="400px"
                        styleClass="vgt-table condensed bordered striped"> 
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'btn'" class="center">
                                <button type="button" data-toggle="tooltip" title="" class="btn btn-primary btn-xs" data-original-title="" @click.prevent="selectServicio(props)">
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
        <modal name="descuento" :width="'25%'" height="auto" transition="pop-out" :scrollable="true" :clickToClose="false" >
           <div class="card mb-0">
                <div class="card-header">
                    <div class="card-title">Aplicar Descuento</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-check form-check-inline pt-0 pb-0">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input" value="0" v-model="dataDescuento.tipo" @change="cambiaTipo">
                                    <label class="custom-control-label" for="customRadio1">Por Monto Fijo</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input" value="1" v-model="dataDescuento.tipo" @change="cambiaTipo">
                                    <label class="custom-control-label" for="customRadio2">Por Porcentaje</label>
                                </div>                             
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group pt-0 pb-0">
                                <label for="nombre" class="text-primary font-weight-bold">Monto Actual <span class="required-label"> *</span></label>
                                <input type="text" id="nombre" class="form-control form-control-sm border border-primary" v-model="dataDescuento.monto_actual">
                            </div> 
                        </div>                        
                    </div>
                    <div class="row" v-if="dataDescuento.tipo == 1">
                        <div class="col">
                            <div class="form-group pt-10 pb-0">
                                <label for="nombre" class="text-primary font-weight-bold">% descuento <span class="required-label"> *</span></label>
                                <input type="text" id="nombre" class="form-control form-control-sm border border-primary" v-model="dataDescuento.porcentaje">
                            </div> 
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group pt-10 pb-0">
                                <label for="nombre" class="text-primary font-weight-bold">Nuevo Monto <span class="required-label"> *</span></label>
                                <input type="text" id="nombre" class="form-control form-control-sm mayusculas border border-primary" v-model="dataDescuento.nuevo_monto" :disabled="dataDescuento.tipo == 1">
                            </div>  
                        </div>                       
                    </div>
                </div>
                <div class="card-action">
                    <button class="btn btn-primary" @click.prevent="ActionDescuento" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                    <button class="btn btn-danger" @click="$modal.hide('descuento')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                </div>                
            </div>                                
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
    name: 'ppto-ortodoncia',
    mixins: [mixin], 
    created(){      
        this.$store.dispatch('LOAD_EMPLEADOS_LIST')   
        this.$store.dispatch('LOAD_SERVICIOS_LIST')  
        this.$store.dispatch('LOAD_TIPOCAMBIOS_LIST')          
        this.dataPaciente = {
            id:this.PacienteById.id,
            nombre_completo:this.PacienteById.nombre_completo,
            historiaclinica:this.PacienteById.historiaclinica,
            empresa:this.PacienteById.pacienteplanes.tipo == 1 ? '-' : this.PacienteById.pacienteplanes.empresapaciente.razon_social,
            plan:this.PacienteById.pacienteplanes.plan.descripcion ,
            aseguradora:this.PacienteById.pacienteplanes.plan.descripcion ,
            empleado_id:'',
            fecha:moment().format('DD-MM-YYYY'),
            tipocambio:this.getTipoCambioHoy == undefined ? '-' : this.getTipoCambioHoy.tipo_cambio
        }        
    },
    data(){
        return {
            isLoading: false,
            fullPage: true,

            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos', 

            columns_servicios: [
                {
                label: 'Servicio',
                field: 'servicio.nombre_servicio',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },                
                width:'40%',
                }, 
                {
                label: 'Costo',
                field: 'costo', 
                type: 'decimal',            
                width:'8%',
                },
                {
                label: 'Moneda',
                field: 'moneda.nombre_moneda',
                width:'10%',
                },                 
                {
                label: 'Pago',
                field: 'plan.descripcion',                
                width:'27%',
                },                                                                                                                                                                                                                       
                {
                label: 'Acción',
                field: 'btn',
                thClass: 'center',
                tdClass: 'center',
                html: true  ,
                width:'15%',  
                }                               
            ],
            dataPresupuesto:{
                fecha_registro:'',
                paciente_id:'',
                empleado_id:'',
                nombre_empleado:'',
                codigo:'',
                cuotas:'',
                cuota_inicial:'',
                control_mensual:'',
                valor_cuota:'',     // contiene el valor de la cuota inicial para modificar con el tipo de cambio
                valor_control:'',   // contiene el valor del control mensual para modificar con el tipo de cambio
                descuento:'',                
                observaciones:'',
                tipocambio_id:'',
                estadopresupuesto_id:'',
                moneda:'.',
                moneda_id:'',
                total_dolares:'',
                total_soles:'',  
                total:'',
                sede_id:'',
                estado_seguimiento:'',
                cuota_inicial_base:'',
                control_mensual_base:'',
                user_id:'',
                saldo:'',
                tarifario_id:'',
                nombre_servicio:'',
                cuota_inicial_dolares:'',
                control_mensual_dolares:'', 
                cuota_inicial_base_dolares:'',
                control_mensual_base_dolares:'',                                
                detalle:[]
            },
            dataDetallePresupuesto:{
                tarifario_id:'',
                moneda_id:'',
                costo:'',
                costo_base:'',
                descuento:'',
                tipoplan:'',
                empleado_id:'',
                realizado:'',
                descargado:'',
                pagado:'',
                tipo_pagado:'',
                adicional:'',
                laboratorio_id:'',
                monto_lab:'',
                material_id:'',
                monto_mat:'',
                user_id:'',
                numero_cuota:'',
                descripcion:''
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
            dataTratamiento:{
                tarifario_id:'',
                servicio_id : '',
                nombre_servicio : '',
                costo_base:'',
                costo : '',
                moneda_id:'',
                nombre_moneda : '',
                descuento:'',
                adicional:1
            },
            dataDescuento:{
                tipo:'0',
                monto_actual:'',
                porcentaje:'',
                nuevo_monto:'',
                descuento:''
            },
            lista_general_presupuesto:[],   // listado general del presupuesto            
        }
    },
    computed:{
        ...mapState(['user_system','tarifarios','servicios']),
        ...mapGetters([,'getPacienteById','getMedicos','getTratamientosOrtodoncia','getTipoCambioHoy','getPresupuestoOrtodonciaById']), 
        PacienteById(){
            return this.getPacienteById(this.$route.params.idpaciente)
        }, 
        MedicosOrtodoncias(){
            let med = []
            this.getMedicos.map(function(value, key){
                value.especialidades.map(function(value2,key2){
                    if(value2.pivot.especialidade_id == 6){
                        med.push(value)
                    }
                })
            }) 
            return med                       
        },
        TratamientosOrtodoncia(){
            return this.getTratamientosOrtodoncia(this.PacienteById.pacienteplanes.plan_id,1)
        },   
        TratamientosAdicionales(){
            return this.tarifarios.filter(tar => tar.plan_id == this.PacienteById.pacienteplanes.plan_id && tar.sede_id == 1)
        },              
        presupuestoOrtodonciaById(){
            if(this.$route.params.idpresupuesto != undefined){
                return this.getPresupuestoOrtodonciaById(this.$route.params.idpresupuesto)                 
            }
            return []        
        }                 

    },
    watch:{
        'dataDescuento.porcentaje' (newVal,oldVal){
            if(newVal != 0){
                this.dataDescuento.nuevo_monto = this.dataDescuento.monto_actual * ( 1 - (this.dataDescuento.porcentaje / 100))
            }else{
                this.dataDescuento.nuevo_monto = ''
            }
        }       
    },    
    methods:{
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },           
        Cambiotarifario(param){
            let tarifa = this.tarifarios.find(tar => tar.id == param)
            this.dataPresupuesto.nombre_servicio = tarifa.servicio.nombre_servicio
            this.dataPresupuesto.moneda = tarifa.moneda.nombre_moneda
            this.dataPresupuesto.moneda_id = tarifa.moneda_id
            this.dataPresupuesto.valor_control = parseFloat(tarifa.control_mensual).toFixed(2)
            this.dataPresupuesto.valor_cuota = parseFloat(tarifa.cuota_inicial).toFixed(2) 
            if(tarifa.moneda_id == 2){
                this.dataPresupuesto.cuota_inicial_base_dolares = parseFloat(tarifa.cuota_inicial).toFixed(2)
                this.dataPresupuesto.control_mensual_base_dolares =  parseFloat(tarifa.control_mensual).toFixed(2)              
                this.dataPresupuesto.cuota_inicial_base = (parseFloat(tarifa.cuota_inicial) * parseFloat(this.getTipoCambioHoy.tipo_cambio)).toFixed(2) 
                this.dataPresupuesto.control_mensual_base =  (parseFloat(tarifa.control_mensual) * parseFloat(this.getTipoCambioHoy.tipo_cambio)).toFixed(2)              

            }else{
                this.dataPresupuesto.cuota_inicial_base = parseFloat(tarifa.cuota_inicial).toFixed(2)
                this.dataPresupuesto.control_mensual_base =  parseFloat(tarifa.control_mensual).toFixed(2)              
                this.dataPresupuesto.cuota_inicial_base_dolares = (parseFloat(tarifa.cuota_inicial) / parseFloat(this.getTipoCambioHoy.tipo_cambio)).toFixed(2) 
                this.dataPresupuesto.control_mensual_base_dolares =  (parseFloat(tarifa.control_mensual) / parseFloat(this.getTipoCambioHoy.tipo_cambio)).toFixed(2)              
            }                     
        },
        CambioMedico(param){
            let medico = this.getMedicos.find(med => med.id == param)
            this.dataPresupuesto.nombre_empleado = medico.nombre_completo
        },
        CargaTratamientos(){
            this.$modal.show('tratamientos')            
        },
        selectServicio(param){   
            let self = this
            let encontrado = false
            this.lista_general_presupuesto.map(function(value, key){
                if(value.tarifario_id == param.row.id){  
                    self.$modal.hide('tratamientos');                   
                    self.notificaciones('El servicio seleccionado ya se encuentra en la lista general','la la-thumbs-o-down','danger')                
                    encontrado = true
                    return
                }
            })  
            if(!encontrado){
                this.dataTratamiento = {
                    tarifario_id:param.row.id,
                    servicio_id : param.row.servicio_id,
                    nombre_servicio : param.row.servicio.nombre_servicio,
                    costo_base: param.row.costo,
                    costo : param.row.costo,
                    moneda_id:param.row.moneda.id,
                    nombre_moneda : param.row.moneda.nombre_moneda,
                    descuento:''
                }  
                if(param.row.moneda.id == 2){
                    let costo_soles = (this.dataTratamiento.costo) * (this.getTipoCambioHoy.tipo_cambio) 
                    this.dataTratamiento.costo = parseFloat(costo_soles).toFixed(2)
                    this.dataTratamiento.costo_base = parseFloat(costo_soles).toFixed(2)
                    this.dataTratamiento.moneda_id = 1
                    this.dataTratamiento.moneda = 'SOLES'
                }              
                this.lista_general_presupuesto.push(this.dataTratamiento)          // nuevos servicios
                this.$modal.hide('tratamientos'); 
            }           
           
        },
        CrearDatosPpto(){
            let self = this              
            this.dataPresupuesto.fecha_registro = moment().format('DD-MM-YYYY')
            this.dataPresupuesto.paciente_id = this.PacienteById.id
            //this.dataPresupuesto.empleado_id = this.PacienteById.empleado_id                     
            this.dataPresupuesto.descuento = ''
            this.dataPresupuesto.tipocambio_id = this.getTipoCambioHoy.id
            this.dataPresupuesto.estadopresupuesto_id = 1
            this.dataPresupuesto.moneda_id = 1 
            this.dataPresupuesto.total = ''
            this.dataPresupuesto.sede_id = 1
            this.dataPresupuesto.estado_seguimiento = 1
            this.dataPresupuesto.user_id = this.user_system.id
            this.dataPresupuesto.saldo = 0
            this.dataPresupuesto.detalle = []
            if(this.dataPresupuesto.moneda_id == 2){
                this.dataPresupuesto.cuota_inicial_dolares = parseFloat(this.dataPresupuesto.valor_cuota).toFixed(2)
                this.dataPresupuesto.control_mensual_dolares = parseFloat(this.dataPresupuesto.valor_control).toFixed(2)                
                this.dataPresupuesto.cuota_inicial = (parseFloat(this.dataPresupuesto.valor_cuota) * parseFloat(this.getTipoCambioHoy.tipo_cambio)).toFixed(2)
                this.dataPresupuesto.control_mensual = (parseFloat(this.dataPresupuesto.valor_control) * parseFloat(this.getTipoCambioHoy.tipo_cambio)).toFixed(2)                 
            }else{
                this.dataPresupuesto.cuota_inicial_dolares = (parseFloat(this.dataPresupuesto.valor_cuota) / parseFloat(this.getTipoCambioHoy.tipo_cambio)).toFixed(2)
                this.dataPresupuesto.control_mensual_dolares = (parseFloat(this.dataPresupuesto.valor_control) / parseFloat(this.getTipoCambioHoy.tipo_cambio)).toFixed(2)              
                this.dataPresupuesto.cuota_inicial = parseFloat(this.dataPresupuesto.valor_cuota).toFixed(2) 
                this.dataPresupuesto.control_mensual = parseFloat(this.dataPresupuesto.valor_control).toFixed(2)                
            }
            
            this.lista_general_presupuesto.map(function(value, key) {
                let detpre = _.clone(self.dataDetallePresupuesto)
                detpre = {
                    tarifario_id:value.tarifario_id,
                    tipoplan:1,
                    moneda_id:value.moneda_id,
                    costo:value.costo,
                    costo_base:value.costo_base,
                    descuento:value.descuento,
                    empleado_id:self.dataPresupuesto.empleado_id,
                    realizado:1,
                    descargado:0,
                    pagado:0,
                    tipo_pagado:'',
                    adicional:1,
                    laboratorio_id:'',
                    monto_lab:'',
                    material_id:'',
                    monto_mat:'',
                    user_id:self.user_system.id,
                    numero_cuota:'',
                    descripcion:value.nombre_servicio
                }               
                self.dataPresupuesto.detalle.push(detpre)
            })

            let costoTotal = 0
            let costoser = 0
            costoTotal = (parseFloat(this.dataPresupuesto.control_mensual) * parseFloat(this.dataPresupuesto.cuotas)) + parseFloat(this.dataPresupuesto.cuota_inicial)
            this.lista_general_presupuesto.map(function(value, key){
                costoser += parseFloat(value.costo)
            })
            costoTotal += parseFloat(costoser)
            this.dataPresupuesto.total_dolares = (parseFloat(costoTotal) / parseFloat(this.getTipoCambioHoy.tipo_cambio)).toFixed(2)
            this.dataPresupuesto.total_soles = costoTotal.toFixed(2)                  

            this.createPresupuesto()
            //this.createPDF()     
        },
        createPresupuesto(){
            var url = '/api/presupuestos-ortodoncias';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataPresupuesto).then(response => {
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
            this.$store.dispatch('LOAD_PRESUPUESTOS_ORTODONCIAS_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')              
            this.notificaciones('Nuevo Presupuesto creado con exito','la la-thumbs-up','success')  
            this.$swal({
                title: 'Desea Imprimir este presupuesto?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, imprimir!'
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true
                        this.createPDF()
                    }else{
                        this.$router.push({ name: 'lista-ppto-ortodoncia' }) 
                    }
            });                       
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')           
            });
        },
        createPDF(){
            let total_cuotas = (parseFloat(this.dataPresupuesto.control_mensual) * parseFloat(this.dataPresupuesto.cuotas)).toFixed(2)
            var doc = new jsPDF();
            var img = new Image()
            img.src = '/img/logo/multident.png'
            doc.addImage(img, 'png', 150, 10, 45, 5)                    
            doc.setFontSize(12)
            doc.setFont("helvetica")
            doc.setFontType("bold")
            doc.text(60,25,"PRESUPUESTO DE ORTODONCIA Nº 1265")
            doc.setFontSize(9) 
            doc.setFontType("normal")                               
            doc.text(10,35,'Historia Clinica :')
            doc.setFontType("bold")  
            doc.text(40,35, this.dataPaciente.historiaclinica.toString()) 
            doc.setFontType("normal")              
            doc.text(150,35, 'Fecha:')
            doc.setFontType("bold")                     
            doc.text(165,35, this.dataPresupuesto.fecha_registro) 
            doc.setFontType("normal")                                    
            doc.text(10,40,'Paciente:')
            doc.setFontType("bold") 
            doc.text(40,40, this.dataPaciente.nombre_completo )
            doc.setFontType("normal")                     
            doc.text(10,45,'Doctor:')
            doc.setFontType("bold")                     
            doc.text(40,45, this.dataPresupuesto.nombre_empleado) 
            doc.setFontSize(8)
            doc.setFontType("normal") 
            doc.text(10,50,'TX de Ortodoncia:')
            doc.setFontType("bold")            
            doc.text(40,50, this.dataPresupuesto.nombre_servicio)                                        
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
            doc.text(180,83, this.dataPresupuesto.cuota_inicial,'right')   
            doc.text(200,83, this.dataPresupuesto.cuota_inicial,'right') 
            doc.line(8,85 , 205,85) 
            doc.text(14,89,this.dataPresupuesto.cuotas,'center')
            doc.text(30,89,'CONTROL MENSUAL')   
            doc.text(180,89, this.dataPresupuesto.control_mensual,'right')   
            doc.text(200,89, total_cuotas,'right')  
            doc.line(8,91 , 205,91)                                                
            let y = 89
            let y2
            this.lista_general_presupuesto.map(function(value, key) {
                y += 6
                doc.text(14,y , '1' ,'center')
                doc.text(30,y,value.nombre_servicio)
                doc.text(180,y,parseFloat(value.costo).toFixed(2),'right')
                doc.text(200,y,parseFloat(value.costo).toFixed(2),'right')
                y2 = y + 2
                doc.line(8,y2 , 205,y2)
            }) 
            doc.line(8,67 ,8,y2)
            doc.line(25,73, 25,y2)
            doc.line(165,73 , 165,y2)
            doc.line(185,67 ,185,y2)
            doc.line(205,67 , 205,y2)
            y2 += 10
            doc.text(10,y2,'Observaciones')
            y2 += 5
            doc.text(25,y2, this.dataPresupuesto.observaciones)
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
            this.$router.push({ name: 'lista-ppto-ortodoncia' }) 
        },
        AplicaDescuento(param,index){
            this.dataDescuento = {
                index:index,
                tipo:'0',
                monto_actual:param.costo,
                porcentaje:'',
                nuevo_monto:''
            },
            this.$modal.show('descuento')
        },
        ActionDescuento(){             
            let desc = parseFloat(this.dataDescuento.monto_actual) - parseFloat(this.dataDescuento.nuevo_monto)
            this.lista_general_presupuesto[this.dataDescuento.index].descuento = parseFloat(desc).toFixed(2)
            this.lista_general_presupuesto[this.dataDescuento.index].costo = this.dataDescuento.nuevo_monto
            this.$modal.hide('descuento')
        }, 
        cambiaTipo(){
            this.dataDescuento.nuevo_monto = ''
            this.dataDescuento.porcentaje = ''
        },
        borrarItem(index){
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
                        let self = this
                        this.$delete(self.lista_general_presupuesto , index) 
                    }
                });              
        },                                        
    },
    
}
</script>
<style scoped>
    .v--modal-overlay {
        z-index:9000;     
    }      
    .vld-overlay.is-full-page {
        z-index: 99999;
    }
    #observaciones {
        width: 100% !important;
    }
    .table-sm th,
    .table-sm td {
        padding: 0.3rem !important; 
        font-size: 11px !important;
    } 
    .btn-xs {
        padding: 2px !important;
    } 

</style>