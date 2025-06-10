<?php

namespace App\Http\Controllers;

use App\Models\Puskesmas;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PuskesmasController extends Controller
{
    public function index()
    {
        $puskesmas = Puskesmas::with('admin')->get();
        $totalPuskesmas = $puskesmas->count();
        return view('puskesmas.index', compact('puskesmas', 'totalPuskesmas'));
    }

    public function create()
    {
        return view('puskesmas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255|unique:puskesmas',
        ]);


        // cek nama puskesmas sudah ada
        $puskesmasExists = Puskesmas::where('nama', $request->nama_puskesmas)->exists();
        if ($puskesmasExists) {
            Alert::error('Error', 'Nama Puskesmas sudah digunakan.');
            return redirect()->back()->withInput();
        }

        // ambil id super admin dari session
        $superAdminId = auth()->guard('superadmin')->id();
        if (!$superAdminId) {
            Alert::error('Error', 'Anda harus login sebagai Super Admin.');
            return redirect()->route('login');
        }

        // tambahkan id super admin ke request
        $request->merge(['super_admin_id' => $superAdminId]);

        Puskesmas::create($request->all());

        Alert::success('Success', 'Data puskesmas berhasil ditambahkan.');
        return redirect()->back();
    }

    public function edit($id)
    {
        $puskesmas = Puskesmas::findOrFail($id);
        return view('puskesmas.edit', compact('puskesmas'));
    }

    public function update(Request $request, $id)
    {
        $puskesmas = Puskesmas::findOrFail($id);

        $request->validate([
            'nama' => 'required|string|max:255|unique:puskesmas,nama,' . $puskesmas->id,
        ]);

        $puskesmas->update($request->all());

        Alert::success('Success', 'Data puskesmas berhasil diperbarui.');
        return redirect()->back();
    }

    public function destroy($id)
    {
        $puskesmas = Puskesmas::findOrFail($id);
        $puskesmas->delete();

        return response()->json(['success' => true]);
    }

}