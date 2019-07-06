<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCommentsAndFavoritesTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('comments', function (Blueprint $table1) {
            $table1->bigIncrements('id');
            $table1->text('body');
            $table1->timestamps();
            $table1->unsignedBigInteger('user_id');
            $table1->unsignedBigInteger('recipe_id');
            $table1->foreign('user_id')->references('id')->on('users');
            $table1->foreign('recipe_id')->references('id')->on('recipes');
        });
        Schema::create('favorites', function(Blueprint $table2){
            $table2->bigIncrements('id');
            $table2->boolean('confirmed');
            $table2->timestamps();
            $table2->unsignedBigInteger('user_id');
            $table2->unsignedBigInteger('recipe_id');
            $table2->foreign('user_id')->references('id')->on('users');
            $table2->foreign('recipe_id')->references('id')->on('recipes');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('comments');
        Schema::dropIfExists('favorites');
    }
}
