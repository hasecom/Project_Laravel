<template>
    <div style='width:100%;'>
    <div class="buy_btn btn-lg pointer" @click='openModal()'>
        購入
    </div>
        <SelectModal @close_select="closeModal" v-if="select_modal" class="border-0"> 
        <div class="set_modal shadow-lg" v-if='modal_type == 0'>
            <form class="text-center p-3" @submit.prevent="Buy_Form" >
               <p>この投稿を購入しますか？</p>
               <button type="submit" class="btn buy_btn_in" >購入する</button> 
               <button type="button" @click="closeModal()" class="btn btn-default border">キャンセル</button>
        </form>
        </div>
        <div class="set_modal shadow-lg" v-if='modal_type == 1'>
        <p>ポイントが足りません</p>
        </div>
         <div class="set_modal shadow-lg" v-if='modal_type == 2'>
             <!-- //TODO:画像ダウンロード処理はここに書く############### -->
             <form @submit.prevent="DL_img">
             <button type="submit">画像をだうんろーど</button>
             </form>
              <!-- //TODO:######################################### -->
        </div>
        </SelectModal>
        </div>
</template>
<style>
.buy_btn_in{
    background-color: rgb(0, 191, 255);
    color:white;
}
.buy_btn_in:hover{
    background-color: rgba(0,191,255,0.7);
}
.buy_btn{
    display:block;
    background-color: rgb(0, 191, 255);
    color:white;
    text-align: center;
}
.buy_btn:hover{
    background-color: rgba(0,191,255,0.7);
 
}

</style>
<script>

// import AmplifyEventBus from '../../../../../../node_modules/aws-amplify-vue/src/events/AmplifyEventBus';

import SelectModal from '../../user_modal/select_modal.vue';
window.Vue = require('vue');
export default{
    props:{
        photo_data:{
            type:Object
        },
        my_data:{
            type:Object
        }

    },
    data(){
    return{
         select_modal:false, //modal表示・非表示
         modal_type:0,
        now_query:[],
        dl_data:'',
        file_data:'',
        base64:'',
    }
    },components:{
        SelectModal,
    },
    methods:{
        openModal(){ 
            this.now_query = this.$route.query;
        this.select_modal = true;
        
        
    },
        closeModal() {
            this.modal_type = 0;
    this.$router.push({ query:this.now_query })
      this.select_modal = false;
      
    },
    toBlob(base64) {
    var bin = atob(base64.replace(/^.*,/, ''));
    var buffer = new Uint8Array(bin.length);
    for (var i = 0; i < bin.length; i++) {
        buffer[i] = bin.charCodeAt(i);
    }
    // Blobを作成
    try{
        var blob = new Blob([buffer.buffer], {
            type: 'image/png'
        });
    }catch (e){
        return false;
    }
    // return blob;
    a.href = window.URL.createObjectURL(blob);
},

    Buy_Form(){
           let params = new URLSearchParams();
            params.append('user_id',this.my_data['id']);
            params.append('photo_id',this.photo_data['photo_id']);
            params.append('covered_id',this.photo_data['id']);

       
          axios.post("api/user/post_data/point/trading",params).then(response=>{
              this.$router.push({ query:Math.random().toString(36).slice(-8)});
              if(response['data'] == 2){
              this.modal_type = 2;





              }else if(response['data'] == 1){
                  this.modal_type = 1;
              }
           }).catch(function (error) {
              console.log(error);
           });
    },
    DL_img(){
        let params = new URLSearchParams();
        params.append('user_id',this.my_data['id']);
        params.append('photo_id',this.photo_data['photo_id']);
        params.append('file_name',this.photo_data['file_name']);
        params.append('photo_path',this.photo_data['photo_path']);
        axios.post("api/user/post_data/photo/buy_data",params).then(buy_img_data => {
            console.log(buy_img_data['data']);
            this.file_data = buy_img_data['data'];

            // this.return_base64 = response['data'];
            // this.sample_data = "data:"+this.file_type+";base64," + response['data'];
          }).catch(function (error) {
          console.log(error);
        });
    }
    }
}
</script>
