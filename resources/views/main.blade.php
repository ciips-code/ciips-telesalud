<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        @yield('title')
        @sectionMissing('title')
            {{ __('views.vc') }}
        @endif
    </title>
    <link rel="stylesheet" href="{{ asset('css/telesalud.bulma.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/css.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
</head>
<body>
    <div class="container-is-fullhd">
        @yield('content')
    </div>
</body>
</html>
