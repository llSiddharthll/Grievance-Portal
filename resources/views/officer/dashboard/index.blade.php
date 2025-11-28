<x-layout.app>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-emerald-900">{{ __('officer_dashboard') }}</h1>
                <p class="text-emerald-600 mt-2">{{ __('welcome_back_assigned_overview') }}</p>
            </div>
            <div class="text-sm text-emerald-600 bg-emerald-50 px-3 py-1 rounded-lg">
                {{ __(Auth::user()->department->name) }}
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Assigned Complaints -->
            <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-600 text-sm font-medium">{{ __('Assigned Complaints') }}</p>
                        <p class="text-3xl font-bold text-emerald-900 mt-2">{{ $assignedComplaints }}</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-emerald-600 text-sm">{{ __('total_complaints_assigned_to_you') }}</span>
                </div>
            </div>

            <!-- Pending Action -->
            <div class="bg-white rounded-xl shadow-2xs border border-orange-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-600 text-sm font-medium">{{ __('pending_action_title') }}</p>
                        <p class="text-3xl font-bold text-orange-900 mt-2">{{ $pendingComplaints }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-orange-600 text-sm">{{ __('require_your_attention') }}</span>
                </div>
            </div>

            <!-- Resolved -->
            <div class="bg-white rounded-xl shadow-2xs border border-green-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-600 text-sm font-medium">{{ __('Resolved') }}</p>
                        <p class="text-3xl font-bold text-green-900 mt-2">{{ $resolvedComplaints }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    @php
                        $resolutionRate = $assignedComplaints > 0 ? round(($resolvedComplaints / $assignedComplaints) * 100, 1) : 0;
                    @endphp
                    <span class="text-green-600 text-sm font-medium">{{ $resolutionRate }}% {{ __('Resolution Rate') }}</span>
                </div>
            </div>
        </div>

        <!-- Recent Complaints & Department Stats -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Recent Complaints -->
            <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-emerald-900">{{ __('Recent Assigned Complaints') }}</h3>
                    <a href="{{ route('officer.complaints.index') }}" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                        {{ __('View All') }} →
                    </a>
                </div>
                <div class="space-y-4">
                    @forelse($recentComplaints as $complaint)
                        <div class="flex items-center justify-between p-3 border border-emerald-100 rounded-lg hover:bg-emerald-50 transition-colors">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <p class="font-medium text-emerald-900 text-sm">{{ Str::limit($complaint->subject, 40) }}</p>
                                    <span class="bg-{{ $complaint->status === 'in_progress' ? 'blue' : 'green' }}-100 text-{{ $complaint->status === 'in_progress' ? 'blue' : 'green' }}-800 text-xs px-2 py-1 rounded-full">
                                        {{ __(ucfirst(str_replace('_', ' ', $complaint->status))) }}
                                    </span>
                                </div>
                                <div class="text-xs text-emerald-600 mt-1">
                                    {{ $complaint->user->full_name }} • {{ $complaint->created_at->timezone('Asia/Kolkata')->format('M d, h:i A') }}
                                </div>
                            </div>
                            <a 
                                href="{{ route('officer.complaints.show', $complaint) }}" 
                                class="text-emerald-600 hover:text-emerald-700 ml-2"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    @empty
                        <div class="text-center py-8">
                            <svg class="w-12 h-12 text-emerald-300 mx-auto mb-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            <p class="text-emerald-600">No complaints assigned to you yet.</p>
                        </div>
                    @endforelse
                </div>
            </div>

            <!-- Department Overview -->
            <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
                <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Department Overview') }}</h3>
                <div class="space-y-4">
                    @php
                        $totalDeptComplaints = $departmentStats->sum('count');
                    @endphp
                    
                    @foreach($departmentStats as $stat)
                        @php
                            $percentage = $totalDeptComplaints > 0 ? round(($stat->count / $totalDeptComplaints) * 100, 1) : 0;
                            $statusConfig = [
                                'pending' => ['color' => 'orange', 'label' => 'Pending'],
                                'in_progress' => ['color' => 'blue', 'label' => 'In Progress'],
                                'resolved' => ['color' => 'green', 'label' => 'Resolved'],
                                'rejected' => ['color' => 'red', 'label' => 'Rejected'],
                            ];
                            $config = $statusConfig[$stat->status] ?? ['color' => 'gray', 'label' => 'Unknown'];
                        @endphp
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-{{ $config['color'] }}-700">{{ __($config['label']) }}</span>
                                <span class="text-sm text-{{ $config['color'] }}-600">{{ $stat->count }} ({{ $percentage }}%)</span>
                            </div>
                            <div class="w-full bg-{{ $config['color'] }}-200 rounded-full h-2">
                                <div class="bg-{{ $config['color'] }}-500 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                        </div>
                    @endforeach
                    
                    <div class="pt-4 border-t border-emerald-100">
                        <div class="flex justify-between items-center text-sm">
                            <span class="text-emerald-700 font-medium">{{ __('Total Department Complaints') }}</span>
                            <span class="text-emerald-900 font-bold">{{ $totalDeptComplaints }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-emerald-50 rounded-xl border border-emerald-200 p-6">
            <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Quick Actions') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <a href="{{ route('officer.complaints.index') }}" class="bg-white p-4 rounded-lg border border-emerald-200 hover:shadow-md transition-shadow text-center">
                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-emerald-900">{{ __('View All Complaints') }}</span>
                </a>
                
                <a href="{{ route('officer.complaints.index', ['status' => 'in_progress']) }}" class="bg-white p-4 rounded-lg border border-emerald-200 hover:shadow-md transition-shadow text-center">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-emerald-900">{{ __('Pending Actions') }}</span>
                </a>
                
                <div class="bg-white p-4 rounded-lg border border-emerald-200 text-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-emerald-900">{{ __(Auth::user()->department->name) }}</span>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>