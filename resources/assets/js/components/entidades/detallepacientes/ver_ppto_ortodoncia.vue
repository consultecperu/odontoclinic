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
                        <select class="form-control mt-5" id="medicos" v-model="dataPaciente.empleado_id" @change.prevent="CambioMedico(dataPresupuesto.empleado_id)">
                            <option value="">-- Seleccione --</option>
                            <option v-for="med in getMedicos" :value="med.id" :key="med.id">
                                {{ med.nombre_completo}}
                            </option>
                        </select>                                
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
                                                <span class="center badge" :class="{'badge-danger' : props.row.pagado == 0 ,'badge-success' : props.row.pagado == 1 }">{{ props.row.pagado == 0 ? 'NO' : 'SI' }}</span>             
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
                            <p class="form-control-static text-right title mb-0">Saldo disponible : {{ presupuestoOrtodonciaById.saldo | fixed}}</p>                           
                        </div>
                        <div class="card-body">
                            <button class="btn btn-primary btn-block btn-sm" @click.prevent="pagoAdelantado"><span class="btn-label"><i class="la la-money"></i></span>Pago Adelantado</button>
                            <button class="btn btn-primary btn-block btn-sm" @click.prevent="TxAdicionales"><span class="btn-label"><i class="la la-list-ul"></i></span>Tx Adicionales</button>
                            <button class="btn btn-primary btn-block btn-sm"><span class="btn-label"><i class="la la-pencil-square"></i></span>Record de Atención</button>
                            <button class="btn btn-primary btn-block btn-sm"><span class="btn-label"><i class="la la-calculator"></i></span>Estado de Cuenta</button>             
                            <button class="btn btn-primary btn-block btn-sm" @click.prevent="createPDF"><span class="btn-label"><i class="la la-print"></i></span>Imprimir Presupuesto</button>
                        </div>
                    </div>
                </div>
            </div>                                 
            <div class="row">
                <div class="col-12">
                    <p>Total Abonado Soles : <span class="font-weight-bold">{{ PagoTotalSoles }}</span></p>
                    <p>Total Abonado Dolares : <span class="font-weight-bold">{{ PagoTotalDolares}}</span></p>
                </div> 
            </div>
            <div class="row">
                <div class="col-12">
                    <table class="table table-bordered table-sm table-head-bg-info table-bordered-bd-info">
                        <thead>
                            <tr>
<!--                                 <th scope="col" class="text-center">Nº</th>
                                <th scope="col">Doc</th>
                                <th scope="col">Número</th>
                                <th scope="col">Fecha</th>    
                                <th scope="col" align="right">Monto</th>   -->
                                <th scope="col" class="text-center">Nº</th>
                                <th scope="col" class="text-center">Doc.</th>
                                <th scope="col" class="text-center">Serie</th>
                                <th scope="col" class="text-center">Num.</th>
                                <th scope="col" class="text-center">Monto</th> 
                                <th scope="col" class="text-center">Moneda</th>
                                <th scope="col" class="text-center">Fecha</th>
                                <th scope="col" class="text-center">Forma Pago</th>
                                <th scope="col" class="text-center">Tipo Pago</th>                                                                                                                                                      
                            </tr>
                        </thead>
                        <tbody>
                            <tr v-for="(pago, index) in PagosPresupuestoOrtodonciaById" :key="pago.id">
