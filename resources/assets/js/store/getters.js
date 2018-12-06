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
}