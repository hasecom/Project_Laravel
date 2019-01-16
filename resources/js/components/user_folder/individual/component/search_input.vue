<template>
    <div>
      <form class="form-inline" @submit.prevent="send_search">
        <input class="form-control mr-sm-2" type="search" aria-label="Search" v-model="search_word">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search </button>
    </form>
    </div>
</template>
<style>

</style>
<script>

import Search from '../user_spa/search_page.vue';
window.Vue = require('vue');


export default{
    data(){
        return{
            search_word:"",
        }
    },methods:{
        send_search(){
            console.log(this.search_word);
            this.temporary_url = "user#/search" + "?word=" + this.search_word; 
            this.$router.push({ path: "/search" + "?word=" + this.search_word ,component:Search });
            

        }
    }

}
</script>
