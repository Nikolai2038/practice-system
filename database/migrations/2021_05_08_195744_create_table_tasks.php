<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->bigInteger('user_from_id')->unsigned();
            $table->bigInteger('practice_id')->unsigned();
            $table->bigInteger('chat_id')->unsigned();

            $table->foreign('user_from_id')->references('id')->on('users');
            $table->foreign('practice_id')->references('id')->on('practices');
            $table->foreign('chat_id')->references('id')->on('chats');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('tasks');
    }
}
