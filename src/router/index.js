import { createWebHistory, createRouter } from 'vue-router'
import Home from '../views/Home.vue'

const routes = [
  {
    path: '/',
    name: 'home',
    component: Home,
  },
  {
    path: '/discuss/:hl_id?',
    name: 'DBS',
    component: () =>
      import(/* webpackChunkName: "dbs" */ '../views/pages/DBS.vue'),
    meta: {
      title: 'Discover what God is like in MY LANGUAGE',
      metaTags: [
        {
          name: 'description',
          content:
            'Discover with your friends what God is like and how he wants you to live in 50 languages',
        },
        {
          property: 'keywords',
          content: 'Discover God',
        },
      ],
    },
  },
  {
    path: '/read/:hl_id?',
    name: 'BibleRead',
    component: function () {
      return import(/* webpackChunkName: "bible" */ '../views/pages/Bible.vue')
    },
  },
  {
    path: '/bible_online/:hl_id?',
    name: 'Bible',
    component: function () {
      return import(/* webpackChunkName: "bible" */ '../views/pages/Bible.vue')
    },
  },
  {
    path: '/listen/:hl_id?',
    name: 'Listen',
    component: function () {
      return import(
        /* webpackChunkName: "listen" */ '../views/pages/Listen.vue'
      )
    },
  },
  {
    path: '/watch/:hl_id?',
    name: 'Watch',
    component: function () {
      return import(/* webpackChunkName: "watch" */ '../views/pages/Watch.vue')
    },
  },
  {
    path: '/ask/:hl_id?',
    name: 'Ask',
    component: function () {
      return import(/* webpackChunkName: "ask" */ '../views/pages/Ask.vue')
    },
  },
  {
    path: '/meet/:hl_id?',
    name: 'Gospel',
    component: function () {
      return import(
        /* webpackChunkName: "gospel" */ '../views/pages/Gospel.vue'
      )
    },
  },
  {
    path: '/gospel/:hl_id?',
    name: 'Gospel',
    component: function () {
      return import(
        /* webpackChunkName: "gospel" */ '../views/pages/Gospel.vue'
      )
    },
  },
  {
    path: '/spirit/:hl_id?',
    name: 'Spirit',
    component: function () {
      return import(
        /* webpackChunkName: "spirit" */ '../views/pages/Spirit.vue'
      )
    },
  },
  {
    path: '/link/:hl_id?',
    name: 'EveryPerson',
    component: function () {
      return import(
        /* webpackChunkName: "everyperson" */ '../views/pages/Link.vue'
      )
    },
  },
]

const router = createRouter({
  history: createWebHistory(),
  routes,
})

export default router
