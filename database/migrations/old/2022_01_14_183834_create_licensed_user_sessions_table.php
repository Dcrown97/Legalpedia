<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicensedUserSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licensed_user_sessions', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->integer('license_id')->nullable()->references('id')->on('licenses')->onDelete('cascade');
            $table->string('session_no')->nullable();
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
        Schema::dropIfExists('licensed_user_sessions');
    }
}
