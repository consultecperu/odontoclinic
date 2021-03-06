import VueRouter from 'vue-router'
import routes from './routes'
import store from './store'

const router = new VueRouter({
    mode: 'history',
    linkActiveClass: 'active',
    linkExactActiveClass: 'active',
    routes,
    scrollBehavior (to, from, savedPosition) {
        return { x: 0, y: 0 }
    }    
})

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.state.authenticated) {
            next({
                path: '/login',
                query: { redirect: to.fullPath }
            })
        } else {
            next()
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
        next({
            path: '/login'
        })
    }
})

export default router