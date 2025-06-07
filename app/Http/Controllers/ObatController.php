<?php

namespace App\Http\Controllers;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\DataObat;
use App\Models\HistoryPengeluaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ObatController extends Controller
{
    public function index(Request $request)
    {
        $query = DataObat::query();

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('nama_obat', 'like', '%' . $search . '%')
                    ->orWhere('jenis_obat', 'like', '%' . $search . '%')
                    ->orWhere('bentuk', 'like', '%' . $search . '%')
                    ->orWhere('isi_kemasan', 'like', '%' . $search . '%');
            });
        }

        $query->orderBy('tanggal_masuk', 'desc');

        $obats = $query->paginate(10);

        $obats->appends($request->only('search'));

        // jumlah seluruh obat
        $totalObat = DataObat::count();
        // jumlah obat yang akan habis
        $lowStock = DataObat::where('stock_obat', '<=', 10)->count();
        // jumlah obat yang habis
        $outOfStock = DataObat::where('stock_obat', 0)->count();

        // yang baru pada bulan ini
        $newThisMonth = DataObat::whereMonth('tanggal_masuk', now()->month)
            ->whereYear('tanggal_masuk', now()->year)
            ->count();

        return view('stok.index', compact('obats', 'totalObat', 'lowStock', 'outOfStock', 'newThisMonth'));
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'jenis_obat' => 'required|string|max:255',
            'stock_obat' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after:tanggal_masuk',
            'bentuk' => 'required|string|max:100',
            'isi_kemasan' => 'required|string|max:100',
        ]);


        if (Auth::guard('superadmin')->check()) {
            $validated['superadmin_id'] = Auth::guard('superadmin')->id();
        } elseif (Auth::guard('admin')->check()) {
            $validated['admin_id'] = Auth::guard('admin')->id();
        }


        DataObat::create($validated);

        Alert::success('Hore!', 'Data obat berhasil ditambahkan!')->persistent(true);
        return redirect()->back();
    }

    public function show(string $id)
    {
        $obat = DataObat::findOrFail($id);
        $history = HistoryPengeluaran::select('history_pengeluarans.*', 'data_obats.tanggal_kadaluarsa')
            ->join('data_obats', 'history_pengeluarans.data_obat_id', '=', 'data_obats.id')
            ->where('data_obat_id', $id)
            ->get();
        return view('stok.show', compact('obat', 'history'));
    }

    public function edit(string $id)
    {
        $obat = DataObat::findOrFail($id);
        return view('stok.edit', compact('obat'));
    }

    public function update(Request $request, string $id)
    {
        $obat = DataObat::findOrFail($id);

        $validated = $request->validate([
            'nama_obat' => 'required|string|max:255',
            'jenis_obat' => 'required|string|max:255',
            'stock_obat' => 'required|integer|min:0',
            'satuan' => 'required|string|max:50',
            'tanggal_masuk' => 'required|date',
            'tanggal_kadaluarsa' => 'required|date|after:tanggal_masuk',
            'bentuk' => 'required|string|max:100',
            'isi_kemasan' => 'required|string|max:100',
        ]);

        $obat->update($validated);

        Alert::success('Sukses!', 'Data obat berhasil diperbarui!')->persistent(true);
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        $obat = DataObat::findOrFail($id);
        $obat->delete();

        Alert::success('Sukses!', 'Data obat berhasil dihapus!')->persistent(true);
        return redirect()->back();
    }
}