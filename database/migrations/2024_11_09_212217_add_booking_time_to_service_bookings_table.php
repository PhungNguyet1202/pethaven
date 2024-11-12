<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('servicebookings', function (Blueprint $table) {
            $table->time('booking_time')->after('booking_date');
        });
    }

    public function down()
    {
        Schema::table('servicebookings', function (Blueprint $table) {
            $table->dropColumn('booking_time');
        });
    }

};
