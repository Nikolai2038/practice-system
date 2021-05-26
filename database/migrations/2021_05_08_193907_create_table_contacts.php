<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->bigInteger('user_from_id')->unsigned();
            $table->bigInteger('user_to_id')->unsigned();
            $table->boolean('is_accepted')->default(false);

            $table->unique(['user_from_id', 'user_to_id']);
            $table->foreign('user_from_id')->references('id')->on('users');
            $table->foreign('user_to_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contacts');
    }
}
