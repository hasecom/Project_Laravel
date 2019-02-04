<template>
    <div>
      <i class="fas fa-ellipsis-h text-muted pointer"  @click='dot_click' ></i>
         <MyModal @close="closeModal" v-if="user_modal" class="border-0"> 
       <div class="set_modal shadow-lg" v-if="wherePage == 0">
        <div>
            <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link" @click="Post_Delete" v-if="isPrincipal"  id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">投稿を削除</a>
                <a class="nav-link" id="v-pills-profile-tab" data-toggle="pill" href="#v-pills-profile" role="tab" aria-controls="v-pills-profile" aria-selected="false">シェア</a>
                <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">投稿を報告</a>
            </div>
       </div>
        </div>
         <div class="set_modal" v-if="wherePage == 1">
        <div>
                <form class="text-center p-3" @submit.prevent="deleteForm" >
               <p>この投稿を削除しますか？</p>
               <button type="submit" class="btn btn-danger" >削除</button> 
               <button type="button" @click="closeModal()" class="btn btn-default border">キャンセル</button>
        </form>
       </div>
        </div>

        </MyModal>
    </div>
</template>

<script>
import MyModal from '../../user_modal/user_modal.vue';
window.Vue = require('vue');
export default{
    props:{
        photo_data:{
            type:Object
        },
        my_data:{
            type:Object
        }

    },
    data(){
        return{
            isSet:false,
            user_modal: false, //modal表示・非表示
            isPrincipal:false,
            wherePage:0
        }
    },components:{
        MyModal
    },
    methods:{
        dot_click(){
            this.Principal_chk();
            this.openModal();
        },
        openModal(){         
      this.user_modal = true;
      
    },
        closeModal() {
      this.user_modal = false;
      this.wherePage = 0;
    },Principal_chk(){
      const post_user_id = this.photo_data.id;
      const user_id = this.my_data.id;
      if(post_user_id == user_id ||this.photo_data.user_id == user_id ){
            this.isPrincipal = true;
      }
      return true;
    },Post_Delete(){
         this.wherePage = 1;
    },deleteForm(){
        let params = new URLSearchParams();
        params.append('photo_id',this.photo_data.photo_id);
        params.append('photo_tag',this.photo_data.tag);
        params.append('likes_id',this.photo_data.like_id);
        params.append('user_id',this.photo_data.id);
        axios.post('api/user/post_data/delete/' + this.photo_data.photo_id,params).then(response => {
        if(this.$parent.$route.fullPath == "/"){
            //this.$parent.get_timeline_data();
            //回避
        }
        this.closeModal();
        location.reload();
}).catch(function (error) {
          console.log(error);
        });
    }
    }
}
</script>
<style>
#post_set{
    position: absolute;
    z-index: 500;
    top:50;

}
.cover{
    display: inline-block;
    background-color: #ccc;
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    border-radius: 50%;
}

.modal_display{
  background:white;
  padding:50px 20px;
}
.list_image{
    width:30px;
    height:30px;
}
.set_modal{
   min-width:300px;
}
</style>