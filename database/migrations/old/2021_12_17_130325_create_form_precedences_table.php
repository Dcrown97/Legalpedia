<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFormPrecedencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('form_precedences', function (Blueprint $table) {
            $table->id();
            $table->integer('version_no')->nullable();
            $table->text('content')->nullable();
            $table->text('title')->nullable();
            $table->text('category')->nullable();
            $table->text('area_of_law')->nullable();
            $table->text('author')->nullable();
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
        Schema::dropIfExists('form_precedences');
    }
}
