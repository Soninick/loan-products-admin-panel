import { createApp } from 'vue';
import { createRouter } from './router';
import App from './App.vue';
import 'bootstrap/dist/css/bootstrap.min.css';
import './style.css';

createApp(App).use(createRouter()).mount('#app');
