import Vue from 'vue'
import Vuex from 'vuex'
import axios from 'axios'

Vue.use(Vuex)

axios.defaults.baseURL = 'http://localhost/laravel-passport-vue-sap/public/api'
//axios.defaults.baseURL = 'https://greenisle.co.za/api';

export default new Vuex.Store({
  state: {
    user: null
  },

  mutations: {
    setUserData (state, userData) {
      state.user = userData
      localStorage.setItem('user', JSON.stringify(userData))
      axios.defaults.headers.common.Authorization = `Bearer ${userData.token}`
    },

    clearUserData () {
      localStorage.removeItem('user')
      location.reload()
    }
  },

  actions: {
    login ({ commit }, credentials) {
      return axios
        .post('/login', credentials)
        .then(({ data }) => {
          commit('setUserData', data)
        })
    },

    logout ({ commit }) {
      return axios
        .post('/logout')
        .then(({ data }) => {
          commit('clearUserData')
        })
    },

    logoutAll ({ commit }) {
      return axios
        .post('/logoutAll')
        .then(({ data }) => {
          commit('clearUserData')
        })
    }
  },

  getters : {
    isLogged: state => !!state.user
  }
})
