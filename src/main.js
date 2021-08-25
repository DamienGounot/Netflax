import Vue from 'vue'
import App from './App.vue'
import vuetify from './plugins/vuetify'
import Vuerouter from 'vue-router'
import axios from 'axios'
import VueAxios from 'vue-axios'

Vue.config.productionTip = false
Vue.use(VueAxios, axios)
Vue.use(Vuerouter)

import Home from './components/Home'

const routes = [
  { path: '/Home', component: Home, meta: { requiresAuth: false }, name: 'home' }
]

const router = new Vuerouter({
  routes,
  mode: 'history'
})

new Vue({
  vuetify,
  router,
  render: h => h(App)
}).$mount('#app')
