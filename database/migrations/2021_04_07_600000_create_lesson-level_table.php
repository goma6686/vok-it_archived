<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonLevelTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('LessonLevel', function (Blueprint $table) {
            $table->integer('nr');
            $table->bigInteger('lesson_id')->unsigned()->unique();
            $table->bigInteger('level_id')->unsigned();
        
            $table->foreign('lesson_id')->references('id')->on('Lessons')->onDelete('cascade');
            $table->foreign('level_id')->references('id')->on('Levels')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('LessonLevel');
    }
}
