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
                             <div class="row">
                              <div class="col-md-4">{{item.user_name}}</div>
                              <div class="col-md-4 text-muted">@{{item.user_id}}</div>
                              </div>
			                        <svg class="bd-placeholder-img card-img-top" width="100%" height="300" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: カードの画像"><title>プレースホルダ</title><rect fill="#868e96" width="100%" height="100%"></rect><text fill="#dee2e6" dy=".3em" x="30%" y="50%">no image</text></svg>
			                        <div class="card-body px-2 py-3">
                                <h5 class="card-title">{{item.photo_name}}</h5>  
                                <p>
                                  <span @click="likes(item.photo_id,item.like_stauts)">
                                    <img v-if="item.like_stauts == 1" src="storage/like.svg" width="16" height="16">
                                    <img v-if="item.like_stauts == 0" src="storage/like_emp.svg" width="16" height="16">
                                     </span>   
                                    <span @click="get_likes_user_data(0,item.photo_id)">{{item.likes_cnt}}件</span>
                                  <chats :photo_data="item" :my_data="my_data"></chats>
                                </p>
                                <p class="card-text text-muted text-center">{{item.photo_description}}</p>
			                      </div>
                            <div class="row">
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
           <MyModal @close="closeModal" v-if="user_modal" class="border-0">
               <div class="row justify-content-center mt-3 border-bottom ">
              <div class="col-md-3"></div>
            <div class="col-md-6 h4">{{modai_title}}</div>
           <div @click="closeModal()" class="col-md-3 h4"><i class="fas fa-times"></i></div>
          </div>
            <div v-if="display_judg == 0">
              <div class="modal_display mx-sm-5">
                    <div v-for="(val , index) in likes_user" v-bind:key="index">
                    <div class="row mb-2">
                        <div class="col-md-2">
                            <span class="cover list_image text-left" @click="follows_link(val.user_id)" v-bind:style="{ backgroundImage: 'url(storage/' + val.icon_path + '.jpg)' }"></span>
                        </div>
                         <div class="col-md-4">
                            <span class="h5" @click="follows_link(val.user_id)">{{val.user_name}}</span><br>
                            <span class="text-muted" style="line-height:0px;" @click="follows_link(val.user_id)">{{val.user_id}}</span>
                        </div>
                        <div class="col-md-6">
                            <button type="button" class="btn-sm border"  v-if="val.ff_stauts != -1" @click="ff_click(val.id,val.user_id,val.ff_stauts,val,index)">{{val.follows_string}}</button>
                            <div v-if="val.ff_stauts == -1">&emsp;&emsp;&emsp;&emsp;</div>
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
.list_image{
    width:30px;
    height:30px;
}
</style>
<script>
import MyModal from '../../user_modal/user_modal.vue';
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
    }
  },components:{
        MyModal
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
            //--01の0を消す処理だよ、できへんやん
            // for(let k = 0; k < date_disassembly[j].length; k++){
            //   date_synthesis[j][k]=date_disassembly[j][k].match(/0*([0-9]+)/)[1];  
            // }  
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
      
    },get_likes_user_data(judg,photo_id){
             axios.get("api/user/post_data/timeline/likes_data/"+photo_id).then(photo_id_likes_user => {
                   if(typeof(photo_id_likes_user['data']) == "object"){
                     this.likes_user = photo_id_likes_user['data'];
                     console.log(this.likes_user)
                        axios.get("api/user/"+this.my_data['user_id']).then(response=>{
                          let follows_arr =[];
                          follows_arr = this.arr_chk(response['data']['follows']);
                          for(let i =0; i<this.likes_user.length; i++){
                          for(let j =0; j < follows_arr.length; j++){
                            if(this.likes_user[i]['id'] == follows_arr[j]['id']){
                             this.likes_user[i]['ff_stauts'] = 1;
                             this.likes_user[i]['follows_string'] = "フォロー中";
                             break;
                    
                            }else if(this.likes_user[i]['id'] ==this.my_data['id']){
                              this.likes_user[i]['ff_stauts'] = -1;
                              this.likes_user[i]['follows_string'] = "";
                              break;
                            }else{
                              this.likes_user[i]['ff_stauts'] = 0;
                              this.likes_user[i]['follows_string'] = "フォローする";
                            }
                          
                          }
                          if(i == this.likes_user.length -1){
                              this.openModal(judg);
                              this.now_photo_id = photo_id;
                          }
                        // 
                         }  
                   }).catch(function(error){
                    console.log("error");
                  });  
                 
                    
                    }
                    
                    }).catch(function (error) {
                        console.log(error)
                    });
                     
    },

    ff_click(id,user_id,stauts,photo_id,index){
               let params = new URLSearchParams();
              params.append('id',id);
              params.append('user_id',user_id);
              params.append('stauts',stauts);
              params.append('likes',1);
              params.append('my_id',this.my_data['id']);
      axios.post('api/user/'+this.my_data['id'],params).then(list_get_data => {
          this.arr_chk(list_get_data['data']['user_info']);
           if(stauts == 0){
             list_get_data['data']['user_info']['ff_stauts'] = 1;
             list_get_data['data']['user_info'] ['follows_string'] = "フォロー中";
            this.$set(this.likes_user,index,list_get_data['data']['user_info']);
           this.$set(this.likes_user,index,list_get_data['data']['user_info']);
           }else{
        list_get_data['data']['user_info']['ff_stauts'] = 0;
          list_get_data['data']['user_info'] ['follows_string'] = "フォローする";
          this.$set(this.likes_user,index, list_get_data['data']['user_info']);
           this.$set(this.likes_user,index,list_get_data['data']['user_info']);
           }
      }).catch(function (error) {
          console.log(error);
        });
    },
    openModal(judg) {
       this.display_judg = judg;
       if (judg==0) this.modai_title = "いいね";
       if (judg==1) this.modai_title = "フォロワー";
      this.user_modal = true;
    },
    closeModal() {
      this.user_modal = false;
    },arr_chk(data){
     return typeof(data)=="undefined"? []:data;
    },  
    follows_link(val){
        this.closeModal();
        this.$router.push('/'+val);
    },
  }
}
</script>
