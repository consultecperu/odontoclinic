export default {
    getMenus: state => {
        return state.menus.filter(menu => menu.idparent == 0)
    }, 
    getubigeos: state => {
        return state.ubigeos
    },  
    getservicios_operatoria: state => {
        if(state.servicios.length > 0){
            return state.servicios.filter(servicio => servicio.tipo == 1)
        }
        return []
    }, 
    getservicios_ortodoncia: state => {
        if(state.servicios.length > 0){
            return state.servicios.filter(servicio => servicio.tipo == 2)
        }
        return []
    }, 
    getservicios_ortodoncia_main: state => {
        if(state.servicios.length > 0){
            return state.servicios.filter(servicio => servicio.tipo == 2).filter(servicio => servicio.parentid_ortodoncia === null)
        }
        return []
    },    
    getgruposervicios_operatoria: state => {
        if(state.gruposervicios.length > 0){
            return state.gruposervicios.filter(grupo => grupo.tipo == 1)
        }
        return []
    }, 
    getgruposervicios_ortodoncia: state => {
        if(state.gruposervicios.length > 0){
            return state.gruposervicios.filter(grupo => grupo.tipo == 2)
        }
        return []
    },    
    getplanes_multident: state => {
        if(state.planes.length > 0){
            return state.planes.filter(plan => plan.tipo === 1)
        }
        return []
    },  
    getplanes_aseguradoras: state => {
        if(state.planes.length > 0){
            return state.planes.filter(plan => plan.tipo === 2)
        }
        return []
    },  
    getModulo: (state) => (id) => {
        if(state.menus.length > 0){
            return state.menus.filter(mod => mod.id === id)
        }
        return []
    },  
    getMedicos: state => {
        return state.empleados.filter(emp => emp.tipo == 1)
    },        
    getPersonal: state => {
        return state.empleados.filter(emp => emp.tipo == 2)
    }, 
    getDocumentosIdentidad: state => {
        return state.tipodocumentos.filter(doc => doc.tipo == 1)
    },        
    getDocumentosContables: state => {
        return state.tipodocumentos.filter(doc => doc.tipo == 2)
    }, 
    getEmpleadoById: (state) => (id) => {
        return state.empleados.find(emp => emp.id == id)
    },  
    getHorasAM: state => {
        return state.horas.filter(hor => hor.turno == 1)
    },  
    getHorasPM: state => {
        return state.horas.filter(hor => hor.turno == 2)
    }, 
    getTurnosEmpleadoById: (state) => (id) => {
        return state.turnos.filter(tur => tur.empleado_id == id)
    },   
    getTurnosEspEmpleadoById: (state) => (id) => {
        return state.turnosespeciales.filter(tur => tur.empleado_id == id)
    },  
    getPerfilMedico: state => {
        return state.perfiles.find(per => per.nombre_perfil == 'MEDICO')
    }, 
    getPermisosByDoc: (state) => (id) => {
        return state.permisos.filter(per => per.empleado_id == id)
    },  
    getPolizas: (state) => (idemp , idpla) => {
        console.log("datos",idemp,idpla)
        return state.polizas.filter(pol => pol.empresapaciente_id == idemp).filter(pol => pol.plane_id == idpla)
    },                                                                   
}