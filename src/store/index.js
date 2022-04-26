import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
  state: {
    user: {
      browser_language: null,
      uid: null,
      scope: null,
      token: null,
      expires: null
    },
    language: {
      hl_id: null,
      iso: null,
      direction: 'ltr',
      chinese: null,
      menu_laptop: null,
      menu_mobile: null,
    },
  },
  mutations: {},
  actions: {},
  modules: {},
})
