<x-slot name="title">
    {{ __('quickpanel.register') }}
</x-slot>

<div>
    @if (session('success'))
        <div class="mb-4 rounded border border-green-200 bg-green-50 p-3 text-green-800 dark:border-green-900 dark:bg-green-900/40 dark:text-green-200">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit="register" class="space-y-4">
        <div>
            <label for="name" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">{{ __('Name') }}</label>
            <input id="name" type="text" wire:model.defer="name" autocomplete="name" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" />
            @error('name') <span class="mt-1 block text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="email" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">{{ __('Email') }}</label>
            <input id="email" type="email" wire:model.defer="email" autocomplete="email" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" />
            @error('email') <span class="mt-1 block text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">{{ __('Password') }}</label>
            <input id="password" type="password" wire:model.defer="password" autocomplete="new-password" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" />
            @error('password') <span class="mt-1 block text-sm text-red-600">{{ $message }}</span> @enderror
        </div>

        <div>
            <label for="password_confirmation" class="mb-2 block text-sm font-medium text-gray-900 dark:text-white">{{ __('Confirm Password') }}</label>
            <input id="password_confirmation" type="password" wire:model.defer="password_confirmation" autocomplete="new-password" required class="block w-full rounded-lg border border-gray-300 bg-gray-50 p-2.5 text-gray-900 focus:border-primary-600 focus:ring-primary-600 dark:border-gray-600 dark:bg-gray-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-primary-500 dark:focus:ring-primary-500" />
        </div>

        <button type="submit" class="w-full rounded-lg bg-primary-700 px-5 py-2.5 text-center text-sm font-medium text-white hover:bg-primary-800 focus:outline-none focus:ring-4 focus:ring-primary-300 disabled:opacity-70 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800" wire:loading.attr="disabled">
            <span wire:loading.remove>{{ __('quickpanel.register') }}</span>
            <span wire:loading>{{ __('Please wait...') }}</span>
        </button>

        <p class="text-sm text-gray-500 dark:text-gray-400">
            {{ __('Already have an account?') }} <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:underline dark:text-primary-500">{{ __('Login') }}</a>
        </p>
    </form>
</div>
