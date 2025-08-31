<x-slot name="title">
    {{ __('quickpanel.login') }}
</x-slot>
<form class="mt-4 space-y-4 sm:mt-6 sm:space-y-6" wire:submit="login">
    <div class="space-y-3">
        <a href="{{ route('auth.google.redirect') }}" type="button" class="w-full text-white bg-[#4285F4] hover:bg-[#4285F4]/90 focus:ring-4 focus:outline-none focus:ring-[#4285F4]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-[#4285F4]/55 me-2 mb-2">
            <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 18 19">
                <path fill-rule="evenodd" d="M8.842 18.083a8.8 8.8 0 0 1-8.65-8.948 8.841 8.841 0 0 1 8.8-8.652h.153a8.464 8.464 0 0 1 5.7 2.257l-2.193 2.038A5.27 5.27 0 0 0 9.09 3.4a5.882 5.882 0 0 0-.2 11.76h.124a5.091 5.091 0 0 0 5.248-4.057L14.3 11H9V8h8.34c.066.543.095 1.09.088 1.636-.086 5.053-3.463 8.449-8.4 8.449l-.186-.002Z" clip-rule="evenodd"/>
            </svg>
            {{ __('quickpanel.login_google') }}
        </a>

        <a href="{{ route('auth.github.redirect') }}" type="button" class="w-full text-white bg-[#24292F] hover:bg-[#24292F]/90 focus:ring-4 focus:outline-none focus:ring-[#24292F]/50 font-medium rounded-lg text-sm px-5 py-2.5 text-center inline-flex items-center dark:focus:ring-gray-500 dark:hover:bg-[#050708]/30 me-2 mb-2">
            <svg class="w-4 h-4 me-2" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 .333A9.911 9.911 0 0 0 6.866 19.65c.5.092.678-.215.678-.477 0-.237-.01-1.017-.014-1.845-2.757.6-3.338-1.169-3.338-1.169a2.627 2.627 0 0 0-1.1-1.451c-.9-.615.07-.6.07-.6a2.084 2.084 0 0 1 1.518 1.021 2.11 2.11 0 0 0 2.884.823c.044-.503.268-.973.63-1.325-2.2-.25-4.516-1.1-4.516-4.9A3.832 3.832 0 0 1 4.7 7.068a3.56 3.56 0 0 1 .095-2.623s.832-.266 2.726 1.016a9.409 9.409 0 0 1 4.962 0c1.89-1.282 2.717-1.016 2.717-1.016.366.83.402 1.768.1 2.623a3.827 3.827 0 0 1 1.02 2.659c0 3.807-2.319 4.644-4.525 4.889a2.366 2.366 0 0 1 .673 1.834c0 1.326-.012 2.394-.012 2.72 0 .263.18.572.681.475A9.911 9.911 0 0 0 10 .333Z" clip-rule="evenodd"/>
            </svg>
            {{ __('quickpanel.login_github') }}
        </a>

    </div>
    <div class="flex items-center">
        <div class="h-px w-full bg-gray-200 dark:bg-gray-700"></div>
        <div class="px-5 text-center text-gray-500 dark:text-gray-400">{{ __('quickpanel.or') }}</div>
        <div class="h-px w-full bg-gray-200 dark:bg-gray-700"></div>
    </div>
    <div class="grid gap-4 sm:grid-cols-2 sm:gap-6">
        <div>
            <label for="email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">{{ __('Email') }}</label>
            <input
                type="email"
                wire:model="email"
                id="email"
                class="block w-full rounded-lg border  bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500 sm:text-sm @error('email') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                placeholder="{{ __('quickpanel.email_placeholder') }}"
                required
            />
            @error('email')
            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>
        <div>
            <label for="password" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">{{ __('Password') }}</label>
            <input
                type="password"
                wire:model="password"
                id="password"
                placeholder="{{ __('quickpanel.password_placeholder') }}"
                class="block w-full rounded-lg border  bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder:text-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500 sm:text-sm @error('password') border-red-500 focus:border-red-500 focus:ring-red-500 @enderror"
                required
            />
            @error('password')
            <p class="mt-1 text-sm text-red-600 dark:text-red-500">{{ $message }}</p>
            @enderror
        </div>
    </div>
    <div class="flex items-center justify-between">
        <div class="flex items-center">
            <input
                id="remember"
                wire:model="remember"
                aria-describedby="remember"
                type="checkbox"
                class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded-sm focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600"
            />
            <label for="remember" class="ms-2 text-sm font-medium text-gray-900 dark:text-gray-300">{{ __('quickpanel.remember_me') }}</label>
        </div>
        <a href="{{ route('forget-password') }}" class="text-sm font-medium text-primary-700 hover:underline dark:text-primary-500">{{ __('quickpanel.forgot_your_password') }}</a>
    </div>
    <div class="flex flex-col items-center justify-center gap-2">
        <button
            type="submit"
            wire:loading.attr="disabled"
            wire:target="login"
            class="w-full rounded-lg bg-primary-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800 disabled:opacity-50 disabled:cursor-not-allowed inline-flex items-center justify-center"
        >
            <svg wire:loading wire:target="login" class="me-2 h-4 w-4 animate-spin text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" aria-hidden="true">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
            </svg>
            <span>{{ __('quickpanel.log_in_to_your_account') }}</span>
        </button>
        <a
            href="{{ route('register') }}"
            class="mt-2 w-full text-center focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-4 focus:ring-purple-300 font-medium rounded-lg text-sm px-5 py-2.5 mb-2 dark:bg-purple-600 dark:hover:bg-purple-700 dark:focus:ring-purple-900"
        >
            <span>{{ __('quickpanel.register') }}</span>
        </a>
    </div>

</form>
