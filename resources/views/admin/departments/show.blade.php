<x-layout.app>
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-emerald-900">{{ __($department->name) }}</h1>
                <p class="text-emerald-600 mt-2">{{ __('Department details and statistics') }}</p>
            </div>
            <div class="flex space-x-2">
                <a 
                    href="{{ route('admin.departments.edit', $department) }}" 
                    class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center space-x-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                    </svg>
                    <span>{{ __('Edit') }}</span>
                </a>
                <a 
                    href="{{ route('admin.departments.index') }}" 
                    class="px-4 py-2 border border-emerald-300 text-emerald-700 rounded-lg hover:bg-emerald-50 transition-colors flex items-center space-x-2"
                >
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    <span>{{ __('Back to List') }}</span>
                </a>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
                <div class="text-2xl font-bold text-emerald-900">{{ $stats['total_complaints'] }}</div>
                <div class="text-sm text-emerald-600">{{ __('Total Complaints') }}</div>
            </div>
            <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
                <div class="text-2xl font-bold text-emerald-900">{{ $stats['pending_complaints'] }}</div>
                <div class="text-sm text-emerald-600">{{ __('Pending') }}</div>
            </div>
            <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
                <div class="text-2xl font-bold text-emerald-900">{{ $stats['in_progress_complaints'] }}</div>
                <div class="text-sm text-emerald-600">{{ __('In Progress') }}</div>
            </div>
            <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
                <div class="text-2xl font-bold text-emerald-900">{{ $stats['resolved_complaints'] }}</div>
                <div class="text-sm text-emerald-600">{{ __('Resolved') }}</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Department Information -->
            <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
                <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Department Information') }}</h3>
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-emerald-700 mb-1">{{ __('Department Name') }}</label>
                        <p class="text-emerald-900 font-medium text-lg">{{ $department->name }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-emerald-700 mb-1">{{ __('Total Officers') }}</label>
                        <p class="text-emerald-900 font-medium">{{ $stats['total_officers'] }} {{ __('officers') }}</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-emerald-700 mb-1">{{ __('Complaint Resolution Rate') }}</label>
                        @php
                            $resolutionRate = $stats['total_complaints'] > 0 
                                ? round(($stats['resolved_complaints'] / $stats['total_complaints']) * 100, 1) 
                                : 0;
                        @endphp
                        <p class="text-emerald-900 font-medium">{{ $resolutionRate }}%</p>
                        <div class="w-full bg-emerald-200 rounded-full h-2 mt-2">
                            <div class="bg-emerald-600 h-2 rounded-full" style="width: {{ $resolutionRate }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Assigned Officers -->
            <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
                <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Assigned Officers') }}</h3>
                @if($department->officers->count() > 0)
                    <div class="space-y-3">
                        @foreach($department->officers as $officer)
                            <div class="flex items-center justify-between p-3 border border-emerald-100 rounded-lg">
                                <div class="flex items-center space-x-3">
                                    <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center">
                                        <span class="text-emerald-600 font-semibold text-sm">
                                            {{ substr($officer->full_name, 0, 1) }}
                                        </span>
                                    </div>
                                    <div>
                                        <p class="font-medium text-emerald-900">{{ $officer->full_name }}</p>
                                        <p class="text-sm text-emerald-600">{{ $officer->email }}</p>
                                    </div>
                                </div>
                                <span class="bg-emerald-100 text-emerald-800 text-xs px-2 py-1 rounded">
                                    {{ __('Officer') }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <i class="fa-solid fa-users"></i>
                        </div>
                        <h4 class="text-lg font-semibold text-emerald-900 mb-2">{{ __('No Officers Assigned') }}</h4>
                        <p class="text-emerald-600 text-sm">{{ __('Assign officers to this department to handle complaints.') }}</p>
                    </div>
                @endif
            </div>
        </div>

        <!-- Recent Complaints -->
        <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-semibold text-emerald-900">{{ __('Recent Complaints') }}</h3>
                <a href="{{ route('admin.complaints.index', ['department_id' => $department->id]) }}" 
                   class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                    {{ __('View All') }} →
                </a>
            </div>
            
            @if($department->complaints->count() > 0)
                <div class="space-y-3">
                    @foreach($department->complaints as $complaint)
                        <div class="flex items-center justify-between p-3 border border-emerald-100 rounded-lg hover:bg-emerald-50 transition-colors">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <p class="font-medium text-emerald-900 text-sm">{{ Str::limit($complaint->subject, 50) }}</p>
                                    <span class="bg-{{ $complaint->status === 'pending' ? 'orange' : ($complaint->status === 'in_progress' ? 'blue' : 'green') }}-100 text-{{ $complaint->status === 'pending' ? 'orange' : ($complaint->status === 'in_progress' ? 'blue' : 'green') }}-800 text-xs px-2 py-1 rounded-full">
                                        {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                    </span>
                                </div>
                                <div class="text-xs text-emerald-600 mt-1">
                                    {{ $complaint->tracking_id }} • {{ $complaint->created_at->timezone('Asia/Kolkata')->format('M d, h:i A') }}
                                </div>
                            </div>
                            <a 
                                href="{{ route('admin.complaints.show', $complaint) }}" 
                                class="text-emerald-600 hover:text-emerald-700 ml-2"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-8">
                    <div class="w-16 h-16 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <svg class="w-8 h-8 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <h4 class="text-lg font-semibold text-emerald-900 mb-2">{{ __('No Complaints Yet') }}</h4>
                    <p class="text-emerald-600 text-sm">{{ __('This department has not received any complaints yet.') }}</p>
                </div>
            @endif
        </div>
    </div>
</x-layout.app>