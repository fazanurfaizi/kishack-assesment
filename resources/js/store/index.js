import { createStore } from 'vuex'
import createPersistedState from 'vuex-persistedstate'
import app from '@/store/modules/app'
import auth from '@/store/modules/auth'
import category from '@/store/modules/category'

const store = createStore({
    plugins: [
        createPersistedState()
    ],
    modules: {
        app,
        auth,
        category
    }
})

export default store
