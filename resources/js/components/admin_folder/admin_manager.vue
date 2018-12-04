<template>
  <div>
Admin Manager です。<br>
maa<br>
  <p>{{ message }}</p>
 
  </div>
  
</template>

<script>
//親要素(main)からデータをpropsで取得
export default {
    props: ['message']
}
</script>

<style>
</style>