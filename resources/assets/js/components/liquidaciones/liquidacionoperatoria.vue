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
                    <div class="row">
                        <div class="col-12 pb-10 border-bottom mb-20">
                            <button type="button" class="btn btn-sm btn-primary float-right"><span class="btn-label"><i class="la la-file-text"></i></span>Reporte de Liquidación</button>
                            <button type="button" class="btn btn-sm btn-primary float-right mr-5"><span class="btn-label"><i class="la la-print"></i></span>Reimpresión</button>
                            <button type="button" class="btn btn-sm btn-primary float-right mr-5"><span class="btn-label"><i class="la la-unlock-alt"></i></span>Liberar Liquidación</button>
                            <button type="button" class="btn btn-sm btn-primary float-right mr-5"><span class="btn-label"><i class="la la-files-o"></i></span>Liquidaciones</button>
                        </div>
                    </div>
                    <ul class="nav nav-tabs nav-danger mt-10" id="pills-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold active" id="pills-trabfinalizado-tab" data-toggle="pill" href="#pills-trabfinalizado" role="tab" aria-controls="pills-trabfinalizado" aria-selected="true">POR TRABAJO FINALIZADO</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link font-weight-bold" id="pills-pagoliquidaciones-tab" data-toggle="pill" href="#pills-pagoliquidaciones" role="tab" aria-controls="pills-pagoliquidaciones" aria-selected="false">PAGO DE LIQUIDACIONES</a>
                        </li>                                    
                    </ul>
                    <div class="tab-content mb-3" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-trabfinalizado" role="tabpanel" aria-labelledby="pills-trabfinalizado-tab">
                            <div class="row mt-20">
                                <div class="col-4">
									<div class="form-group form-floating-label">
										<select ref="sedes" class="form-control input-border-bottom" id="selectSedes" v-model="dataFiltro.sede_id" @change.prevent="" required>
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
										<select ref="odontologos" class="form-control input-border-bottom" id="selectOdontologos" v-model="dataFiltro.empleado_id" @change.prevent="cargaDatos" required>
                                            <option value="0">--seleccione--</option>
                                            <option v-for="med in sede_odontologos" :value="med.id" :key="med.id">
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
                                    <ul class="nav nav-tabs nav-primary" id="pills-tab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link font-weight-bold active" id="pills-produccion-tab" data-toggle="pill" href="#pills-produccion" role="tab" aria-controls="pills-produccion" aria-selected="true" @click.prevent="accion_nav(1)">PRODUCCION</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link font-weight-bold" id="pills-abonodescuentos-tab" data-toggle="pill" href="#pills-abonodescuentos" role="tab" aria-controls="pills-abonodescuentos" aria-selected="false" @click.prevent="accion_nav(2)">ABONOS Y DESCUENTOS</a>
                                        </li>
                                    </ul>
                                    <div class="tab-content mb-3" id="pills-tabContent">
                                        <div class="tab-pane fade show active" id="pills-produccion" role="tabpanel" aria-labelledby="pills-produccion-tab">
                                            <div class="row">
                                                <div class="col-12 mb-10 mt-10">
                                                    <button type="button" class="btn btn-sm btn-danger float-right" v-show="seleccionados.length > 0" @click.prevent=""><span class="btn-label"><i class="la la-minus-circle"></i></span> No Facturable</button>
                                                    <button type="button" class="btn btn-sm btn-info float-right mr-5" v-show="seleccionados.length > 0" @click.prevent=""><span class="btn-label"><i class="la la-file-excel-o"></i></span> Preliminar (Excel)</button>
                                                    <button type="button" class="btn btn-sm btn-success float-right mr-5" v-show="seleccionados.length > 0" @click.prevent="createLiquidacion"><span class="btn-label"><i class="la la-edit"></i></span> Liquidar</button>
                                                </div>
                                            </div>                                            
                                            <div class="row">
                                                <div class="col-12">
                                                    <div>
                                                        <v2-table :data="rows" ref="table1"
                                                                border 
                                                                stripe 
                                                                height="210"
                                                                :lazy-load="true"
                                                                :loading="loading"                                                                 
                                                                :default-sort='{prop: "presupuesto_id", order: "descending"}' 
                                                                @sort-change="handleSortChange" 
                                                                :row-class-name="getRowClassName"
                                                                :total="total"
                                                                :cell-height="34"
                                                                :col-height="30"
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
                                                            <v2-table-column label="Servicio" prop="nombre_servicio" width="350" align="left" sortable></v2-table-column>
                                                            <v2-table-column label="Plan" prop="plan" align="left"></v2-table-column>
                                                            <v2-table-column label="Fecha Descarga" prop="fecha" align="left" sortable></v2-table-column>
                                                            <v2-table-column label="% Dr." prop="comision" align="left"></v2-table-column>
                                                            <v2-table-column label="Tipo Pago" prop="type_cash" align="left"></v2-table-column>
                                                            <v2-table-column label="Mon." prop="moneda" align="center"></v2-table-column>
                                                            <v2-table-column label="Total" prop="costo" width="100" align="right">
                                                                <template slot-scope="scope">
                                                                    <div>{{scope.row.costo | formatMoney}}</div> 
                                                                </template>                                                
                                                            </v2-table-column>
                                                            <v2-table-column label="Monto Efectivo" prop="monto_efectivo" width="120" align="right">
                                                                <template slot-scope="scope">
                                                                    <div>{{scope.row.monto_efectivo | formatMoney}}</div> 
                                                                </template>                                                              
                                                            </v2-table-column>
                                                            <v2-table-column label="Monto Tarjeta" prop="monto_tarjeta" width="120" align="right">
                                                                <template slot-scope="scope">
                                                                    <div>{{scope.row.monto_tarjeta | formatMoney}}</div> 
                                                                </template>                                                              
                                                            </v2-table-column>
                                                            <v2-table-column label="Ret.Banco" prop="comision_tarjeta" align="right">
                                                                <template slot-scope="scope">
                                                                    <div>{{scope.row.comision_tarjeta | formatMoney}}</div> 
                                                                </template>                                                              
                                                            </v2-table-column>
                                                            <v2-table-column label="Sunat Ret." prop="sunat" align="right">
                                                                <template slot-scope="scope">
                                                                    <div>{{scope.row.sunat | formatMoney}}</div> 
                                                                </template>                                                              
                                                            </v2-table-column>
                                                            <v2-table-column label="LAB" prop="laboratorio" align="right">
                                                                <template slot-scope="scope">
                                                                    <div>{{scope.row.laboratorio | formatMoney}}</div> 
                                                                </template>                                                              
                                                            </v2-table-column>
                                                            <v2-table-column label="Mats.DR." prop="material_doctor" align="right">
                                                                <template slot-scope="scope">
                                                                    <div>{{scope.row.material_doctor | formatMoney}}</div> 
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
                                                    <button type="button" class="btn btn-sm btn-warning float-right" v-show="dataFiltro.sede_id > 0 && dataFiltro.empleado_id > 0" @click.prevent="agregaDescuento"><i class="la la-minus"></i> Agregar Descuentos</button>
                                                    <button type="button" class="btn btn-sm btn-primary float-right mr-5" v-show="dataFiltro.sede_id > 0 && dataFiltro.empleado_id > 0" @click.prevent="agregaAbono"><i class="la la-plus"></i> Agregar Abonos</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <div>
                                                        <v2-table :data="rows2" ref="table2"
                                                                border 
                                                                stripe 
                                                                height="210"
                                                                :lazy-load="true"
                                                                :loading="loading2" 
                                                                :default-sort='{prop: "presupuesto_id", order: "descending"}' 
                                                                @sort-change="handleSortChange2" 
                                                                :row-class-name="getRowClassName2"
                                                                :total="total2"
                                                                :cell-height="34"
                                                                :col-height="30"
                                                                :shown-pagination="true"
                                                                :pagination-info="paginationInfo2"
                                                                @page-change="handlePageChange2"
                                                                @select-change="handleSelectChange2">
                                                            <div slot="empty"></div>
                                                            <v2-table-column type="selection" width="45"></v2-table-column>                              
                                                            <v2-table-column label="Tipo" width="130" prop="tipo" align="left"></v2-table-column>
                                                            <v2-table-column label="Concepto" prop="concepto" width="200" align="left" sortable></v2-table-column>
                                                            <v2-table-column label="Descripcion" prop="descripcion" width="300" align="left" sortable></v2-table-column>
                                                            <v2-table-column label="Fecha" prop="fecha" width="150" align="left" sortable></v2-table-column>
                                                            <v2-table-column label="Monto" prop="monto" width="150" align="right">
                                                                <template slot-scope="scope">
                                                                    <div>{{scope.row.monto | formatMoney}}</div> 
                                                                </template>                                                             
                                                            </v2-table-column>
                                                            <v2-table-column label="Accion" prop="accion" width="80" align="center">
                                                                <template slot-scope="scope">
                                                                    <div><button type="button" class="btn btn-xs btn-danger" @click.prevent="eliminarAbono(scope.row)"><span class="btn-label"><i class="la la-trash"></i></span></button></div> 
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
                            <div class="row">
                                <div class="col-sm-6 col-md-3">
                                    <div class="card card-stats card-round">
                                        <div class="card-body ">
                                            <div class="row">
                                                <div class="col-5">
                                                    <div class="icon-big text-center icon-primary">
                                                        <i class="flaticon-list text-primary"></i>
                                                    </div>
                                                </div>
                                                <div class="col-7 col-stats">
                                                    <div class="numbers">
                                                        <p class="card-category font-weight-bold">Total Atenciones</p>
                                                        <h4 class="card-title">S/. {{ label_total_atenciones}}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="card card-stats card-round">
                                        <div class="card-body ">
                                            <div class="row">
                                                <div class="col-5">
                                                    <div class="icon-big text-center icon-info">
                                                        <i class="flaticon-inbox text-info"></i>
                                                    </div>
                                                </div>
                                                <div class="col-7 col-stats">
                                                    <div class="numbers">
                                                        <p class="card-category font-weight-bold">Abonos</p>
                                                        <h4 class="card-title">S/. {{ label_total_abonos }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="card card-stats card-round">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-5">
                                                    <div class="icon-big text-center icon-danger">
                                                        <i class="flaticon-arrows-1 text-danger"></i>
                                                    </div>
                                                </div>
                                                <div class="col-7 col-stats">
                                                    <div class="numbers">
                                                        <p class="card-category font-weight-bold">Descuentos</p>
                                                        <h4 class="card-title">S/. {{ label_total_descuentos }}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-sm-6 col-md-3">
                                    <div class="card card-stats card-round">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-5">
                                                    <div class="icon-big text-center icon-success">
                                                        <i class="flaticon-coins text-success"></i>
                                                    </div>
                                                </div>
                                                <div class="col-7 col-stats">
                                                    <div class="numbers">
                                                        <p class="card-category font-weight-bold">Total Liquidar</p>
                                                        <h4 class="card-title">S/. {{ neto_a_liquidar}}</h4>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                                                  
                        </div>
                        <div class="tab-pane fade" id="pills-pagoliquidaciones" role="tabpanel" aria-labelledby="pills-pagoliquidaciones-tab">
                            <div class="row mt-20">
                                <div class="col-3">
									<div class="form-group form-floating-label">
										<select ref="sedes" class="form-control input-border-bottom" id="selectSedes" v-model="dataFiltroPL.sede_id" required>
                                            <option value="0">--seleccione--</option>
                                            <option v-for="sed in sedes" :value="sed.id" :key="sed.id">
                                                {{ sed.nombre_sede}}
                                            </option>
										</select>
										<label for="selectSedes" class="placeholder">Sedes</label>
									</div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group row pt-0 d-inline">
                                        <label for="fecha" class="col-12 pl-10 mb-0 label-title">Desde: </label>
                                        <date-picker v-model="dataFiltroPL.fecha_desde" :first-day-of-week="1" :lang="lang" format="DD-MM-YYYY"></date-picker>
                                    </div>
                                </div>
                                <div class="col-3">
                                    <div class="form-group row pt-0 d-inline">
                                        <label for="fecha" class="col-12 pl-10 mb-0 label-title">Hasta: </label>
                                        <date-picker v-model="dataFiltroPL.fecha_hasta" :first-day-of-week="1" :lang="lang" format="DD-MM-YYYY"></date-picker>
                                    </div>
                                </div>
                                <div class="col-3 pl-0 pt-20">
                                    <div class="form-group row pt-20npm d-inline">
                                        <button type="button" class="btn btn-sm btn-primary" @click.prevent="cargaDatosLiquidacion"><span class="btn-label"><i class="la la-search-plus"></i></span>Consultar</button>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">                                           
                                    <div class="row">
                                        <div class="col-12">
                                            <div>
                                                <v2-table :data="rows3" ref="table3"
                                                        border 
                                                        stripe 
                                                        height="210"
                                                        :lazy-load="true"
                                                        :loading="loading3"                                                                 
                                                        :default-sort='{prop: "numero_liquidacion", order: "descending"}' 
                                                        @sort-change="handleSortChange3" 
                                                        :total="total3"
                                                        :cell-height="34"
                                                        :col-height="30"
                                                        :shown-pagination="true"
                                                        :pagination-info="paginationInfo3"
                                                        @page-change="handlePageChange3">
                                                    <div slot="empty"></div>                            
                                                    <v2-table-column label="Nro. Liq." prop="numero_liquidacion" width="100" sortable></v2-table-column>
                                                    <v2-table-column label="Fecha Liq." prop="fecha_liquidacion" width="110" align="left"></v2-table-column>
                                                    <v2-table-column label="Sede" prop="sede" width="150" align="left" sortable></v2-table-column>
                                                    <v2-table-column label="Odontologo" prop="empleado" width="280" align="left" sortable></v2-table-column>
                                                    <v2-table-column label="Moneda" prop="moneda" width="70" align="left"></v2-table-column>
                                                    <v2-table-column label="Total" prop="total" width="100" align="right">
                                                        <template slot-scope="scope">
                                                            <div>{{scope.row.total | formatMoney}}</div> 
                                                        </template>                                                
                                                    </v2-table-column>                                                    
                                                    <v2-table-column label="Estado" prop="estado" width="120" align="center" sortable>
                                                        <template slot-scope="scope">
                                                            <div v-if="scope.row.estado == 'NO PAGADO'"><span class="badge badge-danger">{{scope.row.estado}}</span></div> 
                                                            <div v-if="scope.row.estado == 'PAGADO'"><span class="badge badge-success">{{scope.row.estado}}</span></div> 
                                                        </template>                                                         
                                                    </v2-table-column>
                                                    <v2-table-column label="Accion" prop="accion" width="120" align="center">
                                                        <template slot-scope="scope">
                                                            <div>
                                                                <button type="button" v-if="scope.row.estado == 'NO PAGADO'" class="btn btn-xs btn-success" @click.prevent="pagarLiquidacion(scope.row)"><span class="btn-label"><i class="la la-money"></i></span></button> 
                                                                <button type="button" v-if="scope.row.estado == 'PAGADO'" class="btn btn-xs btn-primary" @click.prevent="verLiquidacion(scope.row)"><span class="btn-label"><i class="la la-eye"></i></span></button> 
                                                                <button type="button" class="btn btn-xs btn-warning" @click.prevent="imprimirLiquidacion(scope.row)"><span class="btn-label"><i class="la la-print"></i></span></button>
                                                            </div> 
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
            <!-- /. form de registro de transacciones -->
        </modal>
        <!-- PAGE CONTENT MODAL PAGO LIQUIDACION -->  
        <modal name="pago_liquidacion" :width="'45%'" height="auto" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de pago liquidacion -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Cancelación de Operatoria</div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-3 pr-0">
                                <div class="form-group pt-0 pr-0 pl-0" >
                                    <label for="monto_facturar" class="font-weight-bold mb-0">Monto a Facturar</label>
                                    <input type="text" class="form-control form-control-sm text-right" name="monto_facturar" v-model="dataPago.monto" disabled>
                                </div>
                            </div>
                            <div class="col-3 pr-0">
                                <div class="form-group pt-0 pr-0 pl-0" >
                                    <label for="detraccion" class="font-weight-bold mb-0">Detracción </label>
                                    <input type="text" class="form-control form-control-sm text-right" name="detraccion" v-model="dataPago.detraccion" disabled>
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
                        <button class="btn btn-danger float-right ml-10" @click="$modal.hide('pago_liquidacion')"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                        <button class="btn btn-primary float-right" @click.prevent="facturarLiquidacion" :disabled="ShowIcon"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                    </div>
                </div>
            <!-- /. form de registro de pago liquidacion -->
        </modal>  
        <!-- PAGE CONTENT MODAL DETALLE PAGO-->  
        <modal name="detalle_pago" :width="'45%'" height="auto" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de cargos -->
                <div class="card mb-0">
                    <div class="card-header">
                        <div class="card-title">Datos de la Cancelación Operatoria</div>
                    </div>
                    <div class="card-body">
                        <div class="form-group form-inline p-0">
                            <div class="col-md-4">
                                <p class="form-control-static font-weight-bold mb-0">Nro. Liquidación</p>
                            </div>
                            <div class="col-md-8 p-0">
                                <p class="form-control-static mb-0">{{ datos.numero_liquidacion}}</p>
                            </div>
                        </div>
                        <div class="form-group form-inline p-0">
                            <div class="col-md-4">
                                <p class="form-control-static font-weight-bold mb-0">Monto facturado</p>
                            </div>                            
                            <div class="col-md-8 p-0">
                                <p class="form-control-static mb-0">{{ datos.total | formatMoney}}</p>
                            </div>
                        </div>
                        <div class="form-group form-inline p-0">
                            <div class="col-md-4">
                                <p class="form-control-static font-weight-bold mb-0">Fecha de Cancelación</p>
                            </div>                            
                            <div class="col-md-8 p-0">
                                <p class="form-control-static mb-0">{{ datos.fecha_cancelacion}}</p>
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
            <!-- /. form de registro de detalle de pago -->
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
    name: 'liquidacionoperatoria',
    mixins: [mixin],
    created(){
        this.$store.dispatch('LOAD_EMPLEADOS_LIST')        
        this.$store.dispatch('LOAD_SEDES_LIST')
        this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_DETALLES_LIST') 
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
            dataFiltroPL:{
                sede_id:0,
                fecha_desde:new Date(),
                fecha_hasta:new Date()
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
               origen:1,        // 1. operatoria 2.ortodoncia
               user_id:''
            }, 
            dataLiquidacion:{
                empleado_id:'',
                sede_id:'',
                fecha_corte:'',
                monto_total_atenciones:0,
                monto_total_abonos:0,
                monto_total_descuentos:0,
                monto_total_liquidar:0,
                motivo_eliminacion:0,
                tipo:'',
                moneda_id:'',
                pagado:0,
                user_id:'',
                detalle:[],
                transacciones:[]
            }, 
            dataPago:{
                liquidacionoperatoria_id:'',
                monto:'',
                detraccion:'',
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
            tableData:[],
            loading: false,
            loading2:false,
            loading3:false,
            currentPage: 1,
            currentPage2:1,
            currentPage3:1,
            total: 50, 
            total2: 50,
            total3: 50,
            paginationInfo: {
                text: '<strong>0 registros / 50 reg. x Página</strong>',
                pageSize:50,
                nextPageText:'Sig.',
                prevPageText:'Ant.'               
            },                      
            rows:[],  
            paginationInfo2: {
                text: '<strong>0 registros - 50 reg. x Página</strong>',
                pageSize:50,
                nextPageText:'Sig.',
                prevPageText:'Ant.'               
            },
            rows2:[],            
            paginationInfo3: {
                text: '<strong>0 registros - 50 reg. x Página</strong>',
                pageSize:50,
                nextPageText:'Sig.',
                prevPageText:'Ant.'               
            },              
            rows3:[],
            seleccionados:[],
            seleccionados2:[],
            // labels del resumen
            label_total_atenciones:0.00,
            label_total_abonos:0.00,
            label_total_descuentos:0.00,
            label_total_liquidar:0.00,
            neto_a_liquidar:0.00 ,
            generar: false,
            datos:[]                                          
        }
    },
    computed: {
        ...mapState(['user_system','sede_system','sedes','empleados','presupuestos_operatorias_detalles','conceptos','transacciones_doctor','preliquidaciondoctor','liquidacionessedes']),
        ...mapGetters(['getMedicos','getConceptosAbonos','getConceptosDescuentos']),     
        sede_odontologos(){    
            if(this.dataFiltro.sede_id > 0){
                let sede = this.sedes.find(sed => sed.id == this.dataFiltro.sede_id) 
                return sede.empleados.filter(emp => emp.tipo == 1)
            }
            return []
        }                                                 
    },
    components: { DatePicker ,  MaskedInput  },     
    methods:{
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },          
        cargaDatos(){           
            this.loading = true
            let fec_cor = moment(this.dataFiltro.fecha_corte).format('DDMMYYYY')
            this.$store.dispatch('LOAD_PRELIQUIDACIONES_DOCTORES_LIST',{ empleado_id : this.dataFiltro.empleado_id , sede_id : this.dataFiltro.sede_id , fecha_corte : fec_cor}).then(() => {
                this.rows = this.preliquidaciondoctor
                this.$refs.table1.updateScrollbar(true);
                this.paginationInfo.text = `<strong>`+ this.rows.length+` registros / `+ this.paginationInfo.pageSize+` reg. x página</strong>`
                this.loading = false            
            }) 
            this.cargaDatos2()                
        },
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
            let self = this
            this.seleccionados = rows
            let valor_atenciones = 0.00
            let valor_liquidar = 0.00
            this.label_total_atenciones = 0.00
            this.label_total_liquidar = 0.00
            if(this.seleccionados.length > 0){
                _.each(self.seleccionados, function(value,key){
                    valor_atenciones += parseFloat(value.costo)
                    valor_liquidar += parseFloat(value.neto)
                    self.label_total_atenciones = parseFloat(valor_atenciones).toFixed(2)
                    self.label_total_liquidar = parseFloat(valor_liquidar).toFixed(2)
                    self.netoliquidacion(self.label_total_liquidar,self.label_total_abonos,self.label_total_descuentos)
                })
            }else{
                this.netoliquidacion(this.label_total_liquidar,this.label_total_abonos,this.label_total_descuentos)
            }

        },
        getRowClassName ({row, rowIndex}) {
            let encontrado = this.seleccionados.filter(sel => sel.presupuestooperatoriadetalle_id == row.presupuestooperatoriadetalle_id)      
            if(encontrado.length > 0){
                return 'seleccionado'
            }
            return 'no-seleccionado'
        },
        cargaDatos2(){        
            this.loading2 = true
            let self = this
            this.tableData = []
            let filtrados = this.transacciones_doctor.filter(trad => trad.sede_id == this.dataFiltro.sede_id && trad.empleado_id == this.dataFiltro.empleado_id && moment(trad.fecha,'DD-MM-YYYY').isSameOrBefore(moment(this.dataFiltro.fecha_corte,'DD-MM-YYYY')) && trad.liquidado == 0 && trad.origen == 1)
            _.each(filtrados, function(value,key){
                let files= {
                    id:value.id,
                    type:value.concepto.type,
                    tipo:value.concepto.type == 1 ? 'ABONO': 'DESCUENTO',
                    concepto:value.concepto.nombre_concepto,
                    descripcion:value.descripcion,
                    fecha:value.fecha,
                    monto:value.total
                }
                let copyfile = _.clone(files)
                self.tableData.push(copyfile)
            })
            this.getTableData2()            
        },
        getTableData2(){
            this.rows2 = this.tableData
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
            let self = this
            this.seleccionados2 = rows
            let valor_abonos = 0.00
            let valor_descuentos = 0.00
            this.label_total_abonos = 0.00
            this.label_total_descuentos = 0.00
            if(this.seleccionados2.length > 0){
                _.each(self.seleccionados2, function(value,key){
                    if(value.type == 1){
                        valor_abonos += parseFloat(value.monto)
                    }else{
                        valor_descuentos += parseFloat(value.monto)                    
                    }
                    self.label_total_abonos = parseFloat(valor_abonos).toFixed(2)
                    self.label_total_descuentos = parseFloat(valor_descuentos).toFixed(2)
                    if(self.seleccionados.length > 0){
                        self.netoliquidacion(self.label_total_liquidar,self.label_total_abonos,self.label_total_descuentos)
                    }
                }) 
            }else{
                this.netoliquidacion(this.label_total_liquidar,this.label_total_abonos,this.label_total_descuentos)
            }
           
        }, 
        getRowClassName2 ({row, rowIndex}) {
            let encontrado = this.seleccionados2.filter(sel => sel.id == row.id)      
            if(encontrado.length > 0){
                return 'seleccionado'
            }
            return 'no-seleccionado'
        },
        accion_nav(param){
            if(param == 1){     // produccion
                this.loading = true
                setTimeout(() => {                    
                    this.$refs.table1.updateScrollbar(true)
                    this.loading = false
                }, 2000); 
            }else{              // abonos
                this.loading2 = true
                setTimeout(() => {
                    this.$refs.table2.updateScrollbar(true)
                    this.loading2 = false
                }, 2000); 
            }
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
               origen:1,        // 1. operatoria 2.ortodoncia
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
               origen:1,        // 1. operatoria 2.ortodoncia
               user_id:this.user_system.id 
            }           
            this.textTransaccion = "Abono"
            this.$modal.show('transacciones')
        },
        createTransaccion(){
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
            this.$store.dispatch('LOAD_TRANSACCIONES_DOCTOR_LIST').then(() => {
                this.cargaDatos2()
            })    
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
        eliminarAbono(param){
            console.log("param",param)
        },
        netoliquidacion(prod,abo,des){
            let neto = 0.00
            neto = parseFloat(prod) + (parseFloat(abo) - parseFloat(des))
            this.neto_a_liquidar = parseFloat(neto).toFixed(2)
        },
        createLiquidacion(){
            this.dataLiquidacion = {
                empleado_id:this.dataFiltro.empleado_id,
                sede_id:this.dataFiltro.sede_id,
                fecha_corte:moment(this.dataFiltro.fecha_corte).format('DD-MM-YYYY hh:mm:ss'),
                monto_total_atenciones:this.label_total_atenciones,
                monto_total_abonos:this.label_total_abonos,
                monto_total_descuentos:this.label_total_descuentos,
                monto_total_liquidar:this.neto_a_liquidar,
                motivo_eliminacion:'',
                tipo:1,         // 1.terminado   2.abonos
                moneda_id:1,
                pagado:0,
                user_id:this.user_system.id,
                detalle:this.seleccionados,
                transacciones:this.seleccionados2
            }            
            this.$swal({
                title: 'Desea liquidar estos items?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, Liquidar!'
                }).then((result) => {
                    if (result.value) {
                        this.isLoading = true
                        var url = '/api/liquidacionoperatoria';     
                        axios.post(url, this.dataLiquidacion).then(response => {
                        if(typeof(response.data.errors) != "undefined"){
                            this.errors = response.data.errors;
                            var resultado = "";
                            for (var i in this.errors) {
                                if (this.errors.hasOwnProperty(i)) {
                                    resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                                }
                            }
                            this.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                              
                            return;
                        }
                        this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_DETALLES_LIST').then(() => {
                            this.$store.dispatch('LOAD_TRANSACCIONES_DOCTOR_LIST').then(() => {
                                this.cargaDatos()
                                this.isLoading = false
                                this.neto_a_liquidar = 0.00
                                this.$swal(
                                'Liquidados!',
                                'los Registros fueron liquidados con exito.',
                                'success'
                                )   
                            })
                         
                        })       
                        this.errors = [];             
                        //this.notificaciones('Nueva Liquidación creada con exito','la la-thumbs-up','success')                           
                        }).catch(error => {
                        this.errors = error.response.data.status;
                        this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')           
                        });
                    }else{
                        //
                    }
                });

        },
        cargaDatosLiquidacion(){         
            this.loading3 = true
            let fec_ini = moment(this.dataFiltroPL.fecha_desde).format('DDMMYYYY')
            let fec_fin = moment(this.dataFiltroPL.fecha_hasta).format('DDMMYYYY')            
            this.$store.dispatch('LOAD_LIQUIDACIONES_SEDES_LIST',{ sede_id : this.dataFiltroPL.sede_id , fecha_desde : fec_ini , fecha_hasta : fec_fin}).then(() => {
                this.rows3 = this.liquidacionessedes
                this.$refs.table3.updateScrollbar(true);
                this.paginationInfo3.text = `<strong>`+ this.rows3.length+` registros / `+ this.paginationInfo3.pageSize+` reg. x página</strong>`
                this.loading3 = false            
            })         
        },
        handleSortChange3( {prop, order}) {
            this.loading3 = true;
            let list = [].concat(this.rows3);
            list.sort((item1, item2) => {
                let val1 = '';
                let val2 = '';

                if (prop === 'fecha_liquidacion') {
                    val1 = new Date(item1[prop]).getTime();
                    val2 = new Date(item2[prop]).getTime();
                    if (order === 'descending') {
                    return val2 < val1 ? -1 : 1
                    }
                    return val1 < val2 ? -1 : 1
                }

                if (prop === 'numero_liquidacion' || prop === 'sede' || prop === 'empleado' || prop === 'estado') {
                    val1 = item1[prop];
                    val2 = item2[prop]
                    if (order === 'descending') {
                    return val2 < val1 ? -1 : 1
                    }
                    return val1 < val2 ? -1 : 1
                }
            });
            setTimeout (() => {
                this.loading3 = false;
                this.rows3 = [].concat(list);
            }, 2000);
        },
        handlePageChange3(page) {
            this.currentPage3 = page;
            this.loading3 = true;
            let start = (page - 1) * 10 + 1;

            const list = this.rows3.map(item => {
                return Object.assign({}, item, {
                    name: `test${start++}`
                });
            });

            setTimeout(() => {
                this.loading3 = false;
                this.rows3 = [].concat(list);
            }, 2000);  
        },
        pagarLiquidacion(param){
            this.dataPago.monto = parseFloat(param.total).toFixed(2)
            this.dataPago.liquidacionoperatoria_id = param.id
            this.dataPago.serie = ''
            this.dataPago.numero = ''
            this.generar = false
            this.$modal.show('pago_liquidacion')
        },
        verLiquidacion(param){
            this.datos = param
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
                        this.loading3 = true
                        var url = '/api/liquidacionesoperatorias/facturar/'+ this.dataPago.liquidacionoperatoria_id;
                        axios.put(url, this.dataPago).then(response => {
                        if(typeof(response.data.errors) != "undefined"){
                            this.errors = response.data.errors;
                            var resultado = "";
                            for (var i in this.errors) {
                                if (this.errors.hasOwnProperty(i)) {
                                    resultado += "error -> " + i + " = " + this.errors[i] + "\n";
                                }
                            }
                            this.loading3 = false
                            this.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                              
                            return;
                        }
                        this.errors = []; 
                        this.$modal.hide('pago_liquidacion')   
                        this.notificaciones('Datos actualizados con exito','la la-thumbs-up','success')                                                 
                        this.cargaDatosLiquidacion()                       
                        }).catch(error => {
                        this.errors = error.response.data.status;                 
                        this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')           
                        this.loading3 = false
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
    /* --- div Resumen --*/
    .transfer-to {
        line-height: 30px;        
    }      
    .transfer-to .sub {
        font-size: 14px;
        margin-bottom: 8px;
        font-weight: 600;
        padding: 10px !important;
    }
    .transfer-to .account-transfer>div {
        display: flex;
        justify-content: space-between;
    }     
    .transfer-to .account-transfer>div span:first-child {
        font-weight: 600;
        color: #333;
        font-size: 12px;
    }
    .transfer-to .account-transfer>div span:last-child {
        font-size: 12px;
    }  
    .btn .btn-label i {
        margin-left: 0 !important;
        margin-right: 0 !important;
    }     
</style>

