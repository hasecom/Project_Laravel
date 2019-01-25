<template>
  <div>
    <div class="up_btn"><i class="fas fa-file-upload fa-3x faa-float animated my-green" @click="openModal">投稿</i></div>
      <MyModal id="main_modal" @close="closeModal" v-if="img_modal" class="border-0">
        <uploadmodal></uploadmodal>
      </MyModal>
  </div>
</template>
<style>

#main_modal{
    margin:0 auto;
    width: 100%;
    height: 100%;
    overflow:auto;
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

.up_btn{
  position: fixed;
  bottom: 7%;
  right: 10%;
}
</style>
<script>
import MyModal from '../../user_modal/user_modal.vue';
import uploadmodal from '../../user_modal/upload_modal.vue';
window.Vue = require('vue');


export default {
data() {
    return {
      img_modal:false,
      upload_width:0,
      upload_height:0,
    
    };
  },
  components:{
        MyModal,
        uploadmodal
    },

  mounted : function(){
      this.on_post_Load();
     
     
  },

  methods: {
    openModal() {
      this.img_modal = true;
    },
    closeModal() {
      this.img_modal = false;
    },
    onFileChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      
      this.createImage(files[0]);
       
    },
    // アップロードした画像を表示
    createImage(file) {
      var up_image = new Image();
      let reader = new FileReader();

      reader.onload = function(e){
        this.uploadedImage = e.target.result;
           up_image.src = reader.result;
            };
           up_image.onload = function(){
        _this.upload_width = up_image.naturalWidth;
        _this.upload_height = up_image.naturalHeight;
      }; 
      const _this = this;

       
    
      
      


        
     
      reader.readAsDataURL(file);
      this.photo_size = file.size;
   
      var size_txt = "ファイルサイズ：[" + this.photo_size + " Bytes]";
    //   var dimension = "大きさ：[" + this.upload_width + "x"+ this.upload_height + "]"; //!ファイルの幅と高さ取得どうやるの。。。
      document.getElementById("size").innerHTML = size_txt;
      // document.getElementById("px").innerHTML = dimension;
  
    },
    onPost(){
       
        if(this.flg==1){
          return false;
        }
        let  token_ = Math.random();
      
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
