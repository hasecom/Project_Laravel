<template>
    <div class="set_profile_">
    <form @submit.prevent="send_data">
        <div class="row">   
            <div class="col-4">
                <span class="cover list_image"  v-bind:style="{ backgroundImage: 'url(storage/' + my_data.icon_path + '.jpg)' }"></span>
            </div>
            <div class="col-5">
                <span class="text-muted">{{my_data.user_id}}</span>
            </div>
        </div>
        <div class="text-center">プロフィール画像を変更する</div>
        <div class="row">
            <div class="col-md-4">
                <label for="name_change"  >名前:</label>
            </div>
            <div class="col-md-7">
                <input type="text" id="name_change" v-model="name">
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <label for="profile_text">自己紹介文:</label>
            </div>
            <div class="col-md-7">
                <textarea class="form-control" rows="3" id="profile_text" v-model="profile_text"></textarea>
            </div>
        </div>
        <button type="submit" class="btn btn-primary btn-sm">変更を保存</button>
        <button type="button" class="btn btn-default btn-sm">保存しない</button>
        </form> 
    </div>
</template>
<style>
.set_profile_{
    color:black;
}
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
           name:'',
           profile_text:'',
           my_data:this.my_data_box,
        }
    },mounted:function(){
        this.name = this.my_data_box['user_name'];
        this.profile_text = this.my_data_box['si_text'];
    },methods:{
        send_data(){
         let params = new URLSearchParams();
           params.append('user_name',this.name);
           params.append('id',this.my_data_box['id']);
           params.append('si_text',this.profile_text);
           params.append('is_judge_which',0);
          axios.post("api/users/change/userinfo",params).then(response=>{
              this.my_data = response['data'];
              location.reload();
                 this.$set(this.my_data);
           }).catch(function (error) {
              console.log(error);
           });
        }
    }
}
</script>
