<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\Puskesmas;
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
        // AMBIL DATA PUSKESMAS
        $puskesmas = Puskesmas::get();
        if ($puskesmas->isEmpty()) {
            Alert::error('Error', 'Anda harus membuat Puskesmas terlebih dahulu.');
            return redirect()->route('puskesmas.create');
        }
        return view('akun.create', compact('puskesmas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'username' => 'required|string|unique:admins,username',
            'password' => 'required|string|min:6',
            'puskesmas_id' => 'required',
            'password_confirmation' => 'required_with:password|same:password',
        ]);

        $existingAdmin = Admin::where('puskesmas_id', $validated['puskesmas_id'])->first();
        if ($existingAdmin) {
            Alert::error('Error', 'Puskesmas ini sudah memiliki admin.');
            return redirect()->back()->withInput();
        }


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
        $puskesmas = Puskesmas::get();
        if ($puskesmas->isEmpty()) {
            Alert::error('Error', 'Anda harus membuat Puskesmas terlebih dahulu.');
            return redirect()->route('puskesmas.create');
        }
        $admin = Admin::findOrFail($id);
        return view('akun.edit', compact('admin', 'puskesmas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $admin = Admin::findOrFail($id);

        $validated = $request->validate([
            'username' => 'required|string|unique:admins,username,' . $id,
            'password' => 'nullable|string|min:6',
            'puskesmas_id' => 'required|exists:puskesmas,id',
            'password_confirmation' => 'required_with:password|same:password',
        ]);

        $superAdmin = SuperAdmin::where('username', $validated['username'])->first();
        if ($superAdmin) {
            Alert::error('Error', 'Username tidak boleh sama dengan Super Admin.');
            return redirect()->back()->withInput();
        }

        $adminWithSamePuskesmas = Admin::where('puskesmas_id', $validated['puskesmas_id'])
            ->where('id', '!=', $admin->id)
            ->first();

        if ($adminWithSamePuskesmas) {
            Alert::error('Error', 'Puskesmas tersebut sudah memiliki admin.');
            return redirect()->back()->withInput();
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']); 
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
