<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTotalAssetsHistoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('total_assets_histories', function (Blueprint $table) {
            $table->id();
            $table->string('type')->comment('변동 타입 (예: initial, add, withdraw, point_distribute)');
            $table->double('amount')->comment('변동 금액 (양수: 증가, 음수: 감소)');
            $table->double('previous_total_assets')->comment('변동 전 총자산');
            $table->double('new_total_assets')->comment('변동 후 총자산');
            $table->string('description')->nullable()->comment('변동 상세 설명');
            $table->unsignedBigInteger('user_id')->nullable()->comment('관련 사용자 ID (포인트 지급/회수 등)');
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
        Schema::dropIfExists('total_assets_histories');
    }
}