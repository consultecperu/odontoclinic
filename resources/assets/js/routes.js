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
import Materiales from './components/configuracion/materiales.vue'
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
import Medicos from './components/entidades/medicos.vue'
import Personal from './components/entidades/personal.vue'
import Detallepersonal from './components/entidades/detallepersonal.vue'

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
        ]
    },
    {
        path: '*',
        name: 'notfound',
        component: NotFound
    }

]
