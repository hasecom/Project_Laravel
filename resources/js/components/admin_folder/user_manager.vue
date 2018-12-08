<template>
  <div>
   <div class="txt_box border rounded">
    
  <div class="table-responsive">
         <table class="table table-hover">
            <tr>
                <th>ユーザ内部ID</th>
                <th>ユーザID</th>
               <th>ユーザパスワード</th>
                <th>電話番号</th>
            </tr>
            <tbody>
            <tr v-for="item in users" :key="item.id">
                <td v-text="item.id"></td>
                <td v-text="item.user_id"></td>
                  <td v-text="item.user_pw"></td>
                <td v-text="item.tel_num"></td>
               
            </tr>
            </tbody>
        </table>
    </div>
    </div>
  </div>
  
</template>

<script>
window.Vue = require('vue');

//親要素(main)からデータをpropsで取得
export default {
  name:"user_Data",
    props: {
      user_info_str: {
        type:String,
      }
      },
      data(){
    return{
     user_info:this.user_info_str,
     users:[]
    }
  },   
  methods: {
         get_users_info() {
           this.users = JSON.parse(this.user_info);
        }
    },
    mounted() {
        this.get_users_info();
    },
 //ライフサイクル   
//   created: function () {
// var admin_data = JSON.parse(this.admin_info);
   
//   }
    }
    


</script>

<style>

</style>