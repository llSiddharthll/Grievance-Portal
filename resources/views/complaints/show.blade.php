<x-layout.app>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-emerald-900">{{ __('Grievance Details') }}</h1>
                <p class="text-emerald-600 mt-2">{{ __('Complete information about your complaint') }}</p>
            </div>
            <a href="{{ route('complaints.index') }}"
                class="px-4 py-2 border border-emerald-300 text-emerald-700 rounded-lg hover:bg-emerald-50 transition-colors flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>{{ __('Back to List') }}</span>
            </a>
        </div>

        <!-- Tracking ID Card -->
        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-6">
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <p class="text-sm text-emerald-600 font-medium">{{ __('Tracking ID') }}</p>
                        <p class="text-2xl font-bold text-emerald-900 font-mono" id="trackingId">
                            {{ $complaint->tracking_id }}</p>
                    </div>
                </div>
                <button onclick="copyTrackingId()"
                    class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center space-x-2 text-sm"
                    id="copyButton">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                        </path>
                    </svg>
                    <span>{{ __('Copy ID') }}</span>
                </button>
            </div>
            <!-- Copy Success Message -->
            <div id="copySuccess" class="hidden mt-3 p-2 bg-green-100 border border-green-200 rounded-lg">
                <p class="text-green-700 text-sm flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ __('Tracking ID copied to clipboard!') }}</span>
                </p>
            </div>
        </div>

        <!-- Complaint Details -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Complaint Info -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Subject & Description -->
                <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
                    <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Complaint Information') }}</h3>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-emerald-700 mb-1">{{ __('Subject') }}</label>
                            <p class="text-emerald-900 font-medium">{{ $complaint->subject }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-emerald-700 mb-1">{{ __('Detailed Description') }}</label>
                            <p class="text-emerald-600 whitespace-pre-line">{{ $complaint->description }}</p>
                        </div>
                    </div>
                </div>

                <!-- Status Timeline -->
                <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
                    <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Status Timeline') }}</h3>
                    <div class="space-y-4">
                        <div class="flex items-start space-x-3">
                            <div
                                class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 13l4 4L19 7"></path>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <p class="font-medium text-emerald-900">{{ __('Complaint Registered') }}</p>
                                <p class="text-sm text-emerald-600">{{ __('Your grievance has been successfully submitted') }}</p>
                                <p class="text-xs text-emerald-500">
                                    {{ $complaint->created_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }} IST
                                </p>
                            </div>
                        </div>
                        @if ($complaint->officer)
                            <div class="flex items-start space-x-3">
                                <div
                                    class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-emerald-900">{{ __('Assigned to Officer') }}</p>
                                    <p class="text-sm text-emerald-600">{{ __('Complaint assigned to') }}
                                        {{ $complaint->officer->full_name }}</p>
                                    <p class="text-xs text-emerald-500">
                                        {{ $complaint->updated_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }}
                                        IST</p>
                                </div>
                            </div>
                        @endif

                        @if ($complaint->status === 'resolved')
                            <div class="flex items-start space-x-3">
                                <div
                                    class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-emerald-900">{{ __('Resolved') }}</p>
                                    <p class="text-sm text-emerald-600">{{ __('Complaint has been successfully resolved') }}</p>
                                    <p class="text-xs text-emerald-500">
                                        {{ $complaint->updated_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }}
                                        IST</p>
                                </div>
                            </div>
                        @endif
                        @if ($complaint->status === 'in_progress')
                            <div class="flex items-start space-x-3">
                                <div
                                    class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-emerald-900">{{ __('Under Review') }}</p>
                                    <p class="text-sm text-emerald-600">{{ __('Department is currently reviewing your complaint') }}
                                    </p>
                                    <p class="text-xs text-emerald-500">
                                        {{ $complaint->updated_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }}
                                        IST</p>
                                </div>
                            </div>
                        @endif

                        @if ($complaint->status === 'resolved')
                            <div class="mt-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <p class="font-medium text-green-900">{{ __('Complaint Resolved') }}</p>
                                        <p class="text-green-700 text-sm">{{ __('Thank you for using our grievance portal') }}</p>
                                    </div>
                                    @php
                                        $hasFeedback = auth()
                                            ->user()
                                            ->feedback()
                                            ->where('complaint_id', $complaint->id)
                                            ->exists();
                                    @endphp
                                    @if (!$hasFeedback)
                                        <a href="{{ route('feedback.create', $complaint) }}"
                                            class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                            {{ __('Provide Feedback') }}
                                        </a>
                                    @else
                                        <span class="px-4 py-2 bg-green-100 text-green-800 rounded-lg">{{ __('Feedback Submitted') }}</span>
                                    @endif
                                </div>
                            </div>
                        @endif

                        @if ($complaint->status === 'rejected')
                            <div class="flex items-start space-x-3">
                                <div
                                    class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </div>
                                <div class="flex-1">
                                    <p class="font-medium text-emerald-900">{{ __('Rejected') }}</p>
                                    <p class="text-sm text-emerald-600">{{ __('Your complaint has been reviewed and rejected') }}
                                    </p>
                                    <p class="text-xs text-emerald-500">
                                        {{ $complaint->updated_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }}
                                        IST</p>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="space-y-6">
                <!-- Status Card -->
                <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
                    <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Current Status') }}</h3>
                    @php
                        $statusConfig = [
                            'pending' => ['color' => 'orange', 'label' => 'Pending', 'icon' => 'clock'],
                            'in_progress' => ['color' => 'blue', 'label' => 'In Progress', 'icon' => 'refresh'],
                            'resolved' => ['color' => 'green', 'label' => 'Resolved', 'icon' => 'check-circle'],
                            'rejected' => ['color' => 'red', 'label' => 'Rejected', 'icon' => 'x-circle'],
                        ];
                        $config = $statusConfig[$complaint->status] ?? [
                            'color' => 'gray',
                            'label' => 'Unknown',
                            'icon' => 'question-mark',
                        ];
                    @endphp
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-{{ $config['color'] }}-100 rounded-full flex items-center justify-center mx-auto mb-3">
                            <svg class="w-8 h-8 text-{{ $config['color'] }}-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                @if ($config['icon'] === 'clock')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                @elseif($config['icon'] === 'refresh')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15">
                                    </path>
                                @elseif($config['icon'] === 'check-circle')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                @elseif($config['icon'] === 'x-circle')
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                @else
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                @endif
                            </svg>
                        </div>
                        <p class="text-{{ $config['color'] }}-800 font-semibold">{{ $config['label'] }}</p>
                    </div>
                </div>

                <!-- Department & Dates -->
                <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
                    <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Complaint Details') }}</h3>
                    <div class="space-y-3">
                        <div>
                            <label class="block text-sm font-medium text-emerald-700 mb-1">{{ __('Department') }}</label>
                            <p class="text-emerald-900">{{ $complaint->department->name }}</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-emerald-700 mb-1">{{ __('Submitted On') }}</label>
                            <p class="text-emerald-600">
                                {{ $complaint->created_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }} IST</p>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-emerald-700 mb-1">{{ __('Last Updated') }}</label>
                            <p class="text-emerald-600">
                                {{ $complaint->updated_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }} IST</p>
                        </div>
                    </div>
                </div>

                <!-- Attachments -->
                @if ($complaint->file_path)
                    <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
                        <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Attached File') }}</h3>
                        <div class="flex items-center space-x-3 p-3 bg-emerald-50 rounded-lg">
                            <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                                </path>
                            </svg>
                            <div class="flex-1">
                                <p class="text-sm font-medium text-emerald-900">{{ __('Supporting Document') }}</p>
                                <p class="text-xs text-emerald-600">
                                    {{ pathinfo($complaint->file_path, PATHINFO_BASENAME) }}</p>
                            </div>
                            <a href="{{ asset('storage/' . $complaint->file_path) }}" target="_blank"
                                class="px-3 py-1 bg-emerald-200 text-emerald-800 border-emerald-800 text-sm rounded hover:bg-emerald-300 transition-colors">
                                {{ __('View') }}
                            </a>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        function copyTrackingId() {
            const trackingId = document.getElementById('trackingId').textContent;
            const copySuccess = document.getElementById('copySuccess');
            const copyButton = document.getElementById('copyButton');

            navigator.clipboard.writeText(trackingId).then(() => {
                copySuccess.classList.remove('hidden');
                copyButton.innerHTML = `
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ __('Copied!') }}</span>
                `;

                setTimeout(() => {
                    copySuccess.classList.add('hidden');
                }, 3000);

                setTimeout(() => {
                    copyButton.innerHTML = `
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ __('Copy ID') }}</span>
                    `;
                }, 2000);
            }).catch(err => {
                console.error('{{ __("Failed to copy: ") }}', err);
                alert('{{ __("Failed to copy tracking ID. Please copy it manually.") }}');
            });
        }
    </script>
</x-layout.app>
