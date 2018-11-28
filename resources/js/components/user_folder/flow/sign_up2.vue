<!--
ユーザ新規登録画面
-->

<template>
  <div class="user_sign_up_main">
<div class="authentication_box border rounded shadow-lg">


    <div class="authentication_table">
    <form>
  <div class="form-group">
    <label >携帯電話の番号</label>
    <input type="tel" class="form-control shadow-sm">
  </div>

 

  <button type="submit" class="btn btn-primary">SMSに送信する</button>
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