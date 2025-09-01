<x-slot name="title">
    {{ $title ?? __('quickpanel.country') }}
</x-slot>
<div>
    <div class="mb-4 flex items-center justify-between">
        <h1 class="text-xl font-semibold text-gray-900 dark:text-white">{{ $title ?? __('quickpanel.country') }}</h1>
    </div>

    <div class="grid grid-cols-2 gap-3 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-8">
        @forelse($movies as $movie)
            <x-movie.card :movie="$movie" />
        @empty
            <div class="col-span-full text-center text-gray-500 dark:text-gray-400">{{ __('No movies found') }}</div>
        @endforelse
    </div>

    <div class="mt-4">{{ $movies->links() }}</div>
</div>
