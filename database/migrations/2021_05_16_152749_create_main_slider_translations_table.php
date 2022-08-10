<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMainSliderTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('main_slider_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('main_slider_id')->constrained('main_sliders')->onDelete('cascade');
            $table->string('locale')->index();
            $table->longText('content');
            $table->unique(['main_slider_id', 'locale']);
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
        Schema::dropIfExists('main_slider_translations');
    }
}
