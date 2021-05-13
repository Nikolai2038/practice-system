<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTablePractices extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practices', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('name', 64);
            $table->string('description', 256)->nullable();
            $table->bigInteger('user_from_id');
            $table->timestamp('start_at');
            $table->timestamp('end_at');
            $table->boolean('is_closed')->default(false);
            $table->string('registration_key', 128);
            $table->timestamp('registration_closed_at');

            $table->unique('name');
            $table->unique('registration_key');
            $table->foreign('user_from_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('practices');
    }
}
