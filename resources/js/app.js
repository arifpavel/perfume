
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

// Global Fire variable to catch & emit events throwout the app
window.Fire = new Vue()

// Importing Gate.js & set to vue prtotype on window for ACL
import Gate from './Gate';
Vue.prototype.$gate = new Gate(window.user);

//Moment Js for datetime formetting

import moment from 'moment'

// VForm for vue & laravel validation
import { Form, HasError, AlertError } from 'vform'
window.Form = Form
Vue.component(HasError.name, HasError)
Vue.component(AlertError.name, AlertError)

// Vue Router
import VueRouter from 'vue-router'
Vue.use(VueRouter)

import routes from './routes'

const router = new VueRouter({
    routes, // short for `routes: routes`
    mode: 'history'
  })

/**
 * Vue Progressbar component from VueProgressbar lib to use in the app globally.
 */
import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '3px'
})

/**
 * Sweet Alart 2 import & set to window for global use.
 */
import Swal from 'sweetalert2'
const toast = Swal.mixin({
    toast: true,
    position: 'top-end',
    showConfirmButton: false,
    timer: 3000
  });
window.toast = toast;
window.Swal = Swal;
/**
 * Global Vue Filters to formet things
 */
// Capitalize string filter
Vue.filter('capitalize', function (value) {
    if (!value) return ''
    value = value.toString()
    return value.charAt(0).toUpperCase() + value.slice(1)
  })
// Date Formet using MomentJS filter
Vue.filter('dateformet', function (value) {
    if (!value) return ''
    return moment(value).format('MMMM Do YYYY, h:mm:ss a');
  })
 /**
  * Adding passports defaults components to vue for global use.
  */
 Vue.component(
  'passport-clients',
  require('./components/passport/Clients.vue').default
);

Vue.component(
  'passport-authorized-clients',
  require('./components/passport/AuthorizedClients.vue').default
);

Vue.component(
  'passport-personal-access-tokens',
  require('./components/passport/PersonalAccessTokens.vue').default
);

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    router
});
