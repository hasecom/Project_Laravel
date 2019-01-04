<template>
    <div class="container">
        <div class="row">
          <div class="col-md-3"></div>
            <div class="col-6">
              <div class="mt-3">
                <div class="row mt-5">
                  <div class="col-md-12">
                         <div v-for="(item ,index) in time_line" v-bind:key="index">
                           <div class="card img-thumbnail mt-3 shadow-sm">
			                        <svg class="bd-placeholder-img card-img-top" width="100%" height="300" xmlns="http://www.w3.org/2000/svg" preserveAspectRatio="xMidYMid slice" focusable="false" role="img" aria-label="Placeholder: カードの画像"><title>プレースホルダ</title><rect fill="#868e96" width="100%" height="100%"></rect><text fill="#dee2e6" dy=".3em" x="30%" y="50%">no image</text></svg>
			                        <div class="card-body px-2 py-3">
                                <h5 class="card-title">{{item.photo_name}}</h5>
                                <p><span>{{item.user_name}}</span>   <span class="text-muted">@{{item.user_id}}</span></p>
                                <p class="card-text text-muted text-center">{{item.photo_description}}</p>
			                      </div>
                            <div class="row">
                                <p class="col-md-8">{{date_disassembly_out[index][0]}}年{{date_disassembly_out[index][1]}}月{{date_disassembly_out[index][2]}}日</p>
                                <p class="col-md-3 text-white bg-primary rounded">¥{{item.photo_price}}</p>   
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
      time_line_cnt:0,
      date_disassembly_out:[]
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
                     this.date_set();       
                    }
                    }).catch(function (error) {
                        console.log(error)
                    });
                    }
            }).catch(function (error) {
                console.log(error)
            });
    },date_set: function(){
          var date_disassembly =[];
          var date_synthesis = [];
          var date_bef = [];
          for(let j = 0; j < this.time_line.length; j++){
              date_bef[j] = this.time_line[j]['upload_date']
              date_disassembly[j] = date_bef[j].match(/\d{1,4}/g);
            //--01の0を消す処理だよ、できへんやん
            // for(let k = 0; k < date_disassembly[j].length; k++){
            //   date_synthesis[j][k]=date_disassembly[j][k].match(/0*([0-9]+)/)[1];  
            // }  
          }
          this.date_disassembly_out = date_disassembly;       
    }
  }
}
</script>
