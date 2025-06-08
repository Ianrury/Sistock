@extends('layouts.admin')

@section('title', 'Profile - Admin Panel')
@section('page-title', 'My Profile')

@section('content')
    @include('sweetalert::alert')

    <div class="max-w-4xl mx-auto space-y-6">
        <!-- Profile Header Card -->
        <div class="bg-gradient-to-r from-blue-500 to-purple-600 rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-8 text-white">
                <div class="flex items-center space-x-4">
                    <div class="relative">
                        <div
                            class="w-20 h-20 bg-white/20 rounded-full border-4 border-white shadow-lg flex items-center justify-center">
                            <i class="fas fa-user text-3xl text-white"></i>
                        </div>
                        <div class="absolute -bottom-1 -right-1 bg-green-400 w-6 h-6 rounded-full border-2 border-white">
                        </div>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold">Super Admin</h1>
                        <p class="text-blue-100"> {{ Auth::guard('superadmin')->user()->username ?? 'admin' }}</p>
                        </p>
                        <div class="flex items-center mt-2 text-sm text-blue-100">
                            <i class="fas fa-shield-alt mr-2"></i>
                            <span>Status: Aktif</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Edit Profile Form -->
            <div class="lg:col-span-2 space-y-6">
                <!-- Username Form -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-user-edit mr-3 text-blue-500"></i>
                            Edit Username
                        </h2>
                    </div>

                    <form id="username-form" class="p-6 space-y-6">
                        @csrf
                        <!-- Username Field -->
                        <div class="space-y-2">
                            <label for="username" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-user mr-2 text-gray-400"></i>Username
                            </label>
                            <div class="relative">
                                <input type="text" id="username" name="username"
                                    value="{{ Auth::guard('superadmin')->user()->username }}"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200 pl-10">
                                <i class="fas fa-user absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                            </div>
                            <p class="text-xs text-gray-500">Username yang digunakan untuk login</p>
                        </div>

                        <!-- Save Username Button -->
                        <div class="flex justify-end">
                            <button type="submit"
                                class="bg-gradient-to-r from-blue-500 to-blue-600 text-white px-6 py-3 rounded-lg font-medium hover:from-blue-600 hover:to-blue-700 focus:ring-4 focus:ring-blue-300 transition-all duration-200 flex items-center space-x-2">
                                <i class="fas fa-save"></i>
                                <span>Update Username</span>
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Password Form -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h2 class="text-xl font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-lock mr-3 text-red-500"></i>
                            Ganti Password
                        </h2>
                    </div>

                    <form id="password-form" class="p-6 space-y-6">
                        @csrf
                        <!-- Current Password -->
                        <div class="space-y-2">
                            <label for="current_password" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-key mr-2 text-gray-400"></i>Password Lama
                            </label>
                            <div class="relative">
                                <input type="password" id="current_password" name="current_password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200 pl-10 pr-12">
                                <i class="fas fa-key absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <button type="button"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                    onclick="togglePassword('current_password')">
                                    <i class="fas fa-eye" id="current_password_eye"></i>
                                </button>
                            </div>
                            <p class="text-xs text-gray-500">Masukkan password lama untuk konfirmasi</p>
                        </div>

                        <!-- New Password -->
                        <div class="space-y-2">
                            <label for="new_password" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-lock mr-2 text-gray-400"></i>Password Baru
                            </label>
                            <div class="relative">
                                <input type="password" id="new_password" name="new_password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200 pl-10 pr-12">
                                <i class="fas fa-lock absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <button type="button"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                    onclick="togglePassword('new_password')">
                                    <i class="fas fa-eye" id="new_password_eye"></i>
                                </button>
                            </div>
                            <!-- Password Strength Indicator -->
                            <div class="mt-2">
                                <div class="flex space-x-1 mb-2">
                                    <div class="h-2 bg-gray-200 rounded flex-1" id="strength-1"></div>
                                    <div class="h-2 bg-gray-200 rounded flex-1" id="strength-2"></div>
                                    <div class="h-2 bg-gray-200 rounded flex-1" id="strength-3"></div>
                                    <div class="h-2 bg-gray-200 rounded flex-1" id="strength-4"></div>
                                </div>
                                <p class="text-xs text-gray-500" id="strength-text">Minimal 8 karakter dengan kombinasi
                                    huruf dan angka</p>
                            </div>
                        </div>

                        <!-- Confirm New Password -->
                        <div class="space-y-2">
                            <label for="confirm_password" class="block text-sm font-medium text-gray-700">
                                <i class="fas fa-check-circle mr-2 text-gray-400"></i>Konfirmasi Password Baru
                            </label>
                            <div class="relative">
                                <input type="password" id="confirm_password" name="confirm_password"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500 transition-colors duration-200 pl-10 pr-12">
                                <i
                                    class="fas fa-check-circle absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                                <button type="button"
                                    class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-gray-600"
                                    onclick="togglePassword('confirm_password')">
                                    <i class="fas fa-eye" id="confirm_password_eye"></i>
                                </button>
                            </div>
                            <p class="text-xs" id="password-match-text"></p>
                        </div>

                        <!-- Save Password Button -->
                        <div class="flex justify-end">
                            <button type="submit" id="password-submit-btn" disabled
                                class="bg-gradient-to-r from-red-500 to-red-600 text-white px-6 py-3 rounded-lg font-medium hover:from-red-600 hover:to-red-700 focus:ring-4 focus:ring-red-300 transition-all duration-200 flex items-center space-x-2 disabled:opacity-50 disabled:cursor-not-allowed">
                                <i class="fas fa-shield-alt"></i>
                                <span>Update Password</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Security Info -->
            <div class="space-y-6">
                <!-- Security Tips -->
                <div class="bg-white rounded-xl shadow-lg border border-gray-200">
                    <div class="px-6 py-4 border-b border-gray-200">
                        <h3 class="text-lg font-semibold text-gray-800 flex items-center">
                            <i class="fas fa-shield-alt mr-3 text-green-500"></i>
                            Tips Keamanan
                        </h3>
                    </div>

                    <div class="p-6 space-y-4">
                        <div class="flex items-start space-x-3 p-3 bg-green-50 rounded-lg">
                            <i class="fas fa-check-circle text-green-500 mt-1"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Password Kuat</p>
                                <p class="text-xs text-gray-600">Gunakan minimal 8 karakter dengan kombinasi huruf besar,
                                    kecil, angka, dan simbol</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3 p-3 bg-blue-50 rounded-lg">
                            <i class="fas fa-clock text-blue-500 mt-1"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Update Berkala</p>
                                <p class="text-xs text-gray-600">Ganti password secara berkala untuk keamanan maksimal</p>
                            </div>
                        </div>

                        <div class="flex items-start space-x-3 p-3 bg-yellow-50 rounded-lg">
                            <i class="fas fa-exclamation-triangle text-yellow-500 mt-1"></i>
                            <div>
                                <p class="text-sm font-medium text-gray-800">Jangan Bagikan</p>
                                <p class="text-xs text-gray-600">Jangan pernah memberikan password kepada orang lain</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Loading Overlay -->
    <div id="loading-overlay" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 hidden">
        <div class="bg-white rounded-lg p-6 flex items-center space-x-4">
            <div class="animate-spin rounded-full h-8 w-8 border-b-2 border-blue-500"></div>
            <span class="text-gray-700">Menyimpan perubahan...</span>
        </div>
    </div>

    <!-- Success Toast -->
    <div id="success-toast"
        class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 z-50">
        <div class="flex items-center space-x-2">
            <i class="fas fa-check-circle"></i>
            <span id="success-message">Berhasil diperbarui!</span>
        </div>
    </div>

    <!-- Error Toast -->
    <div id="error-toast"
        class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg transform translate-x-full transition-transform duration-300 z-50">
        <div class="flex items-center space-x-2">
            <i class="fas fa-exclamation-circle"></i>
            <span id="error-message">Terjadi kesalahan!</span>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const usernameForm = document.getElementById('username-form');
            const passwordForm = document.getElementById('password-form');
            const loadingOverlay = document.getElementById('loading-overlay');
            const successToast = document.getElementById('success-toast');
            const errorToast = document.getElementById('error-toast');

            // Password strength checker
            const newPasswordInput = document.getElementById('new_password');
            const confirmPasswordInput = document.getElementById('confirm_password');
            const passwordSubmitBtn = document.getElementById('password-submit-btn');

            newPasswordInput.addEventListener('input', function() {
                checkPasswordStrength(this.value);
                checkPasswordMatch();
            });

            confirmPasswordInput.addEventListener('input', function() {
                checkPasswordMatch();
            });

            function checkPasswordStrength(password) {
                const strengthBars = ['strength-1', 'strength-2', 'strength-3', 'strength-4'];
                const strengthText = document.getElementById('strength-text');

                // Reset bars
                strengthBars.forEach(bar => {
                    document.getElementById(bar).className = 'h-2 bg-gray-200 rounded flex-1';
                });

                if (password.length === 0) {
                    strengthText.textContent = 'Minimal 8 karakter dengan kombinasi huruf dan angka';
                    strengthText.className = 'text-xs text-gray-500';
                    return 0;
                }

                let strength = 0;
                const checks = [
                    password.length >= 8,
                    /[a-z]/.test(password),
                    /[A-Z]/.test(password),
                    /[0-9]/.test(password)
                ];

                checks.forEach((check, index) => {
                    if (check) {
                        strength++;
                        document.getElementById(strengthBars[index]).className =
                            `h-2 rounded flex-1 ${strength <= 2 ? 'bg-red-400' : strength === 3 ? 'bg-yellow-400' : 'bg-green-400'}`;
                    }
                });

                const messages = [
                    'Password terlalu lemah',
                    'Password lemah',
                    'Password sedang',
                    'Password kuat'
                ];

                strengthText.textContent = messages[Math.max(0, strength - 1)];
                strengthText.className =
                    `text-xs ${strength <= 2 ? 'text-red-500' : strength === 3 ? 'text-yellow-500' : 'text-green-500'}`;

                return strength;
            }

            function checkPasswordMatch() {
                const newPassword = newPasswordInput.value;
                const confirmPassword = confirmPasswordInput.value;
                const matchText = document.getElementById('password-match-text');

                if (confirmPassword.length === 0) {
                    matchText.textContent = '';
                    passwordSubmitBtn.disabled = true;
                    return;
                }

                const isMatch = newPassword === confirmPassword;
                const isStrong = checkPasswordStrength(newPassword) >= 3;

                matchText.textContent = isMatch ? 'Password cocok' : 'Password tidak cocok';
                matchText.className = `text-xs ${isMatch ? 'text-green-500' : 'text-red-500'}`;

                passwordSubmitBtn.disabled = !(isMatch && isStrong);
            }

            // Username form submission
            usernameForm.addEventListener('submit', function(e) {
                e.preventDefault();
                showLoading();

                const formData = new FormData();
                formData.append('_token', document.querySelector('input[name="_token"]').value);
                formData.append('username', document.getElementById('username').value);

                // Simulate API call
                setTimeout(() => {
                    hideLoading();
                    showToast('success', 'Username berhasil diperbarui!');
                }, 1500);

                // Uncomment for actual implementation

                fetch('/edit/username', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        hideLoading();
                        if (data.success) {
                            showToast('success', 'Username berhasil diperbarui!');
                        } else {
                            showToast('error', data.message || 'Gagal memperbarui username');
                        }
                    })
                    .catch(error => {
                        hideLoading();
                        showToast('error', 'Terjadi kesalahan sistem');
                    });

            });

            // Password form submission
            passwordForm.addEventListener('submit', function(e) {
                e.preventDefault();
                showLoading();

                const formData = new FormData();
                formData.append('_token', document.querySelector('input[name="_token"]').value);
                formData.append('current_password', document.getElementById('current_password').value);
                formData.append('new_password', document.getElementById('new_password').value);
                formData.append('confirm_password', document.getElementById('confirm_password').value);

        
                fetch('/edit/password', {
                        method: 'POST',
                        body: formData,
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                        }
                    })
                    .then(response => {
                        // Cek apakah response OK atau tidak
                        if (!response.ok) {
                            return response.json().then(data => {
                                throw new Error(data.message || 'Network response was not ok');
                            });
                        }
                        return response.json();
                    })
                    .then(data => {
                        hideLoading();
                        if (data.success) {
                            showToast('success', data.message || 'Password berhasil diperbarui!');
                            passwordForm.reset();
                            checkPasswordMatch();
                        } else {
                            showToast('error', data.message || 'Gagal memperbarui password');
                        }
                    })
                    .catch(error => {
                        hideLoading();
                        showToast('error', error.message || 'Terjadi kesalahan sistem');
                        console.error('Error:', error);
                    });
            });

            function showLoading() {
                loadingOverlay.classList.remove('hidden');
            }

            function hideLoading() {
                loadingOverlay.classList.add('hidden');
            }

            function showToast(type, message) {
                const toast = type === 'success' ? successToast : errorToast;
                const messageEl = document.getElementById(type + '-message');
                messageEl.textContent = message;

                toast.classList.remove('translate-x-full');
                setTimeout(() => {
                    toast.classList.add('translate-x-full');
                }, 3000);
            }
        });

        // Toggle password visibility
        function togglePassword(fieldId) {
            const field = document.getElementById(fieldId);
            const eye = document.getElementById(fieldId + '_eye');

            if (field.type === 'password') {
                field.type = 'text';
                eye.className = 'fas fa-eye-slash';
            } else {
                field.type = 'password';
                eye.className = 'fas fa-eye';
            }
        }
    </script>
@endsection
