<template>
    <div class="content">
        <loading :active.sync="isLoading"
            :background-color="'#000'" 
            :color="'red'"
            :can-cancel="false" 
            :is-full-page="fullPage">
        </loading>         
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header pb-0">
                            <div class="row">
                                <div class="col-12">
                                    <p-radio v-for="tip in tipoAgenda" class="p-icon p-curve p-tada" :key="tip.id" :value="tip.id" name="radio77" color="primary-o" v-model="dataTipoAgenda.tipo" @change="cambioTipoAgenda(tip.id)" :disabled="$route.params.idpresupuesto != undefined">
                                        <i slot="extra" class="icon la la-check"></i><label class="text-primary font-weight-bold float-left">{{ tip.nombre_tipo }} </label>                              
                                    </p-radio>                                      
                                </div>
                            </div>
                            <div class="row" v-if="dataTipoAgenda.tipo == 2">
                                <div class="col-4"> 
									<div class="form-group form-floating-label">
										<select ref="especialidades" class="form-control input-border-bottom" id="selectEspecialidades" v-model="dataCita.especialidade_id" @change="cambioEspecialidad" required>
                                            <option value="0">--Todas--</option>
                                            <option v-for="esp in especialidades" :value="esp.id" :key="esp.id">
                                                {{ esp.nombre_especialidad}}
                                            </option>
										</select>
										<label for="selectEspecialidades" class="placeholder">Especialidades</label>
									</div>
                                </div>
                                <div class="col-4">  
									<div class="form-group form-floating-label">
										<select class="form-control input-border-bottom" id="selectMedicos" v-model="dataCita.empleado_id" @change="cambioMedico" required>
                                            <option value="0">--Todos--</option>
                                            <option v-for="med in medicos_especialidad" :value="med.id" :key="med.id">
                                                {{ med.nombre_completo}}
                                            </option>                                            
										</select>
										<label for="selectMedicos" class="placeholder">Médicos</label>
									</div>                                                                                                           
                                </div>
                                <div class="col-4">
                                    <div class="form-group" v-if="ViewReprogramar">
                                        <button type="button" class="btn btn-sm btn-danger float-right"><span class="btn-label"><i class="la la-remove"></i> Cancelar Reprogramacion</span></button>
                                    </div>
                                </div>                               
                            </div>
                        </div>
                        <div class="card-body" oncontextmenu="return false">                          
                            <full-calendar ref="calendar" :events="events" :config="config" @event-selected="eventSelected" @day-click="dayclick" @event-created="createEvent" @event-drop="eventDrop" @event-render="eventRender" @view-render="viewRender" @event-mouseover="eventMouseover" @event-drag-start="eventDragStart" @event-drag-stop="eventDragStop" @event-resize="eventResize"></full-calendar>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <modal name="cita_nueva" :width="'40%'" height="auto" transition="pop-out" :scrollable="true" :clickToClose="false" >
           <div class="card mb-0">
                <div class="card-header bg-primary pt-10 pb-10">
                    <div class="card-title d-inline text-white">Nueva Cita</div>
                    <button type="button" class="close d-inline text-white" aria-label="Close" @click.prevent="$modal.hide('cita_nueva')">
                        <span aria-hidden="true">&times;</span>
                    </button>                      
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <label for="label" class="d-inline font-weight-bold">Tipo</label>
                            <div class="form-check form-check-inline pt-0 pb-0">
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio1" name="customRadio" class="custom-control-input" value="1" v-model="dataCita.tipo" @change="dataCita.paciente_id = ''">
                                    <label class="custom-control-label" for="customRadio1">Paciente Existente</label>
                                </div>
                                <div class="custom-control custom-radio">
                                    <input type="radio" id="customRadio2" name="customRadio" class="custom-control-input" value="2" v-model="dataCita.tipo">
                                    <label class="custom-control-label" for="customRadio2">Paciente Nuevo</label>
                                </div>                             
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group pt-0 pb-0 pl-0">
                                <label for="nombre" class="d-inline font-weight-bold">Odontólogo : </label>
                                <p class="d-inline form-control-static mt-5 mb-0" v-text="dataCita.empleado"></p>                            
                            </div> 
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group pt-10 pb-0 pl-0">
                                <label for="nombre" class="d-inline font-weight-bold">Fecha Cita : </label>
                                <p class="d-inline form-control-static mt-5 mb-0" v-text="dataCita.fecha_cita"></p>
                                <label for="nombre" class="d-inline font-weight-bold"> | Hora Cita : </label> 
                                <p class="d-inline form-control-static mt-5 mb-0" v-text="'Desde ' + dataCita.start"></p>
                                <p class="d-inline form-control-static mt-5 mb-0" v-text="'Hasta ' + dataCita.end"></p>                                                             
                            </div> 
                        </div>                        
                    </div>
                    <div v-if="dataCita.tipo == 1">
                        <div class="row">
                            <div class="col-12">
                                <div class="group-form">
                                    <div class="input-group pt-20">
                                        <input type="text" class="form-control form-control-sm" placeholder="Paciente" aria-label="Recipient's username" aria-describedby="button-addon2" v-model="dataCita.paciente" readonly>
                                        <div class="input-group-append">
                                            <button class="btn btn-primary btn-xs mr-5" type="button" id="button-addon2" @click.prevent="$modal.show('pacientes')"><i class="la la-search-plus la-2x"></i></button>
                                        </div>
                                    </div>                                              
                                </div>                            
                            </div>
                        </div>  
                        <div class="row">
                            <div class="col-5">
                                <div class="group-form pt-10">
                                    <label for="celular" class="font-weight-bold">Celular:</label>
                                    <div class="input-group pt-10">
                                        <input type="text" class="form-control form-control-sm" aria-label="Recipient's username" aria-describedby="button-addon3" maxlength="9" v-model="dataCita.celular">
                                        <div class="input-group-append">
                                            <button class="btn btn-success btn-xs mr-5" type="button" id="button-addon3" @click.prevent="actualizaCelular" v-tooltip="'Actualiza Celular del Paciente'" :disabled="dataCita.celular.length == 0"><i :class="[IconClassCel]"></i></button>
                                        </div>
                                    </div>                                              
                                </div>                                
                            </div>
                        </div>                        
                    </div> 
                    <div v-if="dataCita.tipo == 2">
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group pr-0 pl-0">
                                    <label for="documento" class="font-weight-bold">Tipo Documento: <span class="required-label"> *</span></label>
                                    <div class="select2-input">
                                        <select id="documento" name="documento" class="form-control form-control-sm" v-model="dataNewPaciente.tipodocumento_id">
                                            <option value="">--seleccione--</option>
                                            <option v-for="doc in getDocumentosIdentidad" :value="doc.id" :key="doc.id">
                                                {{ doc.nombre_tipodocumento}}
                                            </option>
                                        </select>
                                    </div>                                          
                                </div>                                 
                            </div>
                            <div class="col-6">
                                <div class="form-group pl-0 pr-0">
                                    <label for="dni" class="font-weight-bold">Nro. Documento: <span class="required-label"> *</span></label>
                                    <input type="text" id="dni" class="form-control form-control-sm" v-model="dataNewPaciente.numero_documento" maxlength="8">
                                </div>                                  
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group pl-0 pr-0 pt-0">
                                    <label for="ape_paterno" class="font-weight-bold">Apellido Paterno: <span class="required-label"> *</span></label>
                                    <input type="text" id="ape_paterno" class="form-control form-control-sm mayusculas" v-model="dataNewPaciente.apellido_paterno">
                                </div>                                 
                            </div>
                            <div class="col-6">
                                <div class="form-group pl-0 pr-0 pt-0">
                                    <label for="ape_materno" class="font-weight-bold">Apellido Materno: <span class="required-label"> *</span></label>
                                    <input type="text" id="ape_materno" class="form-control form-control-sm mayusculas" v-model="dataNewPaciente.apellido_materno">
                                </div>                                 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6">
                                <div class="form-group pl-0 pr-0 pt-0">
                                    <label for="nombres" class="font-weight-bold">Nombres: <span class="required-label"> *</span></label>
                                    <input type="text" id="nombres" class="form-control form-control-sm mayusculas" v-model="dataNewPaciente.nombres">
                                </div>                                 
                            </div>
                            <div class="col-6">
                                <div class="form-group pl-0 pr-0 pt-0">
                                    <label for="new_celular" class="font-weight-bold">Nro. Celular: <span class="required-label"> *</span></label>
                                    <input type="text" id="new_celular" class="form-control form-control-sm" v-model="dataNewPaciente.celular" maxlength="9">
                                </div>                                 
                            </div>
                        </div>
                        <div class="row">
                            <div class="col">
                                <label for="label" class="d-inline font-weight-bold">Sexo</label>
                                <div class="form-check form-check-inline pt-0 pb-0">
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customHombre" name="customSexo" class="custom-control-input" value="H" v-model="dataNewPaciente.sexo" required>
                                        <label class="custom-control-label" for="customHombre">Hombre</label>
                                    </div>
                                    <div class="custom-control custom-radio">
                                        <input type="radio" id="customMujer" name="customSexo" class="custom-control-input" value="M" v-model="dataNewPaciente.sexo" required>
                                        <label class="custom-control-label" for="customMujer">Mujer</label>
                                    </div>                             
                                </div>
                            </div>
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group pl-0 pr-0 pt-10" >
                                <label for="comentario" class="font-weight-bold">Comentario: </label>
                                <textarea name="comentario" id="comentario" rows="4" v-model="dataCita.comentario"></textarea>
                            </div>                             
                        </div>
                    </div>                                    
                </div>
                <div class="card-action pt-15 pb-15 pr-20">
                    <button class="btn btn-danger float-right ml-10" @click="$modal.hide('cita_nueva')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    <button class="btn btn-primary float-right" @click.prevent="createCita" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                </div>                
            </div>                                
        </modal> 
        <modal name="datos_cita" :width="'40%'" height="auto" transition="pop-out" :scrollable="true" :clickToClose="false" >
           <div class="card mb-0">
                <div class="card-header pt-10 pb-10">
                    <div class="card-title">Datos de la Cita</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group pt-0 pb-0 pl-0">
                                <label for="paciente" class="d-inline font-weight-bold">Paciente : </label>
                                <p class="d-inline form-control-static mt-5 mb-0" v-text="dataCita.paciente"></p>                            
                            </div> 
                        </div>                        
                    </div> 
                    <div class="row">
                        <div class="col">
                            <div class="form-group pt-0 pb-0 pl-0">
                                <label for="celular" class="d-inline font-weight-bold">Celular : </label>
                                <p class="d-inline form-control-static mt-5 mb-0" v-text="dataCita.celular"></p>                            
                            </div> 
                        </div>                        
                    </div>                                       
                    <div class="row">
                        <div class="col">
                            <div class="form-group pt-0 pb-0 pl-0">
                                <label for="empleado" class="d-inline font-weight-bold">Odontólogo : </label>
                                <p class="d-inline form-control-static mt-5 mb-0" v-text="dataCita.empleado"></p>                            
                            </div> 
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group pt-10 pb-0 pl-0">
                                <label for="nombre" class="d-inline font-weight-bold">Fecha Cita : </label>
                                <p class="d-inline form-control-static mt-5 mb-0" v-text="dataCita.fecha_cita"></p>
                                <label for="nombre" class="d-inline font-weight-bold"> | Hora Cita : </label> 
                                <p class="d-inline form-control-static mt-5 mb-0" v-text="'Desde ' + dataCita.start"></p>
                                <p class="d-inline form-control-static mt-5 mb-0" v-text="'Hasta ' + dataCita.end"></p>                                                             
                            </div> 
                        </div>                        
                    </div>  
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group pl-0 pr-0 pt-10" >
                                <label for="comentario" class="font-weight-bold">Comentario: </label>
                                <textarea name="comentario" id="comentario" rows="4" v-model="dataCita.comentario" disabled></textarea>
                            </div>                             
                        </div>
                    </div>                                    
                </div>
                <div class="card-action pt-15 pb-15">
                    <button class="btn btn-warning float-right" @click="$modal.hide('datos_cita')"><span class="btn-label"><i class="la la-times-circle"></i> Salir</span></button>
                </div>                
            </div>                                
        </modal>         
        <modal id="pacientes" name="pacientes" width="60%" height="auto" :scrollable="true" :clickToClose="false">
            <div class="card mb-0">
                <div class="card-header">
                    <div class="card-title d-inline">Seleccione el Paciente</div>
                    <button type="button" class="close d-inline" aria-label="Close" @click.prevent="$modal.hide('pacientes')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                     <div class="col">
                        <!-- START DEFAULT DATATABLE -->
                        <vue-good-table
                        :columns="columns_pacientes"
                        :rows="pacientes"
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
                        @on-row-click="selectPaciente"
                        max-height="400px"
                        styleClass="vgt-table condensed bordered striped"> 
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'btn'" class="center">
                                <button type="button" data-toggle="tooltip" title="" class="btn btn-primary btn-xs" data-original-title="Seleccionar" @click.prevent="selectPaciente(props)">
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
        <modal name="reprogramacion" :width="'30%'" height="auto" transition="pop-out" :scrollable="true" :clickToClose="false" >
           <div class="card mb-0">
                <div class="card-header pt-10 pb-10">
                    <div class="card-title">Reprogramando la Cita</div>
                </div>
                <div class="card-body pt-10">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group pl-0 pr-0 pt-0 pb-0" >
                                <label for="comentario_reprog" class="font-weight-bold">Motivo / Comentario: </label>
                                <textarea name="comentario" id="comentario_reprog" rows="3" v-model="dataReprCita.comentario" required></textarea>
                            </div>                             
                        </div>
                    </div>                                   
                </div>
                <div class="card-action pt-15 pb-15 pr-15">
                    <button class="btn btn-primary float-right ml-10" @click.prevent="reprogramarCita" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                    <button class="btn btn-warning float-right" @click="cancelReprogramacion"><span class="btn-label"><i class="la la-times-circle"></i> Salir</span></button>
                </div>                
            </div>                                
        </modal> 
        <modal name="reprogramacion-manual" :width="'50%'" height="auto" transition="pop-out" :scrollable="true" :clickToClose="false" >
           <div class="card mb-0">
                <div class="card-header pt-10 pb-10">
                    <div class="card-title">Reprogramación de la Cita</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col">
                            <div class="form-group pt-0 pb-0 pl-0">
                                <label for="paciente" class="d-inline font-weight-bold">Paciente : </label>
                                <p class="d-inline form-control-static mt-5 mb-0" v-text="dataReprCitaManual.paciente"></p>                            
                            </div> 
                        </div>                        
                    </div> 
                    <div class="row">
                        <div class="col">
                            <div class="form-group pt-0 pb-0 pl-0">
                                <label for="celular" class="d-inline font-weight-bold">Celular : </label>
                                <p class="d-inline form-control-static mt-5 mb-0" v-text="dataReprCitaManual.celular"></p>                            
                            </div> 
                        </div>                        
                    </div>                                       
                    <div class="row">
                        <div class="col">
                            <div class="form-group pt-0 pb-0 pl-0">
                                <label for="empleado" class="d-inline font-weight-bold">Odontólogo : </label>
                                <p class="d-inline form-control-static mt-5 mb-0" v-text="dataReprCitaManual.empleado"></p>                            
                            </div> 
                        </div>                        
                    </div>
                    <div class="row">
                        <div class="col">
                            <div class="form-group pt-10 pb-0 pl-0">
                                <label for="nombre" class="d-inline text-danger font-weight-bold">Fecha Cita Anterior : </label>
                                <p class="d-inline form-control-static mt-5 mb-0" v-text="dataReprCitaManual.fecha_anterior"></p>
                                <label for="nombre" class="d-inline text-danger font-weight-bold"> | Hora Cita : </label> 
                                <p class="d-inline form-control-static mt-5 mb-0" v-text="'Desde ' + dataReprCitaManual.start_anterior"></p>
                                <p class="d-inline form-control-static mt-5 mb-0" v-text="'Hasta ' + dataReprCitaManual.end_anterior"></p>                                                             
                            </div> 
                        </div>                        
                    </div>  
                    <div class="row">
                        <div class="col">
                            <div class="form-group pt-10 pb-0 pl-0">
                                <label for="nombre" class="d-inline text-success font-weight-bold">Fecha Cita Nueva : </label>
                                <p class="d-inline form-control-static mt-5 mb-0" v-text="dataReprCitaManual.fecha_nueva"></p>
                                <label for="nombre" class="d-inline text-success font-weight-bold"> | Hora Cita : </label> 
                                <p class="d-inline form-control-static mt-5 mb-0" v-text="'Desde ' + dataReprCitaManual.start_nueva"></p>
                                <p class="d-inline form-control-static mt-5 mb-0" v-text="'Hasta ' + dataReprCitaManual.end_nueva"></p>                                                             
                            </div> 
                        </div>                        
                    </div>                    
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group pl-0 pr-0 pt-10" >
                                <label for="comentario" class="font-weight-bold">Motivo : </label>
                                <textarea name="comentario" id="comentario" rows="4" v-model="dataReprCitaManual.comentario"></textarea>
                            </div>                             
                        </div>
                    </div>                                    
                </div>
                <div class="card-action pt-15 pb-15">
                    <button class="btn btn-primary float-right ml-10" @click.prevent="grabareprogramarCitaManual" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                    <button class="btn btn-warning float-right" @click="cancelReprogramacionManual"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                </div>                
            </div>                                                               
        </modal>         
        <modal name="modificacion" :width="'30%'" height="auto" transition="pop-out" :scrollable="true" :clickToClose="false" >
           <div class="card mb-0">
                <div class="card-header pt-10 pb-10">
                    <div class="card-title">Modificación de la Cita</div>
                </div>
                <div class="card-body pt-10">
                    <div class="row">
                        <div class="col-12">
                            <div class="form-group pl-0 pr-0 pt-0 pb-0" >
                                <label for="comentario_reprog" class="font-weight-bold">Motivo / Comentario: </label>
                                <textarea name="comentario" id="comentario_reprog" rows="3" v-model="dataReprCita.comentario" required></textarea>
                            </div>                             
                        </div>
                    </div>                                   
                </div>
                <div class="card-action pt-15 pb-15 pr-15">
                    <button class="btn btn-primary float-right ml-10" @click.prevent="modificarCita" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                    <button class="btn btn-warning float-right" @click="cancelModificacion"><span class="btn-label"><i class="la la-times-circle"></i> Salir</span></button>
                </div>                
            </div>                                
        </modal>        
        <context-menu id="context-menu" ref="ctxMenu">
            <li class="ctx-item disabled" value="1" ><span class="circle_estado bg-primary"></span>Citado</li>
            <li class="ctx-item" value="2" :class="classState(2)" @click.prevent="cambioEstado(2)"><span class="circle_estado bg-secondary"></span>En sala de espera</li>
            <li class="ctx-item" value="3" :class="classState(3)" @click.prevent="cambioEstado(3)"><span class="circle_estado bg-default"></span>En consultorio</li>
            <li class="ctx-item border-bottom" value="4" :class="classState(4)" @click.prevent="cambioEstado(4)"><span class="circle_estado bg-success"></span>Atendido</li>
            <li class="ctx-item border-bottom" value="5" :class="classState(5)" @click.prevent="reprogramarCitaManual(selectItem)"><span class="circle_estado bg-warning"></span>Reprogramar</li>
            <li class="ctx-item" value="6" :class="classState(6)"  @click.prevent="cambioEstado(5)"><span class="circle_estado bg-danger"></span>Cancelar cita</li>
            <li class="ctx-item" value="7"  @click.prevent="confirmarCita(selectItem)" v-if="!selectItem.confirmado"><span class="circle_estado bg-info"></span>Confirmar cita</li>
        </context-menu>                
    </div>
