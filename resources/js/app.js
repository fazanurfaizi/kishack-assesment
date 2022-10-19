import './bootstrap';
import '../sass/app.scss'
import { createApp } from 'vue';
import Router from '@/router'
import store from '@/store';

const app = createApp({});

// Object.entries(import.meta.glob('./**/*.vue', { eager: true })).forEach(([path, definition]) => {
//     app.component(path.split('/').pop().replace(/\.\w+$/, ''), definition.default);
// });

app.use(Router)
app.use(store)

app.mount('#app');
