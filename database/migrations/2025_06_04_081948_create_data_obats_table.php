<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('data_obats', function (Blueprint $table) {
            $table->id();
            $table->string('nama_obat');
            $table->string('jenis_obat');
            $table->date('tanggal_kadaluarsa');
            $table->string('bentuk');
            $table->string('isi_kemasan');
            $table->date('tanggal_masuk');
            $table->integer('stock_obat');
            $table->string('satuan');
            $table->foreignId('admin_id')->constrained('admins')->onDelete('cascade');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_obats');
    }
};
