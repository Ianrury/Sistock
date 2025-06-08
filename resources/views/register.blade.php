<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Register - Sistem Stok</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
</head>

<body class="min-h-screen bg-gradient-to-br from-green-50 via-white to-emerald-50 flex items-center justify-center p-4">
    <div class="w-full max-w-md">
        <!-- Logo/Header -->
        <div class="text-center mb-8">
            <div
                class="mx-auto w-16 h-16 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-full flex items-center justify-center mb-4 shadow-lg">
                <i class="fas fa-user-plus text-white text-2xl"></i>
            </div>
            <h1 class="text-3xl font-bold text-gray-800">Daftar Akun</h1>
            <p class="text-gray-600 mt-2">Register ini untuk membuat akun superadmin</p>
        </div>

        <!-- Register Form -->
        <div class="bg-white rounded-2xl shadow-xl p-2 backdrop-blur-sm border border-gray-100">
            <form method="POST" action="{{ route('register') }}" class="space-y-6">
                @csrf

                <!-- Username Field -->
                <div class="relative">
                    <label for="username" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-user mr-2 text-green-500"></i>Username
                    </label>
                    <input type="text" id="username" name="username" value="{{ old('username') }}"
                        class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-4 focus:ring-green-100 focus:border-blue-500 transition-all duration-200 @error('username') border-red-500 @enderror"
                        placeholder="Pilih username unik" required autofocus minlength="3">
                    <div class="text-xs text-gray-500 mt-1">
                        <i class="fas fa-info-circle mr-1"></i>Minimal 3 karakter, tanpa spasi
                    </div>
                    @error('username')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Password Field -->
                <div class="relative">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-lock mr-2 text-green-500"></i>Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password" name="password"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-4 focus:ring-green-100 focus:border-blue-500 transition-all duration-200 pr-12 @error('password') border-red-500 @enderror"
                            placeholder="Buat password yang kuat" required minlength="6"
                            onkeyup="checkPasswordStrength()">
                        <button type="button"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-colors"
                            onclick="togglePassword('password')">
                            <i class="fas fa-eye" id="toggleIconPassword"></i>
                        </button>
                    </div>

                    <!-- Password Strength Indicator -->
                    <div class="mt-2">
                        <div class="flex space-x-1">
                            <div class="h-2 flex-1 rounded-full bg-gray-200" id="strength1"></div>
                            <div class="h-2 flex-1 rounded-full bg-gray-200" id="strength2"></div>
                            <div class="h-2 flex-1 rounded-full bg-gray-200" id="strength3"></div>
                            <div class="h-2 flex-1 rounded-full bg-gray-200" id="strength4"></div>
                        </div>
                        <p class="text-xs mt-1 text-gray-500" id="strengthText">Minimal 6 karakter</p>
                    </div>

                    @error('password')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Confirm Password Field -->
                <div class="relative">
                    <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-2">
                        <i class="fas fa-shield-alt mr-2 text-green-500"></i>Ulangi Password
                    </label>
                    <div class="relative">
                        <input type="password" id="password_confirmation" name="password_confirmation"
                            class="w-full px-4 py-3 rounded-lg border border-gray-300 focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-200 pr-12 @error('password_confirmation') border-red-500 @enderror"
                            placeholder="Ketik ulang password Anda" required onkeyup="checkPasswordMatch()">
                        <button type="button"
                            class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 hover:text-gray-700 transition-colors"
                            onclick="togglePassword('password_confirmation')">
                            <i class="fas fa-eye" id="toggleIconConfirm"></i>
                        </button>
                    </div>

                    <!-- Password Match Indicator -->
                    <div class="mt-1" id="matchIndicator" style="display: none;">
                        <p class="text-xs flex items-center" id="matchText">
                            <i class="fas fa-check-circle mr-1"></i>Password cocok
                        </p>
                    </div>

                    @error('password_confirmation')
                        <p class="text-red-500 text-sm mt-1 flex items-center">
                            <i class="fas fa-exclamation-circle mr-1"></i>{{ $message }}
                        </p>
                    @enderror
                </div>

                <!-- Terms and Conditions -->
                <div class="flex items-start">
                    <input type="checkbox" id="terms" name="terms"
                        class="mt-1 rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500" required>
                    <label for="terms" class="ml-2 text-sm text-gray-600">
                        Silahkan Centang jika sudah yakin
                    </label>
                </div>

                <!-- Submit Button -->
                <button type="submit" id="submitBtn"
                    class="w-full bg-gradient-to-r from-green-600 to-emerald-600 text-white py-3 px-4 rounded-lg font-medium hover:from-green-700 hover:to-emerald-700 focus:ring-4 focus:ring-green-200 transform hover:scale-105 transition-all duration-200 shadow-lg disabled:opacity-50 disabled:cursor-not-allowed"
                    disabled>
                    <i class="fas fa-user-check mr-2"></i>Daftar Sekarang
                </button>

                <!-- Login Link -->
                <div class="text-center pt-4 border-t border-gray-200">
                    <p class="text-gray-600">
                        Sudah punya akun?
                        <a href="{{ route('login') }}"
                            class="text-green-600 hover:text-green-800 font-medium transition-colors">
                            Masuk di sini
                        </a>
                    </p>
                </div>
            </form>
        </div>

    </div>

    <script>
        function togglePassword(fieldId) {
            const passwordInput = document.getElementById(fieldId);
            const toggleIcon = document.getElementById(fieldId === 'password' ? 'toggleIconPassword' : 'toggleIconConfirm');

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

        function checkPasswordStrength() {
            const password = document.getElementById('password').value;
            const strengthBars = ['strength1', 'strength2', 'strength3', 'strength4'];
            const strengthText = document.getElementById('strengthText');

            // Reset bars
            strengthBars.forEach(bar => {
                document.getElementById(bar).className = 'h-2 flex-1 rounded-full bg-gray-200';
            });

            let strength = 0;
            let text = 'Lemah';
            let color = 'bg-red-400';

            if (password.length >= 6) strength++;
            if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength++;
            if (password.match(/[0-9]/)) strength++;
            if (password.match(/[^a-zA-Z0-9]/)) strength++;

            if (strength >= 1) {
                document.getElementById('strength1').className = 'h-2 flex-1 rounded-full ' + color;
            }
            if (strength >= 2) {
                color = 'bg-yellow-400';
                text = 'Sedang';
                document.getElementById('strength2').className = 'h-2 flex-1 rounded-full ' + color;
            }
            if (strength >= 3) {
                color = 'bg-blue-400';
                text = 'Baik';
                document.getElementById('strength3').className = 'h-2 flex-1 rounded-full ' + color;
            }
            if (strength >= 4) {
                color = 'bg-green-400';
                text = 'Sangat Kuat';
                document.getElementById('strength4').className = 'h-2 flex-1 rounded-full ' + color;
            }

            strengthText.textContent = text;
            strengthText.className = 'text-xs mt-1 font-medium';

            if (strength >= 2) {
                strengthText.className += ' text-green-600';
            } else if (strength >= 1) {
                strengthText.className += ' text-yellow-600';
            } else {
                strengthText.className += ' text-red-600';
            }

            checkFormValidity();
        }

        function checkPasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const matchIndicator = document.getElementById('matchIndicator');
            const matchText = document.getElementById('matchText');

            if (confirmPassword.length > 0) {
                matchIndicator.style.display = 'block';

                if (password === confirmPassword) {
                    matchText.innerHTML = '<i class="fas fa-check-circle mr-1"></i>Password cocok';
                    matchText.className = 'text-xs flex items-center text-green-600';
                } else {
                    matchText.innerHTML = '<i class="fas fa-times-circle mr-1"></i>Password tidak cocok';
                    matchText.className = 'text-xs flex items-center text-red-600';
                }
            } else {
                matchIndicator.style.display = 'none';
            }

            checkFormValidity();
        }

        function checkFormValidity() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password_confirmation').value;
            const terms = document.getElementById('terms').checked;
            const submitBtn = document.getElementById('submitBtn');

            const isValid = username.length >= 3 &&
                password.length >= 6 &&
                password === confirmPassword &&
                terms;

            submitBtn.disabled = !isValid;
        }

        // Add event listeners
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.querySelector('form');
            form.classList.add('animate-fade-in');

            // Add event listeners for form validation
            document.getElementById('username').addEventListener('input', checkFormValidity);
            document.getElementById('terms').addEventListener('change', checkFormValidity);

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
