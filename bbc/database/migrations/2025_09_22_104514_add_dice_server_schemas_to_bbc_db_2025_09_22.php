<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDiceServerSchemasToBbcDb20250922 extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 1. oddeven40 테이블 생성
        Schema::create('oddeven40', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('blocknumber')->nullable(false);
            $table->string('blockhash', 255)->nullable(false);
            $table->string('result', 64)->nullable(false);
            $table->timestamps(); // created_at, updated_at
        });

        // 2. under40 테이블 생성
        Schema::create('under40', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('blocknumber')->nullable(false);
            $table->string('blockhash', 255)->nullable(false);
            $table->string('result', 64)->nullable(false);
            $table->timestamps(); // created_at, updated_at
        });

        // 3. underover40 테이블 생성
        Schema::create('underover40', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('blocknumber')->nullable(false);
            $table->string('blockhash', 255)->nullable(false);
            $table->string('result', 64)->nullable(false);
            $table->timestamps(); // created_at, updated_at
        });

        // 4. users 테이블에 store, odds, point 컬럼 추가
        Schema::table('users', function (Blueprint $table) {
            $table->string('store', 255)->after('address')->default('');
            $table->double('odds')->after('store')->default(0);
            $table->double('point')->after('odds')->default(0);
        });

        Schema::table('users', function (Blueprint $table) {
            // 이전: store, odds, point 컬럼 추가 로직 (이미 적용되었어야 함)
            if (!Schema::hasColumn('users', 'store')) {
                $table->string('store', 255)->after('address')->default('');
            }
            if (!Schema::hasColumn('users', 'odds')) {
                $table->double('odds')->after('store')->default(0);
            }
            if (!Schema::hasColumn('users', 'point')) {
                $table->double('point')->after('odds')->default(0);
            }
            // 새로 추가: level 컬럼
            if (!Schema::hasColumn('users', 'level')) {
                $table->integer('level')->after('email_verified_at')->default(0); // 기본값 0으로 설정
            }
            // ExternalFunctionController.php에서 사용하는 otex 필드도 추가
            if (!Schema::hasColumn('users', 'otex')) {
                $table->string('otex', 255)->after('address')->nullable(); // nullable로 설정
            }
            // RegisterController에서 사용하지만 $fillable에 없던 super, hq, dist 추가
            if (!Schema::hasColumn('users', 'super')) {
                $table->string('super', 255)->after('recommander')->nullable();
            }
            if (!Schema::hasColumn('users', 'hq')) {
                $table->string('hq', 255)->after('super')->nullable();
            }
            if (!Schema::hasColumn('users', 'dist')) {
                $table->string('dist', 255)->after('hq')->nullable();
            }
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // 마이그레이션 롤백 시 테이블 삭제 및 컬럼 삭제
        Schema::dropIfExists('oddeven40');
        Schema::dropIfExists('under40');
        Schema::dropIfExists('underover40');

        Schema::table('users', function (Blueprint $table) {
            if (Schema::hasColumn('users', 'point')) {
                $table->dropColumn('point');
            }
            if (Schema::hasColumn('users', 'odds')) {
                $table->dropColumn('odds');
            }
            if (Schema::hasColumn('users', 'store')) {
                $table->dropColumn('store');
            }
        });
    }
}