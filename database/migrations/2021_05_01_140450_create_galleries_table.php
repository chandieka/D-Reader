<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users'); // owner or uploader
            // $table->foreignId('archive_id')->nullable()->constrained('archives');
            // $table->foreignId('category_id')->constrained();
            // $table->foreignId('language_id')->constrained();
            $table->string('title')->nullable(false);
            $table->string('title_original')->nullable();
            $table->decimal('fizesize')->nullable(); // either Bytes or Kilobytes or MegaBytes
            $table->string('thumbnail')->nullable();
            $table->string('dir_path')->nullable(false);
            $table->boolean('isHidden')->default(false);
            $table->softDeletes();
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
        Schema::dropIfExists('galleries');
    }
}
