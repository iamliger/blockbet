<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use App\Traits\HasColumnComments;
class User extends Authenticatable
{
    use Notifiable, HasColumnComments;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','recommander','country','mobile',
        'api_token','store','swift','iban','account','super','hq','dist',
        'level','odds', 'point', 'otex'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token','privateKey'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getColumnComment(string $columnName): ?string
    {
        // 캐시에서 코멘트 정보를 가져옵니다. (성능 최적화)
        return Cache::rememberForever("users_column_comment_{$columnName}", function () use ($columnName) {
            try {
                $connection = Schema::getConnection();
                $driver = $connection->getDriverName();
                
                if ($driver === 'mysql') {
                    // MySQL 전용: SHOW FULL COLUMNS FROM 테이블명 WHERE Field = '컬럼명'
                    $table = (new static)->getTable(); // 현재 모델의 테이블 이름 가져오기
                    $result = $connection->selectOne("SHOW FULL COLUMNS FROM `{$table}` WHERE Field = ?", [$columnName]);
                    
                    return $result->Comment ?? null;
                } 
                // 다른 데이터베이스 드라이버에 대한 로직 추가 (필요시)
                // PostgreSQL: SELECT col_description(oid, attnum) FROM pg_class, pg_attribute WHERE relname = '테이블명' AND attrelid = oid AND attname = '컬럼명';

                return null; // 지원하지 않는 드라이버 또는 코멘트 없음
            } catch (\Exception $e) {
                // 예외 발생 시 (예: 테이블/컬럼 없음)
                return null;
            }
        });
    }
}