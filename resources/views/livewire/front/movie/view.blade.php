<x-slot name="title">
    {{ $movie->title }}
</x-slot>
<div>
    @if($movie)
        <div class="space-y-6">
            <h1 class="text-3xl font-bold text-gray-900 dark:text-white">{{ $movie->title }}</h1>

            <!-- Video player on top with play button on hover -->
            <div x-data="{ playing: false, src: null }" class="relative aspect-video w-full overflow-hidden rounded-lg bg-black">
                <template x-if="!playing">
                    <div class="absolute inset-0 flex items-center justify-center cursor-pointer group" @click="playing = true">
                        @if($movie->cover)
                            <img src="{{ $movie->cover }}" alt="{{ $movie->title }} cover" class="w-full h-full object-cover opacity-70 group-hover:opacity-60 transition-opacity duration-200">
                        @else
                            <div class="w-full h-full bg-gray-800"></div>
                        @endif
                        <button class="absolute w-20 h-20 rounded-full bg-white/80 group-hover:bg-white text-gray-900 flex items-center justify-center shadow-lg transition" aria-label="Play">
                            <svg class="w-8 h-8" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M8 5v14l11-7z"></path>
                            </svg>
                        </button>
                    </div>
                </template>
                <template x-if="playing">
                    <video class="w-full h-full" controls autoplay x-ref="videoEl">
                        @php($defaultSrc = ($movie->files && $movie->files->count()) ? ($movie->files->first()->path ?? null) : ($movie->trailer ?: null))
                        @if($defaultSrc)
                            <source src="{{ $defaultSrc }}" type="video/mp4">
                        @endif
                        Your browser does not support the video tag.
                    </video>
                </template>
            </div>

            <!-- Description and meta info -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <div class="space-y-3 lg:col-span-2">
                    <p class="text-gray-700 dark:text-gray-300 leading-relaxed">{{ $movie->description }}</p>
                </div>
                <div class="space-y-2">
                    @if($movie->director)
                        <div class="flex items-center justify-between"><span class="text-gray-500 dark:text-gray-400">{{ __('Director') }}</span><span class="text-gray-900 dark:text-white">{{ $movie->director->name }}</span></div>
                    @endif
                    @if($movie->country)
                        <div class="flex items-center justify-between"><span class="text-gray-500 dark:text-gray-400">{{ __('Country') }}</span><span class="text-gray-900 dark:text-white">{{ $movie->country->name }}</span></div>
                    @endif
                    @if($movie->year)
                        <div class="flex items-center justify-between"><span class="text-gray-500 dark:text-gray-400">{{ __('Year') }}</span><span class="text-gray-900 dark:text-white">{{ $movie->year }}</span></div>
                    @endif
                    @if($movie->duration)
                        <div class="flex items-center justify-between"><span class="text-gray-500 dark:text-gray-400">{{ __('Duration') }}</span><span class="text-gray-900 dark:text-white">{{ $movie->duration }} min</span></div>
                    @endif
                    @if($movie->IMDB)
                        <div class="flex items-center justify-between"><span class="text-gray-500 dark:text-gray-400">IMDB</span><span class="text-gray-900 dark:text-white">{{ $movie->IMDB }}</span></div>
                    @endif
                    @if($movie->genres && $movie->genres->count())
                        <div>
                            <div class="text-gray-500 dark:text-gray-400 mb-1">{{ __('Genres') }}</div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($movie->genres as $genre)
                                    <span class="px-2 py-1 rounded bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-xs">{{ $genre->title }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if($movie->artists && $movie->artists->count())
                        <div>
                            <div class="text-gray-500 dark:text-gray-400 mb-1">{{ __('Artists') }}</div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($movie->artists as $artist)
                                    <span class="px-2 py-1 rounded bg-gray-100 dark:bg-gray-700 text-gray-800 dark:text-gray-200 text-xs">{{ $artist->name }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                    @if($movie->files && $movie->files->count())
                        <div>
                            <div class="text-gray-500 dark:text-gray-400 mb-1">{{ __('Qualities') }}</div>
                            <div class="flex flex-wrap gap-2">
                                @foreach($movie->files->pluck('quality')->unique() as $quality)
                                    <span class="px-2 py-1 rounded bg-green-100 dark:bg-green-800 text-green-800 dark:text-green-100 text-xs">{{ $quality }}</span>
                                @endforeach
                            </div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Files list grouped by seasons (if any) and sorted -->
            @if($movie->files && $movie->files->count())
                <div class="space-y-4">
                    <h2 class="text-xl font-semibold text-gray-900 dark:text-white">{{ __('Files') }}</h2>
                    @foreach($this->seasonedFiles as $seasonTitle => $group)
                        <div class="border border-gray-200 dark:border-gray-700 rounded-lg">
                            <div class="px-4 py-2 bg-gray-50 dark:bg-gray-800 text-gray-700 dark:text-gray-200 font-medium">{{ $seasonTitle }}</div>
                            <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                                @foreach($group->sortBy('name') as $file)
                                    <li class="flex items-center justify-between px-4 py-3">
                                        <div class="flex flex-col">
                                            <span class="text-gray-900 dark:text-white">{{ $file->name }}</span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">{{ $file->quality }} • {{ $file->code }}</span>
                                        </div>
                                        <button @click="$dispatch('play-file', { src: '{{ $file->path }}' })" class="text-blue-600 hover:underline text-sm">{{ __('Play') }}</button>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>

        <!-- Listener to play selected file in the player above -->
        <script>
            document.addEventListener('alpine:init', () => {
                document.addEventListener('play-file', (e) => {
                    // Find the nearest component root from this script tag
                    const root = document.currentScript.closest('div');
                    if (!root) return;
                    const playerWrapper = root.querySelector('[x-data]');
                    if (!playerWrapper) return;
                    const state = Alpine.$data(playerWrapper);
                    state.playing = true;
                    const video = playerWrapper.querySelector('video');
                    if (video) {
                        let source = video.querySelector('source');
                        if (!source) {
                            source = document.createElement('source');
                            source.setAttribute('type', 'video/mp4');
                            video.appendChild(source);
                        }
                        source.setAttribute('src', e.detail.src);
                        video.load();
                        video.play();
                    }
                });
            });
        </script>
    @else
        <div class="text-gray-500 dark:text-gray-400">{{ __('Movie not found') }}</div>
    @endif
</div>
