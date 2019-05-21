/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');



import Vue from 'vue';
import Vuex from 'vuex';

import VueFormWizard from 'vue-form-wizard';
import Vuelidate from 'vuelidate';
import 'vue-form-wizard/dist/vue-form-wizard.min.css';


Vue.use(VueFormWizard)

 Vue.use(Vuex);
Vue.use(Vuelidate);



Vue.component('clock', require('./components/helpers/clock.vue').default);
Vue.component('fanpage-idea', require('./components/ideas/FanPage.vue').default);
Vue.component('home-idea', require('./components/ideas/administrador/index.vue').default);
Vue.component('form-register', require('./components/users/administrador/form-register.vue').default);
Vue.component('step1', require('./components/users/administrador/step1.vue').default);
Vue.component('step2', require('./components/users/administrador/step2.vue').default);


// Vue.component('step1', {
//   template: ``,
  
// })

// Vue.component('step2', {
//   template: `<div>
//           <div class="form-group" v-bind:class="{ 'has-error': $v.country.$error }">
//             <label >Country</label>
//             <select class="form-control" v-model.trim="country" @input="$v.country.$touch()">
//               <option>USA</option>
//   					   <option>United Kingdom</option>
//   						<option>France</option>
//             </select>
//              <span class="help-block" v-if="$v.country.$error && !$v.country.required">Country is required</span>
//           </div>
//           <div class="form-group" v-bind:class="{ 'has-error': $v.city.$error }">
//             <label>City</label>
//             <input class="form-control" v-model.trim="city" @input="$v.city.$touch()">
//              <span class="help-block" v-if="$v.city.$error && !$v.city.required">City is required</span>
//           </div>
//         </div>`,
//   data() {
//     return {
//       country: '',
//       city: ''
//     }
//   },
//   validations: {
//     country: {
//       required
//     },
//     city: {
//       required
//     },
//     form: ['country', 'city']
//   },
//   methods: {
//     validate() {
//       this.$v.form.$touch();
//       var isValid = !this.$v.form.$invalid
//       this.$emit('on-validate', this.$data, isValid)
//       return isValid
//     }
//   }
// });





// const router = new VueRouter({
//     routes: [
//             {
//                 path: '/',
//                 component: require('./views/Home.vue').default,
//             },
//             {
//                 path: '/ideas',
//                 component: require('./views/Ideas.vue').default,

//             },
            

//         ],
//         'linkExactActiveClass': 'acitve',
//         mode: 'history'
//     });






const app = new Vue({
    el: '#app',
    data: {
    finalModel: {},
  },
  methods: {
    validateStep(name) {
      var refToValidate = this.$refs[name];
      return refToValidate.validate();
    },
    mergePartialModels(model, isValid){
      if(isValid){
      // merging each step model into the final model
       this.finalModel = Object.assign({},this.finalModel, model)
      }
    }
  }
    // router,
    
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
