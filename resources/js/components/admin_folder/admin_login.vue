<!--
管理者ログイン画面
-->

<template>
  <div class="admin_login_main">

<div class="authentication_box border rounded shadow-lg">
<div class="my_state"></div>
    <div class="authentication_table">
    <form>
  <div class="form-group">
    <label >ユーザー名またはメールアドレス</label>
    <input type="email" class="form-control shadow-sm">
  </div>
  <div class="form-group">
    <label>パスワード</label>
    <input type="password" class="form-control shadow-sm">
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

</script>

<style>
.admin_login_main{
    background:rgb(241,241,241);
    height:100%;
    position:absolute;
    width:100%;
}

.authentication_box{
    position:absolute;
    top:50%;
    width:50%;
    left:25%;
    background:white;
    padding:3rem 2rem;
    vertical-align: middle;
    margin:0 auto;
    }


</style>