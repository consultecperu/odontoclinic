import VueRouter from 'vue-router'
import routes from './routes'
import store from './store'

const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    linkExactActiveClass: 'active',
    routes
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.state.authenticated) {
            next({
                path: '/login',
                query: { redirect: to.fullPath }
            })
        } else {
            if (to.path == "/") {
                next({
                    path: '/dashboard'
                })
            } else {
                next()
            }
        }
    } else if (to.matched.some(record => record.meta.redirectIfLogged)) {
        if (store.state.authenticated) {
            next({
                path: '/dashboard'
            })
        } else {
            next()
        }
    } else {
        if (to.path == "/" && store.state.authenticated) {
            next({
                path: '/dashboard'
            })
        } else if (to.path == "/" && !store.state.authenticated) {
            next({
                path: '/login'
            })
        } else {
            next()
        }
    }
})

export default router