<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLikesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('likes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->foreignId('team_id')->nullable()->references('id')->on('teams')->onDelete('cascade');
            $table->foreignId('article_id')->nullable()->references('id')->on('articles')->onDelete('cascade');
            $table->foreignId('form_precedence_id')->nullable()->references('id')->on('form_precedences')->onDelete('cascade');
            $table->foreignId('annotation_id')->nullable()->references('id')->on('annotations')->onDelete('cascade');
            $table->foreignId('comment_id')->nullable()->references('id')->on('comments')->onDelete('cascade');
            $table->integer('like')->nullable();
            $table->enum('type', ['team', 'article', 'form', 'note'])->nullable();
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
        Schema::dropIfExists('likes');
    }
}
