<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title')</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns=%22http://www.w3.org/2000/svg%22 viewBox=%220 0 100 100%22><text y=%22.9em%22 font-size=%2290%22>🍰</text></svg>">
    @vite(['resources/css/app.scss', 'resources/js/app.js'])
    @stack('styles')
</head>

<body class="d-flex flex-column min-vh-100">
    @include('layout.navbar')

    <main class="flex-fill">
        @yield('content')
    </main>

    @include('layout.footer')

    @stack('scripts')
</body>

</html>
