<template>
    <div class="row mt-5">
         <div class="col-md-12">
             <div class="row">
                    <div class="col-md-6" v-for="(item ,index) in reverseItems" v-bind:key="index">
                        <div class="card img-thumbnail mt-3 shadow-sm">
			               <amplify-s3-image style="pointer-events: none;" :imagePath= "'Photos/'+item[reverseItems.length -1-index].photo_path+'/'+item[reverseItems.length -1-index].file_name+'.png'" ></amplify-s3-image>
                            <div class="card-body px-2 py-3">
                                <h5 class="card-title">{{item[reverseItems.length -1-index].photo_name}}</h5>
                                <p class="card-text text-muted text-center">{{item[reverseItems.length -1-index].photo_description}}</p>
			                </div>
                            <div class="row row_margin_del_">
                                <p class="col-md-4"></p>
                                <p class="col-md-8 card-text">¥{{item[reverseItems.length -1-index].photo_price}}</p>   
                            </div>
		                </div>
                    </div>
             </div>
        </div>
    </div>
</template>
<style>
.amplify-image{
    width:100% !important;
    height:auto;
}
</style>
<script>
//画像の遅延でこれ使いたいな=>https://www.kabanoki.net/2099

export default{
    data(){
        return{
            my_img_arr:[]
        }
    },mounted : function(){ 
        this.img_load_func()
        
    },methods:{
            img_load_func : function(){
            axios.get("api/users/chk").then(response => {
               if(typeof(response['data']) == "object"){
                axios.get("api/user/post_data/" + response['data']['user_id']).then(my_img_data => {
                   if(typeof(my_img_data['data']) == "object"){
                       let temp_arr =[];
                       for(let i = my_img_data['data'].length-1; 0 <= i; i-- ){
                      temp_arr[my_img_data['data'].length-i-1] =my_img_data['data'][i];
                       }
                        this.my_img_arr = my_img_data['data'];
                    }
                    }).catch(function (error) {
                        console.log(error)
                    });
                    }
            }).catch(function (error) {
                console.log(error)
            });
            }
    }, computed:{
    reverseItems(){
        return this.my_img_arr.slice().reverse();
    },

}
}

</script>
