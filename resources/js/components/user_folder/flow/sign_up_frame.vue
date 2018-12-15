<!--
ユーザ新規登録画面(フレーム)
-->

<template>
<div>
  <router-view :chk_userid_send="chk_userid_send" :chk_useremail_send="chk_useremail_send"></router-view>

</div>
</template>

<script>
import sign_up from './sign_up.vue';
import sign_up2 from './sign_up2.vue';

export default{
  props:{
    chk_userid: {
        type:String,
      },
    chk_useremail:{
        type:String,
    },
    temp_user_data:{
        type:Array,
    }
    },
    components: {
        sign_up,
        sign_up2
    },
     data(){
        return {
            chk_userid_send:this.chk_userid,
            chk_useremail_send:this.chk_useremail,
        }
},
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


</style>