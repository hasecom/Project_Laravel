<template>
    <div  @keyup.up="key_up" @keyup.down="key_down">
        <form class="form-inline" @submit.prevent="send_search">
            <input class="form-control mr-sm-2" type="search" placeholder="検索" aria-label="Search"  autocomplete="off" v-model="search_word"  @focus="onFocus" @blur="onBlur" id="search_input">
            <button class="btn btn-outline-success my-2 my-sm-0 search_" type="submit">Search </button>
        </form>
        <div class="balloon2-top border" v-if="isWord" >
            <div  @mouseenter="in_candidate" @mouseleave="out_candidate">
            <div  v-if="0 < search_result.length || 0 < user_search.length">
               <div v-for="(item,index) in search_result" :key='index' @mousedown="tag_click(item)" class="search_item" >
                   <div class="row pl-2 pt-3 pb-3" :id="'search' + index" :ref="'search_word_ref' + index"> 
                       <div class="col-md-9">
                        <span class="h5">#</span><span :id="'search_ws' + index">{{item.tag_name}}</span>
                       </div>
                       <div class="col-md-3">
                        {{item.tag_cnt}}件
                        </div>
                    </div>
                </div>
                    <div v-for="(user_item ,count) in user_search" :key="count+1"  @mousedown="user_click(user_item.user_id)">
                   <div class="row pl-2 pt-3 pb-3 search_item" :id="'search' + (search_result.length + count)"   :ref="'search_word_ref' + (search_result.length + count)"> 
                       <div class="col-md-2">
                           <span class="cover list_image"  v-bind:style="{ backgroundImage: 'url(storage/' + user_item.icon_path + '.jpg)' }"></span>
                       </div>
                       <div class="col-md-3">
                        {{user_item.user_name}}
                       </div>
                       <div class="col-md-3">
                        <span class="small text-muted" :id="'search_ws' + (search_result.length + count)">@{{user_item.user_id}}</span>
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <span class="small">一致する検索結果はありませんでした。</span>
            </div>
        </div>
     </div>
    </div>
</template>

<script>

import Search from '../user_spa/search_page.vue';
window.Vue = require('vue');


export default{
    data(){
        return{
            search_word:"",
            isWord:false,
            search_result:[],
            user_search:[],
            get_id:"",
            select_num:0,
            select_data:"",  
        }
    },watch:{
        search_word:function(oldval ,newval){
            if(0 < newval.length && oldval.length == 0){
               this.isWord = false;
            }
            if(this.isWordLength(oldval) == true){
                this.isWord = true;
                this.assist_word();
            };
        },


    }
    ,methods:{
        send_search(){
        var search_refs = this.select_num;
        var datas=document.getElementById('search_ws' + this.select_num);
         this.select_data = datas.textContent;
      if(this.search_result.length == 0 && this.user_search.length == 0){return false;}
       
        if(this.search_word .length == 0 && this.search_word .indexOf('') != -1){
                return false;
            }

    if(0 <= this.select_data.indexOf('@')){
        var user_id_search = this.select_data.slice(1);
    
       this.user_click(user_id_search);
        return false;
        }
            document.getElementById('search_input').blur();
            this.$router.push({ path: "/search" + "?word=" + this.select_data  ,component:Search });
            this.isWord = false;

        },
        isWordLength(val){//文字数
           let word_length = val.length;
           if( 0 < word_length){
               return true;
           }
           return false;
        },
        onFocus(e){
            if(0 <this.search_word.length){
                this.isWord = true;
                this.assist_word();
                 
            }
        },
        onBlur(){
            this.isWord = false;
        },
        assist_word(){
           
          this.axios_search(this.word_check(this.search_word));

        },
        axios_search(val){
            if(val.length == 0 && val.indexOf('') != -1){
                return false;
            }
      
                axios.get('api/user/post_data/photo/tags/' + val).then(assist_word_response => {  
                    this.user_search = assist_word_response['data'][1];
                    this.search_result = assist_word_response['data'][0];  
                    
                    }).catch(function (error) {
                console.log(error);
                    });
                        },
        tag_click(data){
           this.$router.push({ path: "/search" + "?word=" + data['tag_name'] ,component:Search });
        },word_check(val){
            //TODO:そのほかの記号もエスケープ/\
            if(val.indexOf('#') != -1){
              let word = val.split('#').join('');         
              let emp_word = word.replace(/\s+/g, ""); 
             return  emp_word;
            }else if(val.indexOf('@') != -1){
            let word = val.split('@').join('');   
               let emp_word = word.replace(/\s+/g, ""); 
               return  emp_word;
            }else{
            let emp_word = val.replace(/\s+/g, ""); 
            return emp_word;
            }
        },
        user_click(val){
            document.getElementById('search_input').blur();
            this.isWord = false;
        this.$router.push('/'+val);
        
    },
 
 class_input(){
   this.get_id =document.getElementById('search'+this.select_num);
    this.get_id.style.backgroundColor = 'rgba(184,188,192,0.2)';
 }
 ,key_up(){
     if(0 < this.select_num){
     this.select_num = this.select_num - 1;
     this.class_input();
 document.getElementById('search'+(this.select_num +1)).style.backgroundColor = 'white';
     }
 },key_down(){
        var max_length=  this.search_result.length + this.user_search.length -1;
        if(this.select_num < max_length){
     this.select_num = this.select_num + 1;
    
     this.class_input();
     
    document.getElementById('search'+(this.select_num -1)).style.backgroundColor = 'white';
     }
           
 },
 in_candidate(){
     if(this.chk_word() == 1){return false;}
document.getElementById('search0').style.background ='white';
 },
 out_candidate(){
    if(this.chk_word() == 1){return false;}
document.getElementById('search0').style.background ='rgba(184,188,192,0.2)';
 },
 chk_word(){
    if(this.search_result.length == 0 && this.user_search.length == 0){
        return 1;
        }else{
            return 0;
        }
 }

},

}
</script>

<style scoped>
:root {
    --normal_background:whitesmoke;
}
 .search_{
    border-color:#ff9900;
    color:#ff9900;
}
 .search_:hover{
    background:#ff9900;
    color:white;  
}
.search_item{
    cursor: pointer;
}
#search0{
    background: rgba(184,188,192,0.2);
}


.search_item:hover{
    background:rgba(184,188,192,0.2) !important;
}

.balloon2-top {
 	position: fixed;
	display: inline-block;
 	margin: 1.5em 1.5em;
	padding: 7px 10px;
    width: 300px;
    min-height:0px;
    max-height:40%;
 	color: #555;
	font-size: 16px;
	background: #FFF;
 	box-sizing: border-box;
    z-index:100;
    overflow-y: scroll;
    overflow-x: hidden;
   
}



.balloon2-top p {
	margin: 0;
	padding: 0;
}
</style>