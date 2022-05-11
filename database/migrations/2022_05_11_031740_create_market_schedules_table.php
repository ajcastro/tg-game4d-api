<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('market_schedules', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('market_id')->index();
            $table->json('result_day')->nullable();
            $table->boolean('is_result_day_everyday')->default(0);
            $table->json('off_day')->nullable();
            $table->boolean('is_off_day_everyday')->default(0);
            $table->string('close_time')->nullable();
            $table->string('result_time')->nullable();
            $table->unsignedBigInteger('updated_by_id')->index();
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
        Schema::dropIfExists('market_schedules');
    }
}
