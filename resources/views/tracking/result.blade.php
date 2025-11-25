<x-layout.auth>
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold text-emerald-900 mb-4">{{ __('Complaint Status') }}</h1>
                <p class="text-emerald-600">{{ __("Here's the current status of your complaint") }}</p>
            </div>

            <!-- Complaint Details Card -->
            <div class="bg-white rounded-2xl shadow-lg border border-emerald-100 overflow-hidden">
                <!-- Status Header -->
                <div class="bg-emerald-600 px-6 py-4">
                    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
                        <div>
                            <h2 class="text-xl font-bold text-white">{{ __('Tracking ID') }}: {{ $complaint->tracking_id }}</h2>
                            <p class="text-emerald-100 mt-1">{{ $complaint->subject }}</p>
                        </div>
                        @php
                            $statusColors = [
                                'pending' => 'bg-orange-500',
                                'in progress' => 'bg-blue-500',
                                'resolved' => 'bg-green-500',
                                'rejected' => 'bg-red-500'
                            ];
                            $statusColor = $statusColors[$complaint->status] ?? 'bg-gray-500';
                        @endphp
                        <span class="{{ $statusColor }} text-white px-4 py-2 rounded-full text-sm font-medium capitalize">
                            {{ $complaint->status }}
                        </span>
                    </div>
                </div>

                <!-- Complaint Details -->
                <div class="p-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Basic Information -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-emerald-900 border-b border-emerald-100 pb-2">
                                {{ __('Complaint Details') }}
                            </h3>
                            
                            <div>
                                <label class="text-sm font-medium text-emerald-600">{{ __('Subject') }}</label>
                                <p class="text-emerald-900 mt-1">{{ $complaint->subject }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-emerald-600">{{ __('Description') }}</label>
                                <p class="text-emerald-900 mt-1">{{ $complaint->description }}</p>
                            </div>

                            <div>
                                <label class="text-sm font-medium text-emerald-600">{{ __('Submitted On') }}</label>
                                <p class="text-emerald-900 mt-1">{{ $complaint->created_at->format('F d, Y \a\t h:i A') }}</p>
                            </div>

                            @if($complaint->resolved_at)
                            <div>
                                <label class="text-sm font-medium text-emerald-600">{{ __('Resolved On') }}</label>
                                <p class="text-emerald-900 mt-1">{{ $complaint->resolved_at->format('F d, Y \a\t h:i A') }}</p>
                            </div>
                            @endif
                        </div>

                        <!-- Assignment & Resolution -->
                        <div class="space-y-4">
                            <h3 class="text-lg font-semibold text-emerald-900 border-b border-emerald-100 pb-2">
                                {{ __('Assignment & Resolution') }}
                            </h3>

                            @if($complaint->department)
                            <div>
                                <label class="text-sm font-medium text-emerald-600">{{ __('Assigned Department') }}</label>
                                <p class="text-emerald-900 mt-1">{{ $complaint->department->name }}</p>
                            </div>
                            @endif

                            @if($complaint->officer)
                            <div>
                                <label class="text-sm font-medium text-emerald-600">{{ __('Assigned Officer') }}</label>
                                <p class="text-emerald-900 mt-1">{{ $complaint->officer->name }}</p>
                            </div>
                            @endif

                            @if($complaint->resolution_notes)
                            <div>
                                <label class="text-sm font-medium text-emerald-600">{{ __('Resolution Notes') }}</label>
                                <p class="text-emerald-900 mt-1 bg-emerald-50 p-3 rounded-lg">{{ $complaint->resolution_notes }}</p>
                            </div>
                            @endif
                        </div>
                    </div>

                    <!-- Status Timeline -->
                    <div class="mt-8">
                        <h3 class="text-lg font-semibold text-emerald-900 border-b border-emerald-100 pb-2 mb-4">
                            {{ __('Status Timeline') }}
                        </h3>
                        
                        <div class="space-y-4">
                            @php
                                $timeline = [
                                    ['status' => 'Submitted', 'date' => $complaint->created_at, 'active' => true],
                                ];

                                if ($complaint->status === 'In Progress' || $complaint->status === 'Resolved') {
                                    $timeline[] = ['status' => 'In Progress', 'date' => $complaint->updated_at, 'active' => true];
                                }

                                if ($complaint->status === 'Resolved') {
                                    $timeline[] = ['status' => 'Resolved', 'date' => $complaint->resolved_at, 'active' => true];
                                }
                            @endphp

                            @foreach($timeline as $item)
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 w-8 h-8 bg-emerald-500 rounded-full flex items-center justify-center">
                                        <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                        </svg>
                                    </div>
                                    <div class="ml-4">
                                        <p class="text-sm font-medium text-emerald-900">{{ $item['status'] }}</p>
                                        <p class="text-sm text-emerald-600">{{ $item['date']->format('F d, Y \a\t h:i A') }}</p>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="mt-8 flex flex-col sm:flex-row gap-4 justify-center">
                <a href="{{ route('tracking.form') }}" class="bg-emerald-600 text-white px-6 py-3 rounded-lg hover:bg-emerald-700 transition-colors text-center font-medium">
                    {{ __('Track Another Complaint') }}
                </a>
                <a href="{{ route('login') }}" class="bg-white text-emerald-600 border border-emerald-200 px-6 py-3 rounded-lg hover:bg-emerald-50 transition-colors text-center font-medium">
                    {{ __('Back to Home') }}
                </a>
            </div>
        </div>
    </div>
</x-layout.auth>