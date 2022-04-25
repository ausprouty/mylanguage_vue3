import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Login from '../views/Login.vue'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Login',
    component: Login,
  },
  {
    path: '/home',
    name: 'Home',
    component: Home,
  },
  {
    path: '/about',
    name: 'About',
    component: function () {
      return import(/* webpackChunkName: "about" */ '../views/About.vue')
    },
  },

  {
    path: '/dbs_home',
    name: 'DBS',
    component: function () {
      return import(/* webpackChunkName: "dbs" */ '../views/pages/DBS.vue')
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
      return import(/* webpackChunkName: "listen" */ '../views/pages/Listen.vue')
    },
  },
  {
    path: '/dbs_home',
    name: 'DBS',
    component: function () {
      return import(/* webpackChunkName: "dbs" */ '../views/pages/DBS.vue')
    },
  },
  {
    path: '/dbs_home',
    name: 'DBS',
    component: function () {
      return import(/* webpackChunkName: "dbs" */ '../views/pages/DBS.vue')
    },
  },
  {
    path: '/dbs_home',
    name: 'DBS',
    component: function () {
      return import(/* webpackChunkName: "dbs" */ '../views/pages/DBS.vue')
    },
  },
]

const router = new VueRouter({
  routes,
})

export default router
