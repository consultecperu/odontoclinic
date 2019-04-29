import store from './store'

import Login from './components/login/login.vue'
import TemplateMain from './components/template/templatemain.vue'

import Dashboard from './components/dashboard/dashboard.vue'
import Perfiles from './components/seguridad/perfiles.vue'
import Modulos from './components/seguridad/modulos.vue'
import Usuarios from './components/seguridad/usuarios.vue'
import Accesos from './components/seguridad/accesos.vue'

import Cargos from './components/configuracion/cargos.vue'
import Gruposervicios from './components/configuracion/gruposervicios.vue'
import Laboratorios from './components/configuracion/laboratorios.vue'
import Detallelaboratorio from './components/configuracion/detallelaboratorios.vue'
import DetallelaboratorioMultident from './components/configuracion/detallelaboratoriosmultident.vue'
import Materiales from './components/configuracion/materiales.vue'
import Detallematerial from './components/configuracion/detallemateriales.vue'
import Sedes from './components/configuracion/sedes.vue'
import Empresaadministradoras from './components/configuracion/empresaadministradoras.vue'
import Servicios from './components/configuracion/servicios.vue'
import Tarifarios from './components/configuracion/tarifarios.vue'
import Detalletarifarios from './components/configuracion/detalletarifarios.vue'

import Convenios from './components/marketing/Convenios.vue'
import Campañas from './components/marketing/Campañas.vue'
import Canjes from './components/marketing/Canjes.vue'

import Aseguradora from './components/seguros/aseguradora.vue'
import Empresas from './components/seguros/empresas.vue'
import Polizas from './components/seguros/polizas.vue'
import Detalleaseguradora from './components/seguros/detalleaseguradora.vue'
import Detalleempresa from './components/seguros/detalleempresa.vue'

import Pacientes from './components/entidades/pacientes.vue'
import DetallePacientes from './components/entidades/detallepacientes/maindetalle.vue'
import DetPacDatos from './components/entidades/detallepacientes/datos.vue'
import DetPacDerivaciones from './components/entidades/detallepacientes/derivaciones.vue'
import DetPacCitas from './components/entidades/detallepacientes/citaspaciente.vue'
import DetPacMultimedia from './components/entidades/detallepacientes/multimedia.vue'
import ListaPptoOperatoria from './components/entidades/detallepacientes/lista_ppto_operatoria.vue'
import ListaPptoOrtodoncia from './components/entidades/detallepacientes/lista_ppto_ortodoncia.vue'
import PptoOperatoria from './components/entidades/detallepacientes/ppto_operatoria.vue'
import VerPptoOperatoria from './components/entidades/detallepacientes/ver_ppto_operatoria.vue'
import PptoOrtodoncia from './components/entidades/detallepacientes/ppto_ortodoncia.vue'
import VerPptoOrtodoncia from './components/entidades/detallepacientes/ver_ppto_ortodoncia.vue'
import RecordAtencion from './components/entidades/detallepacientes/ver_record_atencion.vue'
import Medicos from './components/entidades/medicos.vue'
import Detallemedicos from './components/entidades/detallemedicos.vue'
import Personal from './components/entidades/personal.vue'
import Detallepersonal from './components/entidades/detallepersonal.vue'

import Citas from './components/agenda/citas.vue'
import Seguimientos from './components/agenda/seguimientos.vue'
/* import Modular from './components/agenda/modular.vue' */

import TipoCambios from './components/caja/tipocambios.vue'
import CierreCaja from './components/caja/cierrecaja.vue'
import VentaDiaria from './components/caja/ventadiaria.vue'

import LiquidacionOperatoria from './components/liquidaciones/liquidacionoperatoria.vue'
import LiquidacionOrtodoncia from './components/liquidaciones/liquidacionortodoncia.vue'
import LiquidacionLaboratorio from './components/liquidaciones/liquidacionlaboratorio.vue'
import LiquidacionAseguradora from './components/liquidaciones/liquidacionaseguradora.vue'

