export default {
    LOGOUT(state) {
        state.authenticated = false
        localStorage.removeItem('autentificado')
        localStorage.removeItem('user')
    },
    SAVE_TOKEN(state, { datos }) {
        state.authenticated = true
        state.user_system = datos.user.user[0]  // aca estan los datos del usuario loggeado          
        localStorage.setItem('autentificado', true)
        localStorage.setItem('user', JSON.stringify(datos.user.user[0]))
    },
    SET_BREADCRUMB(state, { datos }) {
        state.breadmain = datos.main
        state.breadsecond = datos.second  
        state.breadthird = datos.third
    },    
    SET_PERFIL_USER: (state, { list }) => {      // PERFIL DE USUARIO
        state.perfil_user = list
    },       
    SET_PERFILES_LIST: (state, { list }) => {      // PERFILES
        state.perfiles = list
    },  
    SET_MODULES_LIST: (state, { list }) => {      // MODULOS
        state.modules = list
    }, 
    SET_MENUS_LIST: (state, { list }) => {      // MENUS
        state.menus = list
    },
    SET_CARGOS_LIST: (state, { list }) => {      // CARGOS
        state.cargos = list
    },  
    SET_GRUPOSERVICIOS_LIST: (state, { list }) => {      // GRUPOSERVICIOS
        state.gruposervicios = list
    }, 
    SET_LABORATORIOS_LIST: (state, { list }) => {      // LABORATORIOS
        state.laboratorios = list
    }, 
    SET_MATERIALES_LIST: (state, { list }) => {      // MATERIALES
        state.materiales = list
    },  
    SET_MONEDAS_LIST: (state, { list }) => {      // MONEDAS
        state.monedas = list
    }, 
    SET_SEDES_LIST: (state, { list }) => {      // SEDES
        state.sedes = list
    },  
    SET_EMPRESAS_LIST: (state, { list }) => {      // EMPRESAS
        state.empresas = list
    },    
    SET_UBIGEOS_LIST: (state, { list }) => {      // UBIGEOS
        state.ubigeos = list
    },  
    SET_SERVICIOS_LIST: (state, { list }) => {      // SERVICIOS
        state.servicios = list
    },   
    SET_SIMBOLOGIAS_LIST: (state, { list }) => {      // SIMBOLOGIAS
        state.simbologias = list
    },   
    SET_PLANES_LIST: (state, { list }) => {      // PLANES
        state.planes = list
    },  
    SET_TARIFARIOS_LIST: (state, { list }) => {      // TARIFARIOS
        state.tarifarios = list
    },                                                          
}