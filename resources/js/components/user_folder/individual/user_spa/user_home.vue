<template>
    <div class="container">
        <div class="row">
          <div class="col-md-3"></div>
            <div class="col-md-6">
              <div class="mt-3">
                <div class="row mt-5">
                  <div class="col-md-12">
                         <div v-for="(item ,index) in time_line" v-bind:key="index">
                           <div class="card img-thumbnail mt-3 shadow-sm ">
			                      <div @click="modal_set('details' + index,0)" class="img_layer border">
                              <amplify-s3-image :imagePath= "'Photos/'+item.photo_path+'/'+item.file_name+'.png'">
                              </amplify-s3-image>
                            </div>
                                <div class="row row_margin_del_">
                               <div class="col-md-2">
                                 <span class="cover list_image" v-bind:style="{ backgroundImage: 'url(storage/' + item.icon_path + '.jpg)' }"></span>
                               </div>
                              <div class="col-md-6 d-flex align-items-center">
                                  <span class="pr-3">{{item.user_name}}</span>
                                  <span class="text-muted">@{{item.user_id}}</span>
                              </div>
                                 <p class="col-md-8" style="margin:0px;">{{date_disassembly_out[index][0]}}年{{date_disassembly_out[index][1]}}月{{date_disassembly_out[index][2]}}日</p> 
                            </div>
			                        <!-- <div class="card-body">
                                <h5 class="card-title">{{item.photo_name}}</h5>  
			                      </div> -->
                                <div class="bg-light">
                                      <div class="d-flex align-items-center"> 
                                        <div class="row w-100 row_margin_del_ pointer">
                                          <div class="col-6 border py-3 text-center btn_hover"  v-on:click.self="modal_set('details' + index,2)">
                                             <span @click="likes(item.photo_id,item.like_stauts)">
                                            <span v-if="item.like_stauts == 1"  width="16" height="16"><i class="fas fa-heart" style="color:red;"></i></span>
                                            <span v-if="item.like_stauts == 0" width="16" height="16"><i class="far fa-heart"></i></span>
                                            </span>  
                                            <span @click="modal_set('details' + index,2)">{{item.likes_cnt}}件</span>
                                           </div>
                                           <div class="col-6 border py-3 text-center btn_hover" @click="modal_set('details' + index,1)">
                                            <span><i class="far fa-comment"></i></span>
                                          </div>
                                       </div>
                                      </div>
                  

                            
                                 <user-post-details :photo_data="item" :my_data="my_data" :ref="'details' + index" v-on:likes-event="get_timeline_data"></user-post-details>
                                </div>
                            <div class="card_footer_  py-3 value_ row_margin_del_ pointer" @mouseenter="info_hover(index)" @mouseleave="info_leave(index,item.photo_price)" :id="'value_' + index" @click="modal_set('details' + index,0)">
                                ¥{{item.photo_price}}
                            </div>
		                      </div>
                        </div> 
                  </div>
                </div>
              </div> 
            </div>  
            <div class="col-md-3"></div> 
        </div>
 
    <div class="up_btn pointer"><i class="fas fa-file-upload fa-3x faa-float animated my-green shadow-lg" style="width:100%; height:100%" @click="openModal"></i></div>
      <MyModal id="main_modal" @close="closeModal" v-if="img_modal" class="border-0">
        <uploadmodal></uploadmodal>
      </MyModal>
     </div>
</template>


<style>

.card_footer_{
  margin:0;
  background:rgba(0,191,255,1);
  color:white;
  text-align: center;

  -webkit-transition: all 200ms ease;
  transition: all 200ms ease;
  
}

.img-thumbnail{
  padding:0 !important;
}
.amplify-image{
    height:400px !important;
    width:auto !important;
    max-width:100% !important;
    max-height:100% !important;
    margin:0 !important;
    pointer-events:none !important;
    object-fit: contain !important;
    border:none !important;
    border-radius:0px !important;

/*  default setting
    width:30%;
    margin:.2em;
    border-radius:6px;
    border:2px solid var(--color-white);
    cursor:pointer;*/
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
.value_{
   display:table;
   height:3em;
   font-weight: bold;
}
.value_ span{
    display:table-cell;
  vertical-align:middle;
}

.img_layer{
  width:auto !important;
  height:auto !important;
  background-color:#f8f9fa;
  
  display: table-cell !important; /*上下中央*/
  text-align: center !important; /*左右中央*/
  vertical-align: middle !important; /*上下中央*/

}
/* ===========================
 *投稿ボタン＆モーダル 
   ==========================*/

#main_modal .modal-window{
  position: absolute;
  text-align: center !important;
  width:80vw;
  max-width:420px;
  max-height:95%;
  overflow-y:scroll;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
}

