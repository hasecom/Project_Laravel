<!--
管理者画面のサイドメニュー
・SPA使用
-->
<template>
  <div class="side_bar shadow-lg">

<nav class="navbar-expand-md navbar-light">
  <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#Navber" aria-controls="Navber" aria-expanded="false" aria-label="ナビゲーションの切替">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse switch_nav" id="Navber">
 
   

 <div class="dashboard shadow-sm" tag="li">
      <i class="fas fa-tachometer-alt"></i>　Dashboard
    </div>
    <div class="sider_bar_menu">
       <router-link tag="li" to="/admin_manager" class="spa_link">
      <a>管理者操作</a>
      </router-link>
      <router-link tag="li" to="/user_manager" class="spa_link">
      <a>ユーザ管理</a>
      </router-link>
      </div>

    
  </div>
</nav> 


  </div>
  
</template>

<script>

</script>

<style>

.side_bar {
  display: flex;
  flex-direction: column;/*サイドバー内縦配置*/
  width: 15%;
  height: 100%;
  background:rgb(41,48,52);
  color:white;
  position: sticky; top: 10px; 
}
.nav_custom{
  height:100%;
}
.switch_nav{
  flex-direction: column;/*サイドバー内縦配置*/
}
.dashboard{
  background:rgb(50,58,63);
  padding:0.5em 1em 0.5em 1em;/*上右下左*/
  text-align: center;
  font-weight: bold;
  width:100%;
}
.sider_bar_menu{
  padding:1rem;
}
.spa_link{
  padding:0.5rem;
}
.spa_link a{
  color:white;
}
li{
  list-style: none;
}
@media only screen and (max-width: 768px) {

.side_bar {
  display: flex;
  width:100%;
  height:auto;
  background:rgb(41,48,52);
  color:white;
  position: sticky; top: 10px; 
}

}
</style>