<template>
<div>
  <div v-bind:class="amplifyUI.formSection" style="width: 380px">
    <div v-bind:class="amplifyUI.sectionHeader">{{options.header}}</div>
    <div v-bind:class="amplifyUI.sectionBody" style="text-align:center">
      <img
        class="display_img" 
        v-if="file" 
        :src="uploadedImage" 


      />
      <label class="upload_area" 
        @dragover.prevent="dragover=true"
        @dragleave.prevent="dragover=false"
        @drop.prevent="drop">
      <div v-bind:class="amplifyUI.photoPlaceholder" v-if="!file" style="width: 380px">
      <div v-bind:class="amplifyUI.photoPlaceholderIcon" v-if="!file" style="width: 380px; color:#f90;">
        <p class="p1">ファイルを選択</p>
        <p class="p1">jpeg png 最大32MBまで</p>

        <input type="file"
               ref="input"
               style="display:none"
               accept="options.accept"
               @change="pick"
               v-bind="$attrs">

          <svg xmlns='http://www.w3.org/2000/svg' width='64' height='64' viewBox='0 0 24 24'>
            <circle cx='12' cy='12' r='3.2' />
            <path d='M9 2L7.17 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-3.17L15 2H9zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z'/>
            <path d='M0 0h24v24H0z' fill='none' />
            </svg>
        </div>
      </div>
    </label>
      <!--<input
        ref="file_input"  
        type="file"
        accept="options.accept"
        @change="pick"
      />-->


        <!--<div class="photo_info">-->
                <input id="title" type="text" v-model="send_post_name" placeholder="タイトル"/>
                <textarea id= 'caption' v-model="send_description" placeholder="作品の説明"></textarea>
                <input id = 'tag' type="text" v-model="send_post_tag" placeholder="タグ  例(#sample)"/>
                <div class='price_info'><span>￥</span><input id = 'price' type="text" v-model="send_price" placeholder="0"></div>

                <div class="photo_info2">
                <p id="size">ファイルサイズ[0 Bytes]</p>
                <p id="px">大きさ[{{upload_width}}x{{upload_height}}]</p>
                </div>
        <!--</div>-->
    </div>




    <button v-if="file" v-bind:class="[amplifyUI.photoPickerButton, amplifyUI.button]" v-on:click="onPost" :disabled="!file">{{options.title}}</button>
    <div class="error" v-if="error">
      {{ error }}
    </div>
  </div>
</div>
</template>

<style>
#title{
    border-radius: 6px 6px 0px 0px;
    margin :10px 0px 2px 0px;
    background-color: #f8f4f4;
}
#caption{
    height:100px;
    border-radius:0px 0px 6px 6px ;
    background-color: #f8f4f4;
    
}
#tag{
    margin-top: 10px;
    margin-bottom: 5px;
    border-radius:6px;
    background-color: #f8f4f4;
}

#price{
    width:20%;
    font-size: 1.1em;
    text-align: right;
    border-radius:6px;
    margin: 5px;
    background-color: #f8f4f4;
}

.price_info{
  background-color: #6cb2eb;
  text-align: right;
  border-radius:3px;
}
.price_info span{
  font-size: 1.5em;
  vertical-align: middle;
}

.p1{
  font-size: 1.2em;
  color:white;
  line-height: .8em;
  }

.upload_area{ 
  background-color: rgb(63,63,61);
  opacity: 0.8;
}

.display_img{
    width: 380px;
    height: 300px;
    object-fit: contain;
}
.photo_info2{
    text-align: left;
}


</style>




<!-- 
<template>
    <div>
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
          </form>-->
        <!--</div>
</template>-->
<script>

import * as AmplifyUI from '@aws-amplify/ui';

