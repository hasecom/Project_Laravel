<!--
管理者画面のヘッダー
-->

<template>
 <!-- jumbotron・・・画面幅いっぱい -->
<div class="border-bottom header">
　<div class="container">
    <!-- タイトル -->
    <div >
　　<h1>Administrator</h1>
</div>
<div class="text-right">
{{login_user}}さんようこそ<br>
<logout-box></logout-box>

</div>

　</div> 
</div>

 
</template>

<script>

export default{
name:"header_info",
 props:{
      login_user: {
        type: String,
      },
      data:{
return(){

}
      },
}
}

Vue.component('logout-box', {
    data(){
        return{
            logout:true,
        }
    },
methods:{
   logout_user(){
let params = new URLSearchParams();
params.append('status',this.logout);
axios.post('admin',params).then(response => {
    location.reload();
}).catch(function (error) {
          console.log(error);
        });
     }
  },
  template: '<button type="button" class="btn-sm btn-default border" @click="logout_user()">ログアウト</button>'
})
</script>

<style>
.header{
    background:rgba(238,238,238,0.2);
    margin:0;
    border-color:rgba(0,0,0,0.2);
    padding:5px;
  
}
</style>