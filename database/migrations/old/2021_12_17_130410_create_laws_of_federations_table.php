<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLawsOfFederationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('laws_of_federations', function (Blueprint $table) {
            $table->id();
            $table->string('law_no')->nullable();
            $table->string('title')->nullable();
            $table->date('law_date')->nullable();
            $table->text('description')->nullable();
            $table->text('subsidiary_legislation')->nullable();
            $table->string('tags')->nullable();
            $table->text('category')->nullable();
            $table->text('area_of_law')->nullable();
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
        Schema::dropIfExists('laws_of_federations');
    }
}
