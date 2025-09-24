<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCoinInOutsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('coin_in_outs', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->char('inout',1)->default(''); // if 1 is in ,0 is out
            $table->string('cointype'); // use coinname
            $table->double('amount');
            $table->char('type',1)->default('R');
            $table->dateTime('completed_at')->nullable();
            $table->dateTime('deleted_at')->nullable();
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
        Schema::dropIfExists('coin_in_outs');
    }
}
