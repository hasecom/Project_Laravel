<template>
    <div>
        <div class="container">
            <div class="row">
              <div class="col-md-3"></div>
                 <div class="col-6">
                     <div class="mt-3">
                             <div class="card-body row align-items-center">
                                <span class="cover ml-5 profile_icon" v-bind:style="{ backgroundImage: 'url(storage/' + each_user_data.icon_path + '.jpg)' }"></span>
                                 <h4 class="card-title ml-5">{{each_user_data.user_name}}</h4>
                                <p class="pl-2 text-muted">{{each_user_data.user_id}}</p>
                            </div>
                            <div>  
                                <button  v-if="follows_list.length != 0" type="button" class="btn-sm border"  @click="openModal(0)">フォロー中　{{follows_list.length}}人</button>
                               <button  v-if="follows_list.length == 0" type="button" class="btn-sm border">フォロー中　{{follows_list.length}}人</button>
                               <button v-if="followed_list.length != 0" type="button" class="btn-sm border"  @click="openModal(1)">フォロワー　{{followed_list.length}}人</button>
                               <button v-if="followed_list.length == 0" type="button" class="btn-sm border">フォロワー　{{followed_list.length}}人</button>
                               
                            </div>
                            <p class="card-text mt-3">{{each_user_data.si_text}}</p>     
                     </div> 
                      <img-gallery></img-gallery>
                     
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
                <div v-for="val in follows_list" v-bind:key="val.id">
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
                <div v-for="val in followed_list" v-bind:key="val.id">
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
<style scoped>
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
    data(){
        return{
         each_user_data:[],
         follows_list:[],//フォロー
         followed_list:[],//フォロワー
         account_id:"",
         account_inner_id:"",
         user_modal: false, //modal表示・非表示
         display_judg :0, 
         modai_title:"",
        }
    },components:{
        MyModal
    }
    ,mounted : function() { 
            this.submit_user();
},watch:{
            '$route' (to, from) {
               this.submit_user();
            }
},methods:{
    submit_user: function () {
       axios.get("api/users/chk").then(response=>{
                   this.account_id = response['data']['user_id'];
                   this.account_inner_id = response['data']['id'];
            axios.get("api/user/"+this.account_id).then(response => {
               if(typeof(response['data']) == "string"){
               }else{
           this.each_user_data = response['data']['my_data'];
           this.follows_list = typeof(response['data']['follows'])=="undefined"? []:response['data']['follows'];
           this.followed_list =  typeof(response['data']['followed'])=="undefined"? []:response['data']['followed'];      
            this.FF_chk();
               }
            }).catch(function (error) {
               console.log(error);
            });
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
        this.closeModal();
        this.$router.push('/'+val);
    },
    FF_chk(){
        var follows_arr = [];//本人フォロー中
        var followed_arr = [];//本人をフォローしてる人

            for (let k = 0; k < this.follows_list.length; k++) {
              follows_arr[k] = this.follows_list[k]['id'];
            }
            for (let l = 0; l < this.followed_list.length; l++) {
              followed_arr[l] = this.followed_list[l]['id'];
            }

            for(let m = 0; m < followed_arr.length; m++){
                //フォロワー配列にフォロー配列と同一人物がいるか。
                if(0 <= follows_arr.indexOf(followed_arr[m])){
                        //console.log("FF内"+followed_arr[m]);
                        //stautsはあくまで”自分が”フォローしているかどうか
                    this.followed_list[m]['follows_string'] ="フォロー中";
                    this.followed_list[m]['follows_stauts'] =1;
                }else{
                    //console.log("フォローのみされている"+followed_arr[m]);
                    this.followed_list[m]['follows_string'] ="フォローする";
                    this.followed_list[m]['follows_stauts'] =0;
                }
            }
                for(let n = 0; n < follows_arr.length; n++){
                //フォロワー配列にフォロー配列と同一人物がいるか。
                if(0 <= followed_arr.indexOf(follows_arr[n])){
                    this.follows_list[n]['follows_string'] ="フォロー中";
                    this.follows_list[n]['follows_stauts'] =1;
                }else{
                    //console.log("フォローしているだけ"+follows_arr[n]);
                    this.follows_list[n]['follows_string'] ="フォロー中";
                    this.follows_list[n]['follows_stauts'] =1;
                }
            }
  
    }
    ,follow_or_Non(val,stauts){
        let params = new URLSearchParams();
            params.append('id',val);//myid6
            params.append('user_id',this.account_id);
            params.append('stauts',stauts);
            params.append('my_id',this.account_inner_id);
            axios.post('api/user/'+this.account_id,params).then(response => {
             this.each_user_data = response['data']['my_data'];
            this.follows_list =  typeof(response['data']['follows'])=="undefined"? []:response['data']['follows'];
            this.followed_list = typeof(response['data']['followed'])=="undefined"? []:response['data']['followed'];
             this.FF_chk(); 
            }).catch(function (error) {
                console.log(error);
            });
    }
} 
}
</script>
