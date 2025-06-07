<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DataObat;
use Illuminate\Http\Request;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $selectedYear = $request->get('year', date('Y'));

        $obatPerBulan = $this->getObatDataPerMonth($selectedYear);

        $availableYears = $this->getAvailableYears();

        if (empty($availableYears)) {
            $availableYears = [date('Y')];
        }

        // Pastikan hanya menghitung data yang tidak di soft delete
        $totalObat = DataObat::whereNull('deleted_at')->count();

        $obatHampirKadaluarsa = DataObat::whereNull('deleted_at')
            ->whereDate('tanggal_kadaluarsa', '<=', Carbon::now()->addDays(30))
            ->count();

        $stokRendah = DataObat::whereNull('deleted_at')
            ->where('stock_obat', '<=', 10)
            ->count();

        $obatBulanIni = DataObat::whereNull('deleted_at')
            ->whereMonth('tanggal_masuk', Carbon::now()->month)
            ->whereYear('tanggal_masuk', Carbon::now()->year)
            ->count();

        // Data untuk chart jenis obat
        $jenisObatData = $this->getJenisObatData();

        // Data untuk chart bentuk obat  
        $bentukObatData = $this->getBentukObatData();

        $data = [
            'title' => 'Dashboard',
            'active' => 'dashboard',
            'obatPerBulan' => $obatPerBulan,
            'selectedYear' => $selectedYear,
            'availableYears' => $availableYears,
            'totalObat' => $totalObat,
            'obatHampirKadaluarsa' => $obatHampirKadaluarsa,
            'stokRendah' => $stokRendah,
            'obatBulanIni' => $obatBulanIni,
            'jenisObatData' => $jenisObatData,
            'bentukObatData' => $bentukObatData,
        ];

        return view('admin.dashboard', $data);
    }

    private function getObatDataPerMonth($year)
    {
        $months = [
            1 => 'Januari',
            2 => 'Februari',
            3 => 'Maret',
            4 => 'April',
            5 => 'Mei',
            6 => 'Juni',
            7 => 'Juli',
            8 => 'Agustus',
            9 => 'September',
            10 => 'Oktober',
            11 => 'November',
            12 => 'Desember'
        ];

        $data = [];

        foreach ($months as $monthNum => $monthName) {
            // Menggunakan tanggal_masuk dan exclude soft deleted
            $count = DataObat::whereNull('deleted_at')
                ->whereRaw('YEAR(tanggal_masuk) = ?', [$year])
                ->whereRaw('MONTH(tanggal_masuk) = ?', [$monthNum])
                ->count();

            $data[] = [
                'month' => $monthName,
                'count' => $count,
                'monthNum' => $monthNum
            ];
        }

        return $data;
    }

    private function getAvailableYears()
    {
        // Menggunakan tanggal_masuk untuk mendapatkan tahun yang tersedia, exclude soft deleted
        return DataObat::whereNull('deleted_at')
            ->selectRaw('YEAR(tanggal_masuk) as year')
            ->whereNotNull('tanggal_masuk')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->filter() // Remove null values
            ->toArray();
    }

    // API endpoint untuk AJAX
    public function getChartData(Request $request)
    {
        $year = $request->get('year', date('Y'));
        $data = $this->getObatDataPerMonth($year);

        return response()->json([
            'labels' => array_column($data, 'month'),
            'data' => array_column($data, 'count'),
            'year' => $year
        ]);
    }

    private function getJenisObatData()
    {
        $jenisObat = DataObat::whereNull('deleted_at')
            ->selectRaw('jenis_obat, COUNT(*) as total')
            ->whereNotNull('jenis_obat')
            ->groupBy('jenis_obat')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        return [
            'labels' => $jenisObat->pluck('jenis_obat')->toArray(),
            'data' => $jenisObat->pluck('total')->toArray()
        ];
    }

    private function getBentukObatData()
    {
        $bentukObat = DataObat::whereNull('deleted_at')
            ->selectRaw('bentuk, COUNT(*) as total')
            ->whereNotNull('bentuk')
            ->groupBy('bentuk')
            ->orderBy('total', 'desc')
            ->get();

        return [
            'labels' => $bentukObat->pluck('bentuk')->toArray(),
            'data' => $bentukObat->pluck('total')->toArray()
        ];
    }
}