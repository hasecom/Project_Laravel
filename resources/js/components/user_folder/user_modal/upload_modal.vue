<template>
  <div v-bind:class="amplifyUI.formContainer" style="text-align:center; margin-bottom:0px; max-width:100%;">
  <!--<div class="modal" style="text-align:center; margin-bottom:0px; max-width:320px !important; width:320px !important">-->
    <div v-bind:class="amplifyUI.sectionBody" style="text-align:center; margin-bottom:0px !important; width:100%; padding:10px;">
    <div v-bind:class="amplifyUI.sectionHeader" style="text-align:center; width:100%; ">{{options.header}}</div>
      <img
        class="display_img" 
        v-if="file" 
        :src="uploadedImage" 


      />
      <label class="upload_area" 
        @dragover.prevent="dragover=true"
        @dragleave.prevent="dragover=false"
        @drop.prevent="drop">
      <div v-bind:class="amplifyUI.photoPlaceholder" v-if="!file" style="width:100%; ">
      <div v-bind:class="amplifyUI.photoPlaceholderIcon" v-if="!file" style="width:100%;">
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

                <input id="title" type="text" v-model="send_post_name" placeholder="タイトル"/>
                <textarea id= 'caption' v-model="send_description" placeholder="作品の説明"></textarea>
                <input id = 'tag' type="text" v-model="send_post_tag" placeholder="タグ  例(#sample)"/>
                <div class='price_info'><span>￥</span><input id = 'price' type="text" v-model="send_price" placeholder="0"></div>

                <div class="photo_info2">
                <p id="size">ファイルサイズ[0 Bytes]</p>
                <p id="px">大きさ[{{upload_width}}x{{upload_height}}]</p>
                </div>
    </div>
          <button v-if="file" v-bind:class="[amplifyUI.photoPickerButton, amplifyUI.button]" v-on:click="onPost" :disabled="!file" style="width:100%; ">{{options.title}}</button>
          <div class="error" v-if="error">
            {{ error }}
          </div>
        </div>
      </div>
</template>

<style>
#title{
    width:100%;
    
    border-radius: 6px 6px 0px 0px;
    margin :10px 0px 2px 0px;
    background-color: #f8f4f4;
}
#caption{
    width:100%;  
    
    height:100px;
    border-radius:0px 0px 6px 6px ;
    background-color: #f8f4f4;
    
}
#tag{
    width:100%; 
    
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

.photo_info{
  height:100%;
}

.price_info{
  width:100%; 
  
  color:white;
  text-align: right;
  border-radius:3px;
  background-color: #6cb2eb;
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
  width:100%; 
  
  height:auto;
  background-color: rgb(63,63,61);
  opacity: 0.8;
}

.display_img{
    width:100%; 
    
    height: 300px;
    object-fit: contain;
}
.photo_info2{
    text-align: left;
}

</style>


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
      size_text:'',
      file_type:'',

      dragover: false,
      files: [],
      logger: {},
      file: null,
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

      const reader = new FileReader();
      reader.onload = (e) => {
      this.photo_size =this.file.size;
      this.size_txt = "ファイルサイズ[" + this.photo_size + " Bytes]";
      document.getElementById("size").innerHTML = this.size_txt;
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
      this.photo_size =this.file.size;
      this.size_txt = "ファイルサイズ[" + this.photo_size + " Bytes]";
      document.getElementById("size").innerHTML = this.size_txt;
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
       location.reload(); //!後でちゃんと変更
    
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
</script>