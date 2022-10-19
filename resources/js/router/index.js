import { createWebHistory, createRouter } from 'vue-router'

const AuthLayout = () => import('@/layouts/AuthLayout.vue')

const Login = () => import('@/views/auth/Login.vue')
const ForgotPassword = () => import('@/views/auth/ForgotPassword.vue')
const WaitingForgotPassword = () => import('@/views/auth/WaitingForgotPassword.vue')
const SuccessForgotPassword = () => import('@/views/auth/SuccessForgotPassword.vue')
const ResetPassword = () => import('@/views/auth/ResetPassword.vue')

const Dashboard = () => import('@/views/Dashboard.vue')

const routes = [
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
                component: Login
            },
            {
                name: 'forgot-password',
                path: 'forgot-password',
                component: ForgotPassword
            },
            {
                name: 'waiting-forgot-password',
                path: 'forgot-password/waiting',
                component: WaitingForgotPassword
            },
            {
                name: 'reset-password',
                path: 'reset-password',
                component: ResetPassword
            },
            {
                name: 'success-forgot-password',
                path: 'forgot-password/success',
                component: SuccessForgotPassword
            },
        ]
    },
    {
        name: 'dashboard',
        path: '/',
        component: Dashboard
    }
]

const router = createRouter({
    history: createWebHistory(),
    routes,
})

// router.beforeEach((to, from, next) => {
//     document.title = to.meta.title
//     if (to.meta.middleware == "guest") {
//         if (store.state.auth.authenticated) {
//             next({ name: "dashboard" })
//         }
//         next()
//     } else {
//         if (store.state.auth.authenticated) {
//             next()
//         } else {
//             next({ name: "login" })
//         }
//     }
// })

export default router
