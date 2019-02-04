<template>
    <div class="row mt-5">
         <div class="col-md-12">
             <div class="row">
                    <div class="col-md-6" v-for="(item ,index) in reverseItems" v-bind:key="index">
                        <div class="card img-thumbnail mt-3 shadow-sm">
			                <!--<svg class="bd-placeholder-img card-img-top" width="100%" height="150" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: カードの画像"><title>プレースホルダ</title><rect fill="#868e96" width="100%" height="100%"></rect><text fill="#dee2e6" dy=".3em" x="30%" y="50%">no image</text></svg>-->
                           <div class="img_layer">
			               <amplify-s3-image style="pointer-events: none;" :imagePath= "'Photos/'+item[reverseItems.length -1-index].photo_path+'/'+item[reverseItems.length -1-index].file_name+'.png'" ></amplify-s3-image>
                           </div>
			                <div class="card-body px-2 py-3">
                                <h5 class="card-title">{{item[reverseItems.length -1 -index].photo_name}}</h5>
                                <p class="card-text text-muted">{{item[reverseItems.length -1 -index].photo_description}}</p>
			                </div>
                            <div class="row">
                                <p class="col-md-8"></p>
                                <p class="col-md-3 card-text text-white bg-primary rounded">¥{{item[reverseItems.length -1 -index].photo_price}}</p>   
                            </div>
		                </div>
                    </div>
             </div>
        </div>
    </div>
</template>
<style>
.img_layer div .amplify-image{
    height:400px !important;
    width:auto !important;
    max-width:100% !important;
    max-height:100% !important;
    margin:0 !important;
    pointer-events:none !important;
    object-fit: contain !important;
    border:none !important;
    border-radius:0px !important;
}
.img_layer{
  width:auto !important;
  height:auto !important;
  background-color:#f8f9fa;
  
  display: table-cell !important; /*上下中央*/
  text-align: center !important; /*左右中央*/
  vertical-align: middle !important; /*上下中央*/

}
</style>
<script>
//画像の遅延でこれ使いたいな=>https://www.kabanoki.net/2099

export default{
      props: {
      each_user_img:{
        type:String,
    }
   
    },
    data(){
        return{
            my_img_arr:[],
        }
    },watch:{
         each_user_img(value, oldValue) {
              this.img_load_func()
    },
    }
    ,mounted : function(){ 
        this.img_load_func()
    }
    ,methods:{
            img_load_func : function(){
                axios.get("api/user/post_data/" + this.each_user_img).then(my_img_data => {
                   if(typeof(my_img_data['data']) == "object"){
                        this.my_img_arr = my_img_data['data'];
                    }
                    }).catch(function (error) {
                        console.log(error)
                    });
         
            }
    },computed:{
    reverseItems(){
        return this.my_img_arr.slice().reverse();
    },
    }

}

</script>
