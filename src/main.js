import Vue from 'vue';
import VueMq from 'vue-mq';
var VueScrollTo = require('vue-scrollto');
import App from './App.vue';
import axios from 'axios';
//set the following value for the URL of your production API Web server
var URL = process.env.NODE_ENV !== 'production' ? 'http://vita.test' : '';
export const HTTP = axios.create({
  baseURL: URL
});

Vue.use(VueMq, {
  breakpoints: {
    sm: 800,
    lg: Infinity,
  }
});
Vue.use(VueScrollTo, {
  container: "#content-wrapper",
  duration: 500,
  easing: "ease",
  offset: 0,
  force: true,
  cancelable: true,
  onStart: false,
  onDone: false,
  onCancel: false,
  x: false,
  y: true
})

const EventBus = new Vue();

Object.defineProperties(Vue.prototype, {
  $bus: {
    get: function () {
      return EventBus
    }
  }
})

new Vue({
  el: '#app',
  render: h => h(App)
});
