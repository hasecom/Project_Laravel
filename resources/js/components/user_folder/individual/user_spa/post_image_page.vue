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
  methods: {
    openModal() {
      this.img_modal = true;
    },
    closeModal() {
      this.img_modal = false;
    },
  },  

}
</script>
