<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\DataObat;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\StockObatExport;

class LaporanController extends Controller
{
    public function index()
    {
        $obat = DataObat::all();
        // dd($obat);
        return view('admin.laporan', compact('obat'));
    }

    public function filter(Request $request)
    {
        $query = DataObat::query();

        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
                $request->tanggal_mulai . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }

        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        $obat = $query->get();

        return view('admin.laporan', compact('obat'));
    }


    public function exportPDF(Request $request)
    {
        $query = DataObat::query();

        // Filter berdasarkan tanggal
        if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
            $query->whereBetween('created_at', [
                $request->tanggal_mulai . ' 00:00:00',
                $request->tanggal_akhir . ' 23:59:59'
            ]);
        }

        // Filter berdasarkan tahun
        if ($request->filled('tahun')) {
            $query->whereYear('created_at', $request->tahun);
        }

        $obat = $query->orderBy('nama_obat', 'asc')->get();

        // Data untuk dikirim ke view
        $data = [
            'obat' => $obat,
            'tanggal_mulai' => $request->tanggal_mulai,
            'tanggal_akhir' => $request->tanggal_akhir,
            'tahun' => $request->tahun
        ];

        $pdf = Pdf::loadView('exports.laporan_stock_pdf', $data);
        $pdf->setPaper('A4', 'landscape');

        $filename = 'laporan_stock_obat_' . date('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }

    public function exportExcel(Request $request)
    {
        try {
            $query = DataObat::query();

            if ($request->filled('tanggal_mulai') && $request->filled('tanggal_akhir')) {
                $query->whereBetween('created_at', [
                    $request->tanggal_mulai . ' 00:00:00',
                    $request->tanggal_akhir . ' 23:59:59'
                ]);
            }

            if ($request->filled('tahun')) {
                $query->whereYear('created_at', $request->tahun);
            }

            $obat = $query->orderBy('nama_obat', 'asc')->get();

            $data = [
                'obat' => $obat,
                'tanggal_mulai' => $request->tanggal_mulai,
                'tanggal_akhir' => $request->tanggal_akhir,
                'tahun' => $request->tahun
            ];

            $filename = 'laporan_stock_obat_' . date('Y-m-d_H-i-s') . '.xlsx';

            return Excel::download(
                new StockObatExport(
                    $obat,
                    $request->tanggal_mulai,
                    $request->tanggal_akhir,
                    $request->tahun
                ),
                $filename
            );

        } catch (\Exception $e) {
            return back()->with('error', 'Gagal mengexport data: ' . $e->getMessage());
        }
    }
}
