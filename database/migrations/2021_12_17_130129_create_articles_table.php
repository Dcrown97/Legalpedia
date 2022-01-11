<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->text('title')->nullable();
            $table->string('version_no')->nullable();
            $table->integer('user_id')->nullable();
            $table->text('title')->nullable();
            $table->text('content')->nullable();
            $table->text('description')->nullable();
            $table->text('references')->nullable();
            $table->text('author')->nullable();
            $table->text('link')->nullable();
            $table->string('photo')->nullable();
            $table->text('category')->nullable();
            $table->text('area_of_law')->nullable();
            $table->text('article_type')->nullable();
            $table->text('display_type')->nullable();
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
        Schema::dropIfExists('articles');
    }
}
