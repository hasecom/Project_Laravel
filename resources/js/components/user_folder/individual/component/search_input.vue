<template>
    <div>
        <form class="form-inline" @submit.prevent="send_search">
            <input class="form-control mr-sm-2" type="search" placeholder="検索" aria-label="Search" v-model="search_word"  @focus="onFocus" @blur="onBlur">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search </button>
        </form>
        <div class="balloon2-top border" v-if="isWord">
               {{search_word}}
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
        }
    }
    ,methods:{
        send_search(){
            this.$router.push({ path: "/search" + "?word=" + this.search_word ,component:Search });
        },
        isWordLength(val){//文字数
           let word_length = val.length;
           if( 0 < word_length){
               return true;
           }
           return false;
        },
        onFocus(){
            if(0 <this.search_word.length){
                this.isWord = true;
                this.assist_word();
            }
        },
        onBlur(){
            this.isWord = false;
        },
        assist_word(){
            console.log(this.search_word)

        },
        axios_search(){
                axios.get().then(assist_word_response => {   
                    }).catch(function (error) {
                console.log(error);
                    });
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