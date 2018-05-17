
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import VeeValidate from 'vee-validate';
import es from 'vee-validate/dist/locale/es';

Vue.use(VeeValidate);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('socialite', require('./components/LoginSocialite'));
Vue.component('user-notifications', require('./components/UserNotifications'));
Vue.component('website-create', require('./components/website/CreateForm'));
Vue.component('website-update', require('./components/website/UpdateForm'));
Vue.component('image-form', require('./components/website/ImageForm'));
Vue.component('avatar-form', require('./components/user/AvatarForm'));
Vue.component('subscribe-button', require('./components/website/SubscribeButton'));

new Vue({
    el: '#app',
    created: function () {
        this.$validator.localize('es', {
            messages: es.messages,
        });
    },
});
