// note css gula eikhane import na kore app.scss eo import kora jete pare oita best practice

require("./bootstrap");
window.Vue = require("vue");
// axios import here start
import axios from "axios";
window.Axios = axios; //globally use
// axios import here end
import App from "./App.vue"; //render component
//import vue filter
import { filter_moment } from "./filter/filter";
//import vue mixin
import "./helpers/mixin";

// start vuex initialize
import Vuex from "vuex";
Vue.use(Vuex);
window.Vuex = Vuex; //globally use
import store_data from "./store/store";
const store = new Vuex.Store(store_data);
// end vuex initialize

// import sweetalert2 start
import swal from "sweetalert2";
window.swal = swal;
// import sweetalert2 end

// import element ui start
// import elementUi from "../../node_modules/element-ui/lib/theme-chalk/index.css";
import ElementUI from "element-ui";
// app.sass e css file link korano hoise miah

Vue.use(ElementUI);
// import element ui end

// import iziToast message start
import iziToastCss from "../../node_modules/izitoast/dist/css/iziToast.min.css";
import iziToastJs from "izitoast";
window.iziToast = iziToastJs;
iziToast.settings({
    timeout: 2500,
    resetOnHover: false,
    transitionIn: "flipInX",
    transitionOut: "flipOutX",
    titleColor: "#ffffff",
    titleSize: "16px",
    position: "topRight",
    theme: "dark",
    zindex: "9999999999999999999999999999999999999999999999999999999999999999",
    drag: false,
    progressBarColor: "#ffffff",
    transitionIn: "fadeInLeft",
    transitionOut: "fadeOutRight",
    transitionInMobile: "fadeInLeft",
    transitionOutMobile: "fadeOutRight"
});
// import iziToast message end

// progressbar preloader start
import VueProgressBar from "vue-progressbar"; //use vue progressbar preloader
const options = {
    color: "#41ff03",
    failedColor: "red",
    thickness: "3px",
    transition: {
        speed: "0.6s",
        opacity: "0.4s",
        termination: 300
    },
    autoRevert: true,
    location: "top",
    inverse: false
};
Vue.use(VueProgressBar, options);
// progressbar preloader end

// import bootstrap vue start
import BootstrapVue from "bootstrap-vue";
Vue.use(BootstrapVue);
// import bootstrap vue end

// start vue router
import { router } from "./router/routes";

// end vue router

// Vue.component('example-component', require('./components/ExampleComponent.vue').default);

const app = new Vue({
    el: "#app",
    render: h => h(App),
    router,
    store
});

Vue.config.devtools = true;
Vue.config.debug = true;
Vue.config.silent = false;
