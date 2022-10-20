export default {
    namespaced: true,
    state: {
        sidebar: {
            opened: localStorage.getItem('sidebarStatus') ? !!localStorage.getItem('sidebarStatus') : true,
            withoutAnimation: false
        },
        device: 'desktop'
    },
    getters: {
        sidebar: state => state.sidebar,
        device: state => state.device
    },
    mutations: {
        toggleSidebar(state) {
            state.sidebar.opened = !state.sidebar.opened
            state.sidebar.withoutAnimation = false
            if(state.sidebar.opened) {
                localStorage.setItem('sidebarStatus', 1)
            } else {
                localStorage.setItem('sidebarStatus', 0)
            }
        },
        closeSidebar(state, payload) {
            localStorage.setItem('sidebarStatus', 0)
            state.sidebar.opened = false
            state.sidebar.withoutAnimation = payload
        },
        toggleDevice(state, payload) {
            state.device = payload
        }
    },
    actions: {
        toggleSidebar({ commit }) {
            commit('toggleSidebar')
        },
        closeSidebar({ commit }, payload) {
            commit('closeSidebar', payload.withoutAnimation)
        },
        toggleDevice({ commit }, payload) {
            commit('toggleDevice', payload)
        }
    }
}
