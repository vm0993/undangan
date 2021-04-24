<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvitationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invitations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('guest_id');
            $table->date('invitation_date');
            $table->string('title',170)->nullable();
            $table->time('time_start')->nullable();
            $table->integer('status')->default(0)->comment('1 Confirm Hadir, 2 Mungkin Hadir, 3 Tidak Hadir');
            $table->integer('realiaze_status')->default(0)->comment('1 Sudah Hadir Di Acara');
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
        Schema::dropIfExists('invitations');
    }
}
