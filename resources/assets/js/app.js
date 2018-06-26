
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VeeValidate from "vee-validate";
import es from "vee-validate/dist/locale/es";
import BootstrapVue from "bootstrap-vue";
import InstantSearch from "vue-instantsearch";
import VModal from 'vue-js-modal';
import vSelect from 'vue-select';

Vue.use(VeeValidate);
Vue.use(BootstrapVue);
Vue.use(InstantSearch);
Vue.use(VModal);

Vue.use(require('vue-moment'));

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component("socialite", require("./components/LoginSocialite"));
Vue.component("search-input", require("./components/SearchInput"));
Vue.component("search-page", require("./components/SearchPage"));
Vue.component("user-notifications", require("./components/UserNotifications"));
Vue.component("avatar-form", require("./components/user/AvatarForm"));
Vue.component("website-create", require("./components/website/CreateForm"));
Vue.component("website-update", require("./components/website/UpdateForm"));
Vue.component("subscribe-button", require("./components/website/SubscribeButton"));
Vue.component("article-create", require("./components/article/CreateForm"));
Vue.component("article-update", require("./components/article/UpdateForm"));
Vue.component("message-main", require("./components/message/Main"));
Vue.component("message-create", require("./components/message/Send_message"));
Vue.component('v-select', vSelect);
Vue.component("favorite-button", require("./components/article/FavoriteButton"));
Vue.component("shopping-button", require("./components/cart/ShoppingButton"));
Vue.component("shopping-cart", require("./components/cart/shopping_cart"));
Vue.component("cart-notification", require("./components/UserCartNotifications"));

new Vue({
    el: '#app',
    created: function () {
        this.$validator.localize("es", {
            messages: es.messages,
        });
    }
});
