<!--
ユーザーログイン画面
-->

<template>
  <div>
    <div class="fixed-top bg-light">
      <router-link to="/" >
        <h2>TITLE</h2>
      </router-link>
      <search-input></search-input>
      <nav class="navbar navbar-expand-md navbar-light bg-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav4" aria-controls="navbarNav4" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-around" id="navbarNav4">
          <ul class="navbar-nav">
            <li class="nav-item active">
              <router-link to="/" >
                <a>ホーム</a>
              </router-link>
            </li>
         </ul>
    <ul class="navbar-nav">
      <li class="nav-item">
        <router-link to="/mypage" >
          <a>マイページ</a>
        </router-link>
      </li>
    </ul>
       <ul class="navbar-nav">
      <li class="nav-item">
        <router-link  to="/search">
         <a>検索</a>
        </router-link>
      </li>
    </ul>
    <ul class="navbar-nav">
      <li class="nav-item">
        <router-link  to="/post_image">
          <a>投稿</a>
        </router-link>
      </li>
    </ul>
    <ul class="navbar-nav">
      <li class="nav-item">
         <router-link  to="/recruit_image" class="spa_link">
          <a>募集</a>
         </router-link>
      </li>
    </ul>
  </div>
</nav>
</div>
      
 <div class="margin-bottom"></div>
<!-- サンプル -->
<div class="border">
  <router-view></router-view>
</div>
  </div>
</template>

<script>
export default {
data(){
  return{
    user_id:"1"
  }
}

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
.margin-bottom{
  height:100px;
}


</style>