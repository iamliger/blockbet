<?php

use Illuminate\Database\Seeder;
use App\User; // User 모델을 사용하기 위해 use 선언
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // 'admin'이라는 추천인이 필요하므로, 첫 관리자는 추천인 없이 생성
        // 이후 일반 유저 가입 시 'admin'을 추천인으로 지정할 수 있습니다.
        User::firstOrCreate(
            ['name' => 'admin'], // 'admin'이라는 이름의 유저가 없으면 생성
            [
                'email' => 'admin@domain.com',
                'password' => Hash::make('liger!@34'), // 안전한 비밀번호로 변경하세요!
                'level' => 10, // 최고 관리자 레벨로 설정 (PartnerMiddleware 조건 충족)
                'store' => '', // 관리자는 store가 없을 수 있음
                'odds' => 0, // 기본값 0
                'point' => 0, // 기본값 0
                'api_token' => Str::random(60),
                'country' => 'Korea', // 더미 값
                'mobile' => '01012345678', // 더미 값
                'recommander' => null, // 첫 관리자는 추천인 없음
                'super' => null,
                'hq' => null,
                'dist' => null,
                'address' => '0x0000000000000000000000000000000000000000', // 초기에는 주소 없음 (dice_server에서 생성)
                'otex' => null,
                'email_verified_at' => now(),
            ]
        );

        // 2. 'iamliger' 계정 생성 (레벨 3 추천인)
        User::firstOrCreate(
            ['name' => 'iamliger'], // 'iamliger'라는 이름의 유저가 없으면 생성
            [
                'email' => 'iamliger@example.com',
                'password' => Hash::make('qwer1234'), // 요청하신 비밀번호로 설정
                'level' => 3, // 요청하신 레벨 3
                'store' => 'admin', // admin을 추천인으로 (존재하는 추천인이어야 함)
                'odds' => 0.05, // 예시 값 (필요에 따라 조정)
                'point' => 100, // 예시 값 (필요에 따라 조정)
                'api_token' => Str::random(60),
                'country' => 'Korea',
                'mobile' => '01011112222', // 더미 값
                'recommander' => 'admin', // admin이 존재하므로 추천인으로 지정 가능
                'super' => null,
                'hq' => null,
                'dist' => null,
                'address' => '0x0000000000000000000000000000000000000001', // 필수 필드이므로 빈 문자열
                'otex' => null,
                'email_verified_at' => now(),
            ]
        );
    }
}