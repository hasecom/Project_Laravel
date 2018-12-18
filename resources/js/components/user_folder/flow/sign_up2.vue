<!--
ユーザ新規登録画面
-->

<template>
  <div class="user_sign_up_main">
<div class="authentication_box border rounded shadow-lg">
  <p>
    {{temporary_registration_display}}
  </p>

</div>
  </div>
</template>

<script>
export default {

  name: 'user-sign_up2',
  props:{
    chk_userid_send: {
        type: String,
      },
    chk_useremail_send: {
        type: String,
      },

  
  },
  //TODO:sign_up2で渡されたチェッカーたちをメソッドで返す？sign_up.vueでよいのか
  
  data(){
    return{
      chk_userid:this.chk_userid_send,
      chk_useremail:this.chk_useremail_send,
      temporary_registration_display:"",
  
       }
  },created : function(){

    //*props扱えるのcreatedらしいぜよ
    //TODO:sign_up1へIDが被っているのかメールが不正or被っているかを返す
    if(this.chk_userid_send == "1" || this.chk_useremail_send == "1"){
       window.location.href="sign_up#/registration";
    }else{
      axios.post('sign_up').then(response => {
  
       if(response['data']['status'] == true){//コントローラーからのレスポンスデータ
          this.temporary_registration_display += '下記のメールアドレスに登録用URLを記載したメールを送信しました。\n';
          this.temporary_registration_display +=  response['data']['email'] + '\n\n';
          this.temporary_registration_display += '登録用URLにアクセスさせて登録確認を完了してください。';
          
       }
 
}).catch(function (error) {
          console.log(error);
        });
    
    }
  }
}
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

p{
  white-space: pre;
  text-align: center;
}


</style>