//ADMIN
import routes from './router/routes.js';
import side_bar from './components/admin_folder/admin_side_bar.vue';
import admin_main from './components/admin_folder/admin_main.vue';
import admin_header from './components/admin_folder/admin_header.vue';
import admin_footer from './components/admin_folder/admin_footer.vue';
import admin_login from './components/admin_folder/admin_login.vue';


//USER
import login from './components/user_folder/flow/user_login.vue';
import sign_up from './components/user_folder/flow/sign_up_frame.vue';
import user_top from './components/user_folder/individual/user_top.vue';


//ADMIN
require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router'
Vue.use(VueRouter)

Vue.component('side-bar', side_bar);//#app内
Vue.component('admin-main', admin_main);//#app内
Vue.component('admin-header', admin_header);//#app内
Vue.component('admin-footer', admin_footer);//#app内
Vue.component('admin-login', admin_login);//#app内

//USER
Vue.component('login', login);//#app内
Vue.component('sign_up', sign_up);//#app内
Vue.component('user_top', user_top);//#app内



const router = new VueRouter({ 
    routes
});

const app = new Vue({
    router,
}).$mount('#app')










