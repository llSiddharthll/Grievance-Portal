<x-layout.app>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-emerald-900">{{ __('Complaints Management') }}</h1>
<p class="text-emerald-600 mt-2">{{ __('Manage and assign all grievances') }}</p>
</div>
<div class="flex items-center space-x-4">
    <div class="text-sm bg-orange-100 text-orange-800 px-3 py-1 rounded-lg">
        <strong>{{ $unassignedComplaints }}</strong> {{ __('unassigned complaints') }}
    </div>
</div>
</div>
<!-- Stats -->
<div class="grid grid-cols-1 md:grid-cols-4 gap-4">
<div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
    <div class="text-2xl font-bold text-emerald-900">{{ $totalComplaints }}</div>
    <div class="text-sm text-emerald-600">{{ __('Total Complaints') }}</div>
</div>
<div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
    <div class="text-2xl font-bold text-emerald-900">
        {{ $complaints->where('status', 'pending')->count() }}
    </div>
    <div class="text-sm text-emerald-600">{{ __('Pending') }}</div>
</div>
<div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
    <div class="text-2xl font-bold text-emerald-900">
        {{ $complaints->where('status', 'in_progress')->count() }}
    </div>
    <div class="text-sm text-emerald-600">{{ __('In Progress') }}</div>
</div>
<div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
    <div class="text-2xl font-bold text-emerald-900">
        {{ $complaints->where('status', 'resolved')->count() }}
    </div>
    <div class="text-sm text-emerald-600">{{ __('Resolved') }}</div>
</div>
</div>

<!-- Filters and Search -->
<div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
<form method="GET" action="{{ route('admin.complaints.index') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
    <!-- Search -->
    <div class="md:col-span-2">
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
    <div>
        <select 
            name="status" 
            class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
        >
            <option value="all">{{ __('All Status') }}</option>
            <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
            <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
            <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>{{ __('Resolved') }}</option>
            <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
        </select>
    </div>

    <!-- Department Filter -->
    <div>
        <select 
            name="department_id" 
            class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
        >
            <option value="">{{ __('All Departments') }}</option>
            @foreach($departments as $department)
                <option value="{{ $department->id }}" {{ request('department_id') == $department->id ? 'selected' : '' }}>
                    {{ $department->name }}
                </option>
            @endforeach
        </select>
    </div>

    <!-- Assignment Filter -->
    <div>
        <select 
            name="assignment" 
            class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
        >
            <option value="">{{ __('All Assignments') }}</option>
            <option value="assigned" {{ request('assignment') == 'assigned' ? 'selected' : '' }}>{{ __('Assigned') }}</option>
            <option value="unassigned" {{ request('assignment') == 'unassigned' ? 'selected' : '' }}>{{ __('Unassigned') }}</option>
        </select>
    </div>

    <!-- Action Buttons -->
    <div class="md:col-span-4 flex gap-2 justify-end">
        <button 
            type="submit"
            class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center space-x-2"
        >
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
            <span>{{ __('Filter') }}</span>
        </button>
        <a 
            href="{{ route('admin.complaints.index') }}" 
            class="px-4 py-2 border border-emerald-300 text-emerald-700 rounded-lg hover:bg-emerald-50 transition-colors"
        >
            {{ __('Reset') }}
        </a>
    </div>
</form>
</div>

