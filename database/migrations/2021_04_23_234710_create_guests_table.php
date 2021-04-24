<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGuestsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('guests', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name',50);
            $table->string('alamat1',130)->nullable();
            $table->string('alamat2',130)->nullable();
            $table->string('alamat3',130)->nullable();
            $table->string('no_telp',25)->nullable();
            $table->string('email',40)->nullable();
            $table->string('keterangan',230)->nullable();
            $table->integer('status')->default(0);
            $table->integer('user_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('guests');
    }
}
