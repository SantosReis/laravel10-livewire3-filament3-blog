<nav class="flex items-center justify-between px-6 py-3 border-b border-gray-100">
    {{-- Right side --}}
    <div class="flex items-center space-x-4">
        @auth

            <div x-data="{ open: false }" class="relative inline-block text-left">
                <button @click="open = !open"
                        class="flex items-center px-3 py-2 text-sm font-medium text-gray-600 bg-white border border-transparent rounded-md hover:bg-gray-50 focus:outline-none focus:ring focus:ring-indigo-500">
                    {{ auth()->user()->name }}
                    <svg class="w-4 h-4 ml-2" xmlns="http://www.w3.org/2000/svg" fill="none"
                        viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>

                {{-- Dropdown --}}
                <div x-show="open" @click.away="open = false"
                    class="absolute right-0 z-50 w-48 mt-2 bg-white border border-gray-200 rounded-md shadow-lg"
                    x-transition>
                    <a href="{{ route('profile.edit') }}"
                    class="block px-4 py-2 text-gray-700 hover:bg-gray-100">
                        {{ __('menu.profile') }}
                    </a>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="w-full px-4 py-2 text-left text-gray-700 hover:bg-gray-100">
                            {{ __('menu.logout') }}
                        </button>
                    </form>
                </div>
            </div>

        @else
            <a href="{{ route('login') }}"
               class="text-gray-600 hover:text-gray-900">
                {{ __('menu.login') }}
            </a>
            <a href="{{ route('register') }}"
               class="ml-2 text-gray-600 hover:text-gray-900">
                {{ __('menu.register') }}
            </a>
        @endauth
    </div>
</nav>
