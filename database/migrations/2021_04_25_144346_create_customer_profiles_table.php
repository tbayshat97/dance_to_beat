<?php

use App\Enums\SourceType;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerProfilesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('customer_id')->constrained('customers')->onDelete('cascade');
            $table->string('first_name');
            $table->string('last_name');
            $table->text('bio')->nullable();
            $table->string('image')->nullable()->default(null);
            $table->date('birthdate')->nullable()->default(null);
            $table->tinyInteger('gender')->unsigned()->nullable()->default(null);
            $table->tinyInteger('source')->unsigned()->nullable()->default(SourceType::Normal);
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
        Schema::dropIfExists('customer_profiles');
    }
}
