import Vue from 'vue';
// import VueRouter from "vue-router";
import './style.css'
import App from './App.vue'

Vue.config.productionTip = false;

// Vue.use(VueRouter);

// const routes = [
//     {
//         path: '/',
//         name: 'home',
//         component: Home
//     },
//     {
//         path: '/about',
//         name: 'about',
//         component: About
//     }
// ];

// const router = new VueRouter({
//     routes
// });



new Vue({

    render: (h) => h(App),
}).$mount('#app');
