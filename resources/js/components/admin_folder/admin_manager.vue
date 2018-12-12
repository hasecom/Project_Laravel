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
                <th class="text-center">編集</th>
                <th class="text-center">削除</th>
            </tr>
            <tbody>
            <tr v-for="item in admins" :key="item.id">
                <td v-text="item.id"  @click="select(item)"></td>
                <td v-text="item.admin_id"  @click="select(item)"></td>
                  <td v-text="item.admin_pw"  @click="select(item)"></td>
                <td v-text="item.admin_authority"  @click="select(item)"></td>
                  <td @click="edit_user(item)" class="text-center"><i class="far fa-edit"></i></td>
                 <td @click="delete_user(item.id)" class="text-center"><i class="far fa-trash-alt"></i></td>
           
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
<!-- 編集 -->
<div v-if="display_judg == 3">
        <form class="text-center" @submit.prevent="editForm" >
           <caption>
             {{update_admin_id}}  
           </caption>
           <tbody>
            <tr>
                <th>管理者内部ID</th>
                <td>{{admin_inner_id}}</td>
                <td></td>
            </tr>
            <tr>
              <th>管理者ID</th>
              <td><input type="text" v-model="update_admin_id"></td>
              <td></td>
            </tr>
            <tr>
              <th>管理者パスワード</th>
              <td><input type="text" v-model="update_admin_pw"></td>
              <td></td>
            </tr>
            <tr> 
              <th>管理者レベル</th>
              <td><input type="text" v-model="update_admin_authority"></td>
              <td></td>
            </tr>
            </tbody>
           <br>        
               <button type="submit" class="btn btn-primary" >変更する</button> 
               <button type="button" @click="closeModal()" class="btn btn-default border">キャンセル</button>
        </form>
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
                <button type="button" @click="closeModal()" class="btn-lg btn-default border">キャンセル</button>
                </div>     
           </form>
              </div>
        </table>
<!--削除 -->
             <div v-if="display_judg == 2">
      <form class="text-center" @submit.prevent="deleteForm" >
               <p>一件のデータを削除しますか？</p>
               <button type="submit" class="btn btn-danger" >削除</button> 
               <button type="button" @click="closeModal()" class="btn btn-default border">キャンセル</button>
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
      sign_up_authority:"",
      admin_inner_id:"",//delete時に必要なユーザの内部ID
      update_admin_id:"",//更新ID
      update_admin_pw:"",//更新PW
      update_admin_authority:""//更新レベル

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
  deleteForm:function(){
    //ユーザ削除の処理
  let params = new URLSearchParams();
  params.append('admin_inner_id',this.admin_inner_id);
axios.post('admin_top',params).then(response => {
  location.reload();
}).catch(function (error) {
          console.log(error);
        });
  },
  editForm:function(){
    //ユーザ編集の処理
  let params = new URLSearchParams();
   params.append('admin_inner_id',this.admin_inner_id);
  params.append('update_admin_id',this.update_admin_id);
  params.append('update_admin_pw',this.update_admin_pw);
  params.append('update_admin_authority',this.update_admin_authority);
  
axios.post('admin_top',params).then(response => {
 location.reload();
}).catch(function (error) {
          console.log(error);
        });
  }
    },
    computed: {
      select: function () {//テーブルの項目をクリックされた時の詳細情報
            self = this;
        return function (details_user) {
        //details_userがstringかオブジェクトか判定
        if(typeof(details_user)=="string"){
          this.display_judg = 1;//新規登録modal
            this.openModal();
        }else{ 
          this.display_judg = 0;//ユーザ詳細modal
          this.openModal();
           this.admin_data = details_user;
        }
        };   
    },delete_user: function(){
           self = this;
        return function (details_user) {
            console.log(details_user);
            this.display_judg = 2;//削除modal
            this.admin_inner_id = details_user;
            this.openModal();
       }; 
    },edit_user:function(){
      self = this;
      return function(details_user){
        this.display_judg = 3;//編集modal
      this.update_admin_id =details_user.admin_id;
      this.update_admin_pw=details_user.admin_pw;
      this.update_admin_authority=details_user.admin_authority;
      this.admin_inner_id = details_user.id;
        this.openModal();
      }
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