<template>
    <div>
        <div class="row">
            <div class="col-md-1">
                <label for="comment_text"><i class="far fa-comment"></i></label>
            </div>
            <div class="col-md-7">
                <input class="form-control form-control-sm" id="comment_text" type="text" placeholder="コメントを追加" v-model="text_add"  @focus="onFocus"
                @keyup.enter="text_send"  @keypress="setCanMessageSubmit">
            </div>
            <div class="col-md-2" v-show="onFocus">
                 <span @click="text_send"><i class="far fa-paper-plane"></i></span>
            </div>
        </div>
    </div>
</template>
<style>

</style>
<script>
export default{
    props:{
    photo_data: {
        type:Object,
      },
    my_data:{
        type:Object
    }
    },
    data(){
        return{
            text_add:"",
            canMessageSubmit: false
            
        }
    },methods:{
         onFocus: function() {

    },
    setCanMessageSubmit() {
      this.canMessageSubmit = true
    },   
    onBlur: function() {
        
     
    },
    text_send:function(e){
    if (!this.canMessageSubmit) {
        return
      }
      
      this.canMessageSubmit = false;
        document.activeElement.blur();

        //TODO:テキスト内容の処理を
        //TODO:最後photo_id的なのをどうするか?バックエンドでもハッシュ化して照合？or暗号化?

        let params = new URLSearchParams();
              params.append('chat_text',this.text_add);
              params.append('photo_data',this.photo_data['photo_id']);
              params.append('my_data',this.my_data['id']);
      axios.post("api/user/post_data/photo/chat/" + this.photo_data['photo_id'],params).then(chat_data => {
        this.text_add="";
       if(typeof(chat_data['data']) == "object"){
           
                    }
                    console.log(chat_data['data']);
                    }).catch(function (error) {
                        console.log(error)
                    });
    }
        }
}
</script>
