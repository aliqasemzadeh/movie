<x-livewire-modal::stack fullscreen="true">
    <x-livewire-modal::modal position="center" class="w-full h-screen">
        <div class="min-h-screen flex flex-col bg-white dark:bg-gray-900">
            <div class="sticky top-0 z-10 flex items-center justify-between px-4 py-3 border-b bg-white/90 backdrop-blur dark:bg-gray-800/90 dark:border-gray-700">
                <h3 class="text-base md:text-lg font-semibold text-gray-900 dark:text-white">
                    {{ __('quickpanel.users') }}: {{ isset($role) ? $role->name : '' }}
                </h3>
                <button type="button" class="p-2 text-gray-500 hover:text-gray-900 hover:bg-gray-100 rounded-lg dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-primary-500" aria-label="Close" wire:click="$dispatch('modal-close')">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
            </div>

            <div class="flex-1 overflow-y-auto px-4 py-4 md:px-6 md:py-6">
                <p class="text-sm text-gray-600 dark:text-gray-300">{{ __('quickpanel.role_users_description') }}</p>

                <div>
                    <ul class="divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach(isset($role) && isset($role->users) ? $role->users : [] as $user)
                            <li class="py-3">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="text-sm font-medium text-gray-900 dark:text-white">{{ $user->name }}</p>
                                        <p class="text-xs text-gray-500 dark:text-gray-400">{{ $user->email }}</p>
                                    </div>
                                    <button type="button" class="inline-flex items-center px-3 py-1.5 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:outline-none focus:ring-4 focus:ring-red-300 dark:focus:ring-red-800" wire:click="revoke({{ $user->id }}, '{{ $role->name }}')" onclick="return confirm('{{ __('quickpanel.are_you_sure') }}')">
                                        <svg class="w-5 h-5 mr-1" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M1 7h22M8 7V5a3 3 0 013-3h2a3 3 0 013 3v2" /></svg>
                                        {{ __('quickpanel.remove') }}
                                    </button>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="button" class="px-4 py-2 text-sm font-medium text-gray-700 bg-gray-200 rounded-lg hover:bg-gray-300 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600" wire:click="$dispatch('modal-close')">{{ __('quickpanel.close') }}</button>
                </div>
            </div>
        </div>
    </x-livewire-modal::modal>
</x-livewire-modal::stack>
