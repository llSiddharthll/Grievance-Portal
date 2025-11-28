<x-layout.app>
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-emerald-900">{{ __('Complaint Management') }}</h1>
                <p class="text-emerald-600 mt-2">{{ __('Review and resolve the assigned complaint') }}</p>
            </div>
            <a href="{{ route('officer.complaints.index') }}"
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
                        <p class="text-2xl font-bold text-emerald-900 font-mono">{{ $complaint->tracking_id }}</p>
                    </div>
                </div>
                <div class="flex items-center space-x-3">
                    @php
                        $statusConfig = [
                            'pending' => ['color' => 'orange', 'label' => 'Pending'],
                            'in_progress' => ['color' => 'blue', 'label' => 'In Progress'],
                            'resolved' => ['color' => 'green', 'label' => 'Resolved'],
                        ];
                        $config = $statusConfig[$complaint->status] ?? ['color' => 'gray', 'label' => 'Unknown'];
                    @endphp
                    <span
                        class="bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-800 text-sm px-3 py-1 rounded-full font-medium">
                        {{ $config['label'] }}
                    </span>
                </div>
            </div>
        </div>

        <!-- Main Content Grid -->
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Complaint Details -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Complaint Information -->
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
                        @if ($complaint->file_path)
                            <div>
                                <label class="block text-sm font-medium text-emerald-700 mb-1">{{ __('Attached File') }}</label>
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

                <!-- User Information -->
                <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
                    <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Complainant Information') }}</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                            <span class="text-emerald-600 font-medium">{{ __('Full Name') }}</span>
                            <span class="text-emerald-900 font-medium">{{ $complaint->user->full_name }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                            <span class="text-emerald-600 font-medium">{{ __('Email') }}</span>
                            <span class="text-emerald-900">{{ $complaint->user->email }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                            <span class="text-emerald-600 font-medium">{{ __('Phone') }}</span>
                            <span class="text-emerald-900">{{ $complaint->user->phone }}</span>
                        </div>
                        <div class="flex justify-between items-center py-2">
                            <span class="text-emerald-600 font-medium">{{ __('Username') }}</span>
                            <span class="text-emerald-900 font-mono">{{ $complaint->user->username }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Sidebar -->
            <div class="space-y-6">
                <!-- Status Management -->
                <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
                    <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Update Status') }}</h3>

                    @if ($complaint->status !== 'resolved')
                        <form action="{{ route('officer.complaints.updateStatus', $complaint) }}" method="POST">
                            @csrf
                            @method('put')
                            <div class="space-y-3">
                                <select name="status"
                                    class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                    <option value="in_progress"
                                        {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}
                                    </option>
                                    <option value="resolved">{{ __('Mark as Resolved') }}</option>
                                </select>

                                <button type="submit"
                                    class="w-full px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                                    {{ __('Update Status') }}
                                </button>
                            </div>
                        </form>
                    @else
                        <div class="p-3 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center space-x-2">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-green-700 font-medium">{{ __('Complaint Resolved') }}</span>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Complaint Details -->
                <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
                    <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Complaint Details') }}</h3>
                    <div class="space-y-3">
                        <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                            <span class="text-emerald-600 font-medium">{{ __('Department') }}</span>
                            <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                {{ $complaint->department->name }}
                            </span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                            <span class="text-emerald-600 font-medium">{{ __('Submitted On') }}</span>
                            <span
                                class="text-emerald-900 text-sm">{{ $complaint->created_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }}
                                IST</span>
                        </div>
                        <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                            <span class="text-emerald-600 font-medium">{{ __('Assigned To You') }}</span>
                            <span
                                class="text-emerald-900 text-sm">{{ $complaint->updated_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }}
                                IST</span>
                        </div>
                        @if ($complaint->resolved_at)
                            <div class="flex justify-between items-center py-2">
                                <span class="text-emerald-600 font-medium">{{ __('Resolved On') }}</span>
                                <span
                                    class="text-emerald-900 text-sm">{{ $complaint->resolved_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }}
                                    IST</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
                    <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Quick Actions') }}</h3>
                    <div class="space-y-2">
                        <a href="mailto:{{ $complaint->user->email }}"
                            class="w-full flex items-center justify-between p-3 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors group">
                            <div class="flex items-center space-x-3">
                                <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <span class="text-blue-700 font-medium">{{ __('Email User') }}</span>
                            </div>
                            <svg class="w-4 h-4 text-blue-400 group-hover:text-blue-600" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status Timeline -->
        <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
            <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Status Timeline') }}</h3>
            <div class="space-y-4">
                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                        <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-emerald-900">{{ __('Complaint Registered') }}</p>
                        <p class="text-sm text-emerald-600">{{ __('Complaint was successfully submitted by user') }}</p>
                        <p class="text-xs text-emerald-500">
                            {{ $complaint->created_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }} IST</p>
                    </div>
                </div>

                <div class="flex items-start space-x-3">
                    <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    </div>
                    <div class="flex-1">
                        <p class="font-medium text-emerald-900">{{ __('Assigned to You') }}</p>
                        <p class="text-sm text-emerald-600">{{ __('Complaint was assigned to you for resolution') }}</p>
                        <p class="text-xs text-emerald-500">
                            {{ $complaint->updated_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }} IST</p>
                    </div>
                </div>

                @if ($complaint->status === 'resolved')
                    <div class="mt-6 p-4 bg-blue-50 border border-blue-200 rounded-lg">
                        <div class="flex items-center justify-between">
                            <div>
                                <p class="font-medium text-blue-900">{{ __('Complaint Resolved') }}</p>
                                <p class="text-blue-700 text-sm">{{ __('You can now provide feedback about this case') }}</p>
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
                                    class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                                    {{ __('Provide Feedback') }}
                                </a>
                            @else
                                <span class="px-4 py-2 bg-blue-100 text-blue-800 rounded-lg">{{ __('Feedback Submitted') }}</span>
                            @endif
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</x-layout.app>