<!--                                 <th width="10%" align="center" scope="row" class="text-center">{{ index+1 }}</th>
                                <td width="15%">{{ pago.tipodocumento.abreviatura}}</td>
                                <td width="25%">{{ pago.serie + '-' + pago.numero}}</td>  
                                <td width="25%">{{ pago.fecha_pago}}</td> 
                                <td width="25%" align="right">{{ parseFloat(pago.total).toFixed(2)}}</td> -->                                                                                                                       

                                <th width="5%" align="center" scope="row" class="text-center">{{ index+1 }}</th>
                                <td width="13%" class="text-center">{{ pago.tipodocumento.nombre_tipodocumento}}</td> 
                                <td width="8%" class="text-center">{{ pago.tipodocumento.abreviatura + pago.serie}}</td>
                                <td width="5%" class="text-center">{{ pago.numero}}</td>
                                <td width="10%" class="text-center">{{ pago.moneda_id == 1 ? parseFloat(pago.total).toFixed(2) : parseFloat(pago.total_dolares).toFixed(2)}}</td>                                                                                                                       
                                <td width="10%" class="text-center">{{ pago.moneda.nombre_moneda}}</td>
                                <td width="21%" class="text-center">{{ pago.fecha_pago}}</td>
                                <td width="13%" class="text-center" v-if="pago.modo == 3">MIXTO</td>                                
                                <td width="13%" class="text-center" v-if="pago.modo == 1 || pago.modo == 2">{{ pago.tipopago.descripcion}}</td>
                                <td width="15%" class="text-center">{{ pago.tipo == 1 ? 'DIRECTO': 'ADELANTADO' }}</td> 
                            </tr>
                            <tr v-if="PagosPresupuestoOrtodonciaById.length == 0">
                                <td colspan="9" class="text-center">NO HAY SERVICIOS CARGADOS ...</td>                                           
                            </tr>
                        </tbody>
                    </table> 
                </div>                               
            </div>          
        </div> 
        <!-- PAGE CONTENT MODAL ATENCIONES-->  
        <modal name="record_atencion" :width="'65%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de record atencion -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Realización de Tratamientos</div>
                    </div>
                    <div class="card-body">
                        <div v-for="rec in seleccionados" :key="rec.id">
                            <!-- Cabecera de los servicios-->
                            <div class="row">
                                <div class="col-7">
                                    <p class="form-control-static"><span class="font-weight-bold">Tratamiento : </span>{{ rec.descripcion }}</p>
                                </div>
                                <div class="col-3">
                                    <p class="form-control-static"><span class="font-weight-bold">Estado : </span>
                                        <span class="badge badge-warning" v-if="rec.realizado == 1">Pendiente</span>
                                        <span class="badge badge-primary" v-if="rec.realizado == 2">En Proceso</span>
                                        <span class="badge badge-success" v-if="rec.realizado == 3">Terminado</span>
                                    </p>
                                </div>
                                <div class="col-2">
                                    <button class="btn btn-primary btn-xs btn-no-xs float-right" v-tooltip.top="'Agregar Evolución'" @click.prevent="numid = rec.id"><i class="la la-plus"></i></button>
                                    <button class="btn btn-success btn-xs btn-no-xs float-right mr-10" v-tooltip.top="'Finalizar Tratamiento'" @click.prevent="finalizarTratamiento(rec.id)"><i class="la la-check"></i></button>
                                </div>
                            </div>
                            <!-- Record de Atenciones -->
                            <template v-if="rec.recordatencionortodoncias.length > 0">
                                <div class="row" v-for="(ate, index) in rec.recordatencionortodoncias" :key="ate.id">
                                    <div class="col-1 text-right">
                                        {{ index+1 }}
                                    </div>
                                    <div class="col-11">
                                        <p class="form-control-static mb-0"><span class="font-weight-bold">Fecha de Registro :</span>{{ ate.fecha_realizacion }}</p>
                                        <p class="form-control-static"><span class="font-weight-bold">Descripcion :</span>{{ ate.descripcion }}</p>
                                    </div>
                                </div>
                            </template>
                            <div class="row" v-if="rec.recordatencionortodoncias.length == 0">
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
                                                    <div class="select2-input" v-if="rec.laboratorio_id == null">
                                                        <select id="laboratorio" name="laboratorio" class="col-8 form-control form-control-sm border" v-model="dataServicio.laboratorioservicio_id" @change="cambioLaboratorio">
                                                            <option value="">--seleccione--</option>
                                                            <option v-for="lab in rec.tarifario.servicio.laboratorioservicios" :value="lab.id" :key="lab.id">
                                                                {{ lab.laboratorio.nombre_laboratorio}}
                                                            </option>
                                                        </select>
                                                    </div> 
                                                    <div class="text-primary font-weight-bold" v-if="rec.laboratorio_id != null">
                                                        <label for="descripcion" class="text-danger font-weight-bold">{{ rec.laboratorio.nombre_laboratorio}}</label>
                                                    </div>                                                    
                                                </div>
