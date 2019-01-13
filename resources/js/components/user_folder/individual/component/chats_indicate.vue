<template>
    <div>
       {{each_chats_data}}
    </div>
</template>
<style>

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
        }
    },
    methods:{
            chat_get(){
              axios.get("api/user/post_data/photo/chat/" + this.chats).then(chat_data => {
                if(typeof(chat_data['data']) == "object"){
                     this.each_chats_data = chat_data['data'];
                    }
                    }).catch(function (error) {
                        console.log(error)
                    });
            }
    },
    mounted:function(){
        this.chat_get();
    }

}

</script>
