@extends('layouts.admin')

@section('title', 'Manajement tambah - Admin Panel')
@section('page-title', 'Manajement tambah')

@section('content')
    @include('sweetalert::alert')
    <div class="min-h-screen  py-8">
        <div class="container mx-auto px-4 max-w-4xl">
            <!-- Header Section -->
            <div class="mb-8">
                <div class="flex items-center mb-4">
                    <a href="{{ route('akun') }}"
                        class="inline-flex items-center text-gray-600 hover:text-gray-800 transition-colors duration-200">
                        <i class="fas fa-arrow-left text-lg mr-2"></i>
                        <span class="text-sm font-medium">Kembali ke Data Akun</span>
                    </a>
                </div>
                <div class="text-center">
                    <div
                        class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-blue-500 to-indigo-600 rounded-full mb-4 shadow-lg">
                        <i class="fas fa-user-plus text-white text-2xl"></i>
                    </div>
                    <h1 class="text-3xl font-bold text-gray-900 mb-2">Tambah Akun Baru</h1>
                    <p class="text-gray-600 max-w-md mx-auto">Buat akun admin baru untuk mengelola sistem</p>
                </div>
            </div>

            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-8 py-6">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <i class="fas fa-user-cog mr-3"></i>
                        Informasi Akun Admin
                    </h2>
                </div>

                <!-- Form Body -->
                <div class="p-8">
                    <form id="createAccountForm" action="{{ route('akun.store') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Username Field -->
                        <div class="group">
                            <label for="username" class="block text-sm font-semibold text-gray-700 mb-2">
                                Username
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-user text-gray-400"></i>
                                </div>
                                <input type="text" id="username" name="username" value="{{ old('username') }}"
                                    class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 focus:bg-white @error('username') border-red-500 @enderror"
                                    placeholder="Masukkan username admin">
                            </div>
                            @error('username')
                                <div class="flex items-center mt-2 text-red-600">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    <span class="text-sm">{{ $message }}</span>
                                </div>
                            @enderror
                            <p class="mt-2 text-sm text-gray-500 flex items-center">
                                <i class="fas fa-info-circle mr-2"></i>
                                Username harus unik dan mudah diingat
                            </p>
                        </div>

                        <div class="group">
                            <label for="puskesmas" class="block text-sm font-semibold text-gray-700 mb-2">
                                Puskesmas
                                <span class="text-red-500 ml-1">*</span>
                            </label>

                            <select id="puskesmas" name="puskesmas_id"
                                class="w-full border border-gray-300 rounded-md shadow-sm focus:border-indigo-500 focus:ring-indigo-500"
                                required>
                                <option value="">-- Pilih Puskesmas --</option>
                                @foreach ($puskesmas as $item)
                                    <option value="{{ $item->id }}"
                                        {{ old('puskesmas_id') == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>

                            @error('puskesmas_id')
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        <!-- Password Field -->
                        <div class="group">
                            <label for="password" class="block text-sm font-semibold text-gray-700 mb-2">
                                Password
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" id="password" name="password"
                                    class="block w-full pl-12 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 focus:bg-white @error('password') border-red-500 @enderror"
                                    placeholder="Masukkan password">
                                <button type="button" id="togglePassword"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600 transition-colors"></i>
                                </button>
                            </div>
                            @error('password')
                                <div class="flex items-center mt-2 text-red-600">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    <span class="text-sm">{{ $message }}</span>
                                </div>
                            @enderror

                            <!-- Password Strength Indicator -->
                            <div class="mt-3">
                                <div class="flex items-center justify-between mb-2">
                                    <span class="text-sm text-gray-600">Kekuatan Password:</span>
                                    <span id="passwordStrengthText" class="text-sm font-medium text-gray-500">Lemah</span>
                                </div>
                                <div class="w-full bg-gray-200 rounded-full h-2">
                                    <div id="passwordStrengthBar"
                                        class="bg-red-500 h-2 rounded-full transition-all duration-300" style="width: 0%">
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 text-sm text-gray-500">
                                <p class="flex items-center mb-1">
                                    <i class="fas fa-check-circle mr-2 text-gray-400" id="lengthCheck"></i>
                                    Minimal 8 karakter
                                </p>
                                <p class="flex items-center mb-1">
                                    <i class="fas fa-check-circle mr-2 text-gray-400" id="upperCheck"></i>
                                    Mengandung huruf besar
                                </p>
                                <p class="flex items-center mb-1">
                                    <i class="fas fa-check-circle mr-2 text-gray-400" id="lowerCheck"></i>
                                    Mengandung huruf kecil
                                </p>
                                <p class="flex items-center">
                                    <i class="fas fa-check-circle mr-2 text-gray-400" id="numberCheck"></i>
                                    Mengandung angka
                                </p>
                            </div>
                        </div>

                        <!-- Confirm Password Field -->
                        <div class="group">
                            <label for="password_confirmation" class="block text-sm font-semibold text-gray-700 mb-2">
                                Konfirmasi Password
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-lock text-gray-400"></i>
                                </div>
                                <input type="password" id="password_confirmation" name="password_confirmation"
                                    class="block w-full pl-12 pr-12 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 focus:bg-white"
                                    placeholder="Konfirmasi password">
                                <button type="button" id="togglePasswordConfirm"
                                    class="absolute inset-y-0 right-0 pr-4 flex items-center">
                                    <i class="fas fa-eye text-gray-400 hover:text-gray-600 transition-colors"></i>
                                </button>
                            </div>
                            <div id="passwordMatchMessage" class="mt-2 text-sm hidden">
                                <div class="flex items-center text-red-600" id="passwordMismatch">
                                    <i class="fas fa-times-circle mr-2"></i>
                                    <span>Password tidak cocok</span>
                                </div>
                                <div class="flex items-center text-green-600" id="passwordMatch">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    <span>Password cocok</span>
                                </div>
                            </div>
                        </div>

                        <!-- Admin Info Card -->
                        <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                            <div class="flex items-start">
                                <div class="flex-shrink-0">
                                    <div class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center">
                                        <i class="fas fa-user-shield text-blue-600"></i>
                                    </div>
                                </div>
                                <div class="ml-4">
                                    <h3 class="text-sm font-semibold text-blue-800 mb-1">Informasi Super Admin</h3>
                                    <p class="text-sm text-blue-700">
                                        Akun ini akan dibuat di bawah Super Admin:
                                        <span
                                            class="font-medium">{{ Auth::guard('superadmin')->user()->username ?? 'N/A' }}</span>
                                    </p>
                                    <p class="text-xs text-blue-600 mt-1">
                                        Admin yang dibuat akan memiliki akses terbatas sesuai dengan pengaturan sistem
                                    </p>
                                </div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('akun') }}"
                                class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </a>

                            <button type="submit" id="submitBtn"
                                class="inline-flex items-center px-8 py-3 border border-transparent rounded-xl text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-save mr-2"></i>
                                <span class="loading-text">Buat Akun</span>
                                <i class="fas fa-spinner fa-spin ml-2 hidden loading-spinner"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Tips Card -->
            <div class="mt-8 bg-gradient-to-r from-amber-50 to-orange-50 border border-amber-200 rounded-xl p-6">
                <div class="flex items-start">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-amber-100 rounded-full flex items-center justify-center">
                            <i class="fas fa-lightbulb text-amber-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4">
                        <h3 class="text-lg font-semibold text-amber-800 mb-2">Tips Keamanan</h3>
                        <ul class="text-sm text-amber-700 space-y-1">
                            <li class="flex items-center">
                                <i class="fas fa-check text-amber-600 mr-2"></i>
                                Gunakan password yang kuat dan unik
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-amber-600 mr-2"></i>
                                Jangan gunakan informasi pribadi dalam password
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-amber-600 mr-2"></i>
                                Pastikan username mudah diingat namun profesional
                            </li>
                            <li class="flex items-center">
                                <i class="fas fa-check text-amber-600 mr-2"></i>
                                Admin dapat mengubah password setelah login pertama
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    {{-- Select2 CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    {{-- Custom Select2 Tailwind Styling --}}
    <style>
        .select2-container--default .select2-selection--single {
            height: 42px;
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 0.5rem 0.75rem;
            background-color: white;
        }

        .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #374151;
            line-height: 28px;
            padding-left: 0;
            padding-right: 20px;
        }

        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
            right: 10px;
        }

        .select2-container--default.select2-container--focus .select2-selection--single,
        .select2-container--default.select2-container--open .select2-selection--single {
            border-color: #6366f1;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
            outline: none;
        }

        .select2-dropdown {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05);
        }

        .select2-container--default .select2-results__option--highlighted[aria-selected] {
            background-color: #6366f1;
            color: white;
        }

        .select2-container--default .select2-results__option {
            padding: 8px 12px;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field {
            border: 1px solid #d1d5db;
            border-radius: 0.375rem;
            padding: 8px 12px;
        }

        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            border-color: #6366f1;
            outline: none;
            box-shadow: 0 0 0 3px rgba(99, 102, 241, 0.1);
        }

        /* Responsive */
        .select2-container {
            width: 100% !important;
        }
    </style>
