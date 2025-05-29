@extends('layouts.admin')

@section('title', 'Manajement Akun - Admin Panel')
@section('page-title', 'Manajement Akun')

@section('content')
    <!-- Header Section -->
    <div class="mb-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div>
                <h2 class="text-2xl font-bold text-gray-900">Manajement Akun</h2>
                <p class="mt-2 text-sm text-gray-700">Kelola Akun Pada sistem</p>
            </div>
            <div class="mt-4 sm:mt-0">
                <button
                    class="inline-flex items-center px-4 py-2 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-primary hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all duration-200">
                    <i class="fas fa-plus mr-2"></i>
                    Tambah Akun
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
                            <i class="fas fa-user text-blue-600 text-xl"></i>
                        </div>
                    </div>
                    <div class="ml-4 flex-1">
                        <dl>
                            <dt class="text-sm font-medium text-gray-500 truncate">Total Products</dt>
                            <dd class="text-2xl font-bold text-gray-900">156</dd>
                        </dl>
                    </div>
                </div>
                <div class="mt-4 flex items-center text-sm">
                    <span class="text-green-600 font-medium">12 new this month</span>
                </div>
            </div>
        </div>
    </div>

    <div class="bg-white shadow-lg rounded-xl border border-gray-100 overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-gray-900">Data Akun</h3>
                <div class="flex space-x-2">
                    <button
                        class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <i class="fas fa-download mr-2"></i>
                        Export
                    </button>
                    <button
                        class="inline-flex items-center px-3 py-2 border border-gray-300 rounded-lg text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary">
                        <i class="fas fa-filter mr-2"></i>
                        Filter
                    </button>
                </div>
            </div>
            <!-- Search Bar -->
            <div class="relative">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <i class="fas fa-search text-gray-400"></i>
                </div>
                <input type="text" id="searchInput" placeholder="Cari username..."
                    class="block w-full pl-10 pr-3 py-2 border border-gray-300 rounded-lg leading-5 bg-white placeholder-gray-500 focus:outline-none focus:placeholder-gray-400 focus:ring-1 focus:ring-primary focus:border-primary">
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Username
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Dibuat
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody id="accountTableBody" class="bg-white divide-y divide-gray-200">
                    <!-- Data will be populated by JavaScript -->
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <div class="bg-white px-6 py-3 border-t border-gray-200 sm:px-6">
            <div class="flex items-center justify-between">
                <div class="flex items-center">
                    <p class="text-sm text-gray-700">
                        Showing <span id="showingStart" class="font-medium">1</span> to <span id="showingEnd"
                            class="font-medium">5</span> of <span id="totalResults" class="font-medium">6</span> results
                    </p>
                </div>
                <div class="flex items-center space-x-2">
                    <button id="prevBtn"
                        class="relative inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-500 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        <i class="fas fa-chevron-left mr-1"></i>
                        Previous
                    </button>
                    <div id="pageNumbers" class="flex items-center space-x-2">
                        <!-- Page numbers will be populated by JavaScript -->
                    </div>
                    <button id="nextBtn"
                        class="relative inline-flex items-center px-3 py-2 border border-gray-300 text-sm font-medium rounded-lg text-gray-500 bg-white hover:bg-gray-50 disabled:opacity-50 disabled:cursor-not-allowed">
                        Next
                        <i class="fas fa-chevron-right ml-1"></i>
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Dummy data
        const accountsData = [{
                id: 1,
                username: 'admin123',
                created: '2024-01-15'
            },
            {
                id: 2,
                username: 'user_john',
                created: '2024-02-20'
            },
            {
                id: 3,
                username: 'manager_sarah',
                created: '2024-03-10'
            },
            {
                id: 4,
                username: 'employee_mike',
                created: '2024-03-25'
            },
            {
                id: 5,
                username: 'guest_user',
                created: '2024-04-05'
            },
            {
                id: 6,
                username: 'supervisor_alex',
                created: '2024-04-18'
            }
        ];

        let filteredData = [...accountsData];
        let currentPage = 1;
        const itemsPerPage = 5;

        function renderTable() {
            const startIndex = (currentPage - 1) * itemsPerPage;
            const endIndex = startIndex + itemsPerPage;
            const currentData = filteredData.slice(startIndex, endIndex);

            const tbody = document.getElementById('accountTableBody');
            tbody.innerHTML = '';

            currentData.forEach((account, index) => {
                const globalIndex = startIndex + index + 1;
                const row = `
                    <tr class="hover:bg-gray-50 transition-colors">
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${globalIndex}</td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="flex items-center">
                                <div class="flex-shrink-0 h-10 w-10">
                                    <div class="h-10 w-10 rounded-full bg-blue-100 flex items-center justify-center">
                                        <i class="fas fa-user text-blue-600"></i>
                                    </div>
                                </div>
                                <div class="ml-3">
                                    <div class="text-sm font-medium text-gray-900">${account.username}</div>
                                </div>
                            </div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">${formatDate(account.created)}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <div class="flex space-x-2">
                                <button onclick="editAccount(${account.id})" class="text-primary hover:text-blue-700 p-2 rounded hover:bg-blue-50 transition-colors">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button onclick="deleteAccount(${account.id})" class="text-red-600 hover:text-red-700 p-2 rounded hover:bg-red-50 transition-colors">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                `;
                tbody.innerHTML += row;
            });

            updatePaginationInfo();
        }

        function formatDate(dateString) {
            const options = {
                year: 'numeric',
                month: 'long',
                day: 'numeric'
            };
            return new Date(dateString).toLocaleDateString('id-ID', options);
        }

        function updatePaginationInfo() {
            const totalPages = Math.ceil(filteredData.length / itemsPerPage);
            const startIndex = (currentPage - 1) * itemsPerPage + 1;
            const endIndex = Math.min(currentPage * itemsPerPage, filteredData.length);

            document.getElementById('showingStart').textContent = filteredData.length > 0 ? startIndex : 0;
            document.getElementById('showingEnd').textContent = endIndex;
            document.getElementById('totalResults').textContent = filteredData.length;

            // Update buttons
            document.getElementById('prevBtn').disabled = currentPage === 1;
            document.getElementById('nextBtn').disabled = currentPage === totalPages || totalPages === 0;

            // Update page numbers
            const pageNumbersContainer = document.getElementById('pageNumbers');
            pageNumbersContainer.innerHTML = '';

            for (let i = 1; i <= totalPages; i++) {
                const button = document.createElement('button');
                button.className = `relative inline-flex items-center px-4 py-2 border text-sm font-medium rounded-lg ${
                    i === currentPage 
                        ? 'border-transparent text-white bg-primary hover:bg-blue-700' 
                        : 'border-gray-300 text-gray-700 bg-white hover:bg-gray-50'
                }`;
                button.textContent = i;
                button.onclick = () => goToPage(i);
                pageNumbersContainer.appendChild(button);
            }
        }

        function goToPage(page) {
            currentPage = page;
            renderTable();
        }

        function searchAccounts() {
            const searchTerm = document.getElementById('searchInput').value.toLowerCase();
            filteredData = accountsData.filter(account =>
                account.username.toLowerCase().includes(searchTerm)
            );
            currentPage = 1;
            renderTable();
        }

        function editAccount(id) {
            const account = accountsData.find(acc => acc.id === id);
            alert(`Edit akun: ${account.username}`);
        }

        function deleteAccount(id) {
            const account = accountsData.find(acc => acc.id === id);
            if (confirm(`Hapus akun ${account.username}?`)) {
                // Remove from original data
                const originalIndex = accountsData.findIndex(acc => acc.id === id);
                if (originalIndex > -1) {
                    accountsData.splice(originalIndex, 1);
                }

                // Update filtered data
                searchAccounts();

                // Adjust current page if needed
                const totalPages = Math.ceil(filteredData.length / itemsPerPage);
                if (currentPage > totalPages && totalPages > 0) {
                    currentPage = totalPages;
                }

                renderTable();
            }
        }

        // Event listeners
        document.getElementById('searchInput').addEventListener('input', searchAccounts);
        document.getElementById('prevBtn').addEventListener('click', () => {
            if (currentPage > 1) {
                goToPage(currentPage - 1);
            }
        });
        document.getElementById('nextBtn').addEventListener('click', () => {
            const totalPages = Math.ceil(filteredData.length / itemsPerPage);
            if (currentPage < totalPages) {
                goToPage(currentPage + 1);
            }
        });

        // Initial render
        renderTable();
    </script>
@endsection
