@extends('layouts.admin')

@section('title', 'Dashboard - Admin Panel')
@section('page-title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-6">
        <div
            class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <div class="w-3 h-8 bg-blue-500 rounded-full mr-3"></div>
                            <p class="text-sm font-semibold text-blue-600 uppercase tracking-wide">
                                Total Obat
                            </p>
                        </div>
                        <div class="text-3xl font-bold text-gray-800 mb-1">{{ $totalObat }}</div>
                        <p class="text-xs text-gray-500">Jumlah keseluruhan obat</p>
                    </div>
                    <div class="bg-blue-100 p-4 rounded-full">
                        <i class="fas fa-pills text-2xl text-blue-500"></i>
                    </div>
                </div>
            </div>
        </div>


        <!-- Hampir Kadaluarsa Card -->
        <div
            class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <div class="w-3 h-8 bg-yellow-500 rounded-full mr-3"></div>
                            <p class="text-sm font-semibold text-yellow-600 uppercase tracking-wide">
                                Hampir Kadaluarsa
                            </p>
                        </div>
                        <div class="text-3xl font-bold text-gray-800 mb-1">{{ $obatHampirKadaluarsa }}</div>
                        <p class="text-xs text-gray-500">Perlu perhatian segera</p>
                    </div>
                    <div class="bg-yellow-100 p-4 rounded-full">
                        <i class="fas fa-exclamation-triangle text-2xl text-yellow-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Stok Rendah Card -->
        <div
            class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <div class="w-3 h-8 bg-red-500 rounded-full mr-3"></div>
                            <p class="text-sm font-semibold text-red-600 uppercase tracking-wide">
                                Stok Rendah
                            </p>
                        </div>
                        <div class="text-3xl font-bold text-gray-800 mb-1">{{ $stokRendah }}</div>
                        <p class="text-xs text-gray-500">Butuh restok segera</p>
                    </div>
                    <div class="bg-red-100 p-4 rounded-full">
                        <i class="fas fa-chart-bar text-2xl text-red-500"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Obat Masuk Bulan Ini Card -->
        <div
            class="bg-white rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1">
            <div class="p-6">
                <div class="flex items-center justify-between">
                    <div class="flex-1">
                        <div class="flex items-center mb-2">
                            <div class="w-3 h-8 bg-green-500 rounded-full mr-3"></div>
                            <p class="text-sm font-semibold text-green-600 uppercase tracking-wide">
                                Masuk Bulan Ini
                            </p>
                        </div>
                        <div class="text-3xl font-bold text-gray-800 mb-1">{{ $obatBulanIni }}</div>
                        <p class="text-xs text-gray-500">Stok baru bulan ini</p>
                    </div>
                    <div class="bg-green-100 p-4 rounded-full">
                        <i class="fas fa-calendar-plus text-2xl text-green-500"></i>
                    </div>
                </div>
            </div>
        </div>

    </div>


    <!-- Chart Section -->
    <div class="row">
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Obat Masuk Per Bulan - {{ $selectedYear }}</h6>
                    <div class="dropdown no-arrow">
                        <select id="yearSelect" class="form-control form-control-sm" style="width: auto;">
                            @forelse($availableYears as $year)
                                <option value="{{ $year }}" {{ $year == $selectedYear ? 'selected' : '' }}>
                                    {{ $year }}</option>
                            @empty
                                <option value="{{ date('Y') }}">{{ date('Y') }}</option>
                            @endforelse
                        </select>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="obatChart" style="height: 320px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pie Chart -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Distribusi Jenis Obat</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-4 pb-2">
                        <canvas id="jenisObatChart" style="height: 245px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Charts Row -->
    <div class="row">
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Distribusi Bentuk Obat</h6>
                </div>
                <div class="card-body">
                    <div class="chart-bar">
                        <canvas id="bentukObatChart" style="height: 200px;"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Stok Obat Status</h6>
                </div>
                <div class="card-body">
                    <div class="chart-pie">
                        <canvas id="stokStatusChart" style="height: 200px;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Chart Configuration
            const chartConfig = {
                type: 'line',
                data: {
                    labels: {!! json_encode(array_column($obatPerBulan, 'month')) !!},
                    datasets: [{
                        label: 'Jumlah Obat Masuk',
                        data: {!! json_encode(array_column($obatPerBulan, 'count')) !!},
                        borderColor: '#4e73df',
                        backgroundColor: 'rgba(78, 115, 223, 0.1)',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.3,
                        pointBackgroundColor: '#4e73df',
                        pointBorderColor: '#ffffff',
                        pointBorderWidth: 2,
                        pointRadius: 5,
                        pointHoverRadius: 7
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: true,
                            position: 'top',
                        },
                        tooltip: {
                            mode: 'index',
                            intersect: false,
                            backgroundColor: 'rgba(0, 0, 0, 0.8)',
                            titleColor: '#fff',
                            bodyColor: '#fff'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: 'rgba(0, 0, 0, 0.1)'
                            },
                            ticks: {
                                stepSize: 1,
                                callback: function(value) {
                                    return Number.isInteger(value) ? value : '';
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false
                            }
                        }
                    }
                }
            };

            // Initialize main chart
            const ctx = document.getElementById('obatChart').getContext('2d');
            let obatChart = new Chart(ctx, chartConfig);

            // Year selector change handler
            document.getElementById('yearSelect').addEventListener('change', function() {
                const selectedYear = this.value;
                const url = new URL(window.location);
                url.searchParams.set('year', selectedYear);
                window.location.href = url.toString();
            });

            // Jenis Obat Chart Data (you can replace with real data from controller)
            const jenisObatData = {!! json_encode(
                $jenisObatData ?? [
                    'labels' => ['Tablet', 'Kapsul', 'Sirup', 'Salep', 'Injeksi'],
                    'data' => [30, 25, 20, 15, 10],
                ],
            ) !!};

            new Chart(document.getElementById('jenisObatChart'), {
                type: 'doughnut',
                data: {
                    labels: jenisObatData.labels,
                    datasets: [{
                        data: jenisObatData.data,
                        backgroundColor: [
                            '#4e73df',
                            '#1cc88a',
                            '#36b9cc',
                            '#f6c23e',
                            '#e74a3b'
                        ],
                        hoverBackgroundColor: [
                            '#2e59d9',
                            '#17a673',
                            '#2c9faf',
                            '#f4b942',
                            '#e02d1b'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom',
                            labels: {
                                padding: 20
                            }
                        }
                    }
                }
            });

            // Bentuk Obat Chart
            const bentukObatData = {!! json_encode(
                $bentukObatData ?? [
                    'labels' => ['Tablet', 'Kapsul', 'Cair', 'Salep'],
                    'data' => [45, 30, 20, 15],
                ],
            ) !!};

            new Chart(document.getElementById('bentukObatChart'), {
                type: 'bar',
                data: {
                    labels: bentukObatData.labels,
                    datasets: [{
                        label: 'Jumlah',
                        data: bentukObatData.data,
                        backgroundColor: '#4e73df',
                        borderColor: '#4e73df',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                stepSize: 1
                            }
                        }
                    }
                }
            });

            // Stok Status Chart
            const stokData = {!! json_encode([
                'labels' => ['Stok Normal', 'Stok Rendah', 'Stok Habis'],
                'data' => [$totalObat - $stokRendah, $stokRendah, 0],
            ]) !!};

            new Chart(document.getElementById('stokStatusChart'), {
                type: 'pie',
                data: {
                    labels: stokData.labels,
                    datasets: [{
                        data: stokData.data,
                        backgroundColor: [
                            '#1cc88a',
                            '#f6c23e',
                            '#e74a3b'
                        ]
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
@endpush
