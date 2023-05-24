import Vue from 'vue'
import App from './App.vue'
import router from './router'
import store from './store'

import { BootstrapVue } from 'bootstrap-vue'
import { EmbedPlugin } from 'bootstrap-vue'
import { library } from '@fortawesome/fontawesome-svg-core'
import { faHatWizard } from '@fortawesome/free-solid-svg-icons'
import { FontAwesomeIcon } from '@fortawesome/vue-fontawesome'
import  VueCookies  from 'vue-cookies'
import Vuesax from 'vuesax'
import Buefy from 'buefy'
import SvgIcon from '@jamescoyle/vue-icon'
import { mdiAccount } from '@mdi/js'
import VueSweetalert2 from 'vue-sweetalert2';


Vue.config.productionTip = false

import 'bootstrap/dist/css/bootstrap.css'
import 'bootstrap-vue/dist/bootstrap-vue.css'
import "@fortawesome/fontawesome-free/css/all.min.css";
import 'vuesax/dist/vuesax.css'; //Vuesax styles
import 'buefy/dist/buefy.css';
import 'sweetalert2/dist/sweetalert2.min.css';


library.add(faHatWizard)

// Make BootstrapVue available throughout your project
Vue.use(BootstrapVue)
Vue.use(EmbedPlugin)
// Optionally install the BootstrapVue icon components plugin
//Vue.use(IconsPlugin)

// default options config: { expires: '1d', path: '/', domain: '', secure: '', sameSite: 'Lax' }
Vue.use(VueCookies, { expires: '7d'})

Vue.use(Vuesax);

Vue.component('vue-fontawesome', FontAwesomeIcon);

Vue.component('vue-mdi', mdiAccount);

Vue.use(SvgIcon);

Vue.use(Buefy);
Vue.use(VueSweetalert2);

//import "bootstrap/dist/js/bootstrap";

new Vue({
  router,
  store,
  render: h => h(App)
}).$mount('#app')