@endpush
@push('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>
        $(document).ready(function() {
            // Initialize Select2
            $('#puskesmas').select2({
                placeholder: "-- Pilih Puskesmas --",
                allowClear: true,
                width: '100%',
                language: {
                    noResults: function() {
                        return "Tidak ada data yang ditemukan";
                    },
                    searching: function() {
                        return "Mencari...";
                    },
                    loadingMore: function() {
                        return "Memuat lebih banyak hasil...";
                    }
                },
                // Tambahan konfigurasi
                dropdownParent: $('body'), // Untuk modal compatibility
                escapeMarkup: function(markup) {
                    return markup;
                }
            });

            // Event listener untuk debugging (opsional)
            $('#puskesmas').on('select2:select', function(e) {
                var data = e.params.data;
                console.log('Puskesmas terpilih:', data);
            });

            $('#puskesmas').on('select2:clear', function(e) {
                console.log('Pilihan puskesmas dihapus');
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            // Toggle password visibility
            $('#togglePassword').click(function() {
                const password = $('#password');
                const icon = $(this).find('i');

                if (password.attr('type') === 'password') {
                    password.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    password.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            $('#togglePasswordConfirm').click(function() {
                const password = $('#password_confirmation');
                const icon = $(this).find('i');

                if (password.attr('type') === 'password') {
                    password.attr('type', 'text');
                    icon.removeClass('fa-eye').addClass('fa-eye-slash');
                } else {
                    password.attr('type', 'password');
                    icon.removeClass('fa-eye-slash').addClass('fa-eye');
                }
            });

            // Password strength checker
            $('#password').on('input', function() {
                const password = $(this).val();
                checkPasswordStrength(password);
            });

            // Password match checker
            $('#password_confirmation').on('input', function() {
                const password = $('#password').val();
                const confirmPassword = $(this).val();

                if (confirmPassword.length > 0) {
                    $('#passwordMatchMessage').removeClass('hidden');

                    if (password === confirmPassword) {
                        $('#passwordMatch').removeClass('hidden');
                        $('#passwordMismatch').addClass('hidden');
                    } else {
                        $('#passwordMatch').addClass('hidden');
                        $('#passwordMismatch').removeClass('hidden');
                    }
                } else {
                    $('#passwordMatchMessage').addClass('hidden');
                }
            });

            function checkPasswordStrength(password) {
                let strength = 0;
                const checks = {
                    length: password.length >= 8,
                    upper: /[A-Z]/.test(password),
                    lower: /[a-z]/.test(password),
                    number: /[0-9]/.test(password)
                };

                // Update visual indicators
                updateCheck('lengthCheck', checks.length);
                updateCheck('upperCheck', checks.upper);
                updateCheck('lowerCheck', checks.lower);
                updateCheck('numberCheck', checks.number);

                // Calculate strength
                Object.values(checks).forEach(passed => {
                    if (passed) strength++;
                });

                // Update strength bar
                const strengthPercentage = (strength / 4) * 100;
                const strengthBar = $('#passwordStrengthBar');
                const strengthText = $('#passwordStrengthText');

                strengthBar.css('width', strengthPercentage + '%');

                if (strength <= 1) {
                    strengthBar.removeClass().addClass('bg-red-500 h-2 rounded-full transition-all duration-300');
                    strengthText.text('Lemah').removeClass().addClass('text-sm font-medium text-red-500');
                } else if (strength <= 2) {
                    strengthBar.removeClass().addClass(
                        'bg-yellow-500 h-2 rounded-full transition-all duration-300');
                    strengthText.text('Sedang').removeClass().addClass('text-sm font-medium text-yellow-500');
                } else if (strength <= 3) {
                    strengthBar.removeClass().addClass('bg-blue-500 h-2 rounded-full transition-all duration-300');
                    strengthText.text('Baik').removeClass().addClass('text-sm font-medium text-blue-500');
                } else {
                    strengthBar.removeClass().addClass('bg-green-500 h-2 rounded-full transition-all duration-300');
                    strengthText.text('Sangat Kuat').removeClass().addClass('text-sm font-medium text-green-500');
                }
            }

            function updateCheck(elementId, passed) {
                const element = $('#' + elementId);
                if (passed) {
                    element.removeClass('text-gray-400').addClass('text-green-500');
                } else {
                    element.removeClass('text-green-500').addClass('text-gray-400');
                }
            }

            // Form submission with loading state
            $('#createAccountForm').submit(function(e) {
                const submitBtn = $('#submitBtn');
                const loadingText = submitBtn.find('.loading-text');
                const loadingSpinner = submitBtn.find('.loading-spinner');

                // Show loading state
                submitBtn.prop('disabled', true);
                loadingText.text('Membuat Akun...');
                loadingSpinner.removeClass('hidden');

                // Add some visual feedback
                submitBtn.addClass('opacity-75 cursor-not-allowed');
            });

            // Auto-focus on first input
            $('#username').focus();

            // Add smooth animations
            $('.group input').on('focus', function() {
                $(this).parent().parent().addClass('transform scale-105 transition-transform duration-200');
            }).on('blur', function() {
                $(this).parent().parent().removeClass(
                    'transform scale-105 transition-transform duration-200');
            });
        });
    </script>
@endpush

@push('styles')
    <style>
        .group:hover {
            transform: translateY(-1px);
            transition: all 0.2s ease;
        }

        .group input:focus {
            box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.1);
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .container>div {
            animation: fadeInUp 0.6s ease forwards;
        }

        .container>div:nth-child(2) {
            animation-delay: 0.1s;
        }

        .container>div:nth-child(3) {
            animation-delay: 0.2s;
        }

        .container>div:nth-child(4) {
            animation-delay: 0.3s;
        }
    </style>
@endpush
