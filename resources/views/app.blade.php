<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @routes
    @viteReactRefresh
    @vite(['resources/js/app.jsx'])
    @inertiaHead

    <!-- Midtrans Snap -->
    @php
        $isProduction = filter_var(config('midtrans.is_production', false), FILTER_VALIDATE_BOOLEAN);
        $snapJsUrl = $isProduction ? 'https://app.midtrans.com/snap/snap.js' : 'https://app.sandbox.midtrans.com/snap/snap.js';
    @endphp
    <script type="text/javascript" src="{{ $snapJsUrl }}" data-client-key="{{ config('midtrans.client_key') }}"></script>
</head>

<body class="font-sans antialiased">
    @inertia
</body>

</html>
