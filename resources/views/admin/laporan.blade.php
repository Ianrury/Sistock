@extends('layouts.admin')
@section('title', 'Laporan - Admin Panel')
@section('page-title', 'Laporan Obat')

@section('content')
    <!-- Header Section -->
    <div class="mb-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Laporan Obat</h2>
                <p class="mt-2 text-sm text-gray-700">Laporan Stok dan Data Obat Berdasarkan Periode</p>
            </div>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6 mb-6">
        <h3 class="text-lg font-semibold text-gray-900 mb-4">Filter Laporan</h3>

        <form action="{{ route('laporan.filter') }}" method="POST"
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
            @csrf
            <!-- Tanggal Mulai -->
            <div>
                <label for="tanggal_mulai" class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Mulai
                </label>
                <input type="date" id="tanggal_mulai" name="tanggal_mulai"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            </div>

            <!-- Tanggal Akhir -->
            <div>
                <label for="tanggal_akhir" class="block text-sm font-medium text-gray-700 mb-2">
                    Tanggal Akhir
                </label>
                <input type="date" id="tanggal_akhir" name="tanggal_akhir"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
            </div>

            <!-- Filter Tahun -->
            <div>
                <label for="tahun" class="block text-sm font-medium text-gray-700 mb-2">
                    Tahun
                </label>
                <select id="tahun" name="tahun"
                    class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <option value="">Semua Tahun</option>
                </select>
            </div>

            <!-- Tombol Filter -->
            <div class="flex items-end">
                <button type="submit"
                    class="w-full bg-blue-600 hover:bg-blue-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center justify-center">
                    <i class="fas fa-search mr-2"></i>
                    Filter Data
                </button>
            </div>
        </form>
    </div>

    <!-- Action Buttons -->
    <div class="mb-6 flex flex-wrap gap-3">
        <button id="exportExcel"
            class="bg-green-600 hover:bg-green-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
            <i class="fas fa-file-excel mr-2"></i>
            Export Excel
        </button>
        <button id="exportPDF"
            class="bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200 flex items-center">
            <i class="fas fa-file-pdf mr-2"></i>
            Export PDF
        </button>
    </div>


    <!-- Table Section -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h3 class="text-lg font-semibold text-gray-900">Data Laporan Obat</h3>
        </div>

        <div class="container mx-auto px-4">
            <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
                    <!-- Search -->
                    <div class="flex-1 max-w-md">
                        <div class="relative">
                            <input type="text" placeholder="Cari nama obat..."
                                class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500"
                                id="searchInput">
                            <i class="fas fa-search absolute left-3 top-3 text-gray-400"></i>
                        </div>
                    </div>

                    <!-- Per Page Selection -->
                    <div class="flex items-center gap-2">
                        <label class="text-sm text-gray-700">Tampilkan:</label>
                        <select id="perPageSelect"
                            class="border border-gray-300 rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:border-blue-500">
                            <option value="10">10</option>
                            <option value="20">20</option>
                            <option value="100">100</option>
                        </select>
                        <label class="text-sm text-gray-700">per halaman</label>
                    </div>
                </div>
            </div>

            <!-- Table -->
            <div class="bg-white rounded-lg shadow-md overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    No
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Nama Obat
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Jenis Obat
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Stok
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Masuk
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Tanggal Kadaluarsa
                                </th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Bentuk & Satuan
                                </th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200" id="tableBody">
                            <!-- Data akan dimuat di sini -->
                        </tbody>
                    </table>
                </div>

                <!-- Pagination -->
                <div class="bg-white px-4 py-3 flex items-center justify-between border-t border-gray-200 sm:px-6">
                    <div class="flex-1 flex justify-between sm:hidden">
                        <button id="prevMobile"
                            class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                            Previous
                        </button>
                        <button id="nextMobile"
                            class="ml-3 relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                            Next
                        </button>
                    </div>
                    <div class="hidden sm:flex-1 sm:flex sm:items-center sm:justify-between">
                        <div>
                            <p class="text-sm text-gray-700" id="paginationInfo">
                                Menampilkan <span class="font-medium" id="showingStart">1</span> sampai <span
                                    class="font-medium" id="showingEnd">10</span> dari <span class="font-medium"
                                    id="totalRecords">0</span> data
                            </p>
                        </div>
                        <div>
                            <nav class="relative z-0 inline-flex rounded-md shadow-sm -space-x-px" aria-label="Pagination"
                                id="paginationNav">
                                <!-- Pagination buttons akan dimuat di sini -->
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Sample data - ganti dengan data dari server
        const sampleData = @json($obat);

        let currentData = [...sampleData];
        let currentPage = 1;
        let itemsPerPage = 10;
        let filteredData = [...sampleData];

        function formatDate(dateString) {
            const date = new Date(dateString);
            return date.toLocaleDateString('id-ID', {
                day: 'numeric',
                month: 'short',
                year: 'numeric'
            });
        }

        function getStatusBadge(tanggalKadaluarsa, stock) {
            const today = new Date();
            const expiredDate = new Date(tanggalKadaluarsa);
            const diffTime = expiredDate - today;
            const diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24));

            if (stock === 0) {
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">Habis</span>';
            } else if (diffDays < 30) {
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">Hampir Kadaluarsa</span>';
            } else if (stock < 1000) {
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-orange-100 text-orange-800">Stok Menipis</span>';
            } else {
                return '<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">Tersedia</span>';
            }
        }

        function renderTable() {
            const tbody = document.getElementById('tableBody');
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const pageData = filteredData.slice(startIndex, endIndex);

            tbody.innerHTML = pageData.map((item, index) => `
                <tr class="hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${startIndex + index + 1}</td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="text-sm font-medium text-gray-900">${item.nama_obat}</div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.jenis_obat}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.stock_obat.toLocaleString('id-ID')}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${formatDate(item.tanggal_masuk)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">${formatDate(item.tanggal_kadaluarsa)}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${item.bentuk} - ${item.isi_kemasan} ${item.satuan}</td>
                </tr>
            `).join('');

            updatePagination();
        }

        function updatePagination() {
            const totalPages = Math.ceil(filteredData.length / itemsPerPage);
            const startItem = (currentPage - 1) * itemsPerPage + 1;
            const endItem = Math.min(currentPage * itemsPerPage, filteredData.length);

            // Update info text
            document.getElementById('showingStart').textContent = startItem;
            document.getElementById('showingEnd').textContent = endItem;
            document.getElementById('totalRecords').textContent = filteredData.length;

            // Update pagination buttons
            const paginationNav = document.getElementById('paginationNav');
            let paginationHTML = '';

            // Previous button
            paginationHTML += `
                <button ${currentPage === 1 ? 'disabled' : ''} 
                        onclick="changePage(${currentPage - 1})"
                        class="relative inline-flex items-center px-2 py-2 rounded-l-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-chevron-left"></i>
                </button>
            `;

            // Page numbers
            for (let i = 1; i <= totalPages; i++) {
                if (i === currentPage) {
                    paginationHTML += `
                        <button class="z-10 bg-blue-50 border-blue-500 text-blue-600 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                            ${i}
                        </button>
                    `;
                } else {
                    paginationHTML += `
                        <button onclick="changePage(${i})"
                                class="bg-white border-gray-300 text-gray-500 hover:bg-gray-50 relative inline-flex items-center px-4 py-2 border text-sm font-medium">
                            ${i}
                        </button>
                    `;
                }
            }

            // Next button
            paginationHTML += `
                <button ${currentPage === totalPages ? 'disabled' : ''} 
                        onclick="changePage(${currentPage + 1})"
                        class="relative inline-flex items-center px-2 py-2 rounded-r-md border border-gray-300 bg-white text-sm font-medium text-gray-500 hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                    <i class="fas fa-chevron-right"></i>
                </button>
            `;

            paginationNav.innerHTML = paginationHTML;

            // Update mobile pagination
            document.getElementById('prevMobile').disabled = currentPage === 1;
            document.getElementById('nextMobile').disabled = currentPage === totalPages;
        }

        function changePage(page) {
            const totalPages = Math.ceil(filteredData.length / itemsPerPage);
            if (page >= 1 && page <= totalPages) {
                currentPage = page;
                renderTable();
            }
        }

        function changeItemsPerPage(newItemsPerPage) {
            itemsPerPage = newItemsPerPage;
            currentPage = 1;
            renderTable();
        }

        function filterData(searchTerm) {
            filteredData = sampleData.filter(item =>
                item.nama_obat.toLowerCase().includes(searchTerm.toLowerCase()) ||
                item.jenis_obat.toLowerCase().includes(searchTerm.toLowerCase())
            );
            currentPage = 1;
            renderTable();
        }

        // Event listeners
        document.getElementById('perPageSelect').addEventListener('change', function() {
            changeItemsPerPage(parseInt(this.value));
        });

        document.getElementById('searchInput').addEventListener('input', function() {
            filterData(this.value);
        });

        document.getElementById('prevMobile').addEventListener('click', function() {
            changePage(currentPage - 1);
        });

        document.getElementById('nextMobile').addEventListener('click', function() {
            changePage(currentPage + 1);
        });

        // Initialize
        renderTable();
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const tahunSelect = document.getElementById("tahun");
            const currentYear = new Date().getFullYear();

            for (let i = 0; i < 5; i++) {
                const year = currentYear - i;
                const option = document.createElement("option");
                option.value = year;
                option.textContent = year;
                tahunSelect.appendChild(option);
            }
        });
    </script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const exportExcelBtn = document.getElementById("exportExcel");
            const exportPDFBtn = document.getElementById("exportPDF");

            exportExcelBtn.addEventListener("click", function() {
                exportFile("excel");
            });

            exportPDFBtn.addEventListener("click", function() {
                exportFile("pdf");
            });

            function exportFile(type) {
                const tanggalMulai = document.getElementById("tanggal_mulai").value;
                const tanggalAkhir = document.getElementById("tanggal_akhir").value;
                const tahun = document.getElementById("tahun").value;

                let url = type === "excel" ? "{{ route('laporan.export.excel') }}" :
                    "{{ route('laporan.export.pdf') }}";

                // Tambahkan parameter ke URL
                const params = new URLSearchParams();
                if (tanggalMulai) params.append('tanggal_mulai', tanggalMulai);
                if (tanggalAkhir) params.append('tanggal_akhir', tanggalAkhir);
                if (tahun) params.append('tahun', tahun);

                // Redirect ke URL dengan query string
                window.location.href = `${url}?${params.toString()}`;
            }
        });
    </script>


@endsection
