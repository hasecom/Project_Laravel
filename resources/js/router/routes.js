//SPA(routerの処理)

import admin_manager from '../components/admin_folder/admin_manager.vue';
import user_manager from '../components/admin_folder/user_manager.vue';

export default [
{ path: '/admin_manager', component:admin_manager },
{ path: '/user_manager', component:user_manager },

];