<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDataToPackagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('packages', function (Blueprint $table) {
            $table->string('postman_link')->nullable();
            $table->string('api_access')->nullable();
            $table->string('judgement_featureapi')->nullable();
            $table->string('lfn_featureapi')->nullable();
            $table->string('roc_featureapi')->nullable();
            $table->string('sroc_featureapi')->nullable();
            $table->string('form_featureapi')->nullable();
            $table->string('article_featureapi')->nullable();
            $table->string('maxim_featureapi')->nullable();
            $table->string('dict_featureapi')->nullable();
            $table->string('resource_featureapi')->nullable();
            $table->string('ai_featureapi')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('packages', function (Blueprint $table) {
            //
        });
    }
}
