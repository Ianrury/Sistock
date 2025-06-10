<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePuskesmasTable extends Migration
{
    public function up()
    {
        Schema::create('puskesmas', function (Blueprint $table) {
            $table->id();
            $table->string('nama');
            $table->unsignedBigInteger('super_admin_id');
            $table->timestamps();

            $table->foreign('super_admin_id')->references('id')->on('super_admins')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('puskesmas');
    }
}

