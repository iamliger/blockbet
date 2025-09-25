<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasColumnComments;

class Point extends Model
{
    use HasColumnComments;

    // 모델이 매핑될 테이블 이름 (기본적으로 클래스명의 소문자 복수형)
    protected $table = 'points'; 

    // 대량 할당 가능한 속성 정의 (모든 필드를 지정하는 것이 안전)
    protected $fillable = [
        'fromName', 'toName', 'bid', 'type', 'game', 'amount', 'odds', 'result_odds', 'previous', 'request', 'result'
    ];

    // timestamps()를 마이그레이션에 사용했으므로 true (기본값)
    public $timestamps = true;
}