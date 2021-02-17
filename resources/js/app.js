/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');


window.Vue = require('vue').default;
import Form from './Form';
window.Form = Form;
import store from "./store/index";
Vue.prototype.$eventBus = new Vue();
import VueJSModal from 'vue-js-modal';
Vue.use(VueJSModal);
import StarRating from 'vue-star-rating';


/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i)
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default))

Vue.component('menu-component', require('./components/MenuComponent.vue').default);

Vue.component('addtocart-component', require('./components/AddToCartComponent.vue').default);
Vue.component('badge-component', require('./components/BadgeComponent.vue').default);
Vue.component('cart-item-component', require('./components/Cart/CartItemComponent.vue').default);
Vue.component('cart-component', require('./components/Cart/CartComponent.vue').default);
Vue.component('checkout-component', require('./components/Cart/CheckoutComponent.vue').default);

Vue.component('admin-button-component', require('./components/Admin/AdminButtonComponent.vue').default);
Vue.component('admin-menu-component', require('./components/Admin/AdminMenuComponent.vue').default);
Vue.component('sidebar-component', require('./components/Admin/SidebarComponent.vue').default);

Vue.component('order-management-component', require('./components/OrderManagementComponent.vue').default);
Vue.component('coupon-management-component', require('./components/CouponManagementComponent.vue').default);
Vue.component('star-rating-component', require('./components/StarRatingComponent.vue').default);
Vue.component('star-rating', StarRating);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    store: store,
});
