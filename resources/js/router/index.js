import { createWebHistory, createRouter } from 'vue-router'
import store from '@/store'

import AppLayout from '@/layouts/AppLayout.vue'
import AuthLayout from '@/layouts/AuthLayout.vue'

const Login = () => import('@/views/auth/Login.vue')
const ForgotPassword = () => import('@/views/auth/ForgotPassword.vue')
const WaitingForgotPassword = () => import('@/views/auth/WaitingForgotPassword.vue')
const SuccessForgotPassword = () => import('@/views/auth/SuccessForgotPassword.vue')
const ResetPassword = () => import('@/views/auth/ResetPassword.vue')

const Dashboard = () => import('@/views/Dashboard.vue')

const constantRoutes = [
    {
        path: '/auth',
        redirect: '/auth/login',
        component: AuthLayout,
        meta: {
            middleware: 'guest'
        },
        children: [
            {
                name: 'login',
                path: 'login',
                component: Login,
                meta: {
                    title: 'Login'
                }
            },
            {
                name: 'forgot-password',
                path: 'forgot-password',
                component: ForgotPassword,
                meta: {
                    title: 'Forgot Password'
                }
            },
            {
                name: 'waiting-forgot-password',
                path: 'forgot-password/waiting',
                component: WaitingForgotPassword,
                meta: {
                    title: 'Forgot Password'
                }
            },
            {
                name: 'reset-password',
                path: 'reset-password',
                component: ResetPassword,
                meta: {
                    title: 'Reset Password'
                }
            },
            {
                name: 'success-forgot-password',
                path: 'forgot-password/success',
                component: SuccessForgotPassword,
                meta: {
                    title: 'Forgot Password'
                }
            },
        ]
    },
    {
        path: '',
        component: AppLayout,
        redirect: 'dashboard',
        meta: {
            middleware: 'auth'
        },
        children: [
            {
                name: 'dashboard',
                path: 'dashboard',
                component: Dashboard,
                meta: {
                    title: 'Dashboard'
                }
            }
        ]
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes: constantRoutes,
})

router.beforeEach((to, from, next) => {
    document.title = `Kishack ${to.meta.title}`
    if (to.meta.middleware == "guest") {
        if (store.state.auth.authenticated) {
            next({ name: "dashboard" })
        }
        next()
    } else {
        if (store.state.auth.authenticated) {
            next()
        } else {
            next({ name: "login" })
        }
    }
})

export function resetRouter() {
    const newRouter = createRouter();
    router.matcher = newRouter.matcher; // reset router
}

export default router
