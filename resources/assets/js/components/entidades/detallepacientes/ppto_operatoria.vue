<template>
    <div class="row" ref="contenedor">
        <div class="col-12">
            <div class="row">
                <div class="col-9">
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group form-group-default border border-primary" >
                                <label for="historia" class="text-primary font-weight-bold">Paciente </label>
                                <p class="form-control-static font-weight-bold mb-0">{{ 'MANUEL JIMENO CANDELA' }}</p>
                            </div>
                        </div>
                        <div class="col-4 pl-0 pr-0">
                            <div class="form-group form-group-default border border-primary" >
                                <label for="historia" class="text-primary font-weight-bold">Num. Historia </label>
                                <p class="form-control-static font-weight-bold mb-0">{{ '4' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-4">
                            <div class="form-group form-group-default border border-primary" >
                                <label for="historia" class="text-primary font-weight-bold">Empresa </label>
                                <p class="form-control-static font-weight-bold mb-0">{{ '-' }}</p>
                            </div>
                        </div>
                        <div class="col-4 pl-0">
                            <div class="form-group form-group-default border border-primary" >
                                <label for="historia" class="text-primary font-weight-bold">Plan </label>
                                <p class="form-control-static font-weight-bold mb-0">{{ 'PARTICULAR MAYOLO' }}</p>
                            </div>
                        </div>
                        <div class="col-4 pl-0 pr-0">
                            <div class="form-group form-group-default border border-primary" >
                                <label for="historia" class="text-primary font-weight-bold">Aseguradora </label>
                                <p class="form-control-static font-weight-bold mb-0">{{ 'PARTICULAR MAYOLO' }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="form-group form-group-default border border-primary" >
                                <label for="historia" class="text-primary font-weight-bold">Profesional </label>
                                <p class="form-control-static font-weight-bold mb-0">{{ 'CARLOS APARICIO ZAMBRANO' }}</p>
                            </div>
                        </div>
                        <div class="col-2 pl-0 pr-0">
                            <div class="form-group form-group-default border border-primary" >
                                <label for="historia" class="text-primary font-weight-bold">Fecha </label>
                                <p class="form-control-static font-weight-bold mb-0">{{ '12/01/2019' }}</p>
                            </div>
                        </div>
                        <div class="col-2 pr-0">
                            <div class="form-group form-group-default border border-primary" >
                                <label for="historia" class="text-primary font-weight-bold">T.C </label>
                                <p class="form-control-static font-weight-bold mb-0">{{ '3.20' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-3">
                    <button class="btn btn-info btn-block btn-sm"><span class="btn-label"><i class="la la-info"></i></span>Tx sin Piezas</button>
                    <button class="btn btn-success btn-block btn-sm"><span class="btn-label"><i class="la la-check"></i></span>Grabar</button>
                    <button class="btn btn-warning btn-block btn-sm" v-if="!select_multi" @click.prevent="select_multi = true"><span class="btn-label"><i class="la la-exclamation-circle"></i></span>Seleccion Multiple</button>             
                    <button class="btn btn-danger btn-block btn-sm" v-if="select_multi" @click.prevent="cancelarMultiple"><span class="btn-label"><i class="la la-exclamation-circle"></i></span>Cancelar Multiple</button>             
                    <button class="btn btn-primary btn-block btn-sm" v-if="select_multi" :disabled="!(list_dent_multiple.length > 1)" @click.prevent="LoadServices"><span class="btn-label"><i class="la la-bookmark"></i></span>Cargar Servicios</button>
                </div>
            </div>
            <div class="row">
                <div class="col-12">
                    <div class="form-group border border-primary pt-0 pb-0">
                        <p class="form-control-static text-primary font-weight-bold mb-10">Tipo de Odontograma</p>
                        <p-radio v-for="tip in tiposOdontograma" class="p-icon p-curve p-tada" :key="tip.id" :value="tip.id" name="radio77" color="primary-o" v-model="tipoOdonto" @change="cambioTipo(tip.id)">
                            <i slot="extra" class="icon la la-check"></i><label class="text-primary font-weight-bold float-left">{{ tip.nombre }} </label>                              
                        </p-radio>  
                    </div>

                </div>              
            </div>
            <!-- Inicio de Odontograma -->
            <div class="row">
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
                                            <p class="form-control-static text-center mb-0" :class="{seleccionado:contains(list_dent_multiple,info),'text-danger':contains(list_dent_multiple,info)}" :id="'t'+info.id">{{ info.codigo }}</p>
                                            <input type="text" name="" :id="'d'+info.id" class="texto-dientito" maxlength="3"> 
                                            <div>
                                                <svg height="32" :class="info.tipo" width="32" v-tooltip.top-start="info.nombre_diente" :id="info.id" @click.prevent="ShowDiente(info)">
                                                    <!-- Caras del diente -->
                                                    <polygon points="6,6 30,6 24,12 12,12" :class="BuscoCara(info,'V')" @contextmenu.prevent.stop ="openMenu($event,info)"/> <!-- CARA 1 Trapecio superior -->
                                                    <polygon points="30,6 30,30 24,24 24,12" :class="BuscoCara(info,'M')" @contextmenu.prevent.stop ="openMenu($event,info)"/> <!-- CARA 2 Trapecio lateral derecho -->
                                                    <polygon points="30,30 6,30 12,24 24,24" :class="BuscoCara(info,'P')" @contextmenu.prevent.stop ="openMenu($event,info)"/> <!-- CARA 3 Trapecio inferior -->
                                                    <polygon points="6,30 12,24 12,12 6,6" :class="BuscoCara(info,'D')" @contextmenu.prevent.stop ="openMenu($event,info)"/> <!-- CARA 4 trapecio lateral izquierdo-->
                                                    <polygon points="12,12 24,12 24,24 12,24" :class="BuscoCara(info,'O')" @contextmenu.prevent.stop ="openMenu($event,info)"/> <!-- CARA 5 Cuadrado Central -->
                                                    <!-- Tratamientos / Estados del diente -->
                                                    <polygon points="16,8 20,8 20,28 16,28" :class="[BuscoDiente(info) == 2 ? 'marcadoEndodonciaO marcado' : 'endodoncia']" @contextmenu.prevent.stop ="openMenu($event,info)"/>
                                                    <circle cx="18" cy="18" r="10" :class="[BuscoDiente(info) == 3 ? 'marcadoCoronaO marcado' : 'corona']" @contextmenu.prevent.stop ="openMenu($event,info)"/>
                                                    <polygon points="6,10 10,6 30,26 26,30" :class="[BuscoDiente(info) == 4 ? 'marcadoExodonciaO marcado' : 'exodoncia']" @contextmenu.prevent.stop ="openMenu($event,info)"/>                                    
                                                    <polygon points="26,6 30,10 10,30 6,26" :class="[BuscoDiente(info) == 4 ? 'marcadoExodonciaO marcado' : 'exodoncia']" @contextmenu.prevent.stop ="openMenu($event,info)"/>
                                                    <image v-if="BuscoDiente(info) == 5" xlink:href="/img/odontograma/perno4.png" x=6 y=6 width=26 height=26 class="perno" @contextmenu.prevent.stop ="openMenu($event,info)"/>
                                                    <path d="M 8,20 a10,10 0 1,1 20,0" :class="[BuscoDiente(info) == 6 ? 'marcadoIonomeroO marcado' : 'ionomero']" @contextmenu.prevent.stop ="openMenu($event,info)"></path>
                                                    <text x=8 y=29 :class="[BuscoDiente(info) == 7 ? 'marcadoSellanteO marcado' : 'sellante']" @contextmenu.prevent.stop ="openMenu($event,info)">S</text>                                                                        
                                                    <ellipse cx="18" cy="18" rx="12" ry="7" :class="[BuscoDiente(info) == 8 ? 'marcadoGeneralO marcado' : 'general']" @contextmenu.prevent.stop ="openMenu($event,info)"/>
                                                    <line x1="8" y1="18" x2="30" y2="18" :class="[BuscoDiente(info) == 8 ? 'marcadoGeneralO marcado' : 'general']" @contextmenu.prevent.stop ="openMenu($event,info)"/>                                    
                                                </svg>                                                                                                                                            
                                            </div>                                            
                                        </div>                                          
                                    </div>
                                                                        
                                </div>
                                <div class="col-6">
                                    <div class="row" v-for="i in cuadrante_derecho_superior" :key="i">
                                        <div v-for="info in getDientesByCuadrante(i)" :key="info.id" class="dientito">
                                            <p class="form-control-static text-center mb-0" :class="{seleccionado:contains(list_dent_multiple,info),'text-danger':contains(list_dent_multiple,info)}" :id="'t'+info.id">{{ info.codigo }}</p>
                                            <input type="text" name="" :id="'d'+info.id" class="texto-dientito" maxlength="3"> 
                                            <div>
                                                <svg height="32" :class="info.tipo" width="32" v-tooltip.top-start="info.nombre_diente" :id="info.id" @click.prevent="ShowDiente(info)">
                                                    <!-- Caras del Diente -->
                                                    <polygon points="6,6 30,6 24,12 12,12" :class="BuscoCara(info,'V')" @contextmenu.prevent.stop ="openMenu($event,info)"/> <!-- CARA 1 Trapecio superior -->
                                                    <polygon points="30,6 30,30 24,24 24,12" :class="BuscoCara(info,'M')" @contextmenu.prevent.stop ="openMenu($event,info)"/> <!-- CARA 2 Trapecio lateral derecho -->
                                                    <polygon points="30,30 6,30 12,24 24,24" :class="BuscoCara(info,'P')" @contextmenu.prevent.stop ="openMenu($event,info)"/> <!-- CARA 3 Trapecio inferior -->
                                                    <polygon points="6,30 12,24 12,12 6,6" :class="BuscoCara(info,'D')" @contextmenu.prevent.stop ="openMenu($event,info)"/> <!-- CARA 4 trapecio lateral izquierdo-->
                                                    <polygon points="12,12 24,12 24,24 12,24" :class="BuscoCara(info,'O')" @contextmenu.prevent.stop ="openMenu($event,info)"/> <!-- CARA 5 Cuadrado Central -->
                                                    <!-- Tratamientos / Estados del diente -->
                                                    <polygon points="16,8 20,8 20,28 16,28" :class="[BuscoDiente(info) == 2 ? 'marcadoEndodonciaO marcado' : 'endodoncia']" @contextmenu.prevent.stop ="openMenu($event,info)"/>
                                                    <circle cx="18" cy="18" r="10" :class="[BuscoDiente(info) == 3 ? 'marcadoCoronaO marcado' : 'corona']" @contextmenu.prevent.stop ="openMenu($event,info)"/>
                                                    <polygon points="6,10 10,6 30,26 26,30" :class="[BuscoDiente(info) == 4 ? 'marcadoExodonciaO marcado' : 'exodoncia']" @contextmenu.prevent.stop ="openMenu($event,info)"/>                                    
                                                    <polygon points="26,6 30,10 10,30 6,26" :class="[BuscoDiente(info) == 4 ? 'marcadoExodonciaO marcado' : 'exodoncia']" @contextmenu.prevent.stop ="openMenu($event,info)"/>
                                                    <image v-if="BuscoDiente(info) == 5" xlink:href="/img/odontograma/perno4.png" x=6 y=6 width=26 height=26 class="perno" @contextmenu.prevent.stop ="openMenu($event,info)"/>
                                                    <path d="M 8,20 a10,10 0 1,1 20,0" :class="[BuscoDiente(info) == 6 ? 'marcadoIonomeroO marcado' : 'ionomero']" @contextmenu.prevent.stop ="openMenu($event,info)"></path>
                                                    <text x=8 y=29 :class="[BuscoDiente(info) == 7 ? 'marcadoSellanteO marcado' : 'sellante']" @contextmenu.prevent.stop ="openMenu($event,info)">S</text>                                                                        
                                                    <ellipse cx="18" cy="18" rx="12" ry="7" :class="[BuscoDiente(info) == 8 ? 'marcadoGeneralO marcado' : 'general']" @contextmenu.prevent.stop ="openMenu($event,info)"/>
                                                    <line x1="8" y1="18" x2="30" y2="18" :class="[BuscoDiente(info) == 8 ? 'marcadoGeneralO marcado' : 'general']" @contextmenu.prevent.stop ="openMenu($event,info)"/>                                    
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
                                            <p class="form-control-static text-center mb-0" :class="{seleccionado:contains(list_dent_multiple,info),'text-danger':contains(list_dent_multiple,info)}" :id="'t'+info.id">{{ info.codigo }}</p>
                                            <input type="text" name="" :id="'d'+info.id" class="texto-dientito" maxlength="3"> 
                                            <div>
                                                <svg height="32" :class="info.tipo" width="32" v-tooltip.top-start="info.nombre_diente" :id="info.id" @click.prevent="ShowDiente(info)">
                                                    <!-- Caras del Diente -->
                                                    <polygon points="6,6 30,6 24,12 12,12" :class="BuscoCara(info,'V')" @contextmenu.prevent.stop ="openMenu($event,info)"/> <!-- CARA 1 Trapecio superior -->
                                                    <polygon points="30,6 30,30 24,24 24,12" :class="BuscoCara(info,'M')" @contextmenu.prevent.stop ="openMenu($event,info)"/> <!-- CARA 2 Trapecio lateral derecho -->
                                                    <polygon points="30,30 6,30 12,24 24,24" :class="BuscoCara(info,'P')" @contextmenu.prevent.stop ="openMenu($event,info)"/> <!-- CARA 3 Trapecio inferior -->
                                                    <polygon points="6,30 12,24 12,12 6,6" :class="BuscoCara(info,'D')" @contextmenu.prevent.stop ="openMenu($event,info)"/> <!-- CARA 4 trapecio lateral izquierdo-->
                                                    <polygon points="12,12 24,12 24,24 12,24" :class="BuscoCara(info,'O')" @contextmenu.prevent.stop ="openMenu($event,info)"/> <!-- CARA 5 Cuadrado Central -->
                                                    <!-- Tratamientos / Estados del diente -->
                                                    <polygon points="16,8 20,8 20,28 16,28" :class="[BuscoDiente(info) == 2 ? 'marcadoEndodonciaO marcado' : 'endodoncia']" @contextmenu.prevent.stop ="openMenu($event,info)"/>
                                                    <circle cx="18" cy="18" r="10" :class="[BuscoDiente(info) == 3 ? 'marcadoCoronaO marcado' : 'corona']" @contextmenu.prevent.stop ="openMenu($event,info)"/>
                                                    <polygon points="6,10 10,6 30,26 26,30" :class="[BuscoDiente(info) == 4 ? 'marcadoExodonciaO marcado' : 'exodoncia']" @contextmenu.prevent.stop ="openMenu($event,info)"/>                                    
                                                    <polygon points="26,6 30,10 10,30 6,26" :class="[BuscoDiente(info) == 4 ? 'marcadoExodonciaO marcado' : 'exodoncia']" @contextmenu.prevent.stop ="openMenu($event,info)"/>
                                                    <image v-if="BuscoDiente(info) == 5" xlink:href="/img/odontograma/perno4.png" x=6 y=6 width=26 height=26 class="perno" @contextmenu.prevent.stop ="openMenu($event,info)"/>
                                                    <path d="M 8,20 a10,10 0 1,1 20,0" :class="[BuscoDiente(info) == 6 ? 'marcadoIonomeroO marcado' : 'ionomero']" @contextmenu.prevent.stop ="openMenu($event,info)"></path>
                                                    <text x=8 y=29 :class="[BuscoDiente(info) == 7 ? 'marcadoSellanteO marcado' : 'sellante']" @contextmenu.prevent.stop ="openMenu($event,info)">S</text>                                                                        
                                                    <ellipse cx="18" cy="18" rx="12" ry="7" :class="[BuscoDiente(info) == 8 ? 'marcadoGeneralO marcado' : 'general']" @contextmenu.prevent.stop ="openMenu($event,info)"/>
                                                    <line x1="8" y1="18" x2="30" y2="18" :class="[BuscoDiente(info) == 8 ? 'marcadoGeneralO marcado' : 'general']" @contextmenu.prevent.stop ="openMenu($event,info)"/>                                    
                                                </svg>
                                            </div>
                                        </div>
                                    </div>                            
                                </div>
                                <div class="col-6">
                                    <div class="row" v-for="i in cuadrante_derecho_inferior" :key="i">
                                        <div v-for="info in getDientesByCuadrante(i)" :key="info.id" class="dientito">
                                            <p class="form-control-static text-center mb-0" :class="{seleccionado:contains(list_dent_multiple,info),'text-danger':contains(list_dent_multiple,info)}" :id="'t'+info.id">{{ info.codigo }}</p>
                                            <input type="text" name="" :id="'d'+info.id" class="texto-dientito" maxlength="3"> 
                                            <div>
                                                <svg height="32" :class="info.tipo" width="32" v-tooltip.top-start="info.nombre_diente" :id="info.id" @click.prevent="ShowDiente(info)">
                                                    <!-- Caras del Diente-->
                                                    <polygon points="6,6 30,6 24,12 12,12" :class="BuscoCara(info,'V')" @contextmenu.prevent.stop ="openMenu($event,info)"/> <!-- CARA 1 Trapecio superior -->
                                                    <polygon points="30,6 30,30 24,24 24,12" :class="BuscoCara(info,'M')" @contextmenu.prevent.stop ="openMenu($event,info)"/> <!-- CARA 2 Trapecio lateral derecho -->
                                                    <polygon points="30,30 6,30 12,24 24,24" :class="BuscoCara(info,'P')" @contextmenu.prevent.stop ="openMenu($event,info)"/> <!-- CARA 3 Trapecio inferior -->
                                                    <polygon points="6,30 12,24 12,12 6,6" :class="BuscoCara(info,'D')" @contextmenu.prevent.stop ="openMenu($event,info)"/> <!-- CARA 4 trapecio lateral izquierdo-->
                                                    <polygon points="12,12 24,12 24,24 12,24" :class="BuscoCara(info,'O')" @contextmenu.prevent.stop ="openMenu($event,info)"/> <!-- CARA 5 Cuadrado Central -->
                                                    <!-- Tratamientos / Estados del diente -->
                                                    <polygon points="16,8 20,8 20,28 16,28" :class="[BuscoDiente(info) == 2 ? 'marcadoEndodonciaO marcado' : 'endodoncia']" @contextmenu.prevent.stop ="openMenu($event,info)"/>
                                                    <circle cx="18" cy="18" r="10" :class="[BuscoDiente(info) == 3 ? 'marcadoCoronaO marcado' : 'corona']" @contextmenu.prevent.stop ="openMenu($event,info)"/>
                                                    <polygon points="6,10 10,6 30,26 26,30" :class="[BuscoDiente(info) == 4 ? 'marcadoExodonciaO marcado' : 'exodoncia']" @contextmenu.prevent.stop ="openMenu($event,info)"/>                                    
                                                    <polygon points="26,6 30,10 10,30 6,26" :class="[BuscoDiente(info) == 4 ? 'marcadoExodonciaO marcado' : 'exodoncia']" @contextmenu.prevent.stop ="openMenu($event,info)"/>
                                                    <image v-if="BuscoDiente(info) == 5" xlink:href="/img/odontograma/perno4.png" x=6 y=6 width=26 height=26 class="perno" @contextmenu.prevent.stop ="openMenu($event,info)"/>
                                                    <path d="M 8,20 a10,10 0 1,1 20,0" :class="[BuscoDiente(info) == 6 ? 'marcadoIonomeroO marcado' : 'ionomero']" @contextmenu.prevent.stop ="openMenu($event,info)"></path>
                                                    <text x=8 y=29 :class="[BuscoDiente(info) == 7 ? 'marcadoSellanteO marcado' : 'sellante']" @contextmenu.prevent.stop ="openMenu($event,info)">S</text>                                                                        
                                                    <ellipse cx="18" cy="18" rx="12" ry="7" :class="[BuscoDiente(info) == 8 ? 'marcadoGeneralO marcado' : 'general']" @contextmenu.prevent.stop ="openMenu($event,info)"/>
                                                    <line x1="8" y1="18" x2="30" y2="18" :class="[BuscoDiente(info) == 8 ? 'marcadoGeneralO marcado' : 'general']" @contextmenu.prevent.stop ="openMenu($event,info)"/>                                    
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
            <ul id="right-click-menu" tabindex="-1" ref="menu" v-if="viewMenu" @blur="closeMenu" v-bind:style="{top:top, left:left}">
                <li @click.prevent="deleteItem">Eliminar</li>
            </ul>            
            <div class="row">
                <table class="table table-bordered table-sm table-head-bg-info table-bordered-bd-info">
                    <thead>
                        <tr>
                            <th scope="col">Diente</th>
                            <th scope="col">Servicio</th>
                            <th scope="col">Moneda</th>
                            <th scope="col">Deducible</th>
                            <th scope="col">Coaseguro</th>
                            <th scope="col">P.Aseg</th>     
                            <th scope="col">C.Total</th> 
                            <th scope="col"></th>                                                                                                                         
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="serv in lista_general_presupuesto" :key="serv.id">
                            <td>{{ serv.letras }}</td>
                            <td>{{ serv.nombre_servicio}}</td>
                            <td>{{ serv.nombre_moneda}}</td>
                            <td>0</td>
                            <td>0</td>  
                            <td>0</td>   
                            <td>{{ serv.costo}}</td> 
                            <td><button type="button" v-tooltip="'Eliminar Item'" class="btn btn-danger btn-xs" @click.prevent="borrarItem(serv)">
                                    <i class="la la-trash-o font-large"></i>
                                </button>
                            </td>                                                                                                                        
                        </tr>
                        <tr v-if="lista_general_presupuesto.length == 0">
                            <td colspan="8" class="text-center">NO HAY SERVICIOS CARGADOS ...</td>                                           
                        </tr>
                        <tr v-else>
                            <td>Totales</td>
                            <td>Cliente: {{ costoTotal }}</td>
                            <td colspan="2">Aseguradora:</td>
                            <td colspan="4">Total: {{ costoTotal }}</td>
                        </tr>
                    </tbody>
                </table>                                
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
                                    <p-radio class="p-icon p-curve p-tada mr-0" :value="sim.id" name="radio66" color="primary-o" v-model="simboloID" @change="cambiotratamiento(sim.id)">
                                        <i slot="extra" class="icon la la-check"></i>                                
                                    </p-radio>
                                    <div>
                                        <svg height="42" width="42" v-tooltip.top="sim.nombre_simbologia" :id="'tratam_' + sim.id">
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
                                <button type="button" class="btn btn-primary btn-sm float-right" @click.prevent="cargaTratamientos">Buscar Servicios <i class="la flaticon-search-2"></i></button>
                            </div>
                        </div>
                        <div class="row mt-10">
                            <div class="col-3 mr-0 pr-0">
                                <svg height="160" width="160" id="diente_servicios">
                                    <!-- Caras del Diente -->                                        
                                    <polygon points="0,0 160,0 120,40 40,40" v-tooltip.top="'VESTIBULAR'" :class="[simboloID == 1 && multicaras.includes(1) ? 'marcadoRojo marcado' : 'diente']" @click.prevent="selectD(1)" /> <!-- CARA 1 Trapecio superior -->
                                    <polygon points="160,0 160,160 120,120 120,40" v-tooltip.right="'MESIAL'" :class="[simboloID == 1 && multicaras.includes(2) ? 'marcadoRojo marcado' : 'diente']" @click.prevent="selectD(2)" /> <!-- CARA 2 Trapecio lateral derecho -->
                                    <polygon points="160,160 0,160 40,120 120,120" v-tooltip.bottom="'PALATINO'" :class="[simboloID == 1 && multicaras.includes(3) ? 'marcadoRojo marcado' : 'diente']" @click.prevent="selectD(3)"/> <!-- CARA 3 Trapecio inferior -->
                                    <polygon points="0,160 40,120 40,40 0,0" v-tooltip.left="'DISTAL'" :class="[simboloID == 1 && multicaras.includes(4) ? 'marcadoRojo marcado' : 'diente']" @click.prevent="selectD(4)" /> <!-- CARA 4 trapecio lateral izquierdo-->
                                    <polygon points="40,40 120,40 120,120 40,120" v-tooltip.top="'OCLUSAL'" :class="[simboloID == 1 && multicaras.includes(5) ? 'marcadoRojo marcado' : 'diente']" @click.prevent="selectD(5)" /> <!-- CARA 5 Cuadrado Central -->
                                    <!-- Tratamientos del Diente -->
                                    <polygon points="75,5 87,5 87,155 75,155" :class="[simboloID == 2 ? 'marcadoEndodonciaD marcado' : 'endodoncia']"/>                                           
                                    <circle cx="80" cy="80" r="70" :class="[simboloID == 3 ? 'marcadoCoronaD marcado' : 'corona']"/>
                                    <polygon points="0,10 10,0 160,150 150,160" :class="[simboloID == 4 ? 'marcadoExodonciaD marcado' : 'exodoncia']"/>                                    
                                    <polygon points="150,0 160,10 10,160 0,150" :class="[simboloID == 4 ? 'marcadoExodonciaD marcado' : 'exodoncia']" />
                                    <image v-if="simboloID == 5" xlink:href="/img/odontograma/perno4.png" x=0 y=0 width=160 height=160 />                                        
                                    <path d="M 10,85 a40,40 0 1,1 140,0" :class="[simboloID == 6 ? 'marcadoIonomeroD marcado' : 'ionomero']"></path>
                                    <text x=40 y=130 :class="[simboloID == 7 ? 'marcadoSellanteD marcado' : 'sellante']">S</text>                                                                        
                                    <ellipse cx="80" cy="80" rx="75" ry="35"  :class="[simboloID == 8 ? 'marcadoGeneralD marcado' : 'general']"/>
                                    <line x1="5" y1="80" x2="155" y2="80" :class="[simboloID == 8 ? 'marcadoGeneralD marcado' : 'general']"/>                                    
                                </svg>
                            </div>
                            <div class="col-9 pl-0">
                                <table class="table table-bordered table-sm table-head-bg-info table-bordered-bd-info">
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
                                        <tr v-for="serv in list_services_dent" :key="serv.id">
                                            <td>{{ serv.letras }}</td>
                                            <td>{{ serv.nombre_servicio}}</td>
                                            <td>{{ serv.nombre_moneda}}</td>
                                            <td>0</td>
                                            <td>0</td>  
                                            <td>0</td>   
                                            <td>{{ serv.costo}}</td>  
                                            <td>{{ serv.costo}}</td>                                                                                                                         
                                        </tr>
                                        <tr v-if="list_services_dent.length == 0">
                                            <td colspan="8" class="text-center">NO HAY SERVICIOS CARGADOS ...</td>                                           
                                        </tr>
                                    </tbody>
                                </table>                                
                            </div>

                        </div>
                    </div>
                    <div class="card-action">
                        <button class="btn btn-primary float-right ml-10" :disabled="list_services_dent.length == 0" @click.prevent="ActionServicio"><span class="btn-label"><i :class="[IconClass]"></i> {{ labelButton }}</span></button>
                        <button class="btn btn-danger float-right" @click="salirDiente"><span class="btn-label"><i class="la la-times-circle"></i> Cancelar</span></button>
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
    mounted(){
        this.cambioTipo(1)
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
                diente_id: '',
                diente_codigo: '',
                caras: '',
                simbologia: '',
                letras : '',
                servicio_id : '',
                nombre_servicio : '',
                costo : '',
                nombre_moneda : ''
            },
            tiposOdontograma:[
                {id:1 , nombre:'permanente'},
                {id:2 , nombre:'nino'},
                {id:3 , nombre:'mixta'}
            ],
            simboloID:'',
            tipoOdonto:1,
            denteselect:'',
            infodent:'',
            multicaras:[],
            select_multi: false,
            list_dent_multiple:[],
            list_services_dent:[],
            lista_general_presupuesto:[],
            selected: undefined,
            odontograma:[],
            cuadrante_izquierdo_superior:[1,5],
            cuadrante_derecho_superior:[2,6],
            cuadrante_izquierdo_inferior:[8,4],
            cuadrante_derecho_inferior:[7,3],
            viewMenu: false,
            top: '0px',
            left: '0px',
            deleteDent:[]
        }
    },
    computed: {
        ...mapState(['dientes','simbologias','tarifarios']),
        ...mapGetters(['getDientesByCuadrante']),  
        simbolos(){
            return _.sortBy(this.simbologias, 'id');
        },
        costoTotal(){
            let costo = 0
            this.lista_general_presupuesto.map(function(value, key){
                costo += parseFloat(value.costo)
            })
            return parseFloat(costo).toFixed(2)
        }                 
    },  
    watch:{
        simboloID (newVal,oldVal){
            if(newVal != 1){
                this.multicaras =[]
            }
        }
    },  
    methods: {
        ShowDiente(params){
            if(!this.contains(this.odontograma,params.id)) return
            this.infodent = params
            if(this.select_multi){
                if(this.contains(this.list_dent_multiple,params)){
                    this.list_dent_multiple = _.reject(this.list_dent_multiple, function(val){
                        return val.id == params.id
                    });
                }else{
                    this.list_dent_multiple.push(params)
                }
            }else{
                this.LoadServices()
            } 
        },
        LoadServices(){
            let self = this
            this.list_services_dent = []
            if(this.select_multi){

            }else{
                let encontrado = self.lista_general_presupuesto.find(ser => ser.diente_id == self.infodent.id)
                if(encontrado){
                    this.list_services_dent.push(encontrado)
                }
            }

            this.dataTratamiento = {
                diente_id: '',
                diente_codigo: '',
                caras: '',
                simbologia: '',
                letras : '',
                servicio_id : '',
                nombre_servicio : '',
                costo : '',
                nombre_moneda : ''              
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
            let self = this 
            let datalist = []                  
            if(this.multicaras.includes(5)) _letras += 'O'
            if(this.multicaras.includes(1)) _letras += 'V'
            if(this.multicaras.includes(3)) _letras += 'P'
            if(this.multicaras.includes(2)) _letras += 'M'
            if(this.multicaras.includes(4)) _letras += 'D'
            if(this.simboloID != 1) _letras='OVPMD'

            if(this.select_multi){
                this.list_dent_multiple.map(function(value, key) {                                       
                    self.dataTratamiento = {
                        diente_id: value.id,
                        diente_codigo: value.codigo,
                        caras: _letras,
                        simbologia: self.simboloID,
                        letras : value.codigo.replace('.', '') + '_' + _letras,
                        servicio_id : param.row.id,
                        nombre_servicio : param.row.servicio.nombre_servicio,
                        costo : param.row.costo,
                        nombre_moneda : param.row.moneda.nombre_moneda
                    } 
                    datalist = _.clone(self.dataTratamiento)             
                    self.list_services_dent.push(datalist)
                })
            }else{
                this.dataTratamiento = {
                    diente_id: this.infodent.id,
                    diente_codigo: this.infodent.codigo,
                    caras: _letras,
                    simbologia: this.simboloID,
                    letras : this.infodent.codigo.replace('.', '') + '_' + _letras,
                    servicio_id : param.row.id,
                    nombre_servicio : param.row.servicio.nombre_servicio,
                    costo : param.row.costo,
                    nombre_moneda : param.row.moneda.nombre_moneda
                }                
                this.list_services_dent.push(this.dataTratamiento)
            }
            this.multicaras = []
            this.selected = undefined
            this.$modal.hide('tratamientos');            
        },
        selectD(param){
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
            this.$modal.hide('carga_servicios')
        },
        cambioTipo(param){
            this.lista_general_presupuesto = []
            if(param == 1) this.odontograma = [1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31,32]
            if(param == 2) this.odontograma = [33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52]
            if(param == 3) this.odontograma = [1,2,3,14,15,16,17,18,19,30,31,32,33,34,35,36,37,38,39,40,41,42,43,44,45,46,47,48,49,50,51,52]
        },
        ActionServicio(){
            let self = this
            this.list_dent_multiple = []
            this.select_multi = false  
            this.simboloID = '' 
            this.selected = undefined   
            this.list_services_dent.map(function(value, key) {
                self.lista_general_presupuesto.push(value)
            })     
            this.$modal.hide('carga_servicios')
        },
        BuscoDiente(param){
            let serdent = this.lista_general_presupuesto.find(ser => ser.diente_id == param.id)            
            if(serdent){
                return serdent.simbologia
            }
            return undefined
        },  
        BuscoCara(param,cara){
            let encontrado;
            self = this
            if(this.contains(this.odontograma,param.id)){
                encontrado = self.lista_general_presupuesto.find(ser => ser.diente_id == param.id)
                if(encontrado){                 
                    if(encontrado.simbologia == 1){                       
                        if(encontrado.caras.indexOf(cara) > -1){
                            return 'marcadoRojo marcado'
                        }
                    }
                }
                return 'diente'
            }
            return 'deshabilitado'
        },
        setMenu(top, left) {               
/*             let largestHeight = window.innerHeight - this.$refs.menu.offsetHeight - 25;
            let largestWidth = window.innerWidth - this.$refs.menu.offsetWidth - 25;
            if (top > largestHeight) top = largestHeight;
            if (left > largestWidth) left = largestWidth; */
            this.top = (top - this.$refs.contenedor.getBoundingClientRect().top) + 'px'
            this.left = (left - this.$refs.contenedor.getBoundingClientRect().left) + 'px'
        },

        closeMenu() {
            this.viewMenu = false
        },

        openMenu(e,param) {
            console.log("di click",param)
            this.deleteDent = param
            let self = this
            this.viewMenu = true
            this.$nextTick(function() {
                self.$refs.menu.focus();
                self.setMenu(e.y, e.x)
            })
            e.preventDefault();
        },
        deleteItem(){
            console.log(this.deleteDent)
            let self = this
            let encontrado = this.lista_general_presupuesto.find(lis => lis.diente_id == self.deleteDent.id)
            if(encontrado){
                this.lista_general_presupuesto = _.reject(self.lista_general_presupuesto, function(val){
                    return val.diente_id == self.deleteDent.id
                });
            }           
            this.closeMenu()
        },
        borrarItem(param){
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
                        let encontrado = this.lista_general_presupuesto.find(lis => lis.diente_id == param.diente_id)
                        if(encontrado){
                            this.lista_general_presupuesto = _.reject(this.lista_general_presupuesto, function(val){
                                return val.diente_id == param.diente_id
                            });
                        } 
                    }
                });              
        }

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
        fill:red;
        stroke:dimgrey;
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
        stroke-width: 4px 
    }
    .marcadoIonomeroO
    {
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
        fill : red !important;
        stroke:red !important;
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
    .btn-xs {
        padding: 2px !important;
    } 
    #right-click-menu{
        background: rgb(238, 237, 237);
        border: 1px solid #BDBDBD;
        box-shadow: 0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);
        display: block;
        list-style: none;
        margin: 0;
        padding: 0;
        position: absolute;
        width: 120px;
        z-index: 999999;
    }

    #right-click-menu li {
        cursor:pointer; 
        cursor: hand ;  
        border-bottom: 1px solid #E0E0E0;
        margin: 0;
        padding: 5px 35px;
    }

    #right-click-menu li:last-child {
        border-bottom: none;
    }

    #right-click-menu li:hover {
        background: #1E88E5;
        color: #FAFAFA;
    }      
</style>