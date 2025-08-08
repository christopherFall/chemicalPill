<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ config('app.name', 'Laravel') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('css/alertify.min.css') }}">
     <link rel="stylesheet" href="{{ asset('css/alertify.dark.css') }}">
    <script src="{{ asset('js/alertify.min.js') }}"></script>

    <style>
        html.dark .ajs-dialog {
            background-color: #1f2937 !important;
            color: #f9fafb !important;
        }
        html.dark .ajs-header {
            background-color: #111827 !important;
            color: #f9fafb !important;
        }
        html.dark .ajs-content {
            color: #f9fafb !important;
        }
        html.dark .ajs-footer {
            background-color: #111827 !important;
        }
        html.dark .ajs-button {
            color: #f9fafb !important;
        }
    </style>

</head>
<body class="font-sans antialiased">
    <header>
        {{ $header ?? '' }}
    </header>

    <main class="py-4">
        {{ $slot }}
    </main>
</body>
</html>
