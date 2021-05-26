<?php

use App\Models\File;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTableFiles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('files', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->softDeletes();

            $table->string('name', 64);
            $table->string('prefix', 64);
            $table->string('filename', 134); // название файла = ключ_sha_512 (128 симв.) + '.' + расширение (3 или 4 симв.) + 1 (на всякий случай)
            $table->bigInteger('user_from_id')->unsigned();

            $table->foreign('user_from_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $files = File::all();
        foreach ($files as $file)
        {
            $file->fileDelete();
        }
        Schema::dropIfExists('files');
    }
}
