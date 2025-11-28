<x-layout.app>
    <div class="max-w-4xl mx-auto">
        <!-- Page Header -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-emerald-900">{{ __('File New Grievance') }}</h1>
            <p class="text-emerald-600 mt-2">
                {{ __('Submit your complaint and we\'ll work to resolve it as soon as possible.') }}</p>
        </div>

        <!-- Complaint Form -->
        <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
            <form action="{{ route('complaints.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Department Selection -->
                <div class="mb-6">
                    <label for="department_id" class="block text-sm font-medium text-emerald-700 mb-2">
                        {{ __('Select Department') }} <span class="text-red-500">*</span>
                    </label>
                    <select id="department_id" name="department_id" required
                        class="w-full px-4 py-3 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                        <option value="">{{ __('Choose a department...') }}</option>
                        @foreach ($departments as $department)
                            <option value="{{ $department->id }}"
                                {{ old('department_id') == $department->id ? 'selected' : '' }}>
                                {{ $department->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('department_id')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Subject -->
                <div class="mb-6">
                    <label for="subject" class="block text-sm font-medium text-emerald-700 mb-2">
                        {{ __('Complaint Subject') }} <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="subject" name="subject" value="{{ old('subject') }}" required
                        placeholder="{{ __('Brief description of your complaint') }}"
                        class="w-full px-4 py-3 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    @error('subject')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="mb-6">
                    <label for="description" class="block text-sm font-medium text-emerald-700 mb-2">
                        {{ __('Detailed Description') }} <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="6" required
                        placeholder="{{ __('Please provide detailed information about your complaint including location, time, and any other relevant details...') }}"
                        class="w-full px-4 py-3 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-emerald-600 text-sm mt-2">{{ __('Minimum 10 characters required') }}</p>
                </div>

                <!-- File Attachment -->
                <div class="mb-8">
                    <label class="block text-sm font-medium text-emerald-700 mb-2">
                        {{ __('Attach Supporting Document (Optional)') }}
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
                                    <span class="font-semibold">{{ __('Click to upload') }}</span>
                                    {{ __('or drag and drop') }}
                                </p>
                                <p class="text-xs text-emerald-600">{{ __('JPG, PNG, PDF, DOC, MP4, AVI, MOV, HEIC (Max: 25MB)') }}</p>
                            </div>

                            <!-- Hidden input stays untouched -->
                            <input id="file" name="file" type="file" class="hidden" />
                        </label>
                    </div>

                    @error('file')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <!-- Form Actions -->
                <div class="flex items-center justify-between pt-6 border-t border-emerald-200">
                    <a href="{{ route('dashboard') }}"
                        class="px-6 py-3 border border-emerald-300 text-emerald-700 rounded-lg hover:bg-emerald-50 transition-colors">
                        {{ __('Cancel') }}
                    </a>
                    <button type="submit"
                        class="px-8 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors flex items-center space-x-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        <span>{{ __('Submit Complaint') }}</span>
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
                    <h3 class="font-semibold text-blue-900 mb-2">{{ __('Before you submit:') }}</h3>
                    <ul class="text-blue-700 text-sm space-y-1">
                        <li>{{ __('• Ensure you\'ve selected the correct department for your complaint') }}</li>
                        <li>{{ __('• Provide clear and detailed description for faster resolution') }}</li>
                        <li>{{ __('• Include location details and any relevant information') }}</li>
                        <li>{{ __('• You\'ll receive a tracking ID to check your complaint status') }}</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // File upload preview
        const fileInput = document.getElementById('file');
        const preview = document.getElementById('filePreview');

        fileInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                preview.innerHTML = `
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
