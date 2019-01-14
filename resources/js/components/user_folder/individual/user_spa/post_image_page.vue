<template>
    <div>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
        画像の投稿
        </div>
      </div>
    </nav>
<i class="fas fa-plus fa-5x faa-float animated my-green" @click="openModal"></i>
    
<MyModal @close="closeModal" v-if="img_modal" class="border-0">

          <form @submit.prevent="onPost" enctype= "multipart/form-data">
          <div class="img_up">    
          <img class="img_view" v-show="uploadedImage" :src="uploadedImage" width="480" height="320"/>
          <input type="file" v-on:change="onFileChange" name="file"><br>
          </div>
          タイトル：<input id="title" type="text" v-model="send_post_name"/><br>
          説明欄　：<input type="textarea" v-model="send_description">
          <p id="size">ファイルサイズ：[0 Bytes]</p>
          <p id="px">大きさ：[0x0]</p>
          <div class="sub" ><button  type="submit" class = "btn btn-primary">送信</button></div>
          </form>
</MyModal>
    </div>
</template>
<style>
.img_up{
  width:480px;
  height:320px;
  margin: 30px;
  background-color:#555555;
}
.img_view{
  text-align: center;
  object-fit: contain;
  
}

.sub{
  text-align: center;
}

.my-green{color:green;}
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
    openModal() {
      this.img_modal = true;
    },
    closeModal() {
      this.img_modal = false;
    },
    onFileChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      this.createImage(files[0]);
          // console.log(files);
    },
    // アップロードした画像を表示
    createImage(file) {
      let reader = new FileReader();
      reader.onload = (e) => {
        this.uploadedImage = e.target.result;

      };
      reader.readAsDataURL(file);
      var size = "ファイルサイズ：[" + file.size + " Bytes]";
      // var dimension = "大きさ：[" + file.width + "x"+ file.height + "]"; //!ファイルの幅と高さ取得どうやるの。。。
      document.getElementById("size").innerHTML = size;
      // document.getElementById("px").innerHTML = dimension;
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
        params.append('photo_size',size);
        // params.append('photo_px',dimension); //!ファイルの幅と高さ取得どうやるの。。。
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
  },  

}
</script>
