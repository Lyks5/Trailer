<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Lar') }}</title>
    
    <link rel="dns-prefetch" href="//fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">
    <link rel="icon" href="./favicon.ico" />
    @vite('resources/css/app.css')
</head>
<style>
    .menu {
        min-height: calc(100vh - (68px + 152px))
    }
</style>

<body>
    @include('components.header')
    <main class="menu">
        @yield('content')
    </main>
    @include('components.footer')
</body>

</html>
