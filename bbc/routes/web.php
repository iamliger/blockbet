<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

$maintenance = false;

if($maintenance){
Route::get('/',function(){
    return view('maintenance');
});

}else{

Route::get('/', function () {
    return view('index');
})->name('index');


Route::get('/login',function(){
    return view('auth.login');
});

Route::get('/register',function(){
    return view('auth.register');
});

Route::post('/address','ExternalFunctionController@address');


Auth::routes();

    Route::group(['middleware'=>['auth']],function(){
        
        if(session("locale")){
            App::setLocale(session("locale"));
        }
        Route::get('/mypage','MyPageController@index')->name("mypage");
        Route::get('/inout','InoutController@index')->name('inout');
        Route::get('/game/oddEvent/result','GameController@oddEven_result')->name('game.oddEven');
        Route::get('/game/oddEven','GameController@oddEven_index')->name('game.oddEven');
        Route::get('/game/underOver','GameController@underOver_index')->name('game.underOver');
        Route::get('/game/under','GameController@under_index')->name('game.under');

        Route::get('/game/oddEven40','GameController@oddEven40_index')->name('game.oddEven40');
        Route::get('/game/underOver40','GameController@underOver40_index')->name('game.underOver40');
        Route::get('/game/under40','GameController@under40_index')->name('game.under40');


        Route::post('/mypage','MyPageController@store')->name("favorite.register");
        Route::post('/mypage/favorite/{id}','MyPageController@delete_favoriteWallet')->where(['id'=>'[0-9]+'])->name("favorite.delete");

        Route::post('/deposit',"InoutController@deposit")->name('deposit');
        Route::post('/widthdraw',"InoutController@withdraw")->name('withdraw');
        Route::post('/widthdrawtoOtex',"InoutController@withdraw_otex")->name('withdraw.otex');
        Route::post('/widthdrawtoUser',"InoutController@withdraw_user")->name('withdraw.user');

        Route::group(["middleware"=>['partner']],function(){
            Route::get('/partner','MyPageController@partner')->name("partner");
            Route::get('/points','MyPageController@points')->name("points");
            Route::get('/transfer','GameController@transfer_index')->name('partner.transfer');
            Route::post('/partner/odds','MyPageController@partner_odds')->name('partner.set.odds');
            Route::post('/partner/exchange','MyPageController@createPointExchangeTransaction')->name('partner.update.exchange');
        });       
    });

    Route::get('/language/{locale}',function(Request $request,$locale){
        if (! in_array($locale, ['en', 'ja', 'ko','my','vn','zh','bn'])) {
            abort(400);
        }

        session(["locale"=>$locale]);            
        
        return back()->withInput();
    });

    Route::get('/guide',function(){
        return view('guide');
    });

    Route::group(['prefix' => 'admin', 'middleware' => ['auth', 'admin']], function () { // 'admin' 미들웨어를 가정
        // AdminController의 index()는 대시보드용 (GET /admin)
        Route::get('/', 'AdminController@dashboard')->name('admin.dashboard');        
        
        Route::resource('users', 'AdminController', [
            'parameters' => ['users' => 'user'],
            'names' => [
                'index' => 'admin.users.index',
                'create' => 'admin.users.create',
                'store' => 'admin.users.store',
                'show' => 'admin.users.show',
                'edit' => 'admin.users.edit',
                'update' => 'admin.users.update',
                'destroy' => 'admin.users.destroy',
            ],
        ]);

        // 기존처럼 명시적으로 정의된 라우트들은 그대로 유지
        Route::get('/transfers', 'AdminController@transfers')->name('admin.transfers');
        Route::get('/balances', 'AdminController@balances')->name('admin.balances');
        Route::get('/points', 'AdminController@points')->name('admin.points');
    });
}