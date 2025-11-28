<x-layout.app>
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-emerald-900">{{ __('Create New Department') }}</h1>
                <p class="text-emerald-600 mt-2">{{ __('Add a new department to organize complaints and officers') }}</p>
            </div>
            <a 
                href="{{ route('admin.departments.index') }}" 
                class="px-4 py-2 border border-emerald-300 text-emerald-700 rounded-lg hover:bg-emerald-50 transition-colors flex items-center space-x-2"
            >
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
                <span>{{ __('Back to List') }}</span>
            </a>
        </div>

        <!-- Create Form -->
        <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
            <form action="{{ route('admin.departments.store') }}" method="POST">
                @csrf
                
                <div class="space-y-6">
                    <!-- Department Name -->
                    <div>
                        <label for="name" class="block text-sm font-medium text-emerald-700 mb-2">
                            {{ __('Department Name') }} <span class="text-red-500">*</span>
                        </label>
                        <input 
                            type="text" 
                            name="name" 
                            id="name"
                            value="{{ old('name') }}"
                            required
                            class="w-full px-4 py-3 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors"
                            placeholder="{{ __('Enter department name...') }}"
                        >
                        @error('name')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Action Buttons -->
                    <div class="flex gap-3 pt-4">
                        <button 
                            type="submit"
                            class="px-6 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition-colors flex items-center space-x-2"
                        >
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            <span>{{ __('Create Department') }}</span>
                        </button>
                        <a 
                            href="{{ route('admin.departments.index') }}" 
                            class="px-6 py-3 border border-emerald-300 text-emerald-700 rounded-lg hover:bg-emerald-50 transition-colors"
                        >
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </div>
            </form>
        </div>

        <!-- Help Text -->
        <div class="bg-blue-50 border border-blue-200 rounded-xl p-6">
            <div class="flex items-start space-x-3">
                <svg class="w-5 h-5 text-blue-600 mt-0.5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div>
                    <h4 class="font-semibold text-blue-900">{{ __('About Departments') }}</h4>
                    <p class="text-blue-700 text-sm mt-1">
                        {{ __('Departments help organize complaints and assign them to relevant officers. Each department can have multiple officers, and complaints are routed based on their nature and department expertise.') }}
                    </p>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>