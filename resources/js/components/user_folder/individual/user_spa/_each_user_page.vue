<template>
    <div>
        <div class="container">
            <div class="row">
              <div class="col-md-3"></div>
                 <div class="col-md-6">
                     <div class="mt-3">
                             <div class="card-body row align-items-center">
                                <span class="profile_icon cover ml-5" v-bind:style="{ backgroundImage: 'url(storage/' + each_user_data.icon_path + '.jpg)' }"></span>
                                 <h4 class="card-title ml-5">{{each_user_data.user_name}}</h4>
                                <p class="pl-2 text-muted">{{each_user_data.user_id}}</p>
                            </div>
                            <div class="float-right">
                            <button type="button" class="btn-sm border" @click="User_FF_send()">{{user_follow_string}}</button>
                            </div>
                                <div>
    <button type="button" class="btn-sm border"  @click="openModal(0)">フォロー中　{{user_follower.length}}人</button>
                               <button type="button" class="btn-sm border"  @click="openModal(1)">フォロワー　{{user_followers.length}}人</button>
                                </div>
                            <p class="card-text mt-3">{{each_user_data.si_text}}</p>
                     </div>                  
                </div>   
                <div class="col-md-3"></div> 
            </div>
        </div>
          <MyModal @close="closeModal" v-if="user_modal" class="border-0"> 
       <div class="row justify-content-center mt-3 border-bottom ">
              <div class="col-md-3"></div>
            <div class="col-md-6 h4">{{modai_title}}</div>
           <div @click="closeModal()" class="col-md-3 h4"><i class="fas fa-times"></i></div>
          </div>
            <div v-if="display_judg == 0">
              <div class="modal_display mx-sm-5">
                <div v-for="val in user_follower" v-bind:key="val.id">
                    <div class="row mb-2">
                        <div class="col-md-2">
                            <span class="cover list_image text-left" @click="follows_link(val.user_id)" v-bind:style="{ backgroundImage: 'url(storage/' + val.icon_path + '.jpg)' }"></span>
                        </div>
                         <div class="col-md-4">
                            <span class="h5"  @click="follows_link(val.user_id)">{{val.user_name}}</span><br>
                            <span class="text-muted" style="line-height:0px;">{{val.user_id}}</span>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn-sm border" @click="follow_or_Non(val.id,val.follows_stauts)">{{val.follows_string}}</button>
                        </div>
                    </div>
                </div>
               </div>
            </div>
               <div v-if="display_judg == 1">
              <div class="modal_display mx-sm-5">
                <div v-for="val in user_followers" v-bind:key="val.id">
                    <div class="row mb-2">
                        <div class="col-md-2">
                            <span class="cover list_image text-left" @click="follows_link(val.user_id)" v-bind:style="{ backgroundImage: 'url(storage/' + val.icon_path + '.jpg)' }"></span>
                        </div>
                         <div class="col-md-4">
                            <span class="h5"  @click="follows_link(val.user_id)">{{val.user_name}}</span><br>
                            <span class="text-muted" style="line-height:0px;">{{val.user_id}}</span>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn-sm border" @click="follow_or_Non(val.id,val.follows_stauts)">{{val.follows_string}}</button>
                        </div>
                    </div>
                </div>
               </div>
            </div> 
        </MyModal>
    </div>
</template>
<style>
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

@media (max-width: 992px) {
  .container {
    min-width: 890px;
 
  }
}
@media (max-width: 768px) {
  .container {
    max-width:none !important;
  }
}
.list_image{
    width:30px;
    height:30px;
}

</style>

