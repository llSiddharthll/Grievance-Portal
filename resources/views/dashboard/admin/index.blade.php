<x-layout.app>
    <div class="space-y-6">

        <!-- Page Header -->
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-emerald-800">{{ __('Admin Dashboard') }}</h1>
                <p class="text-emerald-600 mt-2">{{ __('Overview of grievance portal statistics and activities') }}</p>
            </div>

            <div class="flex flex-col gap-2">
                <div class="text-sm text-emerald-700 bg-emerald-100 px-3 py-1 rounded-lg">
                    {{ __('Last updated') }}: {{ now()->timezone('Asia/Kolkata')->format('M d, Y h:i A') }} IST
                </div>

                <div class="flex gap-3 mb-4 items-center justify-center">
                    <span class="text-emerald-700">{{ __('Download Report as') }}: </span>
                    <button id="downloadPdfBtn"
                        class="px-4 py-2 bg-emerald-100 text-emerald-800 rounded-lg cursor-pointer">
                        <i class="fa-regular fa-file-pdf"></i>
                    </button>

                    <button id="downloadWordBtn"
                        class="px-4 py-2 bg-emerald-100 text-emerald-800 rounded-lg cursor-pointer">
                        <i class="fa-regular fa-file-word"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

            <!-- Total Complaints -->
            <div class="bg-white rounded-xl shadow-sm border border-emerald-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-500 text-sm font-medium">{{ __('Total Complaints') }}</p>
                        <p class="text-3xl font-bold text-emerald-700 mt-2" data-total>{{ $totalComplaints }}</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-emerald-500 text-sm font-medium">{{ __('All time complaints') }}</span>
                </div>
            </div>

            <!-- Pending -->
            <div class="bg-white rounded-xl shadow-sm border border-emerald-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-500 text-sm font-medium">{{ __('Pending') }}</p>
                        <p class="text-3xl font-bold text-emerald-700 mt-2" data-pending>{{ $pendingComplaints }}</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-emerald-500 text-sm font-medium">{{ __('Awaiting action') }}</span>
                </div>
            </div>

            <!-- In Progress -->
            <div class="bg-white rounded-xl shadow-sm border border-emerald-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-500 text-sm font-medium">{{ __('In Progress') }}</p>
                        <p class="text-3xl font-bold text-emerald-700 mt-2" data-progress>{{ $inProgressComplaints }}
                        </p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" />
                        </svg>
                    </div>
                </div>
                <div class="mt-4">
                    <span class="text-emerald-500 text-sm font-medium">{{ __('Under review') }}</span>
                </div>
            </div>

            <!-- Resolved -->
            <div class="bg-white rounded-xl shadow-sm border border-emerald-100 p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-emerald-500 text-sm font-medium">{{ __('Resolved') }}</p>
                        <p class="text-3xl font-bold text-emerald-700 mt-2" data-resolved>{{ $resolvedComplaints }}</p>
                    </div>
                    <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                </div>

                @php
                    $resolutionRate =
                        $totalComplaints > 0 ? round(($resolvedComplaints / $totalComplaints) * 100, 1) : 0;
                @endphp

                <div class="mt-4">
                    <span class="text-emerald-500 text-sm font-medium">
                        {{ $resolutionRate }}% {{ __('resolution rate') }}
                    </span>
                </div>
            </div>

        </div>

        <!-- Charts Section (emerald themed) -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-6">

            <div class="bg-white rounded-xl shadow-sm border border-emerald-100 p-6">
                <h3 class="text-lg font-semibold text-emerald-800 mb-4">{{ __('Top Officers') }}</h3>
                <canvas id="officerChart" height="100"></canvas>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-emerald-100 p-6">
                <h3 class="text-lg font-semibold text-emerald-800 mb-4">{{ __('Lowest Officers') }}</h3>
                <canvas id="lowOfficerChart" height="100"></canvas> 
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-emerald-100 p-6">
                <h3 class="text-lg font-semibold text-emerald-800 mb-4">{{ __('Monthly Trend') }}</h3>
                <canvas id="monthlyTrendChart" height="100"></canvas>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-emerald-100 p-6">
                <h3 class="text-lg font-semibold text-emerald-800 mb-4">{{ __('Department Score') }}</h3>
                <canvas id="departmentScoreChart" height="100"></canvas>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-emerald-100 p-6 md:col-span-2">
                <h3 class="text-lg font-semibold text-emerald-800 mb-4">{{ __('Complaints by Department') }}</h3>
                <canvas id="departmentChart" height="100"></canvas>
            </div>
        </div>

        <!-- Chart.js (Emerald only colors) -->
        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>
            const emeraldLight = "#A7F3D0";
            const emeraldMed = "#6EE7B7";
            const emerald = "#34D399";
            const emeraldDark = "#059669";

            /* Monthly Trend */
            new Chart(document.getElementById("monthlyTrendChart"), {
                type: "line",
                data: {
                    labels: @json($monthlyTrend->map(fn($i) => $i->month . '-' . $i->year)),
                    datasets: [{
                            label: "Total Complaints",
                            data: @json($monthlyTrend->map(fn($i) => $i->count)),
                            borderColor: emeraldDark,
                            backgroundColor: "rgba(16,185,129,0.2)",
                        },
                        {
                            label: "Resolved",
                            data: @json($monthlyTrend->map(fn($i) => $i->resolved_count)),
                            borderColor: emerald,
                            backgroundColor: "rgba(52,211,153,0.2)",
                        }
                    ]
                }
            });

            /* Dept Score */
            new Chart(document.getElementById("departmentScoreChart"), {
                type: "pie",
                data: {
                    labels: @json($departmentScores->pluck('name')),
                    datasets: [{
                        data: @json($departmentScores->pluck('performance_score')),
                        backgroundColor: [
                            emeraldLight, emeraldMed, emerald, emeraldDark,
                            "#D1FAE5", "#86EFAC"
                        ]
                    }]
                }
            });

            /* Dept Complaints */
            new Chart(document.getElementById("departmentChart"), {
                type: "bar",
                data: {
                    labels: @json($departmentStats->pluck('name')),
                    datasets: [{
                        label: "{{ __('Complaints') }}",
                        data: @json($departmentStats->pluck('total_complaints')),
                        backgroundColor: emerald
                    }]
                }
            });

            /* Top Officers */
            new Chart(document.getElementById("officerChart"), {
                type: "bar",
                data: {
                    labels: @json($topOfficers->pluck('full_name')),
                    datasets: [{
                        label: "{{ __('Performance') }}",
                        data: @json($topOfficers->pluck('performance_score')),
                        backgroundColor: emeraldDark
                    }]
                },
                options: {
                    indexAxis: 'y'
                }
            });

            /* Low Officers */
            new Chart(document.getElementById("lowOfficerChart"), {
                type: "bar",
                data: {
                    labels: @json($lowOfficers->pluck('full_name')),
                    datasets: [{
                        label: "{{ __('Performance') }}",
                        data: @json($lowOfficers->pluck('performance_score')),
                        backgroundColor: emeraldLight
                    }]
                },
                options: {
                    indexAxis: 'y'
                }
            });
        </script>

    </div>
</x-layout.app>
