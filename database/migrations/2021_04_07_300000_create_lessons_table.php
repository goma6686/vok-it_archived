<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLessonsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('Lessons', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->unique();
            $table->boolean('visible');
            $table->bigInteger('category_id')->unsigned()->nullable();
            $table->integer('category_order')->nullable();
            $table->bigInteger('topic_id')->unsigned()->nullable();
            $table->integer('topic_order')->nullable();
            $table->bigInteger('level_id')->unsigned()->nullable();
            $table->integer('level_order')->nullable();
            $table->string('picture')->nullable();
            $table->timestamp('updated_at');
            $table->timestamp('created_at')->default(DB::raw('CURRENT_TIMESTAMP'));
        
            $table->foreign('category_id')->references('id')->on('Categories')->onDelete('set null');
            $table->foreign('topic_id')->references('id')->on('Topics')->onDelete('set null');
            $table->foreign('level_id')->references('id')->on('Levels')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('Lessons');
    }
}
