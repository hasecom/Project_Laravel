<template>
    <div>
    <div class="buy_btn btn-lg pointer" @click='openModal()'>
        購入
    </div>
        <SelectModal @close_select="closeModal" v-if="select_modal" class="border-0"> 
        <div class="set_modal shadow-lg" >
            <form class="text-center p-3" @submit.prevent="Buy_Form" >
               <p>この投稿を購入しますか？</p>
               <button type="submit" class="btn btn-info" >購入する</button> 
               <button type="button" @click="closeModal()" class="btn btn-default border">キャンセル</button>
        </form>
   
        </div>
        </SelectModal>
        </div>
</template>
<style>
.buy_btn{
    display: inline-block;
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
    }
    },components:{
        SelectModal
    },
    methods:{
        openModal(){         
        this.select_modal = true;
    },
        closeModal() {
      this.select_modal = false;
    },
    Buy_Form(){
           let params = new URLSearchParams();
            params.append('user_id',this.my_data['id']);
            params.append('photo_id',this.photo_data['photo_id']);
            params.append('covered_id',this.photo_data['id']);
       
          axios.post("api/user/post_data/point/trading",params).then(response=>{
             console.log(response['data'])
           }).catch(function (error) {
              console.log(error);
           });
    }
    }
}
</script>
