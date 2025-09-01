<x-slot name="title">
    {{ __('quickpanel.home') }}
</x-slot>
<div x-data>
    <div class="max-w-2xl mx-auto text-center space-y-6">
        <!-- Logo on top (center) -->
        <div class="flex justify-center" x-show="!$wire.results || $wire.results.length === 0">
            @includeIf('layouts.global.logo', ['class' => 'h-64 w-64'])
        </div>

        <!-- Search form (submit triggers search) -->
        <form wire:submit.prevent="search" class="space-y-3">
            <div class="relative">
                <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                    <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16z" />
                    </svg>
                </div>
                <input type="text" wire:model.defer="q" autofocus
                       placeholder="{{ __('quickpanel.search') }}..."
                       class="w-full ps-10 py-3 rounded-lg border border-gray-300 bg-gray-50 text-gray-900 placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"/>
            </div>
            <div class="flex justify-center">
                <button type="submit" class="inline-flex items-center gap-2 px-4 py-2 rounded-md bg-blue-600 text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16z" />
                    </svg>
                    <span>{{ __('quickpanel.search') }}</span>
                </button>
            </div>
        </form>

        <!-- Description under the search input -->
        <div class="text-sm text-gray-600 dark:text-gray-300 leading-6">
            <p>
                Discover movies curated by our community. Each title includes details like year, genre, country, and artwork to help you decide what to watch.
            </p>
            <p class="mt-2">
                How to watch: open a movie page to view its seasons, episodes, or linked files. Use the search above to find titles by name. Results only appear after you press the Search button or hit Enter.
            </p>
            <p class="mt-2">
                How it works: our website organizes movies and series with clean navigation, dark mode support, and fast search so you can quickly jump into what you love.
            </p>
        </div>
    </div>

    <!-- Results -->
    <div class="mt-6" x-show="$wire.results && $wire.results.length > 0">
        <ul class="max-w-2xl mx-auto divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($results as $movie)
                <li class="py-3">
                    <a href="{{ route('front.movie.view', ['movieId' => $movie->id, 'slug' => $movie->slug]) }}" class="flex items-center gap-4 hover:bg-gray-50 dark:hover:bg-gray-800 p-2 rounded">
                        <img src="{{ $movie->cover ?: $movie->image }}" alt="{{ $movie->title }}" class="w-16 h-10 object-cover rounded bg-gray-200 dark:bg-gray-600">
                        <div>
                            <div class="text-gray-900 dark:text-white font-medium">{{ $movie->title }}</div>
                            @if($movie->year)
                                <div class="text-xs text-gray-500 dark:text-gray-400">{{ $movie->year }}</div>
                            @endif
                        </div>
                    </a>
                </li>
            @endforeach
        </ul>
    </div>
</div>
