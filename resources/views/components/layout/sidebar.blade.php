<!-- Sidebar Backdrop for Mobile -->
<div id="sidebarBackdrop" class="lg:hidden fixed inset-0 bg-black bg-opacity-50 z-40" style="display: none;"
    onclick="toggleSidebar()"></div>

<!-- Sidebar -->
<aside id="sidebar"
    class="fixed left-0 top-0 h-full w-70 bg-white shadow-sm z-50 transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out">
    <!-- Sidebar Header -->
    <div class="p-6 border-b border-emerald-100 bg-emerald-600">
        <div class="flex items-center justify-between">
            <h2 class="text-2xl font-semibold text-white">{{ __('Dashboard') }}</h2>
            <!-- Close button for mobile -->
            <button class="lg:hidden p-1 rounded hover:bg-emerald-100 transition-colors" onclick="toggleSidebar()">
                <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    </div>

    <!-- Sidebar Menu -->
    <nav class="p-4">
        <ul class="space-y-2">
            @foreach ($menuItems as $item)
                <li>
                    <a href="{{ $item['url'] }}"
                        class="flex items-center space-x-3 px-4 py-3 rounded-lg text-emerald-700 hover:bg-emerald-50 hover:text-emerald-900 transition-all duration-200 group {{ request()->url() === $item['url'] ? 'bg-emerald-50 border-l-4 border-emerald-500' : '' }}">
                        <!-- Icon -->
                        @if (isset($item['icon']))
                            <span class="text-emerald-500 group-hover:text-emerald-600">
                                {!! $item['icon'] !!}
                            </span>
                        @else
                            <svg class="w-5 h-5 text-emerald-400 group-hover:text-emerald-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                        @endif

                        <!-- Label -->
                        <span class="font-medium">{{ $item['label'] }}</span>

                        <!-- Badge (optional) -->
                        @if (isset($item['badge']))
                            <span class="ml-auto px-2 py-1 text-xs bg-emerald-100 text-emerald-800 rounded-full">
                                {{ $item['badge'] }}
                            </span>
                        @endif
                    </a>
                </li>
            @endforeach
        </ul>

        <!-- Sidebar Footer -->
        <div class="absolute bottom-0 left-0 right-0 p-4 border-t border-emerald-100 bg-white">
            <div class="text-center text-sm text-emerald-600">
                &copy; {{ date('Y') }} {{ __('Grievance Portal') }}
            </div>
        </div>
    </nav>
</aside>
