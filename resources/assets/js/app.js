
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

Vue.component('navbarmain', require('./components/template/navbar/navbarmain.vue'));
Vue.component('navbar', require('./components/template/navbar/navbar.vue'));
Vue.component('logo', require('./components/template/navbar/logo.vue'));
Vue.component('contentmain', require('./components/template/main/contentmain.vue'));
Vue.component('breadcrumbmain', require('./components/template/main/breadcrumb/breadcrumbmain.vue'));
Vue.component('breadcrumb', require('./components/template/main/breadcrumb/breadcrumb.vue'));
Vue.component('pagetitle', require('./components/template/main/breadcrumb/pagetitle.vue'));
Vue.component('sidebar', require('./components/template/sidebar/sidebar.vue'));
/*--- Carga de Imagenes ---*/
Vue.component('file-upload',require('./components/utils/FileUpload.vue'));
Vue.component('file-upload-multiple', require('./components/utils/FileUploadMultiple.vue'));
Vue.component('file-upload-images', require('./components/utils/FileUploadImages.vue'));

import router from './router';
import store from './store';

const app = new Vue({
    router,
    store,      
    el: '#app',
    data:'',
});
