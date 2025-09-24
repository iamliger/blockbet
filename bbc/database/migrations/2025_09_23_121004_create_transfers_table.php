<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransfersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transfers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fromName');
            $table->string('fromAddress');
            $table->string('toName');
            $table->string('toAddress');
            $table->double('amount')->default(0);
            $table->string('tid'); // 트랜잭션 ID (블록체인)
            $table->char('status', 1)->default('R'); // 'R', 'S', 'F', 'C' 등
            $table->string('operator')->nullable();
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
        Schema::dropIfExists('transfers');
    }
}