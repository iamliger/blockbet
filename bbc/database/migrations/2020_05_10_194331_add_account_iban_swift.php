<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAccountIbanSwift extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('balances', function (Blueprint $table) {
            //
            $table->string('swift',64)->default('')->after('status');
            $table->string('iban',64)->default('')->after('swift');
            $table->string('account',64)->default('')->after('iban');
            $table->string('mobile',64)->default('')->after('account');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('balances', function (Blueprint $table) {
            //
            $table->dropColumn('swift');
            $table->dropColumn('iban');
            $table->dropColumn('account');
            $table->dropColumn('mobile');
        });
    }
}
