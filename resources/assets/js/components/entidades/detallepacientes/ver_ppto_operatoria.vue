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
<!--             <div class="row">
                <div class="col-4">
                    <div class="form-group form-group-default" >
                        <label for="historia" class="text-primary font-weight-bold">Paciente </label>
                        <p class="form-control-static mb-0" v-text="dataPaciente.nombre_completo"></p>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group form-group-default" >
                        <label for="historia" class="text-primary font-weight-bold">Num. Historia </label>
                        <p class="form-control-static text-center mb-0" v-text="dataPaciente.historiaclinica"></p>
                    </div>
                </div>
                <div class="col-2">
                    <div class="form-group form-group-default" >
                        <label for="historia" class="text-primary font-weight-bold">T.C </label>
                        <p class="form-control-static mt-5 mb-0" v-text="dataPaciente.tipocambio"></p>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group form-group-default" >
                        <label for="historia" class="text-primary font-weight-bold">Fecha </label>
                        <p class="form-control-static mt-5 mb-0" v-text="dataPaciente.fecha"></p>
                    </div>
                </div>                 
            </div> -->
            <div class="row">
                <div class="col-4 pr-0">
                    <div class="form-group form-group-default border-odonto">
                        <label for="empresa" class="text-primary font-weight-bold">Empresa </label>
                        <p class="form-control-static text-truncate mb-0" v-text="dataPaciente.empresa"></p>
                    </div>
                </div>
                <div class="col-4">
                    <div class="form-group form-group-default border-odonto">
                        <label for="plan" class="text-primary font-weight-bold">Plan </label>
                        <p class="form-control-static text-truncate mb-0" v-text="dataPaciente.plan"></p>
                    </div>
                </div>
                <div class="col-4 pl-0">
                    <div class="form-group form-group-default border-odonto">
                        <label for="aseguradora" class="text-primary font-weight-bold">Aseguradora </label>
                        <p class="form-control-static text-truncate mb-0" v-text="dataPaciente.aseguradora"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-7">
                    <div class="form-group form-group-default border-odonto">
                        <label for="medicos" class="text-primary font-weight-bold">Profesional </label>
                        <select class="form-control form-control-sm mt-5" id="medicos" v-model="dataPaciente.empleado_id" @change.prevent="CambioMedico(dataPresupuesto.empleado_id)">
                            <option value="">-- Seleccione --</option>
                            <option v-for="med in getMedicos" :value="med.id" :key="med.id">
                                {{ med.nombre_completo}}
                            </option>
                        </select>                                
                    </div>
                </div>
                <div class="col-2 pr-0 pl-0">
                    <div class="form-group form-group-default border-odonto">
                        <label for="tipocambio" class="text-primary font-weight-bold">T.Cambio </label>
                        <p class="form-control-static mt-5 mb-0" v-text="dataPaciente.tipocambio"></p>
                    </div>
                </div>
                <div class="col-3">
                    <div class="form-group form-group-default border-odonto">
                        <label for="fecha" class="text-primary font-weight-bold">Fecha </label>
                        <p class="form-control-static mt-5 mb-0" v-text="dataPaciente.fecha"></p>
                    </div>
                </div>                                
            </div>
            <div class="row">
                <div class="col-9 pr-10">
                    <div class="card">
                        <div class="card-body">
                            <ul class="nav nav-pills nav-secondary" id="pills-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="pills-tx-pendientes-tab" data-toggle="pill" href="#pills-tx-pendientes" role="tab" aria-controls="pills-tx-pendientes" aria-selected="true">TX Pendientes</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="pills-tx-realizados-tab" data-toggle="pill" href="#pills-tx-realizados" role="tab" aria-controls="pills-tx-realizados" aria-selected="false">TX Realizados</a>
                                </li>
                            </ul>
                            <div class="tab-content mb-3" id="pills-tabContent">
                                <div class="tab-pane fade show active" id="pills-tx-pendientes" role="tabpanel" aria-labelledby="pills-tx-pendientes-tab">
                                    <vue-good-table
                                    ref="tabla_detalle"
                                    :columns="columns"
                                    :rows="items_sindescarga"
                                    :paginationOptions="{
                                        enabled: true,
                                        dropdownAllowAll: false,
                                        nextLabel: 'Sig',
                                        prevLabel: 'Ant',
                                        rowsPerPageLabel: 'Registros por Pagina',
                                        ofLabel: 'de',
                                        allLabel: 'Todos',
                                    }"
                                    @on-selected-rows-change="selectionChanged"
                                    :selectOptions="{
                                        enabled: true,
                                        selectOnCheckboxOnly: false, // only select when checkbox is clicked instead of the row
                                        selectionInfoClass: 'custom-class',
                                        selectionText: 'registros seleccionados',
                                        clearSelectionText: 'borrar seleccionados',
                                    }"                                    
                                    :rowStyleClass="rowStyleClassFn"                                    
                                    :lineNumbers="true"
                                    styleClass="vgt-table condensed bordered striped">
                                        <template slot="table-row" slot-scope="props">
                                            <span v-if="props.column.field == 'pagado'" class="center">
                                                <span class="center badge" :class="{'badge-danger' : props.row.pagado == 0 ,'badge-primary' : props.row.pagado == 1 }">{{ props.row.pagado == 0 ? 'NO' : 'SI' }}</span>             
                                            </span>
                                            <span v-else-if="props.column.field == 'realizado'">
                                                <span class="center badge badge-danger" v-if="props.row.realizado == 1" v-text="'PENDIENTE'">pendiente</span>                                
                                                <span class="center badge badge-primary" v-if="props.row.realizado == 2" v-text="'EN PROCESO'">proceso</span>                                
                                                <span class="center badge badge-success" v-if="props.row.realizado == 3" v-text="'TERMINADO'">terminado</span>                                
                                            </span>
                                            <span v-else>
                                                {{props.formattedRow[props.column.field]}}
                                            </span>
                                        </template>                                                         
                                    </vue-good-table>
                                    <div class="row text-center">
                                        <div class="col-12 pt-10">
                                            <button class="btn btn-primary btn-sm" :disabled="color_selected.length == 0" @click.prevent="pagoDirecto"><span class="btn-label"><i class="la la-money"></i></span>Pago Directo</button>
                                            <button class="btn btn-primary btn-sm" :disabled="color_selected.length == 0" @click.prevent="descargaTx"><span class="btn-label"><i class="la la-download"></i></span>Descarga TX</button>
                                            <button class="btn btn-primary btn-sm" :disabled="color_selected.length == 0" @click.prevent="descargaSaldo"><span class="btn-label"><i class="la la-sort-amount-asc"></i></span>Descarga con Saldo</button>
                                            <button class="btn btn-primary btn-sm" :disabled="color_selected.length == 0" @click.prevent="RealizarTratamiento"><span class="btn-label"><i class="la la-pencil-square"></i></span>Realizar Tratamiento</button>             
                                        </div>
                                    </div>
                                </div>
                                <!-- descargados -->
                                <div class="tab-pane fade" id="pills-tx-realizados" role="tabpanel" aria-labelledby="pills-tx-realizados-tab">
                                    <vue-good-table
                                    ref="tabla_detalle_2"
                                    :columns="columns2"
                                    :rows="items_descargados"
                                    :paginationOptions="{
                                        enabled: true,
                                        dropdownAllowAll: false,
                                        nextLabel: 'Sig',
                                        prevLabel: 'Ant',
                                        rowsPerPageLabel: 'Registros por Pagina',
                                        ofLabel: 'de',
                                        allLabel: 'Todos',
                                    }"
                                    @on-selected-rows-change="selectionChanged2"
                                    :selectOptions="{
                                        enabled: true,
                                        selectOnCheckboxOnly: false, // only select when checkbox is clicked instead of the row
                                        selectionInfoClass: 'custom-class',
                                        selectionText: 'registros seleccionados',
                                        clearSelectionText: 'borrar seleccionados',
                                    }"                                    
                                    :rowStyleClass="rowStyleClassFn2"                                    
                                    :lineNumbers="true"
                                    styleClass="vgt-table condensed bordered striped">
                                        <template slot="table-row" slot-scope="props">
                                            <span v-if="props.column.field == 'realizado'">
                                                <span class="center badge badge-success" v-if="props.row.realizado == 3" v-text="'TERMINADO'">terminado</span>                                
                                            </span>
                                            <span v-else>
                                                {{props.formattedRow[props.column.field]}}
                                            </span>
                                        </template>                                                         
                                    </vue-good-table>
                                    <div class="row text-center">
                                        <div class="col-12 pt-10">
                                            <button class="btn btn-primary btn-sm" :disabled="color_selected2.length == 0" @click.prevent="verRecord"><span class="btn-label"><i class="la la-medkit"></i></span>Ver Record</button>
                                        </div>
                                    </div>                                    
                                </div>
                            </div>

                        </div>
                    </div>
                </div> 
                <div class="col-3 pl-0">
                    <div class="card">
                        <div class="card-header">
                            <p class="form-control-static text-danger text-right title mb-0">Tx Pendientes : {{ TxPendientes}}</p>  
                            <p class="form-control-static text-right title mb-0">Saldo disponible : {{ MontoSaldoTotal | fixed}}</p>                           
                        </div>
                        <div class="card-body">
                            <button class="btn btn-primary btn-block btn-sm" @click.prevent="pagoAdelantado"><span class="btn-label"><i class="la la-money"></i></span>Pago Adelantado</button>
                            <button class="btn btn-primary btn-block btn-sm" @click.prevent="verOdontograma"><span class="btn-label"><i class="la la-list-ul"></i></span>Ver Odontograma</button>
                            <button class="btn btn-primary btn-block btn-sm" @click.prevent="verRecord"><span class="btn-label"><i class="la la-pencil-square"></i></span>Record de Atención</button>
                            <button class="btn btn-primary btn-block btn-sm"><span class="btn-label"><i class="la la-calculator"></i></span>Estado de Cuenta</button>             
                            <button class="btn btn-primary btn-block btn-sm" @click.prevent="CargaOdontograma"><span class="btn-label"><i class="la la-print"></i></span>Imprimir Presupuesto</button>
                        </div>
                    </div>
                </div>
            </div>                                 
            <div class="row">
                <div class="col-12">
                    <p>Total Abonado Soles : <span class="font-weight-bold">{{ PagoTotalSoles}}</span></p>
                    <p>Total Abonado Dolares : <span class="font-weight-bold">{{ PagoTotalDolares}}</span></p>
                </div> 
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-sm table-head-bg-info table-bordered-bd-info">
                        <thead>
                            <tr>
                                <th scope="col" class="text-center">Nº</th>
                                <th scope="col">Doc</th>
                                <th scope="col">Número</th>
                                <th scope="col">Fecha</th>    
                                <th scope="col" align="right">Monto</th>                                                                                                                      
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(pago, index) in PagosPresupuestoOperatoriaById" :key="pago.id">
                                <th width="10%" align="center" scope="row" class="text-center">{{ index+1 }}</th>
                                <td width="15%">{{ pago.tipodocumento.abreviatura}}</td>
                                <td width="25%">{{ pago.serie + '-' + pago.numero}}</td>  
                                <td width="25%">{{ pago.fecha_pago}}</td> 
                                <td width="25%" align="right">{{ parseFloat(pago.total).toFixed(2)}}</td>                                                                                                                       
                            </tr>
                            <tr v-if="PagosPresupuestoOperatoriaById.length == 0">
                                <td colspan="8" class="text-center">NO HAY SERVICIOS CARGADOS ...</td>                                           
                            </tr>
                        </tbody>
                    </table> 
                </div>                               
            </div>          
        </div> 
        <!-- PAGE CONTENT MODAL ATENCIONES-->  
        <modal name="record_atencion" :width="'65%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de cargos -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Realización de Tratamientos</div>
                    </div>
                    <div class="card-body">
                        <div v-for="rec in seleccionados" :key="rec.id">
                            <!-- Cabecera de los servicios-->
                            <div class="row">
                                <div class="col-7">
                                    <p class="form-control-static"><span class="font-weight-bold">Tratamiento : </span>{{ rec.letras + ' / ' + rec.tarifario.servicio.nombre_servicio }}</p>
                                </div>
                                <div class="col-3">
                                    <p class="form-control-static"><span class="font-weight-bold">Estado : </span>
                                        <span class="badge badge-warning" v-if="rec.realizado == 1">Pendiente</span>
                                        <span class="badge badge-primary" v-if="rec.realizado == 2">En Proceso</span>
                                        <span class="badge badge-success" v-if="rec.realizado == 3">Terminado</span>
                                    </p>
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-primary btn-xs float-right" v-tooltip.top="'Agregar Evolución'" @click.prevent="AgregaEvolucion(rec.id)"><i class="la la-plus"></i></button>
                                    <button class="btn btn-success btn-xs float-right mr-10" v-tooltip.top="'Finalizar Tratamiento'" @click.prevent="finalizarTratamiento(rec.id)"><i class="la la-check"></i></button>
                                </div>
                            </div>
                            <!-- Record de Atenciones -->
                            <template v-if="rec.recordatencionoperatorias.length > 0">
                                <div class="row" v-for="(ate, index) in rec.recordatencionoperatorias" :key="ate.id">
                                    <div class="col-1 text-right">
                                        {{ index+1 }}
                                    </div>
                                    <div class="col-11">
                                        <p class="form-control-static mb-0"><span class="font-weight-bold">Fecha de Registro :</span>{{ ate.fecha_realizacion }}</p>
                                        <p class="form-control-static"><span class="font-weight-bold">Descripcion :</span>{{ ate.descripcion }}</p>
                                        <p class="form-control-static" v-if="ate.laboratorio_id != null"><span class="font-weight-bold text-danger">Laboratorio Asignado : </span> {{ getLaboratorio(ate.laboratorio_id) }}</p>
                                    </div>
                                </div>
                            </template>
                            <div class="row" v-if="rec.recordatencionoperatorias.length == 0">
                                <div class="col-12 text-center">
                                    <p class="form-control-static">No hay evoluciones registradas</p>
                                </div>
                            </div>                        
                            <!-- Nuevo Record -->
                            <transition name="expand">               
                                <div class="row" v-if="rec.id == numid">
                                    <div class="col-12">                                    
                                        <div class="form-group form-group-default">
                                            <label for="descripcion" class="text-primary font-weight-bold">Descripcion</label>
                                            <textarea name="descripcion" id="descripcion" rows="4" v-model="dataServicio.descripcion[rec.id]"></textarea>
                                            <div class="row">
                                                <div class="col-6" v-if="rec.tarifario.servicio.laboratorioservicios.length > 0">
                                                    <label for="laboratorio" class="text-primary font-weight-bold pt-10">{{ rec.laboratorio_id == null ? 'Asignar Laboratorio :' : 'Laboratorio Asignado :'}}</label>
                                                    <div class="select2-input">
                                                        <select id="laboratorio" name="laboratorio" class="col-8 form-control form-control-sm border" v-model="dataServicio.laboratorioservicio_id" @change="cambioLaboratorio">
                                                            <option value="">--seleccione--</option>
                                                            <option v-for="lab in rec.tarifario.servicio.laboratorioservicios" :value="lab.id" :key="lab.id">
                                                                {{ lab.laboratorio.nombre_laboratorio}}
                                                            </option>
                                                        </select>
                                                    </div> 
