<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAnnotationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('annotations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->references('id')->on('users')->onDelete('cascade');
            $table->string('note_id')->nullable();
            $table->string('content_id')->nullable();
            $table->string('content_type')->nullable();
            $table->text('content')->nullable();
            $table->text('comment')->nullable();
            $table->text('replies')->nullable();
            $table->text('text_target')->nullable();
            $table->text('tags')->nullable();
            $table->text('display')->nullable();
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
        Schema::dropIfExists('annotations');
    }
}
