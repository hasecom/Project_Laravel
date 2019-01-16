<template>
    <div>
       ああ
  
    </div>
</template>
<style>

</style>
<script>

export default{
    data(){
        return{

        }
    },watch: {
    '$route' (to, from) {
      console.log(this.$route['query']);
    },
    },
    mounted:function(){
   console.log(this.$route['query']);
         
    },
    methods:{
    
   
   }
}

</script>
