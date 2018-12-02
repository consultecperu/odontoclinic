import store from './store'

import Login from './components/login/login.vue'
import TemplateMain from './components/template/templatemain.vue'

import Dashboard from './components/dashboard/dashboard.vue'
import Perfiles from './components/seguridad/perfiles.vue'
import Modulos from './components/seguridad/modulos.vue'
import Usuarios from './components/seguridad/usuarios.vue'

import Cargos from './components/configuracion/cargos.vue'
import Gruposervicios from './components/configuracion/gruposervicios.vue'
import Laboratorios from './components/configuracion/laboratorios.vue'
import Materiales from './components/configuracion/materiales.vue'
import Sedes from './components/configuracion/sedes.vue'
import Empresaadministradoras from './components/configuracion/empresaadministradoras.vue'
import Servicios from './components/configuracion/servicios.vue'
import Tarifarios from './components/configuracion/tarifarios.vue'
import Detalletarifarios from './components/configuracion/detalletarifarios.vue'

import Pacientes from './components/entidades/pacientes.vue'
import Medicos from './components/entidades/medicos.vue'
import Personal from './components/entidades/personal.vue'

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
                path: '/usuarios',
                name: 'usuarios',
                component: Usuarios,
                meta: { requiresAuth: true }
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
                    var payload = { main: 'Tarifarios', second: 'Planes' , third : 'Configuracion' }
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
        ]
    },
    {
        path: '*',
        name: 'notfound',
        component: NotFound
    }

]