<script>
import MyModal from '../../user_modal/user_modal.vue';
window.Vue = require('vue');
export default {
     props:{
    id:{
        type: String,
      }
     },
    data(){
        return{
            each_user_id:"",
            each_user_data:[],
            user_follow_stauts:"",
            user_follow_string:"",
            user_followers:[],
            user_follower:[],
            my_data:[],
            user_modal: false, //modal表示・非表示
            display_judg :0, 
            modai_title:"",
        }
    },components:{
        MyModal
    },
mounted : function() { 
            this.submit_user(this.$route.params['id']);
},watch:{
            '$route' (to, from) {
               this.submit_user(this.$route.params['id']);
            }
},methods:{
    submit_user: function (id) {
        let params = new URLSearchParams();
            axios.get("api/user/"+id,params).then(response => {
               if(typeof(response['data']) == "string"){
           //Not data
               }else{
           this.each_user_data = response['data']['user_info'];
           this.user_followers = response['data']['followed'];//フォロワー
           this.user_follower = response['data']['follows'];//フォロー
           this.my_data = response['data']['my_data'];
           this.FF_chk();
           this.FF_chk_list();
               }
            }).catch(function (error) {
               console.log(error);
            });
              },
                openModal(judg) {
                   
       this.display_judg = judg;
       if (judg==0) this.modai_title = "フォロー中";
       if (judg==1) this.modai_title = "フォロワー";
      this.user_modal = true;
    },
    closeModal() {
      this.user_modal = false;
    },
    follows_link(val){
        this.$router.push('/'+val);
    },
    FF_chk(){//他人のマイページのFFボタン操作
                if(this.user_followers == null){
                    this.user_follow_string = "フォローする";
                    this.user_follow_stauts = 0;
                }
                for(let i = 0; i < this.user_followers.length; i++){
                    if(this.user_followers[i]['id'] == this.my_data['id']){
                            this.user_follow_string = "フォロー中";
                            this.user_follow_stauts = 1;
                    }else{
                            this.user_follow_string = "フォローする";
                            this.user_follow_stauts = 0;
                    }
                }
               
            
         },
         FF_chk_list(){
        var follows_arr = [];//本人フォロー中
        var followed_arr = [];//本人をフォローしてる人
        
            for (let k = 0; k < this.user_follower.length; k++) {
              follows_arr[k] = this.user_follower[k]['user_name'];
            }
            for (let l = 0; l < this.user_followers.length; l++) {
              followed_arr[l] = this.user_followers[l]['user_name'];
            }

            for(let m = 0; m < followed_arr.length; m++){
                //フォロワー配列にフォロー配列と同一人物がいるか。
                if(0 <= follows_arr.indexOf(followed_arr[m])){
                        //console.log("FF内"+followed_arr[m]);
                        //stautsはあくまで”自分が”フォローしているかどうか
                    this.user_followers[m]['follows_string'] ="フォロー中";
                    this.user_followers[m]['follows_stauts'] =1;
                }else{
                    //console.log("フォローのみされている"+followed_arr[m]);
                    this.user_followers[m]['follows_string'] ="フォローする";
                    this.user_followers[m]['follows_stauts'] =0;
                }
            }
                for(let n = 0; n < follows_arr.length; n++){
                //フォロワー配列にフォロー配列と同一人物がいるか。
                if(0 <= followed_arr.indexOf(follows_arr[n])){
                    this.user_follower[n]['follows_string'] ="フォロー中";
                    this.user_follower[n]['follows_stauts'] =1;
                }else{
                    //console.log("フォローしているだけ"+follows_arr[n]);
                    this.user_follower[n]['follows_string'] ="フォロー中";
                    this.user_follower[n]['follows_stauts'] =1;
                }
            }
         },
         User_FF_send(){//他人のマイページのFFボタン転送
        let params = new URLSearchParams();
         params.append('id',this.each_user_data['id']);
        params.append('user_id',this.my_data['user_id']);
        params.append('stauts',this.user_follow_stauts);
        params.append('my_id',this.my_data['id']);
        axios.post('api/user/'+this.my_data['id'],params).then(response => {
             this.each_user_data = response['data']['user_info'];
           this.user_followers = response['data']['followed'];
           this.my_data = response['data']['my_data'];
           this.FF_chk();
}).catch(function (error) {
          console.log(error);
        });
            },
    follow_or_Non(val,stauts){
        let params = new URLSearchParams();
  params.append('id',val);//myid6
   params.append('user_id',this.each_user_data['user_id']);
  params.append('stauts',stauts);
  params.append('my_id',this.my_data['id']);
axios.post('api/user/'+this.my_data['id'],params).then(response => {
             this.my_data = response['data']['my_data'];
           this.user_follower =  response['data']['follows'];
           this.user_followers =  response['data']['followed'];  
             this.FF_chk_list(); 
}).catch(function (error) {
          console.log(error);
        });
    }
}
}


</script>
