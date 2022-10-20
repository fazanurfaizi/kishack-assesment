import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import app from '@/store/modules/app'
import auth from '@/store/modules/auth'

const store = createStore({
    plugins: [
        createPersistedState()
    ],
    modules: {
        app,
        auth
    }
})

export default store
