import Vue from 'vue'
import VueRouter from 'vue-router'


Vue.use(VueRouter)

const routes = [
  {
    path: '/dbs_home',
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
    path: '/bible_online',
    name: 'Bible',
    component: function () {
      return import(/* webpackChunkName: "bible" */ '../views/pages/Bible.vue')
    },
  },
  {
    path: '/listen',
    name: 'Listen',
    component: function () {
      return import(
        /* webpackChunkName: "listen" */ '../views/pages/Listen.vue'
      )
    },
  },
  {
    path: '/watch_online',
    name: 'Watch',
    component: function () {
      return import(/* webpackChunkName: "watch" */ '../views/pages/Watch.vue')
    },
  },
  {
    path: '/ask',
    name: 'Ask',
    component: function () {
      return import(/* webpackChunkName: "ask" */ '../views/pages/Ask.vue')
    },
  },
  {
    path: '/meet',
    name: 'Gospel',
    component: function () {
      return import(
        /* webpackChunkName: "gospel" */ '../views/pages/Gospel.vue'
      )
    },
  },
  {
    path: '/study_online',
    name: 'Spirit',
    component: function () {
      return import(
        /* webpackChunkName: "spirit" */ '../views/pages/Spirit.vue'
      )
    },
  },
  {
    path: '/link',
    name: 'EveryPerson',
    component: function () {
      return import(
        /* webpackChunkName: "everyperson" */ '../views/pages/Link.vue'
      )
    },
  },
]

const router = new VueRouter({
  routes,
})

export default router
