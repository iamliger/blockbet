<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    protected $fillable = ['key', 'value']; // 대량 할당 가능한 속성
    
    // Helper function to easily get/set settings
    public static function get(string $key, $default = null)
    {
        return static::where('key', $key)->first()->value ?? $default;
    }

    public static function set(string $key, $value)
    {
        return static::updateOrCreate(
            ['key' => $key],
            ['value' => (string) $value] // 값은 항상 문자열로 저장
        );
    }
}