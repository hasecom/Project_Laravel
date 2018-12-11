<template>
  <div>
    <div class="col-12 clearfix">
  <button type="button" class="float-right btn btn-primary" @click="select('signup')" >新規登録</button>
</div>

   <div class="txt_box border rounded">
  <div class="table-responsive">
         <table class="table table-hover">
            <tr>
                <th>管理者内部ID</th>
                <th>管理者ID</th>
               <th>管理者パスワード</th>
                <th>管理者レベル</th>
                <th><center>削除</center></th>
            </tr>
            <tbody>
            <tr v-for="item in admins" :key="item.id">
                <td v-text="item.id"  @click="select(item)"></td>
                <td v-text="item.admin_id"  @click="select(item)"></td>
                  <td v-text="item.admin_pw"  @click="select(item)"></td>
                <td v-text="item.admin_authority"  @click="select(item)"></td>
                 <td @click="select('delete')"><center><i class="far fa-trash-alt"></i></center></td>
            </tr>
            </tbody>
        </table>
    </div>

 <!-- コンポーネント MyModal -->
    <MyModal @close="closeModal" v-if="admin_modal" class="border-0">
     <div class="modal_display">
      
         <table class="table table-hover">
           <div v-if="display_judg == 0">
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
            <div v-if="display_judg == 1">
                <form action=""  @submit.prevent="signupForm">
               <caption>新規登録</caption>
 <tbody>
            <tr>
                <th>管理者内部ID</th>
                <td>Can't decide</td>
            </tr>
            <tr>
              <th>管理者ID</th>
              <td><input  class="form-control" type="text" v-model="sign_up_id"></td>
            </tr>
            <tr>
              <th>管理者パスワード</th>
              <td><input  class="form-control" type="text" v-model="sign_up_pw"></td>
            </tr>
            <tr> 
              <th>管理者レベル</th>
              <td>
                <select v-model="sign_up_authority">
                <option disabled value="">select</option>
                <option >1</option>
                 <option>2</option>
                 <option>3</option>
                </select>
              </td>
            </tr>
            </tbody>
             <br>
              <div class="text-center">
                <button type="submit" class="btn-lg btn-primary">新規作成</button>
                </div>     
           </form>
              </div>
        </table>
             <div v-if="display_judg == 2">
      <form action="">
               <p>一件のデータを削除しますか？</p>
               <button type="submit" class="btn btn-danger">削除</button> 
               <button type="submit" class="btn btn-default border">キャンセル</button>
        </form>
         </div>
     
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
      display_judg :0, //詳細 or 新規作成
      sign_up_id:"",
      sign_up_pw:"",
      sign_up_authority:""
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
    },
    signupForm: function(){
  //TODO:idの重複がないか、パスワードの文字数、権限レベル選ばれているか、記号のエスケープ
  let params = new URLSearchParams();
  params.append('sign_up_id',this.sign_up_id);
  params.append('sign_up_pw',this.sign_up_pw);
  params.append('sign_up_authority',this.sign_up_authority);
axios.post('admin_top',params).then(response => {
  location.reload();
}).catch(function (error) {
          console.log(error);
        });
    },  

    },
    computed: {
      select: function () {//テーブルの項目をクリックされた時の詳細情報
            self = this;
        return function (details_user) {
        //details_userがstringかオブジェクトか判定
        if(typeof(details_user)=="string"){
          if(details_user == "signup"){
          this.display_judg = 1;//新規登録modal
            this.openModal();
          }else if(details_user == "delete"){
            console.log("a");
            this.display_judg = 2;//削除modal
            this.openModal();
          }
        }else{ 
          this.display_judg = 0;//ユーザ詳細modal
          this.openModal();
           this.admin_data = details_user;
        }
        };   
    },
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