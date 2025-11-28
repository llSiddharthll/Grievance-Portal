<x-layout.app>
    <div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-emerald-900">{{ __('Add New User') }}</h1>
        <p class="text-emerald-600 mt-2">{{ __('Create a new user account with appropriate role and permissions') }}</p>
    </div>

    <!-- User Form -->
    <div class="bg-white rounded-xl shadow-2xs border border-emerald-100 p-6">
        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Full Name -->
                <div>
                    <label for="full_name" class="block text-sm font-medium text-emerald-700 mb-2">
                        {{ __('Full Name *') }}
                    </label>
                    <input type="text" id="full_name" name="full_name" value="{{ old('full_name') }}" required
                        class="w-full px-4 py-3 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    @error('full_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium text-emerald-700 mb-2">
                        {{ __('Username *') }}
                    </label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}" required
                        class="w-full px-4 py-3 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    @error('username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-emerald-700 mb-2">
                        {{ __('Email Address *') }}
                    </label>
                    <input type="email" id="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Phone -->
                <div>
                    <label for="phone" class="block text-sm font-medium text-emerald-700 mb-2">
                        {{ __('Phone Number *') }}
                    </label>
                    <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" required
                        class="w-full px-4 py-3 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div>
                    <label for="password" class="block text-sm font-medium text-emerald-700 mb-2">
                        {{ __('Password *') }}
                    </label>
                    <input type="password" id="password" name="password" required
                        class="w-full px-4 py-3 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-emerald-700 mb-2">
                        {{ __('Confirm Password *') }}
                    </label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required
                        class="w-full px-4 py-3 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                </div>

                <!-- Role -->
                <div>
                    <label for="role" class="block text-sm font-medium text-emerald-700 mb-2">
                        {{ __('Role *') }}
                    </label>
                    <select id="role" name="role" required
                        class="w-full px-4 py-3 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                        <option value="">{{ __('Select Role') }}</option>
                        @foreach ($roles as $role)
                            <option value="{{ $role->name }}"
                                {{ old('role') == $role->name ? 'selected' : '' }}>
                                {{ ucfirst($role->name) }}
                            </option>
                        @endforeach
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Department (Only for Officers) -->
                <div id="department-field" style="display: none;">
                    <label for="department_id" class="block text-sm font-medium text-emerald-700 mb-2">
                        {{ __('Assign Department *') }}
                    </label>
                    <select id="department_id" name="department_id"
                        class="w-full px-4 py-3 border border-emerald-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors">
                        <option value="">{{ __('Select Department') }}</option>
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
            </div>

            <!-- Form Actions -->
            <div class="flex items-center justify-between pt-6 mt-6 border-t border-emerald-200">
                <a href="{{ route('admin.users.index') }}"
                    class="px-6 py-3 border border-emerald-300 text-emerald-700 rounded-lg hover:bg-emerald-50 transition-colors">
                    {{ __('Cancel') }}
                </a>
                <button type="submit"
                    class="px-8 py-3 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 focus:ring-2 focus:ring-emerald-500 focus:ring-offset-2 transition-colors flex items-center space-x-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                        </path>
                    </svg>
                    <span>{{ __('Create User') }}</span>
                </button>
            </div>
        </form>
    </div>
</div>

    <script>
        function toggleDepartment() {
            let role = document.querySelector('input[name="role"]:checked')?.value;
            let deptBox = document.getElementById('department-container');

            if (role === 'officer') {
                deptBox.style.display = 'block';
            } else {
                deptBox.style.display = 'none';
            }
        }

        document.querySelectorAll('input[name="role"]').forEach(r => {
            r.addEventListener('change', toggleDepartment);
        });
    </script>


    <script>
        // Show/hide department field based on role selection
        const roleSelect = document.getElementById('role');
        const departmentField = document.getElementById('department-field');
        const departmentSelect = document.getElementById('department_id');

        roleSelect.addEventListener('change', function() {
            if (this.value === 'officer') {
                departmentField.style.display = 'block';
                departmentSelect.required = true;
            } else {
                departmentField.style.display = 'none';
                departmentSelect.required = false;
                departmentSelect.value = '';
            }
        });

        // Trigger change event on page load if there's a value
        if (roleSelect.value === 'officer') {
            departmentField.style.display = 'block';
            departmentSelect.required = true;
        }
    </script>
</x-layout.app>
