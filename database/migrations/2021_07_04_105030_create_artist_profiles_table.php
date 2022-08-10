<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArtistProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('artist_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artist_id')->constrained('artists')->onDelete('cascade');
            $table->foreignId('dance_id')->constrained('dances')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('phone')->nullable();
            $table->text('bio')->nullable();
            $table->unsignedDecimal('price_per_hour', 11, 2)->default(0);
            $table->integer('percentage')->nullable()->default(0);
            $table->json('image');
            $table->json('gallery')->nullable()->default(null);
            $table->date('birthdate')->nullable()->default(null);
            $table->text('facebook_link')->nullable();
            $table->text('twitter_link')->nullable();
            $table->text('linkedin_link')->nullable();
            $table->tinyInteger('gender')->unsigned()->nullable()->default(null);
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
        Schema::dropIfExists('artist_profiles');
    }
}
