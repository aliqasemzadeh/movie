<x-slot name="title">
    {{ __('quickpanel.forgot_password_title') }}
</x-slot>

<form class="mt-4 space-y-4 sm:mt-6 sm:space-y-6" wire:submit="sendCode">
    <div>
        <label for="email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">{{ __('quickpanel.email') }}</label>
        <input
            type="email"
            wire:model="email"
            id="email"
            class="block w-full rounded-lg border bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500 sm:text-sm @error('email') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
            placeholder="{{ __('quickpanel.email_placeholder') }}"
            required
        />
        @error('email')
        <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
        @enderror
        <p class="mt-2 text-xs text-gray-500 dark:text-gray-400">{{ __('quickpanel.helper_email_privacy') }} <a href="#" class="underline">{{ __('quickpanel.privacy_policy') }}</a>.</p>
    </div>

    <div class="flex flex-col items-center justify-center gap-2">
        <button type="submit"
                wire:loading.attr="disabled"
                wire:target="sendCode"
                class="w-full rounded-lg bg-primary-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 disabled:opacity-50 disabled:cursor-not-allowed inline-flex items-center justify-center">
            <svg wire:loading wire:target="sendCode" class="me-2 h-4 w-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <span>{{ __('quickpanel.send_reset_code') }}</span>
        </button>
        <a href="{{ route('change-password') }}" class="text-sm text-primary-700 hover:underline dark:text-primary-500">{{ __('quickpanel.already_have_code') }}</a>
        <a href="{{ route('login') }}" class="text-sm text-gray-600 hover:underline dark:text-gray-400">{{ __('quickpanel.back_to_login') }}</a>
    </div>
</form>
