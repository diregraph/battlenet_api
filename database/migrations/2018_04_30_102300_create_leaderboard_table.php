<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLeaderboardTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('leaderboard', function (Blueprint $table) {
            $table->increments('id');
            $table->string("name-realm");
            $table->string('thumbnail');
            $table->integer('2v2')->default(0);
            $table->integer('ranking_2v2')->default(0);
            $table->integer('3v3')->default(0);
            $table->integer('ranking_3v3')->default(0);
            $table->integer('5v5')->default(0);
            $table->integer('ranking_5v5')->default(0);
            $table->integer('rbg')->default(0);
            $table->integer('ranking_rbg')->default(0);
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
        Schema::dropIfExists('leaderboard');
    }
}
