<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Blacklist</title>
</head>
<body>
<form method="POST" action="{{route('save_blacklist')}}">
    @csrf
    маски ввода нет, поэтому ввести через запятую<br>
    <input type="text" name="blacklist" placeholder="список паблишеров и сайтов"><br>
    <input type="text" name="advertiser" placeholder="айди рекламодателя"><br>
    <input type="submit">
</form>
<br>
<hr>
<form method="GET" action="{{route('get_blacklist')}}">
    @csrf
    Получить блэклист<br>
    <input type="text" name="advertiser" placeholder="айди рекламодателя"><br>
    <input type="submit">
</form><br>
@if(isset($blacklist))
   Блэклист по запрошенному айди: {{$blacklist}}
@endif
</body>
</html>
