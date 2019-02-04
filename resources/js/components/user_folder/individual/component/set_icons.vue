<template>
  <div v-bind:class="amplifyUI.formContainer" style="text-align:center; margin-bottom:0px; max-width:100%;">
  <!--<div class="modal" style="text-align:center; margin-bottom:0px; max-width:320px !important; width:320px !important">-->
    <div v-bind:class="amplifyUI.sectionBody" style="text-align:center; margin-bottom:0px !important; width:100%; padding:10px;">
    <div v-bind:class="amplifyUI.sectionHeader" style="text-align:center; width:100%; ">{{options.header}}</div>
      <label class="upload_area" 
        @dragover.prevent="dragover=true"
        @dragleave.prevent="dragover=false"
        @drop.prevent="drop">

      <img
        class="display_img" 
        v-if="file" 
        :src="uploadedImage" 
      />

      <div v-bind:class="amplifyUI.photoPlaceholder" v-if="!file" 
           style="width:100%;  position: absolute;
                  top: 55%;    left: 50%;
                  transform: translate(-50%, -40%);">
      <div v-bind:class="amplifyUI.photoPlaceholderIcon" v-if="!file" style="width:100%;">
        <div class="p_txt">
        <p class="p1">ファイルを選択</p>
        <p class="p1">jpeg png 最大10MBまで</p>
        </div>
        <input type="file"
               ref="input"
               style="display:none"
               accept="options.accept"
               @change="pick"
               v-bind="$attrs">

          <!--<svg xmlns='http://www.w3.org/2000/svg' width='64' height='64' viewBox='0 0 24 24'>-->
            <!--<circle cx='12' cy='12' r='3.2' />
            <path d='M9 2L7.17 4H4c-1.1 0-2 .9-2 2v12c0 1.1.9 2 2 2h16c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-3.17L15 2H9zm3 15c-2.76 0-5-2.24-5-5s2.24-5 5-5 5 2.24 5 5-2.24 5-5 5z'/>
            <path d='M0 0h24v24H0z' fill='none' />-->
            <!--</svg>-->
        </div>
      </div>
    </label>

    </div>
          <button v-if="file" v-bind:class="[amplifyUI.photoPickerButton, amplifyUI.button]" v-on:click="onPost" :disabled="!file" style="width:50%; border-radius:3px; ">{{options.title}}</button>
          <div class="error" v-if="error">
            {{ error }}
          </div>
        </div>
</template>

<style scoped>
.p_txt{
  font-size: .8em;
  color:white;
  line-height: .8em;
  vertical-align: middle;
  }

.upload_area{ 
  width:150px; 
  height:150px;
  background-color: rgb(63,63,61);
  opacity: 0.8;
  border-radius: 50%;
  overflow: hidden;
}

.display_img{
    width:100%;
    max-width:150px; 
    height: 150px;
    border-radius: 50%;
    overflow: hidden;
}

body {overflow:hidden;}


</style>


<script>
import * as AmplifyUI from '@aws-amplify/ui';

export default {
  inheritAttrs: false,
  name: 'PhotoPicker',
  props: ['photoPickerConfig'],
  props:{
    my_data_box:{
        type:Object
    }
  },
  data () {
    return {
      uploadedImage: '',
      return_base64:'',
      sample_data:'',
      my_data:[],
      flg :0,
      file_type:'',

      dragover: false,
      files: [],
      logger: {},
      file: null,
      error: '',
      amplifyUI: AmplifyUI,

      my_data:this.my_data_box,
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
      this.file_type =this.file.type;
      this.uploadedImage = e.target.result;
      }
      reader.readAsDataURL(this.file);
    },
    options() {
      const defaults = {
        header: this.$Amplify.I18n.get('アイコン変更'),
        title: this.$Amplify.I18n.get('変更'),
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
      var up_image = new Image();
      const reader = new FileReader();
      reader.onload = (e) => {
      this.photo_size =this.file.size;
      this.size_txt = "ファイルサイズ[" + this.photo_size + " Bytes]";
      this.file_type = this.file.type;
      this.uploadedImage = e.target.result;
           up_image.src = reader.result;
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
     params.append('file_type',this.file_type);
     params.append('id',this.my_data_box['id']);
     params.append('is_judge_which',2);
     axios.post("api/users/change/userinfo",params).then(response => {
       this.flg=1;
       
       this.return_base64 = response['data'];
         this.sample_data = "data:"+this.file_type+";base64," + response['data'];
       console.log(this.file_type);
       location.reload(); //!後でちゃんと変更
       this.$set(this.my_data);

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