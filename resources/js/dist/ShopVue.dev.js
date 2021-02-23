"use strict";

var _Counter = _interopRequireDefault(require("./components/Counter.vue"));

var _OfferTime = _interopRequireDefault(require("./components/OfferTime.vue"));

var _Roz = _interopRequireDefault(require("./components/Roz.vue"));

var _RentingCart = _interopRequireDefault(require("./components/RentingCart.vue"));

var _AddressList = _interopRequireDefault(require("./components/AddressList.vue"));

var _HeaderCart = _interopRequireDefault(require("./components/HeaderCart.vue"));

var _ProfileAddress = _interopRequireDefault(require("./components/ProfileAddress.vue"));

var _LoginBox = _interopRequireDefault(require("./components/LoginBox.vue"));

var _numeral = _interopRequireDefault(require("numeral"));

var _vueFilterNumberFormat = _interopRequireDefault(require("vue-filter-number-format"));

var _axios = _interopRequireDefault(require("axios"));

var _vueAxios = _interopRequireDefault(require("vue-axios"));

function _interopRequireDefault(obj) { return obj && obj.__esModule ? obj : { "default": obj }; }

window.Vue = require("vue");
Vue.component("pagination", require("laravel-vue-pagination"));
Vue.filter("numFormat", (0, _vueFilterNumberFormat["default"])(_numeral["default"]));
Vue.use(_vueAxios["default"], _axios["default"]);
Vue.prototype.$siteUrl = "http://127.0.0.1:8000";
var app = new Vue({
  el: "#app",
  components: {
    Counter: _Counter["default"],
    OfferTime: _OfferTime["default"],
    Roz: _Roz["default"],
    RentingCart: _RentingCart["default"],
    AddressList: _AddressList["default"],
    HeaderCart: _HeaderCart["default"],
    ProfileAddress: _ProfileAddress["default"],
    LoginBox: _LoginBox["default"]
  }
});