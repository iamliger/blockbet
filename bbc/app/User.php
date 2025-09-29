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
        'name',
        'email',
        'password',
        'recommander',
        'country',
        'mobile',
        'api_token',
        'store',
        'swift',
        'iban',
        'account',
        'super',
        'hq',
        'dist',
        'level',
        'odds',
        'point',
        'otex'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'privateKey'
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    // 레벨에 따른 명칭을 반환하는 메서드
    public function getLevelName(): string
    {
        switch ($this->level) {
            case 10:
                return '슈퍼관리자'; // admin 계정
            case 9:
                return '회사';
            case 8:
                return '본사';
            case 7:
                return '부본사';
            case 6:
                return '지사';
            case 5:
                return '총판';
            case 4:
                return '영업장';
            case 3:
                return '매장';
            case 2:
                return '사용자';
            case 1:
                return '보조사용자';
            case 0:
                return '승인대기 (이용불가)';
            default:
                return '알 수 없음';
        }
    }

    /**
     * 이 사용자의 직접적인 상위(부모) 사용자를 반환합니다.
     * recommander 또는 store를 기준으로 부모를 찾습니다.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo|null
     */
    public function directParent()
    {
        // recommander가 있으면 recommander를, 없으면 store를 부모로 가정합니다.
        // 또는 둘 중 더 높은 레벨의 부모를 찾을 수도 있습니다.
        // 여기서는 'recommander'를 우선적으로 사용합니다.
        if ($this->recommander) {
            return $this->belongsTo(User::class, 'recommander', 'name');
        } elseif ($this->store && $this->store !== $this->name) { // store가 자신 이름과 같지 않은 경우
            return $this->belongsTo(User::class, 'store', 'name');
        }
        return null; // 최상위 사용자
    }


    /**
     * 이 사용자의 직접적인 하위 멤버(자식)들을 반환합니다.
     * 자신을 recommander 또는 store로 가진 모든 하위 멤버들을 찾습니다.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function directChildren()
    {
        // 자신을 recommander로 가진 하위 멤버
        return $this->hasMany(User::class, 'recommander', 'name')
            // 또는 자신을 store로 가진 하위 멤버 (recommander와 store가 다를 경우)
            ->orWhere(function ($query) {
                $query->where('store', $this->name)
                    ->where('recommander', '!=', $this->name); // recommander가 자신이 아닌 경우
            });
    }

    public function recommanderParent()
    {
        return $this->belongsTo(User::class, 'recommander', 'name');
    }

    // 직접적인 하위 멤버 (recommander) (hasMany)
    public function recommanderChildren()
    {
        return $this->hasMany(User::class, 'recommander', 'name');
    }

    // 직접적인 하위 멤버 (store) (hasMany)
    public function storeChildren()
    {
        return $this->hasMany(User::class, 'store', 'name');
    }

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