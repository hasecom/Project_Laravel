<!--
ユーザ新規登録画面
-->

<template>
  <div class="user_sign_up_main">
<div class="authentication_box border rounded shadow-lg">

<div class="my_state"></div>
    <div class="authentication_table">
    <form>
  <div class="form-group">
    <label >ニックネーム</label>
    <input type="text" class="form-control shadow-sm">
  </div>

   <div class="form-group">
    <label >ユーザーID</label>
    <input type="text" class="form-control shadow-sm">
  </div>

  <div class="form-group">
    <label >メールアドレス</label>
    <input type="email" class="form-control shadow-sm">
  </div>

  <div class="form-group">
    <label>パスワード</label>
    <input type="password" class="form-control shadow-sm">
  </div>

    <div class="form-group">
    <label>パスワード(確認)</label>
    <input type="password" class="form-control shadow-sm">
  </div>


 <router-link to="/sms_confirmation" class="btn btn-primary">
      <a>次へ</a>
      </router-link>

</form>

</div>
</div>
  </div>
</template>

<script>

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