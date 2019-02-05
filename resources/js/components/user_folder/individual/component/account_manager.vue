<template>
    <div>
        <div @click="openModal">
      
            <div v-if="data1 != 'underfind'" >
                <amplify-s3-image style="pointer-events:none;" :class='{IconImg:isLoad}' :imagePath="'UserIcons/'+ data1 + '/' + data2 + '.png'" ></amplify-s3-image>
            </div>
         <!--<span v-if="data1 == 'underfind'">
             <i class="fas fa-user"></i>
         </span>-->
         <div>
            <span class="small set_click">{{my_data.user_name}}</span>
            <span style="color:#f90">{{my_data.point}} pt</span>
        </div>
    </div>


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
<style>
.IconImg img{
 width:30px !important;
 height:30px;
 border-radius: 50% !important;
 border:none !important;
 margin:0 !important;
}
</style>
<style scoped>
.set_click{
    cursor: pointer;
}


/*.amplify-image{
    /*
    *反映されてない 
    */
    /*display: inline-block !important;
    background-color: #ccc !important;
    background-position: center center !important;
    background-repeat: no-repeat !important;
    background-size: cover !important;
    border-radius: 50% !important;
    width:30px !important;
    height:30px !important;
    margin:0px !important;
    border:0px !important;*/

/*  default setting
    width:30%;
    margin:.2em;
    border-radius:6px;
    border:2px solid var(--color-white);
    cursor:pointer;*/




.modal_display{
  background:white;
  padding:50px 20px;
}
/*.list_image{
    width:30px;
    height:30px;
}*/
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
            data1 :'underfind',
            data2:'underfind',
            isLoad:false,
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
        this.data1 = val.icon_path;
        this.data2 = val.icon_name;
        this.isLoad = true;
        console.log('aa');
        if(oldVal.length !=0){
            console.log("セッションキレてます。")
        }

      },
      deep: true
    },
     '$route' (to, from) {
   this.get_my_data();
    },

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
