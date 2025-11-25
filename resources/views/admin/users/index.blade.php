<x-layout.app>
    <div class="space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-emerald-900">{{ __('User Management') }}</h1>
            <p class="text-emerald-600 mt-2">{{ __('Manage all registered users and their roles') }}</p>
        </div>
        <a 
            href="{{ route('admin.users.create') }}" 
            class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center space-x-2"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            <span>{{ __('Add New User') }}</span>
        </a>
    </div>

    <!-- Stats -->
    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
        <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
            <div class="text-2xl font-bold text-emerald-900">{{ $users->total() }}</div>
            <div class="text-sm text-emerald-600">{{ __('Total Users') }}</div>
        </div>
        <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
            <div class="text-2xl font-bold text-blue-600">
                {{ $users->where(function($user) { return $user->hasRole('citizen'); })->count() }}
            </div>
            <div class="text-sm text-blue-600">{{ __('Citizens') }}</div>
        </div>
        <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
            <div class="text-2xl font-bold text-purple-600">
                {{ $users->where(function($user) { return $user->hasRole('officer'); })->count() }}
            </div>
            <div class="text-sm text-purple-600">{{ __('Officers') }}</div>
        </div>
        <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
            <div class="text-2xl font-bold text-orange-600">
                {{ $users->where(function($user) { return $user->hasRole('admin'); })->count() }}
            </div>
            <div class="text-sm text-orange-600">{{ __('Admins') }}</div>
        </div>
    </div>

    <!-- Filters and Search -->
    <div class="bg-white rounded-xl shadow-lg border border-emerald-100 p-6">
        <form method="GET" action="{{ route('admin.users.index') }}" class="flex flex-col md:flex-row gap-4">
            <!-- Search -->
            <div class="flex-1">
                <div class="relative">
                    <input 
                        type="text" 
                        name="search" 
                        value="{{ request('search') }}"
                        placeholder="{{ __('Search by name, email, phone...') }}"
                        class="w-full pl-10 pr-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    >
                    <svg class="w-5 h-5 text-emerald-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>
            </div>

            <!-- Role Filter -->
            <div class="w-full md:w-48">
                <select 
                    name="role" 
                    class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    onchange="this.form.submit()"
                >
                    <option value="">{{ __('All Roles') }}</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" {{ request('role') == $role->name ? 'selected' : '' }}>
                            {{ ucfirst($role->name) }}
                        </option>
                    @endforeach
                </select>
            </div>

            <!-- Action Buttons -->
            <div class="flex gap-2">
                <button 
                    type="submit"
                    class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center space-x-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>{{ __('Search') }}</span>
                </button>
                <a 
                    href="{{ route('admin.users.index') }}" 
                    class="px-4 py-2 border border-emerald-300 text-emerald-700 rounded-lg hover:bg-emerald-50 transition-colors"
                >
                    {{ __('Reset') }}
                </a>
            </div>
        </form>
    </div>

    <!-- Users Table -->
    <div class="bg-white rounded-xl shadow-lg border border-emerald-100 overflow-hidden">
        @if($users->count() > 0)
            <div class="overflow-x-auto">
                <table class="w-full whitespace-nowrap">
                    <thead>
                        <tr class="bg-emerald-50 border-b border-emerald-100">
                            <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('User') }}</th>
                            <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Contact') }}</th>
                            <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Role') }}</th>
                            <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Department') }}</th>
                            <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Registered') }}</th>
                            <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr class="border-b border-emerald-50 hover:bg-emerald-50 transition-colors">
                                <td class="py-4 px-6">
                                    <div class="flex items-center space-x-3">
                                        <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                            <span class="text-emerald-600 font-semibold text-sm">
                                                {{ substr($user->full_name, 0, 1) }}
                                            </span>
                                        </div>
                                        <div>
                                            <div class="font-medium text-emerald-900">{{ $user->full_name }}</div>
                                            <div class="text-sm text-emerald-600">@ {{ $user->username }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="text-emerald-900">{{ $user->email }}</div>
                                    <div class="text-sm text-emerald-600">{{ $user->phone }}</div>
                                </td>
                                <td class="py-4 px-6">
                                    @php
                                        $role = $user->roles->first();
                                        $roleColors = [
                                            'admin' => 'orange',
                                            'officer' => 'purple', 
                                            'citizen' => 'blue'
                                        ];
                                        $color = $roleColors[$role->name] ?? 'gray';
                                    @endphp
                                    <span class="bg-{{ $color }}-100 text-{{ $color }}-800 text-xs px-3 py-1 rounded-full font-medium">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                </td>
                                <td class="py-4 px-6">
                                    @if($user->department)
                                        <span class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">
                                            {{ $user->department->name }}
                                        </span>
                                    @else
                                        <span class="text-emerald-500 text-sm">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-emerald-600 text-sm">
                                    {{ $user->created_at->timezone('Asia/Kolkata')->format('M d, Y') }}
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex space-x-2">
                                        <a 
                                            href="{{ route('admin.users.show', $user) }}" 
                                            class="px-3 py-1 bg-blue-600 text-white text-sm rounded hover:bg-blue-700 transition-colors"
                                        >
                                            {{ __('View') }}
                                        </a>
                                        <a 
                                            href="{{ route('admin.users.edit', $user) }}" 
                                            class="px-3 py-1 bg-emerald-600 text-white text-sm rounded hover:bg-emerald-700 transition-colors"
                                        >
                                            {{ __('Edit') }}
                                        </a>
                                        @if($user->id !== auth()->id())
                                            <form 
                                                action="{{ route('admin.users.destroy', $user) }}" 
                                                method="POST" 
                                                class="inline"
                                                onsubmit="return confirm('{{ __('Are you sure you want to delete this user?') }}')"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit"
                                                    class="px-3 py-1 bg-red-600 text-white text-sm rounded hover:bg-red-700 transition-colors"
                                                >
                                                    {{ __('Delete') }}
                                                </button>
                                            </form>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="bg-emerald-50 px-6 py-4 border-t border-emerald-100">
                {{ $users->links() }}
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-12">
                <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                    <svg class="w-12 h-12 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <h3 class="text-lg font-semibold text-emerald-900 mb-2">{{ __('No Users Found') }}</h3>
                <p class="text-emerald-600 mb-6">{{ __('No users match your search criteria.') }}</p>
                <a 
                    href="{{ route('admin.users.create') }}" 
                    class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors inline-flex items-center space-x-2"
                >
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>{{ __('Add New User') }}</span>
                </a>
            </div>
        @endif
    </div>
</div>
</x-layout.app>