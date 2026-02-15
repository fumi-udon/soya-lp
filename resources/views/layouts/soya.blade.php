<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Söya. | prod. bistronippon')</title>

    @stack('meta')
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    @stack('page-styles')
</head>

<body>
    <div class="concrete-bg"></div>

    {{-- ここにヘッダーを追加します --}}
    @include('parts.header')

    <main>
        @yield('content')
    </main>

    @include('parts.footer')
    @stack('scripts')
</body>

</html>
