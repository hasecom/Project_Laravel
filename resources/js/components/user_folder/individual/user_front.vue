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
  <input type="file" v-on:change="onFileChange" name="file">
<img src="storage/photo.jpg">
<img v-bind:src="sample_data">
  </div>
</template>

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
           let params = new URLSearchParams();
           params.append('files',this.uploadedImage);
        axios.post('',params).then(response => {
          this.return_base64 = response['data'];
  this.sample_data = "data:image/jpeg;base64," + response['data'];
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