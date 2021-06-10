import Vue from 'vue'
import Vuex from 'vuex'
import cats from '../data/cats'
import dogs from '../data/dogs'
Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    cats,
    dogs
  },
  mutations: {
  },
  actions: {
  },
  modules: {
  }
})
