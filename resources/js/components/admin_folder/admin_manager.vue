<template>
  <div>
    <div class="col-12 clearfix">
  <button type="button" class="float-right btn btn-primary" @click="select('新規登録')" >新規登録</button>
</div>

   <div class="txt_box border rounded">
  <div class="table-responsive">
         <table class="table table-hover">
            <tr>
                <th>管理者内部ID</th>
                <th>管理者ID</th>
               <th>管理者パスワード</th>
                <th>管理者レベル</th>
            </tr>
            <tbody>
            <tr v-for="item in admins" :key="item.id" @click="select(item)">
                <td v-text="item.id"></td>
                <td v-text="item.admin_id"></td>
                  <td v-text="item.admin_pw"></td>
                <td v-text="item.admin_authority"></td>
            </tr>
            </tbody>
        </table>
    </div>

 <!-- コンポーネント MyModal -->
    <MyModal @close="closeModal" v-if="admin_modal" class="border-0">
     <div class="modal_display">
      
         <table class="table table-hover">
           <div v-if="display_judg == true">
           <caption>
             {{admin_fnc().admin_id}}
              <button @click="edit_btn" class="float-right  btn-{themecolor} badge-pill"><i class="fas fa-user-edit"></i></button>
           </caption>
    
           <tbody>
            <tr>
                <th>管理者内部ID</th>
                <td>{{admin_fnc().id}}</td>
                <td></td>
            </tr>
            <tr>
              <th>管理者ID</th>
              <td>{{admin_fnc().admin_id}}</td>
              <td></td>
            </tr>
            <tr>
              <th>管理者パスワード</th>
              <td>{{admin_fnc().admin_pw}}</td>
              <td></td>
            </tr>
            <tr> 
              <th>管理者レベル</th>
              <td>{{admin_fnc().admin_authority}}</td>
              <td></td>
            </tr>
            </tbody>
            </div>
<!-- 新規登録 -->
            <div v-if="display_judg == false">
               <caption>新規登録</caption>
 <tbody>
            <tr>
                <th>管理者内部ID</th>
                <td>Can't decide</td>
            </tr>
            <tr>
              <th>管理者ID</th>
              <td><input  class="form-control" type="text"></td>
            </tr>
            <tr>
              <th>管理者パスワード</th>
              <td><input  class="form-control" type="text"></td>
            </tr>
            <tr> 
              <th>管理者レベル</th>
              <td>
                <select>
                <option disabled value="">Please select one</option>
                <option>1</option>
                 <option>2</option>
                 <option>3</option>
                </select>
              </td>
            </tr>
            </tbody>
            
            <br>

           
              <div class="text-center">
                <button type="button" class="btn-lg btn-primary">新規作成</button>
                </div>
           
              </div>
        </table>
       
      </div>
    </MyModal>

    </div>
  </div>
  
</template>

<script>
import MyModal from './admin_modal/admin_manager_modal.vue'
window.Vue = require('vue');

//親要素(main)からデータをpropsで取得
export default {
  name:"Receive_Data",
    props: {
      admin_info_str: {
        type:String,
      }
      },components: { 
        MyModal 
        },
      data(){
    return{
     admin_info:this.admin_info_str,
     admins:[],
      admin_modal: false, //modal表示・非表示
      admin_data:"",
      display_judg : true, //詳細 or 新規作成
    }
  },   
  methods: {
      get_admins_info() {//adminの情報
           this.admins = JSON.parse(this.admin_info);
        },
       openModal() {
      this.admin_modal = true;
    },
      closeModal() {
      this.admin_modal = false;
    },
      admin_fnc(){//admin_dataの値を埋め込む
       return this.admin_data;
      },
    edit_btn:function(){//編集機能
      console.log("OK");
    }
    },
    computed: {
      select: function () {//テーブルの項目をクリックされた時の詳細情報
            self = this;
        return function (details_user) {
            console.table(details_user)
        //details_userがstringかオブジェクトか判定
        if(typeof(details_user)=="string"){
          this.display_judg = false;//新規登録modal
            this.openModal();
            
        }else{ 
          this.display_judg = true;//ユーザ詳細modal
          this.openModal();
           this.admin_data = details_user;
        }
        };
            
         
    }
    },

    mounted() {
        this.get_admins_info();
    },

    }
    


</script>
<style>
.modal_display{
  background:white;
  padding:50px;
}

caption {
caption-side:top;
text-align: center;
font-weight: bold;
font-size:x-large;
}
</style>