
/**
 * First, we will load all of this project's Javascript utilities and other
 * dependencies. Then, we will be ready to develop a robust and powerful
 * application frontend using useful Laravel and JavaScript libraries.
 */

import './bootstrap';
import Vue from 'vue';
import BootstrapVue from 'bootstrap-vue';
import Loading from 'vue-loading-overlay';
import AxiosPlugin from '@/js/axios-plugin.js';
import Routes from '@/js/routes.js';
import App from '@/js/views/App';
import '../sass/app.scss';

Vue.use(AxiosPlugin);
Vue.use(BootstrapVue);
Vue.use(Loading);
const app = new Vue({
   el: '#app',
   router: Routes,
   render: h => h(App),
});

export default app;
