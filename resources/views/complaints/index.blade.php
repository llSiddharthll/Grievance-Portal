<x-layout.app>
    <div class="space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col lg:flex-row justify-between items-start lg:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-emerald-900">{{ __('My Grievances') }}</h1>
                <p class="text-emerald-600 mt-2">{{ __('Track and manage all your submitted complaints') }}</p>
            </div>
            <a href="{{ route('complaints.create') }}"
                class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center space-x-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>{{ __('New Grievance') }}</span>
            </a>
        </div>

        <!-- Stats Overview -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
                <div class="text-2xl font-bold text-emerald-900">{{ $complaints->total() }}</div>
                <div class="text-sm text-emerald-600">{{ __('Total') }}</div>
            </div>
            <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
                <div class="text-2xl font-bold text-orange-600">
                    {{ $complaints->where('status', 'pending')->count() }}
                </div>
                <div class="text-sm text-orange-600">{{ __('Pending') }}</div>
            </div>
            <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
                <div class="text-2xl font-bold text-blue-600">
                    {{ $complaints->where('status', 'in_progress')->count() }}
                </div>
                <div class="text-sm text-blue-600">{{ __('In Progress') }}</div>
            </div>
            <div class="bg-white rounded-xl shadow border border-emerald-100 p-4 text-center">
                <div class="text-2xl font-bold text-green-600">
                    {{ $complaints->where('status', 'resolved')->count() }}
                </div>
                <div class="text-sm text-green-600">{{ __('Resolved') }}</div>
            </div>
        </div>

        <!-- Filters and Search -->
        <div class="bg-white rounded-xl shadow-lg border border-emerald-100 p-6">
            <form method="GET" action="{{ route('complaints.index') }}" class="flex flex-col md:flex-row gap-4">
                <!-- Search -->
                <div class="flex-1">
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="{{ __('Search by tracking ID, subject...') }}"
                            class="w-full pl-10 pr-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500">
                        <svg class="w-5 h-5 text-emerald-400 absolute left-3 top-2.5" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </div>
                </div>

                <!-- Status Filter -->
                <div class="w-full md:w-48">
                    <select name="status"
                        class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                        onchange="this.form.submit()">
                        <option value="all" {{ request('status') == 'all' ? 'selected' : '' }}>{{ __('All Status') }}</option>
                        <option value="pending" {{ request('status') == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                        <option value="in_progress" {{ request('status') == 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                        <option value="resolved" {{ request('status') == 'resolved' ? 'selected' : '' }}>{{ __('Resolved') }}
                        </option>
                        <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}
                        </option>
                    </select>
                </div>

                <!-- Action Buttons -->
                <div class="flex gap-2">
                    <button type="submit"
                        class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center space-x-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>{{ __('Search') }}</span>
                    </button>
                    <a href="{{ route('complaints.index') }}"
                        class="px-4 py-2 border border-emerald-300 text-emerald-700 rounded-lg hover:bg-emerald-50 transition-colors">
                        {{ __('Reset') }}
                    </a>
                </div>
            </form>
        </div>

        <!-- Grievances List -->
        <div class="bg-white rounded-xl shadow-lg border border-emerald-100 overflow-hidden">
            @if ($complaints->count() > 0)
                <div class="overflow-x-auto max-w-full">
                    <table class="w-full whitespace-nowrap">
                        <thead>
                            <tr class="bg-emerald-50 border-b border-emerald-100">
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Tracking ID') }}</th>
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Subject') }}</th>
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Department') }}</th>
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Submitted') }}</th>
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Status') }}</th>
                                <th class="text-left py-4 px-6 text-emerald-700 font-semibold">{{ __('Actions') }}</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($complaints as $complaint)
                                <tr class="border-b border-emerald-50 hover:bg-emerald-50 transition-colors">
                                    <td class="py-4 px-6">
                                        <div class="font-mono font-semibold text-emerald-900">
                                            {{ $complaint->tracking_id }}</div>
                                        <button onclick="copyTrackingId('{{ $complaint->tracking_id }}')"
                                            class="text-xs text-emerald-600 hover:text-emerald-700 flex items-center space-x-1 mt-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span>{{ __('Copy') }}</span>
                                        </button>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="font-medium text-emerald-900">
                                            {{ Str::limit($complaint->subject, 50) }}</div>
                                        <div class="text-sm text-emerald-600 mt-1">
                                            {{ Str::limit($complaint->description, 70) }}</div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span class="bg-blue-100 text-blue-800 text-xs px-2 py-1 rounded">
                                            {{ $complaint->department->name }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6 text-emerald-600 text-sm">
                                        {{ $complaint->created_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }}
                                    </td>
                                    <td class="py-4 px-6">
                                        @php
                                            $statusConfig = [
                                                'pending' => ['color' => 'orange', 'label' => 'Pending'],
                                                'in_progress' => ['color' => 'blue', 'label' => 'In Progress'],
                                                'resolved' => ['color' => 'green', 'label' => 'Resolved'],
                                                'rejected' => ['color' => 'red', 'label' => 'Rejected'],
                                            ];
                                            $config = $statusConfig[$complaint->status] ?? [
                                                'color' => 'gray',
                                                'label' => 'Unknown',
                                            ];
                                        @endphp
                                        <span
                                            class="bg-{{ $config['color'] }}-100 text-{{ $config['color'] }}-800 text-xs px-3 py-1 rounded-full font-medium">
                                            {{ $config['label'] }}
                                        </span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <a href="{{ route('complaints.show', $complaint) }}"
                                            class="px-4 py-2 bg-emerald-600 text-white text-sm rounded-lg hover:bg-emerald-700 transition-colors inline-flex items-center space-x-2">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                </path>
                                            </svg>
                                            <span>{{ __('View Details') }}</span>
                                        </a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-emerald-50 px-6 py-4 border-t border-emerald-100">
                    {{ $complaints->links() }}
                </div>
            @else
                <!-- Empty State -->
                <div class="text-center py-12">
                    <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center mx-auto mb-4">
                        <svg class="w-12 h-12 text-emerald-400" fill="none" stroke="currentColor"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                            </path>
                        </svg>
                    </div>
                    <h3 class="text-lg font-semibold text-emerald-900 mb-2">{{ __('No Grievances Found') }}</h3>
                    <p class="text-emerald-600 mb-6">{{ __("You haven't submitted any grievances yet.") }}</p>
                    <a href="{{ route('complaints.create') }}"
                        class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors inline-flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                            </path>
                        </svg>
                        <span>{{ __('File Your First Grievance') }}</span>
                    </a>
                </div>
            @endif
        </div>

        <!-- Quick Stats -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-emerald-50 rounded-xl border border-emerald-200 p-6">
                <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Need Help?') }}</h3>
                <p class="text-emerald-600 mb-4">{{ __('If you have questions about your grievances or need assistance:') }}</p>
                <div class="space-y-2 text-sm text-emerald-700">
                    <p>{{ __('• Contact support: support@grievanceportal.gov.in') }}</p>
                    <p>{{ __('• Helpline: 1800-123-4567') }}</p>
                    <p>{{ __('• Visit your nearest citizen service center') }}</p>
                </div>
            </div>
            <div class="bg-blue-50 rounded-xl border border-blue-200 p-6">
                <h3 class="text-lg font-semibold text-blue-900 mb-4">{{ __('Status Guide') }}</h3>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 bg-orange-400 rounded-full"></span>
                        <span class="text-blue-700">{{ __('Pending: Waiting for department review') }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 bg-blue-400 rounded-full"></span>
                        <span class="text-blue-700">{{ __('In Progress: Department is working on it') }}</span>
                    </div>
                    <div class="flex items-center space-x-2">
                        <span class="w-3 h-3 bg-green-400 rounded-full"></span>
                        <span class="text-blue-700">{{ __('Resolved: Grievance has been resolved') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        function copyTrackingId(trackingId) {
            navigator.clipboard.writeText(trackingId).then(() => {
                // Show temporary notification
                const notification = document.createElement('div');
                notification.className =
                    'fixed top-4 right-4 bg-green-500 text-white px-4 py-2 rounded-lg shadow-lg z-50';
                notification.textContent = '{{ __('Tracking ID copied!') }}';
                document.body.appendChild(notification);

                setTimeout(() => {
                    document.body.removeChild(notification);
                }, 2000);
            }).catch(err => {
                console.error('{{ __('Failed to copy: ') }}', err);
                alert('{{ __('Failed to copy tracking ID. Please copy it manually.') }}');
            });
        }

        // Auto-submit form when status filter changes
        document.querySelectorAll('select[name="status"]').forEach(select => {
            select.addEventListener('change', function() {
                this.form.submit();
            });
        });
    </script>

    <style>
        /* Custom pagination styles to match emerald theme */
        .pagination {
            display: flex;
            justify-content: center;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .pagination li {
            margin: 0 2px;
        }

        .pagination li a,
        .pagination li span {
            display: block;
            padding: 8px 12px;
            border: 1px solid #d1fae5;
            border-radius: 6px;
            color: #047857;
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .pagination li a:hover {
            background-color: #d1fae5;
            border-color: #10b981;
        }

        .pagination li.active span {
            background-color: #10b981;
            border-color: #10b981;
            color: white;
        }

        .pagination li.disabled span {
            color: #9ca3af;
            border-color: #e5e7eb;
            background-color: #f9fafb;
        }
    </style>
</x-layout.app>
