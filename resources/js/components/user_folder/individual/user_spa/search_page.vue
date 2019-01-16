<template>
    <div>
  

<div v-for="n in 100" :key=n>k</div>
    </div>
</template>

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
<style>

</style>
