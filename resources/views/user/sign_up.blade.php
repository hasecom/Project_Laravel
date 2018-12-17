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



        </style>
    </head>
    <body>

<div id="app">

    
@if ($chk_userid == 0 && $chk_useremail ==0)
    {{-- idとメアドがオリジナル --}}  
    <sign_up></sign_up>
@else
    {{-- idとメアドが重複している（DBと） --}}
    <sign_up 
    chk_userid="{{$chk_userid}}" 
    chk_useremail="{{$chk_useremail}}"
    ></sign_up>
 {{Session::forget('temp_user_id')}}  
 {{Session::forget('temp_user_pw')}}  
 {{Session::forget('temp_user_email')}}   
 {{Session::forget('temp_user_name')}}  

@endif
</div>


<script src="{{ mix('js/app.js') }}"></script>
    </body>
</html>