</template>
<script>
import mixin from '../../mixins.js'
import  {_} from 'vue-underscore'
import { mapState, mapGetters } from 'vuex'
import 'fullcalendar/dist/locale/es'
export default {
    name: 'citas',
    mixins: [mixin],
    created(){
        this.$store.dispatch('LOAD_TURNOS_LIST')
        this.$store.dispatch('LOAD_TURNOS_ESPECIALES_LIST')
        this.$store.dispatch('LOAD_PERMISOS_LIST')
        this.$store.dispatch('LOAD_EMPLEADOS_LIST')
        this.$store.dispatch('LOAD_PACIENTES_LIST')
        this.$store.dispatch('LOAD_DATA_INIT_LIST')  
        window.addEventListener('scroll', this.handleScroll);              
    },
    mounted(){
        this.cambioEspecialidad()
    },
    updated(){
        $(".fc-scroller").bind('scroll', function() {
            $('#context-menu').css({'display':'none'})
        });      
    },
    destroyed(){
        window.removeEventListener('scroll', this.handleScroll);
    },
    data(){
        return {
            isLoading: true,
            fullPage: true,

            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos', 

            IconClassCel : 'la la-refresh la-2x',

/*             Agenda: {
                tipoAgenda:1
            }, */
            tipoAgenda : [{id : 1 , nombre_tipo : 'General'},{ id: 2 , nombre_tipo : 'Filtros'}],
            dataTipoAgenda:{
                tipo : 1
            },
            dataCita : {
                paciente_id:'',
                paciente:'',
                celular:'',
                especialidade_id:0,
                empleado_id:0,
                empleado:'',
                start:'',
                end:'',
                fecha_cita:'',
                fecha_incidencia:'',
                estadocita_id:'',
                sede_id:'',
                adicional:0,
                tipo:1,
                fuera_hora:0,
                user_id:'',
                reprogramado:0,
                comentario:'',
                data_paciente:''
            },
            dataNewPaciente:{
                tipodocumento_id:'',
                numero_documento:'',
                apellido_paterno:'',
                apellido_materno:'',
                nombres:'',
                celular:'',
                sexo:'',
                sede_id: '',
                titular: '',
                empleado_id:'',
                asignacion_id: '',
                user_id:'',
                plan_id:'',
                tipo:''
            },
            dataReprCita :{
                cita_id:'',
                fecha_incidencia:'',
                fecha_anterior:'',
                fecha_nueva:'',
                start_anterior:'',
                end_anterior:'',
                start_nueva:'',
                end_nueva:'',
                empleado_id:'',
                estadocita_id:'',
                reprogramado: 1,
                comentario:'',
                user_id:''               
            },
            dataReprCitaManual :{
                cita_id:'',
                fecha_incidencia:'',
                fecha_anterior:'',
                fecha_nueva:'',
                start_anterior:'',
                end_anterior:'',
                start_nueva:'',
                end_nueva:'',
                paciente:'',
                empleado:'',
                celular:'',
                empleado_id:'',
                estadocita_id:'',
                reprogramado: 1,
                comentario:'',
                user_id:''               
            },            
            columns_pacientes: [
                {
                label: 'DOC.',
                field: 'numero_documento',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },                
                width:'10%',
                },                 
                {
                label: 'Apellido Paterno',
                field: 'apellido_paterno',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'20',
                },  
                {
                label: 'Apellido Materno',
                field: 'apellido_materno',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'20%',
                }, 
                {
                label: 'Nombres',
                field: 'nombres',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'30%',
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
            events: [],           
            config: {  
                nowIndicator: true,                                         
                weekends: true,
                selectable : true,
                selectHelper: true, 
                locale: 'es',  
                timeFormat: 'HH:mm',
                slotDuration:'00:15:00',  
                slotLabelFormat : 'hh:mm a', 
                minTime : '08:00:00',
                maxTime : '24:00:00',  
                editable : true,   
                allDaySlot: false, 
                eventLimit : true,                 
                businessHours:[],
                views : {
                    month : {
                        eventLimit : 3
                    }
                },                                
                selectOverlap: function(event) {
                    return event.rendering !== 'background' || event.especial == 'si';
                },                                                                                        
                drop(...args) {
                //handle drop logic in parent
                console.log("drop")
                },
                
            },
            selectItem: [],
            turn_especials :[],
            turn_permisos:[],
            item_move: false ,
            medicos_especialidad:[],

            dateHoy: new Date(),
            ViewReprogramar: false  // cursor de reprogramar
        }
    },
    computed: {
        ...mapState(['user_system','sede_system','especialidades','documentos','pacientes','turnos','turnosespeciales','citasfechas','estadocitas','permisos']),
        ...mapGetters(['getMedicos','getDocumentosIdentidad']),                  
    },         
    methods:{
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },         
        cambioTipoAgenda(param){
            this.dataCita.especialidade_id = 0
            this.cambioEspecialidad()
        },
        eventSelected(event, jsEvent, view){
            this.dataCita.paciente = event.title
            this.dataCita.celular = event.celular
            this.dataCita.empleado = event.empleado
            this.dataCita.fecha_cita = moment(event.fecha_cita).format('DD-MM-YYYY')
            this.dataCita.start = moment(event.start).format('HH:mm:ss')
            this.dataCita.end = moment(event.end).format('HH:mm:ss')
            this.dataCita.comentario = event.comentario
            this.$modal.show('datos_cita')
        },
        dayclick(date, jsEvent, view){
            $('#context-menu').css({'display':'none'}) 
            //this.$nextTick(() => this.$refs.especialidades.focus())               
        },
        createEvent(event){
            $('#context-menu').css({'display':'none'})             
            if(this.dataCita.empleado_id == 0){
                this.notificaciones('Tiene que seleccionar un odontologo!!','la la-thumbs-o-down','danger')
                this.$refs.calendar.fireMethod('unselect')
                return 
            }
            let businessHours = this.CargaTurnoMedico()
            if(businessHours.length == 0){
                this.notificaciones('El odontologo no tiene turnos asignados!!','la la-thumbs-o-down','danger')
                this.$refs.calendar.fireMethod('unselect')
                return                   
            } 
            let hoy = moment().format('YYYY-MM-DD') 
            let horaActual = moment().format('YYYY-MM-DD HH:mm:ss')
            let d_start = moment(event.start).format('YYYY-MM-DD')
            let d_end = moment(event.end).format('YYYY-MM-DD')
            let h_start = moment(event.start).format('HH:mm:ss')
            let h_end = moment(event.end).format('HH:mm:ss')
            let h_comparation = moment(event.start).format('YYYY-MM-DD HH:mm:ss')
            if(moment(d_start).isBefore(hoy)){
                this.notificaciones('No se puede seleccionar una fecha anterior al dia de hoy !!','la la-thumbs-o-down','danger')
                this.$refs.calendar.fireMethod('unselect')
                return 
            }
            if(moment(h_comparation).isBefore(horaActual)){
                this.notificaciones('No se puede seleccionar una hora menor a la hora actual !!','la la-thumbs-o-down','danger')
                this.$refs.calendar.fireMethod('unselect')
                return 
            }            
            if(!this.validandoTurnoMedico(d_start,d_end,h_start,h_end)){
                this.$swal({
                    title: 'Confirmación del proceso',
                    text: "El odontólogo no tiene turno asignado a este periodo ... desea grabar este registro?",
                    type: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: 'No, Cancelar',
                    confirmButtonText: 'Si, Grabar!'
                    }).then((result) => {
                        if (result.value) {
                            console.log("ok.. continue")
                        }else{
                            this.$refs.calendar.fireMethod('unselect')                            
                            this.$modal.hide('cita_nueva')  
                            return                                                   
                        }
                    });
            }                     
            this.dataCita.tipo = 1
            this.dataCita.fecha_cita = moment(event.start).format('DD-MM-YYYY')
            this.dataCita.start = moment(event.start).format('HH:mm:ss')
            this.dataCita.end = moment(event.end).format('HH:mm:ss')
            this.dataCita.paciente_id = ''
            this.dataCita.paciente = ''
            this.dataCita.celular = ''
            this.dataCita.comentario = ''
            this.dataCita.fecha_incidencia = moment().format('DD-MM-YYYY HH:mm:ss')
            this.dataCita.sede_id = this.sede_system.id
            this.dataCita.user_id = this.user_system.id
            this.dataCita.reprogramado = 0
            this.dataCita.estadocita_id = 1

            this.dataNewPaciente = {
                tipodocumento_id:'',
                numero_documento:'',
                apellido_paterno:'',
                apellido_materno:'',
                nombres:'',
                celular:'',
                sexo:'H',
                sede_id: 1,
                titular: 1,
                empleado_id:this.dataCita.empleado_id,
                asignacion_id: 1,
                user_id:this.user_system.id,
                plan_id:this.sede_system.plan_id,
                tipo : 1
            } 
            if(this.ViewReprogramar){
                this.dataReprCitaManual.fecha_nueva = moment(event.start).format('YYYY-MM-DD')
                this.dataReprCitaManual.start_nueva =  moment(event.start).format('HH:mm:ss')
                this.dataReprCitaManual.end_nueva = moment(event.end).format('HH:mm:ss')
                this.$modal.show('reprogramacion-manual')  
            }else{
                this.$modal.show('cita_nueva')  
            }
                       
        } ,
        eventDrop( event, delta, revertFunc, jsEvent, ui, view ){
            //console.log("cambio drop")
            let self = this
            let bloqueado = false
            let turn_valid = true
            $('.popover').remove()
            let fec_hoy = moment().format('YYYY-MM-DD')
            let fec_new = event.start.format('YYYY-MM-DD')
            // comprobando si la fecha es anterior al dia de hoy
            if(moment(fec_new).isBefore(fec_hoy)){
                this.notificaciones('La fecha de reprogramacion no puede ser anterior al dia de hoy!!','la la-thumbs-o-down','danger')
                revertFunc()
                return  
            }
            // comprobando si en la fecha nueva tiene permisos el medico
            let permisos = this.permisos.filter(per => per.empleado_id == this.dataCita.empleado_id)
            _.each(permisos, function(value,key){
                let fec_ini = moment(value.fecha_inicio,'DD-MM-YYYY').format('YYYY-MM-DD')                
                let fec_new = event.start.format('YYYY-MM-DD')                 
                if(value.tipopermiso == 1){
                    let fec_fin = moment(value.fecha_fin,'DD-MM-YYYY').format('YYYY-MM-DD')                      
                    if(moment(fec_new).isBetween(fec_ini,fec_fin,null,[])){
                        self.notificaciones('La fecha esta bloqueada por Permiso del odontólogo!!','la la-thumbs-o-down','danger')
                        revertFunc()
                        bloqueado = true
                        return                          
                    }                  
                }else{
                    if(moment(fec_new).isSame(fec_ini)){
                        let h_ini = moment(value._horaini.nombre_hora + ':00','HH:mm:ss')
                        let h_fin = moment(value._horafin.nombre_hora + ':00','HH:mm:ss')
                        let h_start = event.start.format('HH:mm:ss')   
                        let h_end = event.end.format('HH:mm:ss') 
                        if(moment(h_start,'HH:mm:ss').isBetween(h_ini, h_fin )){
                            self.notificaciones('La fecha esta bloqueada por Permiso del odontólogo!!','la la-thumbs-o-down','danger')
                            revertFunc()
                            bloqueado = true
                            return 
                        }  
                        if(moment(h_end,'HH:mm:ss').isBetween(h_ini, h_fin )){
                            self.notificaciones('La fecha esta bloqueada por Permiso del odontólogo!!','la la-thumbs-o-down','danger')
                            revertFunc()
                            bloqueado = true
                            return 
                        }                                          
                    }
                }                
            })
            // comprobando los turnos del medico
            let d_start = moment(event.start).format('YYYY-MM-DD')
            let d_end = moment(event.end).format('YYYY-MM-DD')
            let h_start = moment(event.start).format('HH:mm:ss')
            let h_end = moment(event.end).format('HH:mm:ss')
            if(!this.validandoTurnoMedico(d_start,d_end,h_start,h_end)){
                turn_valid = false
            }                     
            // fin de comprobacion
            if(bloqueado){
                return
            }
            this.$swal({
                title: turn_valid ? 'Desea Reprogramar esta cita?' : 'Confirmación del Proceso!!',
                text: turn_valid ? "No podras revertir esto!" : 'El odontólogo no tiene turno asignado a este periodo ... desea grabar este registro?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, Reprogramar!'
                }).then((result) => {
                    if (result.value) {
                        this.dataReprCita = {
                            cita_id:event.id,
                            fecha_incidencia:moment().format('DD-MM-YYYY HH:mm:ss'),
                            fecha_anterior:moment(event.start_ant,'YYYY-MM-DD').format('YYYY-MM-DD'),
                            fecha_nueva:event.start.format('YYYY-MM-DD'),
                            start_anterior:String(moment(event.start_ant).format('HH:mm:ss')),
                            end_anterior:String(moment(event.end_ant).format('HH:mm:ss')),
                            start_nueva:String(event.start.format('HH:mm:ss')),
                            end_nueva:String(event.end.format('HH:mm:ss')),
                            empleado_id:this.dataCita.empleado_id,
                            estadocita_id:event.estadocita_id,
                            reprogramado: 1,
                            comentario:'',
                            user_id:this.user_system.id
                        }                        
                        this.$modal.show('reprogramacion')
                    }else{
                        revertFunc()
                    }
                });            
        },
        eventDragStart(event, jsEvent, ui, view ){
            this.item_move = true
            $('.popover').remove()
        },
        eventDragStop(event, jsEvent, ui, view ){
            this.item_move = false
            $('.popover').remove()
        },        
        eventRender(event,element){
            let self = this
            if(this.dataCita.empleado_id > 0){
                element.on('contextmenu', function (e) { 
                    if(e.target.className != 'fc-bgevent'){
                        $('#context-menu').css({'display':'block'})
                        self.selectItem = event
                        self.$refs.ctxMenu.open()
                    }
                })
            }
            if(event.rendering !== 'background'){
                if(!self.item_move){
                    $(element).popover({
                        title: event.title == undefined ? '' : event.title,
                        placement: 'top',
                        content: event.empleado == undefined ? '' : 'MED.: '+event.empleado,
                        container: 'body',
                        trigger : 'hover',
                        animation : true
                    });
                }
            }                                                  
        },
        eventMouseover(event, jsEvent, view){
            //console.log("evento",event)
        },
        eventResize(event, delta, revertFunc){
            let self = this
            let bloqueado = false
            let turn_valid = true
            $('.popover').remove()
            let fec_hoy = moment().format('YYYY-MM-DD')
            let fec_new = event.start.format('YYYY-MM-DD')
            // comprobando si la fecha es anterior al dia de hoy
/*             if(moment(fec_new).isBefore(fec_hoy)){
                this.notificaciones('La fecha de reprogramacion no puede ser anterior al dia de hoy!!','la la-thumbs-o-down','danger')
                revertFunc()
                return  
            } */
            // comprobando si en la fecha nueva tiene permisos el medico
            let permisos = this.permisos.filter(per => per.empleado_id == this.dataCita.empleado_id)
            _.each(permisos, function(value,key){
                let fec_ini = moment(value.fecha_inicio,'DD-MM-YYYY').format('YYYY-MM-DD')                
                let fec_new = event.start.format('YYYY-MM-DD')                 
                if(value.tipopermiso == 1){
                    let fec_fin = moment(value.fecha_fin,'DD-MM-YYYY').format('YYYY-MM-DD')                      
                    if(moment(fec_new).isBetween(fec_ini,fec_fin,null,[])){
                        self.notificaciones('La fecha esta bloqueada por Permiso del odontólogo!!','la la-thumbs-o-down','danger')
                        revertFunc()
                        bloqueado = true
                        return                          
                    }                  
                }else{
                    if(moment(fec_new).isSame(fec_ini)){
                        let h_ini = moment(value._horaini.nombre_hora + ':00','HH:mm:ss')
                        let h_fin = moment(value._horafin.nombre_hora + ':00','HH:mm:ss')
                        let h_start = event.start.format('HH:mm:ss')   
                        let h_end = event.end.format('HH:mm:ss') 
                        if(moment(h_start,'HH:mm:ss').isBetween(h_ini, h_fin )){
                            self.notificaciones('La fecha esta bloqueada por Permiso del odontólogo!!','la la-thumbs-o-down','danger')
                            revertFunc()
                            bloqueado = true
                            return 
                        }  
                        if(moment(h_end,'HH:mm:ss').isBetween(h_ini, h_fin )){
                            self.notificaciones('La fecha esta bloqueada por Permiso del odontólogo!!','la la-thumbs-o-down','danger')
                            revertFunc()
                            bloqueado = true
                            return 
                        }                                          
                    }
                }                
            })
            // comprobando los turnos del medico
            let d_start = moment(event.start).format('YYYY-MM-DD')
            let d_end = moment(event.end).format('YYYY-MM-DD')
            let h_start = moment(event.start).format('HH:mm:ss')
            let h_end = moment(event.end).format('HH:mm:ss')
            if(!this.validandoTurnoMedico(d_start,d_end,h_start,h_end)){
                turn_valid = false
            }                     
            // fin de comprobacion
            if(bloqueado){
                return
            }
            this.$swal({
                title: turn_valid ? 'Desea Modificar esta cita?' : 'Confirmación del Proceso!!',
                text: turn_valid ? "No podras revertir esto!" : 'El odontólogo no tiene turno asignado a este periodo a modificar... desea grabar este registro?',
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, Modificar!'
                }).then((result) => {
                    if (result.value) {
                        this.dataReprCita = {
                            cita_id:event.id,
                            fecha_incidencia:moment().format('DD-MM-YYYY HH:mm:ss'),
                            fecha_anterior:'',
                            fecha_nueva:'',
                            start_anterior:String(moment(event.start_ant).format('HH:mm:ss')),
                            end_anterior:String(moment(event.end_ant).format('HH:mm:ss')),
                            start_nueva:String(event.start.format('HH:mm:ss')),
                            end_nueva:String(event.end.format('HH:mm:ss')),
                            empleado_id:this.dataCita.empleado_id,
                            estadocita_id:event.estadocita_id,
                            reprogramado: 0,
                            comentario:'',
                            user_id:this.user_system.id
                        }                        
                        this.$modal.show('modificacion')
                    }else{
                        revertFunc()
                    }
                });            
        },
        viewRender(view,element){       // Recarga la vista
            $('.popover').remove()
            this.CargaFullcalendar()
            if(this.ViewReprogramar){
                this.ModoReprogramacionManual(true)
            }
        },
        selectPaciente(params){
            this.dataCita.paciente_id = params.row.id
            this.dataCita.paciente = params.row.nombre_completo
            this.dataCita.celular = params.row.celular
            this.$modal.hide('pacientes')
        },
        cambioEspecialidad(){
            console.log("cambio_e")
            if(this.dataCita.especialidade_id == 0){
                this.medicos_especialidad = this.getMedicos
            }else{
                let especialidad = this.especialidades.find(esp => esp.id == this.dataCita.especialidade_id)
                this.medicos_especialidad = especialidad.empleados
            }
            this.dataCita.empleado_id = 0
            this.cambioMedico()
        },
        cambioMedico(){
            if(this.dataCita.empleado_id == 0){
                this.$refs.calendar.fireMethod('option', 'businessHours', [])                 
                //return
            }else{
                let medico = this.getMedicos.find(med => med.id == this.dataCita.empleado_id)
                this.dataCita.empleado = medico.nombre_completo
                let businessHours = this.CargaTurnoMedico()
                if(businessHours.length == 0){
                    this.notificaciones('El odontologo no tiene turnos asignados!!','la la-thumbs-o-down','danger') 
                    this.$refs.calendar.fireMethod('option', 'editable', false)             
                }else{
                    this.$refs.calendar.fireMethod('option', 'editable', true)
                }
                this.$refs.calendar.fireMethod('option', 'businessHours', businessHours)   
            }
            this.CargaFullcalendar()                         
        },
        actualizaCelular(){
            this.$swal({
                title: 'Actualiza el Celular??',
                text: "No podra revertir esto !!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'No, Cancelar',
                confirmButtonText: 'Si, Actualizar!'
                }).then((result) => {
                    if (result.value) {
                        var url = '/api/pacientes/actualizacelular/'+this.dataCita.paciente_id 
                        this.IconClassCel = 'la la-spinner la-2x'
                        //this.StatusForm(true,'la la-spinner','Procesando')     
                        axios.put(url, this.dataCita).then(response => {
                            if(typeof(response.data.errors) != "undefined"){
                                this.errors = response.data.errors;
                                var resultado = "";
                                for (var i in this.errors) {
                                    if (this.errors.hasOwnProperty(i)) {
                                        resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                                    }
                                } 
                                this.IconClassCel = 'la la-refresh la-2x'  
                                //this.StatusForm(false,'la la-cloud-download','Grabar Datos')
                                this.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                 
                                return;
                            }
                            this.$store.dispatch('LOAD_PACIENTES_LIST')                  
                            this.errors = [];
                            this.IconClassCel = 'la la-refresh la-2x' 
                            //this.StatusForm(false,'la la-cloud-download','Grabar Datos')           
                            this.notificaciones('el Celular fue actualizado con exito','la la-thumbs-up','success')                  
                        }).catch(error => {
                            this.errors = error.response.data.status;  
                            this.IconClassCel = 'la la-refresh la-2x' 
                            //this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')
                        });                        
                    }
                });            
        },
        createCita: function(){
            if(this.dataCita.tipo == 1){
                this.dataCita.data_paciente = ''
            }else{
                this.dataCita.data_paciente = this.dataNewPaciente
            }
            var url = '/api/citas';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataCita).then(response => {
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

            this.$store.dispatch('LOAD_CITAS_LIST').then(() => {
               this.CargaFullcalendar()
            }) 
            if(this.dataCita.data_paciente != ''){
                this.$store.dispatch('LOAD_PACIENTES_LIST')
            }  
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('cita_nueva');   
            this.notificaciones('Nueva Cita creada con exito','la la-thumbs-up','success')       
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')           

            });
        },
        CargaTurnoMedico(){
            let self = this
            this.turn_especials = []    // turnos especiales del doctor
            this.turn_permisos = []
            let turnomedico = this.turnos.filter(tur => tur.empleado_id == this.dataCita.empleado_id)
            let turnomedico_esp = this.turnosespeciales.filter(tur => tur.empleado_id == this.dataCita.empleado_id)
            let permisos = this.permisos.filter(per => per.empleado_id == this.dataCita.empleado_id)
            let turncompleto = []
            _.each(turnomedico, function(value,key){
                if(value.horaini1 != null && value.horafin1 != null){
                    let dataturn = {
                        dow:[],
                        start:'',
                        end:''
                    }                
                    dataturn.dow.push(value.dia_id)
                    dataturn.start = value.horaini1.nombre_hora
                    dataturn.end = value.horafin1.nombre_hora
                    let copyt = _.clone(dataturn)
                    turncompleto.push(copyt) 
                }
               
                if(value.horaini2 != null && value.horafin2 != null){
                    let dataturn = {
                        dow:[],
                        start:'',
                        end:''
                    }                
                    dataturn.dow.push(value.dia_id)
                    dataturn.start = value.horaini2.nombre_hora
                    dataturn.end = value.horafin2.nombre_hora 
                    let copyt = _.clone(dataturn)
                    turncompleto.push(copyt)                                       
                }
                               
            })
            _.each(turnomedico_esp, function(value,key){
                if(value.horaini1 != null && value.horafin1 != null){
                    let evento = {
                        start : String(value.fecha) + 'T' + value.horaini1.nombre_hora + ':00',
                        end: String(value.fecha) + 'T' + value.horafin1.nombre_hora + ':00',
                        rendering: 'background',
                        color: '#99FF00',
                        especial: 'si'
                    }
                    self.turn_especials.push(evento)
                }               
                if(value.horaini2 != null && value.horafin2 != null){
                    let evento = {
                        start : String(value.fecha) + 'T' + value.horaini2.nombre_hora + ':00',
                        end: String(value.fecha) + 'T' + value.horafin2.nombre_hora + ':00',
                        rendering: 'background',
                        color: '#99FF00',
                        especial: 'si'
                    }
                    self.turn_especials.push(evento)                                      
                }
                               
            })
            _.each(permisos, function(value,key){
                let fec_ini = moment(value.fecha_inicio,'DD-MM-YYYY').format('YYYY-MM-DD')
                let fec_fin = value.fecha_fin != null ? moment(value.fecha_fin,'DD-MM-YYYY').format('YYYY-MM-DD') : ''
                let evento = {
                    start : value.tipopermiso == 1 ?  String(fec_ini) : String(fec_ini) + 'T' + value._horaini.nombre_hora + ':00', 
                    end: value.tipopermiso == 1 ? String(fec_fin) : String(fec_ini) + 'T' + value._horafin.nombre_hora + ':00',
                    rendering: 'background',
                    color: 'red',
                    especial: 'no'
                }
                self.turn_permisos.push(evento)                               
            })
            return turncompleto           
        },
        handleScroll(){
            $('#context-menu').css({'display':'none'}) 
        },
        cargaEventos(data){
            let eventos = []
            let evento = {
                id :'',
                title  : '',
                start  : '', //'2019-02-14T12:30:00',
                end :  '', //'2019-02-14T13:00:00',
                start_ant: '',
                end_ant:'',
                paciente_id:'',
                celular: '',
                fecha_cita : '',
                empleado: '',
                empleado_id :'',
                comentario: '',
                estadocita_id:'',
                reprogramado:'',
                confirmado:'',
                allDay : '',
                className: '',
                backgroundColor	: '',
                textColor :'',
                especial : ''              
            }
            _.each(data, function(value,key){
                let class_event
                let bg_color
/*                 switch (_.last(value.seguimientocitas).estadocita_id) {
                    case 1 : class_event = 'fc-primary'; break;
                    case 2 : class_event = 'fc-secondary'; break;                    
                    case 3 : class_event = 'fc-default'; break;                    
                    case 4 : class_event = 'fc-success'; break;                    
                    case 5 : class_event = 'fc-danger'; break;                    
                    case 6 : class_event = 'fc-warning'; break;                    
                }  */    
                switch (value.estadocita_id) {
                    case 1 : bg_color = '#177DFF'; break;
                    case 2 : bg_color = '#716ACA'; break;                    
                    case 3 : bg_color = '#282A3C'; break;                    
                    case 4 : bg_color = '#35CD3A'; break;                    
                    case 5 : bg_color = '#FFA534'; break;                    
                    case 6 : bg_color = '#F3545D'; break;                    
                }                             
                evento = {
                    id: String(value.id),
                    title: value.paciente.nombre_completo,
                    start : String(value.fecha_cita) + 'T' + value.start,
                    end: String(value.fecha_cita) + 'T' + value.end,
                    start_ant : String(value.fecha_cita) + 'T' + value.start,
                    end_ant: String(value.fecha_cita) + 'T' + value.end,                    
                    paciente_id: value.paciente_id,
                    celular: value.paciente.celular,
                    fecha_cita: value.fecha_cita,
                    empleado: value.empleado.nombre_completo,
                    empleado_id : value.empleado_id,
                    comentario: _.first(value.seguimientocitas).comentario,
                    estadocita_id : value.estadocita_id,
                    reprogramado : value.reprogramado,
                    confirmado : value.confirmado,
                    allDay : false ,
                    className : value.confirmado == true ? 'fc-success' : 'fc-danger',
                    backgroundColor : bg_color,
                    textColor : 'yellow',
                    especial: 'no'
                }
                let dato = _.clone(evento)
                eventos.push(dato)
            }) 
            if(this.turn_especials.length > 0){
                _.each(this.turn_especials, function(value,key){
                    eventos.push(value)
                })
            } 
            if(this.turn_permisos.length > 0){
                _.each(this.turn_permisos, function(value,key){
                    eventos.push(value)
                })
            }                        
            this.events = eventos 
            this.isLoading = false      
        },
        CargaFullcalendar(){
            let self = this
            this.isLoading = true
            let citasxfiltro = []
            let ini = moment(this.$refs.calendar.fireMethod('getView').start).format('DDMMYYYY')
            let fin = moment(this.$refs.calendar.fireMethod('getView').end).format('DDMMYYYY')
            this.$store.dispatch('LOAD_CITAS_FECHAS_LIST',{ fecini : ini , fecfin : fin }).then(() => {
                if(this.dataCita.especialidade_id == 0){
                    citasxfiltro = this.citasfechas
                }
                if(this.dataCita.especialidade_id > 0 && this.dataCita.empleado_id == 0){
                    let especialidad = this.especialidades.find(esp => esp.id == this.dataCita.especialidade_id)
                    _.each(especialidad.empleados, function(value,key){
                        let cit = self.citasfechas.filter(ci => ci.empleado_id == value.id)
                        if(cit.length > 0){
                            _.each(cit,function(value2,key2){
                                citasxfiltro.push(value2)
                            })
                        }
                    })                 
                }
                if(this.dataCita.empleado_id > 0){
                    citasxfiltro = this.citasfechas.filter(cif => cif.empleado_id == this.dataCita.empleado_id)
                }
                //console.log("citas-filtro",citasxfiltro)
                //this.cargaEventos(this.citasfechas)
                this.cargaEventos(citasxfiltro)
                this.isLoading = false 
            }) 
          
        },
        cambioEstado(e_cita_id){
            this.$swal({
                title: 'Desea Modificar esta cita?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, Modificar!'
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true
                        let data = {
                            cita_id:this.selectItem.id,
                            fecha_incidencia: moment().format('DD-MM-YYYY HH:mm:ss'),
                            estadocita_id:e_cita_id,
                            user_id:this.user_system.id
                        }
                        var url = '/api/citas/cambioestado';
                        axios.post(url, data).then(response => {
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
                            this.isLoading = false              
                            return;
                        }
                        this.CargaFullcalendar()
                        this.errors = [];
                        this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
                        this.$modal.hide('cita_nueva');   
                        this.notificaciones('La Cita fue modificada con exito','la la-thumbs-up','success')       
                        }).catch(error => {
                        this.errors = error.response.data.status;
                        this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
                        this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           
                        });
                    }
                });
        },
        reprogramarCitaManual(param){
            this.dataReprCitaManual = {
                cita_id:param.id,
                fecha_incidencia:moment().format('DD-MM-YYYY HH:mm:ss'),
                fecha_anterior:moment().format('DD-MM-YYYY'),
                fecha_nueva:'',
                start_anterior:moment(param.start_ant).format('HH:mm:ss'),
                end_anterior:moment(param.end_ant).format('HH:mm:ss'),
                start_nueva:'',
                end_nueva:'',
                empleado:param.empleado,
                paciente:param.title,
                celular:param.celular,
                empleado_id:param.empleado_id,
                estadocita_id:param.estadocita_id,
                reprogramado: 1,
                comentario:'',
                user_id:this.user_system.id               
            }
            this.ViewReprogramar = true
            this.ModoReprogramacionManual(true)
        },
        ModoReprogramacionManual(bparam){
            const el = document.querySelectorAll('.fc-widget-content');
            for (var i = 0; i < el.length; i++) {
                if(bparam){
                    el[i].classList.add('fc-cursor-new');
                }else{
                    el[i].classList.remove('fc-cursor-new');
                }
            }          
        },
        validandoTurnoMedico(d_s,d_e,h_s,h_e){
            // primero validamos el dia
            let valor = false
            let dia = moment(d_s).day()
            let diaok = this.turnos.find(tur => tur.empleado_id == this.dataCita.empleado_id && tur.dia_id == dia)
            if(diaok != undefined){ 
                if( diaok.horaini1 != null && diaok.horafin1 != null){
                    let h_ini1 = moment(diaok.horaini1.nombre_hora + ':00','HH:mm:ss')
                    let h_fin1 = moment(diaok.horafin1.nombre_hora + ':00','HH:mm:ss')
                    // comprobamos la hora de inicio del calendario turno mañana
                    if(moment(h_s,'HH:mm:ss').isBetween(h_ini1, h_fin1 , null , [])){
                        // comprobamos la hora de fin del calendario
                        if(moment(h_e,'HH:mm:ss').isBetween(h_ini1, h_fin1 , null , [])){
                            valor = true
                        }
                    }
                }             
                if( diaok.horaini2 != null && diaok.horafin2 != null){
                    let h_ini2 = moment(diaok.horaini2.nombre_hora + ':00','HH:mm:ss')
                    let h_fin2 = moment(diaok.horafin2.nombre_hora + ':00','HH:mm:ss')  
                    // comprobamos la hora de inicio del calendario turno tarde
                    if(moment(h_s,'HH:mm:ss').isBetween(h_ini2, h_fin2 , null , [])){
                        // comprobamos la hora de fin del calendario
                        if(moment(h_e,'HH:mm:ss').isBetween(h_ini2, h_fin2 , null , [])){
                            valor = true
                        }
                    }                      
                }          
            }
            // turnos especiales
            let dia_esp = moment(d_s).format('YYYY-MM-DD')
            let dia_espok = this.turnosespeciales.find(tur => tur.empleado_id == this.dataCita.empleado_id && tur.fecha == dia_esp)
            if(dia_espok != undefined){
                if( dia_espok.horaini1 != null && dia_espok.horafin1 != null){
                    let h_ini1 = moment(dia_espok.horaini1.nombre_hora + ':00','HH:mm:ss')
                    let h_fin1 = moment(dia_espok.horafin1.nombre_hora + ':00','HH:mm:ss')
                    // comprobamos la hora de inicio del calendario turno mañana
                    if(moment(h_s,'HH:mm:ss').isBetween(h_ini1, h_fin1 , null , [])){
                        // comprobamos la hora de fin del calendario
                        if(moment(h_e,'HH:mm:ss').isBetween(h_ini1, h_fin1 , null , [])){
                            valor = true
                        }
                    }
                }             
                if( dia_espok.horaini2 != null && dia_espok.horafin2 != null){
                    let h_ini2 = moment(dia_espok.horaini2.nombre_hora + ':00','HH:mm:ss')
                    let h_fin2 = moment(dia_espok.horafin2.nombre_hora + ':00','HH:mm:ss')  
                    // comprobamos la hora de inicio del calendario turno tarde
                    if(moment(h_s,'HH:mm:ss').isBetween(h_ini2, h_fin2 , null , [])){
                        // comprobamos la hora de fin del calendario
                        if(moment(h_e,'HH:mm:ss').isBetween(h_ini2, h_fin2 , null , [])){
                            valor = true
                        }
                    }                      
                }                 
            }
            return valor
        },
        reprogramarCita(){           
            var url = '/api/citas/reprogramacion/' + this.dataReprCita.cita_id;
            this.StatusForm(true,'la la-spinner','Procesando')  
            axios.put(url, this.dataReprCita).then(response => {
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
                this.CargaFullcalendar()                 
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
                this.$modal.hide('reprogramacion');  
                this.notificaciones('la cita fue reprogramada con exito','la la-thumbs-up','success')                  
            }).catch(error => {
                this.errors = error.response.data.status;  
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')
            });
        },
        confirmarCita(param){ 
            let data = {
                cita_id : param.id,
                fecha_incidencia : moment().format('DD-MM-YYYY HH:mm:ss'),
                estadocita_id : 1,
                confirmado : 1,
                user_id:this.user_system.id 
            }          
            var url = '/api/citas/confirmar/' + param.id;
            this.StatusForm(true,'la la-spinner','Procesando')  
            axios.put(url, data).then(response => {
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
                this.CargaFullcalendar()                 
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')           
                this.notificaciones('la cita fue confirmada con exito','la la-thumbs-up','success')                  
            }).catch(error => {
                this.errors = error.response.data.status;  
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')
            });
        },        
        grabareprogramarCitaManual(){           
            var url = '/api/citas/reprogramacion/' + this.dataReprCitaManual.cita_id;
            this.StatusForm(true,'la la-spinner','Procesando')  
            axios.put(url, this.dataReprCitaManual).then(response => {
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
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
                this.$modal.hide('reprogramacion-manual'); 
                $('.popover').remove()
                this.ViewReprogramar = false
                this.ModoReprogramacionManual(false)  
                this.CargaFullcalendar()                                
                this.notificaciones('la cita fue reprogramada con exito','la la-thumbs-up','success')                  
            }).catch(error => {
                this.errors = error.response.data.status;  
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')
            });
        },        
        cancelReprogramacion(){
            this.$modal.hide('reprogramacion')
            this.CargaFullcalendar()
        },
        modificarCita(){           
            var url = '/api/citas/modificacion/' + this.dataReprCita.cita_id;
            this.StatusForm(true,'la la-spinner','Procesando')  
            axios.put(url, this.dataReprCita).then(response => {
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
                this.CargaFullcalendar()                 
                this.errors = [];
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
                this.$modal.hide('modificacion');  
                this.notificaciones('la cita fue actualizada con exito','la la-thumbs-up','success')                  
            }).catch(error => {
                this.errors = error.response.data.status;  
                this.StatusForm(false,'la la-cloud-download','Grabar Datos')             
                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')
            });
        },
        cancelModificacion(){
            this.$modal.hide('modificacion')
            this.CargaFullcalendar()
        },
        cancelReprogramacionManual(){
            this.$modal.hide('reprogramacion-manual')  
            $('.popover').remove()
            this.ViewReprogramar = false
            this.ModoReprogramacionManual(false)
            this.CargaFullcalendar()      
        },
        classState(param){
            let state = false
            if(param == 2 || param == 3 || param == 4){
                state = parseInt(this.selectItem.estadocita_id) + 1 != param || this.selectItem.confirmado == false
            }
            if(param == 5){
                state = this.selectItem.estadocita_id != 1 || this.selectItem.reprogramado == 1
            }
            if(param == 6){
                state = this.selectItem.estadocita_id != 1
            }
            return {
                'disabled' : state
            }
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
    .v--modal-overlay {
        z-index:9000;     
    }    
    .vld-overlay.is-full-page {
        z-index: 99999;
    }
    #comentario {
        width: 100% !important;
    }  
    #comentario_reprog {
        width: 100% !important;
    }     
    .form-control:disabled {
        opacity: 0.9 !important;
    }
    .circle_estado {
        display: inline-block;
        height: 10px;
        margin-right: 10px;
        width: 10px;        
    }
    .table-sm th,
    .table-sm td {
        padding: 0.3rem !important; 
        font-size: 11px !important;
    } 
    .btn-xs {
        padding: 3px !important;
    }   
/*     .fc-widget-content {
        cursor : move !important;
    } */
    .fc-cursor-new {
        cursor : move !important;
    }
</style>

