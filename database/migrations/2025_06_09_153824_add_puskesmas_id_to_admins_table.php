<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPuskesmasIdToAdminsTable extends Migration
{
    public function up()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->unsignedBigInteger('puskesmas_id')->unique()->nullable()->after('super_admin_id');

            $table->foreign('puskesmas_id')->references('id')->on('puskesmas')->onDelete('set null');
        });
    }

    public function down()
    {
        Schema::table('admins', function (Blueprint $table) {
            $table->dropForeign(['puskesmas_id']);
            $table->dropColumn('puskesmas_id');
        });
    }
}
