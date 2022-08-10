<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDanceTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dance_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dance_id')->constrained('dances')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('name');
            $table->unique(['dance_id', 'locale']);
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
        Schema::dropIfExists('dance_translations');
    }
}
