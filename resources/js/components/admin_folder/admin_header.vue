<!--
管理者画面のヘッダー
-->

<template>
 <!-- jumbotron・・・画面幅いっぱい -->
<div class="border-bottom header">
　<div class="container">
    <!-- タイトル -->
　　<h1>Administrator</h1>
<p>{{test}}</p>
　</div> 
</div>

 
</template>

<script>
export default{
props:{
test:String,
},

}
</script>

<style>
.header{
    background:rgba(238,238,238,0.2);
    margin:0;
    border-color:rgba(0,0,0,0.2);
    padding:5px;
  
}
</style>