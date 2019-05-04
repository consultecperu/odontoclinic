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
    getMedicosOrtodoncias: (state, getters) => {
        //return getters.getMedicos.especialidades.filter(med => med.id == 6)
        let ortodoncistas = [] 
        let medicos = this.getMedicos
        _.each(medicos, function(value,key){
            _.each(value.especialidades, function(value2,key2){
                if(value2.id == 6){
                    ortodoncistas.push(value)
                }
            })
        })
        return ortodoncistas         
        //return state.empleados.filter(emp => emp.tipo == 1 && emp.especialidades.pivot.especialidade_id == 6)
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
        return state.polizas.filter(pol => pol.empresapaciente_id == idemp).filter(pol => pol.plane_id == idpla)
    },
    getPacienteById: (state) => (id) => {
        return state.pacientes.find(pac => pac.id == id)
    },      
    getDependientesById: (state) => (id) => {
        return state.dependientes.filter(dep => dep.pacientetitular_id == id)
    },   
    getDerivacionesById: (state) => (id) => {
        return state.derivaciones.filter(der => der.paciente_id == id)
    },  
    getDerivacionesById: (state) => (id) => {
        return state.derivaciones.filter(der => der.paciente_id == id)
    },  
    getDientesByCuadrante: (state) => (cua) => {
        return state.dientes.filter(die => die.cuadrante == cua)
    },
    getpptoOperatoriaPaciente: (state) => (id) => {
        return state.presupuestos_operatorias.filter(ppt => ppt.paciente_id == id)
    },  
    getpptoOrtodonciaPaciente: (state) => (id) => {
        return state.presupuestos_ortodoncias.filter(ppt => ppt.paciente_id == id)
    },
    getTipoCambioHoy: state => {
        return state.tipocambios.find(tc => tc.fecha_registro == moment().format('DD-MM-YYYY'))
    },
    // Carga de tratamientos para agregar a la muela principal
    getTratamientosSimbolo: (state) => (idsim, idpla ,idsed,idplased,multicaras) => {
        let servicios = []
        if(idsim == 1){
            if(multicaras == 1){  
                state.tarifarios.map(function(value, key) { 
                    if(value.servicio.simbologia_id == idsim && (value.plan_id == idplased || value.plan_id == idpla) && value.sede_id == idsed && !value.servicio.nombre_servicio.includes('COMPUESTA') && !value.servicio.nombre_servicio.includes('COMPLEJA')){
                        servicios.push(value)
                    }                    
                })
                return servicios           
            }
            if(multicaras == 2){
                state.tarifarios.map(function(value, key) { 
                    if(value.servicio.simbologia_id == idsim && (value.plan_id == idplased || value.plan_id == idpla) && value.sede_id == idsed && !value.servicio.nombre_servicio.includes('SIMPLE') && !value.servicio.nombre_servicio.includes('COMPLEJA')){
                        servicios.push(value)
                    }                    
                })
                return servicios   
            }
            if(multicaras >= 3 ){
                state.tarifarios.map(function(value, key) { 
                    if(value.servicio.simbologia_id == idsim && (value.plan_id == idplased || value.plan_id == idpla) && value.sede_id == idsed && !value.servicio.nombre_servicio.includes('COMPUESTA') && !value.servicio.nombre_servicio.includes('SIMPLE')){
                        servicios.push(value)
                    }                    
                })
                return servicios   
            }
        }else{
            let serpla = state.tarifarios.filter(tar => tar.servicio.simbologia_id == idsim && tar.plan_id == idpla && tar.sede_id == idsed) 
            let sersed = state.tarifarios.filter(tar => tar.servicio.simbologia_id == idsim && tar.plan_id == idplased && tar.sede_id == idsed) 
            return servicios = _.union(serpla,sersed)
        }

    },
    getTratamientosSimboloNew: (state) => (idsim, idplapac ,idsed ,idplased) => {
        let serpla = state.tarifarios.filter(tar => tar.servicio.simbologia_id == idsim && tar.plan_id == idplapac && tar.sede_id == idsed)
        let sersed = state.tarifarios.filter(tar => tar.servicio.simbologia_id == idsim && tar.plan_id == idplased && tar.sede_id == idsed)
        //return state.tarifarios.filter(tar => tar.servicio.simbologia_id == idsim && tar.plan_id == idpla && tar.sede_id == idsed) 
        let servicios = []        
        _.each(serpla, function(value,key){
            _.each(sersed, function(value2,key2){
                if(value2.servicio_id == value.servicio_id){
                    sersed.splice(key2,1)
                }
            })
        }) 
        return servicios = _.union(serpla,sersed)       
    },    
    getTratamientosOrtodoncia: (state) => (idpla ,idsed) => {    
        return state.tarifarios.filter(tar => tar.ortodoncia == 1 && tar.plan_id == idpla && tar.sede_id == idsed) 
    },    
    getPresupuestoOperatoriaById: (state) => (id) => {
        return state.presupuestos_operatorias.find(pid => pid.id == id)
    }, 
    getPresupuestoOrtodonciaById: (state) => (id) => {
        return state.presupuestos_ortodoncias.find(pid => pid.id == id)
    },
    getTipopagosForma: (state) => (param) => {
        return state.tipopagos.filter(tp => tp.tipo == param)
    },
    getPagosPresupuestoOperatoriaById: (state) => (id) => {
        return state.pagos.filter(pag => pag.presupuestooperatoria_id == id)
    }, 
    getPagosPresupuestoOrtodonciaById: (state) => (id) => {
        return state.pagos.filter(pag => pag.presupuestoortodoncia_id == id)
    }, 
    getConceptosAbonos: (state) => {
        return state.conceptos.filter(con => con.type == 1)
    }, 
    getConceptosDescuentos: (state) => {
        return state.conceptos.filter(con => con.type == 2)
    },   
    getSeguimientoPlanesbyPaciente: (state) => (id) => {
        return state.seguimientoplanes.filter(seg => seg.paciente_id == id)
    },  
    getcitasPacienteById: (state) => (id) => {
        return state.citas.filter(cit => cit.paciente_id == id )
    }                                                                                                                      
}