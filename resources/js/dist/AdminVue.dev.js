"use strict";

var _IncredibleOffers = _interopRequireDefault(require("./components/IncredibleOffers.vue"));

var _OrderStep = _interopRequireDefault(require("./components/OrderStep.vue"));

var _axios = _interopRequireDefault(require("axios"));

var _vueAxios = _interopRequireDefault(require("vue-axios"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

window.Vue = require('vue');
Vue.component('pagination', require('laravel-vue-pagination'));
Vue.component("Cleave", require("vue-cleave-component"));
Vue.use(_vueAxios["default"], _axios["default"]);
Vue.prototype.$siteUrl = "http://127.0.0.1:8000";
var app = new Vue({
  el: "#app",
  components: {
    IncredibleOffers: _IncredibleOffers["default"],
    OrderStep: _OrderStep["default"]
  }
});