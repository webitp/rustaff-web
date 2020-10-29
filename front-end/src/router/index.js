import Vue from 'vue'
import store from '@/store'
import VueRouter from 'vue-router'
import Home from '../views/Home.vue'
import Profile from '../views/Profile.vue'
import Rules from '../views/Rules.vue'
import BanList from '../views/BanList.vue'
import Servers from '../views/Servers.vue'
import Blocks from '../views/Blocks.vue'
import Shop from '../views/Shop.vue'
import Kits from '../views/Kits.vue'

import user from '../middleware/user'
import auth from '../middleware/auth'

Vue.use(VueRouter)

const routes = [
  {
    path: '/',
    name: 'Home',
    component: Home
  },
  
  {
    path: '/profile/:page',
    name: 'Profile',
    component: Profile,
    meta: {
      middleware: [
        auth
      ]
    },
  },

  {
    path: '/rules',
    name: 'Rules',
    component: Rules
  },

  {
    path: '/bans',
    name: 'BanList',
    component: BanList
  },

  {
    path: '/servers',
    name: 'Servers',
    component: Servers
  },

  {
    path: '/blocks',
    name: 'Blocks',
    component: Blocks
  },

  {
    path: '/shop',
    name: 'Shop',
    component: Shop
  },

  {
    path: '/kits',
    name: 'Kits',
    component: Kits
  }
]

const router = new VueRouter({
  mode: 'history',
  base: process.env.BASE_URL,
  routes
})

router.beforeEach(async (to, from, next) => {
  await user();
  if (!to.meta.middleware) {
    return next()
  }
  const middleware = to.meta.middleware
  const context = {
    to,
    from,
    next,
    store
  }
  return middleware[0]({
    ...context
  })
})

export default router
