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

           
            }
            @media only screen and (max-width: 768px) {
             
                
            }
            }


        </style>
    </head>
    <body>


<div id="app">
  <admin-login></admin-login>
</div>

<script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
