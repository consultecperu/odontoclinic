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
                <div class="col-9">
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group form-group-default" >
                                <label for="historia" class="text-primary font-weight-bold">Paciente </label>
                                <p class="form-control-static mb-0" v-text="dataPaciente.nombre_completo"></p>
                            </div>
                        </div>
                        <div class="col-4 pl-0 pr-0">
                            <div class="form-group form-group-default" >
                                <label for="historia" class="text-primary font-weight-bold">Num. Historia </label>
                                <p class="form-control-static text-center mb-0" v-text="dataPaciente.historiaclinica"></p>
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
                        <div class="col-4 pl-0">
                            <div class="form-group form-group-default" >
                                <label for="historia" class="text-primary font-weight-bold">Plan </label>
                                <p class="form-control-static text-truncate mb-0" v-text="dataPaciente.plan"></p>
                            </div>
                        </div>
                        <div class="col-4 pl-0 pr-0">
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
                                <select class="form-control mt-5" id="medicos" v-model="dataPaciente.empleado_id">
                                    <option value="">-- Seleccione --</option>
                                    <option v-for="med in getMedicos" :value="med.id" :key="med.id">
                                        {{ med.nombre_completo}}
                                    </option>
                                </select>                                
                            </div>
                        </div>
                        <div class="col-2 pl-0 pr-0">
                            <div class="form-group form-group-default" >
                                <label for="historia" class="text-primary font-weight-bold">Fecha </label>
                                <p class="form-control-static mt-5 mb-0" v-text="dataPaciente.fecha"></p>
                            </div>
                        </div>
                        <div class="col-2 pr-0">
                            <div class="form-group form-group-default" >
                                <label for="historia" class="text-primary font-weight-bold">T.C </label>
                                <p class="form-control-static mt-5 mb-0" v-text="dataPaciente.tipocambio"></p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <button class="btn btn-danger btn-sm btn-round float-right mb-10" @click.prevent="$router.go(-1)"><span class="btn-label"><i class="la la-angle-double-left"></i></span>Volver</button>             
                   
                    <button class="btn btn-info btn-block btn-sm" @click.prevent="Tratamientos_sin_piezas"><span class="btn-label"><i class="la la-info"></i></span>Tx sin Piezas</button>
                    <button class="btn btn-default btn-block btn-sm" v-if="$route.params.idpresupuesto != undefined" @click.prevent="createPDF"><span class="btn-label"><i class="la la-info"></i></span>Imprimir</button>
                    <button class="btn btn-success btn-block btn-sm" v-if="$route.params.idpresupuesto == undefined" @click.prevent="CrearDatosPpto"><span class="btn-label"><i class="la la-check"></i></span>Grabar</button>
                    <button class="btn btn-warning btn-block btn-sm" v-if="!select_multi" @click.prevent="select_multi = true"><span class="btn-label"><i class="la la-exclamation-circle"></i></span>Seleccion Multiple</button>             
                    <button class="btn btn-danger btn-block btn-sm" v-if="select_multi" @click.prevent="cancelarMultiple"><span class="btn-label"><i class="la la-exclamation-circle"></i></span>Cancelar Multiple</button>             
                    <button class="btn btn-primary btn-block btn-sm" v-if="select_multi" :disabled="!(list_dent_multiple.length > 1)" @click.prevent="LoadServices"><span class="btn-label"><i class="la la-bookmark"></i></span>Cargar Servicios</button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group border border-primary pt-0 pb-0">
                        <p class="form-control-static text-primary font-weight-bold mb-10">Tipo de Dentición </p>
                        <p-radio v-for="tip in tiposOdontograma" class="p-icon p-curve p-tada" :key="tip.id" :value="tip.id" name="radio77" color="primary-o" v-model="dataPresupuesto.tipo_odontograma" @change="cambioTipo(tip.id)" :disabled="$route.params.idpresupuesto != undefined">
                            <i slot="extra" class="icon la la-check"></i><label class="text-primary font-weight-bold float-left">{{ tip.nombre }} </label>                              
                        </p-radio>  
                    </div>

                </div>              
            </div>
            <!-- Inicio de Odontograma -->
            <div class="row" ref="printMe">
                <div class="col-12">
                    <p class="form-control-static text-center font-weight-bold mb-0" :class="{ 'text-warning': select_multi }">BUCAL</p>
                </div>
                <div class="col-12">
                    <div class="row">
                        <div class="col-1 d-flex align-items-center">
                            <div class="texto-vertical" :class="{ 'text-warning': select_multi }">
                                DERECHA
                            </div>
                        </div>
                        <div class="col-10">
                            <div class="row">
                                <div class="col-6" :class="[ select_multi ? 'borde-derecho-multi' : 'borde-derecho' ]">
                                    <div class="row d-flex justify-content-end" v-for="i in cuadrante_izquierdo_superior" :key="i">
                                        <div v-for="info in getDientesByCuadrante(i)" :key="info.id" class="dientito">
                                            <p class="form-control-static text-center mb-0" :class="{seleccionado:contains(list_dent_multiple,info),'text-danger':contains(list_dent_multiple,info)}" v-tooltip.top-start="info.nombre_diente" :id="'t'+info.id">{{ info.codigo }}</p>
                                            <input type="text" :id="'d'+info.id" class="texto-dientito" maxlength="3" v-model="dataPresupuesto.text_up_dent[info.id]" @focus="guardaDatoTexto(info.id)" @blur="grabaDatoTexto(info.id)"> 
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" height="64" :class="info.tipo" width="32" :id="info.id" @click.prevent="ShowDiente(info)" @contextmenu.prevent="menuPopup(info)">
                                                    <!-- Caras del diente -->
                                                    <polygon points="6,38 30,38 24,44 12,44" :style="BuscoCara(info,'1')" /> <!-- CARA 1 Trapecio superior -->
                                                    <polygon points="30,38 30,62 24,56 24,44" :style="BuscoCara(info,'2')"/> <!-- CARA 2 Trapecio lateral derecho -->
                                                    <polygon points="30,62 6,62 12,56 24,56" :style="BuscoCara(info,'3')" /> <!-- CARA 3 Trapecio inferior -->
                                                    <polygon points="6,62 12,56 12,44 6,38" :style="BuscoCara(info,'4')"/> <!-- CARA 4 trapecio lateral izquierdo-->
                                                    <polygon points="12,44 24,44 24,56 12,56" :style="BuscoCara(info,'5')" /> <!-- CARA 5 Cuadrado Central -->
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
                                            <p class="form-control-static text-center mb-0" :class="{seleccionado:contains(list_dent_multiple,info),'text-danger':contains(list_dent_multiple,info)}" v-tooltip.top-start="info.nombre_diente" :id="'t'+info.id">{{ info.codigo }}</p>
                                            <input type="text" name="" :id="'d'+info.id" class="texto-dientito" maxlength="3" v-model="dataPresupuesto.text_up_dent[info.id]" @focus="guardaDatoTexto(info.id)" @blur="grabaDatoTexto(info.id)"> 
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" height="64" :class="info.tipo" width="32" :id="info.id" @click.prevent="ShowDiente(info)" @contextmenu.prevent="menuPopup(info)">
                                                    <!-- Caras del Diente -->
                                                    <polygon points="6,38 30,38 24,44 12,44" :style="BuscoCara(info,'1')"/> <!-- CARA 1 Trapecio superior -->
                                                    <polygon points="30,38 30,62 24,56 24,44" :style="BuscoCara(info,'2')"/> <!-- CARA 2 Trapecio lateral derecho -->
                                                    <polygon points="30,62 6,62 12,56 24,56" :style="BuscoCara(info,'3')"/> <!-- CARA 3 Trapecio inferior -->
                                                    <polygon points="6,62 12,56 12,44 6,38" :style="BuscoCara(info,'4')"/> <!-- CARA 4 trapecio lateral izquierdo-->
                                                    <polygon points="12,44 24,44 24,56 12,56" :style="BuscoCara(info,'5')"/> <!-- CARA 5 Cuadrado Central -->
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
                            <div class="row" :class="[ select_multi ? 'borde-inferior-multi' : 'borde-inferior' ]">
                                <div class="col-12">
                                    <p class="form-control-static text-center font-weight-bold mb-0" :class="{ 'text-warning': select_multi }">LINGUAL</p>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6" :class="[ select_multi ? 'borde-derecho-multi' : 'borde-derecho' ]">
                                    <div class="row d-flex justify-content-end" v-for="i in cuadrante_izquierdo_inferior" :key="i">
                                        <div v-for="info in getDientesByCuadrante(i)" :key="info.id" class="dientito">
                                            <p class="form-control-static text-center mb-0" :class="{seleccionado:contains(list_dent_multiple,info),'text-danger':contains(list_dent_multiple,info)}" v-tooltip.top-start="info.nombre_diente" :id="'t'+info.id">{{ info.codigo }}</p>
                                            <input type="text" name="" :id="'d'+info.id" class="texto-dientito" maxlength="3" v-model="dataPresupuesto.text_up_dent[info.id]" @focus="guardaDatoTexto(info.id)" @blur="grabaDatoTexto(info.id)"> 
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" height="64" :class="info.tipo" width="32" :id="info.id" @click.prevent="ShowDiente(info)" @contextmenu.prevent="menuPopup(info)">
                                                    <!-- Caras del Diente -->
                                                    <polygon points="6,38 30,38 24,44 12,44" :style="BuscoCara(info,'1')"/> <!-- CARA 1 Trapecio superior -->
                                                    <polygon points="30,38 30,62 24,56 24,44" :style="BuscoCara(info,'2')"/> <!-- CARA 2 Trapecio lateral derecho -->
                                                    <polygon points="30,62 6,62 12,56 24,56" :style="BuscoCara(info,'3')"/> <!-- CARA 3 Trapecio inferior -->
                                                    <polygon points="6,62 12,56 12,44 6,38" :style="BuscoCara(info,'4')"/> <!-- CARA 4 trapecio lateral izquierdo-->
                                                    <polygon points="12,44 24,44 24,56 12,56" :style="BuscoCara(info,'5')"/> <!-- CARA 5 Cuadrado Central -->
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
                                            <p class="form-control-static text-center mb-0" :class="{seleccionado:contains(list_dent_multiple,info),'text-danger':contains(list_dent_multiple,info)}" v-tooltip.top-start="info.nombre_diente" :id="'t'+info.id">{{ info.codigo }}</p>
                                            <input type="text" name="" :id="'d'+info.id" class="texto-dientito" maxlength="3" v-model="dataPresupuesto.text_up_dent[info.id]" @focus="guardaDatoTexto(info.id)" @blur="grabaDatoTexto(info.id)"> 
                                            <div>
                                                <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" xml:space="preserve" height="64" :class="info.tipo" width="32" :id="info.id" @click.prevent="ShowDiente(info)" @contextmenu.prevent="menuPopup(info)">
                                                    <!-- Caras del Diente-->
                                                    <polygon points="6,38 30,38 24,44 12,44" :style="BuscoCara(info,'1')"/> <!-- CARA 1 Trapecio superior -->
                                                    <polygon points="30,38 30,62 24,56 24,44" :style="BuscoCara(info,'2')"/> <!-- CARA 2 Trapecio lateral derecho -->
                                                    <polygon points="30,62 6,62 12,56 24,56" :style="BuscoCara(info,'3')"/> <!-- CARA 3 Trapecio inferior -->
                                                    <polygon points="6,62 12,56 12,44 6,38" :style="BuscoCara(info,'4')"/> <!-- CARA 4 trapecio lateral izquierdo-->
                                                    <polygon points="12,44 24,44 24,56 12,56" :style="BuscoCara(info,'5')"/> <!-- CARA 5 Cuadrado Central -->
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
                            <div class="texto-vertical" :class="{ 'text-warning': select_multi }">
                                IZQUIERDA
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <p class="form-control-static text-center font-weight-bold mb-0" :class="{ 'text-warning': select_multi }">BUCAL</p>
                </div>              
            </div>
            <!-- Fin de Odontograma -->
            <div class="row">
                <div class="col-12 pr-20 mb-10 pt-10">
                    <button type="button" class="btn btn-sm btn-danger float-right ml-10" :disabled="checkTxs.length == 0" @click.prevent="EliminarItemsMultiple" ><span class="btn-label"><i class="la la-trash-o"></i></span> Eliminar Item(s)</button>
                    <button type="button" class="btn btn-sm btn-primary float-right" v-if="dataPaciente.tipo_plan == 1" :disabled="checkTxs.length == 0"  @click.prevent="AplicarDescuentoMultiple"><span class="btn-label"><i class="la la-calculator font-large"></i></span> Aplicar Descuento</button>
                </div>
            </div>          
            <div class="row pl-20 pr-20">
                <table class="table table-bordered table-sm table-head-bg-info table-bordered-bd-info">
                    <thead>
                        <tr>
                            <th align="center" class="text-center" style="width: 15px !important;">
                                <input id="" type="checkbox" @change.prevent="marcarAllTx" v-model="checkAllTx">
                            </th>                            
                            <th scope="col">Diente</th>
                            <th scope="col">Servicio</th>
                            <th scope="col">Moneda</th>
                            <th scope="col">Deducible</th>
                            <th scope="col">Coaseguro</th>
                            <th scope="col">P.Aseg</th>     
                            <th scope="col">C.Total</th> 
