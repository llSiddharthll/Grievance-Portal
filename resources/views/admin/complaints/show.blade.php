<x-layout.app>
    <div class="max-w-6xl mx-auto space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-emerald-900">{{ __('Complaint Management') }}</h1>
<p class="text-emerald-600 mt-2">{{ __('Manage complaint details and assignments') }}</p>
</div>
<a 
href="{{ route('admin.complaints.index') }}" 
class="px-4 py-2 border border-emerald-300 text-emerald-700 rounded-lg hover:bg-emerald-50 transition-colors flex items-center space-x-2"
>
<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
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
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
        </svg>
    </div>
    <div>
        <p class="text-sm text-emerald-600 font-medium">{{ __('Tracking ID') }}</p>
        <p class="text-2xl font-bold text-emerald-900 font-mono" id="trackingId">{{ $complaint->tracking_id }}</p>
    </div>
</div>
<button 
    onclick="copyTrackingId()"
    class="px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center space-x-2 text-sm"
    id="copyButton"
>
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
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
                <p class="text-emerald-600 whitespace-pre-line text-justify">{{ $complaint->description }}</p>
            </div>
            @if($complaint->file_path)
            <div>
                <label class="block text-sm font-medium text-emerald-700 mb-1">{{ __('Attached File') }}</label>
                <div class="flex items-center space-x-3 p-3 bg-emerald-50 rounded-lg">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <div class="flex-1">
                        <p class="text-sm font-medium text-emerald-900">{{ __('Supporting Document') }}</p>
                        <p class="text-xs text-emerald-600">{{ pathinfo($complaint->file_path, PATHINFO_BASENAME) }}</p>
                    </div>
                    <a 
                        href="{{ asset('storage/' . $complaint->file_path) }}" 
                        target="_blank"
                        class="px-3 py-1 bg-emerald-200 text-emerald-800 border-emerald-800 text-sm rounded hover:bg-emerald-300 transition-colors"
                    >
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
                <span class="text-emerald-600 font-medium">{{ __('Email Address') }}</span>
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

<!-- Management Sidebar -->
<div class="space-y-6">
    <!-- Status Management -->
    <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
        <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Status Management') }}</h3>
        <form action="{{ route('admin.complaints.updateStatus', $complaint) }}" method="post">
            @csrf
            <div class="space-y-3">
                <select 
                    name="status" 
                    class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                >
                    <option value="pending" {{ $complaint->status == 'pending' ? 'selected' : '' }}>{{ __('Pending') }}</option>
                    <option value="in_progress" {{ $complaint->status == 'in_progress' ? 'selected' : '' }}>{{ __('In Progress') }}</option>
                    <option value="resolved" {{ $complaint->status == 'resolved' ? 'selected' : '' }}>{{ __('Resolved') }}</option>
                    <option value="rejected" {{ $complaint->status == 'rejected' ? 'selected' : '' }}>{{ __('Rejected') }}</option>
                </select>
                <button 
                    type="submit"
                    class="w-full px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors"
                >
                    {{ __('Update Status') }}
                </button>
            </div>
        </form>
    </div>

    <!-- Assignment Management -->
    <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
        <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Officer Assignment') }}</h3>
        
        @if($complaint->officer)
            <div class="mb-4 p-3 bg-green-50 border border-green-200 rounded-lg">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="font-medium text-green-900">{{ __('Currently Assigned To') }}</p>
                        <p class="text-green-700">{{ $complaint->officer->full_name }}</p>
                        <p class="text-green-600 text-sm">{{ $complaint->officer->email }}</p>
                    </div>
                </div>
            </div>
            
            <form action="{{ route('admin.complaints.unassignOfficer', $complaint) }}" method="POST">
                @csrf
                <button 
                    type="submit"
                    class="w-full px-4 py-2 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition-colors"
                >
                    {{ __('Unassign Officer') }}
                </button>
            </form>
        @else
            <div class="mb-4 p-3 bg-orange-50 border border-orange-200 rounded-lg">
                <p class="text-orange-700 font-medium">{{ __('No officer assigned') }}</p>
                <p class="text-orange-600 text-sm">{{ __('Assign an officer to handle this complaint') }}</p>
            </div>
        @endif

        <!-- Assign Officer Form -->
        <form action="{{ route('admin.complaints.assignOfficer', $complaint) }}" method="POST" class="mt-4">
            @csrf
            <div class="space-y-3">
                <label class="block text-sm font-medium text-emerald-700">{{ __('Assign to Officer') }}</label>
                <select 
                    name="officer_id" 
                    class="w-full px-4 py-2 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500"
                    required
                >
                    <option value="">{{ __('Select Officer') }}</option>
                    @foreach($availableOfficers as $officer)
                        <option value="{{ $officer->id }}">
                            {{ $officer->full_name }}
                        </option>
                    @endforeach
                </select>
                <button 
                    type="submit"
                    class="w-full px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors"
                >
                    {{ __('Assign Officer') }}
                </button>
            </div>
        </form>
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
                <span class="text-emerald-900 text-sm">{{ $complaint->created_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }} IST</span>
            </div>
            <div class="flex justify-between items-center py-2">
                <span class="text-emerald-600 font-medium">{{ __('Last Updated') }}</span>
                <span class="text-emerald-900 text-sm">{{ $complaint->updated_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }} IST</span>
            </div>
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
            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
        </div>
        <div class="flex-1">
            <p class="font-medium text-emerald-900">{{ __('Complaint Registered') }}</p>
            <p class="text-sm text-emerald-600">{{ __('Complaint was successfully submitted by user') }}</p>
            <p class="text-xs text-emerald-500">{{ $complaint->created_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }} IST</p>
        </div>
    </div>

    @if($complaint->officer)
    <div class="flex items-start space-x-3">
        <div class="w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
            </svg>
        </div>
        <div class="flex-1">
            <p class="font-medium text-emerald-900">{{ __('Assigned to Officer') }}</p>
            <p class="text-sm text-emerald-600">{{ __('Complaint assigned to') }} {{ $complaint->officer->full_name }}</p>
            <p class="text-xs text-emerald-500">{{ $complaint->updated_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }} IST</p>
        </div>
    </div>
    @endif

    @if($complaint->status === 'resolved')
    <div class="flex items-start space-x-3">
        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
            <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="flex-1">
            <p class="font-medium text-emerald-900">{{ __('Resolved') }}</p>
            <p class="text-sm text-emerald-600">{{ __('Complaint has been successfully resolved') }}</p>
            <p class="text-xs text-emerald-500">{{ $complaint->updated_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }} IST</p>
        </div>
    </div>
    @endif

    @if($complaint->status === 'rejected')
    <div class="flex items-start space-x-3">
        <div class="w-8 h-8 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
            <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </div>
        <div class="flex-1">
            <p class="font-medium text-emerald-900">{{ __('Rejected') }}</p>
            <p class="text-sm text-emerald-600">{{ __('Complaint has been reviewed and rejected') }}</p>
            <p class="text-xs text-emerald-500">{{ $complaint->updated_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }} IST</p>
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