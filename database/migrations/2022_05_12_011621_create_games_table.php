<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGamesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('games', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('market_id')->index();
            $table->date('market_period')->index();
            $table->unsignedInteger('period');
            $table->string('close_time')->index();
            $table->string('result_time')->index();
            $table->string('market_result')->nullable()->index()->comment('this is null at first because game_market is still not closed, but when it closed there will be result');
            $table->unsignedTinyInteger('result_day')->comment('dayOfWeek in integer format base from market_period');
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
        Schema::dropIfExists('games');
    }
}
