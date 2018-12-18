<!--
ユーザ新規登録画面
-->

<template>
  <div class="user_sign_up_main">
<div class="authentication_box border rounded shadow-lg">

<div class="my_state"></div>
    <div class="authentication_table">
    <form @submit="submitForm">
  <div class="form-group">
    <label >ニックネーム</label>
    <input type="text" class="form-control shadow-sm "  v-model="user_name">
  </div>

   <div class="form-group">
    <label >ユーザーID</label>
    <input type="text" class="form-control shadow-sm"  v-model="user_id">
  </div>

  <div class="form-group">
    <label >メールアドレス</label>
    <input type="email" class="form-control shadow-sm"  v-model="user_email">
  </div>

  <div class="form-group">
    <label>パスワード</label>
    <input type="password" class="form-control shadow-sm"  v-model="user_pass">
  </div>

    <div class="form-group">
    <label>パスワード(確認)</label>
    <input type="password" class="form-control shadow-sm"  v-model="user_pass_chk">
  </div>

<button type="submit" class="btn btn-primary">次へ</button>

</form>
</div>

</div>
  </div>
</template>

<script>
import Vue from 'vue'
import axios from 'axios'
Vue.$http = axios;

export default {

  name: 'user-sign_up',
  props:{
    chk_userid_send: {
        type: String,
      },
    chk_useremail_send: {
        type: String,
      },

 
  },
  data(){//return内にテンプuser__情報ニュ力
    return{
      user_name:'',
      user_id:'',
      user_email:'',
      user_pass:'',
      user_pass_chk:'',
      chk_userid:this.chk_userid_send,
      chk_useremail:this.chk_useremail_send,
    }
  },
  methods: {
              submitForm: function () {
              if(this.user_name !="" && this.user_id != "" && this.user_email != "" && this.user_pass != "")
              {
        let params = new URLSearchParams();
           params.append('username',this.user_name);
           params.append('userid',this.user_id);
           params.append('useremail',this.user_email);
           params.append('userpassword',this.user_pass);
            axios.post('sign_up',params).then(response => {
               console.dir(response.config); 
               window.location.href="sign_up#/redirect";
            }).catch(function (error) {
               console.log(error);
              alert('失敗');
            });
              }
         } 
    },
}
</script>

<style>
.user_sign_up_main{
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