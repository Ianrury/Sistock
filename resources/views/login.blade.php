<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login - Sistem Stok</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div
                class="mx-auto w-16 h-16 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full flex items-center justify-center mb-4 shadow-lg">
                <i class="fas fa-boxes text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Sistem Stok</h1>
            <p class="text-gray-600 mt-2">Masuk ke akun Anda</p>
        </div>

        <!-- Login Form -->
        <div class="bg-white rounded-2xl shadow-xl p-8 backdrop-blur-sm border border-gray-100">
            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- Username Field -->
                <div class="relative">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-blue-500"></i>Username
                    </label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200 @error('username') border-red-500 @enderror"
                        placeholder="Masukkan username Anda" required autofocus>
                    @error('username')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-blue-500"></i>Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200 pr-12 @error('password') border-red-500 @enderror"
                            placeholder="Masukkan password Anda" required>
                        <button type="button"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-colors"
                            onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between">
                    <label class="flex items-center">
                        <input type="checkbox" name="remember"
                            class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500">
                        <span class="ml-2 text-sm text-gray-600">Ingat saya</span>
                    </label>
                    <a href="#" class="text-sm text-blue-600 hover:text-blue-800 transition-colors">
                        Lupa password?
                    </a>
                </div>

                <!-- Submit Button -->
                <button type="submit"
                    class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 text-white py-3 px-4 rounded-lg font-medium hover:from-blue-700 hover:to-indigo-700 focus:ring-4 focus:ring-blue-200 transform hover:scale-105 transition-all duration-200 shadow-lg">
                    <i class="fas fa-sign-in-alt mr-2"></i>Masuk
                </button>

                <!-- Register Link -->
                <div class="text-center pt-4 border-t border-gray-200">
                    <p class="text-gray-600">
                        Belum punya akun?
                        <a href="{{ route('register') }}"
                            class="text-blue-600 hover:text-blue-800 font-medium transition-colors">
                            Daftar sekarang
                        </a>
                    </p>
                </div>
            </form>
        </div>

        <!-- Footer -->
        <div class="text-center mt-8 text-gray-500 text-sm">
            <p>&copy; 2024 Sistem Stok. All rights reserved.</p>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');

            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }

        // Add smooth animations
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.classList.add('animate-fade-in');

            // Add focus animations
            const inputs = document.querySelectorAll('input');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.classList.add('scale-105');
                });

                input.addEventListener('blur', function() {
                    this.parentElement.classList.remove('scale-105');
                });
            });
        });
    </script>

    <style>
        .animate-fade-in {
            animation: fadeIn 0.6s ease-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</body>

</html>
