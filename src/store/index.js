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
    appendPet: (state, { species, pet }) => {
      state[species].push(pet)
    }
  },
  actions: {
    addPet: ({ commit }, payload) => {
      commit('appendPet', payload)
    }
  },
  modules: {
  }
})
