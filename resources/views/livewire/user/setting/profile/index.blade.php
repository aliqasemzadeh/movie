<div>
    <div class="mx-auto max-w-xl space-y-6">
        <!-- Update Profile Card -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h1 class="text-xl font-semibold text-gray-900 dark:text-white mb-4">{{ __('quickpanel.profile') }}</h1>

            <form wire:submit.prevent="update" class="space-y-4">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('quickpanel.name') }}</label>
                    <input type="text" id="name" wire:model.defer="name" autocomplete="name" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" />
                    @error('name')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('quickpanel.email') }}</label>
                    <input type="email" id="email" wire:model.defer="email" autocomplete="email" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" />
                    @error('email')
                        <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="pt-2">
                    <button type="submit" wire:loading.attr="disabled" wire:target="update" class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-center text-white bg-primary-600 rounded-lg hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 disabled:opacity-70 disabled:cursor-not-allowed dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">
                        <svg wire:loading wire:target="update" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                        </svg>
                        {{ __('quickpanel.update') }}
                    </button>
                </div>
            </form>
        </div>

        <!-- Delete Account Card -->
        <div class="bg-white dark:bg-gray-800 shadow rounded-lg p-6">
            <h2 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">Delete Account</h2>
            <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">This action is irreversible. All your data will be permanently deleted.</p>
            <button type="button" wire:click="openDeleteModal" class="inline-flex items-center justify-center w-full px-4 py-2 text-sm font-medium text-center text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                {{ __('quickpanel.delete') }}
            </button>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    @if($confirmingDeletion)
        <div class="fixed inset-0 z-50 flex items-center justify-center">
            <!-- overlay -->
            <div class="absolute inset-0 bg-black/50" aria-hidden="true"></div>
            <!-- modal -->
            <div class="relative bg-white dark:bg-gray-800 rounded-lg shadow-lg w-full max-w-md mx-4">
                <div class="p-6">
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-2">{{ __('quickpanel.are_you_sure') }}</h3>
                    <p class="text-sm text-gray-600 dark:text-gray-300 mb-4">Please confirm your current password to delete your account.</p>

                    <div class="mb-4">
                        <label for="delete_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{ __('quickpanel.password') }} (Current)</label>
                        <input type="password" id="delete_password" wire:model.defer="delete_password" autocomplete="current-password" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-red-500 focus:border-red-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white" />
                        @error('delete_password')
                            <p class="mt-2 text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <div class="flex items-center gap-2">
                        <button type="button" wire:click="deleteAccount" wire:loading.attr="disabled" wire:target="deleteAccount" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-white bg-red-600 rounded-lg hover:bg-red-700 focus:ring-4 focus:outline-none focus:ring-red-300 disabled:opacity-70 disabled:cursor-not-allowed dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-800">
                            <svg wire:loading wire:target="deleteAccount" class="animate-spin -ml-1 mr-2 h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            {{ __('quickpanel.delete') }}
                        </button>
                        <button type="button" wire:click="closeDeleteModal" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">
                            {{ __('quickpanel.cancel') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
