import routes from './router/routes.js';
import side_bar from './components/admin_folder/admin_side_bar.vue';

require('./bootstrap');
window.Vue = require('vue');
import VueRouter from 'vue-router'
Vue.use(VueRouter)


const router = new VueRouter({ 
    routes
});

const app = new Vue({
    router,
}).$mount('#app')



// root インスタンスを作成する
new Vue({
  el: '#side_bar',
  components: { side_bar },
  template: '<side_bar></side_bar>'
})