<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLiveCoursesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('live_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->constrained('courses')->onDelete('cascade');
            $table->string('meeting_id');
            $table->string('topic');
            $table->text('description')->comment('agenda');
            $table->dateTime('start_at');
            $table->integer('duration')->comment('minutes');
            $table->string('password')->comment('meeting password');
            $table->boolean('participant_video')->default(false);
            $table->boolean('mute_upon_entry')->default(false);
            $table->integer('number_of_attendance')->nullable()->default(null);
            $table->integer('student_limit')->nullable();
            $table->json('settings')->nullable();
            $table->text('start_url');
            $table->text('join_url');
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
        Schema::dropIfExists('live_courses');
    }
}
