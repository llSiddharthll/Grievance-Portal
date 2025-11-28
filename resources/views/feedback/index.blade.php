<x-layout.app>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-emerald-900">
                    @auth
                        @if (auth()->user()->hasRole('admin'))
                            {{ __('feedback_management') }}
                        @elseif(auth()->user()->hasRole('officer'))
                            {{ __('feedback_dashboard') }}
                        @else
                            {{ __('My Feedback') }}
                        @endif
                    @endauth
                </h1>
                <p class="text-emerald-600 mt-2">
                    @auth
                        @if (auth()->user()->hasRole('admin'))
                            {{ __('Monitor all feedback from citizens and officers') }}
                        @elseif(auth()->user()->hasRole('officer'))
                            {{ __('Review feedback from citizens and manage your responses') }}
                        @else
                            {{ __('Review your submitted feedback') }}
                        @endif
                    @endauth
                </p>
            </div>
        </div>

        <!-- Role-based Statistics -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @if (auth()->user()->hasRole('admin'))
                <!-- Admin Stats -->
                <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
                    <div class="text-2xl font-bold text-emerald-900">{{ $stats['total_feedback'] }}</div>
                    <div class="text-sm text-emerald-600">{{ __('Total Feedback') }}</div>
                </div>
                <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
                    <div class="text-2xl font-bold text-red-600">{{ $stats['average_rating'] }}/5</div>
                    <div class="text-sm text-red-600">{{ __('Average Rating') }}</div>
                </div>
                <div class="bg-white rounded-xl shadow border border-red-100 p-4 text-center">
                    <div class="text-2xl font-bold text-red-600">{{ $stats['low_ratings'] }}</div>
                    <div class="text-sm text-red-600">{{ __('Low Ratings (≤2)') }}</div>
                </div>
                <div class="bg-white rounded-xl shadow border border-green-100 p-4 text-center">
                    <div class="text-2xl font-bold text-green-600">{{ $stats['high_ratings'] }}</div>
                    <div class="text-sm text-green-600">{{ __('High Ratings (≥4)') }}</div>
                </div>
            @elseif(auth()->user()->hasRole('officer'))
                <!-- Officer Stats -->
                <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
                    <div class="text-2xl font-bold text-emerald-900">{{ $stats['total_received'] }}</div>
                    <div class="text-sm text-emerald-600">{{ __('Feedback Received') }}</div>
                </div>
                <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
                    <div class="text-2xl font-bold text-red-600">
                        {{ $stats['average_rating'] ? $stats['average_rating'] : '0' }}/5
                    </div>
                    <div class="text-sm text-red-600">{{ __('Average Rating') }}</div>
                </div>
                <div class="bg-white rounded-xl shadow border border-red-100 p-4 text-center">
                    <div class="text-2xl font-bold text-red-600">{{ $stats['low_ratings'] }}</div>
                    <div class="text-sm text-red-600">{{ __('Low Ratings') }}</div>
                </div>
                <div class="bg-white rounded-xl shadow border border-blue-100 p-4 text-center">
                    <div class="text-2xl font-bold text-blue-600">{{ $stats['feedback_given'] }}</div>
                    <div class="text-sm text-blue-600">{{ __('Feedback Given') }}</div>
                </div>
            @else
                <!-- Citizen Stats -->
                <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
                    <div class="text-2xl font-bold text-emerald-900">{{ $stats['total_feedback'] }}</div>
                    <div class="text-sm text-emerald-600">{{ __('Total Feedback') }}</div>
                </div>
                @if ($stats['average_rating_given'])
                    <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
                        <div class="text-2xl font-bold text-red-600">{{ $stats['average_rating_given'] }}/5</div>
                        <div class="text-sm text-red-600">{{ __('Average Rating Given') }}</div>
                    </div>
                @endif
            @endif
        </div>

        <!-- Low Ratings Alert for Admin and Officer -->
        @if (
            (auth()->user()->hasRole('admin') || auth()->user()->hasRole('officer')) &&
                $stats['recent_low_ratings']->count() > 0)
            <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.35 16.5c-.77.833.192 2.5 1.732 2.5z">
                            </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="font-semibold text-red-900">{{ __('Attention Required') }}</h3>
                            <p class="text-red-700 text-sm">
                                {{ $stats['recent_low_ratings']->count() }} {{ __('complaint(s) with low ratings need review') }}
                            </p>
                        </div>
                    </div>
                    <a href="#low-ratings"
                        class="px-3 py-1 bg-red-200 text-red-800 border-red-800 text-sm rounded hover:bg-red-300 transition-colors">
                        {{ __('View Details') }}
                    </a>
                </div>
            </div>
        @endif

        <!-- Filters Section -->
        <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
            <form method="GET" action="{{ route('feedback.index') }}"
                class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="md:col-span-2">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="{{ __('Search by tracking ID, subject, or user...') }}"
                            class="w-full pl-10 pr-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <svg class="w-5 h-5 text-emerald-400 absolute left-3 top-2.5" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Status Filter -->
                <div>
                    <select name="status"
                        class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="all">{{ __('All Status') }}</option>
                        <option value="submitted" {{ request('status') == 'submitted' ? 'selected' : '' }}>{{ __('Submitted') }}
                        </option>
                        <option value="reviewed" {{ request('status') == 'reviewed' ? 'selected' : '' }}>{{ __('Reviewed') }}
                        </option>
                        <option value="action_required" {{ request('status') == 'action_required' ? 'selected' : '' }}>
                            {{ __('Action Required') }}</option>
                    </select>
                </div>

                <!-- Rating Filter -->
                <div>
                    <select name="rating"
                        class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <option value="">{{ __('All Ratings') }}</option>
                        <option value="5" {{ request('rating') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5)</option>
                        <option value="4" {{ request('rating') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4)</option>
                        <option value="3" {{ request('rating') == '3' ? 'selected' : '' }}>⭐⭐⭐ (3)</option>
                        <option value="2" {{ request('rating') == '2' ? 'selected' : '' }}>⭐⭐ (2)</option>
                        <option value="1" {{ request('rating') == '1' ? 'selected' : '' }}>⭐ (1)</option>
                    </select>
                </div>

                <!-- Department Filter (Admin & Officer) -->
                @if (auth()->user()->hasRole('admin') || auth()->user()->hasRole('officer'))
                    <div>
                        <select name="department_id"
                            class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">{{ __('All Departments') }}</option>
                            @foreach ($departments as $department)
                                <option value="{{ $department->id }}"
                                    {{ request('department_id') == $department->id ? 'selected' : '' }}>
                                    {{ __($department->name) }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                @endif

                <!-- Feedback Type Filter (Officer only) -->
                @if (auth()->user()->hasRole('officer'))
                    <div>
                        <select name="feedback_type"
                            class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                            <option value="">{{ __('All Feedback') }}</option>
                            <option value="received" {{ request('feedback_type') == 'received' ? 'selected' : '' }}>
                                {{ __('Received from Citizens') }}</option>
                            <option value="given" {{ request('feedback_type') == 'given' ? 'selected' : '' }}>{{ __('Given by Me') }}</option>
                        </select>
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="md:col-span-2 lg:col-span-4 flex gap-2 justify-end">
                    <button type="submit"
                        class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>{{ __('Apply Filters') }}</span>
                    </button>
                    <a href="{{ route('feedback.index') }}"
                        class="px-4 py-2 border border-emerald-300 text-emerald-700 rounded-lg hover:bg-emerald-50 transition-colors">
                        {{ __('Reset') }}
                    </a>
                </div>
            </form>
        </div>

        <!-- Low Ratings Section for Admin and Officer -->
        @if (
            (auth()->user()->hasRole('admin') || auth()->user()->hasRole('officer')) &&
                $stats['recent_low_ratings']->count() > 0)
            <div id="low-ratings" class="bg-red-50 rounded-xl border border-red-200 p-6">
                <h3 class="text-lg font-semibold text-red-900 mb-4">{{ __('Low Ratings Requiring Attention') }}</h3>
                <div class="space-y-3">
                    @foreach ($stats['recent_low_ratings'] as $lowRating)
                        <div class="flex items-center justify-between p-3 bg-white border border-red-200 rounded-lg">
                            <div class="flex-1">
                                <div class="flex items-center space-x-3">
                                    <div class="flex space-x-1">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <svg class="w-4 h-4 {{ $i <= $lowRating->rating ? 'text-red-400 fill-current' : 'text-gray-300' }}"
                                                fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                            </svg>
                                        @endfor
                                    </div>
                                    <div>
                                        <p class="font-medium text-red-900 text-sm">
                                            {{ Str::limit($lowRating->complaint->subject, 50) }}</p>
                                        <p class="text-xs text-red-600">
                                            {{ $lowRating->user->full_name }} •
                                            {{ $lowRating->created_at->timezone('Asia/Kolkata')->format('M d, Y') }}
                                            @if (auth()->user()->hasRole('admin') && $lowRating->officer)
                                                • Officer: {{ $lowRating->officer->full_name }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="flex space-x-2">
                                <a href="{{ route('feedback.show', $lowRating) }}"
                                    class="px-3 py-1 bg-red-200 text-red-800 border-red-800 text-sm rounded hover:bg-red-300 transition-colors">
                                    {{ __('Review') }}
                                </a>
                                @if (auth()->user()->hasRole('officer'))
                                    <a href="{{ route('officer.complaints.show', $lowRating->complaint) }}"
                                        class="px-3 py-1 border border-red-300 text-red-700 text-sm rounded hover:bg-red-50 transition-colors">
                                        {{ __('View Complaint') }}
                                    </a>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        <!-- Feedback Table -->
        <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 overflow-hidden">
            @if ($feedback->count() > 0)
                <div class="overflow-x-auto max-w-full">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-emerald-50 border-b border-emerald-100">
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Complaint') }}</th>
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Rating & Comment') }}</th>
                                @if (auth()->user()->hasRole('admin'))
                                    <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('From User') }}</th>
                                    <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('To Officer') }}</th>
                                @elseif(auth()->user()->hasRole('officer'))
                                    <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('From User') }}</th>
                                    <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Type') }}</th>
                                @else
                                    <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('To Officer') }}</th>

                                @endif
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Status') }}</th>
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Submitted') }}</th>
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($feedback as $item)
                                <tr class="border-b border-emerald-50 hover:bg-emerald-50 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="font-medium text-emerald-900">
                                            {{ Str::limit($item->complaint->subject, 40) }}</div>
                                        <div class="text-sm text-emerald-600 font-mono">
                                            {{ $item->complaint->tracking_id }}</div>
                                        <div class="text-xs text-emerald-500">{{ $item->complaint->department->name }}
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center space-x-1 mb-1">
                                            @for ($i = 1; $i <= 5; $i++)
                                                <svg class="w-4 h-4 {{ $i <= $item->rating ? 'text-yellow-400 fill-current' : 'text-gray-300' }}"
                                                    fill="currentColor" viewBox="0 0 20 20">
                                                    <path
                                                        d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                                </svg>
                                            @endfor
                                            <span class="text-sm text-emerald-600 ml-1">({{ $item->rating }}/5)</span>
                                        </div>
                                        <div class="text-emerald-600 text-sm">{{ Str::limit($item->comment, 60) }}
                                        </div>
                                    </td>

                                    @if (auth()->user()->hasRole('admin'))
                                        <td class="py-4 px-6">
                                            <div class="text-emerald-900 font-medium">{{ $item->user->full_name }}
                                            </div>
                                            <div class="text-sm text-emerald-600">{{ $item->user->email }}</div>
                                        </td>
                                        <td class="py-4 px-6">
                                            @if ($item->officer)
                                                <div class="text-emerald-900 font-medium">
                                                    {{ $item->officer->full_name }}</div>
                                                <div class="text-sm text-emerald-600">{{ $item->officer->email }}
                                                </div>
                                            @else
                                                <span class="text-emerald-500 text-sm">-</span>
                                            @endif
                                        </td>
                                    @elseif(auth()->user()->hasRole('officer'))
                                        <td class="py-4 px-6">
                                            @if ($item->user_id === auth()->id())
                                                <span
                                                    class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">You</span>
                                            @else
                                                <div class="text-emerald-900 font-medium">{{ $item->user->full_name }}
                                                </div>
                                                <div class="text-sm text-emerald-600">{{ $item->user->email }}</div>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6">
                                            @if ($item->user_id === auth()->id())
                                                <span
                                                    class="bg-green-100 text-green-800 text-xs px-2 py-1 rounded">Given</span>
                                            @else
                                                <span
                                                    class="bg-red-100 text-red-800 text-xs px-2 py-1 rounded">Received</span>
                                            @endif
                                        </td>
                                    @else
                                        <td class="py-4 px-6">
                                            @if ($item->officer)
                                                <div class="text-emerald-900 font-medium">
                                                    {{ $item->officer->full_name }}</div>
                                                <div class="text-sm text-emerald-600">{{ $item->officer->email }}
                                                </div>
                                            @else
                                                <span class="text-emerald-500 text-sm">-</span>
                                            @endif
                                        </td>
                                    @endif

                                    <td class="py-4 px-6">
                                        @php
                                            $statusConfig = [
                                                'submitted' => ['color' => 'blue', 'label' => 'Submitted'],
                                                'reviewed' => ['color' => 'green', 'label' => 'Reviewed'],
                                                'action_required' => ['color' => 'red', 'label' => 'Action Required'],
                                            ];
                                            $config = $statusConfig[$item->status] ?? [
                                                'color' => 'gray',
                                                'label' => 'Unknown',
                                            ];
                                        @endphp
                                        <span
                                            class="bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-800 text-xs px-2 py-1 rounded">
                                            {{ __($config['label']) }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-emerald-600 text-sm">
                                        {{ $item->created_at->timezone('Asia/Kolkata')->format('M d, Y') }}
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex space-x-2">
                                            <a href="{{ route('feedback.show', $item) }}"
                                                class="px-3 py-1 bg-emerald-200 text-emerald-800 border-emerald-800 text-sm rounded hover:bg-emerald-300 transition-colors">
                                                <i class="fa-solid fa-eye"></i>
                                            </a>
                                            @if (auth()->user()->hasRole('officer') && $item->user_id !== auth()->id() && $item->rating <= 2)
                                                <a href="{{ route('officer.complaints.show', $item->complaint) }}"
                                                    class="px-3 py-1 border border-red-300 text-red-700 text-sm rounded hover:bg-red-50 transition-colors">
                                                    Address
                                                </a>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-emerald-50 px-6 py-4 border-t border-emerald-100">
                    {{ $feedback->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-emerald-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-emerald-900 mb-2">{{ __('No Feedback Found') }}</h3>
                    <p class="text-emerald-600 mb-6">
                        @auth
                            @if (auth()->user()->hasRole('admin'))
                                {{ __('No feedback matches your search criteria.') }}
                            @elseif(auth()->user()->hasRole('officer'))
                                {{ __("You haven't received or given any feedback yet.") }}
                            @else
                                {{ __("You haven't submitted any feedback yet.") }}
                            @endif
                        @endauth
                    </p>
                </div>
            @endif
        </div>
    </div>
</x-layout.app>
