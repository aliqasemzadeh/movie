<x-slot name="title">
    {{ __('quickpanel.verify_email_title') }}
</x-slot>
<div class="max-w-sm mx-auto py-10">
    <h1 class="text-xl font-semibold text-gray-900 dark:text-white mb-2">{{ __('quickpanel.verify_email_title') }}</h1>
    <p class="text-sm text-gray-600 dark:text-gray-300 mb-6">{{ __('quickpanel.verify_email_intro') }}</p>

    <form wire:submit.prevent="submit" class="max-w-sm mx-auto">
        <div class="flex mb-2 space-x-2 rtl:space-x-reverse">
            <div>
                <label for="code-1" class="sr-only">{{ __('quickpanel.first_code') }}</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-next="code-2" id="code-1" wire:model.defer="d1" class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required />
            </div>
            <div>
                <label for="code-2" class="sr-only">{{ __('quickpanel.second_code') }}</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-1" data-focus-input-next="code-3" id="code-2" wire:model.defer="d2" class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required />
            </div>
            <div>
                <label for="code-3" class="sr-only">{{ __('quickpanel.third_code') }}</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-2" data-focus-input-next="code-4" id="code-3" wire:model.defer="d3" class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required />
            </div>
            <div>
                <label for="code-4" class="sr-only">{{ __('quickpanel.fourth_code') }}</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-3" data-focus-input-next="code-5" id="code-4" wire:model.defer="d4" class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required />
            </div>
            <div>
                <label for="code-5" class="sr-only">{{ __('quickpanel.fifth_code') }}</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-4" data-focus-input-next="code-6" id="code-5" wire:model.defer="d5" class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required />
            </div>
            <div>
                <label for="code-6" class="sr-only">{{ __('quickpanel.sixth_code') }}</label>
                <input type="text" maxlength="1" data-focus-input-init data-focus-input-prev="code-5" id="code-6" wire:model.defer="d6" class="block w-9 h-9 py-3 text-sm font-extrabold text-center text-gray-900 bg-white border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" required />
            </div>
        </div>
        <p id="helper-text-explanation" class="mt-2 text-sm text-gray-500 dark:text-gray-400">{{ __('quickpanel.verify_email_helper') }}</p>

        <div class="mt-4 flex items-center gap-2">
            <button type="submit" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-center text-white bg-primary-600 rounded-lg hover:bg-primary-700 focus:ring-4 focus:outline-none focus:ring-primary-300 dark:bg-primary-600 dark:hover:bg-primary-700 dark:focus:ring-primary-800">{{ __('quickpanel.verify') }}</button>
            <button type="button" wire:click="resend" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 focus:ring-4 focus:outline-none focus:ring-gray-200 dark:bg-gray-700 dark:text-white dark:hover:bg-gray-600 dark:focus:ring-gray-600">{{ __('quickpanel.resend_code') }}</button>
        </div>
    </form>
</div>

<script>
// use this simple function to automatically focus on the next input
function focusNextInput(el, prevId, nextId) {
    if (el.value.length === 0) {
        if (prevId) {
            document.getElementById(prevId).focus();
        }
    } else {
        if (nextId) {
            document.getElementById(nextId).focus();
        }
    }
}

// Defer until DOM loaded
window.addEventListener('DOMContentLoaded', function() {
    document.querySelectorAll('[data-focus-input-init]').forEach(function(element) {
        element.addEventListener('keyup', function() {
            const prevId = this.getAttribute('data-focus-input-prev');
            const nextId = this.getAttribute('data-focus-input-next');
            focusNextInput(this, prevId, nextId);
        });
        // Handle paste event to split the pasted code into each input
        element.addEventListener('paste', function(event) {
            event.preventDefault();
            const pasteData = (event.clipboardData || window.clipboardData).getData('text');
            const digits = pasteData.replace(/\D/g, '');
            const inputs = document.querySelectorAll('[data-focus-input-init]');
            inputs.forEach((input, index) => {
                if (digits[index]) {
                    input.value = digits[index];
                    const nextId = input.getAttribute('data-focus-input-next');
                    if (nextId) {
                        document.getElementById(nextId).focus();
                    }
                }
            });
        });
    });
});
</script>
