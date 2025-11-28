<x-layout.app>
    <div class="max-w-2xl mx-auto text-center">
        <!-- Success Icon -->
        <div class="mb-6">
            <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto">
                <svg class="w-10 h-10 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
            </div>
        </div>

        <!-- Success Message -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-emerald-900 mb-4">{{ __('Complaint Registered Successfully!') }}</h1>
            <p class="text-emerald-600 text-lg">
                {{ __("Your grievance has been submitted and is now under review. We'll update you on the progress.") }}
            </p>
        </div>

        <!-- Tracking ID Card -->
        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-6 mb-8">
            <div class="flex flex-col sm:flex-row items-center justify-between space-y-4 sm:space-y-0">
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-12 bg-emerald-100 rounded-lg flex items-center justify-center">
                        <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="text-left">
                        <p class="text-sm text-emerald-600 font-medium">{{ __('Your Tracking ID') }}</p>
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

        <!-- Complaint Details -->
        <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6 mb-8 text-left">
            <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Complaint Details') }}</h3>
            <div class="space-y-3">
                <div class="flex justify-between">
                    <span class="text-emerald-600">{{ __('Subject:') }}</span>
                    <span class="font-medium text-emerald-900 text-right line-clamp-1">{{ $complaint->subject }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-emerald-600">{{ __('Department:') }}</span>
                    <span class="font-medium text-emerald-900">{{ $complaint->department->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-emerald-600">{{ __('Submitted On:') }}</span>
                    <span class="font-medium text-emerald-900">
                        {{ $complaint->created_at->timezone('Asia/Kolkata')->format('M d, Y h:i A') }} IST
                    </span>
                </div>
                <div class="flex justify-between">
                    <span class="text-emerald-600">{{ __('Status:') }}</span>
                    <span class="bg-yellow-100 text-yellow-800 px-2 py-1 rounded text-sm font-medium">{{ __('Pending Review') }}</span>
                </div>
            </div>
        </div>

        <!-- Next Steps -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6 mb-8">
            <h3 class="text-lg font-semibold text-blue-900 mb-3">{{ __('What happens next?') }}</h3>
            <div class="space-y-2 text-blue-700 text-sm text-left">
                <p>{{ __("• Your complaint has been forwarded to the concerned department") }}</p>
                <p>{{ __('• You can track the status using your Tracking ID') }}</p>
                <p>{{ __('• The department will review your complaint within 24-48 hours') }}</p>
                <p>{{ __("• You'll receive updates via email and in your dashboard") }}</p>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a 
                href="{{ route('complaints.create') }}" 
                class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center justify-center space-x-2"
            >
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                </svg>
                <span>{{ __('File Another Complaint') }}</span>
            </a>
            <a 
                href="{{ route('dashboard') }}" 
                class="px-6 py-3 border border-emerald-300 text-emerald-700 rounded-lg hover:bg-emerald-50 transition-colors"
            >
                {{ __('Back to Dashboard') }}
            </a>
        </div>
    </div>

    <script>
        function copyTrackingId() {
            const trackingId = document.getElementById('trackingId').textContent;
            const copySuccess = document.getElementById('copySuccess');
            const copyButton = document.getElementById('copyButton');
            
            // Copy to clipboard
            navigator.clipboard.writeText(trackingId).then(() => {
                // Show success message
                copySuccess.classList.remove('hidden');
                
                // Update button text temporarily
                copyButton.innerHTML = `
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ __('Copied!') }}</span>
                `;
                
                // Hide success message after 3 seconds
                setTimeout(() => {
                    copySuccess.classList.add('hidden');
                }, 3000);
                
                // Reset button text after 2 seconds
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

        // Alternative method for older browsers
        function fallbackCopyTextToClipboard(text) {
            const textArea = document.createElement("textarea");
            textArea.value = text;
            textArea.style.top = "0";
            textArea.style.left = "0";
            textArea.style.position = "fixed";
            document.body.appendChild(textArea);
            textArea.focus();
            textArea.select();
            
            try {
                const successful = document.execCommand('copy');
                document.body.removeChild(textArea);
                return successful;
            } catch (err) {
                document.body.removeChild(textArea);
                return false;
            }
        }
    </script>
</x-layout.app>