<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
        
        <!-- Third Party Libraries -->
        <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
        <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
        <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>
    <body class="font-sans antialiased bg-gray-50 text-gray-900 flex h-screen overflow-hidden">
        
        <!-- Sidebar Navigation -->
        @include('layouts.sidebar')

        <!-- Main Content Wrapper -->
        <div class="flex-1 flex flex-col h-screen overflow-hidden bg-gray-100">
            <!-- Top Navigation -->
            @include('layouts.navigation')

            <!-- Page Heading -->
            @isset($header)
                <header class="bg-white shadow border-b border-gray-200">
                    <div class="max-w-7xl mx-auto py-4 px-4 sm:px-6 lg:px-8">
                        {{ $header }}
                    </div>
                </header>
            @endisset

            <!-- Page Content -->
            <main class="flex-1 overflow-y-auto p-4 sm:p-6 lg:p-8">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
