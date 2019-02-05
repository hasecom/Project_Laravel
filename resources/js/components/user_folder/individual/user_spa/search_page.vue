<template>
    <div  id="search_content" style="margin:0 auto">
        <div class="row row_margin_del_" >
            <div class="col-md-4 col-6">
                <div v-for="(item_left , index) in img_arr_left" :key="index"  class="row flex-column" style="height:fit-content">
                    <div class="col-12 mt-2 pointer" :id="'item_left' + index"  @mouseenter="info_hover('item_left'+index)" @mouseleave="info_leave('item_left'+index)" @click="modal_set('details' + index,0,0)">
                        <amplify-s3-image style="pointer-events: none; width:100% !important"  :imagePath= "'Photos/'+item_left.photo_path+'/'+item_left.file_name+'.png'" ></amplify-s3-image>
                    </div>
                    <user-post-details :photo_data="item_left"  :my_data="my_data"  :ref="'details' + index"></user-post-details>
                </div>
            </div>
            <div class="col-md-4 col-6">
                <div v-for="(item_center , index) in img_arr_center" :key="index"  class="row flex-column" style="height:fit-content">
                    <div class="col-12  mt-2 pointer" :id="'item_center' + index"  @mouseenter="info_hover('item_center'+index)" @mouseleave="info_leave('item_center'+index)" @click="modal_set('details' + index,0,1)">
                        <amplify-s3-image style="pointer-events: none; width:100% !important"  :imagePath= "'Photos/'+item_center.photo_path+'/'+item_center.file_name+'.png'" ></amplify-s3-image>
                    </div>
                    <user-post-details :photo_data="item_center"  :my_data="my_data"  :ref="'details' + index"></user-post-details>
                </div>
            </div>
            <div class="col-md-4">
                <div v-for="(item_right , index) in img_arr_right" :key="index"  class="row flex-column" style="height:fit-content">
                    <div class="col-12  mt-2 pointer" :id="'item_right' + index"  @mouseenter="info_hover('item_right'+index)" @mouseleave="info_leave('item_right'+index)" @click="modal_set('details' + index,0,2)">
                       <!-- <div class="sample">kkkkkkkkkkkkkkk</div> -->
                        <amplify-s3-image style="pointer-events: none; width:100% !important"  :imagePath= "'Photos/'+item_right.photo_path+'/'+item_right.file_name+'.png'" ></amplify-s3-image>
                    </div>
                    <user-post-details :photo_data="item_right" :my_data="my_data"  :ref="'details' + index"></user-post-details>
                </div>
            </div>
        </div>
 
        </div>
</template>

<script>
import MyModal from '../../user_modal/user_modal.vue';
import Details from "../component/user_post_details.vue";

export default{
    data(){
        return{
            search_word_send:'',
            search_data:[],
            add_img:0,
            put_arr:[0,0,0],
            img_arr_left:[],
            img_arr_center:[],
            img_arr_right:[],
            my_data:[],
            img_modal:false
            
        }
    },components:{
        MyModal,Details
    },watch: {
    '$route' (to, from) {
      this.search_word_send = this.$route['query'];
      this.search_word();
    },
  
   
    },
    mounted:function(){
     
    this.search_word_send = this.$route['query'];
    this.search_word();
    this.get_my_data();
    },
    methods:{
    search_word(){
             axios.get('api/user/post_data/photo/search/' + this.search_word_send['word']).then(search_word_response => {  
                this.search_data = search_word_response['data'];
               
    for(let i = 0; i < this.search_data.length; i++){
                    axios.get("api/user/post_data/details/" + this.search_data[i]['photo_id'] ).then(response => {
                    if(typeof(response['data']) == "object"){
                        this.search_data[i]['user_name'] = response['data'][0]['user_name'];
                      this.search_data[i]['icon_path'] = response['data'][0]['icon_path'];
                      this.search_data[i]['id'] = response['data'][0]['id'];
                      this.search_data[i]['like_id']= response['data'][0]['like_id'];
                      this.search_data[i]['likes_cnt'] = response['data'][0]['likes_cnt'];
                      this.search_data[i]['like_stauts'] = response['data'][0]['like_stauts'];
                      this.search_data[i]['user_id'] = response['data'][0]['user_id'];
                    
                    }
            }).catch(function (error) {
                console.log(error)
            });
    }
    //!この処理はあり得んが妥協。
    const this_ = this;
      var countup = function(){    
  this_.gallery_in();
  } 
  setTimeout(countup, 2000);

    
  
                      
                    }).catch(function (error) {
                console.log(error);
                    });
    },
    gallery_in(){
        let get_arr = this.search_data;
       
       // get_arr = get_arr.reverse();
     for(let i = 0; i < get_arr.length; i++){
      if(i%3 == 0){
          this.img_arr_left.unshift(get_arr[i])
      }else if(i%3 == 1){
          this.img_arr_center.unshift(get_arr[i])
      }else{
          this.img_arr_right.unshift(get_arr[i])
      }
     }
          if(this.put_arr[0] == this.put_arr[1] || this.put_arr[0] == this.put_arr[2]){
              this.add_img = 0;
          }else if(this.put_arr[1] < this.put_arr[0] && this.put_arr[1] < this.put_arr[2]){
              this.add_img = 1;
          }else{
              this.add_img = 2;
          }
    },
    info_leave(id){
        document.getElementById(id).classList.remove("search_img")
    },
    info_hover(id){
        document.getElementById(id).classList.add("search_img")
    },
    get_my_data(){
      axios.get("api/users/chk").then(response => {
               if(typeof(response['data']) == "object"){  
                  
                 this.my_data = response['data'];
                    }
            }).catch(function (error) {
                console.log(error)
            });

    },
    modal_set(ref,chat_or_img,col){
       
     //chatクリック=1
        this.$refs[ref][col].openModal(chat_or_img); 
    },
  
   }
}

</script>
<style>
.search_img{
     opacity:0.4;
         -webkit-transform: scale(1.1);
    -moz-transform: scale(1.1);
    -o-transform: scale(1.1);
    -ms-transform: scale(1.1);
    transform: scale(1.1);
  -webkit-transition:all 300ms ease-in-out;
  transition:all 300ms ease-in-out;
}
.amplify-image{
    width:100% !important;
    height:auto;
    
}
#search_content{
    width:70% ;
}
@media (max-width: 992px) {
  #search_content {
    width:100%;
  }
}
@media (max-width: 768px) {
 #search_content {
    width:100%;
  }
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
.sample{
      position: absolute;/*絶対配置*/
  color: white;/*文字は白に*/
  top: 0;
  left: 0;
}
</style>
