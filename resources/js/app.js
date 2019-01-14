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
import user_front from './components/user_folder/individual/user_front.vue';
import mypage_img_gallery from './components/user_folder/individual/mypage_img_gallery.vue';
import each_user_img_gallery from './components/user_folder/individual/each_user_img_gallery.vue';
import chats from './components/user_folder/individual/component/chats.vue';
import user_post_details from './components/user_folder/individual/component/user_post_details.vue';
import chats_indicate from './components/user_folder/individual/component/chats_indicate.vue';


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
Vue.component('user_front', user_front);//#app内
Vue.component('img-gallery',mypage_img_gallery);
Vue.component('each-user-img-gallery',each_user_img_gallery);
Vue.component('chats',chats);
Vue.component('user-post-details',user_post_details);
Vue.component('chats-indicate',chats_indicate);



const router = new VueRouter({ 
    routes
});

const app = new Vue({
    router,
}).$mount('#app')