<!-- Complaints Table -->
<div class="bg-white rounded-xl shadow-2xs border border-emerald-100 overflow-hidden">
@if($complaints->count() > 0)
    <div class="w-full overflow-x-auto">
        <table class="min-w-max w-full">
            <thead>
                <tr class="bg-emerald-50 border-b border-emerald-100">
                    <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Tracking ID') }}</th>
                    <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Complaint') }}</th>
                    <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Citizen') }}</th>
                    <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Department') }}</th>
                    <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Assigned To') }}</th>
                    <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Status') }}</th>
                    <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Submitted') }}</th>
                    <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Actions') }}</th>
                </tr>
            </thead>
            <tbody>
                @foreach($complaints as $complaint)
                    <tr class="border-b border-emerald-50 hover:bg-emerald-50 transition-colors">
                        <td class="py-4 px-6">
                            <div class="font-mono font-semibold text-emerald-900">{{ $complaint->tracking_id }}</div>
                            <button 
                                onclick="copyTrackingId('{{ $complaint->tracking_id }}')"
                                class="text-xs text-emerald-600 hover:text-emerald-700 flex items-center space-x-1 mt-1"
                            >
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                <span>{{ __('Copy') }}</span>
                            </button>
                        </td>
                        <td class="py-4 px-6">
                            <div class="font-medium text-emerald-900">{{ Str::limit($complaint->subject, 50) }}</div>
                            <div class="text-sm text-emerald-600 mt-1">{{ Str::limit($complaint->description, 70) }}</div>
                        </td>
                        <td class="py-4 px-6">
                            <div class="text-emerald-900 font-medium">{{ $complaint->user->full_name }}</div>
                            <div class="text-sm text-emerald-600">{{ $complaint->user->email }}</div>
                        </td>
                        <td class="py-4 px-6">
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                {{ $complaint->department->name }}
                            </span>
                        </td>
                        <td class="py-4 px-6">
                            @if($complaint->officer)
                                <div class="text-emerald-900 font-medium">{{ $complaint->officer->full_name }}</div>
                                <div class="text-xs text-emerald-600">{{ __('Officer') }}</div>
                            @else
                                <span class="text-orange-600 text-sm font-medium">{{ __('Not Assigned') }}</span>
                            @endif
                        </td>
                        <td class="py-4 px-6">
                            @php
                                $statusConfig = [
                                    'pending' => ['color' => 'orange', 'label' => __('Pending')],
                                    'in_progress' => ['color' => 'blue', 'label' => __('In Progress')],
                                    'resolved' => ['color' => 'green', 'label' => __('Resolved')],
                                    'rejected' => ['color' => 'red', 'label' => __('Rejected')],
                                ];
                                $config = $statusConfig[$complaint->status] ?? ['color' => 'gray', 'label' => __('Unknown')];
                            @endphp
                            <span class="bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-800 text-xs px-3 py-1 rounded-full font-medium">
                                {{ $config['label'] }}
                            </span>
                        </td>
                        <td class="py-4 px-6 text-emerald-600 text-sm">
                            {{ $complaint->created_at->timezone('Asia/Kolkata')->format('M d, Y') }}
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex space-x-2">
                                <a 
                                    href="{{ route('admin.complaints.show', $complaint) }}" 
                                    class="px-3 py-1 bg-emerald-200 text-emerald-800 border-emerald-800 text-sm rounded hover:bg-emerald-300 transition-colors"
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
        <h3 class="text-lg font-semibold text-emerald-900 mb-2">{{ __('No Complaints Found') }}</h3>
        <p class="text-emerald-600 mb-6">{{ __('No complaints match your search criteria.') }}</p>
        <a 
            href="{{ route('admin.complaints.index') }}" 
            class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors inline-flex items-center space-x-2"
        >
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
            </svg>
            <span>{{ __('Clear Filters') }}</span>
        </a>
    </div>
@endif
</div>
</div>

<script>
    function copyTrackingId(trackingId) {
        navigator.clipboard.writeText(trackingId).then(() => {
            // Show temporary notification
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-2xs z-50';
            notification.textContent = '{{ __("Tracking ID copied!") }}';
            document.body.appendChild(notification);
            
            setTimeout(() => {
                document.body.removeChild(notification);
            }, 2000);
        }).catch(err => {
            console.error('{{ __("Failed to copy: ") }}', err);
            alert('{{ __("Failed to copy tracking ID. Please copy it manually.") }}');
        });
    }
</script>
</x-layout.app>