<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStaticPageTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('static_page_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('static_page_id')->constrained('static_pages')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
            $table->longText('content')->nullable();
            $table->unique(['static_page_id', 'locale']);
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
        Schema::dropIfExists('static_page_translations');
    }
}
