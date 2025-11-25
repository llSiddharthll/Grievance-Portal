<x-layout.app>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-emerald-900">{{ __('My Assigned Complaints') }}</h1>
                <p class="text-emerald-600 mt-2">{{ __('Manage and resolve complaints assigned to you') }}</p>
            </div>
            <div class="text-sm bg-emerald-100 text-emerald-800 px-3 py-1 rounded-lg">
                {{ __('Department:') }} <strong>{{ Auth::user()->department->name }}</strong>
            </div>
        </div>

        <!-- Stats -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
                <div class="text-2xl font-bold text-emerald-900">{{ $complaints->total() }}</div>
                <div class="text-sm text-emerald-600">{{ __('Total Assigned') }}</div>
            </div>
            <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
                <div class="text-2xl font-bold text-orange-600">
                    {{ $complaints->where('status', 'pending')->count() }}
                </div>
                <div class="text-sm text-orange-600">{{ __('Pending') }}</div>
            </div>
            <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
                <div class="text-2xl font-bold text-blue-600">
                    {{ $complaints->where('status', 'in_progress')->count() }}
                </div>
                <div class="text-sm text-blue-600">{{ __('In Progress') }}</div>
            </div>
            <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
                <div class="text-2xl font-bold text-green-600">
                    {{ $complaints->where('status', 'resolved')->count() }}
                </div>
                <div class="text-sm text-green-600">{{ __('Resolved') }}</div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white rounded-xl shadow-lg border border-emerald-100 p-6">
            <form method="GET" action="{{ route('officer.complaints.index') }}" class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <div class="relative">
                        <input 
                            type="text" 
                            name="search" 
                            value="{{ request('search') }}"
                            placeholder="{{ __('Search by tracking ID, subject, or user...') }}"
                            class="w-full pl-10 pr-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        >
                        <svg class="w-5 h-5 text-emerald-400 absolute left-3 top-2.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="w-full md:w-48">
                    <select 
                        name="status" 
                        class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        onchange="this.form.submit()"
                    >
                        <option value="all">{{ __('All Status') }}</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>{{ __('Resolved') }}</option>
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
                        href="{{ route('officer.complaints.index') }}" 
                        class="px-4 py-2 border border-emerald-300 text-emerald-700 rounded-lg hover:bg-emerald-50 transition-colors"
                    >
                        {{ __('Reset') }}
                    </a>
                </div>
            </form>
        </div>

        <!-- Complaints Table -->
        <div class="bg-white rounded-xl shadow-lg border border-emerald-100 overflow-hidden">
            @if($complaints->count() > 0)
                <div class="overflow-x-auto">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-emerald-50 border-b border-emerald-100">
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Tracking ID') }}</th>
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Complaint') }}</th>
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('User') }}</th>
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Submitted') }}</th>
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Status') }}</th>
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($complaints as $complaint)
                                <tr class="border-b border-emerald-50 hover:bg-emerald-50 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="font-mono font-semibold text-emerald-900">{{ $complaint->tracking_id }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-medium text-emerald-900">{{ Str::limit($complaint->subject, 50) }}</div>
                                        <div class="text-sm text-emerald-600 mt-1">{{ Str::limit($complaint->description, 70) }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="text-emerald-900 font-medium">{{ $complaint->user->full_name }}</div>
                                        <div class="text-sm text-emerald-600">{{ $complaint->user->email }}</div>
                                    </td>
                                    <td class="py-4 px-6 text-emerald-600 text-sm">
                                        {{ $complaint->created_at->timezone('Asia/Kolkata')->format('M d, Y') }}
                                    </td>
                                    <td class="py-4 px-6">
                                        @php
                                            $statusConfig = [
                                                'pending' => ['color' => 'orange', 'label' => 'Pending'],
                                                'in_progress' => ['color' => 'blue', 'label' => 'In Progress'],
                                                'resolved' => ['color' => 'green', 'label' => 'Resolved'],
                                            ];
                                            $config = $statusConfig[$complaint->status] ?? ['color' => 'gray', 'label' => 'Unknown'];
                                        @endphp
                                        <span class="bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-800 text-xs px-3 py-1 rounded-full font-medium">
                                            {{ $config['label'] }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex space-x-2">
                                            <a 
                                                href="{{ route('officer.complaints.show', $complaint) }}" 
                                                class="px-3 py-1 bg-emerald-600 text-white text-sm rounded hover:bg-emerald-700 transition-colors"
                                            >
                                                {{ __('Manage') }}
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-emerald-50 px-6 py-4 border-t border-emerald-100">
                    {{ $complaints->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-emerald-900 mb-2">{{ __('No Complaints Assigned') }}</h3>
                    <p class="text-emerald-600 mb-6">{{ __("You don't have any complaints assigned to you yet.") }}</p>
                </div>
            @endif
        </div>
    </div>
</x-layout.app>