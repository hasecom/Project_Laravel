<!--
管理者ログイン画面
-->

<template>
  <div class="admin_login_main">
<div class="authentication_box border rounded shadow-lg">
<div class="my_state"></div>
    <div class="authentication_table">
    <form action="admin_top" method="POST">
      
  <div class="form-group" >
    <label >ユーザー名またはメールアドレス</label>
    <input type="text" class="form-control shadow-sm">
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