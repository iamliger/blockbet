<?php

namespace App\Http\Controllers;

use App\Bet;
use App\User;
use App\Transfer;
use App\favoriteWallet;
use App\Balance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;

class GameController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    public function transfer_index(){
        
        $list = Transfer::where('operator',Auth::user()->name)->orderby("id","desc")->paginate(30);
        return view('transfer',["list"=>$list]);
    }

    public function transfer(Request $request){
        $user = User::find(Auth::user()->id);        
        try{
            if($request->amount <= 0){
                response()->json(["status"=>'error',"message"=>'Amount must to have 0 over']);
            }
        }catch(\Exception $e){
            return response()->json(["status"=>'error',"message"=>'invalidate Number']);
        }

        $targetUser = User::where('name',$request->name)->where('store',$user->name)->first();
        
        if($user && $targetUser){
            Transfer::create([
                'fromName'=>$user->name,
                'fromAddress'=>$user->address,
                'toName'=>$targetUser->name,
                'toAddress'=>$targetUser->address,
                'amount'=>$request->amount,
                'operator'=>$user->name,
                'ip'=>$request->ip(),
            ]);

            return response()->json(["status"=>'success',"message"=>'Requested']);
        }
        return response()->json(["status"=>'error',"message"=>'Cannot find User']);
    }

    public function oddEven_index(){
        return view('game.oddEven');
    }

    public function underOver_index(){
        return view('game.underOver');
    }

    public function under_index(){
        return view('game.under');
    }

    public function oddEven40_index(){
        return view('game.oddEven40');
    }

    public function underOver40_index(){
        return view('game.underOver40');
    }

    public function under40_index(){
        return view('game.under40');
    }

    public function oddEven_result(){
        $bets = Bet::select("id","name","amount","rate","blockNumber","blockhash","transaction",'pick','result_amount','result','status')
        ->where(function($query){
            $query->where("status","S")->orWhere("status","L")->orWhere("status","W");
        })->where("game","oddeven")->orderby("blockNumber","desc")->limit(20)->get();


        return response()->json($bets);
    }

    public function oddEven_myresult(){
        $bets = [];
        $user = Auth::user();
        
        if($user)
        {            
            $bets = Bet::select("id","name","amount","rate","blockNumber","blockhash","transaction",'pick','result_amount','result','status')
            ->where(function($query){
                $query->where("status","S")->orWhere("status","L")->orWhere("status","W");
            })->where("game","oddeven")->where("name",$user->name)->orderby("blockNumber","desc")->limit(20)->get();
        }

        return response()->json($bets);
    }

    public function underOver_result(){
        $bets = Bet::select("id","name","amount","rate","blockNumber","blockhash","transaction",'pick','result_amount','result','status')
        ->where(function($query){
            $query->where("status","S")->orWhere("status","L")->orWhere("status","W");
        })->where("game","underover")->orderby("blockNumber","desc")->limit(20)->get();

        return response()->json($bets);
    }


    public function underOver_myresult(){        
        $bets = [];
        $user = Auth::user();
        
        if($user)
        {            
            $bets = Bet::select("id","name","amount","rate","blockNumber","blockhash","transaction",'pick','result_amount','result','status')
            ->where(function($query){
                $query->where("status","S")->orWhere("status","L")->orWhere("status","W");
            })->where("game","underover")->where("name",$user->name)->orderby("blockNumber","desc")->limit(20)->get();
            
        }

        return response()->json($bets);
    }

    public function under_result(){
        $bets = Bet::select("id","name","amount","rate","blockNumber","blockhash","transaction",'pick','result_amount','result','status')
        ->where(function($query){
            $query->where("status","S")->orWhere("status","L")->orWhere("status","W");
        })->where("game","under")->orderby("blockNumber","desc")->limit(20)->get();        
        return response()->json($bets);

    }

    public function under_myresult(){

        $bets = [];
        $user = Auth::user();
        
        if($user)
        {            
            $bets = Bet::select("id","name","amount","rate","blockNumber","blockhash","transaction",'pick','result_amount','result','status')
            ->where(function($query){
                $query->where("status","S")->orWhere("status","L")->orWhere("status","W");
            })->where("game","under")->where("name",$user->name)->orderby("blockNumber","desc")->limit(20)->get();        
        }

        return response()->json($bets);
    }


    /**
     * 
     * 40 " 
     */

    public function oddEven40_result(){
        $bets = Bet::select("id","name","amount","rate","blockNumber","blockhash","transaction",'pick','result_amount','result','status')
        ->where(function($query){
            $query->where("status","S")->orWhere("status","L")->orWhere("status","W");
        })->where("game","oddeven40")->orderby("blockNumber","desc")->limit(20)->get();


        return response()->json($bets);
    }

    public function oddEven40_myresult(){
        $bets = [];
        $user = Auth::user();
        
        if($user)
        {            
            $bets = Bet::select("id","name","amount","rate","blockNumber","blockhash","transaction",'pick','result_amount','result','status')
            ->where(function($query){
                $query->where("status","S")->orWhere("status","L")->orWhere("status","W");
            })->where("game","oddeven40")->where("name",$user->name)->orderby("blockNumber","desc")->limit(20)->get();
        }

        return response()->json($bets);
    }

    public function underOver40_result(){
        $bets = Bet::select("id","name","amount","rate","blockNumber","blockhash","transaction",'pick','result_amount','result','status')
        ->where(function($query){
            $query->where("status","S")->orWhere("status","L")->orWhere("status","W");
        })->where("game","underover40")->orderby("blockNumber","desc")->limit(20)->get();

        return response()->json($bets);
    }


    public function underOver40_myresult(){        
        $bets = [];
        $user = Auth::user();
        
        if($user)
        {            
            $bets = Bet::select("id","name","amount","rate","blockNumber","blockhash","transaction",'pick','result_amount','result','status')
            ->where(function($query){
                $query->where("status","S")->orWhere("status","L")->orWhere("status","W");
            })->where("game","underover40")->where("name",$user->name)->orderby("blockNumber","desc")->limit(20)->get();
            
        }

        return response()->json($bets);
    }

    public function under40_result(){
        $bets = Bet::select("id","name","amount","rate","blockNumber","blockhash","transaction",'pick','result_amount','result','status')
        ->where(function($query){
            $query->where("status","S")->orWhere("status","L")->orWhere("status","W");
        })->where("game","under40")->orderby("blockNumber","desc")->limit(20)->get();        
        return response()->json($bets);

    }

    public function under40_myresult(){

        $bets = [];
        $user = Auth::user();
        
        if($user)
        {            
            $bets = Bet::select("id","name","amount","rate","blockNumber","blockhash","transaction",'pick','result_amount','result','status')
            ->where(function($query){
                $query->where("status","S")->orWhere("status","L")->orWhere("status","W");
            })->where("game","under40")->where("name",$user->name)->orderby("blockNumber","desc")->limit(20)->get();        
        }

        return response()->json($bets);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

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

    public function bet(Request $request){


        if(preg_match('/^[0-9]+(\.[0-9]+)?/',$request->amount) !== false){

            if($request->amount > 0 ){
                $user = Auth::guard('api')->user();                            
                if($user){
                    $cnt = Balance::where("name",$user->name)->where("type",-1)->where("status" , "<>","F")->where("status" , "<>","C")->count();
                    if($cnt > 0 ) return response()->json(["status"=>'error',"message"=>"Requested Withdraw not finished"]);
                    Bet::create([
                        'name'=>$user->name,
                        'game'=>$request->game,
                        'amount'=>$request->amount,
                        'pick'=>$request->pick,
                        'rate'=>$request->rate,
                        'ip'=>$request->ip()
                    ]);
                    return response()->json(["status"=>'success',"message"=>'success']);
                }
            }            
        }

        return response()->json(["status"=>'error',"invalid type"]);
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
