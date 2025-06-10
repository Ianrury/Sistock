@extends('layouts.admin')

@section('title', 'Manajement edit - Admin Panel')
@section('page-title', 'Manajement edit')

@section('content')
    @include('sweetalert::alert')
    <div class="min-h-screen  py-8">
        <div class="container mx-auto px-4 max-w-4xl">
            <!-- Form Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <!-- Form Header -->
                <div class="bg-gradient-to-r from-blue-500 to-indigo-600 px-8 py-6">
                    <h2 class="text-xl font-semibold text-white flex items-center">
                        <i class="fas fa-user-cog mr-3"></i>
                        Edit Puskesmas
                    </h2>
                </div>

                <!-- Form Body -->
                <div class="p-8">
                    <form id="createAccountForm" action="{{ route('puskesmas.update' , $puskesmas->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')
                        <!-- Username Field -->
                        <div class="group">
                            <label for="nama" class="block text-sm font-semibold text-gray-700 mb-2">
                                Nama Puskesmas
                                <span class="text-red-500 ml-1">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none">
                                    <i class="fas fa-hospital text-gray-400"></i>
                                </div>
                                <input type="text" id="nama" name="nama" value="{{ old('nama', $puskesmas->nama) }}"
                                    class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 bg-gray-50 focus:bg-white @error('nama') border-red-500 @enderror"
                                    placeholder="Masukkan nama puskesmas" required>
                            </div>
                            @error('nama')
                                <div class="flex items-center mt-2 text-red-600">
                                    <i class="fas fa-exclamation-circle mr-2"></i>
                                    <span class="text-sm">{{ $message }}</span>
                                </div>
                            @enderror
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                            <a href="{{ route('puskesmas.index') }}"
                                class="inline-flex items-center px-6 py-3 border border-gray-300 rounded-xl text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500 transition-all duration-200">
                                <i class="fas fa-times mr-2"></i>
                                Batal
                            </a>

                            <button type="submit" id="submitBtn"
                                class="inline-flex items-center px-8 py-3 border border-transparent rounded-xl text-sm font-medium text-white bg-gradient-to-r from-blue-500 to-indigo-600 hover:from-blue-600 hover:to-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                                <i class="fas fa-save mr-2"></i>
                                <span class="loading-text">Perbarui Puskesmas</span>
                                <i class="fas fa-spinner fa-spin ml-2 hidden loading-spinner"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
