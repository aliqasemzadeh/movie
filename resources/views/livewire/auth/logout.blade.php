<x-slot name="title">
    {{ __('quickpanel.logout') }}
</x-slot>
<div class="max-w-md mx-auto py-10">
    @if (session('success'))
        <div class="mb-6 p-4 rounded border border-green-300 bg-green-50 text-green-800 dark:bg-gray-800 dark:text-green-400 dark:border-green-700">
            {{ session('success') }}
        </div>
    @endif

    <div class="p-6 border rounded shadow-sm bg-white dark:bg-gray-800 dark:border-gray-700">
        <h1 class="text-xl font-semibold mb-4 text-gray-900 dark:text-white">{{ __('quickpanel.confirm_logout') }}</h1>
        <p class="mb-6 text-gray-700 dark:text-gray-300">{{ __('quickpanel.confirm_logout_message') }}</p>

        <div class="flex items-center gap-3">
            <button wire:click="confirmLogout" wire:loading.attr="disabled" class="inline-flex items-center justify-center gap-2 px-5 py-2.5 text-sm font-medium text-white bg-red-700 hover:bg-red-800 focus:outline-none focus:ring-4 focus:ring-red-300 rounded-lg me-2 mb-2 dark:bg-red-600 dark:hover:bg-red-700 dark:focus:ring-red-900 disabled:opacity-50 disabled:cursor-not-allowed">
                <span wire:loading.remove>{{ __('quickpanel.yes_log_me_out') }}</span>
                <span wire:loading>
                    <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                    </svg>
                </span>
            </button>

            <a href="{{ url()->previous() ?: route('home') }}" class="px-5 py-2.5 text-sm font-medium text-gray-900 bg-white border border-gray-200 hover:bg-gray-100 hover:text-blue-700 focus:z-10 focus:outline-none focus:ring-4 focus:ring-gray-200 rounded-lg dark:bg-gray-800 dark:text-gray-300 dark:border-gray-600 dark:hover:text-white dark:hover:bg-gray-700 dark:focus:ring-gray-700">
                {{ __('quickpanel.cancel') }}
            </a>
        </div>
    </div>
</div>
