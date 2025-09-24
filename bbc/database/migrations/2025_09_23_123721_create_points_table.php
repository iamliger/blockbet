<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fromName');
            $table->string('toName');
            $table->bigInteger('bid')->default(0); // bid는 bet ID
            $table->string('type', 128)->default('game');
            $table->string('game', 128);
            $table->double('amount')->default(0);
            $table->double('odds')->default(0);
            $table->double('result_odds')->default(0);
            $table->double('previous')->default(0);
            $table->double('request')->default(0);
            $table->double('result')->default(0);
            $table->timestamps(); // created_at, updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('points');
    }
}