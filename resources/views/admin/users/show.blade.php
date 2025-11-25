<x-layout.app>
    <div class="max-w-4xl mx-auto space-y-6">
    <!-- Page Header -->
    <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
        <div>
            <h1 class="text-3xl font-bold text-emerald-900">{{ __('User Details') }}</h1>
            <p class="text-emerald-600 mt-2">{{ __('Complete information about the user') }}</p>
        </div>
        <div class="flex space-x-3">
            <a 
                href="{{ route('admin.users.edit', $user) }}" 
                class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center space-x-2"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                </svg>
                <span>{{ __('Edit User') }}</span>
            </a>
            <a 
                href="{{ route('admin.users.index') }}" 
                class="px-4 py-2 border border-emerald-300 text-emerald-700 rounded-lg hover:bg-emerald-50 transition-colors flex items-center space-x-2"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>{{ __('Back to List') }}</span>
            </a>
        </div>
    </div>

    <!-- User Profile Card -->
    <div class="bg-white rounded-xl shadow-lg border border-emerald-100 p-6">
        <div class="flex flex-col lg:flex-row items-start lg:items-center gap-6">
            <!-- Avatar -->
            <div class="w-24 h-24 bg-emerald-100 rounded-full flex items-center justify-center flex-shrink-0">
                <span class="text-2xl font-bold text-emerald-600">
                    {{ substr($user->full_name, 0, 1) }}
                </span>
            </div>
            
            <!-- Basic Info -->
            <div class="flex-1">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">
                    <div>
                        <h2 class="text-2xl font-bold text-emerald-900">{{ $user->full_name }}</h2>
                        <p class="text-emerald-600 mt-1">{{ $user->username }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        @php
                            $role = $user->roles->first();
                            $roleColors = [
                                'admin' => 'orange',
                                'officer' => 'purple', 
                                'citizen' => 'blue'
                            ];
                            $color = $roleColors[$role->name] ?? 'gray';
                        @endphp
                        <span class="bg-{{ $color }}-100 text-{{ $color }}-800 text-sm px-3 py-1 rounded-full font-medium">
                            {{ ucfirst($role->name) }}
                        </span>
                        @if($user->department)
                            <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded-full font-medium">
                                {{ $user->department->name }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- User Information Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Personal Information -->
        <div class="bg-white rounded-xl shadow-lg border border-emerald-100 p-6">
            <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Personal Information') }}</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                    <span class="text-emerald-600 font-medium">{{ __('Full Name') }}</span>
                    <span class="text-emerald-900 font-medium">{{ $user->full_name }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                    <span class="text-emerald-600 font-medium">{{ __('Username') }}</span>
                    <span class="text-emerald-900 font-mono">{{ $user->username }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                    <span class="text-emerald-600 font-medium">{{ __('Email Address') }}</span>
                    <span class="text-emerald-900">{{ $user->email }}</span>
                </div>
                <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                    <span class="text-emerald-600 font-medium">{{ __('Phone Number') }}</span>
                    <span class="text-emerald-900">{{ $user->phone }}</span>
                </div>
                <div class="flex justify-between items-center py-2">
                    <span class="text-emerald-600 font-medium">{{ __('Account Created') }}</span>
                    <span class="text-emerald-900">{{ $user->created_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }} IST</span>
                </div>
            </div>
        </div>

        <!-- Role & Department Information -->
        <div class="bg-white rounded-xl shadow-lg border border-emerald-100 p-6">
            <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Role & Department') }}</h3>
            <div class="space-y-4">
                <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                    <span class="text-emerald-600 font-medium">{{ __('Primary Role') }}</span>
                    <span class="bg-{{ $color }}-100 text-{{ $color }}-800 text-sm px-3 py-1 rounded-full font-medium">
                        {{ ucfirst($role->name) }}
                    </span>
                </div>
                
                @if($user->department)
                <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                    <span class="text-emerald-600 font-medium">{{ __('Assigned Department') }}</span>
                    <span class="bg-green-100 text-green-800 text-sm px-3 py-1 rounded font-medium">
                        {{ $user->department->name }}
                    </span>
                </div>
                @else
                <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                    <span class="text-emerald-600 font-medium">{{ __('Department') }}</span>
                    <span class="text-emerald-500 text-sm">{{ __('Not assigned') }}</span>
                </div>
                @endif

                <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                    <span class="text-emerald-600 font-medium">{{ __('Last Updated') }}</span>
                    <span class="text-emerald-900">{{ $user->updated_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }} IST</span>
                </div>

                <div class="flex justify-between items-center py-2">
                    <span class="text-emerald-600 font-medium">{{ __('User ID') }}</span>
                    <span class="text-emerald-900 font-mono text-sm">{{ $user->id }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Information -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- User Statistics -->
        <div class="bg-white rounded-xl shadow-lg border border-emerald-100 p-6">
            <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('User Statistics') }}</h3>
            <div class="space-y-4">
                @php
                    $userComplaints = $user->complaints ?? collect();
                    $totalComplaints = $userComplaints->count();
                    $pendingComplaints = $userComplaints->where('status', 'pending')->count();
                    $resolvedComplaints = $userComplaints->where('status', 'resolved')->count();
                @endphp
                
                <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                    <span class="text-emerald-600 font-medium">{{ __('Total Complaints') }}</span>
                    <span class="text-emerald-900 font-bold">{{ $totalComplaints }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                    <span class="text-emerald-600 font-medium">{{ __('Pending Complaints') }}</span>
                    <span class="text-orange-600 font-bold">{{ $pendingComplaints }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2 border-b border-emerald-50">
                    <span class="text-emerald-600 font-medium">{{ __('Resolved Complaints') }}</span>
                    <span class="text-green-600 font-bold">{{ $resolvedComplaints }}</span>
                </div>
                
                <div class="flex justify-between items-center py-2">
                    <span class="text-emerald-600 font-medium">{{ __('Resolution Rate') }}</span>
                    <span class="text-emerald-900 font-bold">
                        @if($totalComplaints > 0)
                            {{ round(($resolvedComplaints / $totalComplaints) * 100, 1) }}%
                        @else
                            0%
                        @endif
                    </span>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="bg-white rounded-xl shadow-lg border border-emerald-100 p-6">
            <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Quick Actions') }}</h3>
            <div class="space-y-3">
                <a 
                    href="{{ route('admin.users.edit', $user) }}" 
                    class="w-full flex items-center justify-between p-3 border border-emerald-200 rounded-lg hover:bg-emerald-50 transition-colors group"
                >
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                            </svg>
                        </div>
                        <span class="text-emerald-700 font-medium">{{ __('Edit User Information') }}</span>
                    </div>
                    <svg class="w-4 h-4 text-emerald-400 group-hover:text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>

                @if($user->id !== auth()->id())
                <form 
                    action="{{ route('admin.users.destroy', $user) }}" 
                    method="POST" 
                    onsubmit="return confirm('{{ __('Are you sure you want to delete this user? This action cannot be undone.') }}')"
                >
                    @csrf
                    @method('DELETE')
                    <button 
                        type="submit"
                        class="w-full flex items-center justify-between p-3 border border-red-200 rounded-lg hover:bg-red-50 transition-colors group text-left"
                    >
                        <div class="flex items-center space-x-3">
                            <div class="w-8 h-8 bg-red-100 rounded-lg flex items-center justify-center">
                                <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </div>
                            <span class="text-red-700 font-medium">{{ __('Delete User Account') }}</span>
                        </div>
                        <svg class="w-4 h-4 text-red-400 group-hover:text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </form>
                @else
                <div class="p-3 border border-emerald-200 rounded-lg bg-emerald-50">
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-emerald-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <span class="text-emerald-700 font-medium">{{ __('You cannot delete your own account') }}</span>
                    </div>
                </div>
                @endif

                <a 
                    href="mailto:{{ $user->email }}" 
                    class="w-full flex items-center justify-between p-3 border border-blue-200 rounded-lg hover:bg-blue-50 transition-colors group"
                >
                    <div class="flex items-center space-x-3">
                        <div class="w-8 h-8 bg-blue-100 rounded-lg flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                        <span class="text-blue-700 font-medium">{{ __('Send Email') }}</span>
                    </div>
                    <svg class="w-4 h-4 text-blue-400 group-hover:text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </a>
            </div>
        </div>
    </div>

    <!-- Recent Activity (if applicable) -->
    @if($user->complaints && $user->complaints->count() > 0)
    <div class="bg-white rounded-xl shadow-lg border border-emerald-100 p-6">
        <div class="flex justify-between items-center mb-4">
            <h3 class="text-lg font-semibold text-emerald-900">{{ __('Recent Complaints') }}</h3>
            <span class="text-emerald-600 text-sm">{{ __('Last 5 complaints') }}</span>
        </div>
        <div class="space-y-3">
            @foreach($user->complaints->sortByDesc('created_at')->take(5) as $complaint)
            <div class="flex items-center justify-between p-3 border border-emerald-100 rounded-lg hover:bg-emerald-50 transition-colors">
                <div class="flex-1">
                    <div class="flex items-center space-x-2">
                        <p class="font-medium text-emerald-900 text-sm">{{ Str::limit($complaint->subject, 50) }}</p>
                        <span class="bg-{{ $complaint->status === 'pending' ? 'orange' : ($complaint->status === 'in_progress' ? 'blue' : 'green') }}-100 text-{{ $complaint->status === 'pending' ? 'orange' : ($complaint->status === 'in_progress' ? 'blue' : 'green') }}-800 text-xs px-2 py-1 rounded-full">
                            {{ ucfirst(str_replace('_', ' ', $complaint->status)) }}
                        </span>
                    </div>
                    <div class="text-xs text-emerald-600 mt-1">
                        {{ $complaint->department->name }} • {{ $complaint->created_at->timezone('Asia/Kolkata')->format('M d, Y') }}
                        @if($complaint->tracking_id)
                            • {{ $complaint->tracking_id }}
                        @endif
                    </div>
                </div>
                <a 
                    href="{{ route('admin.complaints.show', $complaint) }}" 
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
    @endif
</div>
</x-layout.app>