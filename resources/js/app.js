require('./bootstrap');
window.Vue = require('vue');
window.moment = require('moment');//para funcionar o moment fora do js

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
//vue tables 2
import { ServerTable, ClientTable, Event } from 'vue-tables-2';
import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
//permission
import { abilitiesPlugin } from '@casl/vue';
import {ability} from './ability.js'
//laguang
import {i18n} from './i18n.js'
//local storage
import Storage from "vue-ls";
const options = {
  namespace: 'vuejs__', // key prefix
  name: 'ls', // name variable Vue.[ls] or this.[$ls],
  storage: 'local', // storage name session, local, memory
};
Vue.use(Storage, options);

//VueGoogleMaps
import * as VueGoogleMaps from "vue2-google-maps";
//nprocesss
import NProgress from 'vue-nprogress'

Vue.use(VueGoogleMaps, {
  load: {
    key: "AIzaSyDYU9QZbgp6ctkbFIpHR0km9Lu7kh0Z2Ac",
  },
  installComponents: true,
});




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
Vue.use(ServerTable, {}, false, 'bootstrap4')
Vue.use(require('vue-moment'));
Vue.use(BootstrapVue)
Vue.use(IconsPlugin)
Vue.use(abilitiesPlugin, ability);

//axios.defaults.baseURL = 'http://localhost/cwqafkxr_eat_in_more/public/api';
axios.defaults.baseURL = 'https://cwqafkxreatinmore.herokuapp.com/api';

const router = new VueRouter({
    mode: 'history',
    //base: "/cwqafkxr_eat_in_more/public/",
    base: "/",
    routes: routes
});


const optionsNProgress = {
  latencyThreshold: 200, // Number of ms before progressbar starts showing, default: 100,
  router: true, // Show progressbar when navigating routes, default: true
  http: true // Show progressbar when doing Vue.http, default: true
};
Vue.use(NProgress, optionsNProgress)

const nprogress = new NProgress()

import { AbilityBuilder, Ability } from '@casl/ability';
const { can, rules } = new AbilityBuilder(Ability);
router.beforeEach((to, from, next) => {

  const loggedIn = localStorage.getItem('user')
  const canNavigate = to.matched.some(route => {
      if(route.meta.resource){
          return ability.can(route.meta.resource)
      }
    return true
  })


  if (to.matched.some(record => record.meta.auth) && !loggedIn) {
    next('/login')
    return
  }else{

    if (!canNavigate) {
        return next('/403')
    }
  }

  next()
});



const app = new Vue({
    vuetify:Vuetify,
    el: '#app',
    router: router,
    store,
    i18n,
    nprogress,
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

