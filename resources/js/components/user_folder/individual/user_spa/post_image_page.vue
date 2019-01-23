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
    
<MyModal id="main_modal" @close="closeModal" v-if="img_modal" class="border-0">
          <h1>画像投稿</h1>
          <form @submit.prevent="onPost" enctype= "multipart/form-data">
          <div class="img_up">    
          <img class="img_view" v-show="uploadedImage" :src="uploadedImage" width="480" height="320"/>
          <input type="file" v-on:change="onFileChange" name="file"><br>
          </div>
          <div class="photo_info">
            <div class="row">
              <div class="col-md-3">
                  タイトル：
              </div>
               <div class="col-md-8">
                  <p><input id="title" type="text" v-model="send_post_name"/></p>
              </div>

            </div>
        

          <p>タ　グ　：<input type="text" v-model="send_post_tag"/></p>
          <p>説明欄　：<textarea v-model="send_description"></textarea></p>
          <p id="size">ファイルサイズ：[0 Bytes]</p>
          <p id="px">大きさ：[0x0]</p>
          </div>
          <div class="sub" ><button  type="submit" class = "btn btn-primary">送信</button></div>
          </form>
</MyModal>
    </div>
</template>
<style>


#main_modal{
    /*position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    width: 92%;
    height: 90%;
    margin: auto;
    z-index: 3;*/

    margin:0 auto;
    width: 100%;
    height: 100%;
    overflow:auto;

}

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

.photo_info{
  line-height: 120%;
  font-size: 1.12em;
  width: 480px;
  margin-left:30px;
  /*background-color: red;*/
}

.sub{
  text-align: center;
}

.my-green{color:green;}

textarea {
  vertical-align:top;
  resize: left;
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
      send_post_tag:'',
      my_data:[],
      flg :0,
      photo_size :0,
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
      this.photo_size = file.size;
      var size_txt = "ファイルサイズ：[" + this.photo_size + " Bytes]";
      // var dimension = "大きさ：[" + file.width + "x"+ file.height + "]"; //!ファイルの幅と高さ取得どうやるの。。。
      document.getElementById("size").innerHTML = size_txt;
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
        params.append('photo_size',this.photo_size);
        // params.append('photo_px',dimension); //!ファイルの幅と高さ取得どうやるの。。。
        params.append('description',this.send_description);
        params.append('post_tag',this.send_post_tag);
        params.append('post_name',this.send_post_name);
        axios.post("api/user/post_data/"+ this.my_data['user_id'],params).then(response => {
          this.flg=1;
          this.return_base64 = response['data'];
            this.sample_data = "data:image/jpeg;base64," + response['data'];
          console.log(response['data']);
          }).catch(function (error) {
          console.log(error);
        });
    },
  },  

}
</script>
