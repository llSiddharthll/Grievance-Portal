<x-layout.app>
    <div class="space-y-6 max-w-[85vw] md:max-w-auto">
        <!-- Page Header -->
        <div class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 md:gap-0">
            <div>
                <h1 class="text-3xl font-bold text-emerald-900">{{ __('Citizen Dashboard') }}</h1>
                <p class="text-emerald-600 mt-2">{{ __('Welcome Back')}}, {{ Auth::user()->full_name ?? Auth::user()->name }}! {{ __("Here's your complaint overview.") }}</p>
            </div>
            <div class="flex space-x-3">
                <button class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition-colors flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <span>{{ __('New Complaint') }}</span>
                </button>
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
                    <span class="text-green-600 text-sm font-medium">{{ __('All your submitted complaints') }}</span>
                </div>
            </div>

            <!-- Resolved -->
            <div class="bg-white rounded-xl shadow-lg border border-green-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-green-600 text-sm font-medium">{{ __('Resolved') }}</p>
                        <p class="text-3xl font-bold text-green-900 mt-2">{{ $resolvedCount }}</p>
                    </div>
                    <div class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-green-600 text-sm font-medium">{{ $successRate }}% {{ __('success rate') }}</span>
                </div>
            </div>

            <!-- In Progress -->
            <div class="bg-white rounded-xl shadow-lg border border-blue-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-blue-600 text-sm font-medium">{{ __('In Progress') }}</p>
                        <p class="text-3xl font-bold text-blue-900 mt-2">{{ $inProgressCount }}</p>
                    </div>
                    <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-blue-600 text-sm font-medium">{{ __('Being actively addressed') }}</span>
                </div>
            </div>

            <!-- Pending -->
            <div class="bg-white rounded-xl shadow-lg border border-orange-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-orange-600 text-sm font-medium">{{ __('Pending') }}</p>
                        <p class="text-3xl font-bold text-orange-900 mt-2">{{ $pendingCount }}</p>
                    </div>
                    <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-orange-600 text-sm font-medium">{{ __('Waiting for review') }}</span>
                </div>
            </div>
        </div>

        <!-- Charts and Graphs Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Status Distribution Chart -->
            <div class="bg-white rounded-xl shadow-lg border border-emerald-100 p-6">
                <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Complaint Status Distribution') }}</h3>
                <div class="h-64 flex items-center justify-center">
                    <div class="w-full max-w-md">
                        @php
                            $total = $totalComplaints ?: 1; // Avoid division by zero
                            $resolvedPercent = round(($resolvedCount / $total) * 100);
                            $inProgressPercent = round(($inProgressCount / $total) * 100);
                            $pendingPercent = round(($pendingCount / $total) * 100);
                        @endphp
                        
                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm text-emerald-600">{{ __('Resolved') }}</span>
                            <span class="text-sm font-medium text-emerald-900">{{ $resolvedCount }} ({{ $resolvedPercent }}%)</span>
                        </div>
                        <div class="w-full bg-emerald-200 rounded-full h-3 mb-4">
                            <div class="bg-green-600 h-3 rounded-full" style="width: {{ $resolvedPercent }}%"></div>
                        </div>

                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm text-blue-600">{{ __('In Progress') }}</span>
                            <span class="text-sm font-medium text-blue-900">{{ $inProgressCount }} ({{ $inProgressPercent }}%)</span>
                        </div>
                        <div class="w-full bg-blue-200 rounded-full h-3 mb-4">
                            <div class="bg-blue-600 h-3 rounded-full" style="width: {{ $inProgressPercent }}%"></div>
                        </div>

                        <div class="flex items-center justify-between mb-3">
                            <span class="text-sm text-orange-600">{{ __('Pending') }}</span>
                            <span class="text-sm font-medium text-orange-900">{{ $pendingCount }} ({{ $pendingPercent }}%)</span>
                        </div>
                        <div class="w-full bg-orange-200 rounded-full h-3">
                            <div class="bg-orange-600 h-3 rounded-full" style="width: {{ $pendingPercent }}%"></div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Monthly Trend Chart -->
            <div class="bg-white rounded-xl shadow-lg border border-emerald-100 p-6">
                <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Monthly Complaint Trend') }}</h3>
                <div class="h-64 flex items-end justify-between space-x-2 px-4">
                    @php
                        $maxCount = max($monthlyTrend['counts']) ?: 1; // Avoid division by zero
                        $colors = ['bg-emerald-300', 'bg-emerald-400', 'bg-emerald-500', 'bg-emerald-600', 'bg-emerald-700', 'bg-emerald-800'];
                    @endphp
                    
                    @foreach($monthlyTrend['months'] as $index => $month)
                        @php
                            $count = $monthlyTrend['counts'][$index];
                            $height = $maxCount > 0 ? ($count / $maxCount) * 160 : 0; // Max height 160px
                            $color = $colors[$index] ?? 'bg-emerald-400';
                        @endphp
                        <div class="flex flex-col items-center flex-1">
                            <div class="text-xs text-emerald-600 mb-1">{{ $month }}</div>
                            <div class="w-full {{ $color }} rounded-t transition-all duration-500" style="height: {{ $height }}px"></div>
                            <div class="text-xs text-emerald-900 mt-1">{{ $count }}</div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

        <!-- Recent Complaints Table -->
        <div class="bg-white rounded-xl shadow-lg border border-emerald-100 p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="text-lg font-semibold text-emerald-900">{{ __('Recent Complaints') }}</h3>
                <button class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                    {{ __('View All →') }}
                </button>
            </div>
            
            <div class="overflow-x-auto">
                <table class="w-full table-auto whitespace-nowrap">
                    <thead>
                        <tr class="border-b border-emerald-100">
                            <th class="text-left py-3 px-4 text-emerald-600 font-medium">{{ __('Tracking ID') }}</th>
                            <th class="text-left py-3 px-4 text-emerald-600 font-medium">{{ __('Subject') }}</th>
                            <th class="text-left py-3 px-4 text-emerald-600 font-medium">{{ __('Date') }}</th>
                            <th class="text-left py-3 px-4 text-emerald-600 font-medium">{{ __('Status') }}</th>
                            <th class="text-left py-3 px-4 text-emerald-600 font-medium">{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($complaints as $complaint)
                            <tr class="border-b border-emerald-50 hover:bg-emerald-50">
                                <td class="py-3 px-4 max-w-[150px] md:max-w-auto">
                                    <div class="font-medium text-emerald-900">#{{ $complaint->tracking_id }}</div>
                                    <div class="text-sm text-emerald-600">{{ Str::limit($complaint->subject, 30) }}</div>
                                </td>
                                <td class="py-3 px-4 max-w-[150px] md:max-w-auto">
                                    <span class="text-sm text-emerald-600">{{ Str::limit($complaint->subject, 40) }}</span>
                                </td>
                                <td class="py-3 px-4 text-emerald-600">{{ $complaint->created_at->format('d M Y') }}</td>
                                <td class="py-3 px-4 max-w-[150px] md:max-w-auto">
                                    @php
                                        $statusColors = [
                                            'Resolved' => 'bg-green-100 text-green-800',
                                            'In Progress' => 'bg-blue-100 text-blue-800',
                                            'Pending' => 'bg-orange-100 text-orange-800',
                                            'Rejected' => 'bg-red-100 text-red-800'
                                        ];
                                        $statusColorClass = $statusColors[$complaint->status] ?? 'bg-gray-100 text-gray-800';
                                    @endphp
                                    <span class="{{ $statusColorClass }} text-xs px-2 py-1 rounded font-medium">{{ $complaint->status }}</span>
                                </td>
                                <td class="py-3 px-4 max-w-[150px] md:max-w-auto">
                                    <button class="text-emerald-600 hover:text-emerald-700 text-sm font-medium">
                                        {{ __('View Details') }}
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-emerald-600">
                                    {{ __("No complaints found. Start by filing your first complaint!") }}
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-emerald-50 rounded-xl border border-emerald-200 p-6 text-center">
                <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                <h4 class="font-semibold text-emerald-900 mb-2">{{ __('File New Complaint') }}</h4>
                <p class="text-emerald-600 text-sm mb-4">{{ __('Submit a new complaint or request') }}</p>
                <a href="{{ route('complaints.create') }}" class="bg-emerald-600 text-white px-4 py-2 rounded-lg hover:bg-emerald-700 transition-colors text-sm">
                    {{ __('Get Started') }}
                </a>
            </div>

            <div class="bg-blue-50 rounded-xl border border-blue-200 p-6 text-center">
                <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path>
                    </svg>
                </div>
                <h4 class="font-semibold text-blue-900 mb-2">{{ __('Track Status') }}</h4>
                <p class="text-blue-600 text-sm mb-4">{{ __('Check your existing complaint status') }}</p>
                <a href="{{ route('tracking.form') }}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors text-sm">
                    {{ __('Track Now') }}
                </a>
            </div>

            <div class="bg-orange-50 rounded-xl border border-orange-200 p-6 text-center">
                <div class="w-12 h-12 bg-orange-100 rounded-lg flex items-center justify-center mx-auto mb-4">
                    <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <h4 class="font-semibold text-orange-900 mb-2">{{ __('Need Help?') }}</h4>
                <p class="text-orange-600 text-sm mb-4">{{ __('Get assistance with your complaints') }}</p>
                <button class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 transition-colors text-sm">
                    {{ __('Get Help') }}
                </button>
            </div>
        </div>
    </div>
</x-layout.app>