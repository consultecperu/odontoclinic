export default {
    ISLOGGED: function ({ commit }){
        var url = '/api/sessionActiva';
        return axios.get(url).then((response) => {
            commit('ISLOGGED', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOGOUT({ commit }) {
        return new Promise((resolve, reject) => {
            axios.post('/api/logout')
                .then(function (response) {
                    commit('LOGOUT')
                    resolve()
                })
                .catch(function (error) {
                    reject(error)
                });
        }, error => console.log(error))
    },
    SAVE_TOKEN({ commit }, payload) {
        commit('SAVE_TOKEN', { datos: payload })
    },
    CAMBIO_SEDE({ commit }, payload){
        commit('CAMBIO_SEDE', {datos: payload})
    },
    UPDATE_BREADCRUMB({ commit }, payload) {
        commit('SET_BREADCRUMB', { datos: payload })
    },    
    CLOSE_SESSION({ commit }) {
        commit('LOGOUT')
    },    
    LOAD_PERFIL_USER: function ({ commit, state }) {
        if (state.user_system != null) {
            var url = "/api/perfiles/" + state.user_system.perfil_id
            return axios.get(url).then((response) => {
                commit('SET_PERFIL_USER', { list: response.data })
            }, (err) => {
                console.log(err)
            });
        }
        commit('SET_PERFIL_USER', { list: null })
    },     
    LOAD_PERFILES_LIST: function ({ commit }) {
        var url = '/api/perfiles';
        return axios.get(url).then((response) => {
            commit('SET_PERFILES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_MODULES_LIST: function ({ commit }) {
        var url = '/api/modulos';
        return axios.get(url).then((response) => {
            commit('SET_MODULES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },  
    LOAD_MENUS_LIST: function ({ commit }) {
        var url = '/api/modulos/create';
        return axios.get(url).then((response) => {
            commit('SET_MENUS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_CARGOS_LIST: function ({ commit }) {
        var url = '/api/cargos';
        return axios.get(url).then((response) => {
            commit('SET_CARGOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_GRUPOSERVICIOS_LIST: function ({ commit }) {
        var url = '/api/gruposervicios';
        return axios.get(url).then((response) => {
            commit('SET_GRUPOSERVICIOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },                 
    LOAD_LABORATORIOS_LIST: function ({ commit }) {
        var url = '/api/laboratorios';
        return axios.get(url).then((response) => {
            commit('SET_LABORATORIOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },    
    LOAD_MATERIALES_LIST: function ({ commit }) {
        var url = '/api/materiales';
        return axios.get(url).then((response) => {
            commit('SET_MATERIALES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_MONEDAS_LIST: function ({ commit }) {
        var url = '/api/monedas';
        return axios.get(url).then((response) => {
            commit('SET_MONEDAS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },  
    LOAD_SEDES_LIST: function ({ commit }) {
        var url = '/api/sedes';
        return axios.get(url).then((response) => {
            commit('SET_SEDES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },   
    LOAD_UBIGEOS_LIST: function ({ commit }) {
        var url = '/api/ubigeos';
        return axios.get(url).then((response) => {
            commit('SET_UBIGEOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_EMPRESAS_LIST: function ({ commit }) {
        var url = '/api/empresas';
        return axios.get(url).then((response) => {
            commit('SET_EMPRESAS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },   
    LOAD_SERVICIOS_LIST: function ({ commit }) {
        var url = '/api/servicios';
        return axios.get(url).then((response) => {
            commit('SET_SERVICIOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },      
    LOAD_SIMBOLOGIAS_LIST: function ({ commit }) {
        var url = '/api/simbologias';
        return axios.get(url).then((response) => {
            commit('SET_SIMBOLOGIAS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_PLANES_LIST: function ({ commit }) {
        var url = '/api/planes';
        return axios.get(url).then((response) => {
            commit('SET_PLANES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },   
    LOAD_TARIFARIOS_LIST: function ({ commit }) {
        var url = '/api/tarifarios';
        return axios.get(url).then((response) => {
            commit('SET_TARIFARIOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_EMPRESAPACIENTES_LIST: function ({ commit }) {
        var url = '/api/empresapacientes';
        return axios.get(url).then((response) => {
            commit('SET_EMPRESAPACIENTES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_EMPRESAPACIENTES_PLANES_LIST: function ({ commit } , payload) {  // aseguradoras ligadas a las empresas
        var url = '/api/empresapacientes/aseguradoras/' + payload.id
        return axios.get(url).then((response) => {
            commit('SET_EMPRESAPACIENTES_PLANES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_EMPRESAPACIENTES_PLANES_EMPRESAS_LIST: function ({ commit } , payload) {  // empresas ligadas a las aseguradoras
        var url = '/api/empresapacientes/empresas/' + payload.id
        return axios.get(url).then((response) => {
            commit('SET_EMPRESAPACIENTES_PLANES_EMPRESAS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },    
    LOAD_POLIZAS_LIST: function ({ commit }) {
        var url = '/api/polizas';
        return axios.get(url).then((response) => {
            commit('SET_POLIZAS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_PLANPOLIZAS_LIST: function ({ commit }) {
        var url = '/api/planpolizas';
        return axios.get(url).then((response) => {
            commit('SET_PLANPOLIZAS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_CONVENIOS_LIST: function ({ commit }) {
        var url = '/api/convenios';
        return axios.get(url).then((response) => {
            commit('SET_CONVENIOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_CAMPAÑAS_LIST: function ({ commit }) {
        var url = '/api/campanias';
        return axios.get(url).then((response) => {
            commit('SET_CAMPAÑAS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },  
    LOAD_CANJES_LIST: function ({ commit }) {
        var url = '/api/canjes';
        return axios.get(url).then((response) => {
            commit('SET_CANJES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },      
    LOAD_USUARIOS_LIST: function ({ commit }) {
        var url = '/api/users';
        return axios.get(url).then((response) => {
            commit('SET_USUARIOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_ACCESOSUSUARIO_LIST: function ({ commit }, payload) {
        var url = '/api/accesos/usuario/'+ payload.id
        return axios.get(url).then((response) => {
            commit('SET_ACCESOSUSUARIO_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_DATA_INIT_LIST: function ({ commit }) {
        var urlType = '/api/empleados/create';
        return axios.get(urlType).then((response) => {
            commit('SET_DATA_INIT_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_EMPLEADOS_LIST: function ({ commit }) {
        var url = '/api/empleados';
        return axios.get(url).then((response) => {
            commit('SET_EMPLEADOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_LABORATORIOSERVICIOS_LIST: function ({ commit }) {
        var url = '/api/laboratorioservicios';
        return axios.get(url).then((response) => {
            commit('SET_LABORATORIOSERVICIOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },  
    LOAD_MATERIALSERVICIOS_LIST: function ({ commit }) {
        var url = '/api/materialservicios';
        return axios.get(url).then((response) => {
            commit('SET_MATERIALSERVICIOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_TURNOS_LIST: function ({ commit }) {
        var url = '/api/turnos';
        return axios.get(url).then((response) => {
            commit('SET_TURNOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_TURNOS_ESPECIALES_LIST: function ({ commit }) {
        var url = '/api/turnos-especiales';
        return axios.get(url).then((response) => {
            commit('SET_TURNOS_ESPECIALES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_PERMISOS_LIST: function ({ commit }) {
        var url = '/api/permisos';
        return axios.get(url).then((response) => {
            commit('SET_PERMISOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_DATA_INIT_PACIENTES_LIST: function ({ commit }) {
        var urlType = '/api/pacientes/create';
        return axios.get(urlType).then((response) => {
            commit('SET_DATA_INIT_PACIENTES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_PACIENTES_LIST: function ({ commit }) {
        var url = '/api/pacientes';
        return axios.get(url).then((response) => {
            commit('SET_PACIENTES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },  
    LOAD_DEPENDIENTES_LIST: function ({ commit }) {
        var url = '/api/dependientes';
        return axios.get(url).then((response) => {
            commit('SET_DEPENDIENTES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_DERIVACIONES_LIST: function ({ commit }) {
        var url = '/api/derivaciones';
        return axios.get(url).then((response) => {
            commit('SET_DERIVACIONES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },        
    LOAD_DIENTES_LIST: function ({ commit }) {
        var url = '/api/dientes';
        return axios.get(url).then((response) => {
            commit('SET_DIENTES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_PRESUPUESTOS_OPERATORIAS_LIST: function ({ commit }) {
        var url = '/api/presupuestos-operatorias';
        return axios.get(url).then((response) => {
            commit('SET_PRESUPUESTOS_OPERATORIAS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_PRESUPUESTOS_OPERATORIAS_DETALLES_LIST: function ({ commit }) {
        var url = '/api/presupuestos-operatorias/detalles';
        return axios.get(url).then((response) => {
            commit('SET_PRESUPUESTOS_OPERATORIAS_DETALLES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },    
    LOAD_PRESUPUESTOS_ORTODONCIAS_LIST: function ({ commit }) {
        var url = '/api/presupuestos-ortodoncias';
        return axios.get(url).then((response) => {
            commit('SET_PRESUPUESTOS_ORTODONCIAS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_PRESUPUESTOS_ORTODONCIAS_DETALLES_LIST: function ({ commit }) {
        var url = '/api/presupuestos-ortodoncias/detalles';
        return axios.get(url).then((response) => {
            commit('SET_PRESUPUESTOS_ORTODONCIAS_DETALLES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },      
    LOAD_TIPOCAMBIOS_LIST: function ({ commit }) {
        var url = '/api/tipocambios';
        return axios.get(url).then((response) => {
            commit('SET_TIPOCAMBIOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },  
    LOAD_TIPOPAGOS_LIST: function ({ commit }) {
        var url = '/api/tipopagos';
        return axios.get(url).then((response) => {
            commit('SET_TIPOPAGOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_PAGOS_LIST: function ({ commit }) {
        var url = '/api/pagos';
        return axios.get(url).then((response) => {
            commit('SET_PAGOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_CITAS_LIST: function ({ commit }) {
        var url = '/api/citas';
        return axios.get(url).then((response) => {
            commit('SET_CITAS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_CITAS_FECHAS_LIST: function ({ commit }, payload) {
        var url = '/api/citas/fechas/'+ payload.fecini + '/'+ payload.fecfin;
        return axios.get(url).then((response) => {
            commit('SET_CITAS_FECHAS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_CITAS_CONSULTORIOS_LIST: function({ commit },payload){
        var url = '/api/citas/consultorios/fechas/'+ payload.fecha;
        return axios.get(url).then((response) => {
            commit('SET_CITAS_CONSULTORIOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_CONFIRMACION_CITAS_LIST: function ({ commit }, payload) {
        var url = '/api/citas/confirmacion/'+ payload.empleado_id + '/' + payload.sede_id + '/' + payload.fecini + '/'+ payload.fecfin;
        return axios.get(url).then((response) => {
            commit('SET_CONFIRMACION_CITAS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },  
    LOAD_SEGUIMIENTO_CITAS_LIST: function ({ commit }, payload) {
        var url = '/api/citas/seguimiento/' + payload.sede_id + '/' + payload.fecini + '/'+ payload.fecfin;
        return axios.get(url).then((response) => {
            commit('SET_SEGUIMIENTO_CITAS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },       
    LOAD_LABORATORIO_TRABAJOS_LIST: function ({ commit }) {
        var url = '/api/laboratoriotrabajos/';
        return axios.get(url).then((response) => {
            commit('SET_LABORATORIO_TRABAJOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },   
    LOAD_LIQUIDACION_LABORATORIOS_LIST: function ({ commit }) {
        var url = '/api/liquidacionlaboratorios/';
        return axios.get(url).then((response) => {
            commit('SET_LIQUIDACION_LABORATORIOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_CONCEPTOS_LIST: function ({ commit }) {
        var url = '/api/conceptos';
        return axios.get(url).then((response) => {
            commit('SET_CONCEPTOS_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_TRANSACCIONES_DOCTOR_LIST: function ({ commit }) {
        var url = '/api/transaccionesdoctor';
        return axios.get(url).then((response) => {
            commit('SET_TRANSACCIONES_DOCTOR_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_PRELIQUIDACIONES_DOCTORES_LIST: function ({ commit } , payload) {  // aseguradoras ligadas a las empresas
        var url = '/api/presupuestosoperatoriasdetalles/liquidacion-doctor/' + payload.empleado_id+'/'+payload.sede_id+'/'+payload.fecha_corte
        return axios.get(url).then((response) => {
            commit('SET_PRELIQUIDACIONES_DOCTORES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    }, 
    LOAD_PRELIQUIDACIONES_ORTODONCIAS_DOCTORES_LIST: function ({ commit } , payload) {  // aseguradoras ligadas a las empresas
        var url = '/api/presupuestosortodonciasdetalles/liquidacion-doctor/' + payload.empleado_id+'/'+payload.sede_id+'/'+payload.fecha_corte
        return axios.get(url).then((response) => {
            commit('SET_PRELIQUIDACIONES_ORTODONCIAS_DOCTORES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_LIQUIDACIONES_SEDES_LIST: function ({ commit } , payload) {  // 
        var url = '/api/liquidacionesoperatorias/sedes/' + payload.sede_id+'/'+payload.fecha_desde+'/'+payload.fecha_hasta
        return axios.get(url).then((response) => {
            commit('SET_LIQUIDACIONES_SEDES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_LIQUIDACIONES_SEDES_ORTODONCIA_LIST: function ({ commit } , payload) {  // 
        var url = '/api/liquidacionesortodoncias/sedes/' + payload.sede_id+'/'+payload.fecha_desde+'/'+payload.fecha_hasta
        return axios.get(url).then((response) => {
            commit('SET_LIQUIDACIONES_SEDES_ORTODONCIA_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },
    LOAD_SEGUIMIENTO_PLANES_LIST: function ({ commit }) {
        var url = '/api/seguimientoplanes'
        return axios.get(url).then((response) => {
            commit('SET_SEGUIMIENTO_PLANES_LIST', { list: response.data })
        }, (err) => {
            console.log(err)
        });
    },                                                                                                                                                                      
}