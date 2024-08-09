<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLawOfFedSchedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('law_of_fed_scheds', function (Blueprint $table) {
            $table->id();
            $table->integer('law_of_federation_id')->nullable();
            $table->text('sched_header')->nullable();
            $table->longText('sched_body')->nullable();
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
        Schema::dropIfExists('law_of_fed_scheds');
    }
}
