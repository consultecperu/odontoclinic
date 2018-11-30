import axios from 'axios'
import store from './store'
import router from './router'

/**
 * Request
 */
/* axios.interceptors.request.use(
  (config) => {
    var token = localStorage.getItem('token')

    if (token) {
      config.headers['Authorization'] = 'Bearer ' + token
    }

    config.headers['X-Requested-With'] = 'XMLHttpRequest'
    // TODO: check if have any lang saved in localStorage, if not browser lang or default
    config.headers['Accept-Language'] = 'en'

    return config
  },
  (error) => {
    return Promise.reject(error)
  }
) */

/**
 * Response
 */
axios.interceptors.response.use(
    (response) => {
        return response
    },
    (error) => {
        const originalRequest = error.config
        // token expired
        if (error.response.status === 401 && error.response.data.message == "Unauthenticated.") {
            originalRequest._retry = true
            store.dispatch('CLOSE_SESSION')
            router.push({ name: 'login' })
            return
        }

        return Promise.reject(error)
    }
)
