<template>
    <div>
        <div v-for="(item , index) in each_chats_data" :key="index">
            <div class="row"> 
                <div class="col-md-1">   
                     <!-- <span class="cover list_image text-left" v-bind:style="{ backgroundImage: 'url(storage/' + item[0]['user_data'][0]['icon_path'] + '.jpg)' }"></span> -->
                     <div v-if="isLoad">
                          <amplify-s3-image   style="pointer-events:none;" :class="{chats_icon:isLoad}" :imagePath="'UserIcons/'+  item[0]['user_data'][0]['icon_path'] + '/' +  item[0]['user_data'][0]['icon_name'] + '.png'" ></amplify-s3-image>
                    </div>
                </div>
                <div class="col-md-10">
                    <span>{{item[0]['user_data'][0]['user_name']}}</span>
                    <span class="text-muted">{{item[0]['user_data'][0]['user_id']}}</span>&emsp;&emsp;
                    <span class="text-muted small">{{date_disassembly_out[index][0]}}年{{date_disassembly_out[index][1]}}月{{date_disassembly_out[index][2]}}日</span>
                     <p class="small">{{item[0]['comment_text']}}</p>  
                </div>
            </div>
        </div>
        
    </div>
</template>
<style>
.chats_icon img{
 width:30px !important;
 height:30px;
 border-radius: 50% !important;
 border:none !important;
 margin:0 !important;
}

.profile_icon{
     width: 150px;
    height: 150px;
}
.cover{
    display: inline-block;
    background-color: #ccc;
    background-position: center center;
    background-repeat: no-repeat;
    background-size: cover;
    border-radius: 50%;
}
.card-title{
    display:block;
}
</style>
<script>

export default{
    props:{
          chats: {
        type:Number,
      },
    },
    data(){
        return{
             each_chats_data:[],
             date_disassembly_out:[],
             isLoad:false,
        }
    }, 
    watch:{
    each_chats_data: {
      handler: function (val, oldVal) {
         this.isLoad = true;
      },
      deep: true
    },
    },
    methods:{
            chat_get(){
              axios.get("api/user/post_data/photo/chat/" + this.chats).then(chat_data => {
                if(typeof(chat_data['data']) == "object"){
                     this.each_chats_data = chat_data['data'];
                     this.date_set();
                    }
                    }).catch(function (error) {
                        console.log(error)
                    });
            },
            date_set(){
          var date_disassembly =[];
          var date_synthesis = [];
          var date_bef = [];
          for(let j = 0; j < this.each_chats_data.length; j++){
              date_bef[j] = this.each_chats_data[j][0]['comment_date'];
              date_disassembly[j] = date_bef[j].match(/\d{1,4}/g);
            //--01の0を消す処理だよ、できへんやん
            // for(let k = 0; k < date_disassembly[j].length; k++){
            //   date_synthesis[j][k]=date_disassembly[j][k].match(/0*([0-9]+)/)[1];  
            // }  
          }
          this.date_disassembly_out = date_disassembly;       
    },
    chat_update(){
       this.chat_get();
    },
    
    },
    mounted:function(){
        this.chat_get();
    }

}

</script>
