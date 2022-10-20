import axios from "axios"
import router from '@/router'

export default {
    namespaced: true,
    state: {
        authenticated: false,
        user: null
    },
    getters: {
        authenticated(state) {
            return state.authenticated
        },
        user(state) {
            return state.user
        }
    },
    mutations: {
        setAuthenticated(state, payload) {
            state.authenticated = payload
        },
        setUser(state, payload) {
            state.user = payload
        }
    },
    actions: {
        login({commit}) {
            return new Promise(async (resolve, reject) => {
                await axios.get('/api/profile')
                    .then((response) => {
                        commit('setUser', response.data.data)
                        commit('setAuthenticated', true)
                        router.push({ name: 'dashboard' })
                        return resolve(response)
                    })
                    .catch((error) => {
                        commit('setUser', null)
                        commit('setAuthenticated', false)
                        return reject(error)
                    })
            })
        },
        logout({commit}) {
            commit('setUser', null)
            commit('setAuthenticated', false)
        }
    }
}
