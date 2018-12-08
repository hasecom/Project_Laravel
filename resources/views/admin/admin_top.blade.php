<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{csrf_token()}}">
        <title>Laravel</title>
        
        <link rel="stylesheet"    href="{{ mix('css/app.css') }}">
        <!-- Fonts -->
  
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet" type="text/css">

        <!-- Styles -->
        <style>

            html, body {
                background-color: #fff;
                color: #636b6f;
                font-family: 'Nunito', sans-serif;
                font-weight: 200;
                height: 100%;
                margin: 0;
            }

            #app{
                height:100%;
            }
            .main_content{
                height:100%;
                display:flex;
                flex-wrap: wrap;
                flex-direction:column;
            }
            @media only screen and (max-width: 768px) {
                .main_content{
                height:100%;
                flex-direction: row;
                
            }
            }


        </style>
    </head>
    <body>



<div id="app">
@if ($admin_status == 1)

    <admin-header login_user={{$login_user_id}}></admin-header>
        <div class="main_content" >
        <side-bar></side-bar>
            <admin-main admin_manager={{$admin_info}} user_manager="{{$user_info}}"></admin-main>
        </div>
@else

@endif
</div>

  

<script>



</script>
<script src="{{ mix('js/app.js') }}"></script>

    </body>
</html>
