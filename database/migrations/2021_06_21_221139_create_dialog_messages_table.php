<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDialogMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dialog_messages', function (Blueprint $table) {
            $table->id();
            $table->foreignId('dialog_id')->constrained('dialogs')->onDelete('cascade');
            $table->morphs('from_accountable');
            $table->morphs('to_accountable');
            $table->text('message')->nullable();
            $table->boolean('is_read')->nullable();
            $table->string('attachment')->nullable();
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
        Schema::dropIfExists('dialog_messages');
    }
}
