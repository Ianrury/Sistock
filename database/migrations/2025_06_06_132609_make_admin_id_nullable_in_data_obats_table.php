<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class MakeAdminIdNullableInDataObatsTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('data_obats', function (Blueprint $table) {
            // Ubah kolom admin_id jadi nullable
            $table->unsignedBigInteger('admin_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('data_obats', function (Blueprint $table) {
            // Kembalikan kolom admin_id jadi tidak nullable
            $table->unsignedBigInteger('admin_id')->nullable(false)->change();
        });
    }
}
;
