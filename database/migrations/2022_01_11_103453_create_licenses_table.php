<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLicensesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('licenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('package_id')->nullable()->references('id')->on('packages')->onDelete('cascade');
            $table->string('package')->nullable();
            $table->string('license_code')->nullable();
            $table->string('licensed_email')->nullable();
            $table->string('licensed_organisation')->nullable();
            $table->string('license_name')->nullable();
            $table->integer('license_days')->nullable();
            $table->integer('active_users')->nullable();
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
        Schema::dropIfExists('licenses');
    }
}
