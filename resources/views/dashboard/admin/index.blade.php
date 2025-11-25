<x-layout.app>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-emerald-900">{{ __('Admin Dashboard') }}</h1>
                <p class="text-emerald-600 mt-2">Overview of grievance portal statistics and activities</p>
            </div>
            <div class="text-sm text-emerald-600 bg-emerald-50 px-3 py-1 rounded-lg">
                {{ __('Last updated') }}: {{ now()->timezone('Asia/Kolkata')->format('M d, Y h:i A') }} IST
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
            <!-- Total Complaints -->
            <div class="bg-white rounded-xl shadow-lg border border-emerald-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-600 text-sm font-medium">{{ __('Total Complaints') }}</p>
                        <p class="text-3xl font-bold text-emerald-900 mt-2">{{ $totalComplaints }}</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-green-600 text-sm font-medium">{{ __('All time complaints') }}</span>
                </div>
            </div>

            <!-- Pending Complaints -->
            <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-600 text-sm font-medium">{{ __('Pending') }}</p>
                        <p class="text-3xl font-bold text-orange-900 mt-2">{{ $pendingComplaints }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-orange-600 text-sm font-medium">{{ __('Awaiting action') }}</span>
                </div>
            </div>

            <!-- In Progress -->
            <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-600 text-sm font-medium">{{ __('In Progress') }}</p>
                        <p class="text-3xl font-bold text-blue-900 mt-2">{{ $inProgressComplaints }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-blue-600 text-sm font-medium">{{ __('Under review') }}</span>
                </div>
            </div>

            <!-- Resolved -->
            <div class="bg-white rounded-xl shadow-lg border border-green-100 p-6">
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
                        $resolutionRate = $totalComplaints > 0 ? round(($resolvedComplaints / $totalComplaints) * 100, 1) : 0;
                    @endphp
                    <span class="text-green-600 text-sm font-medium">{{ $resolutionRate }}% {{ __('resolution rate') }}</span>
                </div>
            </div>
        </div>

        <!-- Charts and Recent Activity Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Department-wise Distribution -->
            <div class="bg-white rounded-xl shadow-lg border border-emerald-100 p-6">
                <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Department-wise Complaints') }}</h3>
                <div class="space-y-4">
                    @foreach($departmentStats as $department)
                        @php
                            $percentage = $totalComplaints > 0 ? round(($department->total_complaints / $totalComplaints) * 100, 1) : 0;
                        @endphp
                        <div class="space-y-2">
                            <div class="flex justify-between items-center">
                                <span class="text-sm font-medium text-emerald-900">{{ $department->name }}</span>
                                <span class="text-sm text-emerald-600">{{ $department->total_complaints }} ({{ $percentage }}%)</span>
                            </div>
                            <div class="w-full bg-emerald-200 rounded-full h-2">
                                <div class="bg-emerald-600 h-2 rounded-full" style="width: {{ $percentage }}%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-emerald-500">
                                <span>{{ __('Pending') }}: {{ $department->pending_complaints }}</span>
                                <span>{{ __('Resolved') }}: {{ $department->resolved_complaints }}</span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Recent Complaints -->
            <div class="bg-white rounded-xl shadow-lg border border-emerald-100 p-6">
                <div class="flex justify-between items-center mb-4">
                    <h3 class="text-lg font-semibold text-emerald-900">{{ __('Recent Complaints') }}</h3>
                    <a href="" class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                        {{ __('View All') }} →
                    </a>
                </div>
                <div class="space-y-4">
                    @foreach($recentComplaints as $complaint)
                        <div class="flex items-center justify-between p-3 border border-emerald-100 rounded-lg hover:bg-emerald-50 transition-colors">
                            <div class="flex-1">
                                <div class="flex items-center space-x-2">
                                    <p class="font-medium text-emerald-900 text-sm">{{ Str::limit($complaint->subject, 40) }}</p>
                                    <span class="bg-{{ $complaint->status === 'pending' ? 'orange' : ($complaint->status === 'in_progress' ? 'blue' : 'green') }}-100 text-{{ $complaint->status === 'pending' ? 'orange' : ($complaint->status === 'in_progress' ? 'blue' : 'green') }}-800 text-xs px-2 py-1 rounded-full">
                                        {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                                    </span>
                                </div>
                                <div class="text-xs text-emerald-600 mt-1">
                                    {{ $complaint->department->name }} • {{ $complaint->created_at->timezone('Asia/Kolkata')->format('M d, h:i A') }}
                                </div>
                            </div>
                            <a 
                                href="" 
                                class="text-emerald-600 hover:text-emerald-700 ml-2"
                            >
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </a>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Additional Stats -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <!-- Departments -->
            <div class="bg-white rounded-xl shadow-lg border border-emerald-100 p-6 text-center">
                <div class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-purple-900">{{ $totalDepartments }}</p>
                <p class="text-purple-600 text-sm">{{ __('Departments') }}</p>
            </div>

            <!-- Users -->
            <div class="bg-white rounded-xl shadow-lg border border-emerald-100 p-6 text-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <p class="text-2xl font-bold text-blue-900">{{ $totalUsers }}</p>
                <p class="text-blue-600 text-sm">{{ __('Registered Users') }}</p>
            </div>

            <!-- Resolution Rate -->
            <div class="bg-white rounded-xl shadow-lg border border-emerald-100 p-6 text-center">
                <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center mx-auto mb-3">
                    <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                @php
                    $resolutionRate = $totalComplaints > 0 ? round(($resolvedComplaints / $totalComplaints) * 100, 1) : 0;
                @endphp
                <p class="text-2xl font-bold text-green-900">{{ $resolutionRate }}%</p>
                <p class="text-green-600 text-sm">{{ __('Resolution Rate') }}</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-emerald-50 rounded-xl border border-emerald-200 p-6">
            <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Quick Actions') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <a href="" class="bg-white p-4 rounded-lg border border-emerald-200 hover:shadow-md transition-shadow text-center">
                    <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-emerald-900">{{ __('Manage Complaints') }}</span>
                </a>
                <a href="" class="bg-white p-4 rounded-lg border border-emerald-200 hover:shadow-md transition-shadow text-center">
                    <div class="w-8 h-8 bg-purple-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <svg class="w-4 h-4 text-purple-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-emerald-900">{{ __('Departments') }}</span>
                </a>
                <a href="" class="bg-white p-4 rounded-lg border border-emerald-200 hover:shadow-md transition-shadow text-center">
                    <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-emerald-900">{{ __('Users') }}</span>
                </a>
                <a href="" class="bg-white p-4 rounded-lg border border-emerald-200 hover:shadow-md transition-shadow text-center">
                    <div class="w-8 h-8 bg-orange-100 rounded-lg flex items-center justify-center mx-auto mb-2">
                        <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <span class="text-sm font-medium text-emerald-900">{{ __('Reports') }}</span>
                </a>
            </div>
        </div>
    </div>
</x-layout.app>