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

<!-- Header -->
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

<!-- Main -->
<main>
    <section class="bg-gray-50 dark:bg-gray-900">
        <div class="mx-auto grid h-screen max-w-screen-xl  px-4 py-2.5">
            <div class="w-full place-self-center">
                <div class="mx-auto max-w-lg rounded-lg bg-white p-4 shadow-sm dark:bg-gray-800 sm:p-6">
                    {{ $slot }}
                </div>
            </div>
        </div>
    </section>
</main>

<!-- Bottom Navigation -->
<div class="fixed bottom-0 left-0 z-50 w-full h-16 bg-white border-t border-gray-200 dark:bg-gray-700 dark:border-gray-600">
    <div class="grid h-full max-w-lg grid-cols-4 mx-auto font-medium">
        <a href="{{ route('front.movie.index') }}" type="link" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
            <svg class="w-5 h-5 mb-2 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M4 22h14a2 2 0 0 0 2-2V7l-5-5H6a2 2 0 0 0-2 2v4"/><path d="M14 2v4a2 2 0 0 0 2 2h4"/><rect width="8" height="6" x="2" y="12" rx="1"/><path d="m10 13.843 3.033-1.755a.645.645 0 0 1 .967.56v4.704a.645.645 0 0 1-.967.56L10 16.157"/></svg>
            <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">{{ __('quickpanel.movies') }}</span>
        </a>
        <button type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
            <svg class="w-5 h-5 mb-2 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15.536 11.293a1 1 0 0 0 0 1.414l2.376 2.377a1 1 0 0 0 1.414 0l2.377-2.377a1 1 0 0 0 0-1.414l-2.377-2.377a1 1 0 0 0-1.414 0z"/><path d="M2.297 11.293a1 1 0 0 0 0 1.414l2.377 2.377a1 1 0 0 0 1.414 0l2.377-2.377a1 1 0 0 0 0-1.414L6.088 8.916a1 1 0 0 0-1.414 0z"/><path d="M8.916 17.912a1 1 0 0 0 0 1.415l2.377 2.376a1 1 0 0 0 1.414 0l2.377-2.376a1 1 0 0 0 0-1.415l-2.377-2.376a1 1 0 0 0-1.414 0z"/><path d="M8.916 4.674a1 1 0 0 0 0 1.414l2.377 2.376a1 1 0 0 0 1.414 0l2.377-2.376a1 1 0 0 0 0-1.414l-2.377-2.377a1 1 0 0 0-1.414 0z"/></svg>
            <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">{{ __('quickpanel.genres') }}</span>
        </button>
        <button type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
            <svg class="w-5 h-5 mb-2 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.54 15H17a2 2 0 0 0-2 2v4.54"/><path d="M7 3.34V5a3 3 0 0 0 3 3a2 2 0 0 1 2 2c0 1.1.9 2 2 2a2 2 0 0 0 2-2c0-1.1.9-2 2-2h3.17"/><path d="M11 21.95V18a2 2 0 0 0-2-2a2 2 0 0 1-2-2v-1a2 2 0 0 0-2-2H2.05"/><circle cx="12" cy="12" r="10"/></svg>
            <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">{{ __('quickpanel.country') }}</span>
        </button>
        <button type="button" class="inline-flex flex-col items-center justify-center px-5 hover:bg-gray-50 dark:hover:bg-gray-800 group">
            <svg class="w-5 h-5 mb-2 text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500" viewBox="0 0 32 32" version="1.1" xmlns="http://www.w3.org/2000/svg" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                <path d="M22.231 11.348v9.159h2.134l0.143-0.581c0.173 0.219 0.386 0.397 0.63 0.526l0.011 0.005c0.246 0.107 0.533 0.169 0.835 0.169 0.003 0 0.006 0 0.009-0h-0c0.016 0.001 0.035 0.001 0.054 0.001 0.344 0 0.662-0.111 0.921-0.299l-0.005 0.003c0.246-0.166 0.43-0.407 0.52-0.691l0.003-0.009c0.071-0.327 0.112-0.702 0.112-1.087 0-0.048-0.001-0.096-0.002-0.144l0 0.007v-2.572c0.001-0.055 0.002-0.121 0.002-0.186 0-0.315-0.016-0.626-0.048-0.932l0.003 0.038c-0.033-0.198-0.107-0.375-0.214-0.527l0.003 0.004c-0.136-0.181-0.315-0.323-0.523-0.411l-0.008-0.003c-0.23-0.091-0.496-0.144-0.775-0.144-0.015 0-0.030 0-0.045 0l0.002-0c-0.307 0.001-0.599 0.060-0.868 0.165l0.016-0.006c-0.249 0.127-0.459 0.294-0.63 0.496l-0.002 0.003v-2.986zM25.309 18.29c0.003 0.049 0.004 0.107 0.004 0.165 0 0.237-0.026 0.468-0.076 0.69l0.004-0.021c-0.041 0.118-0.236 0.177-0.379 0.177-0.007 0.001-0.016 0.001-0.024 0.001-0.114 0-0.211-0.069-0.253-0.167l-0.001-0.002c-0.052-0.185-0.081-0.397-0.081-0.616 0-0.056 0.002-0.112 0.006-0.168l-0 0.007v-2.422c-0.003-0.048-0.005-0.103-0.005-0.16 0-0.219 0.026-0.431 0.076-0.634l-0.004 0.018c0.043-0.091 0.134-0.153 0.24-0.153 0.011 0 0.021 0.001 0.032 0.002l-0.001-0c0.143 0 0.337 0.051 0.387 0.177 0.051 0.181 0.080 0.39 0.080 0.605 0 0.051-0.002 0.102-0.005 0.152l0-0.007zM18.916 20.508c0.048 0.001 0.104 0.002 0.16 0.002 0.394 0 0.78-0.034 1.154-0.1l-0.040 0.006c0.273-0.050 0.513-0.166 0.711-0.331l-0.002 0.002c0.198-0.163 0.341-0.386 0.403-0.641l0.002-0.008c0.084-0.415 0.132-0.893 0.132-1.381 0-0.093-0.002-0.185-0.005-0.277l0 0.013v-3.213c0.003-0.091 0.004-0.197 0.004-0.304 0-0.508-0.035-1.009-0.103-1.498l0.006 0.057c-0.054-0.312-0.192-0.584-0.39-0.802l0.001 0.001c-0.243-0.257-0.559-0.442-0.915-0.521l-0.012-0.002c-0.546-0.106-1.173-0.167-1.815-0.167-0.136 0-0.271 0.003-0.405 0.008l0.019-0.001h-1.772v9.159zM18.942 13.001c0.093 0.053 0.159 0.144 0.176 0.251l0 0.002c0.030 0.184 0.048 0.395 0.048 0.611 0 0.067-0.002 0.134-0.005 0.2l0-0.009v3.551c0.006 0.072 0.009 0.155 0.009 0.24 0 0.312-0.047 0.612-0.134 0.896l0.006-0.022c-0.076 0.143-0.287 0.211-0.624 0.211v-6.014c0.028-0.003 0.061-0.004 0.094-0.004 0.155 0 0.303 0.033 0.437 0.092l-0.007-0.003zM15.239 11.348v9.159h-2.066v-6.182l-0.835 6.182h-1.476l-0.869-6.047-0.008 6.047h-2.075v-9.159h3.070c0.093 0.557 0.186 1.206 0.287 1.957l0.337 2.328 0.548-4.285zM7.108 11.348v9.159h-2.37v-9.159zM28.978 1.691c0.785 0.060 1.4 0.711 1.4 1.506 0 0.001 0 0.003 0 0.004v-0 25.598c0 0.001 0 0.002 0 0.003 0 0.787-0.6 1.433-1.368 1.507l-0.006 0h-25.868c-0.74-0.067-1.322-0.658-1.375-1.395l-0-0.005v-25.809c0.049-0.754 0.646-1.355 1.395-1.408l0.005-0zM28.978 1.074h-25.817c-1.076 0.063-1.936 0.911-2.015 1.977l-0 0.007-0.001 25.851c0.054 1.063 0.881 1.917 1.927 2.013l0.008 0.001c0.016 0.002 0.034 0.003 0.052 0.003 0.001 0 0.003 0 0.004-0h25.868q0.027 0 0.054-0.003c1.089-0.109 1.932-1.018 1.936-2.125v-25.598c-0.004-1.119-0.866-2.035-1.963-2.124l-0.008-0c-0.013-0.002-0.029-0.002-0.045-0.002-0 0-0.001 0-0.001 0h0z"></path>
            </svg>
            <span class="text-sm text-gray-500 dark:text-gray-400 group-hover:text-blue-600 dark:group-hover:text-blue-500">{{ __('quickpanel.imdb') }}</span>
        </button>
    </div>
