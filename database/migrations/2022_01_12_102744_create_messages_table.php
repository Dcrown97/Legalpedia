<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->id();
            $table->text('name')->nullable();
            $table->text('subject')->nullable();
            $table->text('body')->nullable();
            $table->string('type')->nullable()->comment('manual or automated messages');
            $table->string('receipient')->nullable()->comment('type of users that receive messages for normal messages');
            $table->string('receipient_type')->nullable()->comment('type of users that receive messages for automated
             messages');
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
        Schema::dropIfExists('messages');
    }
}
