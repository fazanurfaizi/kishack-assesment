import axios from "axios"

export default {
    namespaced: true,
    state: {
        categories: [],
    },
    getters: {
        categories(state) {
            return state.categories
        }
    },
    mutations: {
        setCategories(state, payload) {
            state.categories = payload
        }
    },
    actions: {
        allCategories({ commit }) {
            return new Promise(async (resolve, reject) => {
                await axios.get('/api/categories')
                    .then((response) => {
                        commit('setCategories', response.data.data)
                        return resolve(response)
                    })
                    .catch((error) => {
                        commit('setCategories', [])
                        return reject(error)
                    })
            })
        },
        // logout({ commit }) {
        //     return new Promise(async (resolve, reject) => {
        //         await axios.get('/sanctum/csrf-cookie').then(async () => {
        //             await axios.get('/logout')
        //                 .then((response) => {
        //                     commit('setUser', null)
        //                     commit('setAuthenticated', false)
        //                     return resolve(response)
        //                 })
        //                 .catch((error) => {
        //                     commit('setUser', null)
        //                     commit('setAuthenticated', false)
        //                     return reject(error)
        //                 })
        //                 .finally(() => router.push({ name: 'login' }))
        //         })
        //     })
        // }
    }
}
