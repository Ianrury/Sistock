<?php

namespace App\Http\Controllers;

use App\Models\HistoryPengeluaran;
use App\Models\DataObat;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\DB;

class HistoryController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'data_obat_id' => 'required|exists:data_obats,id',
            'dari' => 'required|string|max:255',
            'kepada' => 'required|string|max:255',
            'penerima' => 'required|string|max:255',
            'pengeluaran' => 'required|integer|min:1',
        ]);

        $obat = DataObat::findOrFail($validated['data_obat_id']);

        if ($validated['pengeluaran'] > $obat->stock_obat) {
            Alert::error('Gagal', 'Jumlah pengeluaran melebihi stok.');
            return redirect()->back()->withInput();
        }

        // Kurangi stok dan simpan history
        $obat->stock_obat -= $validated['pengeluaran'];
        $obat->save();

        $history = new HistoryPengeluaran([
            'data_obat_id' => $validated['data_obat_id'],
            'dari' => $validated['dari'],
            'kepada' => $validated['kepada'],
            'tanggal_pengeluaran' => now(),
            'penerima' => $validated['penerima'],
            'pengeluaran' => $validated['pengeluaran'],
            'sisa_stock' => $obat->stock_obat,
            'tanggal' => now()->toDateString(),
        ]);

        $history->save();

        Alert::success('Berhasil', 'Pengeluaran obat berhasil disimpan.');
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $history = HistoryPengeluaran::findOrFail($id);
        $obat = DataObat::findOrFail($history->data_obat_id);

        // Tambahkan kembali stok yang sudah dikeluarkan
        $obat->stock_obat += $history->pengeluaran;
        $obat->save();

        $history->delete();

        Alert::success('Berhasil', 'Pengeluaran berhasil dihapus dan stok dikembalikan.');
        return redirect()->back();
    }

    public function exportPDF($id)
    {
        $history = DB::table('history_pengeluarans')
            ->join('data_obats', 'history_pengeluarans.data_obat_id', '=', 'data_obats.id')
            ->where('history_pengeluarans.data_obat_id', $id)
            ->select(
                'history_pengeluarans.*',
                'data_obats.tanggal_kadaluarsa',
                'data_obats.tanggal_kadaluarsa'
            )
            ->get();
        
        $obat = DataObat::findOrFail($id);

        $pdf = Pdf::loadView('exports.history_pengeluaran_pdf', compact('history', 'obat'));
        return $pdf->download('history_pengeluaran.pdf');
    }



}