<!--                             <th scope="col"></th>  -->                                                                                                                        
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(serv, index) in lista_general_presupuesto" :key="serv.id">
                            <td align="center">
                                <input :id="'checkbox-type-rounded'+ index" type="checkbox" v-model="checkTxs" :value="index" @change.prevent="change_checkTxs(index)">
                            </td>
                            <td>{{ serv.letras }}</td>
                            <td>{{ serv.nombre_servicio}}</td> 
                            <td>{{ serv.nombre_moneda}}</td>
                            <td align="center">{{ serv.deducible}}</td>
                            <td align="center">{{ serv.solocoaseguro}}</td>  
                            <td align="center">{{ serv.pago_aseguradora}}</td>   
                            <td align="center">{{ serv.costo}}</td> 
<!--                             <td><button type="button" v-tooltip="'Eliminar Item'" class="btn btn-danger btn-xs" @click.prevent="borrarItem(serv,index)">
                                    <i class="la la-trash-o font-large"></i>
                                </button>
                                <button type="button" v-if="$route.params.idpresupuesto == undefined && dataPaciente.tipo_plan == 1" v-tooltip="'Descuento'" class="btn btn-success btn-xs" @click.prevent="AplicaDescuento(serv,index)">
                                    <i class="la la-calculator font-large"></i>
                                </button>
                            </td> -->                                                                                                                        
                        </tr>
                        <tr v-if="lista_general_presupuesto.length == 0">
                            <td colspan="9" class="text-center">NO HAY SERVICIOS CARGADOS ...</td>                                           
                        </tr>
                        <tr v-else>
                            <td colspan="2">Totales</td>
                            <td v-if="dataPaciente.tipo_plan == 1">Cliente: {{ costoTotal }}</td>
                            <td v-if="dataPaciente.tipo_plan == 2">Clientes: {{ costoCliente }}</td>
                            <td colspan="2">Aseguradora:</td>
                            <td colspan="4" v-if="dataPaciente.tipo_plan == 1">Total: 0.00</td>
                            <td colspan="4" v-if="dataPaciente.tipo_plan == 2">Total: {{ costoAseguradora }}</td>                            
                        </tr>
                    </tbody>
                </table>                                
            </div>            
        </div>
        <!-- PAGE CONTENT MODAL -->  
        <modal name="carga_servicios" :width="'65%'" :height="'auto'" transition="pop-out" :scrollable="true" :clickToClose="false">
            <!-- form de registro de servicios -->
                <div class="card mb-0">
                    <div class="card-header bg-primary pt-10 pb-10">
                        <div class="card-title d-inline text-white">Presupuesto</div>
                        <button type="button" class="close d-inline text-white" aria-label="Close" @click.prevent="$modal.hide('carga_servicios')">
                            <span aria-hidden="true">&times;</span>
                        </button>                        
                    </div>
                    <div class="card-body">
                        <div class="row pb-20">
                            <div class="col-9 pr-0">
                                <div class="row pl-20 font-weight-bold pb-10">Tratamientos</div>
                                <div class="row pl-20">
                                    <div v-for="sim in simbolos" :key="sim.id"  class="d-inline pr-10 pl-0">
                                        <div class="title-simbologia text-center text-white pt-3 pb-3 pl-5 pr-5 rounded" :class="[ sim.id == selected ? 'bg-danger' : 'bg-ppto']">{{ sim.id == 1 ? 'SUPERFICIE' : sim.nombre_simbologia}}                                    
                                        </div>
                                        <div class="form-check form-check-inline pl-0 mr-0">
                                            <p-radio class="p-icon p-curve p-tada mr-0" :value="sim.id" name="radio66" color="primary-o" v-model="simboloID" @change="cambiotratamiento(sim.id)">
                                                <i slot="extra" class="icon la la-check"></i>                                
                                            </p-radio>
                                            <div>
                                                <svg height="42" width="42" :id="'tratam_' + sim.id">
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
                            </div>
                            <div class="col-3 pl-0">
                                <div class="row">
                                    <svg height="120" width="120" id="diente_servicios" style="margin:0 auto !important;">
                                        <!-- Caras del Diente -->                                        
                                        <polygon points="0,0 120,0 90,30 30,30" v-tooltip.top="toolTipDiente.cara_1" :class="[simboloID == 1 && multicaras.includes(1) ? 'marcadoRojo marcado' : 'diente']" @click.prevent="selectD(1)" /> <!-- CARA 1 Trapecio superior -->
                                        <polygon points="120,0 120,120 90,90 90,30" v-tooltip.right="toolTipDiente.cara_2" :class="[simboloID == 1 && multicaras.includes(2) ? 'marcadoRojo marcado' : 'diente']" @click.prevent="selectD(2)" /> <!-- CARA 2 Trapecio lateral derecho -->
                                        <polygon points="120,120 0,120 30,90 90,90" v-tooltip.bottom="toolTipDiente.cara_3" :class="[simboloID == 1 && multicaras.includes(3) ? 'marcadoRojo marcado' : 'diente']" @click.prevent="selectD(3)"/> <!-- CARA 3 Trapecio inferior -->
                                        <polygon points="0,120 30,90 30,30 0,0" v-tooltip.left="toolTipDiente.cara_4" :class="[simboloID == 1 && multicaras.includes(4) ? 'marcadoRojo marcado' : 'diente']" @click.prevent="selectD(4)" /> <!-- CARA 4 trapecio lateral izquierdo-->
                                        <polygon points="30,30 90,30 90,90 30,90" v-tooltip.top="toolTipDiente.cara_5" :class="[simboloID == 1 && multicaras.includes(5) ? 'marcadoRojo marcado' : 'diente']" @click.prevent="selectD(5)" /> <!-- CARA 5 Cuadrado Central -->
                                        <!-- Tratamientos del Diente -->
                                        <polygon points="55,5 67,5 67,115 55,115" :class="[simboloID == 2 ? 'marcadoEndodonciaD marcado' : 'endodoncia']"/>                                           
                                        <circle cx="60" cy="60" r="50" :class="[simboloID == 3 ? 'marcadoCoronaD marcado' : 'corona']"/>
                                        <polygon points="0,10 10,0 120,110 110,120" :class="[simboloID == 4 ? 'marcadoExodonciaD marcado' : 'exodoncia']"/>                                    
                                        <polygon points="110,0 120,10 10,120 0,110" :class="[simboloID == 4 ? 'marcadoExodonciaD marcado' : 'exodoncia']" />
                                        <image v-if="simboloID == 5" xlink:href="/img/odontograma/perno4.png" x=0 y=0 width=120 height=120 />                                        
                                        <path d="M 10,65 a30,30 0 1,1 100,0" :class="[simboloID == 6 ? 'marcadoIonomeroD marcado' : 'ionomero']"></path>
                                        <text x=20 y=105 :class="[simboloID == 7 ? 'marcadoSellanteD marcado' : 'sellante']">S</text>                                                                        
                                        <ellipse cx="60" cy="60" rx="55" ry="25"  :class="[simboloID == 8 ? 'marcadoGeneralD marcado' : 'general']"/>
                                        <line x1="5" y1="60" x2="115" y2="60" :class="[simboloID == 8 ? 'marcadoGeneralD marcado' : 'general']"/>                                    
                                    </svg>                                    
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-12">
                                <button type="button" class="btn btn-danger btn-sm" @click.prevent="cargaTratamientos">Buscar Servicios <i class="la flaticon-search-2"></i></button>
                            </div>
                        </div>
                        <div class="row mt-10">
                            <div class="col-12">
                                <table class="table table-bordered table-sm table-head-bg-primary table-bordered-bd-primary">
                                    <thead>
                                        <tr>
                                            <th>Diente</th>
                                            <th>Servicio</th>
                                            <th>Moneda</th>
                                            <th>Deducible</th>
                                            <th>Coaseguro</th>
                                            <th>P.Aseg</th>     
                                            <th>C.Total</th>
                                            <th>Pago</th>  
                                            <th></th>                                                                                                                        
                                        </tr>
                                    </thead>
                                    <tbody>                                        
                                        <tr v-for="(serv, index) in list_services_anteriores" :key="serv.id">
                                            <td>{{ serv.letras }}</td>
                                            <td>{{ serv.nombre_servicio}}</td>
                                            <td>{{ serv.nombre_moneda}}</td>
                                            <td align="right">{{ serv.deducible}}</td>
                                            <td align="right">{{ serv.solocoaseguro}}</td>  
                                            <td align="right">{{ serv.pago_aseguradora}}</td>   
                                            <td align="right">{{ serv.costo}}</td> 
                                            <td align="right">{{ serv.costo}}</td> 
                                            <td align="center"><button type="button" class="btn btn-xs btn-danger" @click.prevent="EliminaServicio(index)" disabled><span class="btn-label pl-5"><i class="la la-trash"></i></span></button></td>                                                                                                                        
                                        </tr>
                                        <tr v-for="(serv, index) in list_services_dent" :key="serv.id">
                                            <td>{{ serv.letras }}</td>
                                            <td>{{ serv.nombre_servicio}}</td>
                                            <td>{{ serv.nombre_moneda}}</td>
                                            <td align="right">{{ serv.deducible}}</td>
                                            <td align="right">{{ serv.solocoaseguro}}</td>  
                                            <td align="right">{{ serv.pago_aseguradora}}</td>   
                                            <td align="right">{{ serv.costo}}</td>  
                                            <td align="right">{{ serv.costo}}</td> 
                                            <td align="center"><button type="button" class="btn btn-xs btn-danger" @click.prevent="EliminaServicio(index)" v-tooltip.top="'Eliminar'"><span class="btn-label pl-5"><i class="la la-trash"></i></span></button></td>                                                                                                                        
                                        </tr>                                        
                                        <tr v-if="list_services_dent.length == 0 && list_services_anteriores.length == 0">
                                            <td colspan="9" class="text-center">NO HAY SERVICIOS CARGADOS ...</td>                                           
                                        </tr>
                                    </tbody>
                                </table>                                
                            </div>
                        </div>
                    </div>
                    <div class="card-action pt-10 pb-10 pr-20">
                        <button class="btn btn-danger float-right ml-10" @click="salirDiente"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
                        <button class="btn btn-primary float-right" :disabled="list_services_dent.length == 0" @click.prevent="ActionServicio"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
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
                        :rows="TratamientosSimbolo"
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
        <modal id="tratamientos_sin_piezas" name="tratamientos_sin_piezas" :width="'60%'" height="auto" transition="pop-out" :scrollable="true" :clickToClose="false" >
           <div class="card mb-0">
                <div class="card-header">
                    <div class="card-title d-inline">Seleccione un Servicio</div>
                    <button type="button" class="close d-inline" aria-label="Close" @click.prevent="$modal.hide('tratamientos_sin_piezas')">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="card-body">
                     <div class="col">
                        <!-- START DEFAULT DATATABLE -->
                        <vue-good-table
                        :columns="columns_servicios"
                        :rows="TratamientosSimbolo"
                        :paginationOptions="{
                            enabled: true,
                            dropdownAllowAll: false,
                            nextLabel: 'Sig',
                            prevLabel: 'Ant',
                            rowsPerPageLabel: 'Registros por Pagina',
                            ofLabel: 'de',
                            allLabel: 'Todos',
                        }"
                        @on-row-dblclick="selectServicioSinPiezas"
                        :rowStyleClass="'enlace'"
                        max-height="400px"
                        styleClass="vgt-table condensed bordered striped"> 
                        <template slot="table-row" slot-scope="props">
                            <span v-if="props.column.field == 'btn'" class="center">
                                <button type="button" data-toggle="tooltip" title="" class="btn btn-primary btn-xs" data-original-title="" @click.prevent="selectServicioSinPiezas(props)">
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
                    <div class="row" v-if="igual_monto">
                        <div class="col-12">
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
                    <div class="row" v-else>
                        <div class="col-12">
                            <p class="form-control-static mb-0">Descuento por Porcentaje</p>
                        </div>
                    </div>
                    <div class="row" v-if="igual_monto">
                        <div class="col-12">
                            <div class="form-group pt-0 pb-0">
                                <label for="nombre" class="text-primary font-weight-bold">Monto Actual <span class="required-label"> *</span></label>
                                <input type="text" id="nombre" class="form-control form-control-sm border border-primary" v-model="dataDescuento.monto_actual" disabled>
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
                    <div class="row" v-if="igual_monto">
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
        <context-menu id="context-menu" ref="ctxMenu">
            <li @click.prevent="deleteItem">Eliminar</li>
            <li @click.prevent="ausenteItem" v-if="contains(odontograma,deleteDent.id)">Ausente</li>
            <li @click.prevent="normalItem" v-if="contains(list_dent_missing,deleteDent.id)">Normal</li>
        </context-menu>                                        
    </div>
