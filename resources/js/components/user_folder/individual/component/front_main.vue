<template>
<div>
   <div class="section_2  d-flex align-items-center"> 
    <div class="container">
        <div class="row">
            <div class="col-12">
               <div class="sec_ti_ text-center pb-5 text-white">写真を売る</div> 
            </div>
        </div>
       <div class="row">
           <div class="col-md-5">
               <div class="panel panel-default bg-white shadow-lg  rounded description_">
                    <div class="panel-body">
                        <h1>スマホで写真を撮って</h1>
                        <div class="sec_"><i class="fas fa-mobile-alt"></i></div>
                    </div>
                </div>
           </div>
           <div class="col-md-2 emp_"></div>
           <div class="col-md-5">
                <div class="panel panel-default bg-white shadow-lg  rounded description_">
                    <div class="panel-body">
                        <h1>アップロードするだけ</h1>
                        <div class="sec_"><i class="fas fa-upload"></i></div>
                    </div>
                </div>
           </div>
       </div>
    </div>
   </div>
      <div class="section_3  d-flex align-items-center"> 
    <div class="container">
        <div class="row">
            <div class="col-12">
               <div class="sec_ti_ text-center pb-5 ">写真を買う</div> 
            </div>
        </div>
       <div class="row">
           <div class="col-md-5">
               <div class="panel panel-default bg-white shadow-lg  rounded description_">
                    <div class="panel-body">
                        <h1>欲しい写真を探して</h1>
                        <div class="sec_"><i class="fas fa-search"></i></div>
                    </div>
                </div>
           </div>
           <div class="col-md-2 emp_"></div>
           <div class="col-md-5">
                <div class="panel panel-default bg-white shadow-lg  rounded description_">
                    <div class="panel-body">
                        <h1>ポイントで<br>支払う</h1>
                        <div class="sec_"><i class="far fa-hand-point-up"></i></div>
                    </div>
                </div>
           </div>
       </div>
    </div>
   </div>
      <div class="section_4  d-flex align-items-center"> 
    <div class="container">
        <div class="row">
            <div class="col-12">
               <div class="sec_ti_ text-center pb-5 text-white">取引の仕組み</div> 
            </div>
        </div>
       <div class="row">
           <div class="col-md-5">
               <div class="panel panel-default bg-white shadow-lg  rounded description_">
                    <div class="panel-body">
                        <h1>ポイントで<span class="br_res"></span>写真を購入</h1>
                        <div class="sec_">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                    </div>
                </div>
           </div>
           <div class="col-md-2 emp_"></div>
           <div class="col-md-5">
                <div class="panel panel-default bg-white shadow-lg  rounded description_">
                    <div class="panel-body">
                        <h1>出品者に<span class="br_res"></span>ポイントが付与</h1>
                        <div class="sec_"><i class="fas fa-user-alt"></i></div>
                    </div>
                </div>
           </div>
       </div>
    </div>
   </div>
</div>
</template>
<style>
.section_2{
 min-height:800px;
}
.section_3{
 min-height: 800px;
 background:white;
}
.section_4{
 min-height: 800px;
}
.sec_{
    text-align: center;
    font-size:100px;
     color:orange;
}
.description_{
    text-align: center;
    height:400px;
    padding:1rem;
    color:black;
    font-weight: bold;
   cursor:default;  
}
.sec_ti_{
    font-size:5rem;
}
.br_res{
    display: block;
}

@media screen and (max-width: 992px){
.description_{
    height:300px;
}

}
@media screen and (max-width: 767px){
.description_{
    height:300px;
    margin:0 auto;
    width:60%;
}
.emp_{
    height:2rem;
}
.sec_ti_{
    font-size:3rem;
}
.br_res{
    display: inline;
}
}

</style>
<script>

</script>
