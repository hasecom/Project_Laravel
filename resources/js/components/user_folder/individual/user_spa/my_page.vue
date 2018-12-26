<template>
       <div>
        <div class="container">
            <div class="row">
              <div class="col-md-3"></div>
                 <div class="col-md-6">
                     <div class="mt-3">
                             <div class="card-body row align-items-center">
                                <span class="cover ml-5" v-bind:style="{ backgroundImage: 'url(storage/' + each_user_data.icon_path + '.jpg)' }"></span>
                                 <h4 class="card-title ml-5">{{each_user_data.user_name}}</h4>
                                <p class="pl-2 text-muted">{{each_user_data.user_id}}</p>
                            </div>
                            <div>
                               <button type="button" class="btn-sm border">フォロー</button>
                               <button type="button" class="btn-sm border">フォロワー</button>
                            </div>
                            <p class="card-text mt-3">{{each_user_data.si_text}}</p>
                     </div>         
                </div>   
                <div class="col-md-3"></div> 
            </div>
        </div>
    </div>
</template>
<style>

.cover{
    display: inline-block;
    background-color: #ccc;
    background-position: center center;
    background-repeat: no-repeat;
    width: 150px;
    height: 150px;
    background-size: cover;
    border-radius: 50%;
}
.card-title{
    display:block;
}


@media (max-width: 992px) {
  .container {
    min-width: 890px;
 
  }
}
@media (max-width: 768px) {
  .container {
    max-width:none !important;
  }
}
.rounded-circle{
    width: 150px;
    height: 150px;
    max-width:100%;
    max-height:100%;

}
</style>
<script>
export default {

    data(){
        return{
         each_user_data:[],
         account_id:""
        }
    },mounted : function() { 
            this.submit_user();
},watch:{
            '$route' (to, from) {
               this.submit_user();
            }
},methods:{
    submit_user: function () {
       axios.get("api/users/chk").then(response=>{
                   this.account_id = response['data'];
            axios.get("api/user/"+this.account_id).then(response => {
               if(typeof(response['data']) == "string"){
               }else{
           this.each_user_data = response['data']['my_data'];
             
               }
            }).catch(function (error) {
               console.log(error);
            });
  }).catch(function (error) {
               console.log(error);
            });

              }
         } 
}
</script>
