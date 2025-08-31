<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="{{ __('quickpanel.direction') }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? "" }} - {{ config('app.name', 'QuickPanel') }}</title>

    @vite('resources/css/app.css')
    @livewireStyles
</head>
<body class="bg-gray-50 dark:bg-gray-900">
<header>
    <nav class="bg-white border-gray-200 px-4 lg:px-6 py-2.5 dark:bg-gray-800">
        <div class="flex flex-wrap justify-between items-center mx-auto max-w-screen-xl">
            <a href="{{ route('home') }}" class="flex items-center">
                @includeIf('layouts.global.logo', ['class' => 'mr-3 h-6 sm:h-9', 'width' => '32px', 'height' => '32px'])
                <span class="self-center text-xl font-semibold whitespace-nowrap dark:text-white">{{ config('app.name') }}</span>
            </a>
            <div class="flex items-center lg:order-2">
                @includeIf('layouts.global.theme')
                @includeIf('layouts.global.action')
            </div>
        </div>
    </nav>
</header>
<!-- Main content -->
<main>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="mx-auto grid h-screen max-w-screen-xl px-4 py-8 lg:grid-cols-12 lg:gap-20 lg:py-16">
            <div class="w-full place-self-center lg:col-span-6">
                <div class="mx-auto max-w-lg rounded-lg bg-white p-4 shadow-sm dark:bg-gray-800 sm:p-6">
                    <h5 class="text-xl font-medium text-gray-900 dark:text-white">{{ $title ?? "" }}</h5>
                    {{ $slot }}
                </div>
            </div>
            <div class="ml-auto hidden place-self-center lg:col-span-6 lg:flex">
                @includeIf('layouts.global.logo', ['class' => 'mx-auto dark:hidden'])
                @includeIf('layouts.global.logo', ['class' => 'mx-auto hidden dark:flex'])
            </div>
        </div>
    </section>

</main>

@vite('resources/js/app.js')
<x-toaster-hub />
<livewire:modal />
@livewireScripts
</body>
</html>
