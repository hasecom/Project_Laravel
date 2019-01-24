<!--
ユーザーログイン画面
-->

<template>
  <div>
    <div class="shadow sticky-top row header_ p-4" ref="front_header">
        <div class="col-md-4">
          <h1 class="title_ rounded-pill">Byezer</h1>
        </div>
        <div class="text-md-right col-md-8">
          <div @click="link_click(2)" class="front_btn rounded-pill">ログイン</div>
          <div @click="link_click(1)" class="front_btn rounded-pill">新規作成</div>
          <div @click="link_click(0)" class="front_btn rounded-pill">TOP</div>
        </div>
    </div>
    <div>
      <div class="bg-white section">
        <div class="cover_img wrap">
          <img src="storage/top.JPG" width='100%' height='auto' class="blur">
          <div class="cover-text text-center">
            <div class="over_view p-3 mb-md-4 js-scroll-fade" ref="over_view_ref" >
              <p>気軽に売れて、手軽に買える</p>
              <p>低価格の写真売買サイト</p>   
            
            </div>
            <button type="button" class="btn-lg  img_btn shadow py-md-3">会員登録</button>
				  </div>
        </div>
      </div> 
      
      <front-main></front-main>
      <vue-footer></vue-footer>
    </div>
  


  </div>
</template>

<script>
export default {
data() {
    return {
     scrollY: 0,
     scroll_judg:true,
    }
  }, 
  mounted() {
    window.addEventListener('scroll', this.handleScroll);
    this.borderAnimation();
  },
  methods: {
    link_click(val){
     switch(val){
      case 0:
          location.href="user";
          break;
      case 1:
          location.href="sign_up#/registration";
          break;
      case 2:
          location.href="login";
          break;
      
     }
    },
     handleScroll() {
       if(window.scrollY < 60){this.scroll_judg = true}
       if(this.scroll_judg != true){return false;}
      this.scrollY = window.scrollY;
       var header_front_cone = this.$refs.front_header;
       header_front_cone.style.getPropertyValue("--header_height");
      if(100 < this.scrollY){
        this.scroll_judg = false;
      header_front_cone.style.setProperty("--header_height",80 +"px");
      }else{
        header_front_cone.style.setProperty("--header_height",110 +"px");
      }
    },borderAnimation(){
        var over_view_border = this.$refs.over_view_ref;
       // over_view_border.style.setProperty("--over_view_border",0 +"px");
    }
 
    },
   
   

}

  	

</script>

<style>
:root {
  --header_height: 100px;
  --over_view_border:100%;
}
body{
  width:100%;
  height:auto;
  background:rgb(63,63,61);
}
a{
  color:none !important;  
}
.title_{
  color:white;
  font-weight: bold;
  
}
.title_:hover{
  color:#ff9900;
   cursor: pointer;
}
.header_{
   background:rgb(63,63,61);
   width:100%;
   height:var(--header_height);
   margin:0 !important;
   transition: all 400ms 0.1s ease;
}
.front_btn{
    width:150px;
    display: inline-block;
    font-size:16px;
    font-weight:bold;
    text-decoration:none;
    text-align:center;
    padding:8px 0 10px;
    color:white;
    cursor: pointer;
}
.front_btn:hover{
  color:#ff9900;
}
.section{
  width:100%;
}
.cover_img{
  position: relative;
  width:100%;
  height: auto;
  background:rgb(0,0,0);
}
.blur{
-webkit-filter: blur(3px);
filter: blur(3px);
opacity:0.7;
-webkit-transition: .1s;
transition: .1s;
}
.cover-text{
  position: absolute;
  color: white;/*文字は白に*/
  font-weight: bold; /*太字に*/
top: 40%;
left: 50%;
-webkit-transform: translate(-50%,-50%);
-moz-transform: translate(-50%,-50%);
-ms-transform: translate(-50%,-50%);
-o-transform: translate(-50%,-50%);
transform: translate(-50%,-50%);
}
.img_btn{  /*会員登録button*/
  background: #ff9900;
  color:white;
  border:#ff9900;
  cursor: pointer;
  background-size: 400% 400%;
  padding-left:3rem;
  padding-right:3rem;
  font-size:18px;
  padding-left: 3rem;
  padding-right:3rem;
  font-size:18px;
  transition: all 0.5s linear; /* 追加 */
  animation: fade-in ease 2s normal;
}
.img_btn:hover{
  color:rgb(245,245,245);
    padding-left: 4rem;
    padding-right:4rem;
    font-size:20px;
   transition:all 0.5s linear; /* 追加 */
}
.over_view{
  font-size: 20px;
  cursor:default;
  animation: fade-in ease 2s normal;
}
@keyframes anim {
  0%{
    width:0%;
    height:0px; 
    
    }
  100%{
    width:100%;
    height:50px;
    }
}
@keyframes fade-in{
  from {
    opacity:0.1;
    }
  to {
    opacity:1;
    }
}


.over_view:before{
    display: block;
    border-top-style: solid;
    border-left-style: solid;
    border-right-style: solid;
    padding:0px 10rem;
    height:50px;
    content: '';
    animation: anim ease 1s normal;
}
.over_view::after{
    display: block;
    border-bottom-style: solid;
    border-right-style: solid;
    border-left-style: solid;
   padding:0px 10rem;
    height:50px;
    content: '';
    animation: anim ease 1s normal;
}








</style>