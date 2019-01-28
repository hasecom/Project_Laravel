<template>
    <div class="detailed">
    <div class="sec">
        <div class="headline">タイトル</div>
        <div class="h3 cnt">{{detailed.photo_name}}</div>
    </div>
      <div>
        <div class="headline">説明</div>
        <div class="h3 cnt">{{detailed.photo_description}}</div>
    </div>
    </div>
</template>
<style>

</style>
<script>
export default{
    props:{
        detailed:{
            type:Object
        }
    },
    data(){
        return{
            
        }
    }
}
</script>
<style>
 .headline{
  color: black;
  background: rgba(225,225,225,0.8);
  font-size: 20px;
  line-height: 1;
  padding: 15px 15px 10px 40px;
  box-shadow: 0 1px 3px #777;
}
/* .headline:after,.headline:before {
  content: "";
  position: absolute;
  top: 100%;
  height: 0;
  width: 0;
  border: 5px solid transparent;
  border-top: 5px solid #333;
}
.headline:after {
  left: 0;
  border-right: 5px solid #333;

}
.headline:before {
  right: 0;
  border-left: 5px solid #333;
} */
</style>
<style scoped>
.cnt{
    padding-top:1rem;
    padding-bottom:1rem;
    padding-left:15px;
    padding-right:15px;
}
</style>