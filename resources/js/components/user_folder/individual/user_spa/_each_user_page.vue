<template>
    <div>
<div class="container-fluid">
  <div class="row">
    <div class="col-md-6 col-sm-offset-3 bg-success">

       {{each_user_data.user_name}}のマイページだよ 
   <p>id:{{each_user_data.user_id}}</p>
   <p>name:{{each_user_data.user_name}}</p>
    <p>profile:{{each_user_data.si_text}}</p>
       </div>
  </div>
</div>

    </div>
</template>
<style>

</style>
<script>
export default {
     props:{
    id:{
        type: String,
      }
     },
    data(){
        return{
            each_user_id:"",
            page:"",
            each_user_data:[],
            
        }
    },
mounted : function() { 
            this.submit_user(this.$route.params['id']);
},watch:{
            '$route' (to, from) {
               this.submit_user(this.$route.params['id']);
            }
},methods:{
    submit_user: function (id) {
        let params = new URLSearchParams();
            axios.get("api/user/"+id,params).then(response => {
           this.each_user_data = response['data'];
            }).catch(function (error) {
               console.log(error);
            });
              }
         } 
}


</script>
