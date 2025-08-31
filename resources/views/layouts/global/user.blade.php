<button
    type="button"
    data-drawer-toggle="drawer-navigation"
    aria-controls="drawer-navigation"
    class="p-2 mr-1 text-gray-500 rounded-lg md:hidden hover:text-gray-900 hover:bg-gray-100 dark:text-gray-400 dark:hover:text-white dark:hover:bg-gray-700 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
>
    <span class="sr-only">Toggle search</span>
    <svg aria-hidden="true" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path clip-rule="evenodd" fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z"></path>
    </svg>
</button>

<button
    type="button"
    class="flex mx-3 text-sm bg-gray-800 rounded-full md:mr-0 focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
    id="user-menu-button"
    aria-expanded="false"
    data-dropdown-toggle="dropdown"
>
    <span class="sr-only">Open user menu</span>
    <img
        class="w-8 h-8 rounded-full"
        src="{{ auth()->user()->avatar }}"
        alt="user photo"
    />
</button>
<!-- Dropdown menu -->
<div
    class="hidden z-50 my-4 w-56 text-base list-none bg-white rounded divide-y divide-gray-100 shadow dark:bg-gray-700 dark:divide-gray-600 rounded-xl"
    id="dropdown"
>
    <div class="py-3 px-4">
              <span
                  class="block text-sm font-semibold text-gray-900 dark:text-white"
              >{{ auth()->user()->name }}</span
              >
        <span
            class="block text-sm text-gray-900 truncate dark:text-white"
        >{{ auth()->user()->email }}</span
        >
    </div>
    <ul
        class="py-1 text-gray-700 dark:text-gray-300"
        aria-labelledby="dropdown"
    >
        <li>
            <a
                href="#"
                class="flex items-center py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
            >
                <svg class="mr-2 w-5 h-5 text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                    <path stroke="currentColor" stroke-linecap="square" stroke-linejoin="round" stroke-width="2" d="M10 19H5a1 1 0 0 1-1-1v-1a3 3 0 0 1 3-3h2m10 1a3 3 0 0 1-3 3m3-3a3 3 0 0 0-3-3m3 3h1m-4 3a3 3 0 0 1-3-3m3 3v1m-3-4a3 3 0 0 1 3-3m-3 3h-1m4-3v-1m-2.121 1.879-.707-.707m5.656 5.656-.707-.707m-4.242 0-.707.707m5.656-5.656-.707.707M12 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z"/>
                </svg>

                {{ __('quickpanel.settings') }}</a
            >
        </li>
        <li>
            <a
                href="#"
                class="flex items-center py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
            >
                <svg xmlns="http://www.w3.org/2000/svg"  width="24" height="24" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"  class="mr-2 w-5 h-5 text-gray-400"><path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/><rect width="8" height="6" x="8" y="12" rx="1"/><path d="M10 12v-2a2 2 0 1 1 4 0v2"/></svg>

                {{ __('quickpanel.change_password') }}</a
            >
        </li>
    </ul>
    <ul
        class="py-1 text-gray-700 dark:text-gray-300"
        aria-labelledby="dropdown"
    >
        <li>
            <a
                href="{{ route('logout') }}"
                class="block py-2 px-4 text-sm hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
            >{{ __('quickpanel.logout') }}</a
            >
        </li>
    </ul>
</div>
