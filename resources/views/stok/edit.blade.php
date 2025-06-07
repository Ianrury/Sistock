@extends('layouts.admin')
@section('title', 'Edit Stock Obat')
@section('page-title', 'Edit Stock Obat')

@section('content')
    @include('sweetalert::alert')
    <div class="mb-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Edit Stock Obat</h2>
                <p class="mt-2 text-sm text-gray-700">Perbarui informasi stock obat</p>
            </div>
        </div>
    </div>

    <div class="max-w-4xl mx-auto">
        <div class="bg-white shadow-xl rounded-lg overflow-hidden">
            <div class="px-6 py-4 bg-gradient-to-r from-blue-500 to-blue-600">
                <h3 class="text-lg font-semibold text-white">Form Edit Stock Obat</h3>
            </div>

            <form action="{{ route('stok.update', $obat->id) }}" method="POST" class="p-6 space-y-6">
                @csrf
                @method('PUT')

                <!-- Grid Layout untuk Desktop, Stack untuk Mobile -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <!-- Nama Obat -->
                    <div class="space-y-2">
                        <label for="nama_obat" class="block text-sm font-medium text-gray-700">
                            Nama Obat <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="nama_obat" name="nama_obat"
                            value="{{ old('nama_obat', $obat->nama_obat) }}"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('nama_obat') border-red-500 @enderror"
                            placeholder="Masukkan nama obat" required>
                        @error('nama_obat')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Jenis Obat -->
                    <div class="space-y-2">
                        <label for="jenis_obat" class="block text-sm font-medium text-gray-700">
                            Jenis Obat <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="jenis_obat" name="jenis_obat"
                            value="{{ old('jenis_obat', $obat->jenis_obat) }}"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('jenis_obat') border-red-500 @enderror"
                            placeholder="Masukkan jenis obat" required>
                        @error('jenis_obat')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Stock Obat -->
                    <div class="space-y-2">
                        <label for="stock_obat" class="block text-sm font-medium text-gray-700">
                            Stock Obat <span class="text-red-500">*</span>
                        </label>
                        <input type="number" id="stock_obat" name="stock_obat"
                            value="{{ old('stock_obat', $obat->stock_obat) }}" min="0"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('stock_obat') border-red-500 @enderror"
                            placeholder="Masukkan jumlah stock" required>
                        @error('stock_obat')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Satuan -->
                    <div class="space-y-2">
                        <label for="satuan" class="block text-sm font-medium text-gray-700">
                            Satuan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="satuan" name="satuan" value="{{ old('satuan', $obat->satuan) }}"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('satuan') border-red-500 @enderror"
                            placeholder="Contoh: pcs, box, botol" required>
                        @error('satuan')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Masuk -->
                    <div class="space-y-2">
                        <label for="tanggal_masuk" class="block text-sm font-medium text-gray-700">
                            Tanggal Masuk <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_masuk" name="tanggal_masuk"
                            value="{{ old('tanggal_masuk', $obat->tanggal_masuk) }}"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('tanggal_masuk') border-red-500 @enderror"
                            required>
                        @error('tanggal_masuk')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Tanggal Kadaluarsa -->
                    <div class="space-y-2">
                        <label for="tanggal_kadaluarsa" class="block text-sm font-medium text-gray-700">
                            Tanggal Kadaluarsa <span class="text-red-500">*</span>
                        </label>
                        <input type="date" id="tanggal_kadaluarsa" name="tanggal_kadaluarsa"
                            value="{{ old('tanggal_kadaluarsa', $obat->tanggal_kadaluarsa) }}"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('tanggal_kadaluarsa') border-red-500 @enderror"
                            required>
                        @error('tanggal_kadaluarsa')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Bentuk Obat -->
                    <div class="space-y-2">
                        <label for="bentuk" class="block text-sm font-medium text-gray-700">
                            Bentuk Obat <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="bentuk" name="bentuk" value="{{ old('bentuk', $obat->bentuk) }}"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('bentuk') border-red-500 @enderror"
                            placeholder="Contoh: tablet, kapsul, sirup" required>
                        @error('bentuk')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Dosis (Isi Kemasan) -->
                    <div class="space-y-2">
                        <label for="isi_kemasan" class="block text-sm font-medium text-gray-700">
                            Dosis/Isi Kemasan <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="isi_kemasan" name="isi_kemasan"
                            value="{{ old('isi_kemasan', $obat->isi_kemasan) }}"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200 @error('isi_kemasan') border-red-500 @enderror"
                            placeholder="Contoh: 500mg, 10ml, 250mg/5ml" required>
                        @error('isi_kemasan')
                            <p class="text-sm text-red-600">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-200">
                    <button type="submit"
                        class="flex-1 sm:flex-none inline-flex justify-center items-center px-6 py-3 bg-blue-600 text-white font-medium rounded-lg hover:bg-blue-700 focus:ring-4 focus:ring-blue-200 transition duration-200 shadow-lg hover:shadow-xl">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Update Stock Obat
                    </button>

                    <a href="{{ route('stok.index') }}"
                        class="flex-1 sm:flex-none inline-flex justify-center items-center px-6 py-3 bg-gray-500 text-white font-medium rounded-lg hover:bg-gray-600 focus:ring-4 focus:ring-gray-200 transition duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                        Batal
                        </button>
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Alert Success/Error (Optional) -->
    @if (session('success'))
        <div class="fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" id="success-alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        </div>
    @endif

    @if ($errors->any())
        <div class="fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50" id="error-alert">
            <div class="flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
                Terdapat kesalahan dalam pengisian form
            </div>
        </div>
    @endif

    <script>
        setTimeout(function() {
            const successAlert = document.getElementById('success-alert');
            const errorAlert = document.getElementById('error-alert');

            if (successAlert) {
                successAlert.style.opacity = '0';
                setTimeout(() => successAlert.remove(), 300);
            }

            if (errorAlert) {
                errorAlert.style.opacity = '0';
                setTimeout(() => errorAlert.remove(), 300);
            }
        }, 5000);

        document.getElementById('tanggal_masuk').addEventListener('change', function() {
            const tanggalMasuk = this.value;
            const tanggalKadaluarsa = document.getElementById('tanggal_kadaluarsa');

            if (tanggalMasuk) {
                tanggalKadaluarsa.min = tanggalMasuk;

                if (tanggalKadaluarsa.value && tanggalKadaluarsa.value < tanggalMasuk) {
                    tanggalKadaluarsa.value = tanggalMasuk;
                }
            }
        });

        // Set initial min date for tanggal kadaluarsa
        window.addEventListener('load', function() {
            const tanggalMasuk = document.getElementById('tanggal_masuk').value;
            if (tanggalMasuk) {
                document.getElementById('tanggal_kadaluarsa').min = tanggalMasuk;
            }
        });
    </script>
@endsection
