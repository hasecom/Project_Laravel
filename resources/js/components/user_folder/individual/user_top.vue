<!--
ユーザーログイン画面
-->

<template>
  <div>
    <div class="sticky-top py-3 shadow">
      <div class="row">
        <div class="col-sm-4">
          <router-link to="/"><h2 class="no_link title_">Byezer</h2></router-link>
        </div>
        <div class="col-sm-6">
         <search-input></search-input>
        </div>
        <div class="col-sm-2">
         <account-manager></account-manager>
        </div>
      </div>
      <nav class="navbar navbar-expand-md navbar-light my_menu_" ref="my_menu_ref">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav4" aria-controls="navbarNav4" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse justify-content-around" id="navbarNav4">
          <ul class="navbar-nav">
            <li class="nav-item active" >
              <router-link to="/" >
                <a class="no_link" :class='{select_bar:isActive == 0}'>ホーム</a>
              </router-link>
            </li>
         </ul>
    <ul class="navbar-nav">
      <li class="nav-item">
        <router-link to="/mypage" >
          <a  class="no_link" :class='{select_bar:isActive == 1}'>マイページ</a>
        </router-link>
      </li>
    </ul>
  
    <ul class="navbar-nav">
      <li class="nav-item">
         <router-link  to="/recruit_image" class="spa_link">
          <a  class="no_link" :class='{select_bar:isActive == 2}'>募集</a>
         </router-link>
      </li>
    </ul>
  </div>
</nav>
</div>
      
<div class="border">
  <router-view></router-view>
</div>
  </div>
</template>

<script>
export default {
data(){
  return{
    scrollY: 0,
    isScroll_Down:false,
    again_chk:true,
    isActive:-1,
  }
},
watch:{
  scrollY:function(oldval,newval){
      if(oldval - newval  < -5 ||  5 <oldval -newval ){
          if(0 < oldval -  newval ){
        this.isScroll_Down = true;
      }else{
        this.isScroll_Down = false;
      }
     this.borderAnimation();
  }
  },
    '$route' (to, from) {
    this.select_(this.$route.fullPath);
    },
},
mounted(){
    window.addEventListener('scroll', this.handleScroll);
    this.borderAnimation();
    this.select_(this.$route.fullPath);
  },
methods:{
       handleScroll(){
         this.scrollY = window.scrollY;
      
    },
    borderAnimation(){
         var my_menu = this.$refs.my_menu_ref;
       my_menu.style.getPropertyValue("--border_opacity");
     //  my_menu.style.getPropertyValue("--my_menu_height");
      if(this.isScroll_Down == true){//上へスクロール
         my_menu.style.setProperty("--my_menu_height",0 +"px");
        my_menu.style.setProperty("--border_opacity",0 );
        my_menu.style.setProperty("--my_menu_display","hidden" );
       
      }else{
        my_menu.style.setProperty("--my_menu_height",40 +"px");
         my_menu.style.setProperty("--border_opacity",1.0 );
         my_menu.style.setProperty("--my_menu_display","visible" );
      }

 
    },select_(val){
      if(val == '/'){this.isActive =0;}
      else if(val=='/mypage'){this.isActive = 1;}
      else if(val=='/recruit_image'){this.isActive = 2;}
      else{this.isActive = -1;}
    }
}

}
</script>
 

<style scoped>
.select_bar{
  color:#ff9900 !important;
}

#navbarNav4{
  background-color: rgb(63,63,61);
  width:40%;
}


:root {
  --border_opacity: 1.0;
  --my_menu_height:100%;
  --my_menu_display:'visible';
}
.row{
  margin:0;
}
.user_login_main{
    background:rgb(241,241,241);
    display: table;
    margin:auto;

}
.my_menu_{
  height:40px;
    opacity:var(--border_opacity) ;
    height:var(--my_menu_height);
    visibility:var(--my_menu_display);
   transition: all 400ms 0.1s ease;
}
.my_menu_ a{
  color:white;
}


.authentication_box{
    background:white;
    width:60%;
    padding:3rem 2rem;
   display:table-cell;
    vertical-align: middle;
    }
  .no_link{
    
     text-decoration: none;
  }
  a:hover{
     text-decoration: none;
  }
  .sticky-top{
background:rgb(63,63,61);
color:white;
  }
  .nav-item a:hover{
    color:#ff9900;
  }

</style>