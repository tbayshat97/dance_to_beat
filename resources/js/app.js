require("./bootstrap");

import store from "./store.js";
import VueRouter from "vue-router";
import swal from "sweetalert2";
import Vue from 'vue';
import VueAwesomeSwiper from 'vue-awesome-swiper';
import 'swiper/swiper-bundle.css';
import Select2 from 'v-select2-component';
import FlashMessage from '@smartweb/vue-flash-message';
import axios from 'axios';
import VueAxios from 'vue-axios'
import VueSocialauth from 'vue-social-auth'

Vue.use(VueAxios, axios)

Vue.use(VueRouter);

Vue.component("products-list", require("./components/ProductsList.vue").default);
Vue.component("related-products", require("./components/RelatedProducts.vue").default);
Vue.component(
    "home-products",
    require("./components/HomeProducts.vue").default
);
Vue.component("product-card", require("./components/ProductCard.vue").default);
Vue.component("category-products", require("./components/CategoryProducts.vue").default);
Vue.component("products-grid3", require("./components/ProductsGrid3.vue").default);
Vue.component("products-grid4", require("./components/ProductsGrid4.vue").default);
Vue.component("single-product", require("./components/SingleProduct.vue").default);
Vue.component("appointments-home", require("./components/Appointments.vue").default);
Vue.component("cart-dropdown", require("./components/Cart.vue").default);
Vue.component("checkout-page", require("./components/Checkout.vue").default);
Vue.component("wishlist-page", require("./components/Wishlist.vue").default);
Vue.component("wishlist-count", require("./components/auth/WishlistCount.vue").default);
Vue.component("my-account", require("./components/MyAccount.vue").default);
Vue.component("change-password", require("./components/ChangePassword.vue").default);
Vue.component("change-mobile-number", require("./components/ChangeMobileNumber.vue").default);
Vue.component("home-search", require("./components/Search.vue").default);
Vue.component("bottom-menu", require("./components/BottomMenu.vue").default);
Vue.component("my-appointments", require("./components/MyAppointments.vue").default);
Vue.component("order-history", require("./components/OrderHistory.vue").default);
Vue.component("forget-password", require("./components/auth/ForgetPassword.vue").default);
Vue.component("log-out", require("./components/auth/Logout.vue").default);
Vue.component("login-tab", require("./components/auth/Login.vue").default);
Vue.component("register-tab", require("./components/auth/Register.vue").default);
Vue.component("verify-account", require("./components/auth/Verify.vue").default);
Vue.component("Calendar", require("./components/Calendar.vue").default);
Vue.component(
    "user-board",
    require("./components/auth/UserBoard.vue").default
);
Vue.component(
    "single-product",
    require("./components/SingleProduct.vue").default
);
Vue.component(
    "show-order",
    require("./components/ShowOrder.vue").default
);

Vue.use(VueAwesomeSwiper, /* { default options with global component } */);

Vue.component('Select2', Select2);
new Vue({
	// ...
})
Vue.use(FlashMessage);

Vue.use(VueSocialauth, {

    providers: {
      facebook: {
        clientId: '161205152617362',
        client_secret: '826c2924256f0e82f4fc112bf64d31fa',
        redirectUri: '/auth/facebook/callback' // Your client app URL
      }
    }
  })

//Translation
Vue.prototype.translate=require('./VueTranslation/Translation').default.translate;

const router = new VueRouter({
    mode: "history",
    routes: [
        {
            path: "/",
            name: "home",
        },
        {
            path: "/product/:id",
            name: "single-product",
        },
        {
            path: "/show-order/:id",
            name: "show-order",
        }

    ]
});

window.onpopstate = function() {
    location.reload();
};

const app = new Vue({
    el: "#app",
    router,
    store: new Vuex.Store(store)
});
