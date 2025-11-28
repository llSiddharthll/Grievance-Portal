<x-layout.app>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-emerald-900">{{ __('Departments Management') }}</h1>
                <p class="text-emerald-600 mt-2">{{ __('Manage all departments and their assignments') }}</p>
            </div>
            <a 
                href="{{ route('admin.departments.create') }}" 
                class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center space-x-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>{{ __('Add Department') }}</span>
            </a>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <div class="bg-white rounded-xl shadow border border-emerald-100 p-6 text-center">
                <div class="text-3xl font-bold text-emerald-900">{{ $totalDepartments }}</div>
                <div class="text-sm text-emerald-600">{{ __('Total Departments') }}</div>
            </div>
            <div class="bg-white rounded-xl shadow border border-emerald-100 p-6 text-center">
                <div class="text-3xl font-bold text-emerald-900">{{ $totalComplaints }}</div>
                <div class="text-sm text-emerald-600">{{ __('Total Complaints') }}</div>
            </div>
            <div class="bg-white rounded-xl shadow border border-emerald-100 p-6 text-center">
                <div class="text-3xl font-bold text-emerald-900">{{ $totalOfficers }}</div>
                <div class="text-sm text-emerald-600">{{ __('Total Officers') }}</div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
            <form method="GET" action="{{ route('admin.departments.index') }}" class="flex flex-col md:flex-row gap-4 items-end">
                <!-- Search -->
                <div class="flex-1">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ $search }}"
                            placeholder="{{ __('Search departments by name...') }}"
                            class="w-full pl-10 pr-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        >
                        <svg class="w-5 h-5 text-emerald-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <button 
                        type="submit"
                        class="px-6 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center space-x-2"
                    >
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>{{ __('Search') }}</span>
                    </button>
                    <a 
                        href="{{ route('admin.departments.index') }}" 
                        class="px-6 py-2 border border-emerald-300 text-emerald-700 rounded-lg hover:bg-emerald-50 transition-colors"
                    >
                        {{ __('Reset') }}
                    </a>
                </div>
            </form>
        </div>

        <!-- Departments Table -->
        <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 overflow-hidden">
            @if($departments->count() > 0)
                <div class="w-full overflow-x-auto">
                    <table class="min-w-max w-full">
                        <thead>
                            <tr class="bg-emerald-50 border-b border-emerald-100">
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Department Name') }}</th>
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Total Complaints') }}</th>
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Assigned Officers') }}</th>
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($departments as $department)
                                <tr class="border-b border-emerald-50 hover:bg-emerald-50 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="font-semibold text-emerald-900">{{ $department->name }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-medium text-emerald-900">{{ $department->complaints_count }}</span>
                                            @if($department->complaints_count > 0)
                                                <span class="text-xs text-emerald-600 bg-emerald-100 px-2 py-1 rounded">
                                                    {{ __('Active') }}
                                                </span>
                                            @else
                                                <span class="text-xs text-gray-500 bg-gray-100 px-2 py-1 rounded">
                                                    {{ __('No complaints') }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-2">
                                            <span class="font-medium text-emerald-900">{{ $department->officers_count }}</span>
                                            @if($department->officers_count > 0)
                                                <span class="text-xs text-blue-600 bg-blue-100 px-2 py-1 rounded">
                                                    {{ __('Staffed') }}
                                                </span>
                                            @else
                                                <span class="text-xs text-emerald-600 bg-emerald-100 px-2 py-1 rounded">
                                                    {{ __('No officers') }}
                                                </span>
                                            @endif
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex space-x-2">
                                            <a 
                                                href="{{ route('admin.departments.show', $department) }}" 
                                                class="h-10 w-10 inline-flex items-center justify-center bg-[var(--btn-bg)] text-[var(--btn-text)] rounded-full shadow-xs"
                                            >
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            <a 
                                                href="{{ route('admin.departments.edit', $department) }}" 
                                                class="h-10 w-10 inline-flex items-center justify-center bg-[var(--btn-bg)] text-[var(--btn-text)] rounded-full shadow-xs"
                                            >
                                                <i class="fa-solid fa-pen-to-square"></i>
                                            </a>
                                            <form 
                                                action="{{ route('admin.departments.destroy', $department) }}" 
                                                method="POST" 
                                                class="inline"
                                                onsubmit="return confirm('{{ __('Are you sure you want to delete this department?') }}');"
                                            >
                                                @csrf
                                                @method('DELETE')
                                                <button 
                                                    type="submit"
                                                    class="h-10 w-10 inline-flex items-center justify-center bg-[var(--btn-bg)] text-[var(--btn-text)] rounded-full shadow-xs cursor-pointer"
                                                    {{ $department->complaints_count > 0 || $department->officers_count > 0 ? 'disabled' : '' }}
                                                >
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-emerald-50 px-6 py-4 border-t border-emerald-100">
                    {{ $departments->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-emerald-900 mb-2">{{ __('No Departments Found') }}</h3>
                    <p class="text-emerald-600 mb-6">
                        {{ $search ? __('No departments match your search criteria.') : __('Get started by creating your first department.') }}
                    </p>
                    @if(!$search)
                        <a 
                            href="{{ route('admin.departments.create') }}" 
                            class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors inline-flex items-center space-x-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                            </svg>
                            <span>{{ __('Create Department') }}</span>
                        </a>
                    @else
                        <a 
                            href="{{ route('admin.departments.index') }}" 
                            class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors inline-flex items-center space-x-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            <span>{{ __('Clear Search') }}</span>
                        </a>
                    @endif
                </div>
            @endif
        </div>
    </div>
</x-layout.app>