<!--
管理者ログイン画面
-->

<template>
  <div class="admin_login_main">
    
<div class="authentication_box border rounded shadow-lg">
<div class="my_state"></div>
    <div class="authentication_table">
    <form action="" @submit.prevent="submitForm">
      
  <div id="form-group-id" class="form-group" >
    <label >ユーザー名</label>
    <input v-model="username"  class="form-control shadow-sm" type="text">
  </div>
  <div class="form-group">
    <label>パスワード</label>
    <input v-model="userpassword" type="password" class="form-control shadow-sm">
  </div>
  <div class="form-group form-check">
    <input type="checkbox" class="form-check-input">
    <label class="form-check-label">ログイン状態を保存する</label>
  </div>
   
  <button type="submit" class="btn btn-primary">ログイン</button>
</form>
</div>
</div>

  </div>
</template>
<script>
/*
v-model->data()

v-on:exと指定->mehods内でex:function(){}とできる
(post送信される前にjsで判定する)
*/

import Vue from 'vue'
import axios from 'axios'
Vue.$http = axios;

export default {
  name: 'user-login',
  data(){
    return{
      username:'',
      userpassword:'',
    }
  },
  methods: {
         submitForm: function () {
        console.log('submitting message...');
        let params = new URLSearchParams();
        const sample = { username :this.username,userpassword :this.userpassword};

  params.append('sample', this.username);

       
axios.post('admin',params).then(response => {
    console.dir(response.config);  
}).catch(function (error) {
          console.log(error);
          alert('失敗');
        });
      },

  }
}
 
   

</script>

<style>
.admin_login_main{
    background:rgb(241,241,241);
    display: table;
    margin:auto;
    

}

.authentication_box{
    background:white;
    width:60%;
    padding:3rem 2rem;
   display:table-cell;
    vertical-align: middle;
    }


</style>