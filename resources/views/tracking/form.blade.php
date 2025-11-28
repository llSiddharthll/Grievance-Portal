<x-layout.auth>
    <div class="min-h-screen bg-gradient-to-br from-emerald-50 to-blue-50 py-12 px-4 sm:px-6 lg:px-8">
        <div class="max-w-md mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-3xl font-bold text-emerald-900 mb-4">Track Your Complaint</h1>
                <p class="text-emerald-600">Enter your tracking ID to check the status of your complaint</p>
            </div>

            <!-- Tracking Form -->
            <div class="bg-white rounded-2xl shadow-2xs border border-emerald-100 p-8">
                @if(session('error'))
                    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-red-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-red-700">{{ session('error') }}</span>
                        </div>
                    </div>
                @endif

                @if(session('success'))
                    <div class="mb-6 p-4 bg-green-50 border border-green-200 rounded-lg">
                        <div class="flex items-center">
                            <svg class="w-5 h-5 text-green-500 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span class="text-green-700">{{ session('success') }}</span>
                        </div>
                    </div>
                @endif

                <form action="{{ route('tracking.submit') }}" method="POST">
                    @csrf
                    
                    <div class="mb-6">
                        <label for="tracking_id" class="block text-sm font-medium text-emerald-700 mb-2">
                            Tracking ID
                        </label>
                        <input 
                            type="text" 
                            name="tracking_id" 
                            id="tracking_id"
                            value="{{ old('tracking_id') }}"
                            class="w-full px-4 py-3 border border-emerald-200 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                            placeholder="Enter tracking ID (GRV-20XXXXXX-000X)"
                            required
                        >
                        @error('tracking_id')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <button 
                        type="submit"
                        class="w-full bg-emerald-600 text-white py-3 px-4 rounded-lg hover:bg-emerald-700 focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors font-medium"
                    >
                        Track Complaint
                    </button>
                </form>

                <!-- Help Text -->
                <div class="mt-6 p-4 bg-blue-50 rounded-lg">
                    <div class="flex items-start">
                        <svg class="w-5 h-5 text-blue-500 mr-3 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <div class="text-sm text-blue-700">
                            <p class="font-medium">Can't find your tracking ID?</p>
                            <p class="mt-1">Check your email confirmation or contact our support team for assistance.</p>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Additional Links -->
            <div class="text-center mt-8">
                <a href="{{ route('login') }}" class="text-emerald-600 hover:text-emerald-700 font-medium">
                    ← Back to Home
                </a>
            </div>
        </div>
    </div>
</x-layout.auth>