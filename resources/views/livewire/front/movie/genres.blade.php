<x-livewire-modal::stack>
    <x-livewire-modal::modal position="center" class="w-full max-w-md overflow-auto rounded-lg bg-white p-5">
        <div class="space-y-4">
            <h2 class="text-lg font-semibold">{{ __('quickpanel.genres') }}</h2>
            <input type="search" placeholder="{{ __('Search genres...') }}" wire:model.debounce.300ms="search"
                   class="w-full rounded border border-gray-300 px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500"/>

            <ul class="divide-y divide-gray-200">
                @forelse($items as $item)
                    <li>
                        <a href="{{ route('front.movie.genre', ['slug' => $item->slug]) }}" class="flex items-center justify-between py-2 hover:text-blue-600">
                            <span>{{ $item->name }}</span>
                            <svg class="h-4 w-4 text-gray-400" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true"><path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L9.586 11 7.293 8.707a1 1 0 111.414-1.414l3 3a1 1 0 010 1.414l-3 3a1 1 0 01-1.414 0z" clip-rule="evenodd"/></svg>
                        </a>
                    </li>
                @empty
                    <li class="py-6 text-center text-sm text-gray-500">{{ __('No genres found') }}</li>
                @endforelse
            </ul>
        </div>
    </x-livewire-modal::modal>
</x-livewire-modal::stack>
