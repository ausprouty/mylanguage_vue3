import { createApp } from 'vue'
import { createStore } from 'vuex'

const store = createStore({
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
        hl_id: null,
        iso: null,
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

const app = createApp({
  /* your root component */
})

// Install the store instance as a plugin
app.use(store)
