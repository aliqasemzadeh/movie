@props(['movie'])
@php
    $image = \Illuminate\Support\Facades\Storage::url($movie->cover) ?: \Illuminate\Support\Facades\Storage::url($movie->image);
@endphp
<a href="{{ route('front.movie.view', ['movieId' => $movie->id, 'slug' => $movie->slug]) }}" class="group relative block overflow-hidden rounded-lg bg-gray-900">
    <img src="{{ $image }}" alt="{{ $movie->title }}" class="h-full w-full object-cover transition-transform duration-300 group-hover:scale-105"/>
    <div class="absolute inset-0 bg-black/40 opacity-0 transition-opacity duration-300 group-hover:opacity-100"></div>
    <div class="pointer-events-none absolute inset-0 flex items-center justify-center opacity-0 transition-opacity duration-300 group-hover:opacity-100">
        <!-- Play icon -->
        <svg class="h-12 w-12 text-white drop-shadow" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"><path d="M8 5v14l11-7z"/></svg>
    </div>
    <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2">
        <p class="truncate text-sm font-medium text-white">{{ $movie->title }}</p>
    </div>
</a>
