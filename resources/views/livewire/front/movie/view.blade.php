<div>
    @if($movie)
        <div class="space-y-4">
            <h1 class="text-2xl font-bold text-gray-900 dark:text-white">{{ $movie->title }}</h1>
            @if($movie->trailer)
                <div class="aspect-video w-full overflow-hidden rounded-lg bg-black">
                    <iframe class="h-full w-full" src="{{ $movie->trailer }}" allowfullscreen></iframe>
                </div>
            @endif
            <p class="text-gray-700 dark:text-gray-300">{{ $movie->description }}</p>
        </div>
    @else
        <div class="text-gray-500 dark:text-gray-400">{{ __('Movie not found') }}</div>
    @endif
</div>
