@extends('layouts.admin')

@section('title', 'Manajemen Stok - Admin Panel')
@section('page-title', 'Manajemen Stok')

@section('content')
    <!-- Header Section -->
    @include('sweetalert::alert')
    <div class="mb-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Manajemen Stok</h2>
                <p class="mt-2 text-sm text-gray-700">Kelola Stok Pada sistem</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <button onclick="openModal()"
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Stok
                </button>
            </div>
        </div>
    </div>

    <!-- Stock Overview Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Total Products -->
        <div
            class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-cube text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Produk</dt>
                            <dd class="text-2xl font-bold text-gray-900"> {{ number_format($totalObat, 0, ',', '.') }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-green-600 font-medium">{{ number_format($newThisMonth, 0, ',', '.') }} Produk Baru pada bulan ini</span>
                </div>
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div
            class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-red-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Produk Akan Habis</dt>
                            <dd class="text-2xl font-bold text-gray-900"> {{ number_format($lowStock, 0, ',', '.') }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-red-600 font-medium">Butuh Restock</span>
                </div>
            </div>
        </div>

        <!-- Out of Stock -->
        <div
            class="bg-white overflow-hidden shadow-lg rounded-xl border border-gray-100 hover:shadow-xl transition-all duration-300">
            <div class="p-6">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <div class="w-12 h-12 bg-gray-100 rounded-lg flex items-center justify-center">
                            <i class="fas fa-times-circle text-gray-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Produk Habis</dt>
                            <dd class="text-2xl font-bold text-gray-900"> {{ number_format($outOfStock, 0, ',', '.') }}</dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-gray-600 font-medium">Butuh Restock</span>
                </div>
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

    <!-- Filters and Search -->
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 mb-8">
        <div class="px-6 py-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="mb-6 bg-white p-4 rounded-lg shadow w-full md:col-span-3">
                    <form method="GET" action="{{ route('stok.index') }}" class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div class="md:col-span-2">
                            <div class="relative w-full"> <!-- ganti dari w-100 ke w-full -->
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <i class="fas fa-search text-gray-400"></i>
                                </div>
                                <input type="text" name="search" value="{{ request('search') }}"
                                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-primary focus:border-primary"
                                    placeholder="Cari nama obat, jenis obat, atau bentuk obat...">
                            </div>
                        </div>

                        <div class="flex space-x-2 items-center">
                            <button type="submit"
                                class="w-auto inline-flex justify-center items-center px-4 py-2 bg-primary text-white font-medium rounded-lg hover:bg-blue-700 transition duration-200">
                                <i class="fas fa-search mr-2"></i>
                                Cari
                            </button>
                            @if (request('search'))
                                <a href="{{ route('stok.index') }}"
                                    class="w-auto inline-flex items-center px-4 py-2 bg-gray-500 text-white font-medium rounded-lg hover:bg-gray-600 transition duration-200">
                                    <i class="fas fa-times mr-2"></i>
                                    Reset
                                </a>
                            @endif
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>

    <!-- Stock Table -->
    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="bg-white shadow overflow-hidden sm:rounded-lg">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                <input type="checkbox" class="rounded border-gray-300 text-primary focus:ring-primary"
                                    id="select-all">
                            </th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama
                                Obat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jenis
                                Obat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock
                                Obat</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Tanggal Masuk</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kadaluarsa</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @forelse($obats as $obat)
                            <tr class="hover:bg-gray-50 transition-colors">
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <input type="checkbox"
                                        class="rounded border-gray-300 text-primary focus:ring-primary row-checkbox"
                                        value="{{ $obat->id }}">
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-start">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">{{ $obat->nama_obat }}</div>
                                            <div class="text-sm text-gray-500">{{ $obat->isi_kemasan }} {{ $obat->bentuk }}
                                            </div>
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $obat->jenis_obat }}</td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    <span
                                        class="font-medium {{ $obat->stock_obat <= 10 ? 'text-red-600' : 'text-gray-900' }}">
                                        {{ $obat->stock_obat }}
                                    </span>
                                    @if ($obat->stock_obat <= 10)
                                        <span
                                            class="ml-2 inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Stok Rendah
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                                    {{ \Carbon\Carbon::parse($obat->tanggal_masuk)->format('d M Y') }}
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    @php
                                        $kadaluarsa = \Carbon\Carbon::parse($obat->tanggal_kadaluarsa);
                                        $today = \Carbon\Carbon::now();
                                        $diffInDays = $today->diffInDays($kadaluarsa, false);
                                    @endphp

                                    @if ($diffInDays < 0)
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">
                                            Kadaluarsa
                                        </span>
                                    @elseif($diffInDays <= 30)
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">
                                            {{ $kadaluarsa->format('d M Y') }}
                                        </span>
                                    @else
                                        <span
                                            class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">
                                            {{ $kadaluarsa->format('d M Y') }}
                                        </span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <div class="flex space-x-2">
                                        <a href="{{ route('stok.edit', $obat->id) }}"
                                            class="text-primary hover:text-blue-700 p-1 rounded hover:bg-blue-50"
                                            title="Edit">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="{{ route('stok.show', $obat->id) }}"
                                            class="text-green-600 hover:text-green-700 p-1 rounded hover:bg-green-50"
                                            title="Lihat Detail">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <button type="button"
                                            class="text-red-600 hover:text-red-700 p-1 rounded hover:bg-red-50 delete-btn"
                                            data-id="{{ $obat->id }}" data-name="{{ $obat->nama_obat }}"
                                            title="Hapus">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="px-6 py-12 text-center">
                                    <div class="flex flex-col items-center">
                                        <i class="fas fa-pills text-gray-400 text-4xl mb-4"></i>
                                        <h3 class="text-lg font-medium text-gray-900 mb-2">Belum ada data obat</h3>
                                        <p class="text-gray-500 mb-4">
                                            @if (request('search'))
                                                Tidak ditemukan obat dengan kata kunci "{{ request('search') }}"
                                            @else
                                                Mulai tambahkan data obat untuk mengelola stock apotek
                                            @endif
                                        </p>
                                        <button onclick="openModal()"
                                            class="inline-flex items-center px-4 py-2 bg-primary text-white font-medium rounded-lg hover:bg-blue-700 transition duration-200">
                                            <i class="fas fa-plus mr-2"></i>
                                            Tambah Obat Baru
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            @if ($obats->hasPages())
                <div class="bg-white px-6 py-3 border-t border-gray-200 sm:px-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <p class="text-sm text-gray-700">
                                Menampilkan <span class="font-medium">{{ $obats->firstItem() }}</span> sampai
                                <span class="font-medium">{{ $obats->lastItem() }}</span> dari
                                <span class="font-medium">{{ $obats->total() }}</span> hasil
                            </p>
                        </div>
                        <div class="flex items-center space-x-2">
                            {{-- Previous Page Link --}}
                            @if ($obats->onFirstPage())
                                <button disabled
                                    class="relative inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-500 bg-white opacity-50 cursor-not-allowed">
                                    <i class="fas fa-chevron-left mr-1"></i>
                                    Previous
                                </button>
                            @else
                                <a href="{{ $obats->previousPageUrl() }}"
                                    class="relative inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-500 bg-white hover:bg-gray-50">
                                    <i class="fas fa-chevron-left mr-1"></i>
                                    Previous
                                </a>
                            @endif

                            {{-- Pagination Elements --}}
                            @foreach ($obats->getUrlRange(1, $obats->lastPage()) as $page => $url)
                                @if ($page == $obats->currentPage())
                                    <button
                                        class="relative inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-primary">
                                        {{ $page }}
                                    </button>
                                @else
                                    <a href="{{ $url }}"
                                        class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-500 bg-white hover:bg-gray-50">
                                        {{ $page }}
                                    </a>
                                @endif
                            @endforeach

                            {{-- Next Page Link --}}
                            @if ($obats->hasMorePages())
                                <a href="{{ $obats->nextPageUrl() }}"
                                    class="relative inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-500 bg-white hover:bg-gray-50">
                                    Next
                                    <i class="fas fa-chevron-right ml-1"></i>
                                </a>
                            @else
                                <button disabled
                                    class="relative inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-500 bg-white opacity-50 cursor-not-allowed">
                                    Next
                                    <i class="fas fa-chevron-right ml-1"></i>
                                </button>
                            @endif
                        </div>
                    </div>
                </div>
            @endif
        </div>

        <!-- Delete Confirmation Modal -->
        <div id="deleteModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full hidden z-50">
            <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-md bg-white">
                <div class="mt-3 text-center">
                    <div class="mx-auto flex items-center justify-center h-12 w-12 rounded-full bg-red-100">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl"></i>
                    </div>
                    <h3 class="text-lg font-medium text-gray-900 mt-2">Konfirmasi Hapus</h3>
                    <div class="mt-2 px-7 py-3">
                        <p class="text-sm text-gray-500">
                            Apakah Anda yakin ingin menghapus obat <span id="delete-name" class="font-medium"></span>?
                            Data yang dihapus tidak dapat dikembalikan.
                        </p>
                    </div>
                    <div class="flex gap-4 px-4 py-3">
                        <button id="confirmDelete"
                            class="flex-1 px-4 py-2 bg-red-600 text-white text-base font-medium rounded-md hover:bg-red-700 focus:outline-none focus:ring-2 focus:ring-red-500">
                            Hapus
                        </button>
                        <button id="cancelDelete"
                            class="flex-1 px-4 py-2 bg-gray-300 text-gray-700 text-base font-medium rounded-md hover:bg-gray-400 focus:outline-none focus:ring-2 focus:ring-gray-500">
                            Batal
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Delete Form (Hidden) -->
        <form id="deleteForm" method="POST" style="display: none;">
            @csrf
            @method('DELETE')
        </form>
    </div>

    <!-- Modal Overlay -->
    <div id="modalOverlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 transition-opacity duration-300">
        <!-- Modal Container -->
        <div class="flex items-center justify-center min-h-screen p-4">
            <div id="modalContent"
                class="bg-white rounded-2xl shadow-2xl w-full max-w-4xl max-h-[90vh] overflow-y-auto transform transition-all duration-300">

                <!-- Modal Header -->
                <div class="bg-gradient-to-r from-blue-600 to-indigo-600 text-white p-6">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div
                                class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center mr-4">
                                <i class="fas fa-pills text-xl"></i>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold">Input Data Obat</h2>
                                <p class="text-blue-100 text-sm">Tambahkan informasi obat ke sistem stok</p>
                            </div>
                        </div>
                        <button onclick="closeModal()"
                            class="w-8 h-8 bg-white bg-opacity-20 rounded-full flex items-center justify-center hover:bg-opacity-30 transition-all duration-200">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <!-- Modal Body -->
                <div class="p-6">
                    <form id="obatForm" action="{{ route('stok.store') }}" method="POST" class="space-y-6">
                        @csrf
                        <!-- Row 1: Nama Obat & Jenis Obat -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Nama Obat -->
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-capsules mr-2 text-blue-500"></i>Nama Obat
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="namaObat" name="nama_obat"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-4 focus:ring-blue-100 focus:border-blue-500 transition-all duration-200 group-hover:border-blue-300"
                                    placeholder="Contoh: Paracetamol" oninput="updateSummary()" required>
                                <div class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-info-circle mr-1"></i>Masukkan nama obat dengan lengkap
                                </div>
                            </div>

                            <!-- Jenis Obat -->
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-tags mr-2 text-green-500"></i>Jenis Obat
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="jenisObat" name="jenis_obat"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-4 focus:ring-green-100 focus:border-green-500 transition-all duration-200 group-hover:border-green-300"
                                    placeholder="Contoh: Analgesik" oninput="updateSummary()" required>
                                <div class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-info-circle mr-1"></i>Masukkan jenis obat (Analgesik, Antibiotik,
                                    dll)
                                </div>
                            </div>
                        </div>

                        <!-- Row 2: Stock & Tanggal Masuk -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Stock Obat -->
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-boxes mr-2 text-purple-500"></i>Stock Obat
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <input type="text" id="stockObatDisplay"
                                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-4 focus:ring-purple-100 focus:border-purple-500 transition-all duration-200 group-hover:border-purple-300 pr-16"
                                        placeholder="0" oninput="formatStock(this)" required>
                                    <!-- Hidden input untuk nilai real -->
                                    <input type="hidden" id="stockReal" name="stock_obat">
                                    <div
                                        class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-500 text-sm font-medium">

                                    </div>
                                </div>
                                <div class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-calculator mr-1"></i>Hanya angka, otomatis format ribuan
                                </div>
                            </div>

                            <!-- Tanggal Masuk -->
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-calendar-plus mr-2 text-indigo-500"></i>Tanggal Masuk
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="tanggalMasuk" name="tanggal_masuk"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-4 focus:ring-indigo-100 focus:border-indigo-500 transition-all duration-200 group-hover:border-indigo-300"
                                    onchange="updateSummary()" required>
                                <div class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-info-circle mr-1"></i>Tanggal obat masuk ke stok
                                </div>
                            </div>
                        </div>

                        <!-- Row 3: Kadar Luarsa & Bentuk -->
                        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                            <!-- Kadar Luarsa -->
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-exclamation-triangle mr-2 text-red-500"></i>Tanggal Kadaluarsa
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="date" id="kadarLuarsa" name="tanggal_kadaluarsa"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-4 focus:ring-red-100 focus:border-red-500 transition-all duration-200 group-hover:border-red-300"
                                    onchange="checkExpiry(); updateSummary();" required>
                                <div id="expiryWarning" class="text-xs mt-1 hidden">
                                    <i class="fas fa-warning mr-1"></i><span id="expiryText"></span>
                                </div>
                            </div>

                            <!-- Bentuk Obat -->
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-shapes mr-2 text-teal-500"></i>Bentuk Obat
                                    <span class="text-red-500">*</span>
                                </label>
                                <input type="text" id="bentukObat" name="bentuk"
                                    class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-4 focus:ring-teal-100 focus:border-teal-500 transition-all duration-200 group-hover:border-teal-300"
                                    placeholder="Contoh: Tablet" oninput="updateSummary()" required>
                                <div class="text-xs text-gray-500 mt-1">
                                    <i class="fas fa-info-circle mr-1"></i>Bentuk fisik obat (Tablet, Kapsul, Sirup,
                                    dll)
                                </div>
                            </div>
                        </div>

                        <!-- Row 4: Dosis -->
                        <div class="grid grid-cols-1 gap-6">
                            <div class="group">
                                <label class="block text-sm font-semibold text-gray-700 mb-2">
                                    <i class="fas fa-prescription-bottle mr-2 text-orange-500"></i>Dosis
                                    <span class="text-red-500">*</span>
                                </label>
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                                    <div>
                                        <input type="text" id="dosisKekuatan" name="isi_kemasan"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition-all duration-200"
                                            placeholder="500" oninput="updateSummary()" required>
                                        <label class="text-xs text-gray-500 mt-1 block">Kekuatan (mg/ml)</label>
                                    </div>
                                    <div>
                                        <input type="text" id="dosisSatuan" name="satuan"
                                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-4 focus:ring-orange-100 focus:border-orange-500 transition-all duration-200"
                                            placeholder="mg, ml, mcg, g" oninput="updateSummary()" required>
                                        <label class="text-xs text-gray-500 mt-1 block">Satuan</label>
                                    </div>
                                </div>
                                <div class="text-xs text-gray-500 mt-2">
                                    <i class="fas fa-info-circle mr-1"></i>Contoh: 500 mg
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Modal Footer -->
                <div
                    class="bg-gray-50 px-6 py-4 rounded-b-2xl flex flex-col sm:flex-row justify-between items-center space-y-3 sm:space-y-0">
                    <div class="text-sm text-gray-600 flex items-center">
                        <i class="fas fa-info-circle mr-2 text-blue-500"></i>
                        <span class="text-red-500">*</span> Field wajib diisi
                    </div>
                    <div class="flex space-x-3">
                        <button type="button" onclick="resetForm()"
                            class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-colors duration-200 flex items-center">
                            <i class="fas fa-redo mr-2"></i>Reset
                        </button>
                        <button type="button" onclick="closeModal()"
                            class="px-6 py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 transition-colors duration-200 flex items-center">
                            <i class="fas fa-times mr-2"></i>Batal
                        </button>
                        <button type="submit" form="obatForm"
                            class="px-8 py-2 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-lg hover:from-blue-700 hover:to-indigo-700 transition-all duration-200 flex items-center shadow-lg">
                            <i class="fas fa-save mr-2"></i>Simpan Data
                        </button>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <script>
        // Modal Functions
        function openModal() {
            const modal = document.getElementById('modalOverlay');
            const content = document.getElementById('modalContent');

            modal.classList.remove('hidden');
            setTimeout(() => {
                modal.classList.add('opacity-100');
                content.classList.add('scale-100');
                content.classList.remove('scale-95');
            }, 10);

            // Set default date
            document.getElementById('tanggalMasuk').value = new Date().toISOString().split('T')[0];

            // Focus first input
            setTimeout(() => {
                document.getElementById('namaObat').focus();
            }, 300);
        }

        function closeModal() {
            const modal = document.getElementById('modalOverlay');
            const content = document.getElementById('modalContent');

            modal.classList.remove('opacity-100');
            content.classList.add('scale-95');
            content.classList.remove('scale-100');

            setTimeout(() => {
                modal.classList.add('hidden');
                resetForm();
            }, 300);
        }

        // Stock Formatting
        function formatStock(input) {
            let value = input.value.replace(/\D/g, ''); // Remove non-digits

            if (value === '') {
                input.value = '';
                document.getElementById('stockReal').value = '';
                updateSummary();
                return;
            }

            // Store real value
            document.getElementById('stockReal').value = value;

            // Format with thousands separator
            let formatted = parseInt(value).toLocaleString('id-ID');
            input.value = formatted;

            updateSummary();
        }

        // Expiry Date Check
        function checkExpiry() {
            const expiryDate = new Date(document.getElementById('kadarLuarsa').value);
            const today = new Date();
            const warning = document.getElementById('expiryWarning');
            const warningText = document.getElementById('expiryText');

            if (expiryDate) {
                const diffTime = expiryDate - today;
                const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

                warning.classList.remove('hidden');

                if (diffDays < 0) {
                    warning.className = 'text-xs mt-1 text-red-600 font-medium';
                    warningText.textContent = 'Obat sudah kadaluarsa!';
                } else if (diffDays <= 30) {
                    warning.className = 'text-xs mt-1 text-orange-600 font-medium';
                    warningText.textContent = `Akan kadaluarsa dalam ${diffDays} hari`;
                } else if (diffDays <= 90) {
                    warning.className = 'text-xs mt-1 text-yellow-600 font-medium';
                    warningText.textContent = `Kadaluarsa dalam ${diffDays} hari`;
                } else {
                    warning.className = 'text-xs mt-1 text-green-600 font-medium';
                    warningText.textContent = `Masih ${diffDays} hari lagi`;
                }
            } else {
                warning.classList.add('hidden');
            }
        }

        // Update Summary
        function updateSummary() {
            const namaObat = document.getElementById('namaObat').value;
            const jenisObat = document.getElementById('jenisObat').value;
            const stockDisplay = document.getElementById('stockObatDisplay').value;
            const tanggalMasuk = document.getElementById('tanggalMasuk').value;
            const kadarLuarsa = document.getElementById('kadarLuarsa').value;
            const bentukObat = document.getElementById('bentukObat').value;
            const dosisKekuatan = document.getElementById('dosisKekuatan').value;
            const dosisSatuan = document.getElementById('dosisSatuan').value;
            const dosisFrekuensi = document.getElementById('dosisFrekuensi').value;

            // Check if any field has value
            const hasValue = namaObat || jenisObat || stockDisplay || tanggalMasuk ||
                kadarLuarsa || bentukObat || dosisKekuatan || dosisSatuan;

            const summaryCard = document.getElementById('summaryCard');
            const summaryContent = document.getElementById('summaryContent');

            if (hasValue) {
                summaryCard.classList.remove('hidden');

                let summaryHTML = '';

                if (namaObat) {
                    summaryHTML += `
                        <div class="flex items-center">
                            <i class="fas fa-capsules text-blue-500 mr-2"></i>
                            <span class="font-medium">Nama:</span>
                            <span class="ml-2">${namaObat}</span>
                        </div>
                    `;
                }

                if (jenisObat) {
                    summaryHTML += `
                        <div class="flex items-center">
                            <i class="fas fa-tags text-green-500 mr-2"></i>
                            <span class="font-medium">Jenis:</span>
                            <span class="ml-2">${jenisObat}</span>
                        </div>
                    `;
                }

                if (stockDisplay) {
                    summaryHTML += `
                        <div class="flex items-center">
                            <i class="fas fa-boxes text-purple-500 mr-2"></i>
                            <span class="font-medium">Stok:</span>
                            <span class="ml-2">${stockDisplay}</span>
                        </div>
                    `;
                }

                if (bentukObat) {
                    summaryHTML += `
                        <div class="flex items-center">
                            <i class="fas fa-shapes text-teal-500 mr-2"></i>
                            <span class="font-medium">Bentuk:</span>
                            <span class="ml-2">${bentukObat}</span>
                        </div>
                    `;
                }

                if (dosisKekuatan && dosisSatuan) {
                    const dosisFull = `${dosisKekuatan} ${dosisSatuan}${dosisFrekuensi ? ', ' + dosisFrekuensi : ''}`;
                    summaryHTML += `
                        <div class="flex items-center">
                            <i class="fas fa-prescription-bottle text-orange-500 mr-2"></i>
                            <span class="font-medium">Dosis:</span>
                            <span class="ml-2">${dosisFull}</span>
                        </div>
                    `;
                }

                if (tanggalMasuk) {
                    const formattedDate = new Date(tanggalMasuk).toLocaleDateString('id-ID');
                    summaryHTML += `
                        <div class="flex items-center">
                            <i class="fas fa-calendar-plus text-indigo-500 mr-2"></i>
                            <span class="font-medium">Tgl Masuk:</span>
                            <span class="ml-2">${formattedDate}</span>
                        </div>
                    `;
                }

                if (kadarLuarsa) {
                    const formattedExpiry = new Date(kadarLuarsa).toLocaleDateString('id-ID');
                    summaryHTML += `
                        <div class="flex items-center">
                            <i class="fas fa-exclamation-triangle text-red-500 mr-2"></i>
                            <span class="font-medium">Kadaluarsa:</span>
                            <span class="ml-2">${formattedExpiry}</span>
                        </div>
                    `;
                }

                summaryContent.innerHTML = summaryHTML;
            } else {
                summaryCard.classList.add('hidden');
            }
        }

        function resetForm() {
            document.getElementById('obatForm').reset();
            document.getElementById('stockReal').value = '';
            document.getElementById('expiryWarning').classList.add('hidden');
            document.getElementById('summaryCard').classList.add('hidden');

            document.getElementById('tanggalMasuk').value = new Date().toISOString().split('T')[0];
        }

        // document.getElementById('obatForm').addEventListener('submit', function(e) {
        //     e.preventDefault();
        //     const formData = new FormData(this);
        //     const data = {};

        //     for (let [key, value] of formData.entries()) {
        //         data[key] = value;
        //     }

        //     data.stock_obat = document.getElementById('stockReal').value;

        //     console.log('Data Obat:', data);

        //     alert('Data obat berhasil disimpan!');

        //     closeModal();
        // });

        // Close modal on overlay click
        document.getElementById('modalOverlay').addEventListener('click', function(e) {
            if (e.target === this) {
                closeModal();
            }
        });

        // Close modal on ESC key
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('modalOverlay');
                if (!modal.classList.contains('hidden')) {
                    closeModal();
                }
            }
        });
    </script>
    <script>
        // Select All Checkbox
        document.getElementById('select-all').addEventListener('change', function() {
            const checkboxes = document.querySelectorAll('.row-checkbox');
            checkboxes.forEach(checkbox => {
                checkbox.checked = this.checked;
            });
        });

        // Delete Modal
        const deleteModal = document.getElementById('deleteModal');
        const deleteForm = document.getElementById('deleteForm');
        const deleteName = document.getElementById('delete-name');
        const confirmDelete = document.getElementById('confirmDelete');
        const cancelDelete = document.getElementById('cancelDelete');

        document.querySelectorAll('.delete-btn').forEach(button => {
            button.addEventListener('click', function() {
                const id = this.dataset.id;
                const name = this.dataset.name;

                deleteName.textContent = name;
                deleteForm.action = `{{ url('stock/delete') }}/${id}`;
                deleteModal.classList.remove('hidden');
            });
        });

        confirmDelete.addEventListener('click', function() {
            deleteForm.submit();
        });

        cancelDelete.addEventListener('click', function() {
            deleteModal.classList.add('hidden');
        });

        // Close modal when clicking outside
        deleteModal.addEventListener('click', function(e) {
            if (e.target === deleteModal) {
                deleteModal.classList.add('hidden');
            }
        });

        // Auto-submit search form on Enter
        document.querySelector('input[name="search"]').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                this.form.submit();
            }
        });
    </script>
@endsection
