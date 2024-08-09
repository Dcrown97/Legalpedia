<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLawOfFedSectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('law_of_fed_sections', function (Blueprint $table) {
            $table->id();
            $table->string('position')->nullable();
            $table->integer('law_of_federation_id')->nullable();
            $table->integer('law_of_fed_part_id')->nullable();
            $table->text('section_header')->nullable();
            $table->longText('section_body')->nullable();
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
        Schema::dropIfExists('law_of_fed_sections');
    }
}
