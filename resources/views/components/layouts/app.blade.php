<!DOCTYPE html>
<html lang="en" class="light">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('page_title') - {{ config('app.name') }}</title>
    @livewireStyles
    <x-dynamic-component :component="config('cms.header')" />
    {{ Vite::useHotFile('vendor/laravel-cms/laravel-cms.hot')->useBuildDirectory('vendor/laravel-cms')->withEntryPoints(['resources/css/app.css']) }}
    {{ Vite::useHotFile('vendor/laravel-backend/laravel-backend.hot')->useBuildDirectory('vendor/laravel-backend')->withEntryPoints(['resources/css/app.css', 'resources/js/app.js']) }}
    @stack('styles')
</head>
@php
    $dynamicSidebar = false;
@endphp

<body class="m-0 h-full w-full overflow-x-hidden !overflow-y-hidden bg-slate-100 antialiased" x-data="{ ...sidebar({{ $dynamicSidebar }}), width: window.innerWidth }"
    @resize.window="handleResize; width = window.innerWidth">
    {{ $slot }}
    @livewireScriptConfig
    @stack('scripts')
    <x-dynamic-component :component="config('cms.footer')" />
</body>

</html>
