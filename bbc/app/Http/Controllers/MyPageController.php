<?php

namespace App\Http\Controllers;

use App\favoriteWallet;
use App\User;
use App\Point;
use App\PointExchangeApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class MyPageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $list = favoriteWallet::whereNull("deleted_at")->get();
        
        return view('mypage',['list'=>$list]);
    }

    public function partner(){
        $list = User::where("store",Auth::user()->name)->paginate(20);
        return view('partner',["list"=>$list]);
    }

    public function partner_odds(Request $request){
        $request->validate([
            "id"=>['required','integer','exists:users,id',function($attribute,$value,$fail) use($request){
                $target = User::find($value);
                if($target->store !== $request->user()->name) {
                    $fail('Not your partner');
                }
            }],
            "odds"=>['required','numeric',function($attribute,$value,$fail) use($request) {
                $odds = $value/100;
                if($odds > $request->user()->odds){
                    $originValue = $request->user()->odds * 100;
                    $fail("Cannot set {$originValue}% more over");
                }
            }]
        ]);        

        $target = User::find($request->id);
        $target->odds = $request->odds/100;
        $target->save();
        return back()->with('alert-success','Success');
    }

    public function points(){
        $list = Point::where('toName',Auth::user()->name)->orderby("id","desc")->paginate(20);
        return view('points',["list"=>$list]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    public function createPointExchangeTransaction(Request $request){
        $user = $request->user();

        if(!$user->point){
            return back()->with('alert-error','you have just 0 point');
        }

        $amount = $user->point;

        $user->point = 0;
        $user->save();

        PointExchangeApplication::create([
            'name'=>$user->name,
            'nickname'=>($user->nickname ?? ''),
            'amount'=>$amount,
        ]);

        return back()->with('alert-success','Success');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'cointype' =>['required','alpha','max:64'],
            'address' =>['required','string','max:255'],
            'note' => ['required', 'string' ,'max:255'],
        ]);

        if($validator->fails()){
            return redirect()->route('mypage')->withErrors($validator)->withInput();
        }

        favoriteWallet::newWallet(Auth::user()->email,$request->cointype,$request->address,$request->note);
        
        return redirect()->route('mypage');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        
    }


    public function delete_favoriteWallet($id){
        //
        $wallet = favoriteWallet::where('name',Auth::user()->email)->where("id",$id)->first();
        if($wallet){
            $wallet->delete();
        }
        return redirect()->route('mypage');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
