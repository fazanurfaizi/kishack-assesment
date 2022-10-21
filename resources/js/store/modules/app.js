export default {
    namespaced: true,
    state: {
        sidebarVisible: '',
        sidebarUnfoldable: false,
        breadcrumb: {
            title: '',
            subtitle: ''
        }
    },
    getters: {
        breadcrumb(state) {
            return state.breadcrumb
        }
    },
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
        setBreadcrumb(state, payload) {
            state.breadcrumb = payload
        }
    },
    actions: {}
}
