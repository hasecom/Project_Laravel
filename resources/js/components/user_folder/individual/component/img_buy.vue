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
             
             画像をだうんろーど
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
        now_query:[]
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
    }
    }
}
</script>
