<header class="bg-emerald-600 text-white shadow-2xs sticky top-0 z-50">
    <div class="flex items-center justify-between p-4">

        <!-- Left Section -->
        <div class="flex items-center space-x-4">
            <button id="sidebarToggle" class="lg:hidden p-2 rounded-md hover:bg-emerald-700 transition-colors"
                onclick="toggleSidebar()">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16">
                    </path>
                </svg>
            </button>

            <h1 class="text-xl font-bold">{{ __('Dashboard') }}</h1>
        </div>

        <!-- Right Section -->
        <div class="flex items-center space-x-4">
            <div class="flex items-center space-x-2">
                <button id="decreaseFont" class="w-8 h-8 inline-flex items-center justify-center bg-emerald-100 text-emerald-800 rounded">A-</button>
                <button id="resetFont" class="w-8 h-8 inline-flex items-center justify-center bg-emerald-100 text-emerald-800 rounded">A</button>
                <button id="increaseFont" class="w-8 h-8 inline-flex items-center justify-center bg-emerald-100 text-emerald-800 rounded">A+</button>
            </div>

            <div class="relative group inline-block">
                <!-- Button -->
                <button
                    class="flex items-center gap-2 px-3 py-2 bg-emerald-800 border rounded-md shadow-sm hover:bg-emerald-700 transition-colors">
                    <span class="text-sm font-medium">
                        {{ app()->getLocale() == 'hi' ? __('हिन्दी') : __('English') }}
                    </span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <!-- Dropdown -->
                <div
                    class="absolute right-0 mt-2 w-32 bg-emerald-800 border rounded-md shadow-2xs opacity-0 invisible
               group-hover:opacity-100 group-hover:visible transition-all duration-200 overflow-hidden outline-none">

                    <a href="{{ url('lang/en') }}"
                        class="flex items-center gap-2 px-3 py-2 text-sm hover:bg-emerald-700 transition-colors">
                        🇬🇧 {{ __('English') }}
                    </a>

                    <a href="{{ url('lang/hi') }}"
                        class="flex items-center gap-2 px-3 py-2 text-sm hover:bg-emerald-700 transition-colors">
                        🇮🇳 {{ __('हिन्दी') }}
                    </a>
                </div>
            </div>

            <!-- User Dropdown -->
            <div class="relative">
                <button onclick="toggleUserMenu()"
                    class="flex items-center space-x-2 p-2 rounded-lg hover:bg-emerald-700 transition-colors">
                    <div class="w-8 h-8 inline-flex items-center justify-center bg-emerald-500 rounded-full flex items-center justify-center">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd">
                            </path>
                        </svg>
                    </div>
                    <span class="hidden sm:block font-medium">
                        {{ auth()->user()->full_name }}
                    </span>
                </button>

                <!-- Dropdown Menu -->
                <div id="userDropdown"
                    class="hidden absolute right-0 mt-2 w-auto min-w-56 bg-white text-gray-800 rounded-lg shadow-2xs overflow-hidden">

                    <button onclick="openProfileModal()" class="block w-full text-left px-4 py-2 hover:bg-gray-100">
                        {{ __('View / Edit Profile') }}
                    </button>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button class="block w-full text-left px-4 py-2 hover:bg-gray-100 text-red-600">
                            {{ __('Logout') }}
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</header>

<!-- Modal Background -->
<div id="profileModal"
    class="hidden fixed inset-0 bg-black/50 backdrop-blur-[2px] flex items-center justify-center z-50">

    <!-- Modal Box -->
    <div class="bg-white w-full max-w-md rounded-lg p-6 shadow-xl">

        <h2 class="text-xl font-bold mb-4">{{ __('Edit Profile') }}</h2>

        <form method="post" action="{{ route('profile.update') }}">
            @csrf
            <div class="mb-4">
                <label class="block text-gray-700 mb-1">{{ __('Full Name') }}</label>
                <input type="text" name="full_name" value="{{ auth()->user()->full_name }}"
                    class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-emerald-600">
            </div>

            <div class="mb-4">
                <label class="block text-gray-700 mb-1">{{ __('Email') }}</label>
                <input type="email" name="email" value="{{ auth()->user()->email }}"
                    class="w-full border rounded p-2 focus:outline-none focus:ring-2 focus:ring-emerald-600">
            </div>

            <div class="flex justify-end space-x-2 mt-4">
                <button type="button" onclick="closeProfileModal()"
                    class="px-4 py-2 bg-gray-300 rounded hover:bg-gray-400">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded hover:bg-emerald-700">
                    {{ __('Save Changes') }}
                </button>
            </div>
        </form>

    </div>
</div>

<script>
    function toggleUserMenu() {
        document.getElementById('userDropdown').classList.toggle('hidden');
    }

    window.addEventListener('click', function(e) {
        if (!e.target.closest('#userDropdown') &&
            !e.target.closest('[onclick="toggleUserMenu()"]')) {
            document.getElementById('userDropdown').classList.add('hidden');
        }
    });

    function openProfileModal() {
        document.getElementById('profileModal').classList.remove('hidden');
        document.getElementById('userDropdown').classList.add('hidden');
    }

    function closeProfileModal() {
        document.getElementById('profileModal').classList.add('hidden');
    }
</script>
