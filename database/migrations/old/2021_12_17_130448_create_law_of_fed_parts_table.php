<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLawOfFedPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('law_of_fed_parts', function (Blueprint $table) {
            $table->id();
            $table->string('position')->nullable();
            $table->integer('law_of_federation_id')->nullable();
            $table->text('part_header')->nullable();
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
        Schema::dropIfExists('law_of_fed_parts');
    }
}
