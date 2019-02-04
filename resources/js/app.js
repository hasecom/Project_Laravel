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
import likes_list from './components/user_folder/individual/component/likes_list.vue';
import search_input from './components/user_folder/individual/component/search_input.vue';
import account_manager from './components/user_folder/individual/component/account_manager.vue';
import set_profile from './components/user_folder/individual/component/set_profile.vue';
import set_pass from './components/user_folder/individual/component/set_pass.vue';
import set_privacy from './components/user_folder/individual/component/set_privacy.vue';
import footer from './components/user_folder/individual/component/footer.vue';
import front_main from './components/user_folder/individual/component/front_main.vue';
import detailed_item from './components/user_folder/individual/component/detailed_item.vue';
import charge_point from './components/user_folder/individual/component/charge_point.vue';
import set_icons from './components/user_folder/individual/component/set_icons.vue';
import post_delete from './components/user_folder/individual/component/post_delete.vue';
import img_buy from './components/user_folder/individual/component/img_buy.vue';


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
Vue.component('likes-list',likes_list);
Vue.component('search-input',search_input);
Vue.component('account-manager',account_manager);
Vue.component('set-profile',set_profile);
Vue.component('set-pass',set_pass);
Vue.component('set-privacy',set_privacy);
Vue.component('charge-point',charge_point);
Vue.component('set-icons',set_icons);
Vue.component('vue-footer',footer);
Vue.component('front-main',front_main);
Vue.component('detailed-item',detailed_item);
Vue.component('post-delete',post_delete);
Vue.component('img-buy',img_buy);


//*aws amplify
import Amplify, * as AmplifyModules from 'aws-amplify';
import { AmplifyPlugin } from 'aws-amplify-vue';
import aws_exports from '../../src/aws-exports';
Amplify.configure(aws_exports)

Vue.use(AmplifyPlugin, AmplifyModules);



const router = new VueRouter({ 
    routes
});

const app = new Vue({
    router,
}).$mount('#app')










