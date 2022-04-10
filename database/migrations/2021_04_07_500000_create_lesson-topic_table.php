<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonTopicTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('LessonTopic', function (Blueprint $table) {
            $table->integer('nr');
            $table->bigInteger('lesson_id')->unsigned()->unique();
            $table->bigInteger('topic_id')->unsigned();
        
            $table->foreign('topic_id')->references('id')->on('Topics')->onDelete('cascade');
            $table->foreign('lesson_id')->references('id')->on('Lessons')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('LessonTopic');
    }
}