<!--                                                     <div class="text-primary font-weight-bold" v-if="rec.laboratorio_id != null">
                                                        <label for="descripcion" class="text-danger font-weight-bold">{{ rec.laboratorio.nombre_laboratorio}}</label>
                                                    </div>   -->                                                  
                                                </div>
                                                <div class="col-6" v-if="rec.tarifario.servicio.materialservicios.length > 0">
                                                    <label for="material" class="text-primary font-weight-bold pt-10">{{ rec.material_id == null ? 'Asignar Material :' : 'Material Asignado :'}}</label>
                                                    <div class="select2-input" v-if="rec.material_id == null">
                                                        <select id="material" name="material" class="col-8 form-control form-control-sm border" v-model="dataServicio.materialservicio_id" @change="cambioMaterial">
                                                            <option value="">--seleccione--</option>
                                                            <option v-for="mat in rec.tarifario.servicio.materialservicios" :value="mat.id" :key="mat.id">
                                                                {{ mat.material.nombre_material}}
                                                            </option>
                                                        </select>
                                                    </div> 
                                                    <div class="text-primary font-weight-bold" v-if="rec.material_id != null">
                                                        <label for="descripcion" class="text-danger font-weight-bold">{{ rec.material.nombre_material}}</label>
                                                    </div>                                                     
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-danger btn-sm float-right" @click.prevent="numid = 0"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                                            <button type="button" class="btn btn-primary btn-sm float-right mr-10" @click.prevent="GrabarRecord(rec)" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                                        </div>                                                                                     
                                    </div>
                                </div>
                            </transition>
                        </div>  
                    </div>
                    <div class="card-action">
                        <button class="btn btn-warning float-right" @click="$modal.hide('record_atencion')"><span class="btn-label"><i class="la la-times-circle"></i> Salir</span></button>
                    </div>
                </div>
            <!-- /. form de registro de cargos -->
        </modal>     
        <!-- PAGE CONTENT MODAL PAGO DIRECTO-->  
        <modal name="pago_directo" :width="'70%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de pago directo -->
                <div class="card mb-0">
                    <div class="card-header pb-0">
                        <div class="card-title">
                            <p class="float-left font-weight-bold">
                                PAGO TOTAL : {{ dataPresupuesto.costo_total }}
                            </p>
                            <p class="float-right font-weight-bold">
                                TIPO DE CAMBIO : {{ dataPresupuesto.tipo_cambio }}
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="container border border-default pl-0 pr-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="moneda" class="text-primary font-weight-bold">Moneda :</label>
                                                <div class="select2-input">
                                                    <select id="moneda" name="moneda" class="form-control form-control-sm" v-model="dataPago.moneda_id" @change="cambioMoneda()">
                                                        <option value="">--seleccione--</option>
                                                        <option v-for="mon in monedas" :value="mon.id" :key="mon.id">
                                                            {{ mon.nombre_moneda}}
                                                        </option>
                                                   </select>
                                                </div>                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group pt-0">
                                                <label for="basic" class="text-primary font-weight-bold">Tipo de Pago :</label>
                                                <div class="select2-input">
                                                    <select id="basic" name="basic" class="form-control form-control-sm" v-model="dataPago.modo" @change="cambioModoPago">
                                                        <option value="">--seleccione--</option>
                                                        <option v-for="tip in tipopagos" :value="tip.id" :key="tip.id">
                                                            {{ tip.descripcion}}
                                                        </option>
                                                   </select>
                                                </div>                                            
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="row" v-if="dataPago.modo == 1 || dataPago.modo == 3">
                                        <div class="col-7 pr-0">
                                            <div class="form-group pt-0 pr-0 pb-0 text-right font-weight-bold">
                                                <p class="form-control-static mb-5">EFECTIVO</p>                                            
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group pt-0">
                                                <input type="number" step="0.01" id="valor_efectivo" class="form-control form-control-sm text-right" v-model="dataPago.monto_efectivo" placeholder="0.00" :disabled="dataPago.modo == 1">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" v-if="dataPago.modo == 2 || dataPago.modo == 3">
                                        <div class="col-7 pr-0">
                                            <div class="form-group pt-0 pr-0">
                                                <label for="tarjeta" class="text-primary font-weight-bold">Tarjeta :</label>
                                                <div class="select2-input">
                                                    <select id="tarjeta" name="tarjeta" class="form-control form-control-sm" v-model="dataPago.tipopago_id">
                                                        <option value="">--seleccione--</option>
                                                        <option v-for="tar in Tarjetas" :value="tar.id" :key="tar.id">
                                                            {{ tar.descripcion}}
                                                        </option>
                                                   </select>
                                                </div>                                          
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group pt-20 mt-5">
                                                <input type="number" step="0.01" id="valor_efectivo_tarjeta" class="form-control form-control-sm text-right" v-model="dataPago.monto_tarjeta" placeholder="0.00" :disabled="dataPago.modo == 2">
                                            </div>
                                        </div>
                                    </div> 
                                </div>                                                              
                            </div>
                            <div class="col-7 pl-0">
                                <div class="container border border-default">
                                    <div class="row">
                                        <div class="col-12 pl-10 pr-10">
                                            <div class="form-group pr-0 pl-0">
                                                <label for="documento" class="text-primary font-weight-bold">Documento Multident</label>
                                                <div class="select2-input">
                                                    <select id="documento" name="documento" class="form-control form-control-sm" v-model="dataPago.tipodocumento_id" @change="cambioDocumento()">
                                                        <option value="">--seleccione--</option>
                                                        <option v-for="doc in documentos_contables" :value="doc.id" :key="doc.id">
                                                            {{ doc.descripcion}}
                                                        </option>
                                                   </select>
                                                </div>                                          
                                            </div>                                        
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 pl-0 pr-0">
                                            <div class="form-group pr-0 pt-0">
                                                <label for="ruc" class="text-primary font-weight-bold mb-0">Facturar a:</label>
                                                <input type="text" id="ruc" class="form-control form-control-sm" v-model="dataPago.ruc" disabled>
                                            </div>
                                        </div>
                                        <div class="col-8">
                                            <div class="group-form">
                                                <div class="input-group pt-20">
                                                    <input type="text" class="form-control form-control-sm font-weight-bold" placeholder="Empresa" aria-label="Recipient's username" aria-describedby="button-addon2" v-model="dataPago.empresa" readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary btn-xs mr-5" type="button" id="button-addon2" @click.prevent="$modal.show('empresas')" :disabled="dataPago.tipodocumento_id != 6"><i class="flaticon-multimedia"></i></button>
                                                        <button class="btn btn-primary btn-xs" type="button" id="button-addon3" @click.prevent="LoadFormEmpresa" :disabled="dataPago.tipodocumento_id != 6"><i class="flaticon-add"></i></button>                                    
                                                    </div>
                                                </div>                                              
                                            </div>
                                        </div>
                                    </div>

                                </div>
                                <div class="container border border-default mt-10">
                                    <div class="row">
                                        <div class="col-12 pl-0 pr-0">
                                            <div class="form-group text-right ">
                                                <label for="" class="text-primary font-weight-bold mb-0">TOTAL EN SOLES : {{ dataPago.total}}</label>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-12 pl-0 pr-0">
                                            <div class="form-group pt-0 text-right ">
                                                <label for="" class="text-primary font-weight-bold mb-0">TOTAL EN DOLARES : {{ dataPago.total_dolares}}</label>
                                            </div>
                                        </div> 
                                    </div>                                      
                                    <div class="row">
                                        <div class="col-12 pr-0 pl-0 text-right">
                                            <label for="" class="d-inline text-primary font-weight-bold text-right col-8">ENTREGO EFECTIVO :</label> 
                                            <input type="number" step="0.01" id="valor_efectivo" class="d-inline col-4 form-control text-right form-control-sm mr-10" v-model="entrego_efectivo" :disabled="dataPago.modo == 2" placeholder="0.00">        
                                        </div>                                          
                                    </div>
                                    <div class="row">
                                        <div class="col-12 pl-0 pr-0">
                                            <div class="form-group pt-0 text-right">
                                                <label for="" class="text-primary font-weight-bold mb-0 mt-10">VUELTO : {{ VueltoAdelantado}}</label>
                                            </div>
                                        </div>
                                    </div>                                                                                                        
                                </div>                                
                            </div>
                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary float-right ml-10" @click.prevent="createPago" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-warning float-right" @click="$modal.hide('pago_directo')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de pago directo -->
        </modal>   
        <!-- PAGE CONTENT MODAL PAGO ADELANTADO-->  
        <modal name="pago_adelantado" :width="'60%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de pago adelantado -->
                <div class="card mb-0">
                    <div class="card-header pb-0">
                        <div class="card-title">
                            <p class="float-left font-weight-bold">
                                PAGOS ADELANTADOS
                            </p>
                            <p class="float-right font-weight-bold">
                                TIPO DE CAMBIO : {{ dataPresupuesto.tipo_cambio }}
                            </p>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-5">
                                <div class="container border border-default pl-0 pr-0">
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group">
                                                <label for="basic" class="text-primary font-weight-bold">Moneda :</label>
                                                <div class="select2-input">
                                                    <select id="basic" name="basic" class="form-control form-control-sm" v-model="dataPago.moneda_id" @change="cambioMoneda()">
                                                        <option value="">--seleccione--</option>
                                                        <option v-for="mon in monedas" :value="mon.id" :key="mon.id">
                                                            {{ mon.nombre_moneda}}
                                                        </option>                                                        
                                                    </select>
                                                </div>                                            
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="form-group pt-0">
                                                <label for="basic" class="text-primary font-weight-bold">Tipo de Pago :</label>
                                                <div class="select2-input">
                                                    <select id="basic" name="basic" class="form-control form-control-sm" v-model="dataPago.modo" @change="cambioModoPago">
                                                        <option value="">--seleccione--</option>
                                                        <option v-for="tip in tipopagos" :value="tip.id" :key="tip.id">
                                                            {{ tip.descripcion}}
                                                        </option>
                                                   </select>
                                                </div>                                            
                                            </div>
                                        </div>
                                    </div>                                    
                                    <div class="row" v-if="dataPago.modo == 1 || dataPago.modo == 3">
                                        <div class="col-7 pr-0 pb-15">
                                            <div class="form-group pt-0 pr-0 pb-0 text-right font-weight-bold">
                                                <p class="form-control-static mb-5 text-primary">EFECTIVO</p>                                            
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group pt-0 pb-0">
                                                <input type="number" step="0.01" id="valor_efectivo" class="form-control form-control-sm" v-model="dataPago.monto_efectivo" placeholder="0.00">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" v-if="dataPago.modo == 2 || dataPago.modo == 3">
                                        <div class="col-7 pr-0">
                                            <div class="form-group pt-0 pr-0">
                                                <label for="tarjeta" class="text-primary font-weight-bold">Tarjeta :</label>
                                                <div class="select2-input">
                                                    <select id="tarjeta" name="tarjeta" class="form-control form-control-sm" v-model="dataPago.tipopago_id">
                                                        <option value="">--seleccione--</option>
                                                        <option v-for="tar in Tarjetas" :value="tar.id" :key="tar.id">
                                                            {{ tar.descripcion}}
                                                        </option>                                                        
                                                    </select>
                                                </div>                                          
                                            </div>
                                        </div>
                                        <div class="col-5">
                                            <div class="form-group pt-20 mt-5">
                                                <input type="number" step="0.01" id="valor_efectivo_tarjeta" class="form-control form-control-sm" v-model="dataPago.monto_tarjeta" placeholder="0.00" :disabled="dataPago.tipopago_id == ''">
                                            </div>
                                        </div>
                                    </div> 
                                </div>                                                              
                            </div>
                            <div class="col-7 pl-0">
                                <div class="container border border-default">
                                    <div class="row">
                                        <div class="col-12 pl-10 pr-10">
                                            <div class="form-group pr-0 pl-0">
                                                <label for="documento" class="text-primary font-weight-bold">Documento Multident</label>
                                                <div class="select2-input">
                                                    <select id="documento" name="documento" class="form-control form-control-sm" v-model="dataPago.tipodocumento_id">
                                                        <option value="">--seleccione--</option>
                                                        <option v-for="doc in documentos_contables" :value="doc.id" :key="doc.id">
                                                            {{ doc.descripcion}}
                                                        </option>                                                        
                                                   </select>
                                                </div>                                          
                                            </div>                                        
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-4 pl-0 pr-0">
                                            <div class="form-group pr-0 pt-0">
                                                <label for="ruc" class="text-primary font-weight-bold mb-0">Facturar a:</label>
                                                <input type="text" id="ruc" class="form-control form-control-sm" v-model="dataPago.ruc" readonly>
                                            </div>
                                        </div>
                                        <div class="col-8 pl-5">
                                            <div class="group-form">
                                                <div class="input-group pt-20">
                                                    <input type="text" class="form-control form-control-sm font-weight-bold" placeholder="Empresa" aria-label="Recipient's username" aria-describedby="button-addon2" v-model="dataPago.empresa" readonly>
                                                    <div class="input-group-append">
                                                        <button class="btn btn-primary btn-xs mr-5" type="button" id="button-addon2" @click.prevent="$modal.show('empresas')" :disabled="dataPago.tipodocumento_id != 6"><i class="flaticon-multimedia"></i></button>
                                                        <button class="btn btn-primary btn-xs" type="button" id="button-addon3" @click.prevent="LoadFormEmpresa" :disabled="dataPago.tipodocumento_id != 6"><i class="flaticon-add"></i></button>                                    
                                                    </div>
                                                </div>                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="container border border-default mt-10">
                                    <div class="row">
                                        <div class="col-12 pl-0 pr-0">
                                            <div class="form-group text-right ">
                                                <label for="" class="text-primary font-weight-bold mb-0">TOTAL EN SOLES : {{ TotalSolesAdelantado}}</label>
                                            </div>
                                        </div> 
                                    </div>
                                    <div class="row">
                                        <div class="col-12 pl-0 pr-0">
                                            <div class="form-group pt-0 text-right ">
                                                <label for="" class="text-primary font-weight-bold mb-0">TOTAL EN DOLARES : {{ TotalDolaresAdelantado}}</label>
                                            </div>
                                        </div> 
                                    </div>                                      
                                    <div class="row">
                                        <div class="col-12 pr-0 pl-0 text-right">
                                            <label for="" class="d-inline text-primary font-weight-bold text-right col-8">ENTREGO EFECTIVO :</label> 
                                            <input type="number" step="0.01" id="valor_efectivo" class="d-inline col-4 form-control text-right form-control-sm mr-10" v-model="entrego_efectivo" placeholder="0.00">        
                                        </div>                                          
                                    </div>
                                    <div class="row">
                                        <div class="col-12 pl-0 pr-0">
                                            <div class="form-group pt-0 text-right">
                                                <label for="" class="text-primary font-weight-bold mb-0 mt-10">VUELTO : {{ VueltoAdelantado}}</label>
                                            </div>
                                        </div>
                                    </div>                                                                                                        
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-action pb-15 pt-15">
                        <button class="btn btn-primary float-right ml-10" @click.prevent="createPago" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-warning float-right" @click="$modal.hide('pago_adelantado')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de pago adelantado -->
        </modal>
        <!-- form para seleccionar la empresa -->
        <modal id="empresas" name="empresas" width="50%" height="auto" :scrollable="true" :clickToClose="false">
            <div class="card mb-0">
                <div class="card-header">
                    <div class="card-title d-inline">Seleccione una Empresa</div>
                    <button type="button" class="close d-inline" aria-label="Close" @click.prevent="$modal.hide('empresas')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                     <div class="col">
                        <!-- START DEFAULT DATATABLE -->
                        <vue-good-table
                        :columns="columns_empresas"
                        :rows="empresapacientes"
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
                        @on-row-click="selectEmpresa"
                        max-height="400px"
                        styleClass="vgt-table condensed bordered striped"> 
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'btn'" class="center">
                                <button type="button" data-toggle="tooltip" title="" class="btn btn-primary btn-xs" data-original-title="" @click.prevent="selectEmpresa(props)">
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
        <modal name="reg_empresa" :width="'35%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de empresas -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Registro de Nueva Empresa</div>
                    </div>
                    <div class="card-body">
                        <div class="col-12">
                            <div class="form-group pt-0">
                                <label for="nombre" class="text-primary font-weight-bold">RUC <span class="required-label"> *</span></label>
                                <input type="text" id="ruc" class="form-control form-control-sm border border-primary" maxlength="11" v-model="dataEmpresa.ruc">
                            </div>                            
                        </div>
                        <div class="col-12">
                            <div class="form-group pt-0">
                                <label for="nombre" class="text-primary font-weight-bold">Razón Social <span class="required-label"> *</span></label>
                                <input type="text" id="razonsocial" class="form-control form-control-sm mayusculas border border-primary" v-model="dataEmpresa.razon_social">
                            </div>                            
                        </div>
                        <div class="col-12">
                            <div class="form-group pt-0">
                                <label for="nombre" class="text-primary font-weight-bold">Direccion <span class="required-label"> *</span></label>
                                <input type="text" id="direccion" class="form-control form-control-sm mayusculas border border-primary" v-model="dataEmpresa.direccion">
                            </div>                            
                        </div>                                                  
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary" @click.prevent="createEmpresa" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger" @click="$modal.hide('reg_empresa')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                    </div>
                </div>
            <!-- /. form de registro de empresas -->
        </modal> 
        <!-- Inicio de Odontograma -->
        <div class="row" ref="printMe" style="position:absolute;top:0;left:0;right:0;margin:0 auto;width:100%;z-index:-1;">
            <div class="col-12">
                <p class="form-control-static text-center font-weight-bold mb-0" >BUCAL</p>
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
                                        <p class="form-control-static text-center mb-0" :id="'t'+info.id">{{ info.codigo }}</p>
                                        <input type="text" :id="'d'+info.id" class="texto-dientito" maxlength="3" v-model="dataPresupuesto_Odontograma.text_up_dent[info.id]"> 
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" height="64" :class="info.tipo" width="32" :id="info.id">
                                                <!-- Caras del diente -->
                                                <polygon points="6,38 30,38 24,44 12,44" :style="BuscoCara(info,'V')" /> <!-- CARA 1 Trapecio superior -->
                                                <polygon points="30,38 30,62 24,56 24,44" :style="BuscoCara(info,'M')"/> <!-- CARA 2 Trapecio lateral derecho -->
                                                <polygon points="30,62 6,62 12,56 24,56" :style="BuscoCara(info,'P')" /> <!-- CARA 3 Trapecio inferior -->
                                                <polygon points="6,62 12,56 12,44 6,38" :style="BuscoCara(info,'D')"/> <!-- CARA 4 trapecio lateral izquierdo-->
                                                <polygon points="12,44 24,44 24,56 12,56" :style="BuscoCara(info,'O')" /> <!-- CARA 5 Cuadrado Central -->
                                                <!-- Tratamientos / Estados del diente -->
                                                <polygon points="17,40 19,40 19,60 17,60" :style="BuscoDiente(info,2)" />
                                                <circle cx="18" cy="50" r="10" :style="BuscoDiente(info,3)" />
                                                <polygon points="8,40 8,39 30,61 30,61" :style="BuscoDiente(info,4)" />                                    
                                                <polygon points="30,39 30,39 8,61 8,60" :style="BuscoDiente(info,4)" />
                                                <image v-if="BuscoDiente(info,5) == 'marcadoPernoO'" xlink:href="/img/odontograma/perno4.png" x=-2 y=10 width=26 height=26 class="perno" />
                                                <image v-if="BuscoDiente(info,5) == 'marcadoPernoO_Azul'" xlink:href="/img/odontograma/perno5.png" x=-2 y=10 width=26 height=26 class="perno" />
                                                <path d="M 8,50 a10,10 0 1,1 20,0" :style="BuscoDiente(info,6)" ></path>
                                                <text x=16 y=32 :style="BuscoDiente(info,7)" >S</text>                                                                        
                                                <ellipse cx="18" cy="50" rx="12" ry="7" :style="BuscoDiente(info,8)" />
                                                <line x1="6" y1="50" x2="30" y2="50" :style="BuscoDiente(info,8)" />                                    
                                            </svg>                                                                                                                                            
                                        </div>                                           
                                    </div>                                          
                                </div>
                                                                    
                            </div>
                            <div class="col-6">
                                <div class="row" v-for="i in cuadrante_derecho_superior" :key="i">
                                    <div v-for="info in getDientesByCuadrante(i)" :key="info.id" class="dientito">
                                        <p class="form-control-static text-center mb-0" :id="'t'+info.id">{{ info.codigo }}</p>
                                        <input type="text" name="" :id="'d'+info.id" class="texto-dientito" maxlength="3" v-model="dataPresupuesto_Odontograma.text_up_dent[info.id]"> 
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" height="64" :class="info.tipo" width="32" :id="info.id">
                                                <!-- Caras del Diente -->
                                                <polygon points="6,38 30,38 24,44 12,44" :style="BuscoCara(info,'V')"/> <!-- CARA 1 Trapecio superior -->
                                                <polygon points="30,38 30,62 24,56 24,44" :style="BuscoCara(info,'M')"/> <!-- CARA 2 Trapecio lateral derecho -->
                                                <polygon points="30,62 6,62 12,56 24,56" :style="BuscoCara(info,'P')"/> <!-- CARA 3 Trapecio inferior -->
                                                <polygon points="6,62 12,56 12,44 6,38" :style="BuscoCara(info,'D')"/> <!-- CARA 4 trapecio lateral izquierdo-->
                                                <polygon points="12,44 24,44 24,56 12,56" :style="BuscoCara(info,'O')"/> <!-- CARA 5 Cuadrado Central -->
                                                <!-- Tratamientos / Estados del diente -->
                                                <polygon points="17,40 19,40 19,60 17,60" :style="BuscoDiente(info,2)" />
                                                <circle cx="18" cy="50" r="10" :style="BuscoDiente(info,3)" />
                                                <polygon points="8,40 8,39 30,61 30,61" :style="BuscoDiente(info,4)" />                                    
                                                <polygon points="30,39 30,39 8,61 8,60" :style="BuscoDiente(info,4)" />
                                                <image v-if="BuscoDiente(info,5) == 'marcadoPernoO'" xlink:href="/img/odontograma/perno4.png" x=-2 y=10 width=26 height=26 class="perno" />
                                                <image v-if="BuscoDiente(info,5) == 'marcadoPernoO_Azul'" xlink:href="/img/odontograma/perno5.png" x=-2 y=10 width=26 height=26 class="perno" />
                                                <path d="M 8,50 a10,10 0 1,1 20,0" :style="BuscoDiente(info,6)" ></path>
                                                <text x=16 y=32 :style="BuscoDiente(info,7)" >S</text>                                                                        
                                                <ellipse cx="18" cy="50" rx="12" ry="7" :style="BuscoDiente(info,8)" />
                                                <line x1="6" y1="50" x2="30" y2="50" :style="BuscoDiente(info,8)" />                                    
                                            </svg>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row borde-inferior">
                            <div class="col-12">
                                <p class="form-control-static text-center font-weight-bold mb-0" >LINGUAL</p>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-6 borde-derecho">
                                <div class="row d-flex justify-content-end" v-for="i in cuadrante_izquierdo_inferior" :key="i">
                                    <div v-for="info in getDientesByCuadrante(i)" :key="info.id" class="dientito">
                                        <p class="form-control-static text-center mb-0" :id="'t'+info.id">{{ info.codigo }}</p>
                                        <input type="text" name="" :id="'d'+info.id" class="texto-dientito" maxlength="3" v-model="dataPresupuesto_Odontograma.text_up_dent[info.id]"> 
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" height="64" :class="info.tipo" width="32" :id="info.id">
                                                <!-- Caras del Diente -->
                                                <polygon points="6,38 30,38 24,44 12,44" :style="BuscoCara(info,'V')"/> <!-- CARA 1 Trapecio superior -->
                                                <polygon points="30,38 30,62 24,56 24,44" :style="BuscoCara(info,'M')"/> <!-- CARA 2 Trapecio lateral derecho -->
                                                <polygon points="30,62 6,62 12,56 24,56" :style="BuscoCara(info,'P')"/> <!-- CARA 3 Trapecio inferior -->
                                                <polygon points="6,62 12,56 12,44 6,38" :style="BuscoCara(info,'D')"/> <!-- CARA 4 trapecio lateral izquierdo-->
                                                <polygon points="12,44 24,44 24,56 12,56" :style="BuscoCara(info,'O')"/> <!-- CARA 5 Cuadrado Central -->
                                                <!-- Tratamientos / Estados del diente -->
                                                <polygon points="17,40 19,40 19,60 17,60" :style="BuscoDiente(info,2)" />
                                                <circle cx="18" cy="50" r="10" :style="BuscoDiente(info,3)" />
                                                <polygon points="8,40 8,39 30,61 30,61" :style="BuscoDiente(info,4)" />                                    
                                                <polygon points="30,39 30,39 8,61 8,60" :style="BuscoDiente(info,4)" />
                                                <image v-if="BuscoDiente(info,5) == 'marcadoPernoO'" xlink:href="/img/odontograma/perno4.png" x=-2 y=10 width=26 height=26 class="perno" />
                                                <image v-if="BuscoDiente(info,5) == 'marcadoPernoO_Azul'" xlink:href="/img/odontograma/perno5.png" x=-2 y=10 width=26 height=26 class="perno" />
                                                <path d="M 8,50 a10,10 0 1,1 20,0" :style="BuscoDiente(info,6)" ></path>
                                                <text x=16 y=32 :style="BuscoDiente(info,7)" >S</text>                                                                        
                                                <ellipse cx="18" cy="50" rx="12" ry="7" :style="BuscoDiente(info,8)" />
                                                <line x1="6" y1="50" x2="30" y2="50" :style="BuscoDiente(info,8)" />                                    
                                            </svg>
                                        </div>
                                    </div>
                                </div>                            
                            </div>
                            <div class="col-6">
                                <div class="row" v-for="i in cuadrante_derecho_inferior" :key="i">
                                    <div v-for="info in getDientesByCuadrante(i)" :key="info.id" class="dientito">
                                        <p class="form-control-static text-center mb-0" :id="'t'+info.id">{{ info.codigo }}</p>
                                        <input type="text" name="" :id="'d'+info.id" class="texto-dientito" maxlength="3" v-model="dataPresupuesto_Odontograma.text_up_dent[info.id]"> 
                                        <div>
                                            <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" height="64" :class="info.tipo" width="32" :id="info.id">
                                                <!-- Caras del Diente-->
                                                <polygon points="6,38 30,38 24,44 12,44" :style="BuscoCara(info,'V')"/> <!-- CARA 1 Trapecio superior -->
                                                <polygon points="30,38 30,62 24,56 24,44" :style="BuscoCara(info,'M')"/> <!-- CARA 2 Trapecio lateral derecho -->
                                                <polygon points="30,62 6,62 12,56 24,56" :style="BuscoCara(info,'P')"/> <!-- CARA 3 Trapecio inferior -->
                                                <polygon points="6,62 12,56 12,44 6,38" :style="BuscoCara(info,'D')"/> <!-- CARA 4 trapecio lateral izquierdo-->
                                                <polygon points="12,44 24,44 24,56 12,56" :style="BuscoCara(info,'O')"/> <!-- CARA 5 Cuadrado Central -->
                                                <!-- Tratamientos / Estados del diente -->
                                                <polygon points="17,40 19,40 19,60 17,60" :style="BuscoDiente(info,2)" />
                                                <circle cx="18" cy="50" r="10" :style="BuscoDiente(info,3)" />
                                                <polygon points="8,40 8,39 30,61 30,61" :style="BuscoDiente(info,4)" />                                    
                                                <polygon points="30,39 30,39 8,61 8,60" :style="BuscoDiente(info,4)" />
                                                <image v-if="BuscoDiente(info,5) == 'marcadoPernoO'" xlink:href="/img/odontograma/perno4.png" x=-2 y=10 width=26 height=26 class="perno" />
                                                <image v-if="BuscoDiente(info,5) == 'marcadoPernoO_Azul'" xlink:href="/img/odontograma/perno5.png" x=-2 y=10 width=26 height=26 class="perno" />
                                                <path d="M 8,50 a10,10 0 1,1 20,0" :style="BuscoDiente(info,6)" ></path>
                                                <text x=16 y=32 :style="BuscoDiente(info,7)" >S</text>                                                                        
                                                <ellipse cx="18" cy="50" rx="12" ry="7" :style="BuscoDiente(info,8)" />
                                                <line x1="6" y1="50" x2="30" y2="50" :style="BuscoDiente(info,8)" />                                    
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
        <!-- Fin de Odontograma -->                                         
    </div>    