</div>

<!-- Footer -->
<footer class="p-4 bg-white md:p-8 lg:p-10 dark:bg-gray-800">
    <div class="mx-auto max-w-screen-xl text-center">
        <a href="{{ route('home') }}" class="flex justify-center items-center text-2xl font-semibold text-gray-900 dark:text-white">
                @include('layouts.global.logo', ['class' => 'mr-2 h-8', 'width' => '33px', 'height' => '33px'])
                {{ config('app.name') }}
        </a>
        <p class="my-6 text-gray-500 dark:text-gray-400">Open-source library of over 400+ web components and interactive elements built for better web.</p>
        <ul class="flex flex-wrap justify-center items-center mb-6 text-gray-900 dark:text-white">
            <li>
                <a href="#" class="mr-4 hover:underline md:mr-6 ">About</a>
            </li>
            <li>
                <a href="#" class="mr-4 hover:underline md:mr-6">Premium</a>
            </li>
            <li>
                <a href="#" class="mr-4 hover:underline md:mr-6 ">Campaigns</a>
            </li>
            <li>
                <a href="#" class="mr-4 hover:underline md:mr-6">Blog</a>
            </li>
            <li>
                <a href="#" class="mr-4 hover:underline md:mr-6">Affiliate Program</a>
            </li>
            <li>
                <a href="#" class="mr-4 hover:underline md:mr-6">FAQs</a>
            </li>
            <li>
                <a href="#" class="mr-4 hover:underline md:mr-6">Contact</a>
            </li>
        </ul>
        <span class="text-sm text-gray-500 sm:text-center dark:text-gray-400">© 2021-2022 <a href="#" class="hover:underline">Flowbite™</a>. All Rights Reserved.</span>
    </div>
</footer>
@vite('resources/js/app.js')
<x-toaster-hub />
<livewire:modal />
@livewireScripts
</body>
</html>
