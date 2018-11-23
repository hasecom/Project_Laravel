<template>
  <div class="side_bar">
      
    <router-link tag="li" to="/admin_manager" class="spa_link">
      <a>管理者操作</a>
    </router-link>
    <router-link tag="li" to="/user_manager" class="spa_link">
      <a>ユーザ管理</a>
    </router-link>
  </div>
</template>

<script>
</script>

<style>
.side_bar {
  float: left;
  width: 30%;
  height: 500vh;
  background-color:rgb(50,54,58);
  color:white;
  position: sticky; top: 10px; 
  min-height: 100%;
height: auto !important;
height: 100%;

}
.spa_link a{
  color:white;
}
li{
  list-style: none;
}

</style>