</template>
<script>
import mixin from '../../../mixins.js'
import  {_} from 'vue-underscore'
import jsPDF from 'jspdf'
import html2canvas from 'html2canvas'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'ver-ppto-operatoria',
    mixins: [mixin],  
    created(){
        this.$store.dispatch('LOAD_EMPRESAPACIENTES_LIST')        
        this.$store.dispatch('LOAD_LABORATORIOSERVICIOS_LIST')   
        this.$store.dispatch('LOAD_MATERIALSERVICIOS_LIST')              
        this.$store.dispatch('LOAD_TIPOPAGOS_LIST') 
        this.$store.dispatch('LOAD_PAGOS_LIST')
        this.$store.dispatch('LOAD_TIPOCAMBIOS_LIST') 
        this.$store.dispatch('LOAD_MONEDAS_LIST') 
        this.$store.dispatch('LOAD_LABORATORIOS_LIST') 
        this.$store.dispatch('LOAD_MATERIALES_LIST')         
        //this.dataDetalleOperatoria = _.clone(this.presupuestoOperatoriaById.presupuestosoperatoriasdetalles)
        this.dataPaciente = {
            id:this.presupuestoOperatoriaById.paciente_id,
            nombre_completo:this.presupuestoOperatoriaById.paciente.nombre_completo,
            historiaclinica:this.presupuestoOperatoriaById.paciente.historiaclinica,
            empresa:this.presupuestoOperatoriaById.poliza_id == null ? '-' : this.presupuestoOperatoriaById.poliza.empresapaciente.razon_social,
            plan:this.presupuestoOperatoriaById.plan.descripcion,
            aseguradora:this.presupuestoOperatoriaById.poliza_id == null ? '-' : this.presupuestoOperatoriaById.poliza.plane.descripcion,
            fecha:moment(this.presupuestoOperatoriaById.fecha_registro).format('DD-MM-YYYY'),
            tipocambio:this.presupuestoOperatoriaById.tipocambio.tipo_cambio,
            empleado_id:this.presupuestoOperatoriaById.empleado_id,
            empleado:this.presupuestoOperatoriaById.empleado.nombre_completo,
            deducible:this.presupuestoOperatoriaById.poliza_id == null ? '0' : this.presupuestoOperatoriaById.poliza.deducible,
            coaseguro:this.presupuestoOperatoriaById.poliza_id == null ? '0' : this.presupuestoOperatoriaById.poliza.coaseguro,
            tipo_presupuesto: this.presupuestoOperatoriaById.tipo_presupuesto            
        } 
    },
    mounted(){
        //this.CargaOdontograma()
    },
    data(){
        return {
            isLoading: false,
            fullPage: true,

            IconClass : 'la la-cloud-download',
            ShowIcon : false,
            labelButton: 'Grabar Datos', 

            columns: [
                {
                label: 'Pieza',
                field: 'letras',               
                width:'15%',
                }, 
                {
                label: 'Servicio',
                field: 'tarifario.servicio.nombre_servicio',           
                width:'40%',
                },
                {
                label: 'Pagado',
                field: 'pagado',
                thClass: 'center',
                tdClass: 'center',                
                width:'15%',
                },                 
                {
                label: 'Estado',
                field: 'realizado', 
                thClass: 'center',
                tdClass: 'center',                               
                width:'20%',
                },                                                                                                                                                                                                                       
                {
                label: 'Total',
                field: 'costo',
                type:'decimal',
                width:'10%',  
                }                               
            ],
            columns2: [
                {
                label: 'Pieza',
                field: 'letras',               
                width:'15%',
                }, 
                {
                label: 'Servicio',
                field: 'tarifario.servicio.nombre_servicio',           
                width:'50%',
                },                
                {
                label: 'Estado',
                field: 'realizado', 
                thClass: 'center',
                tdClass: 'center',                               
                width:'25%',
                },                                                                                                                                                                                                                       
                {
                label: 'Total',
                field: 'costo',
                type:'decimal',
                width:'10%',  
                }                               
            ],

            columns_empresas: [
                {
                label: 'RUC',
                field: 'ruc',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },                
                width:'20%',
                },                 
                {
                label: 'Razón Social',
                field: 'razon_social',
                filterOptions: {
                    enabled: true, 
                    placeholder: 'Buscar', 
                },
                width:'60%',
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
            dataPaciente:{
                id:'',
                nombre_completo:'',
                historiaclinica:'',
                empresa:'',
                plan:'',
                aseguradora:'',
                empleado:'',
                fecha:'',
                tipocambio:'',
                empleado_id:'',
                empleado:'',
                deducible:'',
                coaseguro:'',
                tipo_presupuesto:''
            },
            dataRecord:{
                presupuestooperatoriadetalle_id:'',
                fase_id:'',
                descripcion:'',
                realizado:'',
                comentario:'',
                empleado_id:'',
                fecha_realizacion:'',
                user_id:'',
                laboratorio_id:'',
                monto_lab:0.00,
                material:'',
                servicio_id:'',
                sede_id:'',
                laboratorioservicio_id:''
            },
            dataDetalleOperatoria:[],
            seleccionados:[],
            color_selected:[],
            color_selected2:[],
            dataServicio:{
                detalle:'',
                estado:'',
                descripcion:[],
                laboratorioservicio_id:'',
                laboratorio_id:'',
                nombre_laboratorio:'',
                monto_lab:0.00,
                materialservicio_id:'',
                material_id:'',
                nombre_material:'',                
                monto_mat:0.00
            },
            dataPresupuesto:{
                costo_total:'',
                tipo_cambio:'',
                costo_dolares:''
            },
            dataPresupuesto_Odontograma:{
                fecha_registro:'',
                paciente_id:'',
                empleado_id:'',
                moneda_id:'',
                numero_prespuesto:'',
                plan_id:'',
                poliza_id:'',
                tipo_presupuesto:'',
                estado_seguimiento:'',
                observaciones:'',
                estadopresupuesto_id:'',
                tipocambio_id:'',
                sede_id:'',
                pago_cliente:'',
                pago_aseguradora:'',
                pago_total:'',
                user_id:'',
                saldo:'',
                detalle:[],
                ausentes:[],
                text_up_dent:[]
            },
            dataTratamiento:{
                id:'',
                idppto:'',
                tarifario_id:'',
                diente_id: '',
                diente_codigo: '',
                texto_diente:'',
                caras: '',
                simbologia: '',
                letras : '',
                servicio_id : '',
                nombre_servicio : '',
                costo_base:'',
                costo : '',
                moneda_id:'',
                nombre_moneda : '',
                descuento:'',
                activo:''
            },                        
            dataPago: {
                sede_id:'',
                ptoventa:'',
                origen:'',
                presupuestooperatoria_id:'',
                presupuestoortodoncia_id:'',
                empleado_id:'',
                empresapaciente_id:'',
                empresa:'',
                ruc:'',
                tipodocumento_id:'',
                serie:'',
                numero:'',
                deducible:'',
                coaseguro:'',
                cliente:'',
                valor:'',
                igv:'',
                total:'',
                total_dolares:'',
                tipopago_id:'',
                user_id:'',
                fecha_pago:'',
                transferencia:'',
                ultimos_digitos:'',
                lote:'',
                monto_efectivo:0.00,
                monto_tarjeta:0.00,
                moneda_id:'',
                tipocambio_id:'',
                tipo:'',
                paciente_pago:'',
                disponible:'',
                vuelto:0.00,
                indicador:'',
                disponible_efectivo:'',
                disponible_tarjeta:'',
                contable:'',
                fecha_descarga:'',
                modo:1,     // 1.efectivo   2.tarjeta   3.mixto 
                presupuestodetalles:[]
            },
            numid:'',
            documentos_contables : [
                { id: 5 , descripcion: 'BOLETA DE VENTA'},
                { id: 6 , descripcion: 'FACTURA'},
                { id: 7 , descripcion: 'RECIBO'},
                { id: 9 , descripcion: 'REGULARIZACION SISTEMA ANTERIOR'}
            ],
            tipopagos : [
                { id: 1 , descripcion: 'Efectivo'},
                { id: 2 , descripcion: 'Tarjeta'},
                { id: 3 , descripcion: 'Mixto'}
            ],
            dataEmpresa : {
                ruc:'',
                razon_social:'',
                ubigeo_id:'',
                direccion:'',
                telefono:'',
                celular:'',
                email:'',
                user_id:'',
                codigo:'',
            }, 
            //modo_pago:1 ,   // modo 1-efectivo 2-tarjeta 3-mixto   
            entrego_efectivo: 0.00, 
            // variables del odontograma
            lista_general_presupuesto:[],             
            odontograma:[],
            cuadrante_izquierdo_superior:[1,5],
            cuadrante_derecho_superior:[2,6],
            cuadrante_izquierdo_inferior:[8,4],
            cuadrante_derecho_inferior:[7,3],   
            list_dent_missing:[], 
            // Estilos del Odontograma para imprimir
            diente: {
                cursor:'pointer', 
                cursor: 'hand' ,        
                fillOpacity:'0',
                stroke:'dimgrey',
                strokeWidth:'1px'                
            },

            deshabilitado: {
                fill:'dimgrey',
                stroke: 'rgb(71, 71, 71)',
                strokeWidth:'1px',
                opacity: '0.3'
            },

            invisible: {
                fill:'none',
                opacity: '0'                
            },
            
            marcadoRojo: {
                cursor:'pointer', 
                cursor: 'hand' ,          
                fill:'red',
                stroke:'dimgrey',
                strokeWidth:'1px'
            },

            marcadoAzul: {
                cursor:'pointer', 
                cursor: 'hand' ,          
                fill:'blue',
                stroke:'dimgrey',
                strokeWidth:'1px'
            },

            marcadoCoronaO: {
                cursor:'pointer', 
                cursor: 'hand' , 
                fill:'none',
                stroke:'red',
                strokeWidth:'2px'                          
            },
            
            marcadoCoronaO_Azul: {
                cursor:'pointer', 
                cursor: 'hand' , 
                fill:'none',
                stroke:'blue',
                strokeWidth:'2px'                          
            },            
            
            marcadoEndodonciaO: {
                cursor:'pointer', 
                cursor: 'hand' ,          
                fill:'red',
                stroke:'red',
                strokeWidth:'1px'                 
            },

            marcadoEndodonciaO_Azul: {
                cursor:'pointer', 
                cursor: 'hand' ,          
                fill:'blue',
                stroke:'blue',
                strokeWidth:'1px'                 
            },  

            marcadoExodonciaO: {
                cursor:'pointer', 
                cursor: 'hand' ,          
                fill:'red',
                stroke:'red',
                strokeWidth:'1px'                      
            },

            marcadoExodonciaO_Azul: {
                cursor:'pointer', 
                cursor: 'hand' ,          
                fill:'red',
                stroke:'blue',
                strokeWidth:'1px'                      
            },            
            
            marcadoIonomeroO: {
                cursor:'pointer', 
                cursor: 'hand' ,         
                stroke : 'red',
                fillOpacity : '0',
                strokeWidth: '2px'               
            },

            marcadoIonomeroO_Azul: {
                cursor:'pointer', 
                cursor: 'hand' ,         
                stroke : 'blue',
                fillOpacity : '0',
                strokeWidth: '2px'               
            },            
            
            marcadoSellanteO: {
                cursor:'pointer', 
                cursor: 'hand' ,          
                fontWeight: 'normal',
                fill : 'red',
                stroke : 'red',
                strokeWidth: '1px',
                fontSize : '2em'             
            },

            marcadoSellanteO_Azul: {
                cursor:'pointer', 
                cursor: 'hand' ,          
                fontWeight: 'normal',
                fill : 'blue',
                stroke : 'blue',
                strokeWidth: '1px',
                fontSize : '2em'             
            },            
            
            marcadoGeneralO: {
                cursor:'pointer', 
                cursor: 'hand' ,         
                fill:'none',
                stroke:'red',
                strokeWidth:'1px'        
            },

            marcadoGeneralO_Azul: {
                cursor:'pointer', 
                cursor: 'hand' ,         
                fill:'none',
                stroke:'blue',
                strokeWidth:'1px'        
            },                         
            
            errors:[]
            
        }
    },
    computed: {
        ...mapState(['user_system','sede_system','monedas','empresapacientes','laboratorioservicios','materialservicios','laboratorios','materiales']),
        ...mapGetters(['getDientesByCuadrante','getMedicos','getTipoCambioHoy','getPresupuestoOperatoriaById','getTipopagosForma','getPagosPresupuestoOperatoriaById']), 
        presupuestoOperatoriaById(){
            if(this.$route.params.idpresupuesto != undefined){
                return this.getPresupuestoOperatoriaById(this.$route.params.idpresupuesto)                 
            }
            return []        
        },
        items_descargados(){
            return this.presupuestoOperatoriaById.presupuestosoperatoriasdetalles.filter(pd => pd.descargado == 1)
        },
        items_sindescarga(){
            return this.presupuestoOperatoriaById.presupuestosoperatoriasdetalles.filter(pd => pd.descargado == 0)
        },
        PagosPresupuestoOperatoriaById(){
            return this.getPagosPresupuestoOperatoriaById(this.$route.params.idpresupuesto)
        },
        Tarjetas(){
            return this.getTipopagosForma(2)
        },
        PagoTotalSoles(){
            let totpagos = 0
            if(this.PagosPresupuestoOperatoriaById.length > 0){
                _.each(this.PagosPresupuestoOperatoriaById, function(value,key){
                    if(value.moneda_id == 1){
                        totpagos += parseFloat(value.total)
                    }
                })
            }
            return parseFloat(totpagos).toFixed(2)
        },
        PagoTotalDolares(){
            let totpagos = 0
            if(this.PagosPresupuestoOperatoriaById.length > 0){
                _.each(this.PagosPresupuestoOperatoriaById, function(value,key){
                    if(value.moneda_id == 2){
                        totpagos += parseFloat(value.total_dolares)
                    }
                })
            }
            return parseFloat(totpagos).toFixed(2)
        },
        TxPendientes(){
            let pagados = 0
            let pendientes = 0
            _.each(this.presupuestoOperatoriaById.presupuestosoperatoriasdetalles, function(value,key){
                if(value.pagado == 1){
                    pagados += parseFloat(value.costo)
                }
            })
            pendientes = parseFloat(this.presupuestoOperatoriaById.pago_total) - parseFloat(pagados)
            return parseFloat(pendientes).toFixed(2)
        },
        MontoSaldoTotal(){
            let saldo = this.presupuestoOperatoriaById.saldo == null ? 0 : this.presupuestoOperatoriaById.saldo
            let saldo_tarjeta = this.presupuestoOperatoriaById.saldo_tarjeta == null ? 0 : this.presupuestoOperatoriaById.saldo_tarjeta
            let saldo_total = parseFloat(saldo) + parseFloat(saldo_tarjeta)
            return saldo_total
        },
        TotalSolesAdelantado(){
            let tot = 0
            if(this.dataPago.tipo == 1) return;             
            if(this.dataPago.moneda_id == 1){
                tot = parseFloat(this.dataPago.monto_efectivo) + parseFloat(this.dataPago.monto_tarjeta)
            }else{
                if(this.getTipoCambioHoy == undefined){
                    tot = parseFloat(this.dataPago.monto_efectivo) + parseFloat(this.dataPago.monto_tarjeta) 
                }else{
                    tot = (parseFloat(this.dataPago.monto_efectivo) * parseFloat(this.getTipoCambioHoy.tipo_cambio)) + (parseFloat(this.dataPago.monto_tarjeta) * parseFloat(this.getTipoCambioHoy.tipo_cambio))
                }               
            }
            this.dataPago.total = parseFloat(tot).toFixed(2)
            return parseFloat(tot).toFixed(2) 
        },
        TotalDolaresAdelantado(){
            let tot = 0
            if(this.dataPago.tipo == 1) return;             
            if(this.dataPago.moneda_id == 1){
                if(this.getTipoCambioHoy == undefined){
                    tot = parseFloat(this.dataPago.monto_efectivo) + parseFloat(this.dataPago.monto_tarjeta)
                }else{
                    tot = (parseFloat(this.dataPago.monto_efectivo) / parseFloat(this.getTipoCambioHoy.tipo_cambio)) + (parseFloat(this.dataPago.monto_tarjeta) / parseFloat(this.getTipoCambioHoy.tipo_cambio))
                }              
            }else{
                tot = parseFloat(this.dataPago.monto_efectivo) + parseFloat(this.dataPago.monto_tarjeta)
            }
            this.dataPago.total_dolares = parseFloat(tot).toFixed(2)
            return parseFloat(tot).toFixed(2)
        },
        VueltoAdelantado(){
            let vuelto = parseFloat(this.entrego_efectivo) - parseFloat(this.dataPago.monto_efectivo)
            if(parseInt(this.entrego_efectivo) == 0){
                return 0
            }
            return parseFloat(vuelto).toFixed(2)
        }              
    }, 
    watch:{
        'dataPago.monto_efectivo' (newVal,oldVal){
            if(newVal != 0){
                if(this.dataPago.moneda_id == 1){
                    this.dataPago.vuelto = (parseFloat(this.dataPago.monto_efectivo) + parseFloat(this.dataPago.monto_tarjeta)) - parseFloat(this.dataPago.total)
                }else{
                    this.dataPago.vuelto = (parseFloat(this.dataPago.monto_efectivo) + parseFloat(this.dataPago.monto_tarjeta)) - parseFloat(this.dataPago.total_dolares)

                }
                this.dataPago.vuelto = parseFloat(this.dataPago.vuelto).toFixed(2)
                if(this.dataPago.tipo == 2){
                    this.entrego_efectivo = this.dataPago.monto_efectivo
                }
            }
        },
        'dataPago.monto_tarjeta' (newVal,oldVal){
            if(newVal != 0){
                if(this.dataPago.moneda_id == 1){
                    this.dataPago.vuelto = (parseFloat(this.dataPago.monto_efectivo) + parseFloat(this.dataPago.monto_tarjeta)) - parseFloat(this.dataPago.total)
                }else{
                    this.dataPago.vuelto = (parseFloat(this.dataPago.monto_efectivo) + parseFloat(this.dataPago.monto_tarjeta)) - parseFloat(this.dataPago.total_dolares)

                }
                this.dataPago.vuelto = parseFloat(this.dataPago.vuelto).toFixed(2)
            }
        }       
    },
    methods:{
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },        
        selectionChanged(param){
            this.color_selected = param.selectedRows
        },
        selectionChanged2(param){
            this.color_selected2 = param.selectedRows
        },        
        rowStyleClassFn(row){
            let encontrado = this.color_selected.filter(sel => sel.id == row.id)      
            if(encontrado.length > 0){
                return 'seleccionado'
            }
            return 'no-seleccionado'
        },
        rowStyleClassFn2(row){
            let encontrado = this.color_selected2.filter(sel => sel.id == row.id)      
            if(encontrado.length > 0){
                return 'seleccionado'
            }
            return 'no-seleccionado'
        },        
        RealizarTratamiento(){
            this.seleccionados = this.$refs['tabla_detalle'].selectedRows
            this.numid = 0
            this.$modal.show('record_atencion')
        },
        GrabarRecord(param){
            if(param.tarifario.servicio.materialservicios.length > 0){
                let mat = this.materialservicios.find(mat => mat.id == param.tarifario.servicio.materialservicios[0].material_id)
                this.dataServicio.material_id = mat.material_id
                this.dataServicio.monto_mat = mat.material.costo
            }
            this.dataRecord = {
                presupuestooperatoriadetalle_id:param.id,
                fase_id:'',
                descripcion:this.dataServicio.descripcion[param.id],
                realizado:1,
                comentario:'',
                empleado_id:this.dataPaciente.empleado_id,
                fecha_realizacion:moment().format('DD-MM-YYYY hh:mm:ss'),
                user_id:this.user_system.id,
                laboratorio_id:this.dataServicio.laboratorio_id,
                monto_lab:this.dataServicio.monto_lab,
                material_id:this.dataServicio.material_id,
                monto_mat:this.dataServicio.monto_mat,
                servicio_id:param.tarifario.servicio_id,
                sede_id:this.sede_system.id,
                laboratorioservicio_id:this.dataServicio.laboratorioservicio_id,
                fecha_separacion:moment().format('DD-MM-YYYY hh:mm:ss'),
                costo:this.dataServicio.monto_lab,
                tipo:1,     // operatoria
                liquidable:1                         
            }
            var url = '/api/recordatencion-operatorias';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataRecord).then(response => {
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
            let copy_seleccionados = _.clone(this.seleccionados)
            this.seleccionados = []
            this.color_selected = []
            this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST').then(() => {
                this.numid = 0
                let self = this  
                _.each(copy_seleccionados, function(value,key){
                    _.each(self.presupuestoOperatoriaById.presupuestosoperatoriasdetalles, function(value2,key2){
                        if(value2.id == value.id){
                            self.seleccionados.push(value2)
                        }
                    })
                })
            })    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.notificaciones('Nueva atención creada con exito','la la-thumbs-up','success')       
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')           

            });
        },
        finalizarTratamiento(param){
            this.$swal({
                title: 'Desea finalizar este tratamiento?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, Finalizar!'
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true
                        var url = '/api/recordatencion-operatorias/finalizar/' + param
                        axios.put(url,this.dataRecord).then(response=> {
                            let copy_seleccionados = _.clone(this.seleccionados)
                            this.seleccionados = []
                            this.color_selected = []
                            this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST').then(() => {
                                this.numid = 0
                                let self = this  
                                _.each(copy_seleccionados, function(value,key){
                                    _.each(self.presupuestoOperatoriaById.presupuestosoperatoriasdetalles, function(value2,key2){
                                        if(value2.id == value.id){
                                            self.seleccionados.push(value2)
                                        }
                                    })
                                })
                                this.isLoading = false
                            })                             
                        });
                    }else{
                        //
                    }
                });
        },        
        LoadFormEmpresa: function(){  
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')         
            this.nom_emp = ''
            this.dataEmpresa = {
                ruc:'',
                razon_social:'',
                ubigeo_id:'',
                direccion:'',
                telefono:'',
                celular:'',
                email:'',
                user_id:this.user_system.id,
                codigo:'',
            }           
            this.$modal.show('reg_empresa')
        }, 
        createEmpresa: function(){
            var url = '/api/empresapacientes';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataEmpresa).then(response => {
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

            this.$store.dispatch('LOAD_EMPRESAPACIENTES_LIST')    
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('reg_empresa');   
            this.notificaciones('Nueva Empresa creada con exito','la la-thumbs-up','success')       
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           

            });
        },        
        selectEmpresa: function(params){
            this.dataPago.empresapaciente_id = params.row.id
            this.dataPago.empresa = params.row.razon_social
            this.dataPago.ruc = params.row.ruc
            this.$modal.hide('empresas')           
        },        
        pagoDirecto(){
            let self = this
            let list_detalles = []
            let valor_total = 0
            let valor_dolares = 0
            let tipcam = this.getTipoCambioHoy
            if(tipcam == undefined){
                this.notificaciones('Debe registrar el Tipo de cambio de Hoy','la la-thumbs-o-down','danger')
                return
            }            
            this.seleccionados = this.$refs['tabla_detalle'].selectedRows
            this.dataPago.presupuestodetalles = []
            _.each(this.seleccionados, function(value,key){
                if(value.pagado == 0){
                    // verificar si hay valores en dolares para pasarlos a soles
                    if(value.moneda_id == 1){
                        valor_total += parseFloat(value.costo)
                    }else {
                        let newcosto = parseFloat(value.costo) * parseFloat(tipcam.tipo_cambio)
                        valor_total += parseFloat(newcosto)
                    }                    
                    list_detalles.push(value.id)
                }
            })
            valor_total = parseFloat(valor_total).toFixed(2)
            valor_dolares = parseFloat(valor_total) / parseFloat(tipcam.tipo_cambio)
            valor_dolares = parseFloat(valor_dolares).toFixed(2)
            this.dataPresupuesto = {
                costo_total : valor_total,
                tipo_cambio : parseFloat(tipcam.tipo_cambio).toFixed(2),
                costo_dolares : valor_dolares
            }
            this.dataPago = {
                sede_id:1,
                ptoventa:1,
                origen:1,
                presupuestooperatoria_id:this.presupuestoOperatoriaById.id,
                presupuestoortodoncia_id:'',
                empleado_id:this.dataPaciente.empleado_id,
                empresapaciente_id:'',
                empresa:'',
                ruc:'',
                tipodocumento_id:5,
                serie:'01',
                numero:'',
                deducible:'',
                coaseguro:'',
                cliente:'',
                valor:'',
                igv:'',
                total:'',
                total_dolares:'',
                tipopago_id:'',
                user_id:this.user_system.id,
                fecha_pago:moment().format('DD-MM-YYYY hh:mm:ss'),
                transferencia:'',
                ultimos_digitos:'',
                lote:'',
                monto_efectivo:valor_total,
                monto_tarjeta:0.00,
                moneda_id:1,
                tipocambio_id:this.getTipoCambioHoy.id,
                tipo:1,     // 1. directo 2.adelantado
                paciente_pago:'',
                disponible:'',
                vuelto:0.00,
                indicador:'',
                disponible_efectivo:'',
                disponible_tarjeta:'',
                contable:'',
                fecha_descarga:'',
                modo:1,                 // 1. efectivo 2. tarjeta 3. mixto
                presupuestodetalles:[]
            },
            this.dataPago.total = valor_total
            this.dataPago.total_dolares = valor_dolares
            this.dataPago.presupuestodetalles = _.clone(list_detalles)
            if(list_detalles.length == 0){
                this.notificaciones('Los registros seleccionados ya estan pagados','la la-thumbs-o-down','danger')
                return                
            }
            this.entrego_efectivo = 0
            this.$modal.show('pago_directo')            
        },
        pagoAdelantado(){
            let self = this
            let tipcam = this.getTipoCambioHoy            
            //this.dataPago.modo = 1
            if(tipcam == undefined){
                this.notificaciones('Debe registrar el Tipo de cambio de Hoy','la la-thumbs-o-down','danger')
                return
            } 
            this.dataPresupuesto.tipo_cambio = parseFloat(tipcam.tipo_cambio).toFixed(2)
            this.dataPago = {
                sede_id:this.sede_system.id,
                ptoventa:1,
                origen:1,   // 1.operatoria 2.ortodoncia
                presupuestooperatoria_id:this.presupuestoOperatoriaById.id,
                presupuestoortodoncia_id:'',
                empleado_id:this.dataPaciente.empleado_id,
                empresapaciente_id:'',
                empresa:'',
                ruc:'',
                tipodocumento_id:5,
                serie:'01',
                numero:'',
                deducible:'',
                coaseguro:'',
                cliente:'',
                valor:'',
                igv:'',
                total:'',
                total_dolares:'',
                tipopago_id:'',
                user_id:this.user_system.id,
                fecha_pago:moment().format('DD-MM-YYYY hh:mm:ss'),
                transferencia:'',
                ultimos_digitos:'',
                lote:'',
                monto_efectivo:0.00,
                monto_tarjeta:0.00,
                moneda_id:1,    
                tipocambio_id:this.getTipoCambioHoy.id,
                tipo:2,     // 1. directo 2.adelantado
                paciente_pago:'',
                disponible:'',
                vuelto:0.00,
                indicador:'',
                disponible_efectivo:'',
                disponible_tarjeta:'',
                contable:'',
                modo:1,             // 1. efectivo 2. tarjeta 3. mixto
                fecha_descarga:''
            },
            this.entrego_efectivo = 0
            this.$modal.show('pago_adelantado')  
        },
        createPago: function(){
            if(this.dataPago.tipo == 1){    // Pago directo
                let monto_total = parseFloat(this.dataPago.monto_efectivo) + parseFloat(this.dataPago.monto_tarjeta)
                if(parseFloat(this.dataPago.total) > parseFloat(monto_total)){
                    this.notificaciones('El Pago directo no puede ser menor al costo total de los procedimientos','la la-thumbs-o-down','danger')
                    return
                }
            }
            if(this.dataPago.tipo == 2){    // Pago adelantado
                let debe = parseFloat(this.TxPendientes) - parseFloat(this.presupuestoOperatoriaById.saldo)
                if(parseFloat(this.dataPago.total) > parseFloat(debe)){
                    this.notificaciones('El Pago adelantado no puede ser mayor al Costo pendiente del presupuesto','la la-thumbs-o-down','danger')
                    return
                }
            }
            this.dataPago.valor = parseFloat(this.dataPago.total) * 0.82
            this.dataPago.valor = parseFloat(this.dataPago.valor).toFixed(2)
            this.dataPago.igv = parseFloat(this.dataPago.total) * 0.18
            this.dataPago.igv = parseFloat(this.dataPago.igv).toFixed(2)            
            var url = '/api/pagos';
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.post(url, this.dataPago).then(response => {
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
            this.$store.dispatch('LOAD_PAGOS_LIST') 
            this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST')               
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('pago_directo'); 
            this.$modal.hide('pago_adelantado');  
            this.notificaciones('Nuevo Pago creado con exito','la la-thumbs-up','success')       
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')          
            this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')           

            });
        },
        cambioMoneda(){
            if(this.dataPago.moneda_id == 1){
                this.dataPago.monto_efectivo = this.dataPago.total == '' ? 0.00 : this.dataPago.total
            }else{
                this.dataPago.monto_efectivo = this.dataPago.total_dolares == '' ? 0.00 : this.dataPago.total_dolares
            }
            this.dataPago.monto_tarjeta = 0.00
            this.dataPago.tipopago_id = ''            
        },
        cambioDocumento(){
            if(this.dataPago.tipodocumento_id != 6){
                this.dataPago.ruc = ''
                this.dataPago.empresa = ''
                this.dataPago.empresapaciente_id = ''
            }
        },
        descargaTx(){
            let self = this
            let list_detalles = []     
            let faltapago_terminado = false       
            this.seleccionados = this.$refs['tabla_detalle'].selectedRows
            this.dataPago.presupuestodetalles = []
            this.dataPago.fecha_descarga = moment().format('DD-MM-YYYY hh:mm:ss')
            _.each(this.seleccionados, function(value,key){
                if(value.pagado == 0 || value.realizado != 3){
                    faltapago_terminado = true
                }
                if(value.pagado == 1 && value.realizado == 3){
                    list_detalles.push(value.id)
                }
            })  
            if(faltapago_terminado){
                this.notificaciones('Algunos registros no pueden ser descargados ...deben estar pagados y terminados!!','la la-thumbs-o-down','danger')
                return                
            }            
            this.dataPago.presupuestodetalles = _.clone(list_detalles)
            if(list_detalles.length == 0){
                this.notificaciones('Los registros no pueden ser descargados ...deben estar pagados y terminados!!','la la-thumbs-o-down','danger')
                return                
            }
            this.$swal({
                title: 'Desea descargar estos tratamientos?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, Descargar!'
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true
                        var url = '/api/presupuestosoperatoriasdetalles/descargatx/' + this.$route.params.idpresupuesto
                        axios.put(url,this.dataPago).then(response=> {
                            this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST').then(() => {
                                this.$swal(
                                'Descargados!',
                                'los Registros fueron descargados con exito.',
                                'success'
                                )
                                this.isLoading = false
                            })                             
                        });
                    }else{
                        //
                    }
                });
        },
        descargaSaldo(){
            let self = this
            let list_detalles = [] 
            let verif_saldo = 0 
            let sinterminar = false          
            this.seleccionados = this.$refs['tabla_detalle'].selectedRows
            this.dataPago.presupuestodetalles = []
            this.dataPago.fecha_descarga = moment().format('DD-MM-YYYY hh:mm:ss')
            _.each(this.seleccionados, function(value,key){  
                if(value.realizado != 3){
                    sinterminar = true
                }              
                if(value.pagado == 0 && value.realizado == 3){
                    verif_saldo += parseFloat(value.costo)
                    list_detalles.push(value.id)
                }
            })
            if(sinterminar){
                this.notificaciones('Algunos registros no estan terminados ... verifique por favor!!','la la-thumbs-o-down','danger')
                return                
            }            
            this.dataPago.presupuestodetalles = _.clone(list_detalles)
            if(list_detalles.length == 0){
                this.notificaciones('Los registros no pueden ser descargados ... deben estar terminados!!','la la-thumbs-o-down','danger')
                return                
            }
            console.log("saldo",this.MontoSaldoTotal,verif_saldo)
            if(parseFloat(this.MontoSaldoTotal) < parseFloat(verif_saldo)){
                this.notificaciones('El Saldo no cubre el costo de todos los tratamientos seleccionados!!','la la-thumbs-o-down','danger')
                return                 
            }
            this.$swal({
                title: 'Desea descargar estos tratamientos?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, Descargar!'
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true
                        var url = '/api/presupuestosoperatoriasdetalles/descargasaldo/' + this.$route.params.idpresupuesto
                        axios.put(url,this.dataPago).then(response=> {
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
                            this.errors = [];
                            this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST').then(() => {
                                this.$swal(
                                'Descargados!',
                                'los Registros fueron descargados con exito.',
                                'success'
                                )
                                this.isLoading = false
                            })                             
                        });
                    }else{
                        //
                    }
                }).catch(error => {
                    this.isLoading = false
                    this.errors = error.response.data.status;               
                    this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')
                });
        },        
        cambioModoPago(){
            this.dataPago.monto_efectivo = 0
            this.dataPago.monto_tarjeta = 0
            this.dataPago.tipopago_id = ''
            if(this.dataPago.tipo == 1){
                if(this.dataPago.modo == 1){
                    this.dataPago.monto_efectivo = this.dataPresupuesto.costo_total
                }else if(this.dataPago.modo == 2){
                    this.dataPago.monto_tarjeta = this.dataPresupuesto.costo_total
                }
            }
        },
        verOdontograma(){
            this.$router.push({ name: 'ppto-operatoria' , params: { idpresupuesto: this.presupuestoOperatoriaById.id } })           
        },
        verRecord(){
            this.$router.push({ name: 'record-atencion' , params: { idpresupuesto: this.presupuestoOperatoriaById.id } })           
        },        
        CargaOdontograma(){
            let self = this
            let tipo_odontograma = this.presupuestoOperatoriaById.tipo_odontograma
            self.lista_general_presupuesto = []

            if(tipo_odontograma == 1) this.odontograma = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32]
            if(tipo_odontograma == 2) this.odontograma = [33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52]
            if(tipo_odontograma == 3) this.odontograma = [1,2,3,14,15,16,17,18,19,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52]

            this.presupuestoOperatoriaById.presupuestosoperatoriasdetalles.map(function(value, key) {
                let datadet = []
                self.dataTratamiento = {
                    id: value.id,
                    idppto:value.presupuestooperatoria_id,
                    tarifario_id : value.tarifario_id,
                    diente_id: value.diente_id,
                    diente_codigo: value.diente == null ? '--' : value.diente.codigo,
                    texto_diente:value.texto_diente,
                    caras:value.caras == null ? '--' : value.caras,
                    simbologia:value.simbologia_id,
                    letras:value.letras,
                    servicio_id:value.tarifario.servicio_id,
                    nombre_servicio:value.tarifario.servicio.nombre_servicio,
                    costo_base:value.costo_base,
                    costo:value.costo,
                    moneda_id:value.moneda_id,
                    nombre_moneda:value.moneda.nombre_moneda,
                    descuento:value.descuento,
                    realizado:value.realizado,
                    activo:value.activo
                }
                if(self.dataTratamiento.activo){
                    datadet = _.clone(self.dataTratamiento)
                    self.lista_general_presupuesto.push(datadet)
                }   
                if(value.texto_diente != null){
                    self.dataPresupuesto_Odontograma.text_up_dent[value.diente_id] = value.texto_diente
                }                  
            })
            this.presupuestoOperatoriaById.dientes.map(function(value, key) {
                self.list_dent_missing.push(value.id)
                self.odontograma = _.reject(self.odontograma, function(d){ return d == value.id })                    
            })

            //this.createPDF()
            this.$swal({
                title: 'Desea imprimir este Presupuesto?',
                text: "Impresión del Presupuesto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, imprimir!'
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true   
                        self.take(this.$refs.printMe)
                    }
                });            
        }, 
        BuscoDiente(param,numsim){
            //let valor = false
            let self = this
            let valor = this.invisible
            if(this.lista_general_presupuesto.length == 0) return valor
            let serdent = this.lista_general_presupuesto.filter(ser => ser.diente_id == param.id)
            if(serdent.length > 0){
                serdent.map(function(value, key) {
                    if(value.simbologia == numsim){
                        switch (numsim) {
                            case 2 : 
                                valor = value.realizado == 3 ? self.marcadoEndodonciaO_Azul : self.marcadoEndodonciaO 
                                break;                    
                            case 3 : 
                                valor = value.realizado == 3 ? self.marcadoCoronaO_Azul : self.marcadoCoronaO 
                                break;                    
                            case 4 : 
                                valor = value.realizado == 3 ? self.marcadoExodonciaO_Azul : self.marcadoExodonciaO  
                                break;                    
                            case 5 : 
                                valor = value.realizado == 3 ? self.marcadoPernoO_Azul : self.marcadoPernoO  
                                break;                    
                            case 6 : 
                                valor = value.realizado == 3 ? self.marcadoIonomeroO_Azul : self.marcadoIonomeroO 
                                break;
                            case 7 :
                                valor = value.realizado == 3 ? self.marcadoSellanteO_Azul : self.marcadoSellanteO 
                                break;
                            case 8 :
                                valor = value.realizado == 3 ? self.marcadoGeneralO_Azul : self.marcadoGeneralO 
                                break;                    
                        }                         
                    }
                })
            }
            return valor
        },  
        BuscoCara(param,cara){
            let encontrado;
            //let valor = 'deshabilitado'
            let valor = this.deshabilitado
            self = this
            if(this.contains(this.odontograma,param.id)){
                //valor = 'diente'     
                valor = self.diente           
                encontrado = self.lista_general_presupuesto.filter(ser => ser.diente_id == param.id)
                if(encontrado.length > 0){                 
                    encontrado.map(function(value, key) {
                        if((value.simbologia == 1) && (value.caras.indexOf(cara)) >-1) {
                            //valor = 'marcadoRojo marcado'
                            if(value.realizado == 3){
                                valor = self.marcadoAzul
                                return
                            }else{
                                valor = self.marcadoRojo
                                return
                            }
                        }
                    })
                }
            }
            return valor
        }, 
        cambioTipo(param){
            this.lista_general_presupuesto = []
            if(param == 1) this.odontograma = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32]
            if(param == 2) this.odontograma = [33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52]
            if(param == 3) this.odontograma = [1,2,3,14,15,16,17,18,19,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52]
        }, 
        cambioLaboratorio(){
            let lab = this.laboratorioservicios.find(la => la.id == this.dataServicio.laboratorioservicio_id)
            this.dataServicio.laboratorio_id = lab.laboratorio_id
            this.dataServicio.monto_lab = lab.costo_lab
            //console.log("laboratorio",this.dataServicio.laboratorio_id)
        },
        cambioMaterial(){
            let mat = this.materialservicios.find(mat => mat.id == this.dataServicio.materialservicio_id)
            this.dataServicio.material_id = mat.material_id
            this.dataServicio.monto_mat = mat.material.costo

        },        
        AgregaEvolucion(param){
            this.numid = param
            this.dataServicio.descripcion[param] = ''
            this.dataServicio.laboratorioservicio_id = ''
            this.dataServicio.laboratorio_id = ''
        },    
        createPDF () {
            let self = this
            this.$swal({
                title: 'Desea imprimir este Presupuesto?',
                text: "Impresión del Presupuesto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, imprimir!'
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true   
                        self.take(this.$refs.printMe)
                    }
                });

        },
        take(targetElem) {
            let self = this
            // Primero renderiza todos los SVGs a los lienzos
            var elements = $(targetElem).find('svg').map(function() {
                var svg = $(this);
                var canvas = $('<canvas id="canvas"></canvas>');
                svg.replaceWith(canvas);
                var serializer = new XMLSerializer();
                var svgString = serializer.serializeToString(svg[0]);
                canvg(canvas[0], svgString);
                return {
                    svg: svg,
                    canvas: canvas
                };
            });
            $(targetElem).imagesLoaded(function() {
                // En este punto, el contenedor no tiene SVG, solo tiene HTML y lienzos.
                html2canvas($(targetElem)[0]).then(function(canvas) {
                    // reemplazar los svg originales
                    elements.each(function() {
                        this.canvas.replaceWith(this.svg);
                    });
                    // Poner el lienzo creado en una imagen.
                    var imgData = canvas.toDataURL("image/png");
                    var doc = new jsPDF();
                    var img = new Image()
                    img.src = '/img/logo/multident.png'
                    doc.addImage(img, 'png', 150, 8, 45, 8)                    
                    doc.setFontSize(12)
                    doc.setFont("helvetica")
                    doc.setFontType("bold")
                    doc.setFillColor(130,142,154)
                    doc.roundedRect(75, 8, 60, 7, 1,1, 'F') 
                    doc.setTextColor(255, 255, 255)                   
                    doc.text(80,13,"PRESUPUESTO Nº")
                    doc.text(120,13,self.presupuestoOperatoriaById.id.toString())
                    doc.setTextColor(0, 0, 0)                                        
                    doc.setFontSize(8)                   
                    doc.text(15,20,'FECHA :')
                    doc.text(40,20, self.dataPaciente.fecha)
                    doc.setFontType("normal")   
                    doc.text(85,20,'H.C Nº :')
                    doc.text(100,20, self.dataPaciente.historiaclinica.toString())  
                    doc.text(150,20, 'Sede:')
                    doc.setFontType("bold")                     
                    doc.text(165,20, 'MAYOLO') 
                    doc.setFontType("normal")                                    
                    doc.text(15,25,'Paciente:')
                    doc.setFontSize(6)
                    doc.setFontType("bold") 
                    doc.text(40,25, self.dataPaciente.nombre_completo )
                    doc.setFontSize(8)
                    doc.setFontType("normal")                     
                    doc.text(85,25,'Doctor:')
                    doc.setFontSize(6)
                    doc.setFontType("bold")                     
                    doc.text(100,25, self.dataPaciente.empleado) 
                    doc.setFontSize(8)
                    doc.setFontType("normal")                                         
                    doc.text(15,29,'Plan:')
                    doc.text(40,29 , self.dataPaciente.plan)
                    doc.text(85,29,'Empresa:')
                    doc.text(100,29 , self.dataPaciente.empresa)                    
                    doc.setFontType("bold")                    
                    doc.text(25,36,'FORMA DE PAGO')
                    doc.setFontType("normal")                    
                    doc.text(15,40,'Deducible X Pza.')
                    doc.text(15,45,'Coaseguro %')
                    doc.setFontSize(14)
                    doc.setFontType("bold")                     
                    doc.text(80,55,'O D O N T O G R A M A')
                    doc.setLineWidth(0.5);
                    doc.line(80, 56, 135, 56);
                    doc.setFontType("normal")                     
                    doc.addImage(imgData, 'png', 20, 61, 180, 100)
                    // DETALLE DEL PRESUPUESTO
                    doc.setFontSize(7)
                    doc.setFontType("normal")                     
                    doc.line(8,170 , 205 ,170)
                    doc.text(8,174 , 'Pieza')
                    doc.text(23,174,'Superficie')
                    doc.text(85,174 , 'Tratamientos')
                    doc.text(145,174,'Deducible')  
                    doc.text(165,174 , 'CoaSeguro')
                    doc.text(198,174,'TOTAL','right')                                      
                    doc.line(8,176 , 205 ,176)
                    doc.setFontSize(8)
                    doc.setFontType("bold")                      
                    doc.text(8,180, 'TRATAMIENTOS PARTICULARES')
                    // Carga de Datos
                    doc.setFontSize(7)
                    doc.setFontType("normal")                      
                    let y = 180
                    self.lista_general_presupuesto.map(function(value, key) {
                        y += 4
                        doc.text(8,y,value.diente_codigo)
                        doc.text(23,y,value.caras)
                        doc.text(38,y,value.nombre_servicio)
                        doc.text(145,y,'0.00')
                        doc.text(165,y,'0.00')
                        doc.text(198,y,parseFloat(value.costo).toFixed(2),'right')
                    }) 
                    y += 2 
                    doc.line(8,y , 205 ,y)
                    y += 5
                    doc.setFontSize(8)
                    doc.setFontType("bold")                     
                    doc.text(80,y,'TOTAL TRATAMIENTOS PARTICULARES')
                    doc.text(198,y,parseFloat(self.presupuestoOperatoriaById.pago_total).toFixed(2),'right')
                    y += 8
                    doc.text(140,y,'TOTAL A CANCELAR')
                    doc.line(185,y , 205,y)
                    doc.line(205,y-4 , 205, y)
                    y += 30
                    doc.line(8,y, 75,y)
                    doc.line(145,y ,205,y)
                    y += 5
                    doc.setFontSize(9)
                    doc.setFontType("bold")                    
                    doc.text(13,y, 'Firma del Odontólogo tratante')
                    doc.text(145,y,'Firma del Paciente - Apoderado')
                    doc.setFontSize(6)
                    doc.setFontType("normal")                     
                    y += 12
                    doc.text(13,y , 'Nota:')
                    y += 3
                    doc.text(18,y ,'- Los precios incluyen IGV')
                    y += 3
                    doc.text(18,y ,'- Presupuesto válido por 90 dias sin iniciar tratamiento')
                    y += 3
                    doc.text(18,y ,'- Los tratamientos optativos no estan incluidos en el Total a pagar por el paciente')
                    y += 3
                    doc.text(18,y ,'- Cancelar el total de los deducibles y coaseguro de los tratamientos terminados')
                    y += 3
                    doc.text(18,y, '- Consulte por el financiamiento odontólogico')
                    y += 3
                    doc.text(18,y, '- El precio de los servicios optativos es por pieza')
                    //doc.save('sample-file.pdf'); 
                    self.isLoading = false
                    window.open(doc.output('bloburl'),'_blank') 
                    self.$router.push({ name: 'lista-ppto-operatoria' })
                    //window.open(strurl,'_blank')                   
                })
            })
        },
        getLaboratorio(param){
            let laboratorio = this.laboratorios.find(lab => lab.id == param)
            return laboratorio.nombre_laboratorio
        }                             

    },
    filters: {
        fixed(value){
            return parseFloat(value).toFixed(2)
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
    #descripcion {
        width: 100% !important;
    } 
    .expand-enter-active, .expand-leave-active {
        transition: all .3s ease;
        height: 180px;
        overflow: hidden;
    }
    .expand-enter, .expand-leave-to {
        height: 0;
        opacity: 0;
    } 
    .form-control:disabled {
        opacity: 0.9 !important;
    } 
    .color-yellow{
        background:#ffc107 !important;
    }  
    .table td, .table th {
        padding: 0 !important;
    } 
    .title {
        font-weight: 500 !important;
    } 
    /* --- Odontograma --*/
    .perno {
        cursor:pointer; 
        cursor: hand ;         
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
    .borde-derecho-multi{
        border-right: 3px #ffa534 solid;
        padding-right: 20px;
    }
    .borde-inferior-multi{
        border-bottom:3px #ffa534 solid;
    }    
    .texto-vertical {
        width:10px;
        word-wrap: break-word;
        text-align:center;
        font-weight: 600;
    } 
    .border-odonto {
        border-color: #c1c4c7 !important;
    }       
</style>