<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full antialiased">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $title ?? config('app.name') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @filamentStyles
    <link rel="stylesheet" href="{{ url('css/portal-theme.css') }}" />
</head>

<body class="h-full">
    {{ $slot }}
    @filamentScripts
</body>

</html>