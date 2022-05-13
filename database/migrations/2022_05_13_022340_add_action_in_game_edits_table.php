<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddActionInGameEditsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('game_edits', function (Blueprint $table) {
            $table->string('action')->nullable()->comment('approve/reject')->after('approved_by_id');
        });
    }
}
