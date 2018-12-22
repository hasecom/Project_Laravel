<template>
    <div>
       他のユーザのマイページだよ 
       {{each_user_data}}
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
            each_user_data:""
        }
    },
  validate({params}){
    // 数値でなければならない
    return /^\d+$/.test(params.id)
  
},mounted : function() { 
            console.log("mouted:" + this.$route.params['id'])
            this.submit_user(this.$route.params['id']);
},watch:{
            '$route' (to, from) {
               console.log("watch:" + this.$route.params['id'])
               this.submit_user(this.$route.params['id']);
            }
},methods:{
    submit_user: function (id) {
        let params = new URLSearchParams();
            axios.get(id,params).then(response => {
           console.log(response);
           this.each_user_data = response['data'];
            }).catch(function (error) {
               console.log(error);
            });
              }
         } 
}


</script>
