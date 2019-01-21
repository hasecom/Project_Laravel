<template>
    <div>
        <form class="form-inline" @submit.prevent="send_search">
            <input class="form-control mr-sm-2" type="search" placeholder="検索" aria-label="Search" v-model="search_word"  @focus="onFocus" @blur="onBlur">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search </button>
        </form>
        <div class="balloon2-top border" v-if="isWord">
            <div  v-if="0 < search_result.length">
               <div v-for="(item,index) in search_result" :key='index' @mousedown="tag_click(item)">
                   <div class="row pl-2 pt-3 pb-3 search_item"> 
                       <div class="col-md-9">
                        <span class="h5">#</span>{{item.tag_name}}
                       </div>
                       <div class="col-md-3">
                        {{item.tag_cnt}}件
                        </div>
                    </div>
                </div>
            </div>
            <div v-else>
                <span class="small">一致する検索結果はありませんでした。</span>
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
        }
    },watch:{
        search_word: function(oldval ,newval){
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
                if(this.search_word .length == 0 && this.search_word .indexOf('') != -1){
                return false;
            }
            this.$router.push({ path: "/search" + "?word=" + this.search_word ,component:Search });
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
                    this.search_result = assist_word_response['data'];  
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
            }else{
            let emp_word = val.replace(/\s+/g, ""); 
            return emp_word;
            }
        }
                    }

}
</script>

<style>

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