<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('packages', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->text('description')->nullable();
            $table->integer('price')->nullable();
            $table->text('features')->nullable();
            $table->text('permalink')->nullable();
            $table->string('validity')->nullable();
            $table->integer('recur_date')->nullable();
            $table->text('judgement_feature')->nullable();
            $table->text('lfn_feature')->nullable();
            $table->text('roc_feature')->nullable();
            $table->text('sroc_feature')->nullable();
            $table->text('form_feature')->nullable();
            $table->text('article_feature')->nullable();
            $table->text('maxim_feature')->nullable();
            $table->text('dict_feature')->nullable();
            $table->text('resource_feature')->nullable();
            $table->string('slug')->nullable();
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
        Schema::dropIfExists('packages');
    }
}
