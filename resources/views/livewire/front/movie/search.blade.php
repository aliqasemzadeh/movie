<x-slot name="title">
    {{ __('quickpanel.search') }}
</x-slot>
<div x-data>
    <div class="max-w-2xl mx-auto text-center space-y-6">
        <!-- Logo on top -->
        <div class="flex justify-center" x-show="!$wire.q || ($wire.q && $wire.results.length === 0)">
            @includeIf('layouts.global.logo', ['class' => 'h-32 w-32'])
        </div>
        <!-- Search input -->
        <div class="relative">
            <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
                <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35M10 18a8 8 0 1 1 0-16 8 8 0 0 1 0 16z" />
                </svg>
            </div>
            <input type="text" wire:model.live="q" autofocus
                   placeholder="{{ __('quickpanel.search') }}..."
                   class="w-full ps-10 py-3 rounded-lg border border-gray-300 bg-gray-50 text-gray-900 placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:text-white"/>
        </div>
    </div>

    <!-- Results -->
    <div class="mt-6" x-show="$wire.q && $wire.results.length > 0">
        <ul class="divide-y divide-gray-200 dark:divide-gray-700">
            @foreach($this->results as $movie)
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
