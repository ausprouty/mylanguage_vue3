import Vuex from 'vuex'

const store = new Vuex.Store({
  state() {
    return {
      user: {
        browser_language: null,
        uid: null,
        scope: null,
        token: null,
        expires: null,
      },
      language: {
        hl_id: 'eng00',
        iso: 'eng',
        direction: 'ltr',
        chinese: null,
        menu_laptop: null,
        menu_mobile: null,
      },
    }
  },
  mutations: {},
  actions: {},
  modules: {},
})
