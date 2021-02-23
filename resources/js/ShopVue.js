window.Vue = require("vue");
Vue.component("pagination", require("laravel-vue-pagination"));
import Counter from "./components/Counter.vue";
import OfferTime from "./components/OfferTime.vue";
import Roz from "./components/Roz.vue";
import RentingCart from "./components/RentingCart.vue";
import AddressList from "./components/AddressList.vue";
import HeaderCart from "./components/HeaderCart.vue";
import ProfileAddress from "./components/ProfileAddress.vue";
import LoginBox from "./components/LoginBox.vue";

import numeral from 'numeral';
import numFormat from 'vue-filter-number-format';
Vue.filter("numFormat", numFormat(numeral));
import axios from "axios";
import VueAxios from "vue-axios";
Vue.use(VueAxios, axios);
Vue.prototype.$siteUrl = "http://127.0.0.1:8000";

const app = new Vue({
    el: "#app",
    components: {
        Counter,
        OfferTime,
        Roz,
        RentingCart,
        AddressList,
        HeaderCart,
        ProfileAddress,
        LoginBox
    }
});
