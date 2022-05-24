<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddVirtualColumnNumberInGameTransactionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_transactions', function (Blueprint $table) {
            $table->string('number')->virtualAs('CONCAT(IFNULL(num1,""),IFNULL(num2,""),IFNULL(num3,""),IFNULL(num4,""))')->index()->after('num4');
        });
    }
}
