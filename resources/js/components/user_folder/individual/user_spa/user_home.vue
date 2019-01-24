<template>
    <div class="container">
        <div class="row">
          <div class="col-md-3"></div>
            <div class="col-6">
              <div class="mt-3">
                <div class="row mt-5">
                  <div class="col-md-12">
                         <div v-for="(item ,index) in time_line" v-bind:key="index">
                           <div class="card img-thumbnail mt-3 shadow-sm">
			                      <div @click="modal_set('details' + index,0)"  width="100%" height="300">
                              <amplify-s3-image :imagePath= "item.photo_path+'/'+item.file_name+'.png'">
                              </amplify-s3-image>
                            </div>
                                <div class="row">
                               <div class="col-md-1">
                                 <span class="cover list_image" v-bind:style="{ backgroundImage: 'url(storage/' + item.icon_path + '.jpg)' }"></span>
                               </div>
                              <div class="col-md-10">
                                <span>{{item.user_name}}</span>
                                <span class="text-muted">@{{item.user_id}}</span>
                              </div>
                            </div>
			                        <div class="card-body">
                                <h5 class="card-title">{{item.photo_name}}</h5>  
			                      </div>
                                <div class="bg-light">
                                      <div class="d-flex align-items-center"> 
                                        <div class="row w-100 row_margin_del_">
                                          <div class="col-md-6 border py-3 text-center">
                                             <span @click="likes(item.photo_id,item.like_stauts)">
                                            <span v-if="item.like_stauts == 1"  width="16" height="16"><i class="fas fa-heart" style="color:red;"></i></span>
                                            <span v-if="item.like_stauts == 0" width="16" height="16"><i class="far fa-heart"></i></span>
                                            </span>  
                                            <span @click="modal_set('details' + index,2)">{{item.likes_cnt}}件</span>
                                           </div>
                                           <div class="col-md-6 border py-3 text-center">
                                            <span @click="modal_set('details' + index,1)"><i class="far fa-comment"></i></span>
                                          </div>
                                       </div>
                                      </div>
                  

                               
                                 <user-post-details :photo_data="item" :my_data="my_data" :ref="'details' + index" v-on:likes-event="get_timeline_data"></user-post-details>
                                </div>
                            <div class="row bg-info card_footer_  py-3">
                                <p class="col-md-8">{{date_disassembly_out[index][0]}}年{{date_disassembly_out[index][1]}}月{{date_disassembly_out[index][2]}}日</p>
                                <p class="col-md-3 text-white bg-primary rounded">¥{{item.photo_price}}</p>   
                            </div>
		                      </div>
                        </div> 
                  </div>
                </div>
              </div> 
            </div>  
            <div class="col-md-3"></div> 
        </div>
 
       
     </div>
</template>


<style>
.card_footer_{
  margin:0;
}
.row_margin_del_{
  margin:0;
}
.img-thumbnail{
  padding:0 !important;
}
.amplify-image{
    width:100% !important;
    height:auto;
    margin:0 !important;
    pointer-events: none !important;
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
import Details from "../component/user_post_details.vue";
import { AmplifyEventBus } from 'aws-amplify-vue';
import { S3Image} from 'aws-amplify-vue';
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
      user_post_details_:false
    }
  },components:{
        MyModal,Details
    },mounted:function(){
      this.get_timeline_data();
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
    },likes:function(photo_id,like_stauts){
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
  }
}
</script>
