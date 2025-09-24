<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateBalancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('balances', function (Blueprint $table) {
            $table->id();
            $table->string("name");            
            $table->integer("type")->default(1);
            $table->char("status",1)->default('R');
            $table->double("amount");
            $table->string("address");
            $table->string("tid")->default('');
            $table->string("ip",64)->default('');
            $table->dateTime("resulted_at")->nullable();
            $table->dateTime("deleted_at")->nullable();
            $table->dateTime("canceled_at")->nullable();
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
        Schema::dropIfExists('balances');
    }
}
