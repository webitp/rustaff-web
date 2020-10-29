import Vue from 'vue'
import Vuex from 'vuex'
import Cookies from 'js-cookie'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    user: null,
    token: Cookies.get('token'),
    loginUrl: ''
  },
  mutations: {
  },
  actions: {
  },
  modules: {
  }
})
