<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Balance;
use App\User;

class InoutController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $user = Auth::user();
        if($user){
            $list = Balance::where("name",$user->name)->orderby("id","desc")->paginate(10);
        }
        return view('inout',["list"=>$list]);
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

    public function deposit(Request $request){
        $user = Auth::user();

        if($request->amount && preg_match('/^[0-9]+(\.[0-9]+)?$/',$request->amount) !== false){
            if($user){
                Balance::create([
                    "name"=>$user->name,
                    "type"=>1,
                    "amount"=>$request->amount,
                    "address"=>$user->address,
                    "iban"=>$user->iban,
                    "swift"=>$user->swift,
                    "account"=>$user->account,
                    "mobile"=>$user->mobile,
                    "ip"=>$request->ip()
                ]);
                return redirect()->route('inout')->with('alert-success', 'Deposit completed');
            }    
        }else {
            return redirect()->route('inout')->with('alert-error', 'invalied amount');
        }

        

        return redirect()->route('inout')->with('alert-error', 'Require Login');
    }

    public function isNumber($val){
        return preg_match('/^[0-9]+(\.[0-9]+)?$/',$val) != false;
    }

    public function withdraw(Request $request){
        $user = Auth::user();
        
        if($this->isNumber($request->amount)){
            if($user){
                Balance::create([
                    "name"=>$user->name,
                    "type"=>-1,
                    "amount"=>$request->amount,
                    "address"=>$user->address,
                    "iban"=>$user->iban,
                    "swift"=>$user->swift,
                    "account"=>$user->account,
                    "mobile"=>$user->mobile,
                    "ip"=>$request->ip()
                ]);
                return redirect()->route('inout')->with('alert-success', 'Withdraw completed');               
            }    
        }else{
            return redirect()->route('inout')->with('alert-error', 'invalied amount');
        }        
        return redirect()->route('inout')->with('alert-error', 'Require Login');
    }

    public function withdraw_user(Request $request){
        $user = Auth::user();

        $target = User::where('name',$request->name)->orWhere('email',$request->name)->first();

        if(!$target){
            return redirect()->back()->with('alert-error', 'invalid user');
        }

        if($user->name == $target->name || $user->email == $target->email){
            return redirect()->back()->with('alert-error', 'to equal address.');
        }

        
        if($this->isNumber($request->user_amount)){
            if($user){
                Balance::create([
                    "name"=>$user->name,
                    "type"=>-1,
                    "balance_type"=>'user',
                    "amount"=>$request->user_amount,
                    "address"=>$user->address,
                    "iban"=>'',
                    "swift"=>'',
                    "account"=>$target->name,
                    "mobile"=>$user->mobile,
                    "ip"=>$request->ip()
                ]);
                return redirect()->back()->with('alert-success', 'Withdraw completed');               
            }    
        }else{
            return redirect()->back()->with('alert-error', 'invalid amount');
        }        
        return redirect()->back()->with('alert-error', 'Require Login');
    }

    public function withdraw_otex(Request $request){
        $user = Auth::user();        
        
        if($this->isNumber($request->otex_amount)){
            if($user){
                if(!$user->otex) return redirect()->back()->with('alert-error', 'you didn`t set Otex Address. please contract administrator');

                Balance::create([
                    "name"=>$user->name,
                    "type"=>-1,
                    "balance_type"=>'otex',
                    "amount"=>$request->otex_amount,
                    "address"=>$user->address,
                    "iban"=>'',
                    "swift"=>'',
                    "account"=>$user->otex,
                    "mobile"=>$user->mobile,
                    "ip"=>$request->ip()
                ]);

                return redirect()->back()->with('alert-success', 'Withdraw completed');               
            }    
        }else{
            return redirect()->back()->with('alert-error', 'invalid amount');
        }        
        return redirect()->back()->with('alert-error', 'Require Login');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
        //
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
