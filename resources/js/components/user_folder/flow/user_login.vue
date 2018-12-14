<!--
ユーザーログイン画面
-->

<template>
  <div class="user_login_main">
<div class="authentication_box border rounded shadow-lg">
<div class="my_state"></div>
    <div class="authentication_table">
    <form @submit.prevent="submitForm">
  <div class="form-group">
    <label >ユーザーID</label>
    <input type="text" class="form-control shadow-sm" v-model="userid">
  </div>
  <div class="form-group">
    <label>パスワード</label>
    <input type="password" class="form-control shadow-sm"  v-model="userpassword">
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
      userid:'',
      userpassword:'',
    }
  },
  methods: {
         submitForm: function () {
        let params = new URLSearchParams();
  params.append('userid',this.userid);
  params.append('userpassword',this.userpassword);
axios.post('login',params).then(response => {
    console.dir(response.config); 
   window.location.href="user";
}).catch(function (error) {
          console.log(error);
          alert('失敗');
        });
         }   
    },
}
</script>

<style>
.user_login_main{
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