import PagosLiquidacionOperatoria from './components/pagos/cancelacion_operatoria.vue'
import PagosLiquidacionOrtodoncia from './components/pagos/cancelacion_ortodoncia.vue'
import PagosLiquidacionLaboratorio from './components/pagos/cancelacion_laboratorios.vue'

import NotFound from './components/errors/notfound.vue'

export default [
    {
        path: '/',
        name: 'admin',
        component: TemplateMain,
        children: [
            {
                path: '/dashboard',
                name: 'dashboard',
                component: Dashboard,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Dashboard', second: null , third : null}
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }
            },
            {
                path: '/login',
                name: 'login',
                component: Login,
                meta: { redirectIfLogged: true }
            }, 
            {
                path: '/perfiles',
                name: 'perfiles',
                component: Perfiles,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Perfiles', second: 'Seguridad', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                
            },               
            {
                path: '/modulos',
                name: 'modulos',
                component: Modulos,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Modulos', second: 'Seguridad', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            }, 
            {
                path: '/usuarios',
                name: 'usuarios',
                component: Usuarios,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Usuarios', second: 'Seguridad', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            },
            {
                path: '/accesos/:user',
                name: 'accesos',
                component: Accesos,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Accesos', second: 'Usuarios', third : 'Seguridad' ,ruta_second : 'usuarios' }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            },                          
            {
                path: '/cargos',
                name: 'cargos',
                component: Cargos,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Cargos', second: 'Configuracion', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            },                                      
            {
                path: '/gruposervicios',
                name: 'gruposervicios',
                component: Gruposervicios,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Grupo de Servicios', second: 'Configuracion', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                  
            },
            {
                path: '/servicios',
                name: 'servicios',
                component: Servicios,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Servicios', second: 'Configuracion', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                  
            },              
            {
                path: '/laboratorios',
                name: 'laboratorios',
                component: Laboratorios,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Laboratorios', second: 'Configuracion', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                  
            },
            {
                path: '/detalle-laboratorio/:laboratorio',
                name: 'detallelaboratorio',
                component: Detallelaboratorio,
                meta: { requiresAuth: true },
                props: true,
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Servicios', second: 'Laboratorios' , third : 'Configuracion' , ruta_second : 'laboratorios' }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                  
            },   
            {
                path: '/detalle-laboratorio/servicios-mtd/:laboratorioservicio/:laboratorio',
                name: 'detallelaboratoriomultident',
                component: DetallelaboratorioMultident,
                meta: { requiresAuth: true },
                props: true,
                beforeEnter:(to,from,next) => {
                    var payload = { _main: 'Servicios Mtd' ,main: 'Servicios', second: 'Laboratorios' , third : 'Configuracion' , ruta_second : 'laboratorios' , ruta_main : 'detallelaboratorio' }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                  
            },                     
            {
                path: '/materiales',
                name: 'materiales',
                component: Materiales,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Materiales', second: 'Configuracion', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                  
            },
            {
                path: '/detalle-material/:material',
                name: 'detallematerial',
                component: Detallematerial,
                meta: { requiresAuth: true },
                props: true,
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Servicios', second: 'Materiales' , third : 'Configuracion' , ruta_second : 'materiales' }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                  
            },               
            {
                path: '/sedes',
                name: 'sedes',
                component: Sedes,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Sedes', second: 'Configuracion', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                  
            }, 
            {
                path: '/empresaadministradoras',
                name: 'empresaadministradoras',
                component: Empresaadministradoras,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Empresas Administradoras', second: 'Configuracion', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                  
            },  
            {
                path: '/tarifarios',
                name: 'tarifarios',
                component: Tarifarios,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Planes', second: 'Configuracion' , third : null}
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }            
            }, 
            {
                path: '/detalle/:plan',
                name: 'detalle',
                component: Detalletarifarios,
                meta: { requiresAuth: true },
                props: true,
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Tarifarios', second: 'Planes' , third : 'Configuracion' , ruta_second : 'tarifarios' }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                  
            },
            {
                path: '/aseguradora',
                name: 'aseguradora',
                component: Aseguradora,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Aseguradora', second: 'Seguros', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            },
            {
                path: '/detalle-aseguradora/:plan',
                name: 'detalleaseguradora',
                component: Detalleaseguradora,
                meta: { requiresAuth: true },
                props: true,
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Tarifarios', second: 'Aseguradoras' , third : 'Seguros' , ruta_second : 'aseguradora' }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                  
            },             
            {
                path: '/empresas',
                name: 'empresas',
                component: Empresas,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Empresas', second: 'Seguros', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            },
            {
                path: '/detalle-empresa/:empresa',
                name: 'detalleempresa',
                component: Detalleempresa,
                meta: { requiresAuth: true },
                props: true,
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Aseguradoras', second: 'Empresas' , third : 'Seguros' , ruta_second :'empresas' }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                  
            },             
            {
                path: '/polizas',
                name: 'polizas',
                component: Polizas,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Polizas', second: 'Seguros', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            },  
            {
                path: '/convenios',
                name: 'convenios',
                component: Convenios,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Convenios', second: 'Marketing', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            },  
            {
                path: '/campanias',
                name: 'campañas',
                component: Campañas,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Campañas', second: 'Marketing', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            }, 
            {
                path: '/canjes',
                name: 'canjes',
                component: Canjes,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Canjes', second: 'Marketing', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            },                                                                                                  
            {
                path: '/pacientes',
                name: 'pacientes',
                component: Pacientes,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Pacientes', second: 'Entidades', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                  
            },  
            {
                path: '/detalle-paciente/:idpaciente',
                name: 'detallepacientes',
                component: DetallePacientes,
                meta: { requiresAuth: true },
                props: true,
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Detalle', second: 'Pacientes' , third : 'Entidades' , ruta_second :'pacientes' }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                },
                children:[
                    {
                        path: 'datos',
                        name: 'datos', 
                        component: DetPacDatos, 
                        meta: { requiresAuth: true },
                        props: true 
                    },
                    {
                        path: 'derivaciones',
                        name: 'derivaciones', 
                        component: DetPacDerivaciones, 
                        meta: { requiresAuth: true },
                        props: true                        
                    },
                    {
                        path: 'citaspacientes',
                        name: 'citas-pacientes', 
                        component: DetPacCitas, 
                        meta: { requiresAuth: true },
                        props: true                        
                    },
                    {
                        path: 'multimedia',
                        name: 'multimedia', 
                        component: DetPacMultimedia, 
                        meta: { requiresAuth: true },
                        props: true                        
                    },
                    {
                        path: 'lista-ppto-operatoria',
                        name: 'lista-ppto-operatoria', 
                        component: ListaPptoOperatoria,
                        meta: { requiresAuth: true }, 
                        props: true                        
                    },
                    {
                        path: 'lista-ppto-ortodoncia',
                        name: 'lista-ppto-ortodoncia', 
                        component: ListaPptoOrtodoncia,
                        meta: { requiresAuth: true }, 
                        props: true                        
                    },                                        
                    {
                        path: 'ppto-operatoria/:idpresupuesto?',
                        name: 'ppto-operatoria', 
                        component: PptoOperatoria, 
                        meta: { requiresAuth: true },
                        props: true                        
                    },
                    {
                        path: 'ppto-ortodoncia/:idpresupuesto?',
                        name: 'ppto-ortodoncia', 
                        component: PptoOrtodoncia, 
                        meta: { requiresAuth: true },
                        props: true                        
                    },
                    {
                        path: 'ver-ppto-operatoria/:idpresupuesto?',
                        name: 'ver-ppto-operatoria', 
                        component: VerPptoOperatoria, 
                        meta: { requiresAuth: true },
                        props: true                        
                    }, 
                    {
                        path: 'ver-ppto-ortodoncia/:idpresupuesto?',
                        name: 'ver-ppto-ortodoncia', 
                        component: VerPptoOrtodoncia, 
                        meta: { requiresAuth: true },
                        props: true                        
                    }, 
                    {
                        path: 'record-atencion/:idpresupuesto?',
                        name: 'record-atencion', 
                        component: RecordAtencion, 
                        meta: { requiresAuth: true },
                        props: true                        
                    },                                                                                                   
                ]                  
            },             
            {
                path: '/medicos',
                name: 'medicos',
                component: Medicos,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Medicos', second: 'Entidades', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            },
            {
                path: '/detalle-medico/:medico',
                name: 'detallemedicos',
                component: Detallemedicos,
                meta: { requiresAuth: true },
                props: true,
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Detalle', second: 'Médicos' , third : 'Entidades' , ruta_second :'medicos' }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                  
            },               
            {
                path: '/personal',
                name: 'personal',
                component: Personal,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Personal', second: 'Entidades', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            }, 
            {
                path: '/detalle-personal/:personal',
                name: 'detallepersonal',
                component: Detallepersonal,
                meta: { requiresAuth: true },
                props: true,
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Detalle', second: 'Personal' , third : 'Entidades' , ruta_second :'personal' }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                  
            }, 
            {
                path: '/citas',
                name: 'citas',
                component: Citas,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Citas', second: 'Agenda', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            },   
            {
                path: '/seguimientos',
                name: 'seguimiento-cita',
                component: Seguimientos,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Seguimientos', second: 'Agenda', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            }, 
/*             {
                path: '/agenda-modular',
                name: 'agenda-modular',
                component: Modular,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Modular', second: 'Agenda', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            },  */            
            {
                path: '/tipocambio',
                name: 'tipocambio',
                component: TipoCambios,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Tipo Cambio', second: 'Caja', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            },
            {
                path: '/cierrecaja',
                name: 'cierre-caja',
                component: CierreCaja,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Cierre Caja', second: 'Caja', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            },
            {
                path: '/ventadiaria',
                name: 'venta-diaria',
                component: VentaDiaria,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Venta Diaria', second: 'Caja', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            },  
            {
                path: '/liquidacionoperatoria',
                name: 'liquidacionoperatoria',
                component: LiquidacionOperatoria,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Liquidacion', second: 'Operatoria', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            }, 
            {
                path: '/liquidacionortodoncia',
                name: 'liquidacionortodoncia',
                component: LiquidacionOrtodoncia,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Liquidacion', second: 'Ortodoncia', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            }, 
            {
                path: '/liquidacionlaboratorio',
                name: 'liquidacionlaboratorio',
                component: LiquidacionLaboratorio,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Liquidacion', second: 'Laboratorio', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            }, 
            {
                path: '/liquidacionaseguradora',
                name: 'pacientesaseguradoras',
                component: LiquidacionAseguradora,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Liquidacion', second: 'Aseguradora', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            },   
            {
                path: '/pagosliquidacionoperatoria',
                name: 'cancelacionoperatoria',
                component: PagosLiquidacionOperatoria,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Liquidación Operatoria', second: 'Pagos', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            },  
            {
                path: '/pagosliquidacionortodoncia',
                name: 'cancelacionortodoncia',
                component: PagosLiquidacionOrtodoncia,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Liquidación Ortodoncia', second: 'Pagos', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            }, 
            {
                path: '/pagosliquidacionlaboratorio',
                name: 'cancelacionlaboratorio',
                component: PagosLiquidacionLaboratorio,
                meta: { requiresAuth: true },
                beforeEnter:(to,from,next) => {
                    var payload = { main: 'Liquidación Laboratorio', second: 'Pagos', third : null }
                    store.commit('SET_BREADCRUMB',{ datos: payload })
                    next();
                }                   
            }, 
            {
                path: '*',
                name: 'notfound',
                component: NotFound
            }                                                                                                                                                                                                                                                                               
        ]
    },
/*     {
        path: '*',
        name: 'notfound',
        component: NotFound
    } */

]
