<!--
ユーザーログイン画面
-->

<template>
  <div>
サンプルのユーザートップページ
     <router-link tag="li" to="/mypage" >
      <a>マイページ</a>
      </router-link>
      <router-link tag="li" to="/post_image">
      <a>画像投稿</a>
      </router-link>
      <router-link tag="li" to="/recruit_image" class="spa_link">
      <a>画像募集</a>
      </router-link>
        <router-link tag="li" to="/search">
      <a>検索</a>
      </router-link>
<!-- サンプル -->
<div class="border">
  <router-view></router-view>
</div>
  </div>
</template>

<script>

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