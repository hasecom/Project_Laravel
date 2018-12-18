<!--
ユーザーログイン画面
-->

<template>
  <div>
サンプルのフロントページだお<br>
<a href="login">ろぐいんだお</a><br>
<a href="sign_up#/registration">新規作成だお</a><br>
<a href="user">TOPだお</a><br>


  <img v-show="uploadedImage" :src="uploadedImage" />
  <input type="file" v-on:change="onFileChange" name="file"  mulitple="multiple">
<img src="storage/photo.jpg">
  </div>
</template>

<script>
export default {
data() {
    return {
      uploadedImage: '',
      return_base64:''
    };
  },
  methods: {
    onFileChange(e) {
      let files = e.target.files || e.dataTransfer.files;
      this.createImage(files[0]);
    },
    // アップロードした画像を表示
    createImage(file) {
      console.log(file);
      let reader = new FileReader();

     

      reader.onload = (e) => {

        this.uploadedImage = e.target.result;

        
           let params = new URLSearchParams();
           params.append('files',this.uploadedImage);
           console.log(file['name'])
        axios.post('',params).then(response => {
          this.return_base64 = response['data'];
          }).catch(function (error) {
          console.log(error);
        });
       

      };
      reader.readAsDataURL(file);

    },
  },  

}
</script>

<style>

</style>