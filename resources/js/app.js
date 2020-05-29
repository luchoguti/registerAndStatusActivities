require('./bootstrap');

window.Vue = require('vue');

import VueRouter from 'vue-router';
import Vuetify from 'vuetify';
import 'vuetify/dist/vuetify.min.css';
Vue.config.productionTip = false
Vue.use(Vuetify)
export default new Vuetify({ })

Vue.use(VueRouter);

import VueAxios from 'vue-axios';
import axios from 'axios';

import App from './App.vue';
Vue.use(VueAxios, axios);

import VuejsDialog from 'vuejs-dialog/';

// include the default style
import 'vuejs-dialog/dist/vuejs-dialog.min.css'
Vue.use(VuejsDialog);

import HomeComponent from './components/activitiesComponents/Home.vue';
import CreateAndEditComponent from './components/activitiesComponents/CreateAndEdit.vue';

// Import component
import Loading from 'vue-loading-overlay';
// Import stylesheet
import 'vue-loading-overlay/dist/vue-loading.css';
Vue.use(Loading);

const routes = [
    {
        name: 'home',
        path: '/',
        component: HomeComponent
    },
    {
        name: 'create',
        path: '/create',
        component: CreateAndEditComponent
    }
];
const opts = {
    icons: {
        iconfont: 'md',  // 'mdi' || 'mdiSvg' || 'md' || 'fa' || 'fa4'
    },
    theme: {
        dark: false,
    },
    themes: {
        light: {
            primary: "#4682b4",
            secondary: "#b0bec5",
            accent: "#8c9eff",
            error: "#b71c1c",
        },
    },
}
const router = new VueRouter({ mode: 'history', routes: routes});
const app = new Vue({
    vuetify : new Vuetify(opts),
    router,
    components: { App },
    template: '<App/>'
}).$mount('#app');