.my-green{
  width:140%;
  height:80%;
  color:#f90;
  line-height: 2.3em;
  letter-spacing: 3px;
  text-align: center;
  border-radius: 35px;
  user-select:none;
  background-color: rgb(63,63,61);
}
.my-green:hover{

  background-color:rgb(63,63,61,0.9);
}

.up_btn{
  position: fixed;
  bottom: 7%;
  right: 10%;
  width:100px;
  height:100px;
	border-radius: 50%;/*角丸*/
}

</style>
<script>
import MyModal from '../../user_modal/user_modal.vue';
import Details from "../component/user_post_details.vue";
import { AmplifyEventBus } from 'aws-amplify-vue';
import { S3Image} from 'aws-amplify-vue';
import uploadmodal from '../../user_modal/upload_modal.vue';
window.Vue = require('vue');

 
export default{
  data(){
    return{
      my_data:[],
      time_line:[],
      time_line_cnt:0,
      date_disassembly_out:[],
      user_modal: false, //modal表示・非表示
      display_judg :0, 
      modai_title:"",
      likes_user:[],
      follows_string:"",
      follows_stauts:0,
      now_photo_id:'',
      user_post_details_:false,
      img_modal:false,
    }
  },components:{
        MyModal,Details,uploadmodal
    },mounted:function(){
      this.get_timeline_data();
      //   window.onresize = function() {
      //   var mwindow =document.getElementsByClassName("modal-window");
      //   var modal = mwindow[0];
      //   if(100>modal.children.clientHeight){
      //     modal.id='default';
      //   }else{
      //     modal.id='overflow';
      //   }
      //   console.log(modal.children.clientHeight);
      // };
  },methods:{
    get_timeline_data:function(){
      axios.get("api/users/chk").then(response => {
               if(typeof(response['data']) == "object"){
                 this.my_data = response['data'];
                axios.get("api/user/post_data/timeline/data").then(time_line_data => {
                   if(typeof(time_line_data['data']) == "object"){
                      this.time_line_cnt = this.time_line.length;
                      this.time_line = time_line_data['data'];
                      this.date_set();       
                    }
                    }).catch(function (error) {
                        console.log(error)
                    });
                    }
            }).catch(function (error) {
                console.log(error)
            });
    },date_set: function(){
          var date_disassembly =[];
          var date_synthesis = [];
          var date_bef = [];
          for(let j = 0; j < this.time_line.length; j++){
              date_bef[j] = this.time_line[j]['upload_date']
              date_disassembly[j] = date_bef[j].match(/\d{1,4}/g);
          }
          this.date_disassembly_out = date_disassembly;       
    },likes:function(photo_id,like_stauts,e){
      
        let params = new URLSearchParams();
        params.append('photo_id',photo_id);
        params.append('like_stauts',like_stauts);
        axios.post("api/user/post_data/timeline/data",params).then(response => {
        this.get_timeline_data();
        }).catch(function (error) {
          console.log(error);
        });
      
    },
 
    arr_chk(data){
     return typeof(data)=="undefined"? []:data;
    },  

    modal_set(ref,chat_or_img){
     //chatクリック=1
        this.$refs[ref][0].openModal(chat_or_img); 
    },
    openModal() {
      this.img_modal = true;
      $('html, body').css('overflow', 'hidden');
      event.preventDefault();
    },
    closeModal() {
      this.img_modal = false;
      $('html, body').css('overflow', 'auto');
    },
    info_leave(num,val){
      let cng_value_btn = document.getElementById('value_' + num);
      cng_value_btn.style.backgroundColor = "rgba(0,191,255,1)";
      
      cng_value_btn.textContent = "¥" + val;
      
      
    },
    info_hover(num){
      let cng_value_btn = document.getElementById('value_' + num);
      cng_value_btn.style.backgroundColor = "rgba(0,191,255,0.7)";
      cng_value_btn.textContent = "詳細";
    }

  }
}
</script>
