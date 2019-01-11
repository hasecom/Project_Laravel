<template>
    <div>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
        画像の投稿
        </div>
      </div>
    </nav>

<i class="far fa-arrow-alt-circle-up fa-5x" @click="openModal"></i>
    
<MyModal @close="closeModal" v-if="img_modal" class="border-0">

          <form @submit.prevent="onPost" enctype= "multipart/form-data">
          <div class="img_up">    
          <img v-show="uploadedImage" :src="uploadedImage" style="width=300px; height=200px;"/>
          </div>
          <input type="file" v-on:change="onFileChange" name="file"><br>
          タイトル：<input type="text" v-model="send_post_name"><br>
          説明欄　：<input type="text" v-model="send_description"><br>
          <div class="sub" ><button  type="submit" class = "btn btn-primary">送信</button></div>
          </form>
</MyModal>
    </div>
</template>
<style>
.img_up{
  width:300px;
  height:200px;
  margin: 30px;
  background-color:gray;
}
.sub{
  text-align: center;
}
</style>
<script>
import MyModal from '../../user_modal/user_modal.vue';
window.Vue = require('vue');


export default {
data() {
    return {
      uploadedImage: '',
      return_base64:'',
      sample_data:'',
      send_description:'',
      send_post_name:'',
      my_data:[],
      flg :0,
      img_modal:false,
    };
  },
  components:{
        MyModal
    },
  mounted : function(){
      this.on_post_Load();
  },
  methods: {
    on_post_Load(){
             axios.get("api/users/chk").then(response=>{
                this.my_data = typeof(response['data'])=="undefined"? []: response['data'];
  }).catch(function (error) {
               console.log(error);
            });
    },
    onFileChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      this.createImage(files[0]);
    },
    // アップロードした画像を表示
    createImage(file) {
      let reader = new FileReader();
      reader.onload = (e) => {
        this.uploadedImage = e.target.result;

      };
      reader.readAsDataURL(file);

    },openModal() {
      this.img_modal = true;
    },
    closeModal() {
      this.img_modal = false;
    },
    onPost(){
       
        if(this.flg==1){
          return false;
        }
        let  token_ = Math.random();
        console.log(token_);
        let params = new URLSearchParams();
        params.append('files',this.uploadedImage);
        params.append('img_post',token_);
        params.append('description',this.send_description);
        params.append('post_name',this.send_post_name);
        axios.post("api/user/post_data/"+ this.my_data['user_id'],params).then(response => {
          this.flg=1;
          this.return_base64 = response['data'];
            this.sample_data = "data:image/jpeg;base64," + response['data'];
          // console.log(response['data']);
          }).catch(function (error) {
          console.log(error);
        });
    },
    // send_messsage(){
    //     // let params = new URLSearchParams();
    //     // params.append('description',this.send_description);
    //     axios.post("api/user/post_data/"+ this.my_data['user_id'],params).then(response => {
    //     // console.log(response['data']);
    //     }).catch(function (error) {
    //       console.log(error);
    //     });
    // }
  },  

}
</script>
