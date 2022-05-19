<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_transactions', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('game_id')->index();
            $table->unsignedBigInteger('member_id')->index();
            $table->string('game_code')->index();
            $table->unsignedTinyInteger('num1')->nullable()->index();
            $table->unsignedTinyInteger('num2')->nullable()->index();
            $table->unsignedTinyInteger('num3')->nullable()->index();
            $table->unsignedTinyInteger('num4')->nullable()->index();
            $table->decimal('bet', 15, 2)->default(0);
            $table->decimal('discount', 15, 2)->default(0);
            $table->decimal('pay', 15, 2)->default(0);
            $table->json('game_setting')->nullable();
            $table->unsignedTinyInteger('status')->nullable()->index()->comment('0=lose,1=win,2=draw');
            $table->decimal('winning_amount', 15, 2)->default(0);
            $table->decimal('credit_amount', 15, 2)->default(0);
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
        Schema::dropIfExists('game_transactions');
    }
}
