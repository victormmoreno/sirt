/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');



import Vue from 'vue';
import Vuex from 'vuex';
import VueRouter from 'vue-router';




Vue.use(Vuex);
Vue.use(VueRouter);


Vue.component('clock', require('./components/MyNewComponent.vue').default);



const router = new VueRouter({
    routes: [
            {
                path: '/',
                component: require('./views/Home.vue').default,
            },
            {
                path: '/ideas',
                component: require('./views/Ideas.vue').default,

            },
            

        ],
        'linkExactActiveClass': 'acitve',
        mode: 'history'
    });






const app = new Vue({
    el: '#app',
    router,
    
});



// import Vue from 'vue';
// import Vuex from 'vuex';
// import VueRouter from 'vue-router';
// import {routes} from './routes';
// import StoreData from './store';
// import MainApp from './components/MainApp.vue';


// Vue.use(Vuex);
// Vue.use(VueRouter);

// const store = new Vuex.Store(StoreData);

// const router = new VueRouter({
// 	routes,
// 	mode: 'history'
// });

// router.beforeEach((to, from, next) => {
//         const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
//         const currentUser = store.state.currentUser;
    
//         if(requiresAuth && !currentUser) {
//             next();
//         }else if(requiresAuth && currentUser) {
//             next('/home');
//         }  
//         else if(to.path == '/login' && currentUser) {
//             next('/home');
//         } else {
//             next();
//         }
//     });



// const app = new Vue({
//     el: '#app',
//     router,
//     store,
//     components: {
//         MainApp
//     }
// });
