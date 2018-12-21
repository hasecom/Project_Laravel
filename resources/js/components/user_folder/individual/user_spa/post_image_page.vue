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
      sample_data:''
    };
  },
  methods: {
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
        console.log("aaaaaa");
        let params = new URLSearchParams();
        params.append('files',this.uploadedImage);
        axios.post('',params).then(response => {
          this.return_base64 = response['data'];
            this.sample_data = "data:image/jpeg;base64," + response['data'];
          }).catch(function (error) {
          console.log(error);
        });
    }
  },  

}
</script>
