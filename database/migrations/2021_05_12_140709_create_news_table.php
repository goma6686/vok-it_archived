<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateNewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::enableForeignKeyConstraints();
        Schema::create('news', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('news_title');
            $table->text('description')->nullable();
            $table->mediumText('title_image')->nullable();
            $table->text('news_body');
            $table->bigInteger('news_categoryId')->unsigned()->nullable();
            $table->string('lang');
            $table->timestamps();

            $table->foreign('news_categoryId')->references('id')->on('news_categories')->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('news');
    }
}