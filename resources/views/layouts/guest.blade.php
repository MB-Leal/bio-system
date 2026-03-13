<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name', 'BioSystem') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased bg-slate-50">
        <div class="min-h-screen flex flex-col items-center pt-6 sm:pt-12 pb-12">
            <div class="mb-8">
                <a href="/">
                    <x-application-logo class="w-28 h-28" />
                </a>
            </div>

            <div class="w-full px-4">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>