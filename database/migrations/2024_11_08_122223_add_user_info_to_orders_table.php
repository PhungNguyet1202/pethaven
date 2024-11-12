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
        Schema::table('orders', function (Blueprint $table) {
            $table->string('user_fullname')->nullable(); // Thêm fullname
            $table->string('user_address')->nullable();  // Thêm address
            $table->string('user_phone')->nullable();    // Thêm phone
            $table->string('user_email')->nullable();    // Thêm email
        });
    }

    public function down()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->dropColumn(['user_fullname', 'user_address', 'user_phone', 'user_email']);
        });
    }

};
