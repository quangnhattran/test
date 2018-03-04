
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');
import InstantSearch from 'vue-instantsearch'
Vue.use(InstantSearch)
window.Events = new Vue();
window.flash = function (message,type='success') {
    window.Events.$emit('flash',{message,type});
}
let authorization = require('./authorization')
Vue.prototype.authorize = function(...params) {
    if(! window.App.signedIn) return false;
    if(typeof params[0]=='string') {
        return authorization[params[0]](params[1]);
    }
    return params[0](window.App.user);
};
Vue.prototype.signedIn = window.App.signedIn;
/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.component('flash', require('./components/Flash.vue'));
Vue.component('thread-view', require('./pages/Thread.vue'));
Vue.component('avatar-form', require('./components/AvatarForm.vue'));
Vue.component('wysiwyg',require('./components/Wysiwyg.vue'));

const app = new Vue({
    el: '#app'
});
