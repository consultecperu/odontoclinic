export default {
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
}