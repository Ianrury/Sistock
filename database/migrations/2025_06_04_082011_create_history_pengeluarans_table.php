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
        Schema::create('history_pengeluarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('data_obat_id')->constrained('data_obats')->onDelete('cascade');
            $table->string('dari');
            $table->string('kepada');
            $table->date('tanggal_pengeluaran');
            $table->string('penerima');
            $table->integer('pengeluaran');
            $table->integer('sisa_stock');
            $table->date('tanggal');
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('history_pengeluarans');
    }
};
