<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;

trait HasColumnComments
{
    /**
     * 데이터베이스 컬럼 코멘트를 조회합니다.
     * @param string $columnName
     * @return string|null
     */
    public static function getColumnComment(string $columnName): ?string
    {
        // 툴팁 표시 설정이 false이면 코멘트 조회 자체를 건너뜁니다.
        if (! config('app.show_tooltips')) {
            return null;
        }

        // 캐시에서 코멘트 정보를 가져옵니다. (성능 최적화)
        // 모델 이름을 캐시 키에 포함하여 각 모델별로 캐시
        $modelName = (new static)->getTable(); // 현재 모델의 테이블 이름 가져오기
        return Cache::rememberForever("{$modelName}_column_comment_{$columnName}", function () use ($columnName, $modelName) {
            try {
                $connection = Schema::getConnection();
                $driver = $connection->getDriverName();
                
                if ($driver === 'mysql') {
                    $result = $connection->selectOne("SHOW FULL COLUMNS FROM `{$modelName}` WHERE Field = ?", [$columnName]);
                    return $result->Comment ?? null;
                } 
                return null;
            } catch (\Exception $e) {
                return null;
            }
        });
    }
}