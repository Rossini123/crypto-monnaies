import { createRouter, createWebHistory } from 'vue-router'
import Markets from '../views/Markets.vue'
import About from '../views/About.vue'

const routes = [
  {
    path: '/markets',
    name: 'Markets',
    component: Markets
  },
  {
    path: '/',
    redirect: 'markets'
  },
  {
    path: '/about',
    name: 'About',
    component: About
  },
]

const router = createRouter({
  history: createWebHistory(process.env.BASE_URL),
  routes
})

export default router
