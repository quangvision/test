<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Styles -->
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="/css/vendor/trix.css">

    @yield('header')
    <style>
        .level {
            display: flex; align-items: center;
        }
        [v-cloak] {display: none;}
        .ais-highlight em {background-color:yellow}
    </style>
    <script defer src="https://use.fontawesome.com/releases/v5.0.6/js/all.js"></script>
    <script>
        window.App = {!! json_encode([
            'user' => auth()->user(),
            'signedIn' => auth()->check()
        ]) !!}
    </script>
</head>
<body>
    <div id="app">
        @include('partials.navbar')
        <flash :data="{{ json_encode(['message'=>session('flash'),'type'=> session('type')] ) }}"></flash>
        <main class="py-4">
            
            @yield('content')
            
        </main>
    </div>

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}"></script>
    @yield('footer')
</body>
</html>
