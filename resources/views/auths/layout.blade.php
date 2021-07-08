<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

        <title> {{$page_title}} - {{ env("APP_NAME")  }}</title>

        <link href="https://fonts.googleapis.com/css?family=Lato:300,400,700&display=swap" rel="stylesheet">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{{url('asset/libs/css/style.css')}}">
        <link rel="icon" href="{{image_url('logo.png')}}">

        <script src="{{url('asset/libs/js/jquery.min.js')}}"></script>
        <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    </head>
    <body style="background-image: url({{image_url('logo2fade.png')}})">


    @yield('content')


    <script src="{{url('asset/libs/js/popper.js')}}"></script>
    <script src="{{url('asset/lib/js/bootstrap.min.js')}}"></script>
    <script src="{{url('asset/lib/js/main.js')}}"></script>
    </body>
</html>
