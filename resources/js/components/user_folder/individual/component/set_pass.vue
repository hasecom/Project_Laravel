<template>
    <div>
        <form @submit.prevent="chk_fnc">
        <div class="row">
            <div class="col-md-4">
                <label for="old_pass">現在のパスワード</label>
            </div>
            <div class="col-md-7">
                <input type="password"  id="old_pass" v-model="old_pass"/>
                <div v-if="careful == 1" class="small  text-danger">※パスワードを間違えています。</div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="new_pass">新しいパスワード</label>
            </div>
            <div class="col-md-7">
                <input type="password" id="new_pass"  v-model="new_pass" />
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="new_pass_chk">新しいパスワード再入力</label>
            </div>
            <div class="col-md-7">
                <input type="password" id="new_pass_chk" v-model="new_pass_chk" />
                <div v-if="careful == 2" class="small  text-danger">※パスワードが一致していません。</div>
                        <div v-if="careful == 3" class="small  text-danger">※パスワードを入力してください。</div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary btn-sm">変更を保存</button>
        <button type="button" class="btn btn-default btn-sm">保存しない</button>
        </form>
    </div>
</template>
<style>
</style>
<script>
export default{
    props:{
        my_data_box:{
            type:Object
        }
    },
    data(){
        return{
           old_pass:'',
           new_pass:'',
           new_pass_chk:'',
            my_data:this.my_data_box,
            careful:0
        }
    },mounted:function(){
       this.careful =0;
    },methods:{
        chk_fnc(){
            if(0 < this.new_pass.length && 0 < this.old_pass.length){
            }else{
                console.log("jfei")
                this.careful = 3;
                return false;
            }
                if(this.new_pass != this.new_pass_chk){
                //新しいパスと確認パスが一致しなかったら
                    this.careful = 2;
                    return false;
                }
            
            this.send_data();
        },
        send_data(){
            this.careful = 0;
         let params = new URLSearchParams();
            params.append('id',this.my_data['id']);
           params.append('new_pass',this.new_pass);
           params.append('old_pass',this.old_pass);
           params.append('is_judge_which',1);
          axios.post("api/users/change/userinfo",params).then(response=>{
              console.log(response['data'])
              if(response['data'] == 'wrong_pass'){this.careful =1;}
              else{
                  this.careful = 0;
              }
            //  location.reload();
            //     this.$set(this.my_data);
           }).catch(function (error) {
              console.log(error);
           });
        },
        get_pass(){

        }
    }
}
</script>
