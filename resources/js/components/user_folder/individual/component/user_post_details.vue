<template>
    <div> 
        <button @click="openModal"></button>
    <MyModal @close="closeModal" v-if="user_modal" class="border-0" >
               <div class="row justify-content-center mt-3 border-bottom">             
                    <div class="modal_display mx-sm-5">    <button @click="closeModal">aaaaaa</button>
                                    <div class="card img-thumbnail mt-3 shadow-sm">
                             <div class="row">
                              <div class="col-md-4">{{photo_data.user_name}}</div>
                              <div class="col-md-4 text-muted">@{{photo_data.user_id}}</div>
                              </div>
			                        <svg class="bd-placeholder-img card-img-top" width="100%" height="300" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: カードの画像"><title>プレースホルダ</title><rect fill="#868e96" width="100%" height="100%"></rect><text fill="#dee2e6" dy=".3em" x="30%" y="50%">no image</text></svg>
			                        <div class="card-body px-2 py-3">
                                <h5 class="card-title">{{photo_data.photo_name}}</h5>  
                                <p>
                                  <span @click="likes(photo_data.photo_id,photo_data.like_stauts)">
                                    <img v-if="photo_data.like_stauts == 1" src="storage/like.svg" width="16" height="16">
                                    <img v-if="photo_data.like_stauts == 0" src="storage/like_emp.svg" width="16" height="16">
                                     </span>   
                                    <span @click="get_likes_user_data(0,photo_data.photo_id)">{{photo_data.likes_cnt}}件</span>
                                  <chats :photo_data="photo_data" :my_data="my_data"></chats>
                                </p>
                                 <user-post-details :photo_data="photo_data" :my_data="my_data"></user-post-details>
                                <p class="card-text text-muted text-center">{{photo_data.photo_description}}</p>
			                      </div>
                            <div class="row">
                               
                                <p class="col-md-3 text-white bg-primary rounded">¥{{photo_data.photo_price}}</p>   
                            </div>
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
.modal-window{
    width:60%;
    height:70%;
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
window.Vue = require('vue');


export default{
    props:{
    photo_data: {
        type:Object,
      },
    my_data:{
        type:Object
    }
    },
    data(){
        return{ 
            user_modal :false,     
        }
        },components:{
        MyModal
    }, 
      methods:{  
        openModal() {
      this.user_modal = true;
    },
    closeModal() {
      this.user_modal = false;
    }
      }
}
</script>
