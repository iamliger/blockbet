<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBetTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('bets', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('game',128);
            $table->double('amount')->default(0);
            $table->double('rate')->default(0);
            $table->bigInteger('blockNumber')->default(0);
            $table->string('blockhash')->default('');
            $table->string('transaction')->default('');                        
            $table->integer('pick')->default(0);
            $table->double('result_amount')->default(0);
            $table->integer('result')->default(0);
            $table->char('status',1)->default('R'); // W : 추첨을 기다린다. W , L
            $table->string('ip',64)->default('');
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
        Schema::dropIfExists('bets');
    }
}
