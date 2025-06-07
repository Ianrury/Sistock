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
        Schema::table('data_obats', function (Blueprint $table) {
            $table->unsignedBigInteger('superadmin_id')->nullable()->after('admin_id');

            $table->foreign('superadmin_id')
                ->references('id')
                ->on('super_admins')
                ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('data_obats', function (Blueprint $table) {
            $table->dropForeign(['superadmin_id']);
            $table->dropColumn('superadmin_id');
        });
    }
};

