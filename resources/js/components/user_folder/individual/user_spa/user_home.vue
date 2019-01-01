<template>
    <div class="container">
        <div class="row">
          <div class="col-md-3"></div>
            <div class="col-6">
              <div class="mt-3">
                <div class="row mt-5">
                  <div class="col-md-12">
                      <div class="row">
                         <div class="col-md-6" v-for="(item ,index) in time_line" v-bind:key="index">
                           <div class="card img-thumbnail mt-3 shadow-sm">
			                        <svg class="bd-placeholder-img card-img-top" width="100%" height="150" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: カードの画像"><title>プレースホルダ</title><rect fill="#868e96" width="100%" height="100%"></rect><text fill="#dee2e6" dy=".3em" x="30%" y="50%">no image</text></svg>
			                        <div class="card-body px-2 py-3">
                                <h5 class="card-title">{{item.photo_name}}</h5>
                                <p class="card-text text-muted text-center">{{item.photo_description}}</p>
			                      </div>
                            <div class="row">
                                <p class="col-md-8"></p>
                                <p class="col-md-3 card-text text-white bg-primary rounded">¥{{item.photo_price}}</p>   
                            </div>
		                      </div>
                        </div>
                    </div>
                  </div>
                </div>
              </div> 
            </div>  
            <div class="col-md-3"></div> 
        </div>
     </div>
</template>
<style>

</style>
<script>
export default{
  data(){
    return{
      time_line:[],
      time_line_cnt:0
    }
  },mounted:function(){
      this.get_timeline_data();
  },methods:{
    get_timeline_data:function(){
      axios.get("api/users/chk").then(response => {
               if(typeof(response['data']) == "object"){
                axios.get("api/user/post_data/timeline/data").then(time_line_data => {
                   if(typeof(time_line_data['data']) == "object"){
                         this.time_line_cnt = this.time_line.length;
                         this.time_line = time_line_data['data'];
                    }
                    }).catch(function (error) {
                        console.log(error)
                    });
                    }
            }).catch(function (error) {
                console.log(error)
            });
    }
  }
}
</script>
