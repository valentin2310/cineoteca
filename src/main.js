import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

import { BootstrapVue, IconsPlugin } from 'bootstrap-vue'
import  VueCookies  from 'vue-cookies'

Vue.config.productionTip = false

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import "@fortawesome/fontawesome-free/css/all.min.css";

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
// Optionally install the BootstrapVue icon components plugin
Vue.use(IconsPlugin)

// default options config: { expires: '1d', path: '/', domain: '', secure: '', sameSite: 'Lax' }
Vue.use(VueCookies, { expires: '7d'})

import "bootstrap/dist/js/bootstrap";

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
