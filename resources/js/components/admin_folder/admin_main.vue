<template>
 <!-- jumbotron・・・画面幅いっぱい -->
<div class="right">
  <div class="main_root shadow-sm border-bottom ">
    <!-- ex: Home / Dashboard -->
    HOME / Dashboard
  </div>
  
　<div class="main_display container">
  
  <router-view></router-view>
　</div> 
</div>

 
</template>

<script>

</script>

<style>
.right {
  flex-direction: column;/*メインコンテンツ内縦配置*/
  width: 85%;
  height: 100%;
  display: flex;
 
 
}
.main_root{
  
  background-color:white;
  padding:0.5em 1em 0.5em 1em;/*上右下左*/
 
}
.main_display{
  background:#eee;
  height:100%;
  padding:30px;
}

@media only screen and (max-width: 768px) {

.right{
  width:100%;
  height:100%;
}
}
</style>