export default {
  inheritAttrs: false,
  name: 'PhotoPicker',
  props: ['photoPickerConfig'],
  data () {
    return {
      uploadedImage: '',
      return_base64:'',
      sample_data:'',
      send_description:'',
      send_post_name:'',
      send_post_tag:'',
      send_price:0,
      my_data:[],
      flg :0,
      photo_size :0,
      file_type:'',

      dragover: false,
      files: [],
      logger: {},
      file: null,
      s3ImagePath: '',
      photoUrl: '',
      error: '',
      amplifyUI: AmplifyUI,
      upload_width:0,
      upload_height:0
    }
  },
  mounted : function(){
      this.on_post_Load();
  },
  computed: {
    drop(file) {
      this.dragover = false;
      this.$refs.input.files = this.files = event.dataTransfer.files;
      this.file = file.target.files[0];
      if (!this.file) { return ;};
      if (!this.options.storageOptions.contentType) {
        this.options.storageOptions.contentType = this.file.type;
      };
      // const name = this.options.defaultName ? this.options.defaultName : this.file.name;
      // this.s3ImagePath = `${this.options.path}${name}`;
      // const that = this;
      const reader = new FileReader();
      reader.onload = (e) => {
      //   const target = e.target;
      //   const url  = target.result;
      //   that.photoUrl = url;
      this.file_type =this.file.type;
      this.uploadedImage = e.target.result;
      }
      reader.readAsDataURL(this.file);
    },
    options() {
      const defaults = {
        header: this.$Amplify.I18n.get('File Upload'),
        title: this.$Amplify.I18n.get('Upload'),
        accept: '*/*',
        storageOptions: {}
      }
      return Object.assign(defaults, this.photoPickerConfig || {})
    },
  },
  methods: {
    on_post_Load(){
       axios.get("api/users/chk").then(response=>{
        this.my_data = typeof(response['data'])=="undefined"? []: response['data'];
        console.log('aaa');
        }).catch(function (error) {
      console.log(error);
      });
    },
    // upload() {
    //   this.$Amplify.Storage.put(
    //     this.s3ImagePath,
    //     this.file, 
    //     this.options.storageOptions,
    //   )
    //   .then((result) => {
    //     this.completeFileUpload(result.key)
    //   })
    //   .catch(e => this.setError(e));
    // },
    pick(file) {
      this.file = file.target.files[0];
      if (!this.file) { return ;};
      if (!this.options.storageOptions.contentType) {
        this.options.storageOptions.contentType = this.file.type;
      };
      // const name = this.options.defaultName ? this.options.defaultName : this.file.name;
      // this.s3ImagePath = `${this.options.path}${name}`;
      // const that = this;
      var up_image = new Image();
      const reader = new FileReader();
      reader.onload = (e) => {
      //   const target = e.target;
      //   const url  = target.result;
      //   that.photoUrl = url;
      this.file_type = this.file.type;
      this.uploadedImage = e.target.result;
           up_image.src = reader.result;
           up_image.onload = function(){
        _this.upload_width = up_image.naturalWidth;
        _this.upload_height = up_image.naturalHeight;
      }; 
      const _this = this;
      }
      reader.readAsDataURL(this.file);
    },
    completeFileUpload(img) {
      this.file = null;
      this.s3ImageFile = null;
      this.$refs.file_input.value = null;
      AmplifyEventBus.$emit('fileUpload', img);
    },

onPost(){
     if(this.flg==1){
       return false;
     }
     let  token_ = Math.random();
  
     let params = new URLSearchParams();
     params.append('files',this.uploadedImage);
     params.append('img_post',token_);
     params.append('photo_price',this.send_price);
     params.append('photo_size',this.photo_size);
     // params.append('photo_px',dimension); //!ファイルの幅と高さ取得どうやるの。。。
     params.append('description',this.send_description);
     params.append('post_tag',this.send_post_tag);
     params.append('post_name',this.send_post_name);
     params.append('file_type',this.file_type);
     axios.post("api/user/post_data/"+ this.my_data['user_id'],params).then(response => {
       this.flg=1;
       this.return_base64 = response['data'];
         this.sample_data = "data:"+this.file_type+";base64," + response['data'];
       console.log(this.file_type);
       }).catch(function (error) {
       console.log(error);
     });
  },







    setError: function(e) {
      this.error = this.$Amplify.I18n.get(e.message || e);
      this.logger.error(this.error);
    }
  }
}





// export default {
// data() {
//     return {
//       uploadedImage: '',
//       return_base64:'',
//       sample_data:'',
//       send_description:'',
//       send_post_name:'',
//       send_post_tag:'',
//       my_data:[],
//       flg :0,
//       photo_size :0,
//       img_modal:false,
//     };
//   },
//   mounted : function(){
//       this.on_post_Load();
//   },
//   methods: {
//     on_post_Load(){
//              axios.get("api/users/chk").then(response=>{
//                 this.my_data = typeof(response['data'])=="undefined"? []: response['data'];
//   }).catch(function (error) {
//                console.log(error);
//             });
//     },
//     openModal() {
//       this.img_modal = true;
//     },
//     closeModal() {
//       this.img_modal = false;
//     },
//     onFileChange(e) {
//       let files = e.target.files || e.dataTransfer.files;
//       this.createImage(files[0]);
//           // console.log(files);
//     },
//     // アップロードした画像を表示
//     createImage(file) {
//       let reader = new FileReader();
//       reader.onload = (e) => {
//         this.uploadedImage = e.target.result;

//       };
//       reader.readAsDataURL(file);
//       this.photo_size = file.size;
//       var size_txt = "ファイルサイズ：[" + this.photo_size + " Bytes]";
//       // var dimension = "大きさ：[" + file.width + "x"+ file.height + "]"; //!ファイルの幅と高さ取得どうやるの。。。
//       document.getElementById("size").innerHTML = size_txt;
//       // document.getElementById("px").innerHTML = dimension;
//     },
//     onPost(){
       
//         if(this.flg==1){
//           return false;
//         }
//         let  token_ = Math.random();
      
//         let params = new URLSearchParams();
//         params.append('files',this.uploadedImage);
//         params.append('img_post',token_);
//         params.append('photo_size',this.photo_size);
//         // params.append('photo_px',dimension); //!ファイルの幅と高さ取得どうやるの。。。
//         params.append('description',this.send_description);
//         params.append('post_tag',this.send_post_tag);
//         params.append('post_name',this.send_post_name);
//         axios.post("api/user/post_data/"+ this.my_data['user_id'],params).then(response => {
//           this.flg=1;
//           this.return_base64 = response['data'];
//             this.sample_data = "data:image/jpeg;base64," + response['data'];
//           console.log(response['data']);
//           }).catch(function (error) {
//           console.log(error);
//         });
//     },
//   },  

// }
</script>