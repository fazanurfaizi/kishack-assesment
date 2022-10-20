import './bootstrap';
import '../sass/app.scss'
import { createApp } from 'vue';
import Router from '@/router'
import store from '@/store';

import ElementPlus from 'element-plus'
import 'element-plus/dist/index.css'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faEye, faEyeSlash } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'

library.add(faEye, faEyeSlash)

const app = createApp({});

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

app.use(Router)
app.use(store)
app.use(ElementPlus)

app.component('font-awesome-icon', FontAwesomeIcon)

app.mount('#app');
