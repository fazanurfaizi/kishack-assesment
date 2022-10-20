export default {
    namespaced: true,
    state: {
        sidebarVisible: '',
        sidebarUnfoldable: false,
    },
    getters: {},
    mutations: {
        toggleSidebar(state) {
            state.sidebarVisible = !state.sidebarVisible
        },
        toggleUnfoldable(state) {
            state.sidebarUnfoldable = !state.sidebarUnfoldable
        },
        updateSidebarVisible(state, payload) {
            state.sidebarVisible = payload.value
        },
    },
    actions: {}
}
