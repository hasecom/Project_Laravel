<template>
  <div>

   <div class="txt_box border rounded">
    
  <div class="table-responsive">
         <table class="table table-hover">
            <tr>
                <th>管理者内部ID</th>
                <th>管理者ID</th>
               <th>管理者パスワード</th>
                <th>管理者レベル</th>
            </tr>
            <tbody>
            <tr v-for="item in admins" :key="item.id">
                <td v-text="item.id"></td>
                <td v-text="item.admin_id"></td>
                  <td v-text="item.admin_pw"></td>
                <td v-text="item.admin_authority"></td>
               
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
  name:"Receive_Data",
    props: {
      admin_info_str: {
        type:String,
      }
      },
      data(){
    return{
     admin_info:this.admin_info_str,
     admins:[]
    }
  },   
  methods: {
         get_admins_info() {
           this.admins = JSON.parse(this.admin_info);
        }
    },
    mounted() {
        this.get_admins_info();
    },
 //ライフサイクル   
//   created: function () {
// var admin_data = JSON.parse(this.admin_info);
   
//   }
    }
    


</script>

<style>
</style>