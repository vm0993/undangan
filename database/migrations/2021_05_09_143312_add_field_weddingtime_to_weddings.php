<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddFieldWeddingtimeToWeddings extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->time('wedding_time')->after('wedding_date')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('weddings', function (Blueprint $table) {
            $table->dropColumn('wedding_time');
        });
    }
}
