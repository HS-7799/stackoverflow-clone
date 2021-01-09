
require('./bootstrap');

window.Vue = require('vue');


import App from './App.vue'
import vuetify from './vuetify/index.js'
import router from './Router/router.js'

import User from './Helpers/User.js'
import Exception from './Helpers/Exception.js'
import md from 'marked'

window.md = md;

window.User = User;
window.Exception = Exception;

import VueProgressBar from 'vue-progressbar'

Vue.use(VueProgressBar, {
  color: 'rgb(143, 255, 199)',
  failedColor: 'red',
  height: '7px'
})

export const eventBus = new Vue({
});

const app = new Vue({
    el: '#app',
    render : h => h(App),
    vuetify,
    router
});
