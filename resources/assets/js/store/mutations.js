export default {
    LOGOUT(state) {
        state.authenticated = false
        localStorage.removeItem('autentificado')
        localStorage.removeItem('user')
    },
    SAVE_TOKEN(state, { datos }) {
        state.authenticated = true
        state.user_system = datos.user.user[0]  // aca estan los datos del usuario loggeado  
        //state.sede_system = null        
        localStorage.setItem('autentificado', true)
        localStorage.setItem('user', JSON.stringify(datos.user.user[0]))
    },
    CAMBIO_SEDE(state, { datos}){
        state.sede_system = state.sedes.find(sed => sed.id == datos)
    },
    SET_BREADCRUMB(state, { datos }) {
        state.breadmain = datos.main
        state.breadsecond = datos.second  
        state.breadthird = datos.third
        state.ruta_second = datos.ruta_second != 'undefined' ? datos.ruta_second : null
        state.ruta_main = datos.ruta_main != 'undefined' ? datos.ruta_main : null
        state._breadmain = datos._main !== 'undefined' ? datos._main : null
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
    SET_EMPRESAPACIENTES_LIST: (state, { list }) => {      // EMPRESAPACIENTES
        state.empresapacientes = list
    }, 
    SET_EMPRESAPACIENTES_PLANES_LIST: (state, { list }) => {      // EMPRESAPACIENTES_PLANES
        state.empresapacientesplanes = list
    }, 
    SET_EMPRESAPACIENTES_PLANES_EMPRESAS_LIST: (state, { list }) => {      // EMPRESAPACIENTES_PLANES
        state.empresapacientesplanes = list
    },     
    SET_POLIZAS_LIST: (state, { list }) => {      // POLIZAS
        state.polizas = list
    },
    SET_PLANPOLIZAS_LIST: (state, { list }) => {      // PLANPOLIZAS
        state.planpolizas = list
    },  
    SET_CONVENIOS_LIST: (state, { list }) => {      // CONVENIOS
        state.convenios = list
    },   
    SET_CAMPAÑAS_LIST: (state, { list }) => {      // CAMPAÑAS
        state.campañas = list
    },  
    SET_CANJES_LIST: (state, { list }) => {      // CANJES
        state.canjes = list
    },     
    SET_USUARIOS_LIST: (state, { list }) => {      // USUARIOS
        state.usuarios = list
    },   
    SET_ACCESOSUSUARIO_LIST: (state, { list }) => {      // ACCESOSUSUARIO
        state.accesosusuario = list
    }, 
    SET_DATA_INIT_LIST: (state, { list }) => {      // CARGA INICIAL DEL MODULO EMPLEADOS
        state.estadosciviles = list.estadosciviles
        state.ubigeos = list.ubigeos   
        state.tipodocumentos = list.tipodocumentos
        state.tipocontratos = list.tipocontratos
        state.tipopagodoctores = list.tipopagodoctores
        state.cargos = list.cargos
        state.perfiles = list.perfiles
        state.horas = list.horas
        state.dias = list.dias
        state.especialidades = list.especialidades
        state.estadocitas = list.estadocitas
    },
    SET_EMPLEADOS_LIST: (state, { list }) => {      // EMPLEADOS
        state.empleados = list
    },
    SET_LABORATORIOSERVICIOS_LIST: (state, { list }) => {      // LABORATORIOSSERVICIOS
        state.laboratorioservicios = list
    },   
    SET_MATERIALSERVICIOS_LIST: (state, { list }) => {      // MATERIALSERVICIOS
        state.materialservicios = list
    },
    SET_TURNOS_LIST: (state, { list }) => {      // TURNOS
        state.turnos = list
    }, 
    SET_TURNOS_ESPECIALES_LIST: (state, { list }) => {      // TURNOS_ESPECIALES
        state.turnosespeciales = list
    }, 
    SET_PERMISOS_LIST: (state, { list }) => {      // PERMISOS
        state.permisos = list
    }, 
    SET_DATA_INIT_PACIENTES_LIST: (state, { list }) => {      // CARGA INICIAL DEL MODULO PACIENTES
        state.estadosciviles = list.estadosciviles
        state.ubigeos = list.ubigeos   
        state.tipodocumentos = list.tipodocumentos
        state.motivocaptaciones = list.motivocaptaciones
        state.parentescos = list.parentescos
        state.asignaciones = list.asignaciones
    }, 
    SET_PACIENTES_LIST: (state, { list }) => {      // PACIENTES
        state.pacientes = list
    },     
    SET_DEPENDIENTES_LIST: (state, { list }) => {      // DEPENDIENTES
        state.dependientes = list
    },  
    SET_DERIVACIONES_LIST: (state, { list }) => {      // DERIVACIONES
        state.derivaciones = list
    }, 
    SET_DIENTES_LIST: (state, { list }) => {      // DIENTES
        state.dientes = list
    },
    SET_PRESUPUESTOS_OPERATORIAS_LIST: (state, { list }) => {      // PRESUPUESTOS_OPERATORIA
        state.presupuestos_operatorias = list
    },  
    SET_PRESUPUESTOS_ORTODONCIAS_LIST: (state, { list }) => {      // PRESUPUESTOS_ORTODONCIA
        state.presupuestos_ortodoncias = list
    }, 
    SET_TIPOCAMBIOS_LIST: (state, { list }) => {      // TIPOCAMBIOS
        state.tipocambios = list
    },   
    SET_TIPOPAGOS_LIST: (state, { list }) => {      // TIPOPAGOS
        state.tipopagos = list
    },  
    SET_PAGOS_LIST: (state, { list }) => {      // PAGOS
        state.pagos = list
    },  
    SET_CITAS_LIST: (state, { list }) => {      // CITAS
        state.citas = list
    },   
    SET_CITAS_FECHAS_LIST: (state, { list }) => {      // CITAS x FECHAS
        state.citasfechas = list
    },                                                                                                                                                              
}