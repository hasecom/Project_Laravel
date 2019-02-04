<template>
    <div>
        <div @click="openModal">
         <amplify-s3-image :imagePath= "'UserIcons/2019-01-29 11:03:49/2019-02-02 14:12:21_hGM6vMlWIPZRkx5c.png'" ></amplify-s3-image>
         <amplify-s3-image :imagePath= "'UserIcons/'+ my_data.icon_path + '/' + my_data.icon_name + '.png'" ></amplify-s3-image>
         <span class="cover list_image set_click"  v-bind:style="{ backgroundImage: 'url(storage/' + my_data.icon_path + '.jpg)' }" ></span>
         <span class="small set_click">{{my_data.user_name}}</span>
         <span style="color:#f90">{{my_data.point}} pt</span>
         </div>
         <span>{{my_data.icon_path}}</span>
         <p>{{my_data['icon_path']}}</p>




<!-- ######################################################## -->
 <MyModal @close="closeModal" v-if="user_modal" class="border-0"> 
    <div class="row set_modal py-4 px-4">
        <div class="col-md-5 border-right">
    <div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">
         <a class="nav-link active" id="v-pills-home-tab" data-toggle="pill" href="#v-pills-home" role="tab" aria-controls="v-pills-home" aria-selected="true">プロフィール</a>
         <a class="nav-link" id="v-pills-icons-tab" data-toggle="pill" href="#v-pills-icons" role="tab" aria-controls="v-pills-icons" aria-selected="true">アイコン変更</a>
         <a class="nav-link" id="v-pills-pass-tab" data-toggle="pill" href="#v-pills-pass" role="tab" aria-controls="v-pills-pass" aria-selected="false">パスワードを変更</a>
         <a class="nav-link" id="v-pills-messages-tab" data-toggle="pill" href="#v-pills-messages" role="tab" aria-controls="v-pills-messages" aria-selected="false">メール設定</a>
         <a class="nav-link" id="v-pills-settings-tab" data-toggle="pill" href="#v-pills-settings" role="tab" aria-controls="v-pills-settings" aria-selected="false">プライバシーとセキュリティー</a>
         <a class="nav-link" id="v-pills-charge-tab" data-toggle="pill" href="#v-pills-charge" role="tab" aria-controls="v-pills-charge" aria-selected="false">チャージ</a>
    </div>
        </div>
        <div class="col-md-7">
            <div class="tab-content" id="v-pills-tabContent">
                <div class="tab-pane fade show active" id="v-pills-home" role="tabpanel" aria-labelledby="v-pills-home-tab"><set-profile :my_data_box="my_data" /></div>
                <div class="tab-pane fade" id="v-pills-icons" role="tabpanel" aria-labelledby="v-pills-icons-tab"><set-icons :my_data_box="my_data" /></div>
                <div class="tab-pane fade" id="v-pills-pass" role="tabpanel" aria-labelledby="v-pills-pass-tab"><set-pass :my_data_box="my_data" /></div>
                <div class="tab-pane fade" id="v-pills-messages" role="tabpanel" aria-labelledby="v-pills-messages-tab"></div>
                <div class="tab-pane fade" id="v-pills-settings" role="tabpanel" aria-labelledby="v-pills-settings-tab"><set-privacy /></div>
                <div class="tab-pane fade" id="v-pills-charge" role="tabpanel" aria-labelledby="v-pills-charge-tab"><charge-point :my_data_box="my_data"/></div>
            </div>
        </div>
    </div>

        </MyModal>
<!-- ######################################################## -->
    
    </div>
</template>
<style scoped>
.set_click{
    cursor: pointer;
}
.cover{
    display: inline-block;
    background-color: #ccc;
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    border-radius: 50%;
}

.modal_display{
  background:white;
  padding:50px 20px;
}
.list_image{
    width:30px;
    height:30px;
}
.set_modal{
   min-width:650px;
}
input, textarea{
width:100%;
padding:5px;
box-sizing:border-box;
-moz-box-sizing:border-box; /* Firefox */
-webkit-box-sizing:border-box; /* Chrome, Safari */
}
</style>
<script>

import MyModal from '../../user_modal/user_modal.vue';
window.Vue = require('vue');

export default{
    data(){
        return{
            my_data:[],
            user_modal: false, //modal表示・非表示
        }
    },components:{
        MyModal
    },
    mounted:function(){
        this.get_my_data()
    },
    watch:{
        my_data: {
      handler: function (val, oldVal) {
        console.log('watch 1', 'newval: ', val, '   oldVal:', oldVal)
        if(oldVal.length !=0){
            console.log("セッションキレてます。")
        }

      },
      deep: true
    }

    },
    methods:{
        get_my_data(){
            axios.get("api/users/chk").then(user_info => {
               if(typeof(user_info['data']) == "object"){
                this.my_data = user_info['data'];
                }
                }).catch(function (error) {
                    console.log(error)
                });
        },
        openModal(){         
      this.user_modal = true;
    },
    closeModal() {
      this.user_modal = false;
    },
    }

}
</script>
