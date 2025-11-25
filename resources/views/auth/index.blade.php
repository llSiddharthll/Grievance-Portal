<x-layout.auth>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        body {
            font-family: 'Poppins', sans-serif;
        }

        .form-container {
            transition: all 0.3s ease;
        }

        .active-tab {
            background-color: white;
            color: #059669;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1);
        }
    </style>
    <main class="bg-emerald-50 min-h-screen flex items-center justify-center p-4">
        <div class="max-w-3xl w-full">
            <!-- Card Container -->
            <div class="bg-white rounded-2xl shadow-xl overflow-hidden">
                <!-- Header Section -->
                <div class="bg-gradient-to-r from-emerald-500 to-emerald-600 p-6 text-white text-center">
                    <h1 class="text-2xl font-bold" id="form-title">{{ __('Welcome Back') }}</h1>
                    <p class="text-emerald-100 mt-2" id="form-subtitle">{{ __('Sign in to your account') }}</p>
                    
                    <!-- Tab Switcher -->
                    <div class="mt-6 flex rounded-lg bg-emerald-400 p-1 mb-4">
                        <button id="login-tab"
                            class="flex-1 py-2 px-4 rounded-md font-medium active-tab transition duration-200">
                            {{ __('Login') }}
                        </button>
                        <button id="signup-tab"
                            class="flex-1 py-2 px-4 rounded-md font-medium text-white hover:text-emerald-100 transition duration-200">
                            {{ __('Sign Up') }}
                        </button>
                    </div>

                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-700 rounded-lg">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                </div>

                <!-- Login Form -->
                <div id="login-form" class="form-container p-8">
                    <form class="space-y-6" method="post" action="{{ route('login.post') }}">
                        @csrf
                        <!-- Phone Input -->
                        <div>
                            <label for="login-phone" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Phone Number') }}
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-phone text-emerald-500"></i>
                                </div>
                                <input type="tel" id="login-phone" name="phone" pattern="^[6-9]\d{9}$" placeholder="{{ __('Enter 10 digit phone number') }}"
                                    class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200"
                                    required>
                            </div>
                        </div>

                        <!-- Password Input -->
                        <div>
                            <div class="flex items-center justify-between mb-1">
                                <label for="login-password" class="block text-sm font-medium text-gray-700">
                                    {{ __('Password') }}
                                </label>
                                <a href="#" class="text-sm text-emerald-600 hover:text-emerald-500 font-medium">
                                    {{ __('Forgot password?') }}
                                </a>    
                            </div>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-emerald-500"></i>
                                </div>
                                <input type="password" id="login-password" name="password"
                                    placeholder="{{ __('Enter your password') }}"
                                    class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200"
                                    required>
                                <button type="button"
                                    class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password"
                                    data-target="login-password">
                                    <i class="fas fa-eye text-gray-400 hover:text-emerald-500"></i>
                                </button>
                            </div>
                        </div>

                        <!-- Remember Me Checkbox -->
                        <div class="flex items-center">
                            <input id="remember-me" name="remember-me" type="checkbox"
                                class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded">
                            <label for="remember-me" class="ml-2 block text-sm text-gray-700">
                                {{ __('Remember me') }}
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-200">
                            {{ __('Sign in') }}
                        </button>
                    </form>

                    <div>
                        <p class="text-center my-2">Track Complaint ? <a href="{{ route('tracking.form') }}" class="text-emerald-600 hover:text-emerald-700 font-medium">Click here</a></p>
                    </div>

                </div>
                <!-- Signup Form -->
                <div id="signup-form" class="form-container p-8 hidden">
                    <form class="space-y-6" method="post" action="{{ route('register.post') }}">
                        @csrf
                        <div class="flex gap-4 flex-col md:flex-row items-center w-full">
                            <!-- Full Name Input -->
                            <div class="w-full">
                                <label for="full-name" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('Full Name') }}
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-user text-emerald-500"></i>
                                    </div>
                                    <input type="text" id="full-name" name="full_name" placeholder="{{ __('John Doe') }}"
                                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200"
                                        required>
                                </div>
                            </div>

                            <!-- Email Input -->
                            <div class="w-full">
                                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('Email Address') }}
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-envelope text-emerald-500"></i>
                                    </div>
                                    <input type="email" id="email" name="email" placeholder="{{ __('you@example.com') }}"
                                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200"
                                        required>
                                </div>
                            </div>
                        </div>
                        <div class="flex gap-4 items-start flex-col md:flex-row w-full">
                            <!-- Phone Input -->
                            <div class="w-full">
                                <label for="signup-phone" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('Phone Number') }}
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-phone text-emerald-500"></i>
                                    </div>
                                    <input type="tel" id="signup-phone" name="phone" pattern="^[6-9]\d{9}$"
                                        placeholder="{{ __('Enter 10 digit phone number') }}"   
                                        class="block w-full pl-10 pr-3 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200"
                                        required>
                                </div>
                            </div>


                            <!-- Password Input -->
                            <div class="w-full">
                                <label for="signup-password" class="block text-sm font-medium text-gray-700 mb-1">
                                    {{ __('Password') }}
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <i class="fas fa-lock text-emerald-500"></i>
                                    </div>
                                    <input type="password" id="signup-password" name="password"
                                        placeholder="{{ __('Create a strong password') }}"
                                        class="block w-full pl-10 pr-10 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition duration-200"
                                        required>
                                    <button type="button"
                                        class="absolute inset-y-0 right-0 pr-3 flex items-center toggle-password"
                                        data-target="signup-password">
                                        <i class="fas fa-eye text-gray-400 hover:text-emerald-500"></i>
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Terms and Conditions -->
                        <div class="flex items-center">
                            <input id="terms" name="terms" type="checkbox"
                                class="h-4 w-4 text-emerald-600 focus:ring-emerald-500 border-gray-300 rounded"
                                required>
                            <label for="terms" class="ml-2 block text-sm text-gray-700">
                                {{ __('I agree to the') }} <a href="#"
                                    class="text-emerald-600 hover:text-emerald-500 font-medium">{{ __('Terms and Conditions') }}</a>
                            </label>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full flex justify-center py-3 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-emerald-600 hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-emerald-500 transition duration-200">
                            {{ __('Create Account') }}
                        </button>
                    </form>


                </div>
            </div>

            <!-- Footer -->
            <div class="mt-6 text-center text-sm text-gray-500">
                &copy; 2023 {{ __('Grievance Portal') }}. {{ __('All rights reserved.') }}
            </div>
        </div>

        <script>
            // Toggle between login and signup forms
            document.getElementById('login-tab').addEventListener('click', function() {
                showLoginForm();
            });

            document.getElementById('signup-tab').addEventListener('click', function() {
                showSignupForm();
            });

            function showLoginForm() {
                document.getElementById('login-form').classList.remove('hidden');
                document.getElementById('signup-form').classList.add('hidden');
                document.getElementById('login-tab').classList.add('active-tab');
                document.getElementById('login-tab').classList.remove('text-white', 'hover:text-emerald-100');
                document.getElementById('signup-tab').classList.remove('active-tab');
                document.getElementById('signup-tab').classList.add('text-white', 'hover:text-emerald-100');
                document.getElementById('form-title').textContent = '{{ __("Welcome Back") }}';
                document.getElementById('form-subtitle').textContent = '{{ __("Sign in to your account") }}';
            }

            function showSignupForm() {
                document.getElementById('signup-form').classList.remove('hidden');
                document.getElementById('login-form').classList.add('hidden');
                document.getElementById('signup-tab').classList.add('active-tab');
                document.getElementById('signup-tab').classList.remove('text-white', 'hover:text-emerald-100');
                document.getElementById('login-tab').classList.remove('active-tab');
                document.getElementById('login-tab').classList.add('text-white', 'hover:text-emerald-100');
                document.getElementById('form-title').textContent = '{{ __("Create Account") }}';
                document.getElementById('form-subtitle').textContent = '{{ __("Sign up for a new account") }}';
            }

            // Toggle password visibility for all password fields
            document.querySelectorAll('.toggle-password').forEach(button => {
                button.addEventListener('click', function() {
                    const targetId = this.getAttribute('data-target');
                    const passwordInput = document.getElementById(targetId);
                    const icon = this.querySelector('i');

                    if (passwordInput.type === 'password') {
                        passwordInput.type = 'text';
                        icon.classList.remove('fa-eye');
                        icon.classList.add('fa-eye-slash');
                    } else {
                        passwordInput.type = 'password';
                        icon.classList.remove('fa-eye-slash');
                        icon.classList.add('fa-eye');
                    }
                });
            });
        </script>
    </main>
</x-layout.auth>
