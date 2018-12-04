<template>
  <div>
Admin Manager です。<br>
maa<br>
<p>{{test}}</p>
  </div>
  
</template>

<script>
export default{
props:{
test:String,
},
mounted(){
console.log('ExampleComponent mounted.')
},
}

</script>

<style>
</style>