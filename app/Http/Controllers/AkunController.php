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
    public function editUsername(Request $request)
    {
        try {
            $request->validate([
                'username' => 'required|string|unique:admins,username,' . Auth::guard('admin')->id(),
            ]);

            $admin = Auth::guard('superadmin')->user();
            $admin->username = $request->username;
            $admin->save();

            return response()->json([
                'success' => true,
                'message' => 'Username berhasil diperbarui.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui username'
            ], 500);
        }
    }

    public function editPassword(Request $request)
    {
        try {
            // Validasi input
            $request->validate([
                'current_password' => 'required|string',
                'new_password' => 'required|string|min:6',
                'confirm_password' => 'required|string|same:new_password',
            ]);

            $admin = Auth::guard('superadmin')->user();

            // Cek apakah current password benar
            if (!Hash::check($request->current_password, $admin->password)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kata sandi lama salah.'
                ], 422);
            }

            // Cek apakah new password sama dengan confirm password
            if ($request->new_password !== $request->confirm_password) {
                return response()->json([
                    'success' => false,
                    'message' => 'Konfirmasi kata sandi tidak sama.'
                ], 422);
            }

            // Update password
            $admin->password = Hash::make($request->new_password);
            $admin->save();

            return response()->json([
                'success' => true,
                'message' => 'Kata sandi berhasil diperbarui.'
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak valid',
                'errors' => $e->errors()
            ], 422);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat memperbarui kata sandi'
            ], 500);
        }
    }
}
