import Vue from "vue";
import Router from "vue-router";

Vue.use(Router);

export default new Router({
    routes: [
        {
            path:'/home',
            name:'dashboard',
            //component: require('../js/components/dashboard.vue').default
        },
        {
            path:'*',
            //component: require('../js/components/not-found-component.vue').default
        }
    ],
    mode: 'history'
})