import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

export default new Router({
    routes: [
        {
            path:'/home',
            name:'dashboard',
            component: require('../js/components/dashboard.vue').default
        },
        {
            path:'/create_moverment',
            name:'movements',
            component: require('../js/components/movements/CreateMovement.vue').default
        },
        {
            path:'/movementReport',
            name:'movementReport',
            component: require('../js/components/movements/MovementReport.vue').default
        },
        {
            path:'/empoloyees',
            name:'empoloyees',
            component: require('../js/components/employees/Employees.vue').default
        },
        {
            path:'/roles',
            name:'roles',
            component: require('../js/components/roles/Role.vue').default
        },
        {
            path:'/config',
            name:'config',
            component: require('../js/components/config/Config.vue').default
        },
        {
            path:'*',
            component: require('../js/components/not-found-component.vue').default
        }
    ],
    mode: 'history'
})