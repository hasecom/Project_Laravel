<template>
 <!-- jumbotron・・・画面幅いっぱい -->
<div class="right">
  <div class="main_root shadow-sm border-bottom ">
    <!-- ex: Home / Dashboard -->
    HOME / Dashboard
  </div>

　<div class="main_display">
  <!-- :XXX="YYY"で子要素にデータを送る -->
  <router-view  :admin_info_str="admin_info_str"  :user_info_str="user_info_str"></router-view>
　</div> 

</div>

</template>

<script>
import admin_manager from './admin_manager.vue';
import user_manager from './user_manager.vue';

/*
props->親要素からデータを受け取り
componets->データを送りたい子要素ファイル(importしたもの)
data() return ->子要素にデータを送る(自分自身のデータを送るのでthis.XXXとする)
*/
export default{
  props:{
      admin_manager: {
        type: String,
      },
      user_manager:{
        type:String
      }
    },
components: {
        admin_manager,
        user_manager
    },
     data(){
        return {
            admin_info_str:this.admin_manager,
            user_info_str:this.user_manager
        }
},
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
.txt_box{
 margin-top:1em;
  background:white;
  padding:10px 15px 10px 15px;
}

@media only screen and (max-width: 768px) {

.right{
  width:100%;
  height:100%;
}
}
</style>