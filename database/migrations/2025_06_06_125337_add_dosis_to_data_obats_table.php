<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDosisToDataObatsTable extends Migration
{
    public function up()
    {
        Schema::table('data_obats', function (Blueprint $table) {
            $table->string('dosis')->nullable()->after('satuan'); // Tambahkan kolom setelah 'satuan'
        });
    }

    public function down()
    {
        Schema::table('data_obats', function (Blueprint $table) {
            $table->dropColumn('dosis');
        });
    }
}
