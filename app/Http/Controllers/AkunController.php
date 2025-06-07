<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\SuperAdmin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AkunController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $admins = Admin::where('super_admin_id', Auth::guard('superadmin')->id())->get();

        // total jumlah admin
        $totalAdmins = $admins->count();

        // terbaru pada bulan ini
        $newThisMonth = Admin::whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        return view('akun.index', compact('admins', 'totalAdmins', 'newThisMonth'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('akun.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'username' => 'required|string|unique:admins,username',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required_with:password|same:password',
        ]);

        $adminExists = Admin::where('username', $validated['username'])->exists();
        if ($adminExists) {
            Alert::error('Error', 'Username sudah digunakan.');
            return redirect()->back()->withInput();
        }

        $superAdmin = SuperAdmin::where('username', $validated['username'])->first();
        if ($superAdmin) {
            Alert::error('Error', 'Username tidak boleh sama dengan Super Admin.');
            return redirect()->back()->withInput();
        }

        if (Auth::guard('superadmin')->check()) {
            $validated['super_admin_id'] = Auth::guard('superadmin')->id();
        }

        $validated['password'] = Hash::make($validated['password']);

        Admin::create($validated);

        Alert::success('Success', 'Admin berhasil ditambahkan.');
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $admin = Admin::findOrFail($id);
        return view('admin.akun.show', compact('admin'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $admin = Admin::findOrFail($id);
        return view('akun.edit', compact('admin'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $admin = Admin::findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|string|unique:admins,username,' . $admin->id,
            'password' => 'nullable|string|min:6',
            'password_confirmation' => 'nullable|same:password',
        ]);

        // Cek apakah username yang dimasukkan sama dengan super admin
        $superAdmin = SuperAdmin::where('username', $validated['username'])->first();
        if ($superAdmin) {
            Alert::error('Error', 'Username tidak boleh sama dengan Super Admin.');
            return redirect()->back()->withInput();
        }

        // Jika password diisi, hash password baru
        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']); // supaya tidak menimpa password lama
        }

        $admin->update($validated);

        Alert::success('Success', 'Admin berhasil diperbarui.');
        return redirect()->back();
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $admin = Admin::findOrFail($id);
            $admin->delete();

            return response()->json([
                'success' => true,
                'message' => 'Admin berhasil dihapus.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus admin: ' . $e->getMessage()
            ], 500);
        }
    }
}
