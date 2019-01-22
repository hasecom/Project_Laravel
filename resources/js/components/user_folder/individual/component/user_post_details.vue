<template>
    <div>
        <MyModal @close="closeModal" v-if="user_modal" class="border-0" >          
                    <div class="modal_display">
                        <div class="row">
                            <div class="col-md-5">
                              <div>{{photo_data.user_name}}&emsp;&emsp;<span class="text-muted">@{{photo_data.user_id}}</span></div>
			                    <amplify-s3-image style="pointer-events: none;" :imagePath= "photo_data.photo_path+'/'+photo_data.file_name+'.png'" ></amplify-s3-image>
                                    <!--<svg class="bd-placeholder-img card-img-top" width="100%" height="300" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: カードの画像"><title>プレースホルダ</title><rect fill="#868e96" width="100%" height="100%"></rect><text fill="#dee2e6" dy=".3em" x="30%" y="50%">no image</text></svg>-->
			                        <div class="card-body px-2 py-3">
                                         <h5 class="card-title d-inline">{{photo_data.photo_name}}</h5> &emsp;&emsp;
                                            <h5 class="text-white bg-primary rounded px-md-3 d-inline">¥{{photo_data.photo_price}}</h5>    
                                        <p>
                                            <span @click="likes(photo_data.photo_id,photo_data.like_stauts)">
                                            <img v-if="photo_data.like_stauts == 1" src="storage/like.svg" width="16" height="16">
                                         <img v-if="photo_data.like_stauts == 0" src="storage/like_emp.svg" width="16" height="16">
                                           </span>   
                                          <span @click="tab_select(2)">{{photo_data.likes_cnt}}件</span>
                                         </p>
                                 <user-post-details :photo_data="photo_data" :my_data="my_data"></user-post-details>
                                <p class="card-text text-muted text-center">{{photo_data.photo_description}}</p>
			                      </div>
                            
                               
                               
                           
		                      </div>
                        <div class="col-md-7">
                            <!-- DDDDDDDDDDDDDDDDDDDDDDDDDDDDD -->
                            <ul id="myTab" class="nav nav-tabs" role="tablist">
                                <li class="nav-item">
                                    <a href="#home" id="home-tab" class="nav-link" role="tab" :class="[isActive == 0 ?'active':'']" data-toggle="pill" aria-controls="home" aria-selected="true">詳細</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#comment" id="comment-tab" class="nav-link" :class="[isActive == 1 ?'active':'']" role="tab" data-toggle="pill" aria-controls="comment" aria-selected="false">コメント</a>
                                </li>
                                <li class="nav-item">
                                    <a href="#likes" id="likes-tab" class="nav-link"  :class="[isActive == 2 ?'active':'']" role="tab" data-toggle="pill" aria-controls="likes" aria-selected="false">いいね</a>
                                </li>
                            </ul>

<!-- パネル部分 -->
<div id="myTabContent" class="tab-content mt-3">
  <div id="home" class="tab-pane" :class="[isActive == 0 ?'active':'']"  role="tabpanel" aria-labelledby="home-tab">ホームの文章です。...</div>
  <div id="comment" class="tab-pane" :class="[isActive == 1 ?'active':'']" role="tabpanel" aria-labelledby="comment-tab"><chats-indicate :chats="photo_data['photo_id']" ref="chatsget"></chats-indicate></div>
  <div id="likes" class="tab-pane"  :class="[isActive == 2 ?'active':'']" role="tabpanel" aria-labelledby="likes-tab"><likes-list :photo_data_box="photo_data" :my_data="my_data" v-on:chats-event="likesMethod" ref="likes_child"></likes-list></div>
</div>
<chats :photo_data="photo_data" :my_data="my_data" :foucs_flg="chat_flg_send" v-on:chats-event="parentsMethod" ></chats>
 
   
                            <!-- DDDDDDDDDDDDDDDDDDDDDDDDDDDDD -->
                        </div>
                        </div>
                         
                    </div>
        </MyModal>
    </div>
</template>
<style>
/* body{
  overflow: hidden;
} */
.tab-content{
    overflow-y:scroll;
    overflow-x: hidden;
    height:400px;
}
:root{
    --width-size:auto;
    --height-size:auto;
}

.modal-window{
    background: var(--base-color);
    width:var(--width-size);
    overflow:scroll;
}
.profile_icon{
    width: 150px;
    height: 150px;
}
.cover{
    display: inline-block;
    background-color: #ccc;
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    border-radius: 50%;
}
.card-title{
    display:block;
}
.modal_display{
  background:white;
  padding:50px 20px;
}
.list_image{
    width:30px;
    height:30px;
}
</style>
<script>

import MyModal from '../../user_modal/user_modal.vue';
import Chat_Set from '../component/chats.vue';


window.Vue = require('vue');


export default{
    props:{
    photo_data: {
        type:Object,
      },
    my_data:{
        type:Object
    },
    },
    data(){
        return{ 
            user_modal :false,
            chat_flg_send:0, 
            isActive:0
        }
        },components:{
        MyModal
    },watch: {

}, 
      methods:{  
        openModal(select_num) {
        var body = document.getElementsByTagName('body')[0];
        body.style.overflow="hidden";
        this.user_modal = true;
        document.documentElement.style.setProperty('--width-size', '80%');
        document.documentElement.style.setProperty('--height-size', '80%');
    this.tab_select(select_num);
    },tab_select(select_num){
   if(select_num == 0){
            this.chat_flg_send = 0;
            this.isActive = 0;
        }else if(select_num == 1){//chat
            this.chat_flg_send = 1;
            this.isActive = 1;
        }else{//いいね
            this.chat_flg_send = 2;
            this.isActive = 2;
        }
    },
    closeModal() {
        var body = document.getElementsByTagName('body')[0];
        body.style.overflow="scroll";
        this.user_modal = false;
        this.chat_flg_send = 0;
        this.isActive = 0;
        var modal_return= setTimeout(function(){
        document.documentElement.style.setProperty('--width-size', 'auto');
        document.documentElement.style.setProperty('--height-size', 'auto');
        },300);
    },likes:function(photo_id,like_stauts){
        let params = new URLSearchParams();
        params.append('photo_id',photo_id);
        params.append('like_stauts',like_stauts);
        axios.post("api/user/post_data/timeline/data",params).then(response => {
         this.$emit('likes-event');
         this.$refs.likes_child.get_likes_user_data(0,photo_id);
        }).catch(function (error) {
          console.log(error);
        });
      
    },
    parentsMethod(){
         this.$refs.chatsget.chat_update();
    },
    likesMethod(){
        this.closeModal();
    }
      }
}
</script>
