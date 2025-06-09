@extends('layouts.admin')
@section('title', 'Detail Produk Obat')
@section('page-title', 'Detail Produk Obat')

@section('content')
    @include('sweetalert::alert')

    <!-- Header Section -->
    <div class="mb-8">
        @include('sweetalert::alert')
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Detail Produk Obat</h2>
                <p class="mt-2 text-sm text-gray-700">Informasi lengkap produk obat dan stock</p>
            </div>
            <div class="mt-4 sm:mt-0 flex space-x-3">
                <a href="{{ route('stok.index') }}"
                    class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali
                </a>
                <a href="{{ route('stok.edit', $obat->id) }}"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                    Edit
                </a>
            </div>
        </div>
    </div>

    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
            <strong class="font-bold">Ups! Ada kesalahan:</strong>
            <ul class="mt-2 list-disc list-inside text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <!-- Detail Data Section -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden mb-8">
        <div class="bg-gradient-to-r from-blue-600 to-blue-700 px-6 py-4">
            <h3 class="text-lg font-semibold text-white flex items-center">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Informasi Produk
            </h3>
        </div>

        <div class="p-6">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Nama Obat -->
                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-blue-500">
                    <dt class="text-sm font-medium text-gray-500 mb-1">Nama Obat</dt>
                    <dd class="text-lg font-semibold text-gray-900">{{ $obat->nama_obat }}</dd>
                </div>

                <!-- Jenis Obat -->
                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-green-500">
                    <dt class="text-sm font-medium text-gray-500 mb-1">Jenis Obat</dt>
                    <dd class="text-lg font-semibold text-gray-900">{{ $obat->jenis_obat }}</dd>
                </div>

                <!-- Stock -->
                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-yellow-500">
                    <dt class="text-sm font-medium text-gray-500 mb-1">Stock Tersedia</dt>
                    <dd class="text-lg font-semibold text-gray-900">
                        <span
                            class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium 
                             {{ $obat->stock_obat > 50 ? 'bg-green-100 text-green-800' : ($obat->stock_obat > 10 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                            {{ number_format($obat->stock_obat, 0, ',', '.') }}
                        </span>
                    </dd>
                </div>

                <!-- Bentuk -->
                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-purple-500">
                    <dt class="text-sm font-medium text-gray-500 mb-1">Bentuk</dt>
                    <dd class="text-lg font-semibold text-gray-900">{{ $obat->bentuk }}</dd>
                </div>

                <!-- Isi Kemasan -->
                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-indigo-500">
                    <dt class="text-sm font-medium text-gray-500 mb-1">Isi Kemasan</dt>
                    <dd class="text-lg font-semibold text-gray-900">{{ $obat->isi_kemasan }} {{ $obat->bentuk }}</dd>
                </div>

                <!-- Tanggal Masuk -->
                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-teal-500">
                    <dt class="text-sm font-medium text-gray-500 mb-1">Tanggal Masuk</dt>
                    <dd class="text-lg font-semibold text-gray-900">
                        {{ \Carbon\Carbon::parse($obat->tanggal_masuk)->format('d M Y') }}</dd>
                </div>

                <!-- Tanggal Kadaluarsa -->
                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-red-500">
                    <dt class="text-sm font-medium text-gray-500 mb-1">Tanggal Kadaluarsa</dt>
                    <dd class="text-lg font-semibold text-gray-900">
                        {{ \Carbon\Carbon::parse($obat->tanggal_kadaluarsa)->format('d M Y') }}
                        @php
                            $now = \Carbon\Carbon::now();
                            $expiry = \Carbon\Carbon::parse($obat->tanggal_kadaluarsa);
                            $daysLeft = $now->diffInDays($expiry, false);
                        @endphp
                        @if ($daysLeft < 0)
                            <span
                                class="ml-2 inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                Kadaluarsa
                            </span>
                        @endif
                    </dd>
                </div>

                <!-- Satuan -->
                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-orange-500">
                    <dt class="text-sm font-medium text-gray-500 mb-1">Satuan</dt>
                    <dd class="text-lg font-semibold text-gray-900">{{ $obat->satuan }}</dd>
                </div>
            </div>
        </div>
    </div>

    <!-- Table Section -->
    <div class="bg-white shadow-lg rounded-lg overflow-hidden">
        <div
            class="bg-gradient-to-r from-gray-700 to-gray-800 px-6 py-4 flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <h3 class="text-lg font-semibold text-white flex items-center mb-4 sm:mb-0">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                Riwayat Stock
            </h3>
            <div class="flex flex-col sm:flex-row space-y-2 sm:space-y-0 sm:space-x-3">
                <button onclick="kurangiStock()"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-red-500">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4" />
                    </svg>
                    Pengeluaran
                </button>
                {{-- <a href="{{ route('history.export.pdf', $obat->id) }}">
                    <button 
                        class="inline-flex items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-green-600 hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                        </svg>
                        Export Data
                    </button>
                </a> --}}
            </div>
        </div>


        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            No
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Tanggal
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Dari/Kepada
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Penerimaan
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Pengeluaran
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Sisa Stok
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            Kadaluarsa
                        </th>
                        <th scope="col"
                            class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                            aksi
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    <!-- Data history pengeluaran -->
                    @foreach ($history as $index => $item)
                        <tr class="hover:bg-gray-50">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">{{ $index + 1 }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ \Carbon\Carbon::parse($item->tanggal_keluar)->format('d M Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                {{ $item->dari ?? 'Tidak diketahui' }} / {{ $item->kepada ?? 'Tidak diketahui' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->penerima ?? 'Tidak diketahui' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->pengeluaran }} {{ $obat->satuan }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                {{ $item->sisa_stock }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $item->tanggal_kadaluarsa
                                    ? \Carbon\Carbon::parse($item->tanggal_kadaluarsa)->format('d M Y')
                                    : 'Pengeluaran stock' }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <button
                                    onclick="deleteHistory({{ $item->id }}, '{{ $item->dari ?? 'Item' }}', '{{ $item->tanggal_keluar }}')"
                                    class="text-red-600 hover:text-red-700 p-2 rounded hover:bg-red-50 transition-colors mr-2 bg-red-300">
                                    Hapus
                                </button>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- Empty State jika tidak ada data history -->
        @if ($history->isEmpty())
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M9 17V7m0 10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2h2a2 2 0 012 2m0 10a2 2 0 002 2h2a2 2 0 002-2M9 7a2 2 0 012-2h2a2 2 0 012 2m0 10V7m0 10a2 2 0 002 2h2a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Tidak ada riwayat pengeluaran stock</h3>
                <p class="mt-1 text-sm text-gray-500">Belum ada aktivitas pengeluaran stock untuk produk ini.</p>
            </div>
        @endif
    </div>

    <!-- Modal Kurangi Stock -->
    <div id="kurangiStockModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50 hidden">
        <div class="relative top-10 mx-auto p-6 border max-w-2xl w-full mx-4 shadow-xl rounded-lg bg-white">
            <div class="text-center">
                <!-- Header Icon -->
                <div class="mx-auto flex items-center justify-center h-16 w-16 rounded-full bg-red-100 mb-4">
                    <svg class="h-8 w-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4" />
                    </svg>
                </div>

                <!-- Title -->
                <h3 class="text-xl leading-6 font-semibold text-gray-900 mb-6">Kurangi Stock Obat</h3>
            </div>

            <form action="{{ route('history.store') }}" method="post">
                @csrf
                <input type="hidden" name="data_obat_id" value="{{ $obat->id }}">

                <!-- Form Content -->
                <div class="space-y-6">
                    <!-- Row 1: Dari dan Kepada -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

                        <div>
                            <label for="dari" class="block text-sm font-medium text-gray-700 mb-2">
                                Dari <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="dari" name="dari"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                placeholder="Masukkan asal obat">
                        </div>
                        <div>
                            <label for="kepada" class="block text-sm font-medium text-gray-700 mb-2">
                                Kepada <span class="text-red-500">*</span>
                            </label>
                            <input type="text" id="kepada" name="kepada"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                placeholder="Masukkan tujuan obat">
                        </div>
                    </div>

                    <!-- Row 2: Penerima -->
                    <div>
                        <label for="penerima" class="block text-sm font-medium text-gray-700 mb-2">
                            Penerima <span class="text-red-500">*</span>
                        </label>
                        <input type="text" id="penerima" name="penerima"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                            placeholder="Masukkan nama penerima">
                    </div>

                    <!-- Row 3: Pengeluaran -->
                    <div>
                        <label for="pengeluaran" class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah Pengeluaran <span class="text-red-500">*</span>
                        </label>
                        <div class="relative">
                            <!-- Visible input (format angka dengan titik) -->
                            <input type="text" id="pengeluaran_format"
                                class="w-full px-4 py-3 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition duration-200"
                                placeholder="Masukkan jumlah pengeluaran">

                            <!-- Hidden input untuk dikirim -->
                            <input type="hidden" name="pengeluaran" id="pengeluaran">

                            <!-- Hidden input stok real -->
                            <input type="hidden" name="stok_real" id="stok_real" value="{{ $obat->stock_obat }}">
                        </div>

                        <div class="mt-2 flex items-center">
                            <div class="flex items-center">
                                <svg class="h-4 w-4 text-green-500 mr-1" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <span class="text-sm text-green-600 font-medium">
                                    Stock tersedia: {{ number_format($obat->stock_obat, 0, ',', '.') }}
                                </span>

                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-8 flex flex-col sm:flex-row sm:justify-end sm:space-x-3 space-y-3 sm:space-y-0">
                    <button type="button" onclick="tutupModal()"
                        class="w-full sm:w-auto px-6 py-3 bg-gray-100 text-gray-700 text-base font-medium rounded-lg shadow-sm hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-gray-500 transition duration-200 border border-gray-300">
                        <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                        Batal
                    </button>
                    <button id="konfirmasiKurang"
                        class="w-full sm:w-auto px-6 py-3 bg-red-600 text-white text-base font-medium rounded-lg shadow-sm hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500 transition duration-200">
                        <svg class="inline-block w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Konfirmasi Pengeluaran
                    </button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function kurangiStock() {
            document.getElementById('kurangiStockModal').classList.remove('hidden');
        }

        function tutupModal() {
            document.getElementById('kurangiStockModal').classList.add('hidden');
            document.getElementById('jumlah_kurang').value = '';
            document.getElementById('keterangan').value = '';
        }

        document.getElementById('konfirmasiKurang').addEventListener('click', function() {
            const jumlah = document.getElementById('jumlah_kurang').value;
            const keterangan = document.getElementById('keterangan').value;

            if (!jumlah || jumlah <= 0) {
                alert('Masukkan jumlah yang valid!');
                return;
            }

            if (jumlah > {{ $obat->stock_obat }}) {
                alert('Jumlah tidak boleh melebihi stock yang tersedia!');
                return;
            }

            // Implementasi AJAX untuk kurangi stock
            // Anda bisa menambahkan AJAX call ke controller untuk memproses pengurangan stock
            if (confirm(`Apakah Anda yakin ingin mengurangi stock sebanyak ${jumlah} ${{ '$obat->satuan' }}?`)) {
                // AJAX call atau form submit
                alert('Stock berhasil dikurangi!');
                tutupModal();
                location.reload(); // Refresh halaman
            }
        });

        // Close modal ketika klik di luar modal
        document.getElementById('kurangiStockModal').addEventListener('click', function(e) {
            if (e.target === this) {
                tutupModal();
            }
        });
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const formatInput = document.getElementById('pengeluaran_format');
            const hiddenInput = document.getElementById('pengeluaran');
            const stokReal = parseInt(document.getElementById('stok_real').value);

            formatInput.addEventListener('input', function(e) {
                let value = formatInput.value.replace(/\./g, ''); // hapus titik
                if (!/^\d*$/.test(value)) {
                    formatInput.value = ''; // reset kalau bukan angka
                    hiddenInput.value = '';
                    return;
                }

                let intValue = parseInt(value);
                if (isNaN(intValue)) intValue = 0;

                if (intValue > stokReal) {
                    intValue = stokReal;
                }

                // Set nilai hidden
                hiddenInput.value = intValue;

                // Format tampilannya
                formatInput.value = intValue.toLocaleString('id-ID');
            });
        });
    </script>

    <script>
        function deleteHistory(id, itemName, tanggalKeluar) {
            const formattedDate = new Date(tanggalKeluar).toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            Swal.fire({
                title: 'Konfirmasi Hapus',
                html: `Apakah Anda yakin ingin menghapus history:<br>
               <strong>${itemName}</strong><br>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Create form and submit
                    const form = document.createElement('form');
                    form.method = 'POST';
                    form.action = `/akun/destroy/${id}`; // Sesuaikan dengan route Anda
                    form.style.display = 'none';

                    // Add CSRF token
                    const csrfInput = document.createElement('input');
                    csrfInput.type = 'hidden';
                    csrfInput.name = '_token';
                    csrfInput.value = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

                    // Add method spoofing if using DELETE method
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'DELETE';

                    form.appendChild(csrfInput);
                    form.appendChild(methodInput);
                    document.body.appendChild(form);

                    // Submit form
                    form.submit();
                }
            });
        }

        // Alternative with AJAX (if you prefer JSON response)
        function deleteHistoryAjax(id, itemName, tanggalKeluar) {
            const formattedDate = new Date(tanggalKeluar).toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'long',
                year: 'numeric'
            });

            Swal.fire({
                title: 'Konfirmasi Hapus',
                html: `Apakah Anda yakin ingin menghapus history:<br>
               <strong>${itemName}</strong><br>
               <small>Tanggal: ${formattedDate}</small>`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    // Show loading
                    Swal.fire({
                        title: 'Menghapus...',
                        text: 'Mohon tunggu sebentar',
                        allowOutsideClick: false,
                        showConfirmButton: false,
                        willOpen: () => {
                            Swal.showLoading();
                        }
                    });

                    // Create FormData
                    const formData = new FormData();
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                    if (csrfToken) {
                        formData.append('_token', csrfToken);
                        formData.append('_method', 'DELETE');
                    }

                    fetch(`/akun/destroy/${id}`, {
                            method: 'POST',
                            body: formData
                        })
                        .then(response => {
                            if (response.ok) {
                                return response.json();
                            } else if (response.redirected) {
                                // Handle redirect (page will refresh)
                                window.location.reload();
                                return;
                            } else {
                                throw new Error(`HTTP error! status: ${response.status}`);
                            }
                        })
                        .then(data => {
                            if (data && data.success) {
                                Swal.fire({
                                    title: 'Berhasil!',
                                    text: 'History berhasil dihapus.',
                                    icon: 'success',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    // Refresh page or remove row from table
                                    location.reload();
                                });
                            } else if (data) {
                                throw new Error(data.message || 'Gagal menghapus history');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            Swal.fire({
                                title: 'Error!',
                                text: 'Terjadi kesalahan saat menghapus history.',
                                icon: 'error'
                            });
                        });
                }
            });
        }
    </script>

@endsection
