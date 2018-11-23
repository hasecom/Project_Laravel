import routes from './router/routes.js';
import side_bar from './components/admin_folder/admin_side_bar.vue';
import admin_main from './components/admin_folder/admin_main.vue';
import admin_header from './components/admin_folder/admin_header.vue';
import admin_footer from './components/admin_folder/admin_footer.vue';

require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router'
Vue.use(VueRouter)

Vue.component('side-bar', side_bar);
Vue.component('admin-main', admin_main);
Vue.component('admin-header', admin_header);
Vue.component('admin-footer', admin_footer);

const router = new VueRouter({ 
    routes
});

const app = new Vue({
    router,
}).$mount('#app')





