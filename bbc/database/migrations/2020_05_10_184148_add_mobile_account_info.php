<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddMobileAccountInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->string('swift',64)->default(''); // 은행명
            $table->string('iban',64)->default(''); // 계좌번호
            $table->string('account',64)->default(''); // 계좌주                
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            //
            $table->dropColumn('swift');
            $table->dropColumn('iban');
            $table->dropColumn('account');
        });
    }
}
