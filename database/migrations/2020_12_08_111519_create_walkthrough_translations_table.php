<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWalkthroughTranslationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('walkthrough_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('walkthrough_id')->constrained('walkthroughs')->onDelete('cascade');
            $table->string('locale')->index();
            $table->string('title');
            $table->longText('content');
            $table->unique(['walkthrough_id', 'locale']);
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
        Schema::dropIfExists('walkthrough_translations');
    }
}
