<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Hash;
class ExternalFunctionController extends Controller
{
    //

    public function address(\App\Http\Requests\ExternalFunctionRequest $request){        
        
        $user = User::where('email',$request->email)->first();
    
        if($user && Hash::check($request->password,$user->password)){
            if($request->address){
                $user->otex = $request->address;
                $user->save();
            }
            return response()->json(['resultCode'=>0,'address'=>$user->address]);
        }else{
            return response()->json(['resultCode'=>0,"message"=>'회원 정보가 없거나 패스워드가 틀립니다.']);
        }
    }
}
