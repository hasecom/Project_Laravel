<template>
    <div>
          <div v-for="(val , index) in likes_user" v-bind:key="index">
            <div class="row mb-2">
                <div class="col-md-2">
                    <div v-if="isLoad">
                          <amplify-s3-image  @click="follows_link(val.user_id)" style="pointer-events:none;" :class="{likes_icon:isLoad}" :imagePath="'UserIcons/'+ val.icon_path + '/' + val.icon_name + '.png'" ></amplify-s3-image>
                    </div>
                    <!-- <span class="cover list_image text-left" @click="follows_link(val.user_id)" v-bind:style="{ backgroundImage: 'url(storage/' + val.icon_path + '.jpg)' }"></span> -->
                </div>
                    <div class="col-md-4">
                        <span class="h5" @click="follows_link(val.user_id)">{{val.user_name}}</span><br>
                        <span class="text-muted" style="line-height:0px;" @click="follows_link(val.user_id)">{{val.user_id}}</span>
                    </div>
                     <div class="col-md-6">
                         <button type="button" class="btn-sm border follows_r"  v-if="val.ff_stauts == 1"  @click="ff_click(val.id,val.user_id,val.ff_stauts,val,index)">{{val.follows_string}}</button>
                        <button type="button" class="btn-sm border "  v-if="val.ff_stauts == 0"  @click="ff_click(val.id,val.user_id,val.ff_stauts,val,index)">{{val.follows_string}}</button>
                        <div v-if="val.ff_stauts == -1">&emsp;&emsp;&emsp;&emsp;</div>
                     </div>
                 </div>
                </div>
           
    </div>
</template>
<style>

.likes_icon img{
 width:30px !important;
 height:30px;
 border-radius: 50% !important;
 border:none !important;
 margin:0 !important;
}
</style>
<script>
export default{
    props:{
        photo_data_box:{
            type:Object
        },
        my_data:{
            type:Object
        }
    },
    watch:{
    likes_user: {
      handler: function (val, oldVal) {
         this.isLoad = true;
      },
      deep: true
    },
    },
    data(){
        return{
            likes_user:[],
            isLoad:[]
        }
    },mounted:function(){
        this.get_likes_user_data(0,this.photo_data_box.photo_id);
        
    }
    ,methods:{
        get_likes_user_data(judg,photo_id){

             axios.get("api/user/post_data/timeline/likes_data/"+photo_id).then(photo_id_likes_user => {
                   if(typeof(photo_id_likes_user['data']) == "object"){
                     this.likes_user = photo_id_likes_user['data'];
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
                         } 
                     this.$set(this.likes_user)
                  
                   }).catch(function(error){
                    console.log(error);
                  });  
                    }
                    }).catch(function (error){
                        console.log(error)
                    });
                   
    },arr_chk(data){
     return typeof(data)=="undefined"? []:data;
    },ff_click(id,user_id,stauts,photo_id,index){
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
                //    if(i == this.likes_user.length -1){
                //               this.openModal(judg);
                //               this.now_photo_id = photo_id;
                //           }
      }).catch(function (error) {
          console.log(error);
        });
    },follows_link(val){
        this.$emit('chats-event');
        this.$router.push('/'+val);
    },
    }
}
</script>