</template>
<script>
import mixin from '../../../mixins.js'
import  {_} from 'vue-underscore'
import jsPDF from 'jspdf'
import html2canvas from 'html2canvas'
//import '../../jquery-js/jquery-odontograma.js'
import { mapState, mapGetters } from 'vuex'
export default {
    name: 'ppto-operatoria',
    mixins: [mixin],  
    created(){
        this.$store.dispatch('LOAD_DIENTES_LIST') 
        this.$store.dispatch('LOAD_SIMBOLOGIAS_LIST')   
        this.$store.dispatch('LOAD_TARIFARIOS_LIST') 
        this.$store.dispatch('LOAD_EMPLEADOS_LIST')     
        this.$store.dispatch('LOAD_TIPOCAMBIOS_LIST') 
        if(this.$route.params.idpresupuesto == undefined){
            this.dataPaciente = {
                id:this.PacienteById.id,
                nombre_completo:this.PacienteById.nombre_completo,
                historiaclinica:this.PacienteById.historiaclinica,
                empresa:this.PacienteById.pacienteplanes.tipo == 1 ? '-' : this.PacienteById.pacienteplanes.empresapaciente.razon_social,
                plan:this.PacienteById.pacienteplanes.plan.descripcion ,
                aseguradora:this.PacienteById.pacienteplanes.plan.descripcion ,
                empleado_id:this.PacienteById.empleado_id,
                fecha:moment().format('DD-MM-YYYY'),
                tipocambio:this.getTipoCambioHoy.tipo_cambio,
                deducible:this.PacienteById.pacienteplanes.tipo == 1 ? '0' : this.PacienteById.pacienteplanes.poliza.deducible,
                coaseguro:this.PacienteById.pacienteplanes.tipo == 1 ? '0' : this.PacienteById.pacienteplanes.poliza.coaseguro,
                tipo_plan: this.PacienteById.pacienteplanes.tipo
            } 
        }else{
            this.dataPaciente = {
                id:this.presupuestoOperatoriaById.paciente_id,
                nombre_completo:this.presupuestoOperatoriaById.paciente.nombre_completo,
                historiaclinica:this.presupuestoOperatoriaById.paciente.historiaclinica,
                empresa:this.presupuestoOperatoriaById.poliza_id == null ? '-' : this.presupuestoOperatoriaById.poliza.empresapaciente.razon_social,
                plan:this.presupuestoOperatoriaById.plan.descripcion ,
                aseguradora:this.presupuestoOperatoriaById.poliza_id == null ? '-' : this.presupuestoOperatoriaById.poliza.plane.descripcion,
                empleado_id:this.presupuestoOperatoriaById.empleado_id,
                fecha:moment(this.presupuestoOperatoriaById.fecha_registro).format('DD-MM-YYYY'),
                tipocambio:this.presupuestoOperatoriaById.tipocambio.tipo_cambio,
                deducible:this.presupuestoOperatoriaById.poliza_id == null ? '0' : this.presupuestoOperatoriaById.poliza.deducible,
                coaseguro:this.presupuestoOperatoriaById.poliza_id == null ? '0' : this.presupuestoOperatoriaById.poliza.coaseguro,
                tipo_plan: this.presupuestoOperatoriaById.tipo_presupuesto
            }
            this.newidPresupuesto = this.presupuestoOperatoriaById.id             
        }    
        window.addEventListener('scroll', this.handleScroll);                           
    },  
    mounted(){
        this.cambioTipo(1)
        this.CargaDetalleEdit()
    }, 
    destroyed(){
        window.removeEventListener('scroll', this.handleScroll);
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
                tipo_odontograma:1,
                detalle:[],
                ausentes:[],
                text_up_dent:[]
            },
            dataDetallePresupuesto:{
                tarifario_id:'',
                tarifa:'',
                moneda_id:'',
                deducible:'',
                solocoaseguro:'',
                pago_cliente:'',
                pago_aseguradora:'',
                costo:'',
                costo_base:'',
                descuento:'',
                tipo_odontograma:'',
                empleado_id:'',
                realizado:'',
                descargado:'',
                pagado:'',
                tipo_pagado:'',
                laboratorio_id:'',
                monto_lab:'',
                material_id:'',
                monto_mat:'',
                solicitud:'',
                user_id:'',
                diente_id:'',
                caras:'',
                letras:'',
                simbologia_id:'',
                texto_diente:''
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
                tipocambio:'',
                deducible:'',
                coaseguro:'',
                tipo_plan:''
            },
            dataTratamiento:{
                id:'',
                idppto:'',
                tarifario_id:'',
                diente_id: '',
                diente_codigo: '',
                texto_diente:'',
                caras: '',
                lados:'',
                simbologia: '',
                letras : '',
                servicio_id : '',
                nombre_servicio : '',
                costo_base:'',
                costo : '',
                moneda_id:'',
                nombre_moneda : '',
                descuento:'',
                realizado:'',
                deducible:'',
                solocoaseguro:'',
                pago_cliente:'',
                pago_aseguradora:'',
                activo:''
            },
            dataDescuento:{
                tipo:'0',
                monto_actual:'',
                porcentaje:'',
                nuevo_monto:'',
                descuento:''
            },
            dataPpto:{
                id:'',
                pago_cliente:'',
                pago_total:'',
                idDetalle:''
            },
            tiposOdontograma:[
                {id:1 , nombre:'permanente'},
                {id:2 , nombre:'decidua'},
                {id:3 , nombre:'mixta'}
            ],
            simboloID:'',
            //tipoOdonto:1,
            denteselect:'',
            infodent:'',
            multicaras:[],
            select_multi: false,
            list_dent_multiple:[],
            list_services_dent:[],          // nuevos servicios q se cargan al listado general del ppto
            list_services_anteriores:[],     // lista general de servicios anteriores cargados al diente 
            lista_general_presupuesto:[],   // listado general del presupuesto
            selected: undefined,
            odontograma:[],
            cuadrante_izquierdo_superior:[1,5],
            cuadrante_derecho_superior:[2,6],
            cuadrante_izquierdo_inferior:[8,4],
            cuadrante_derecho_inferior:[7,3],
            deleteDent:[],
            list_dent_missing:[],
            valor_texto_material:'',
            diente_ancla:[],            // diente de referencia en la seleccion multiple
            checkAllTx:'',              // check para marcar todos los tx en la tabla de nuevo tx
            checkTxs:[],
            igual_monto:true,           // para los descuentos masivos de los items

            diente: {
                cursor:'pointer', 
                cursor: 'hand' ,        
                fillOpacity:'0',
                stroke:'black',
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
                fill:'red',
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
                stroke : 'red',
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

            newidPresupuesto:'',
            toolTipDiente: {
                cara_1:'',
                cara_2:'',
                cara_3:'',
                cara_4:'',
                cara_5:''
            }

        }
    },
    computed: {
        ...mapState(['user_system','sede_system','dientes','simbologias','tarifarios']),
        ...mapGetters(['getDientesByCuadrante','getPacienteById','getMedicos','getTipoCambioHoy','getTratamientosSimbolo','getTratamientosSimboloNew','getPresupuestoOperatoriaById']), 
        PacienteById(){
            return this.getPacienteById(this.$route.params.idpaciente)
        },  
        simbolos(){
            return _.sortBy(this.simbologias, 'id');
        },
        TratamientosSimbolo(){
            return this.getTratamientosSimbolo(this.simboloID,this.PacienteById.pacienteplanes.plan_id,this.sede_system.id,this.sede_system.plan_id,this.multicaras.length)
        },
        TratamientosSimboloNew(){
            //console.log("servicio_odonto",this.getTratamientosSimboloNew(this.simboloID,this.PacienteById.pacienteplanes.plan_id,this.sede_system.id,this.sede_system.plan_id))
            return this.getTratamientosSimboloNew(this.simboloID,this.PacienteById.pacienteplanes.plan_id,this.sede_system.id,this.sede_system.plan_id)
        },        
        costoTotal(){
            let costo = 0
            this.lista_general_presupuesto.map(function(value, key){
                costo += parseFloat(value.costo)
            })
            return parseFloat(costo).toFixed(2)
        },
        costoCliente(){
            let costo = 0
            this.lista_general_presupuesto.map(function(value, key){
                let monto = parseFloat(value.deducible) + parseFloat(value.solocoaseguro)
                costo += parseFloat(monto)
            })
            return parseFloat(costo).toFixed(2)
        },
        costoAseguradora(){
            let costo = 0
            this.lista_general_presupuesto.map(function(value, key){
                let monto = parseFloat(value.costo) - (parseFloat(value.deducible) + parseFloat(value.solocoaseguro))
                costo += parseFloat(monto)
            })
            return parseFloat(costo).toFixed(2)
        },
        presupuestoOperatoriaById(){
            if(this.$route.params.idpresupuesto != undefined){
                return this.getPresupuestoOperatoriaById(this.$route.params.idpresupuesto)                 
            }
            return []        
        }                 
    },  
    watch:{
        simboloID (newVal,oldVal){
            if(newVal != 1){
                this.multicaras =[]
            }
        },
        'dataDescuento.porcentaje' (newVal,oldVal){
            if(this.igual_monto){
                if(newVal != 0){
                    this.dataDescuento.nuevo_monto = this.dataDescuento.monto_actual * ( 1 - (this.dataDescuento.porcentaje / 100))
                }else{
                    this.dataDescuento.nuevo_monto = ''
                }
            }
        }       
    },   
    methods: {
        StatusForm: function(eshow,eclass,elabel){
            this.ShowIcon = eshow
            this.IconClass = eclass        
            this.labelButton = elabel            
        },        
        ShowDiente(params){
            let self = this
            if(!this.contains(this.odontograma,params.id)) return
            this.infodent = params
            if(this.select_multi){                  // SELECCION MULTIPLE
                if(this.diente_ancla.length == 0){
                    this.diente_ancla = _.clone(params)
                    this.toolTipDiente = {
                        cara_1 : params.cara_1,
                        cara_2 : params.cara_2,
                        cara_3 : params.cara_3,
                        cara_4 : params.cara_4,
                        cara_5 : params.cara_5
                    }                     
                }              
                if(this.contains(this.list_dent_multiple,params)){
                    this.list_dent_multiple = _.reject(this.list_dent_multiple, function(val){
                        if(self.diente_ancla.id == params.id){
                            self.$swal({
                                title: 'Este es el diente de referencia',
                                text: "se eliminara toda la seleccion multple",
                                type: 'warning',
                                showCancelButton: true,
                                confirmButtonColor: '#3085d6',
                                cancelButtonColor: '#d33',
                                cancelButtonText: 'Cancelar',
                                confirmButtonText: 'Si, eliminar!'
                                }).then((result) => {
                                    if (result.value) {
                                        self.list_dent_multiple = []
                                        return
                                    }
                                });
                        }
                        return val.id == params.id
                    });
                }else{
                    this.list_dent_multiple.push(params)    // cargo los dientes en este Array
                }
            }else{                                      // SELECCION NORMAL
                this.toolTipDiente = {
                    cara_1 : params.cara_1,
                    cara_2 : params.cara_2,
                    cara_3 : params.cara_3,
                    cara_4 : params.cara_4,
                    cara_5 : params.cara_5
                }
                this.LoadServices()
            } 
        },
        LoadServices(){
            let self = this
            this.list_services_dent = []
            if(this.select_multi){
                /** No se cargara  */
            }else{
                /** Cargo los servicios del diente */
                let encontrado = self.lista_general_presupuesto.filter(ser => ser.diente_id == self.infodent.id)
                if(encontrado.length > 0){
                    encontrado.map(function(value, key) {
                        //value.deleted = false
                        self.list_services_anteriores.push(value)
                    })
                }
            }
            this.dataTratamiento = {
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
                realizado:'',   
                deducible:'',
                solocoaseguro:'',
                pago_cliente:'',
                pago_aseguradora:'',
                activo:''
            }
            this.selected = undefined
            this.$modal.show('carga_servicios') 
        },
        cancelarMultiple(){
            this.list_dent_multiple = []
            this.select_multi = false
        },
        cambiotratamiento(param){
            this.selected = param
        },
        cargaTratamientos(){
            if(this.selected){
                if(this.simboloID == 1 && this.multicaras.length == 0){
                    this.notificaciones('Debe Seleccionar al menos una cara del Diente','la la-thumbs-o-down','danger')                
                    return
                }
                this.$modal.show('tratamientos')
            }else{
                this.notificaciones('Debe Seleccionar el tipo de tratamiento','la la-thumbs-o-down','danger')                
            }
        },
        selectServicio(param){
            let _letras = '' 
            let _newletras = '' 
            let _lados = ''         // var proc. espejo 
            let _newlados = ''
            let self = this 
            let datalist = []                  
            if(this.multicaras.includes(5)) _letras += this.toolTipDiente.cara_5.substr(0,1)
            if(this.multicaras.includes(1)) _letras += this.toolTipDiente.cara_1.substr(0,1)
            if(this.multicaras.includes(3)) _letras += this.toolTipDiente.cara_3.substr(0,1)
            if(this.multicaras.includes(2)) _letras += this.toolTipDiente.cara_2.substr(0,1)
            if(this.multicaras.includes(4)) _letras += this.toolTipDiente.cara_4.substr(0,1)          
            // llenamos la var con los numeros de caras
            if(this.multicaras.includes(1)) _lados += '1'
            if(this.multicaras.includes(2)) _lados += '2'
            if(this.multicaras.includes(3)) _lados += '3'            
            if(this.multicaras.includes(4)) _lados += '4' 
            if(this.multicaras.includes(5)) _lados += '5'                       
            if(this.simboloID != 1) _letras=this.toolTipDiente.cara_5.substr(0,1)+this.toolTipDiente.cara_1.substr(0,1)+this.toolTipDiente.cara_3.substr(0,1)+this.toolTipDiente.cara_2.substr(0,1)+this.toolTipDiente.cara_4.substr(0,1)
            if(this.select_multi){
                let _costo_deducible = param.row.solocoaseguro == 1 ? 0.00 : parseFloat(this.dataPaciente.deducible).toFixed(2)
                let _costo_coaseguro = (parseFloat(param.row.costo) - parseFloat(_costo_deducible)) * ((parseFloat(this.dataPaciente.coaseguro))/100)
                let _pago_cliente = parseFloat(_costo_deducible) + parseFloat(_costo_coaseguro)
                let _costo_aseguradora = parseFloat(param.row.costo) - ( parseFloat(_costo_deducible) + parseFloat(_costo_coaseguro))
                this.list_dent_multiple.map(function(value, key) { 
                    _newlados = self.CaraEspejo(self.diente_ancla.sector,value.sector,_lados) 
                    _newletras = self.LetrasEspejo(_newlados,value)
                    self.dataTratamiento = {
                        tarifario_id:param.row.id,
                        diente_id: value.id,
                        diente_codigo: value.codigo,
                        texto_diente:'',
                        caras: _newletras,
                        lados: _newlados,
                        simbologia: self.simboloID,
                        letras : value.codigo.replace('.', '') + '_' + _newletras,
                        servicio_id : param.row.servicio_id,
                        nombre_servicio : param.row.servicio.nombre_servicio,
                        costo_base: parseFloat(param.row.costo).toFixed(2),
                        costo : parseFloat(param.row.costo).toFixed(2),
                        moneda_id:param.row.moneda.id,
                        nombre_moneda : param.row.moneda.nombre_moneda,
                        descuento:'',
                        realizado:'',
                        deducible: self.dataPaciente.tipo_plan == 1 ?  0.00 : parseFloat(_costo_deducible).toFixed(2),
                        solocoaseguro: self.dataPaciente.tipo_plan == 1 ?  0.00 : parseFloat(_costo_coaseguro).toFixed(2),
                        pago_cliente: self.dataPaciente.tipo_plan == 1 ?  param.row.costo : parseFloat(_pago_cliente).toFixed(2),
                        pago_aseguradora: self.dataPaciente.tipo_plan == 1 ? 0.00 : parseFloat(_costo_aseguradora).toFixed(2),
                        activo: true
                    } 
                    datalist = _.clone(self.dataTratamiento)             
                    self.list_services_dent.push(datalist)      // nuevos servicios
                })
            }else{
                let _costo_deducible = param.row.solocoaseguro == 1 ? 0.00 : parseFloat(this.dataPaciente.deducible).toFixed(2)
                let _costo_coaseguro = (parseFloat(param.row.costo) - parseFloat(_costo_deducible)) * ((parseFloat(this.dataPaciente.coaseguro))/100)
                let _pago_cliente = parseFloat(_costo_deducible) + parseFloat(_costo_coaseguro)
                let _costo_aseguradora = parseFloat(param.row.costo) - ( parseFloat(_costo_deducible) + parseFloat(_costo_coaseguro))
                this.dataTratamiento = {
                    tarifario_id:param.row.id,
                    diente_id: this.infodent.id,
                    diente_codigo: this.infodent.codigo,
                    texto_diente:'',
                    caras: _letras,
                    lados: _lados,
                    simbologia: this.simboloID,
                    letras : this.infodent.codigo.replace('.', '') + '_' + _letras,
                    servicio_id : param.row.servicio_id,
                    nombre_servicio : param.row.servicio.nombre_servicio,
                    costo_base: parseFloat(param.row.costo).toFixed(2),
                    costo : parseFloat(param.row.costo).toFixed(2),
                    moneda_id:param.row.moneda.id,
                    nombre_moneda : param.row.moneda.nombre_moneda,
                    descuento:'',
                    realizado:'',
                    deducible: self.dataPaciente.tipo_plan == 1 ?  0.00 : parseFloat(_costo_deducible).toFixed(2),
                    solocoaseguro: self.dataPaciente.tipo_plan == 1 ?  0.00 : parseFloat(_costo_coaseguro).toFixed(2),
                    pago_cliente: self.dataPaciente.tipo_plan == 1 ?  parseFloat(param.row.costo).toFixed(2) : parseFloat(_pago_cliente).toFixed(2),
                    pago_aseguradora: self.dataPaciente.tipo_plan == 1 ? 0.00 : parseFloat(_costo_aseguradora).toFixed(2),
                    activo: true
                }                
                this.list_services_dent.push(this.dataTratamiento)          // nuevos servicios
            }
            this.multicaras = []
            this.cambiotratamiento(undefined)
            this.simboloID = ''
            this.$modal.hide('tratamientos');          
        },
        selectD(param){                     // param --- numero de cara
            if(this.simboloID != 1) return
            if(this.multicaras.includes(param)){
                this.multicaras.splice(this.multicaras.indexOf(param), 1)
            }else{
                this.multicaras.push(param) 
            }            
        },
        salirDiente(){
            this.list_dent_multiple = []
            this.select_multi = false
            this.simboloID = '' 
            this.selected = undefined 
            this.list_services_dent = []
            this.list_services_anteriores = []                         
            this.$modal.hide('carga_servicios')
        },
        cambioTipo(param){
            this.lista_general_presupuesto = []
            if(param == 1) this.odontograma = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32]
            if(param == 2) this.odontograma = [33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52]
            if(param == 3) this.odontograma = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52]
        },
        ActionServicio(){
            let self = this
            let new_costo = 0
            let _pago_cliente = 0
            let _pago_aseguradora = 0
            this.list_dent_multiple = []
            this.select_multi = false  
            this.simboloID = '' 
            this.selected = undefined  
            if(this.$route.params.idpresupuesto == undefined){
                this.list_services_dent.map(function(value, key) {
                    self.lista_general_presupuesto.push(value)
                })  
            }else{
                this.list_services_dent.map(function(value, key) {
                    let detpre = _.clone(self.dataDetallePresupuesto)
                    detpre = {
                        tarifario_id:value.tarifario_id,
                        tarifa:self.PacienteById.pacienteplanes.tipo,
                        moneda_id:value.moneda_id,
                        deducible: value.deducible,
                        solocoaseguro: value.solocoaseguro,
                        pago_cliente:value.pago_cliente,
                        pago_aseguradora:value.pago_aseguradora,
                        costo:value.costo,
                        costo_base:value.costo_base,
                        descuento:value.descuento,
                        tipo_odontograma:1,
                        empleado_id:self.PacienteById.empleado_id,
                        realizado:1,
                        descargado:0,
                        pagado:0,
                        tipo_pagado:'',
                        laboratorio_id:'',
                        monto_lab:'',
                        material_id:'',
                        monto_mat:'',
                        solicitud:'',
                        user_id:self.user_system.id,
                        diente_id:value.diente_id,
                        caras:value.caras,
                        letras:value.letras,
                        simbologia_id:value.simbologia,
                        texto_diente:value.texto_diente
                    }
                    if(self.dataPresupuesto.text_up_dent[value.diente_id] != undefined){
                        detpre.texto_diente = self.dataPresupuesto.text_up_dent[value.diente_id]
                    }      
                    new_costo += value.costo
                    _pago_cliente += value.pago_cliente
                    _pago_aseguradora += value.pago_aseguradora        
                    self.dataPresupuesto.detalle.push(detpre)
                })
                // Grabamos los registros en la BD
                self.dataPresupuesto.pago_cliente = this.dataPaciente.tipo_plan == 1 ? (parseFloat(this.costoTotal) + parseFloat(new_costo)).toFixed(2) : (parseFloat(this.costoCliente) + parseFloat(_pago_cliente)).toFixed(2)
                self.dataPresupuesto.pago_aseguradora = this.dataPaciente.tipo_plan == 1 ? 0.00 : (parseFloat(this.costoAseguradora) + parseFloat(_pago_aseguradora)).toFixed(2)
                self.dataPresupuesto.pago_total = (parseFloat(this.costoTotal) + parseFloat(new_costo)).toFixed(2)                
                self.dataPresupuesto.user_id = self.user_system.id
                var url = '/api/presupuestosoperatoriasdetalles/add/'+ self.$route.params.idpresupuesto;  
                axios.put(url, self.dataPresupuesto).then(response => {
                if(typeof(response.data.errors) != "undefined"){
                    self.errors = response.data.errors;
                    var resultado = "";
                    for (var i in this.errors) {
                        if (self.errors.hasOwnProperty(i)) {
                            resultado += "error -> " + i + " = " + self.errors[i] + "\n";
                        }
                    }
                    self.notificaciones('Hubo un error en el proceso: '+ resultado,'la la-thumbs-o-down','danger')                              
                    return;
                }
                self.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST').then(() => {
                    self.CargaDetalleEdit()
                    self.isLoading = false
                })  
                self.errors = [];            
                self.notificaciones('Nuevo Registro creado con exito','la la-thumbs-up','success')                          
                }).catch(error => {
                self.errors = error.response.data.status;         
                self.notificaciones('Hubo un error en el proceso: '+ self.errors.data.error,'la la-thumbs-o-down','danger')           
                });
            }
            this.list_services_dent = []
            this.list_services_anteriores = []   
            this.$modal.hide('carga_servicios')
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
                                valor = value.realizado == 3 ? 'marcadoPernoO_Azul' : 'marcadoPernoO'  
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
        BuscoCara(param,lado){
            let encontrado;
            let valor = this.deshabilitado
            self = this
            if(this.contains(this.odontograma,param.id)){    
                valor = self.diente           
                encontrado = self.lista_general_presupuesto.filter(ser => ser.diente_id == param.id)
                if(encontrado.length > 0){                 
                    encontrado.map(function(value, key) {
                        if((value.simbologia == 1) && (value.lados.indexOf(lado)) >-1) {
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
/*         BuscoCara(param,cara){
            let encontrado;
            let valor = this.deshabilitado
            self = this
            if(this.contains(this.odontograma,param.id)){    
                valor = self.diente           
                encontrado = self.lista_general_presupuesto.filter(ser => ser.diente_id == param.id)
                if(encontrado.length > 0){                 
                    encontrado.map(function(value, key) {
                        if((value.simbologia == 1) && (value.caras.indexOf(cara)) >-1) {
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
        }, */        
        CaraEspejo(sector_ancla,sector_selec,contenido){
            let newlados = ''
            if(sector_ancla == "A"){
                if(sector_selec == "A") {
                    if(contenido.indexOf('1') >-1) newlados += '1'
                    if(contenido.indexOf('2') >-1) newlados += '2'
                    if(contenido.indexOf('3') >-1) newlados += '3'
                    if(contenido.indexOf('4') >-1) newlados += '4'
                    if(contenido.indexOf('5') >-1) newlados += '5'
                }
                if(sector_selec == "B") {
                    if(contenido.indexOf('1') >-1) newlados += '1'
                    if(contenido.indexOf('2') >-1) newlados += '4'
                    if(contenido.indexOf('3') >-1) newlados += '3'
                    if(contenido.indexOf('4') >-1) newlados += '2'
                    if(contenido.indexOf('5') >-1) newlados += '5'
                }
                if(sector_selec == "C") {
                    if(contenido.indexOf('1') >-1) newlados += '3'
                    if(contenido.indexOf('2') >-1) newlados += '4'
                    if(contenido.indexOf('3') >-1) newlados += '1'
                    if(contenido.indexOf('4') >-1) newlados += '2'
                    if(contenido.indexOf('5') >-1) newlados += '5'
                }
                if(sector_selec == "D") {
                    if(contenido.indexOf('1') >-1) newlados += '3'
                    if(contenido.indexOf('2') >-1) newlados += '2'
                    if(contenido.indexOf('3') >-1) newlados += '1'
                    if(contenido.indexOf('4') >-1) newlados += '4'
                    if(contenido.indexOf('5') >-1) newlados += '5'
                }
            }else if(sector_ancla == "B"){
                if(sector_selec == "A") {
                    if(contenido.indexOf('1') >-1) newlados += '1'
                    if(contenido.indexOf('2') >-1) newlados += '4'
                    if(contenido.indexOf('3') >-1) newlados += '3'
                    if(contenido.indexOf('4') >-1) newlados += '2'
                    if(contenido.indexOf('5') >-1) newlados += '5'
                }
                if(sector_selec == "B") {
                    if(contenido.indexOf('1') >-1) newlados += '1'
                    if(contenido.indexOf('2') >-1) newlados += '2'
                    if(contenido.indexOf('3') >-1) newlados += '3'
                    if(contenido.indexOf('4') >-1) newlados += '4'
                    if(contenido.indexOf('5') >-1) newlados += '5'
                }
                if(sector_selec == "C") {
                    if(contenido.indexOf('1') >-1) newlados += '3'
                    if(contenido.indexOf('2') >-1) newlados += '2'
                    if(contenido.indexOf('3') >-1) newlados += '1'
                    if(contenido.indexOf('4') >-1) newlados += '4'
                    if(contenido.indexOf('5') >-1) newlados += '5'
                }
                if(sector_selec == "D") {
                    if(contenido.indexOf('1') >-1) newlados += '3'
                    if(contenido.indexOf('2') >-1) newlados += '4'
                    if(contenido.indexOf('3') >-1) newlados += '1'
                    if(contenido.indexOf('4') >-1) newlados += '2'
                    if(contenido.indexOf('5') >-1) newlados += '5'
                }
            }else if(sector_ancla == "C"){
                if(sector_selec == "A") {
                    if(contenido.indexOf('1') >-1) newlados += '3'
                    if(contenido.indexOf('2') >-1) newlados += '4'
                    if(contenido.indexOf('3') >-1) newlados += '1'
                    if(contenido.indexOf('4') >-1) newlados += '2'
                    if(contenido.indexOf('5') >-1) newlados += '5'
                }
                if(sector_selec == "B") {
                    if(contenido.indexOf('1') >-1) newlados += '3'
                    if(contenido.indexOf('2') >-1) newlados += '2'
                    if(contenido.indexOf('3') >-1) newlados += '1'
                    if(contenido.indexOf('4') >-1) newlados += '4'
                    if(contenido.indexOf('5') >-1) newlados += '5'
                }
                if(sector_selec == "C") {
                    if(contenido.indexOf('1') >-1) newlados += '1'
                    if(contenido.indexOf('2') >-1) newlados += '2'
                    if(contenido.indexOf('3') >-1) newlados += '3'
                    if(contenido.indexOf('4') >-1) newlados += '4'
                    if(contenido.indexOf('5') >-1) newlados += '5'
                }
                if(sector_selec == "D") {
                    if(contenido.indexOf('1') >-1) newlados += '1'
                    if(contenido.indexOf('2') >-1) newlados += '4'
                    if(contenido.indexOf('3') >-1) newlados += '3'
                    if(contenido.indexOf('4') >-1) newlados += '2'
                    if(contenido.indexOf('5') >-1) newlados += '5'
                }
            }else if(sector_ancla == "D"){
                if(sector_selec == "A") {
                    if(contenido.indexOf('1') >-1) newlados += '3'
                    if(contenido.indexOf('2') >-1) newlados += '2'
                    if(contenido.indexOf('3') >-1) newlados += '1'
                    if(contenido.indexOf('4') >-1) newlados += '4'
                    if(contenido.indexOf('5') >-1) newlados += '5'
                }
                if(sector_selec == "B") {
                    if(contenido.indexOf('1') >-1) newlados += '3'
                    if(contenido.indexOf('2') >-1) newlados += '4'
                    if(contenido.indexOf('3') >-1) newlados += '1'
                    if(contenido.indexOf('4') >-1) newlados += '2'
                    if(contenido.indexOf('5') >-1) newlados += '5'
                }
                if(sector_selec == "C") {
                    if(contenido.indexOf('1') >-1) newlados += '1'
                    if(contenido.indexOf('2') >-1) newlados += '4'
                    if(contenido.indexOf('3') >-1) newlados += '3'
                    if(contenido.indexOf('4') >-1) newlados += '2'
                    if(contenido.indexOf('5') >-1) newlados += '5'
                }
                if(sector_selec == "D") {
                    if(contenido.indexOf('1') >-1) newlados += '1'
                    if(contenido.indexOf('2') >-1) newlados += '2'
                    if(contenido.indexOf('3') >-1) newlados += '3'
                    if(contenido.indexOf('4') >-1) newlados += '4'
                    if(contenido.indexOf('5') >-1) newlados += '5'
                }
            }
            return newlados
        },
        LetrasEspejo(_newlad,_valdie){
            let _newletras = ''
            if(_newlad.includes(5)) _newletras += _valdie.cara_5.substr(0,1)
            if(_newlad.includes(1)) _newletras += _valdie.cara_1.substr(0,1)
            if(_newlad.includes(3)) _newletras += _valdie.cara_3.substr(0,1)
            if(_newlad.includes(2)) _newletras += _valdie.cara_2.substr(0,1)
            if(_newlad.includes(4)) _newletras += _valdie.cara_4.substr(0,1) 
            return _newletras 
        },
        menuPopup(param){
            $('#context-menu').css({'display':'block'}) 
            this.deleteDent = param
            if(this.contains(this.odontograma,param.id) || this.contains(this.list_dent_missing,param.id)){
                this.$refs.ctxMenu.open()
            }
        },
        deleteItem(){
            let self = this
            let encontrado = this.lista_general_presupuesto.find(lis => lis.diente_id == self.deleteDent.id)
            if(encontrado){
                if(this.$route.params.idpresupuesto == undefined){
                    this.lista_general_presupuesto = _.reject(self.lista_general_presupuesto, function(val){
                        return val.diente_id == self.deleteDent.id
                    });
                }else{
                    this.dataTratamiento.diente_id = this.deleteDent.id
                    var url = '/api/presupuestosoperatoriasdetalles/deltradie/'+this.$route.params.idpresupuesto
                    axios.put(url, this.dataTratamiento).then(response => {
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
                        this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST').then(() => {
                            this.CargaDetalleEdit()
                            this.isLoading = false
                        })                  
                        this.errors = []; 
                        this.notificaciones('el Registro fue eliminado con exito','la la-thumbs-up','success')                  
                        this.isLoading = false
                    }).catch(error => {
                        this.errors = error.response.data.status;  
                        this.isLoading = false            
                        this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')
                    });
                }

            }           
        },
        ausenteItem(){
            let self = this
            let encontrado = this.lista_general_presupuesto.find(lis => lis.diente_id == self.deleteDent.id)
            if(encontrado){
                this.notificaciones('El diente tiene tratamientos cargados debe eliminarlos primero','la la-thumbs-o-down','danger')                 
                return
            }
            this.list_dent_missing.push(this.deleteDent.id)
            this.odontograma = _.reject(self.odontograma, function(d){ return d == self.deleteDent.id })
            if(this.$route.params.idpresupuesto != undefined){
                this.dataPresupuesto.ausentes = this.list_dent_missing
                var url = '/api/presupuestosoperatoriasdetalles/estdieaus/'+this.$route.params.idpresupuesto;
                axios.put(url, this.dataPresupuesto).then(response => {
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
                    this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST').then(() => {
                        this.CargaDetalleEdit()
                        this.isLoading = false
                    })                  
                    this.errors = []; 
                    this.notificaciones('el Registro fue actualizado con exito','la la-thumbs-up','success')                  
                    this.isLoading = false
                }).catch(error => {
                    this.errors = error.response.data.status;  
                    this.isLoading = false            
                    this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')
                });
            }

        },
        normalItem(){
            let self = this
            this.odontograma.push(this.deleteDent.id)
            this.list_dent_missing = _.reject(self.list_dent_missing, function(d){ return d == self.deleteDent.id })
            if(this.$route.params.idpresupuesto != undefined){
                this.dataPresupuesto.ausentes = this.list_dent_missing
                var url = '/api/presupuestosoperatoriasdetalles/estdieaus/'+this.$route.params.idpresupuesto;
                axios.put(url, this.dataPresupuesto).then(response => {
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
                    this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST').then(() => {
                        this.CargaDetalleEdit()
                        this.isLoading = false
                    })                  
                    this.errors = []; 
                    this.notificaciones('el Registro fue actualizado con exito','la la-thumbs-up','success')                  
                    this.isLoading = false
                }).catch(error => {
                    this.errors = error.response.data.status;  
                    this.isLoading = false            
                    this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')
                });
            }            
        },
        borrarItem(param,index){
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
                        if(this.$route.params.idpresupuesto == undefined){
                            let self = this
                            this.$delete(self.lista_general_presupuesto , index) 
                        }else{
                            this.isLoading = true
                            this.dataPpto = {
                                id: param.idppto,
                                idDetalle:param.id,
                                user_id:this.user_system.id
                            }
                            var url = '/api/presupuestosoperatoriasdetalles/delete/'+this.dataPpto.id;;
                            axios.put(url, this.dataPpto).then(response => {
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
                                this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST').then(() => {
                                    this.CargaDetalleEdit()
                                    this.isLoading = false
                                })                  
                                this.errors = []; 
                                this.notificaciones('el Registro fue eliminado con exito','la la-thumbs-up','success')                  
                                this.isLoading = false
                            }).catch(error => {
                                this.errors = error.response.data.status;  
                                this.isLoading = false            
                                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')
                            });
                        }
                    }
                });              
        },
        newborrarItems(){
            this.$swal({
                title: 'Desea eliminar estos registros ?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, eliminar!'
                }).then((result) => {
                    if (result.value) {
                        if(this.$route.params.idpresupuesto == undefined){
                            let self = this
                            this.$delete(self.lista_general_presupuesto , index) 
                        }else{
                            this.isLoading = true
                            this.dataPpto = {
                                id: param.idppto,
                                idDetalle:param.id,
                                user_id:this.user_system.id
                            }
                            var url = '/api/presupuestosoperatoriasdetalles/delete/'+this.dataPpto.id;;
                            axios.put(url, this.dataPpto).then(response => {
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
                                this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST').then(() => {
                                    this.CargaDetalleEdit()
                                    this.isLoading = false
                                })                  
                                this.errors = []; 
                                this.notificaciones('el Registro fue eliminado con exito','la la-thumbs-up','success')                  
                                this.isLoading = false
                            }).catch(error => {
                                this.errors = error.response.data.status;  
                                this.isLoading = false            
                                this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')
                            });
                        }
                    }
                });              
        },        
        EliminaServicio(index){
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
                        this.$delete(self.list_services_dent , index)
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
/*             let desc = parseFloat(this.dataDescuento.monto_actual) - parseFloat(this.dataDescuento.nuevo_monto)
            this.lista_general_presupuesto[this.dataDescuento.index].descuento = parseFloat(desc).toFixed(2)
            this.lista_general_presupuesto[this.dataDescuento.index].costo = this.dataDescuento.nuevo_monto
            this.$modal.hide('descuento') */
            let desc
            let nuevo_monto
            let monto_actual
            let item = {
                id:'',
                costo:'',
                descuento:''
            }

            let items_descuento = []

            if(this.$route.params.idpresupuesto == undefined){
                for(let i = this.lista_general_presupuesto.length - 1; i>=0 ;i--){
                    if(this.lista_general_presupuesto[i].activo == false){
                        monto_actual = this.lista_general_presupuesto[i].costo
                        if(this.dataDescuento.tipo == 0){           // por monto
                            nuevo_monto = this.dataDescuento.nuevo_monto
                        }else if(this.dataDescuento.tipo == 1){     // por porcentaje
                            nuevo_monto = monto_actual * ( 1 - (this.dataDescuento.porcentaje / 100))
                        }
                        desc = parseFloat(monto_actual) - parseFloat(nuevo_monto)
                        this.lista_general_presupuesto[i].descuento =+ parseFloat(desc).toFixed(2)
                        this.lista_general_presupuesto[i].costo = parseFloat(nuevo_monto).toFixed(2)                    
                    }
                }  
                this.checkTxs = [] 
            }else{
                let j = 0
                this.isLoading = true
                for(let i = 0; i < this.lista_general_presupuesto.length - 1; i++){
                    if(this.lista_general_presupuesto[i].activo == false){
                        monto_actual = this.lista_general_presupuesto[i].costo
                        if(this.dataDescuento.tipo == 0){           // por monto
                            nuevo_monto = this.dataDescuento.nuevo_monto
                        }else if(this.dataDescuento.tipo == 1){     // por porcentaje
                            nuevo_monto = monto_actual * ( 1 - (this.dataDescuento.porcentaje / 100))
                        }
                        desc = parseFloat(monto_actual) - parseFloat(nuevo_monto)
                        item.descuento = parseFloat(desc).toFixed(2)
                        item.costo = parseFloat(nuevo_monto).toFixed(2)
                        item.id = this.lista_general_presupuesto[i].id
                        let _item = _.clone(item)
                        items_descuento.push(_item)
                        //this.lista_general_presupuesto[i].descuento = parseFloat(desc).toFixed(2)
                        //this.lista_general_presupuesto[i].costo = parseFloat(nuevo_monto).toFixed(2)                    
                    }
                }                  
                this.dataPpto = {
                    id: this.$route.params.idpresupuesto,
                    detalle:items_descuento,
                    user_id:this.user_system.id
                }
                var url = '/api/presupuestosoperatoriasdetalles/descuento_masivo/'+this.dataPpto.id
                axios.put(url, this.dataPpto).then(response => {
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
                        this.isLoading = false
                        return;
                    }
                    this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST').then(() => {
                        this.CargaDetalleEdit()
                        this.isLoading = false
                    })                  
                    this.errors = []
                    this.checkTxs = [] 
                    this.checkAllTx = false
                    //this.notificaciones('el Registro fue eliminado con exito','la la-thumbs-up','success')                  
                    this.isLoading = false
                }).catch(error => {
                    this.errors = error.response.data.status;  
                    this.isLoading = false            
                    this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')
                });


            }
            this.$modal.hide('descuento')                   
        },
        cambiaTipo(){
            this.dataDescuento.nuevo_monto = ''
            this.dataDescuento.porcentaje = ''
        },
        Tratamientos_sin_piezas(){
            this.simboloID = 8
            this.$modal.show('tratamientos_sin_piezas')            
        },
        selectServicioSinPiezas(param){
            console.log("param",param)
/*             this.dataTratamiento = {
                tarifario_id:param.row.id,
                diente_id: '',
                diente_codigo: '',
                texto_diente:'',
                caras: '',
                simbologia: this.simboloID,
                letras : '00_0',
                servicio_id : param.row.servicio_id,
                nombre_servicio : param.row.servicio.nombre_servicio,
                costo_base: param.row.costo,
                costo : param.row.costo,
                moneda_id:param.row.moneda.id,
                nombre_moneda : param.row.moneda.nombre_moneda,
                descuento:'',
                realizado:'',
                user_id:this.user_system.id
            }  */
            let _costo_deducible = param.row.solocoaseguro == 1 ? 0.00 : parseFloat(this.dataPaciente.deducible).toFixed(2)
            let _costo_coaseguro = (parseFloat(param.row.costo) - parseFloat(_costo_deducible)) * ((parseFloat(this.dataPaciente.coaseguro))/100)
            let _pago_cliente = parseFloat(_costo_deducible) + parseFloat(_costo_coaseguro)
            let _costo_aseguradora = parseFloat(param.row.costo) - ( parseFloat(_costo_deducible) + parseFloat(_costo_coaseguro))

            this.dataTratamiento = {
                tarifario_id:param.row.id,
                tarifa:self.PacienteById.pacienteplanes.tipo, 
                deducible: _costo_deducible,
                solocoaseguro: _costo_coaseguro,
                pago_cliente:_pago_cliente,
                pago_aseguradora:_costo_aseguradora,                               
                diente_id: '',
                diente_codigo: '',
                texto_diente:'',
                caras: '',
                simbologia_id: this.simboloID,
                letras : '00_0',
                servicio_id : param.row.servicio_id,
                nombre_servicio : param.row.servicio.nombre_servicio,
                costo_base: param.row.costo,
                costo : param.row.costo,
                moneda_id:param.row.moneda.id,
                nombre_moneda : param.row.moneda.nombre_moneda,
                descuento:'',
                realizado:1,
                descargado:0,
                pagado:0,                
                user_id:this.user_system.id,
                tipo_odontograma:1,
                empleado_id:this.PacienteById.empleado_id,                
            }                              
            //this.lista_general_presupuesto.push(this.dataTratamiento)          // nuevos servicio            
            if(this.$route.params.idpresupuesto == undefined){
                this.lista_general_presupuesto.push(this.dataTratamiento)
            }else{        
                this.dataPresupuesto.detalle.push(this.dataTratamiento)
                // Grabamos los registros en la BD
                this.dataPresupuesto.pago_cliente = this.dataPaciente.tipo_plan == 1 ? (parseFloat(this.costoTotal) + parseFloat(param.row.costo)).toFixed(2) : (parseFloat(this.costoCliente) + parseFloat(_pago_cliente)).toFixed(2)
                this.dataPresupuesto.pago_aseguradora = this.dataPaciente.tipo_plan == 1 ? 0.00 : (parseFloat(this.costoAseguradora) + parseFloat(_costo_aseguradora)).toFixed(2)
                this.dataPresupuesto.pago_total = (parseFloat(this.costoTotal) + parseFloat(param.row.costo)).toFixed(2)                
                this.dataPresupuesto.user_id = this.user_system.id
                var url = '/api/presupuestosoperatoriasdetalles/add/'+ this.$route.params.idpresupuesto;  
                axios.put(url, this.dataPresupuesto).then(response => {
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
                this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST').then(() => {
                    this.CargaDetalleEdit()
                    this.isLoading = false
                })  
                this.errors = [];            
                this.notificaciones('Nuevo Registro creado con exito','la la-thumbs-up','success')                          
                }).catch(error => {
                this.errors = error.response.data.status;         
                this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')           
                });
            } 
            this.cambiotratamiento(undefined)
            this.simboloID = ''
            this.$modal.hide('tratamientos_sin_piezas')                       
        },
        CrearDatosPpto(){
            if(this.lista_general_presupuesto.length == 0){
                this.notificaciones('No hay servicios cargados en el presupuesto','la la-thumbs-o-down','danger')                
                return
            }
            let self = this
            let tipo_odo = this.dataPresupuesto.tipo_odontograma
            let cont_text = _.clone(this.dataPresupuesto.text_up_dent)       
            this.dataPresupuesto = {
                fecha_registro:moment().format('DD-MM-YYYY'),
                paciente_id:this.PacienteById.id,
                empleado_id:this.dataPaciente.empleado_id,
                moneda_id:'',
                numero_prespuesto:'',
                plan_id:this.PacienteById.pacienteplanes.plan_id ,
                poliza_id:this.PacienteById.pacienteplanes.poliza_id != null ? this.PacienteById.pacienteplanes.poliza_id : null,
                tipo_presupuesto:this.PacienteById.pacienteplanes.tipo,
                estado_seguimiento:1,
                observaciones:'',
                estadopresupuesto_id:1,
                tipocambio_id:this.getTipoCambioHoy.id,
                sede_id:this.sede_system.id,
                pago_cliente:this.costoCliente,
                pago_aseguradora:this.costoAseguradora,
                pago_total:this.costoTotal,
                user_id:this.user_system.id,
                saldo:0,
                tipo_odontograma: tipo_odo,
                detalle:[],
                ausentes:[],
                text_up_dent:cont_text
            }
            this.lista_general_presupuesto.map(function(value, key) {
                let detpre = _.clone(self.dataDetallePresupuesto)
                detpre = {
                    tarifario_id:value.tarifario_id,
                    tarifa:self.PacienteById.pacienteplanes.tipo,
                    moneda_id:value.moneda_id,
                    //deducible:self.PacienteById.pacienteplanes.poliza_id != null ? self.PacienteById.pacienteplanes.poliza.deducible : null ,
                    //solocoaseguro: self.PacienteById.pacienteplanes.poliza_id != null ? self.PacienteById.pacienteplanes.poliza.coaseguro : null,
                    deducible: value.deducible,
                    solocoaseguro : value.solocoaseguro,
                    pago_cliente:value.pago_cliente,
                    pago_aseguradora:value.pago_aseguradora,
                    costo:value.costo,
                    costo_base:value.costo_base,
                    descuento:value.descuento,
                    tipo_odontograma:1,
                    empleado_id:self.dataPaciente.empleado_id,
                    realizado:1,
                    descargado:0,
                    pagado:0,
                    tipo_pagado:'',
                    laboratorio_id:'',
                    monto_lab:'',
                    material_id:'',
                    monto_mat:'',
                    solicitud:'',
                    user_id:self.user_system.id,
                    diente_id:value.diente_id,
                    caras:value.caras,
                    lados:value.lados,
                    letras:value.letras,
                    simbologia_id:value.simbologia,
                    texto_diente:''
                }
                if(self.dataPresupuesto.text_up_dent[value.diente_id] != undefined){
                    detpre.texto_diente = self.dataPresupuesto.text_up_dent[value.diente_id]
                }                
                self.dataPresupuesto.detalle.push(detpre)
            })
            if(this.list_dent_missing.length > 0){
                this.list_dent_missing.map(function(value, key) { 
                    self.dataPresupuesto.ausentes.push(value)
                }) 
            }          
            this.createPresupuesto()
        },
        createPresupuesto(){
            var url = '/api/presupuestos-operatorias';
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
                return;
            }
            this.newidPresupuesto = response.data.idpresupuesto
            this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST')    
            this.errors = [];             
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
                        this.$router.push({ name: 'lista-ppto-operatoria' }) 
                    }
            });                        
            }).catch(error => {
            this.errors = error.response.data.status;        
            this.notificaciones('Hubo un error en el proceso: '+ this.errors.data.error,'la la-thumbs-o-down','danger')           
            });
        }, 
        createPDF () {
            this.take(this.$refs.printMe)
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
                    doc.text(120,13,self.newidPresupuesto.toString())
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
                    doc.text(100,25, self.PacienteById.empleado.nombre_completo) 
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
                    doc.text(198,y,self.costoTotal,'right')
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
        CargaDetalleEdit(){
            let self = this
            self.lista_general_presupuesto = []
            if(this.presupuestoOperatoriaById.presupuestosoperatoriasdetalles != undefined){
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
                        lados:value.lados == null ? '' : value.lados,
                        simbologia:value.simbologia_id,
                        letras:value.letras,
                        servicio_id:value.tarifario.servicio_id,
                        nombre_servicio:value.tarifario.servicio.nombre_servicio,
                        costo_base:value.costo_base,
                        costo:parseFloat(value.costo).toFixed(2),
                        moneda_id:value.moneda_id,
                        nombre_moneda:value.moneda.nombre_moneda,
                        descuento:value.descuento,
                        realizado:value.realizado,
                        deducible:value.deducible == null ? '0.00' : parseFloat(value.deducible).toFixed(2),
                        solocoaseguro:value.solocoaseguro == null ? '0.00' : parseFloat(value.solocoaseguro).toFixed(2),
                        pago_cliente:value.pago_cliente == null ? '0.00' : parseFloat(value.pago_cliente).toFixed(2),
                        pago_aseguradora:value.pago_aseguradora == null ? '0.00' : parseFloat(value.pago_aseguradora).toFixed(2),                        
                        activo:value.activo
                    }
                    if(self.dataTratamiento.activo){
                        datadet = _.clone(self.dataTratamiento)
                        self.lista_general_presupuesto.push(datadet)
                    }   
                    if(value.texto_diente != null){
                        self.dataPresupuesto.text_up_dent[value.diente_id] = value.texto_diente
                    }                  
                })
                this.presupuestoOperatoriaById.dientes.map(function(value, key) {
                    self.list_dent_missing.push(value.id)
                    self.odontograma = _.reject(self.odontograma, function(d){ return d == value.id })                    
                })
            }
        },
        guardaDatoTexto(param){
            this.valor_texto_material = ''
            let encontrado = this.lista_general_presupuesto.filter(lis => lis.diente_id == param)
            if(encontrado.length > 0){
                this.valor_texto_material = this.dataPresupuesto.text_up_dent[param]
            }
        },
        grabaDatoTexto(param){
            let encontrado = this.lista_general_presupuesto.filter(lis => lis.diente_id == param) 
            if(encontrado.length > 0){
                if(this.valor_texto_material != this.dataPresupuesto.text_up_dent[param]){
                    this.$swal({
                        title: 'Desea grabar este cambio del registro?',
                        text: "No podras revertir esto!",
                        type: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Cancelar',
                        confirmButtonText: 'Si, Grabar!'
                        }).then((result) => {
                            if (result.value) {
                                this.dataTratamiento.texto_diente = this.dataPresupuesto.text_up_dent[param]
                                this.dataTratamiento.diente_id = param
                                this.isLoading = true
                                var url = '/api/presupuestosoperatoriasdetalles/texsupdie/' + this.$route.params.idpresupuesto;
                                axios.put(url,this.dataTratamiento).then(response=> {
                                    this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST').then(() => {
                                        this.isLoading = false
                                        this.CargaDetalleEdit()
                                        this.$swal(
                                        'Actualizado!',
                                        'Este registro fue actualizado.',
                                        'success'
                                        )
                                    })                    
                                });
                            }else{
                                this.dataPresupuesto.text_up_dent[param] = this.valor_texto_material
                            }
                        });
                }
            }           

        },
        marcarAllTx(){
            let self = this
            if(this.checkAllTx){    // si esta marcando todo
                self.checkTxs = []
                this.lista_general_presupuesto.map(function(value, key) { 
                    self.checkTxs.push(key)
                })
            }else{                  // si esta desmarcando todo
                self.checkTxs = []
            }
        },
        change_checkTxs(param){
            if(this.checkTxs.length == this.lista_general_presupuesto.length ){
                this.checkAllTx = true
            }else {
                this.checkAllTx = false
            }
            // marcamos -- desmarcamos de la lista 
            if(this.checkTxs.includes(param)){    // el valor de index es true
                this.lista_general_presupuesto[param].activo = false
            }else{                                // el valor de index es false
                this.lista_general_presupuesto[param].activo = true
            }
        },
        AplicarDescuentoMultiple(){
            this.igual_monto = true
            this.dataDescuento.tipo = "0"         // por monto
            let firts_monto = parseFloat(this.lista_general_presupuesto[this.checkTxs[0]].costo) 
            this.dataDescuento.monto_actual = firts_monto.toFixed(2)
            for (let i = 0; i < this.checkTxs.length; i++) {
                let elem = this.checkTxs[i];
                this.lista_general_presupuesto[elem].activo = false  
                if(parseFloat(this.lista_general_presupuesto[elem].costo) != firts_monto){
                    this.igual_monto = false
                    this.dataDescuento.tipo = "1" // por porcentaje
                    this.dataDescuento.monto_actual = null
                }              
            }
            this.dataDescuento.porcentaje = ''
            this.dataDescuento.nuevo_monto = ''
            this.$modal.show('descuento')
        },
        EliminarItemsMultiple(){
            this.$swal({
                title: 'Desea eliminar estos tratamientos?',
                text: "No podras revertir esto!",
                type: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Cancelar',
                confirmButtonText: 'Si, Eliminar!'
                }).then((result) => {
                    if (result.value) {
                        let list_detalle = []
                        for (let i = 0; i < this.checkTxs.length; i++) {
                            let elem = this.checkTxs[i];
                            this.lista_general_presupuesto[elem].activo = false                
                        }
                        if(this.$route.params.idpresupuesto == undefined){
                            for(let i = this.lista_general_presupuesto.length - 1; i>=0 ;i--){
                                if(this.lista_general_presupuesto[i].activo == false)
                                    this.lista_general_presupuesto.splice(i,1);
                            }  
                            this.checkTxs = []
                            this.checkAllTx = false
                        }else{
                            this.isLoading = true
                            for(let i = this.lista_general_presupuesto.length - 1; i>=0 ;i--){
                                if(this.lista_general_presupuesto[i].activo == false)                        
                                    list_detalle.push(this.lista_general_presupuesto[i].id)
                            }                 
                            this.dataPpto = {
                                id: this.$route.params.idpresupuesto,
                                detalle:list_detalle,
                                user_id:this.user_system.id
                            }
                            var url = '/api/presupuestosoperatoriasdetalles/delete_masivo/'+this.dataPpto.id;;
                            axios.put(url, this.dataPpto).then(response => {
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
                                    this.isLoading = false
                                    return;
                                }
                                this.$store.dispatch('LOAD_PRESUPUESTOS_OPERATORIAS_LIST').then(() => {
                                    this.CargaDetalleEdit()
                                    this.isLoading = false
                                })                  
                                this.errors = []
                                this.checkTxs = [] 
                                this.checkAllTx = false
                                //this.notificaciones('el Registro fue eliminado con exito','la la-thumbs-up','success')                  
                                this.isLoading = false
                            }).catch(error => {
                                this.errors = error.response.data.status;  
                                this.isLoading = false            
                                this.notificaciones('Hubo un error en el proceso: '+ this.errors,'la la-thumbs-o-down','danger')
                            });
                        }
                    }
                });
        },
        handleScroll(){
            $('#context-menu').css({'display':'none'}) 
        },        
    }
}
</script>
<style scoped>
    .deshabilitado{
        fill:dimgrey;
        stroke:rgb(71, 71, 71);
        stroke-width:1px;
        opacity: 0.3;
    }
	.marcadoRojo{
        cursor:pointer; 
        cursor: hand ;          
        fill:#f94f4f;
        stroke:#dedcdc;
        stroke-width:1px;
	}    
    .marcadoCorona, .marcadoCoronaO
    {
        cursor:pointer; 
        cursor: hand ;  
        fill:none;
        stroke:dimgrey;
        stroke-width:4px;        
    }
    .marcadoCoronaO
    {
        stroke-width:2px !important;  
        stroke:red !important;        
    }
    .marcadoCoronaD
    {
        cursor:pointer; 
        cursor: hand ;  
        fill:none;
        stroke:red;
        stroke-width:8px;        
    }    
    .marcadoEndodoncia, .marcadoExodoncia, .marcadoEndodonciaO, .marcadoExodonciaO{
        cursor:pointer; 
        cursor: hand ;          
        fill:dimgrey;
        stroke:dimgrey;
        stroke-width:1px;        
    }
    .marcadoEndodonciaO, .marcadoExodonciaO
    {
        fill:red !important;
        stroke: red !important;
    }
    .marcadoEndodonciaD, .marcadoExodonciaD{
        cursor:pointer; 
        cursor: hand ;          
        fill:red;
        stroke:red;
        stroke-width:1px;        
    }    
    .marcadoIonomero, .marcadoIonomeroO{
        cursor:pointer; 
        cursor: hand ;          
        stroke : dimgrey;
        fill-opacity : 0;
        stroke-width: 4px;
    }
    .marcadoIonomeroO
    {
        stroke-width: 2px !important;
        stroke:red !important;
    }
    .marcadoIonomeroD{
        cursor:pointer; 
        cursor: hand ;          
        stroke : red;
        fill-opacity : 0;
        stroke-width: 8px 
    }    
    .marcadoSellante, .marcadoSellanteO{
        cursor:pointer; 
        cursor: hand ;          
        font-weight: bold;
        fill : dimgrey;
        stroke : dimgrey;
        stroke-width: 2px;
        font-size : 2.5em;
    }
    .marcadoSellanteO{
        font-weight:normal !important;
        stroke-width: 1px !important;
        fill : red !important;
        stroke:red !important;
        font-size : 2em !important;
    }
    .marcadoSellanteD{
        cursor:pointer; 
        cursor: hand ;          
        font-weight: bold;
        fill : red;
        stroke : red;
        font-size : 10em;
    }    
    .marcadoGeneral, .marcadoGeneralO{
        cursor:pointer; 
        cursor: hand ;          
        fill:none;
        stroke:dimgrey;
        stroke-width:3px;        
    }
    .marcadoGeneralO 
    {
        stroke-width:1px !important;
        stroke:red !important;
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
    .perno {
        cursor:pointer; 
        cursor: hand ;         
    }
    ._diente{
        cursor:pointer; 
        cursor: hand ;         
        fill-opacity:0;
        stroke:rgb(129, 128, 128);
        stroke-width:1px;
    }
    .diente{
        cursor:pointer; 
        cursor: hand ;         
        fill-opacity:0;
        stroke:#6f6a6a;
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
    .table-sm th,
    .table-sm td {
        padding: 0.3rem !important; 
        font-size: 11px !important;
    } 
    td {
        vertical-align: middle !important;
    }
    .btn-xs {
        padding: 3px !important;
    } 
    #context-menu{
        background: rgb(238, 237, 237);
        border: 1px solid #BDBDBD;
        box-shadow: 0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);
        display: block;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    #context-menu li {
        cursor:pointer; 
        cursor: hand ;  
        border-bottom: 1px solid #E0E0E0;
        margin: 0;
        padding: 5px 35px;
    }

    #context-menu li:last-child {
        border-bottom: none;
    }

    #context-menu li:hover {
        background: #1E88E5;
        color: #FAFAFA;
        cursor:pointer; 
        cursor: hand ; 
    }
    .title-simbologia {
        font-size: 0.65em !important; 
        font-weight: 700 !important;       
    } 
    .pt-3 {
        padding-top: 3px !important;
    }
    .pb-3 {
        padding-bottom: 3px !important;
    }
    .bg-ppto {
        background-color: #696969 !important;
    }
    .table {
        color:#131212 !important;
    }
</style>