<!--                                                 <div class="col-6" v-if="rec.tarifario.servicio.materialservicios.length > 0">
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
                                                </div> -->

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
            <!-- /. form de registro de record atencion -->
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
        <!-- PAGE CONTENT MODAL PAGO DIRECTO-->  
        <modal name="pago_adelantado" :width="'60%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de cargos -->
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
                                                <input type="text" id="valor_efectivo_tarjeta" class="form-control form-control-sm" v-model="dataPago.monto_tarjeta" placeholder="0.00" :disabled="dataPago.tipopago_id == ''">
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
        <modal id="tx_adicionales" name="tx_adicionales" :width="'60%'" height="auto" transition="pop-out" :scrollable="true" :clickToClose="false" >
           <div class="card mb-0">
                <div class="card-header">
                    <div class="card-title d-inline">Tx Adicionales</div>
                    <button type="button" class="close d-inline" aria-label="Close" @click.prevent="$modal.hide('tx_adicionales')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                     <div class="row">
                         <div class="col-12">
                             <button type="button" class="btn btn-md btn-primary float-right mb-10" @click.prevent="$modal.show('tratamientos')"><i class="la la-plus"></i> Agregar Servicio</button>
                         </div>
                     </div>
                     <div class="row">
                        <div class="col-12">
                            <table class="table table-bordered table-sm table-head-bg-primary table-bordered-bd-info">
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
                                    <tr v-for="(serv, index) in lista_tx" :key="serv.id">
                                        <td width="5%" align="center">{{ index+1 }}</td>
                                        <td width="60%">{{ serv.nombre_servicio}}</td>
                                        <td width="15%">{{ serv.nombre_moneda}}</td>  
                                        <td width="10%" align="right">{{ parseFloat(serv.costo).toFixed(2)}}</td> 
                                        <td width="10%" align="center">
                                            <button type="button" v-tooltip="'Eliminar Item'" class="btn btn-danger btn-xs" @click.prevent="borrarItem(index)">
                                                <i class="la la-trash-o font-large"></i>
                                            </button>
                                            <button type="button" v-tooltip="'Descuento'" class="btn btn-success btn-xs" @click.prevent="AplicaDescuento(serv,index)">
                                                <i class="la la-calculator font-large"></i>
                                            </button>
                                        </td>                                                                                                                        
                                    </tr>
                                    <tr v-if="lista_tx.length == 0">
                                        <td colspan="8" class="text-center">NO HAY SERVICIOS CARGADOS ...</td>                                           
                                    </tr>
                                </tbody>
                            </table> 
                        </div>                         
                     </div>
                </div>
                <div class="card-action">
                    <button class="btn btn-primary float-right" @click.prevent="createAdicionales" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                    <button class="btn btn-danger float-right" @click="$modal.hide('tx_adicionales')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                </div>                
            </div>                                
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
    name: 'ver-ppto-ortodoncia',
    mixins: [mixin],  
    created(){
        this.$store.dispatch('LOAD_EMPRESAPACIENTES_LIST') 
        this.$store.dispatch('LOAD_LABORATORIOSERVICIOS_LIST')   
        this.$store.dispatch('LOAD_MATERIALSERVICIOS_LIST')                 
        this.$store.dispatch('LOAD_TIPOPAGOS_LIST') 
        this.$store.dispatch('LOAD_PAGOS_LIST')
        this.$store.dispatch('LOAD_TIPOCAMBIOS_LIST') 
        this.$store.dispatch('LOAD_SERVICIOS_LIST')
        this.$store.dispatch('LOAD_MONEDAS_LIST')         
        //this.dataDetalleOperatoria = _.clone(this.presupuestoOperatoriaById.presupuestosoperatoriasdetalles)
        this.dataPaciente = {
            id:this.presupuestoOrtodonciaById.paciente_id,
            nombre_completo:this.presupuestoOrtodonciaById.paciente.nombre_completo,
            historiaclinica:this.presupuestoOrtodonciaById.paciente.historiaclinica,
            //empresa:this.presupuestoOrtodonciaById.paciente.pacienteplanes.tipo == 1 ? '-' : this.presupuestoOrtodonciaById.paciente.pacienteplanes.empresapaciente.razon_social,
            empresa: '-',
            plan:this.presupuestoOrtodonciaById.plan.descripcion,
            aseguradora:'-',
            //aseguradora:this.presupuestoOrtodonciaById.paciente.pacienteplanes.plan.descripcion ,
            fecha:moment(this.presupuestoOrtodonciaById.fecha_registro).format('DD-MM-YYYY'),
            tipocambio:this.presupuestoOrtodonciaById.tipocambio.tipo_cambio,
            empleado_id:this.presupuestoOrtodonciaById.empleado_id
        } 
    },
    mounted(){
        this.CargaDetalleEdit()
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
                label: 'Servicio',
                field: 'descripcion',           
                width:'50%',
                },
                {
                label: 'Pagado',
                field: 'pagado',
                thClass: 'center',
                tdClass: 'center',                
                width:'20%',
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
                label: 'Servicio',
                field: 'tarifario.servicio.nombre_servicio',           
                width:'60%',
                },                
                {
                label: 'Estado',
                field: 'realizado', 
                thClass: 'center',
                tdClass: 'center',                               
                width:'30%',
                },                                                                                                                                                                                                                       
                {
                label: 'Total',
                field: 'costo',
                type:'decimal',
                width:'10%',  
                }                               
            ],
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
                empleado_id:''
            },
            dataRecord:{
                presupuestoortodonciadetalle_id:'',
                fase_id:'',
                descripcion:'',
                realizado:'',
                comentario:'',
                empleado_id:'',
                fecha_realizacion:'',
                user_id:'',
                laboratorio_id:'',
                material:''
            },
            dataDetalleOrtodoncia:[],
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
            dataPago: {
                sede_id:'',
                ptoventa:'',
                origen:2,
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
                modo:1,
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
            dataTratamiento:{
                id:'',
                idppto:'',
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

            //modo_pago:1 ,   // modo 1-efectivo 2-tarjeta 3-mixto   
            entrego_efectivo: 0.00,  
            lista_tx:[],
            dataDetalleTX :{
                items:[],
                total_soles:'',
                total_dolares:''
            },
            lista_general_presupuesto:[]    
        }
    },
    computed: {
        ...mapState(['user_system','sede_system','monedas','empresapacientes','tarifarios','laboratorioservicios','materialservicios']),
        ...mapGetters(['getMedicos','getTipoCambioHoy','getPresupuestoOrtodonciaById','getTipopagosForma','getPagosPresupuestoOrtodonciaById']), 
        presupuestoOrtodonciaById(){
            if(this.$route.params.idpresupuesto != undefined){
                return this.getPresupuestoOrtodonciaById(this.$route.params.idpresupuesto)                 
            }
            return []        
        },
        items_descargados(){
            return this.presupuestoOrtodonciaById.presupuestosortodonciasdetalles.filter(pd => pd.descargado == 1)
        },
        items_sindescarga(){
            return this.presupuestoOrtodonciaById.presupuestosortodonciasdetalles.filter(pd => pd.descargado == 0 && pd.activo == true)
        },
        PagosPresupuestoOrtodonciaById(){
            return this.getPagosPresupuestoOrtodonciaById(this.$route.params.idpresupuesto)
        },
        Tarjetas(){
            return this.getTipopagosForma(2)
        },
        PagoTotalSoles(){
            let totpagos = 0
            if(this.PagosPresupuestoOrtodonciaById.length > 0){
                _.each(this.PagosPresupuestoOrtodonciaById, function(value,key){
                    if(value.moneda_id == 1){
                        totpagos += parseFloat(value.total)
                    }
                })
            }
            return parseFloat(totpagos).toFixed(2)
        },
        PagoTotalDolares(){
            let totpagos = 0
            if(this.PagosPresupuestoOrtodonciaById.length > 0){
                _.each(this.PagosPresupuestoOrtodonciaById, function(value,key){
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
            _.each(this.presupuestoOrtodonciaById.presupuestosortodonciasdetalles, function(value,key){
                if(value.pagado == 1){
                    pagados += parseFloat(value.costo)
                }
            })
            pendientes = parseFloat(this.presupuestoOrtodonciaById.total_soles) - parseFloat(pagados)
            return parseFloat(pendientes).toFixed(2)
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
            return parseFloat(vuelto).toFixed(2)
        },
        TratamientosAdicionales(){
            return this.tarifarios.filter(tar => tar.plan_id == this.presupuestoOrtodonciaById.paciente.pacienteplanes.plan_id && tar.sede_id == 1)
        },                        
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
        },
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
            this.$modal.show('record_atencion')
        },
        GrabarRecord(param){
            this.dataRecord = {
                presupuestoortodonciadetalle_id:param.id,
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
                tipo:2,         // ortodoncia
                liquidable:1                         
            }            

            var url = '/api/recordatencion-ortodoncias';
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
            this.$store.dispatch('LOAD_PRESUPUESTOS_ORTODONCIAS_LIST').then(() => {
                this.numid = 0
                let self = this  
                _.each(copy_seleccionados, function(value,key){
                    _.each(self.presupuestoOrtodonciaById.presupuestosortodonciasdetalles, function(value2,key2){
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
                        var url = '/api/recordatencion-ortodoncias/finalizar/' + param
                        axios.put(url,this.dataRecord).then(response=> {
                            let copy_seleccionados = _.clone(this.seleccionados)
                            this.seleccionados = []
                            this.color_selected = []
                            this.$store.dispatch('LOAD_PRESUPUESTOS_ORTODONCIAS_LIST').then(() => {
                                this.numid = 0
                                let self = this  
                                _.each(copy_seleccionados, function(value,key){
                                    _.each(self.presupuestoOrtodonciaById.presupuestosortodonciasdetalles, function(value2,key2){
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
                    //valor_total += parseFloat(value.costo)
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
                origen:2,
                presupuestooperatoria_id:'',
                presupuestoortodoncia_id:this.presupuestoOrtodonciaById.id,
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
                tipo:1, // 1. directo 2.adelantado
                paciente_pago:'',
                disponible:'',
                vuelto:0.00,
                indicador:'',
                disponible_efectivo:'',
                disponible_tarjeta:'',
                contable:'',
                fecha_descarga:'',
                modo:1,
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
            //this.modo_pago = 1
            if(tipcam == undefined){
                this.notificaciones('Debe registrar el Tipo de cambio de Hoy','la la-thumbs-o-down','danger')
                return
            } 
            this.dataPresupuesto.tipo_cambio = parseFloat(tipcam.tipo_cambio).toFixed(2)
            this.dataPago = {
                sede_id:this.sede_system.id,
                ptoventa:1,
                origen:2,   // 1.operatoria 2.ortodoncia
                presupuestooperatoria_id:'',
                presupuestoortodoncia_id:this.presupuestoOrtodonciaById.id,
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
                fecha_descarga:'',
                modo:1
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
            if(this.dataPago.tipo == 2){
                let debe = parseFloat(this.TxPendientes) - parseFloat(this.presupuestoOrtodonciaById.saldo)
                if(parseFloat(this.dataPago.total) > parseFloat(debe)){
                    this.notificaciones('El Pago adelantado no puede ser mayor al Costo pendiente del presupuesto','la la-thumbs-o-down','danger')
                    return
                }
            }
            if(this.dataPago.modo == 1){
                this.dataPago.tipopago_id = 1
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
            this.$store.dispatch('LOAD_PRESUPUESTOS_ORTODONCIAS_LIST')               
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
                        var url = '/api/presupuestosortodonciasdetalles/descargatx/' + this.$route.params.idpresupuesto
                        axios.put(url,this.dataPago).then(response=> {
                            this.$store.dispatch('LOAD_PRESUPUESTOS_ORTODONCIAS_LIST').then(() => {
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
                    verif_saldo += value.costo
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
            if(parseFloat(this.presupuestoOrtodonciaById.saldo) < parseFloat(verif_saldo)){
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
                        var url = '/api/presupuestosortodonciasdetalles/descargasaldo/' + this.$route.params.idpresupuesto
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
                            this.$store.dispatch('LOAD_PRESUPUESTOS_ORTODONCIAS_LIST').then(() => {
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
                    this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')
                });
        },        
        verRecord(){
            console.log("record......")
        },
        cambioModoPago(){
            this.dataPago.monto_efectivo = 0
            this.dataPago.monto_tarjeta = 0
            this.dataPago.tipopago_id = ''
        },
        verOdontograma(){
            this.$router.push({ name: 'ppto-ortodoncia' , params: { idpresupuesto: this.presupuestoOrtodonciaById.id } })           
        },
        TxAdicionales(){
            let tipcam = this.getTipoCambioHoy
            if(tipcam == undefined){
                this.notificaciones('Debe registrar el Tipo de cambio de Hoy','la la-thumbs-o-down','danger')
                return
            }            
            this.lista_tx = []
            this.$modal.show('tx_adicionales')
        },
        selectServicio(param){   
            let self = this
            let encontrado = false
            this.lista_tx.map(function(value, key){
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
                this.lista_tx.push(this.dataTratamiento)          // nuevos servicios
                this.$modal.hide('tratamientos'); 
            }                      
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
                        this.$delete(self.lista_tx , index) 
                    }
                });              
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
            this.lista_tx[this.dataDescuento.index].descuento = parseFloat(desc).toFixed(2)
            this.lista_tx[this.dataDescuento.index].costo = this.dataDescuento.nuevo_monto
            this.$modal.hide('descuento')
        }, 
        cambiaTipo(){
            this.dataDescuento.nuevo_monto = ''
            this.dataDescuento.porcentaje = ''
        }, 
        cambioLaboratorio(){
            let lab = this.laboratorioservicios.find(la => la.id == this.dataServicio.laboratorioservicio_id)
            this.dataServicio.laboratorio_id = lab.laboratorio_id
            this.dataServicio.monto_lab = lab.costo_lab
        },
        cambioMaterial(){
            let mat = this.materialservicios.find(mat => mat.id == this.dataServicio.materialservicio_id)
            this.dataServicio.material_id = mat.material_id
            this.dataServicio.monto_mat = mat.material.costo
        },         
        createAdicionales(){
            this.isLoading = true
            let self = this
            let lista = []
            let valor_soles = 0
            let valor_dolares = 0
            let tipcam = this.getTipoCambioHoy
            this.lista_tx.map(function(value, key) {
                let detpre = _.clone(self.dataDetallePresupuesto)
                detpre = {
                    tarifario_id:value.tarifario_id,
                    tipoplan:1,
                    moneda_id:value.moneda_id,
                    costo:value.costo,
                    costo_base:value.costo_base,
                    descuento:value.descuento,
                    empleado_id:self.dataPaciente.empleado_id,
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
                valor_soles += parseFloat(value.costo)              
                lista.push(detpre)
            })
            valor_soles = parseFloat(valor_soles).toFixed(2)
            valor_dolares = parseFloat(valor_soles) / parseFloat(tipcam.tipo_cambio)
            valor_dolares = parseFloat(valor_dolares).toFixed(2)

            this.dataDetalleTX = {
                items: lista,
                total_soles : valor_soles,
                total_dolares : valor_dolares
            }
            
            this.createTxAdicionales()

        },
        createTxAdicionales: function(){
            var url = '/api/presupuestosortodonciasdetalles/addadicionales/'+ this.$route.params.idpresupuesto
            this.StatusForm(true,'la la-spinner','Procesando')     
            axios.put(url, this.dataDetalleTX).then(response => {
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
            this.$store.dispatch('LOAD_PRESUPUESTOS_ORTODONCIAS_LIST').then(() => {
                this.isLoading = false
            })     
            this.errors = [];
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')            
            this.$modal.hide('tx_adicionales');   
            this.notificaciones('Nuevos Registros creados con exito','la la-thumbs-up','success')       
            }).catch(error => {
            this.errors = error.response.data.status;
            this.StatusForm(false,'la la-cloud-download','Grabar Datos')  
            this.isLoading = false        
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           

            });
        },
        createPDF(){
            let total_cuotas = (parseFloat(this.presupuestoOrtodonciaById.control_mensual) * parseFloat(this.presupuestoOrtodonciaById.cuotas)).toFixed(2)
            var doc = new jsPDF();
            var img = new Image()
            img.src = '/img/logo/multident.png'
            doc.addImage(img, 'png', 150, 8, 45, 8)                    
            doc.setFontSize(12)
            doc.setFont("helvetica")
            doc.setFontType("bold")            
            doc.text(60,25,"PRESUPUESTO DE ORTODONCIA Nº")
            doc.text(140,25, this.presupuestoOrtodonciaById.id.toString())
            doc.setFontSize(9) 
            doc.setFontType("normal")                               
            doc.text(10,35,'Historia Clinica :')
            doc.setFontType("bold")  
            doc.text(40,35, this.dataPaciente.historiaclinica.toString()) 
            doc.setFontType("normal")              
            doc.text(150,35, 'Fecha:')
            doc.setFontType("bold")                     
            doc.text(165,35, this.presupuestoOrtodonciaById.fecha_registro) 
            doc.setFontType("normal")                                    
            doc.text(10,40,'Paciente:')
            doc.setFontType("bold") 
            doc.text(40,40, this.dataPaciente.nombre_completo )
            doc.setFontType("normal")                     
            doc.text(10,45,'Doctor:')
            doc.setFontType("bold")                     
            doc.text(40,45, this.presupuestoOrtodonciaById.nombre_empleado) 
            doc.setFontSize(8)
            doc.setFontType("normal") 
            doc.text(10,50,'TX de Ortodoncia:')
            doc.setFontType("bold")            
            //doc.text(40,50, this.presupuestoOrtodonciaById.nombre_servicio)                                        
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
            //doc.text(180,83, this.presupuestoOrtodonciaById.cuota_inicial,'right')   
            //doc.text(200,83, this.presupuestoOrtodonciaById.cuota_inicial,'right') 
            doc.line(8,85 , 205,85) 
            //doc.text(14,89,this.presupuestoOrtodonciaById.cuotas,'center')
            doc.text(30,89,'CONTROL MENSUAL')   
            //doc.text(180,89, this.presupuestoOrtodonciaById.control_mensual,'right')   
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
            //doc.text(25,y2, this.presupuestoOrtodonciaById.observaciones)
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
            //this.$router.push({ name: 'lista-ppto-ortodoncia' }) 
        },
        CargaDetalleEdit(){
            let self = this
            self.lista_general_presupuesto = []
            this.presupuestoOrtodonciaById.presupuestosortodonciasdetalles.map(function(value, key) {
                let datadet = []
                self.dataTratamiento = {
                    id: value.id,
                    idppto:value.presupuestooperatoria_id,
                    tarifario_id : value.tarifario_id,
                    servicio_id:value.tarifario.servicio_id,
                    nombre_servicio:value.tarifario.servicio.nombre_servicio,
                    costo_base:value.costo_base,
                    costo:value.costo,
                    moneda_id:value.moneda_id,
                    nombre_moneda:value.moneda.nombre_moneda,
                    descuento:value.descuento,
                    realizado:value.realizado,
                    adicional:value.adicional,
                    activo:value.activo,
                }
                if(self.dataTratamiento.activo){
                    datadet = _.clone(self.dataTratamiento)
                    self.lista_general_presupuesto.push(datadet)
                }                   
            })
        },                                                                                  

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
    .btn-xs {
        padding: 2px !important;
    }
    .btn-no-xs {
        font-size: 10px !important;
        padding: 5px 9px !important;
    }          
</style>