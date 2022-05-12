<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameEditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_edits', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id')->index();
            $table->string('edit_field')->index()->comment('the field edited: date,close_time,market_result');
            $table->date('date')->nullable();
            $table->string('close_time')->nullable();
            $table->string('market_result')->nullable();
            $table->unsignedBigInteger('created_by_id')->index();
            $table->unsignedBigInteger('approved_by_id')->index()->nullable();
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
        Schema::dropIfExists('game_edits');
    }
}
