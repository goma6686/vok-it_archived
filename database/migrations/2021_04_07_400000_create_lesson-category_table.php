<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('LessonCategory', function (Blueprint $table) {
            $table->integer('nr');
            $table->bigInteger('lesson_id')->unsigned()->unique();
            $table->bigInteger('category_id')->unsigned();

        
            $table->foreign('category_id')->references('id')->on('Categories')->onDelete('cascade');
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
        Schema::dropIfExists('LessonCategory');
    }
}
