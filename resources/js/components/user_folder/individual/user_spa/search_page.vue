<template>
    <div>
        <div class="row">
        <div v-for="(item , index) in search_data" :key="index" class="col-md-3">
                <div >{{item}}</div>
        </div>
        </div>
    </div>
</template>

<script>

export default{
    data(){
        return{
            search_word_send:'',
            search_data:[],
        }
    },watch: {
    '$route' (to, from) {
      this.search_word_send = this.$route['query'];
      this.search_word();
    },
    },
    mounted:function(){
    this.search_word_send = this.$route['query'];
    this.search_word();
         
    },
    methods:{
    search_word(){
             axios.get('api/user/post_data/photo/search/' + this.search_word_send['word']).then(search_word_response => {  
                        this.search_data = search_word_response['data'];
                    }).catch(function (error) {
                console.log(error);
                    });
    }
   
   }
}

</script>
<style>

</style>
