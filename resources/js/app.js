require('./bootstrap');
window.Vue = require('vue');

import App from './App.vue';
import VueRouter from 'vue-router';
import VueAxios from 'vue-axios';
import axios from 'axios';
import Vuex from 'vuex';
import {routes} from './routes';
import Antd from 'ant-design-vue';
import 'ant-design-vue/dist/antd.css';
import 'es6-promise/auto';
import store from './loginLogout';
import { ValidationProvider, extend } from 'vee-validate';
import { ValidationObserver } from 'vee-validate';
import Vuetify from "../plugins/vuetify";

Vue.config.productionTip = false;
// Add a rule.
extend('secret', {
  validate: value => value === 'example',
  message: 'This is not the magic word'
});

// Register it globally
Vue.component('ValidationProvider', ValidationProvider);
Vue.component('ValidationObserver', ValidationObserver);
Vue.use(Antd);
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(Vuex);

axios.defaults.baseURL = 'http://localhost/cwqafkxr_eat_in_more/public/api';
//axios.defaults.baseURL = 'https://greenisle.co.za/api';

const router = new VueRouter({
    mode: 'history',
    base: "/cwqafkxr_eat_in_more/public/",
    //base: "/",
    routes: routes
});

router.beforeEach((to, from, next) => {
  const loggedIn = localStorage.getItem('user')

  if (to.matched.some(record => record.meta.auth) && !loggedIn) {
    next('/login')
    return
  }
  next()
});



const app = new Vue({
    vuetify:Vuetify,
    el: '#app',
    router: router,
    store,
    created () {
	    const userInfo = localStorage.getItem('user')
	    if (userInfo) {
	      const userData = JSON.parse(userInfo)
	      this.$store.commit('setUserData', userData)
	    }
	    axios.interceptors.response.use(
	      response => response,
	      error => {
	        if (error.response.status === 401) {
	          this.$store.dispatch('logout')
	        }
	        return Promise.reject(error)
	      }
	    )
	 },
    render: h => h(App),
});

