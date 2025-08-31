<x-livewire-modal::stack>
    <x-livewire-modal::slideover
        position="right"
        class="w-full max-w-md overflow-auto rounded-lg bg-white dark:bg-gray-800 p-5"
    >
        <div class="flex flex-row items-center gap-2 mb-4">
            <h5 class="inline-flex items-center text-base font-semibold text-gray-500 dark:text-gray-400">
                <svg class="w-4 h-4 me-2.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 .5a9.5 9.5 0 1 0 9.5 9.5A9.51 9.51 0 0 0 10 .5ZM9.5 4a1.5 1.5 0 1 1 0 3 1.5 1.5 0 0 1 0-3ZM12 15H8a1 1 0 0 1 0-2h1V6H8a1 1 0 0 1 0-2h2a1 1 0 0 1 1 1v9h1a1 1 0 0 1 0 2Z"/>
                </svg>
                {{ __('quickpanel.create_role') }}
            </h5>
            <button type="button" wire:click="$dispatch('modal-close')" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto flex items-center justify-center dark:hover:bg-gray-600 dark:hover:text-white">
                <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                </svg>
                <span class="sr-only">Close menu</span>
            </button>
        </div>

        <form wire:submit.prevent="create" class="space-y-6">
            <div>
                <label class="{{ $errors->has('name') ? 'block mb-2 text-sm font-medium text-red-700 dark:text-red-500' : 'block mb-2 text-sm font-medium text-gray-900 dark:text-white' }}">{{ __('quickpanel.name') }}</label>
                <input type="text" wire:model.defer="name" class="{{ $errors->has('name')
                    ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500'
                    : 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white' }}" />
                @error('name')<p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>@enderror
            </div>
            <div>
                <label class="{{ $errors->has('guard_name') ? 'block mb-2 text-sm font-medium text-red-700 dark:text-red-500' : 'block mb-2 text-sm font-medium text-gray-900 dark:text-white' }}">{{ __('quickpanel.guard_name') }}</label>
                <select wire:model.defer="guard_name" class="{{ $errors->has('guard_name')
                    ? 'bg-red-50 border border-red-500 text-red-900 placeholder-red-700 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:text-red-500 dark:placeholder-red-500 dark:border-red-500'
                    : 'bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 dark:focus:ring-blue-500 dark:focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white' }}">
                    <option value="web">web</option>
                </select>
                @error('guard_name')<p class="mt-2 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>@enderror
            </div>
            <div class="mt-6 flex items-center justify-center gap-4 w-full">
                <button type="button" wire:click="$dispatch('modal-close')" class="flex-1 py-2.5 px-5 me-2 mb-2 text-sm font-medium text-gray-900 focus:outline-none bg-white rounded-lg border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:ring-4 focus:ring-gray-100 dark:focus:ring-gray-700 dark:bg-gray-800 dark:text-gray-400 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700">
                    <span>{{ __('quickpanel.cancel') }}</span>
                </button>
                <button type="submit" wire:loading.attr="disabled" wire:target="create" class="flex-1 inline-flex items-center justify-center text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 focus:outline-none dark:focus:ring-blue-800">
                    <svg class="w-4 h-4 me-2" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20" aria-hidden="true">
                        <path d="M4 3a2 2 0 0 0-2 2v10c0 1.105.895 2 2 2h12a2 2 0 0 0 2-2V7.414A2 2 0 0 0 17.414 6L14 2.586A2 2 0 0 0 12.586 2H4Zm0 2h8v4h4v6H4V5Zm2 8h8a1 1 0 1 1 0 2H6a1 1 0 1 1 0-2Z"/>
                    </svg>
                    <span>{{ __('quickpanel.save') }}</span>
                    <svg wire:loading wire:target="create" class="w-4 h-4 ms-2 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 0 1 8-8v4a4 4 0 0 0-4 4H4z"></path>
                    </svg>
                </button>
            </div>
        </form>
    </x-livewire-modal::slideover>
</x-livewire-modal::stack>
