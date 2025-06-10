<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\DataObat;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(Request $request)
    {
        // ambil nama puskesmas dari admin yang sedang login
        $admin = Auth::guard('admin')->user();
        $puskesmas = $admin->puskesmas->nama;

        $admin = Auth::guard('admin')->user();
        $adminId = $admin->id;
        $selectedYear = $request->get('year', date('Y'));

        $obatPerBulan = $this->getObatDataPerMonth($selectedYear, $adminId);
        $availableYears = $this->getAvailableYears($adminId);

        if (empty($availableYears)) {
            $availableYears = [date('Y')];
        }

        $totalObat = DataObat::whereNull('deleted_at')
            ->where('admin_id', $adminId)
            ->count();

        $obatHampirKadaluarsa = DataObat::whereNull('deleted_at')
            ->where('admin_id', $adminId)
            ->whereDate('tanggal_kadaluarsa', '<=', Carbon::now()->addDays(30))
            ->count();

        $stokRendah = DataObat::whereNull('deleted_at')
            ->where('admin_id', $adminId)
            ->where('stock_obat', '<=', 10)
            ->count();

        $obatBulanIni = DataObat::whereNull('deleted_at')
            ->where('admin_id', $adminId)
            ->whereMonth('tanggal_masuk', Carbon::now()->month)
            ->whereYear('tanggal_masuk', Carbon::now()->year)
            ->count();

        $jenisObatData = $this->getJenisObatData($adminId);
        $bentukObatData = $this->getBentukObatData($adminId);

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
            'puskesmas' => $puskesmas
        ];

        return view('admin.dashboard', $data);
    }

    private function getObatDataPerMonth($year, $adminId)
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
            $count = DataObat::whereNull('deleted_at')
                ->where('admin_id', $adminId)
                ->whereYear('tanggal_masuk', $year)
                ->whereMonth('tanggal_masuk', $monthNum)
                ->count();

            $data[] = [
                'month' => $monthName,
                'count' => $count,
                'monthNum' => $monthNum
            ];
        }

        return $data;
    }

    private function getAvailableYears($adminId)
    {
        return DataObat::whereNull('deleted_at')
            ->where('admin_id', $adminId)
            ->whereNotNull('tanggal_masuk')
            ->selectRaw('YEAR(tanggal_masuk) as year')
            ->distinct()
            ->orderBy('year', 'desc')
            ->pluck('year')
            ->filter()
            ->toArray();
    }

    public function getChartData(Request $request)
    {
        $admin = Auth::guard('admin')->user();
        $adminId = $admin->id;
        $year = $request->get('year', date('Y'));
        $data = $this->getObatDataPerMonth($year, $adminId);

        return response()->json([
            'labels' => array_column($data, 'month'),
            'data' => array_column($data, 'count'),
            'year' => $year
        ]);
    }

    private function getJenisObatData($adminId)
    {
        $jenisObat = DataObat::whereNull('deleted_at')
            ->where('admin_id', $adminId)
            ->whereNotNull('jenis_obat')
            ->selectRaw('jenis_obat, COUNT(*) as total')
            ->groupBy('jenis_obat')
            ->orderBy('total', 'desc')
            ->limit(5)
            ->get();

        return [
            'labels' => $jenisObat->pluck('jenis_obat')->toArray(),
            'data' => $jenisObat->pluck('total')->toArray()
        ];
    }

    private function getBentukObatData($adminId)
    {
        $bentukObat = DataObat::whereNull('deleted_at')
            ->where('admin_id', $adminId)
            ->whereNotNull('bentuk')
            ->selectRaw('bentuk, COUNT(*) as total')
            ->groupBy('bentuk')
            ->orderBy('total', 'desc')
            ->get();

        return [
            'labels' => $bentukObat->pluck('bentuk')->toArray(),
            'data' => $bentukObat->pluck('total')->toArray()
        ];
    }
}