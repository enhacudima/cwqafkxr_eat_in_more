<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" value="{{ csrf_token() }}"/>
        <link rel="icon" type="image/jpg" href="{{URL::secure_asset('/storage/icons/icon.jpg')}}"/>
        <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet">
        <link href="https://cdn.jsdelivr.net/npm/@mdi/font@4.x/css/materialdesignicons.min.css" rel="stylesheet">
        <title>EatInMore</title>
    </head>
    <body>
        <div id="app">
            <app></app>
        </div>
        <script src="{{ secure_asset('js/app.js') }}" defer></script>
    </body>
</html>
