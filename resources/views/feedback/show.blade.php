<x-layout.app>
    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-emerald-900">{{ __('Feedback Details') }}</h1>
                <p class="text-emerald-600 mt-2">{{ __('Complete information about the submitted feedback') }}</p>
            </div>
            <a href="{{ route('feedback.index') }}"
                class="px-4 py-2 border border-emerald-300 text-emerald-700 rounded-lg hover:bg-emerald-50 transition-colors flex items-center space-x-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>{{ __('Back to List') }}</span>
            </a>
        </div>

        <!-- Feedback Card -->
        <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
            <div class="flex flex-col lg:flex-row items-start lg:items-center justify-between gap-6 mb-6">
                <div>
                    <h2 class="text-2xl font-bold text-emerald-900">{{ __('Feedback for Complaint') }}</h2>
                    <p class="text-emerald-600 mt-1">{{ __('Tracking ID:') }} <span
                            class="font-mono font-semibold">{{ $feedback->complaint->tracking_id }}</span></p>
                </div>
                <div class="flex items-center space-x-4">
                    <div class="text-center">
                        <div class="flex justify-center space-x-1 mb-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <svg class="w-6 h-6 {{ $i <= $feedback->rating ? 'text-yellow-400 fill-current' : 'text-gray-300' }}"
                                    fill="currentColor" viewBox="0 0 20 20">
                                    <path
                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                </svg>
                            @endfor
                        </div>
                        <span class="text-sm text-emerald-600">{{ __('Rating:') }} {{ $feedback->rating }}/5</span>
                    </div>
                    <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full font-medium">
                        {{ ucfirst($feedback->status) }}
                    </span>
                </div>
            </div>

            <!-- Complaint Details -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                <div>
                    <h3 class="text-lg font-semibold text-emerald-900 mb-3">{{ __('Complaint Information') }}</h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-emerald-600">{{ __('Subject:') }}</span>
                            <span
                                class="font-medium text-emerald-900 text-right">{{ $feedback->complaint->subject }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-emerald-600">{{ __('Department:') }}</span>
                            <span class="text-emerald-900">{{ $feedback->complaint->department->name }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-emerald-600">{{ __('Status:') }}</span>
                            <span
                                class="bg-{{ $feedback->complaint->status === 'resolved' ? 'green' : 'blue' }}-100 text-{{ $feedback->complaint->status === 'resolved' ? 'green' : 'blue' }}-800 text-xs px-2 py-1 rounded">
                                {{ ucfirst(str_replace('_', ' ', $feedback->complaint->status)) }}
                            </span>
                        </div>
                    </div>
                </div>

                <div>
                    <h3 class="text-lg font-semibold text-emerald-900 mb-3">
                        @if (auth()->user()->hasRole('officer'))
                            @if ($feedback->user_id === auth()->id())
                                {{ __('Your Feedback') }}
                            @else
                                {{ __('Feedback From User') }}
                            @endif
                        @else
                            {{ __('Your Feedback') }}
                        @endif
                    </h3>
                    <div class="space-y-2">
                        <div class="flex justify-between">
                            <span class="text-emerald-600">{{ __('Submitted By:') }}</span>
                            <span class="text-emerald-900 font-medium">
                                @if (auth()->user()->hasRole('officer') && $feedback->user_id !== auth()->id())
                                    {{ $feedback->user->full_name }}
                                @else
                                    {{ __('You') }}
                                @endif
                            </span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-emerald-600">{{ __('Submitted On:') }}</span>
                            <span
                                class="text-emerald-900">{{ $feedback->created_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }}
                                IST</span>
                        </div>
                        @if ($feedback->officer && auth()->user()->hasRole('officer') && $feedback->user_id !== auth()->id())
                            <div class="flex justify-between">
                                <span class="text-emerald-600">{{ __('Assigned Officer:') }}</span>
                                <span class="text-emerald-900">{{ $feedback->officer->full_name }}</span>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Feedback Comment -->
            <div class="mb-6">
                <h3 class="text-lg font-semibold text-emerald-900 mb-3">{{ __('Feedback Comment') }}</h3>
                <div class="bg-emerald-50 border border-emerald-200 rounded-lg p-4">
                    <p class="text-emerald-700 whitespace-pre-line">{{ $feedback->comment }}</p>
                </div>
            </div>

            <!-- Attached File -->
            @if ($feedback->file_path)
                <div class="mb-6">
                    <h3 class="text-lg font-semibold text-emerald-900 mb-3">{{ __('Attached File') }}</h3>
                    <div class="flex items-center space-x-3 p-3 bg-emerald-50 border border-emerald-200 rounded-lg">
                        <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                        <div class="flex-1">
                            <p class="text-sm font-medium text-emerald-900">{{ __('Supporting Document') }}</p>
                            <p class="text-xs text-emerald-600">{{ pathinfo($feedback->file_path, PATHINFO_BASENAME) }}
                            </p>
                        </div>
                        <a href="{{ asset('storage/' . $feedback->file_path) }}" target="_blank"
                            class="px-3 py-1 bg-emerald-200 text-emerald-800 border-emerald-800 text-sm rounded hover:bg-emerald-300 transition-colors">
                            {{ __('View File') }}
                        </a>
                    </div>
                </div>
            @endif
        </div>

        <!-- Related Complaint Actions -->
        <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
            <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Related Complaint') }}</h3>
            <div class="flex flex-col sm:flex-row gap-4">
                <a href="{{ route(auth()->user()->hasRole('officer') ? 'officer.complaints.show' : 'complaints.show', $feedback->complaint) }}"
                    class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center justify-center space-x-2">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                        </path>
                    </svg>
                    <span>{{ __('View Complaint Details') }}</span>
                </a>

                @if (auth()->user()->hasRole('officer') && $feedback->user_id !== auth()->id())
                    <a href="mailto:{{ $feedback->user->email }}"
                        class="px-4 py-2 border border-blue-300 text-blue-700 rounded-lg hover:bg-blue-50 transition-colors flex items-center justify-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                            </path>
                        </svg>
                        <span>{{ __('Contact User') }}</span>
                    </a>
                @endif
            </div>
        </div>

        <!-- Role-based Actions Section -->
        @if (auth()->user()->hasRole('admin'))
            <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
                <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Admin Actions') }}</h3>
                <form action="{{ route('feedback.updateStatus', $feedback) }}" method="POST" class="space-y-4">
                    @csrf
                    @method('put')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-emerald-700 mb-2">{{ __('Update Status') }}</label>
                            <select name="status"
                                class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                                <option value="submitted" {{ $feedback->status == 'submitted' ? 'selected' : '' }}>
                                    {{ __('Submitted') }}</option>
                                <option value="reviewed" {{ $feedback->status == 'reviewed' ? 'selected' : '' }}>
                                    {{ __('Reviewed') }}</option>
                                <option value="action_required"
                                    {{ $feedback->status == 'action_required' ? 'selected' : '' }}>{{ __('Action Required') }}
                                </option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-emerald-700 mb-2">{{ __('Admin Notes') }}</label>
                            <textarea name="admin_notes" rows="2" placeholder="{{ __('Add notes for this feedback...') }}"
                                class="w-full px-3 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">{{ old('admin_notes', $feedback->admin_notes) }}</textarea>
                        </div>
                    </div>
                    <button type="submit"
                        class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors">
                        {{ __('Update Status') }}
                    </button>
                </form>
            </div>
        @endif

        @if (auth()->user()->hasRole('officer') && $feedback->user_id !== auth()->id() && $feedback->rating <= 2)
            <div class="bg-orange-50 border border-orange-200 rounded-xl p-6">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-orange-600" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-orange-900">{{ __('Low Rating Alert') }}</h3>
                            <p class="text-orange-700 text-sm">{{ __('This feedback indicates dissatisfaction with the complaint resolution.') }}</p>
                        </div>
                    </div>
                    <a href="{{ route('officer.complaints.show', $feedback->complaint) }}"
                        class="px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors">
                        {{ __('Review Complaint') }}
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-layout.app>
