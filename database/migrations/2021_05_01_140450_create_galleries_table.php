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
            $table->foreignId('archive_id')->nullable()->constrained('archives');
            // $table->foreignId('category_id')->nullable()->constrained('categories');
            // $table->foreignId('language_id')->nullable()->constrained('languages');
            // $table->foreignId('artist_id')->nullable()->constrained('artists');
            $table->string('title')->nullable(false);
            $table->string('title_original')->nullable();
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
