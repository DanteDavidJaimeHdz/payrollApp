/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue').default;
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import Element from 'element-ui'
import locale from 'element-ui/lib/locale/lang/en'
import './element-variables.scss'
import jQuery from "jquery";

import Chartckick from "vue-chartkick";
import Chart from "chart.js";

window.$ = window.jQuery = jQuery;
Vue.use(ElementUI, { locale });
Vue.use(Chartckick.use(Chart));
Vue.config.delimiters = ['${', '}'];

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('example-component', require('./components/ExampleComponent.vue').default);
Vue.component('component-main-pos', require('./components/component-pos.vue').default);
Vue.component('not-found-component', require('./components/not-found-component.vue').default);
Vue.component('component-header-pos', require('./components/header-pos.vue').default);
Vue.component('create-movement', require('./components/movements/CreateMovement.vue').default);
Vue.component('movement-report', require('./components/movements/MovementReport.vue').default);
Vue.component('config', require('./components/config/Config.vue').default);
Vue.component('employee', require('./components/employees/Employees.vue').default);
Vue.component('role', require('./components/roles/Role.vue').default);
Vue.component('side-bar', require('./components/side-bar.vue').default);
Vue.component('basic-table', require('./components/utilities/basic-table.vue').default);
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */
import router from './routes';

const app = new Vue({
    el: '#app',
    router,
    data: {
        
    }
});
