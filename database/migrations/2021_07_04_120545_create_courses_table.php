<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dance_id')->constrained('dances')->onDelete('cascade');
            $table->foreignId('artist_id')->constrained('artists')->onDelete('cascade');
            $table->decimal('price', 15, 2)->nullable();
            $table->json('image');
            $table->json('gallery')->nullable()->default(null);
            $table->string('promo_video')->nullable()->default(null);
            $table->tinyInteger('video_type')->unsigned()->nullable()->default(null);
            $table->string('video')->nullable()->default(null);
            $table->tinyInteger('course_level')->unsigned()->nullable()->default(null);
            $table->integer('rate')->default(0)->nullable();
            $table->integer('duration')->nullable()->default(null);
            $table->boolean('is_published')->default(false)->nullable();
            $table->dateTime('start_at')->nullable();
            $table->dateTime('expire_at')->nullable();
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
        Schema::dropIfExists('courses');
    }
}
