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
                    <p class="text-emerald-100 mt-2" id="form-subtitle">{{ __('Sign in as Admin') }}</p>


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
                    <form class="space-y-6" method="post" action="{{ route('admin.login') }}">
                        @csrf
                        <!-- Username Input -->
                        <div>
                            <label for="login-username" class="block text-sm font-medium text-gray-700 mb-1">
                                {{ __('Username') }}
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-emerald-500"></i>
                                </div>
                                <input type="text" id="login-username" name="username" placeholder="{{ __('Enter your username') }}"
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

                </div>

            </div>

            <!-- Footer -->
            <div class="mt-6 text-center text-sm text-gray-500">
                &copy; 2023 {{ __('Grievance Portal') }}. {{ __('All rights reserved.') }}
            </div>
        </div>

        <script>

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
