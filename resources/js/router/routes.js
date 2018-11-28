//SPA(routerの処理)
//管理者
import admin_manager from '../components/admin_folder/admin_manager.vue';
import user_manager from '../components/admin_folder/user_manager.vue';
import news_manager from '../components/admin_folder/news_manager.vue';


//ユーザ
import sign_up from '../components/user_folder/flow/sign_up.vue';
import sign_up2 from '../components/user_folder/flow/sign_up2.vue';

export default [
{ path: '/admin_manager', component:admin_manager },
{ path: '/user_manager', component:user_manager },
{ path: '/news_manager', component:news_manager },
{ path: '/registration', component:sign_up },
{ path: '/sms_confirmation', component:sign_up2 },

];