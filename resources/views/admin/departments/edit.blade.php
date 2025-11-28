<x-layout.app>
    <div class="max-w-2xl mx-auto space-y-6">
        <!-- Page Header -->
        <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <div>
                <h1 class="text-3xl font-bold text-emerald-900">{{ __('Edit Department') }}</h1>
                <p class="text-emerald-600 mt-2">{{ __('Update department information') }}</p>
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

        <!-- Edit Form -->
        <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
            <form action="{{ route('admin.departments.update', $department) }}" method="POST">
                @csrf
                @method('PUT')
                
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
                            value="{{ old('name', $department->name) }}"
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
                            <span>{{ __('Update Department') }}</span>
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

        <!-- Department Statistics -->
        <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
            <h3 class="text-lg font-semibold text-emerald-900 mb-4">{{ __('Current Statistics') }}</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-emerald-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-emerald-900">{{ $department->complaints_count ?? 0 }}</div>
                    <div class="text-sm text-emerald-600">{{ __('Total Complaints') }}</div>
                </div>
                <div class="bg-blue-50 rounded-lg p-4 text-center">
                    <div class="text-2xl font-bold text-blue-900">{{ $department->officers_count ?? 0 }}</div>
                    <div class="text-sm text-blue-600">{{ __('Assigned Officers') }}</div>
                </div>
            </div>
        </div>
    </div>
</x-layout.app>