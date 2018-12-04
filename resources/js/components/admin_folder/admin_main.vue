<template>
 <!-- jumbotron・・・画面幅いっぱい -->
<div class="right">
  <div class="main_root shadow-sm border-bottom ">
    <!-- ex: Home / Dashboard -->
    HOME / Dashboard
  </div>
  
　<div class="main_display">
  <router-view  :message="message"></router-view>
　</div> 
<p>{{test}}</p>
</div>

 
</template>

<script>
import Child from './admin_manager.vue';

export default{
props:{
test:String,
},
components: {
        Child
    },
     data() {
        return {
            message:"aa"
        }
}

}

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
  width:100%;
  margin:0;
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