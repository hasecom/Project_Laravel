<template>
  <div>
Admin Manager です。<br>
<br>
 
         <table border="1">
            <tr>
                <td>管理者ID</td>
                <td>管理者レベル</td>
            </tr>
            <tr v-for="item in admins" :key="item.id">
                <td v-text="item.admin_id"></td>
                <td v-text="item.admin_authority"></td>
            </tr>
        </table>
 
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
           console.table(this.admins);
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