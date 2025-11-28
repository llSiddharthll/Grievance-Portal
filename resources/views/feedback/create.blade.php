<x-layout.app>
    <div class="max-w-2xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-emerald-900">Submit Feedback</h1>
            <p class="text-emerald-600 mt-2">Share your experience and help us improve our services</p>
        </div>

        <!-- Complaint Info -->
        <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-6 mb-6">
            <h3 class="text-lg font-semibold text-emerald-900 mb-3">Complaint Details</h3>
            <div class="space-y-2">
                <div class="flex justify-between">
                    <span class="text-emerald-600">Tracking ID:</span>
                    <span class="font-mono font-semibold text-emerald-900">{{ $complaint->tracking_id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-emerald-600">Subject:</span>
                    <span class="font-medium text-emerald-900">{{ $complaint->subject }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-emerald-600">Department:</span>
                    <span class="text-emerald-900">{{ $complaint->department->name }}</span>
                </div>
                @if (auth()->user()->hasRole('officer'))
                    <div class="flex justify-between">
                        <span class="text-emerald-600">Complainant:</span>
                        <span class="text-emerald-900">{{ $complaint->user->full_name }}</span>
                    </div>
                @endif
            </div>
        </div>

        <!-- Feedback Form -->
        <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
            <form action="{{ route('feedback.store', $complaint) }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Rating -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-emerald-700 mb-4">
                        How would you rate your experience? *
                    </label>
                    <div class="flex justify-center space-x-2 mb-4" id="rating-stars">
                        @for ($i = 1; $i <= 5; $i++)
                            <button type="button" class="rating-star text-3xl focus:outline-none"
                                data-rating="{{ $i }}">
                                <span class="text-gray-300 hover:text-yellow-400">★</span>
                            </button>
                        @endfor
                    </div>
                    <input type="hidden" name="rating" id="rating" value="{{ old('rating', 0) }}" required>
                    <div class="text-center">
                        <span id="rating-text" class="text-sm text-emerald-600">Select a rating</span>
                    </div>
                    @error('rating')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Comment -->
                <div class="mb-6">
                    <label for="comment" class="block text-sm font-medium text-emerald-700 mb-2">
                        Your Feedback *
                    </label>
                    <textarea id="comment" name="comment" rows="6" required
                        placeholder="Please share your detailed feedback about the complaint resolution process..."
                        class="w-full px-4 py-3 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">{{ old('comment') }}</textarea>
                    @error('comment')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-emerald-600 text-sm mt-2">Minimum 10 characters required</p>
                </div>

                <!-- File Attachment -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-emerald-700 mb-2">
                        Attach Supporting Document (Optional)
                    </label>

                    <div class="flex items-center justify-center w-full">
                        <label for="file"
                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-emerald-300 border-dashed rounded-lg cursor-pointer bg-emerald-50 hover:bg-emerald-100 transition-colors relative">
                            <div id="filePreview" class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-emerald-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                    </path>
                                </svg>
                                <p class="mb-2 text-sm text-emerald-700">
                                    <span class="font-semibold">Click to upload</span> or drag and drop
                                </p>
                                <p class="text-xs text-emerald-600">JPG, PNG, PDF, DOC, MP4, AVI, MOV, HEIC (Max: 25MB)</p>
                            </div>

                            <!-- IMPORTANT: File input stays intact -->
                            <input id="file" name="file" type="file" class="hidden" />
                        </label>
                    </div>

                    @error('file')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-emerald-200">
                    <a href="{{ url()->previous() }}"
                        class="px-6 py-3 border border-emerald-300 text-emerald-700 rounded-lg hover:bg-emerald-50 transition-colors">
                        Cancel
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>Submit Feedback</span>
                    </button>
                </div>
            </form>
        </div>

        <!-- Help Information -->
        <div class="mt-8 bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start space-x-3">
                <div class="w-6 h-6 bg-blue-100 rounded-full flex items-center justify-center flex-shrink-0 mt-1">
                    <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <h3 class="font-semibold text-blue-900 mb-2">About Feedback</h3>
                    <ul class="text-blue-700 text-sm space-y-1">
                        <li>• Your feedback helps us improve our services</li>
                        <li>• Be honest and constructive in your comments</li>
                        <li>• Ratings and comments are visible to administrators</li>
                        <li>• You can only submit feedback once per complaint</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Star rating functionality
        const ratingStars = document.querySelectorAll('.rating-star');
        const ratingInput = document.getElementById('rating');
        const ratingText = document.getElementById('rating-text');

        const ratingLabels = {
            1: 'Poor',
            2: 'Fair',
            3: 'Good',
            4: 'Very Good',
            5: 'Excellent'
        };

        ratingStars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                ratingInput.value = rating;

                // Update stars display
                ratingStars.forEach((s, index) => {
                    const starIndex = index + 1;
                    const starSpan = s.querySelector('span');
                    if (starIndex <= rating) {
                        starSpan.className = 'text-yellow-400 fill-current';
                    } else {
                        starSpan.className = 'text-gray-300 hover:text-yellow-400';
                    }
                });

                // Update rating text
                ratingText.textContent = `${ratingLabels[rating]} (${rating}/5)`;
            });

            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                ratingStars.forEach((s, index) => {
                    const starIndex = index + 1;
                    const starSpan = s.querySelector('span');
                    if (starIndex <= rating) {
                        starSpan.className = 'text-yellow-400 fill-current';
                    }
                });
            });

            star.addEventListener('mouseleave', function() {
                const currentRating = parseInt(ratingInput.value);
                ratingStars.forEach((s, index) => {
                    const starIndex = index + 1;
                    const starSpan = s.querySelector('span');
                    if (currentRating === 0) {
                        starSpan.className = 'text-gray-300 hover:text-yellow-400';
                    } else if (starIndex <= currentRating) {
                        starSpan.className = 'text-yellow-400 fill-current';
                    } else {
                        starSpan.className = 'text-gray-300 hover:text-yellow-400';
                    }
                });
            });
        });

        // File upload preview
        // Feedback file upload preview
        const fbFileInput = document.getElementById('file');
        const fbPreview = document.getElementById('filePreview');

        fbFileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                fbPreview.innerHTML = `
            <div class="flex flex-col items-center justify-center p-4">
                <svg class="w-8 h-8 text-emerald-500 mb-2" fill="none" stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                    </path>
                </svg>
                <p class="text-sm font-medium text-emerald-700">${file.name}</p>
                <p class="text-xs text-emerald-600">${(file.size / 1024 / 1024).toFixed(2)} MB</p>
            </div>
        `;
            }
        });
    </script>
</x-layout.app>
