<template>
    <div>
    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div class="navbar-header">
        画像の投稿
        </div>
      </div>
    </nav>

          <form  @submit.prevent="onPost" enctype= "multipart/form-data">
          <img v-show="uploadedImage" :src="uploadedImage" />
          <input type="file" v-on:change="onFileChange" name="file">
          <button type="submit" class = "btn btn-primary">送信</button></form>
          <div>
            <form @submit.prevent="send_messsage">
              <input type="text" v-model="send_description">
              <button type="submit" class="btn-primary">送信</button>
            </form>
          </div>
    </div>
</template>
<style>

</style>
<script>
export default {
data() {
    return {
      uploadedImage: '',
      return_base64:'',
      sample_data:'',
      send_description:'',
      my_data:[],
      flg :0
    };
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
        axios.post('',params).then(response => {
          this.flg=1;
          this.return_base64 = response['data'];
            this.sample_data = "data:image/jpeg;base64," + response['data'];
          // console.log(response['data']);
          }).catch(function (error) {
          console.log(error);
        });
    },
    send_messsage(){
        let params = new URLSearchParams();
        params.append('description',this.send_description);
        axios.post("api/user/post_data/"+ this.my_data['user_id'],params).then(response => {
        console.log(response['data']);
        }).catch(function (error) {
          console.log(error);
        });
    }
  },  

}
</script>
