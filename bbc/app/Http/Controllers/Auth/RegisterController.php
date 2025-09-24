<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Auth\Events\Registered;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string','min:3', 'max:255','unique:users'],
            'country' =>['required','string','max:64'],
            'mobile' =>['required','regex:/^([0-9\s\-\+\(\)]*)$/','max:64'],            
            'account' => ['nullable', 'string','min:3', 'max:64'],
            'iban' => ['nullable', 'string','min:3', 'max:64'],
            'swift' => ['nullable', 'string','min:3', 'max:64'],
            'email' => ['required', 'string', 'email','min:8' ,'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:4', 'confirmed'],
            'recommander' =>['required','string','min:3','max:255','exists:users,name'],            
            //'recommander' =>['nullable','string','min:3','max:255','exists:users,name'],            
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        $recommander = User::where('name',$data['recommander'])->first();
        $store = ($data['recommander'] ? $data['recommander']:'');
        $super = $recommander->super;
        if($recommander->level >= 9)
        {
            $store='';
        }

        $hq = "";
        $dist = "";

        if($recommander->type == 3){
            $hq = $recommander->name;
        }else if($recommander->type == 2){            
            $hq = $recommander->hq;
            $dist = $recommander->name;
        }else if($recommander->type == 1){
            $hq = $recommander->hq;
            $dist = $recommander->dist;
        }

        return User::create([
            'name' => strtolower($data['name']),
            'email' => strtolower($data['email']),
            'recommander'=> $store,
            'super'=>$super,
            'hq'=>$hq,
            'dist'=>$dist,
            'store'=>$store,
            'country'=>$data['country'],
            //'iban'=>$data['iban'],
            //'swift'=>$data['swift'],
            //'account'=>$data['account'],
            'password' => Hash::make($data['password']),
            'mobile' => $data['mobile'],
            'api_token' => Str::random(60),
        ]);
    }

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();      
        
        $partner = User::where("name",$request->recommander)->first();        
        if($partner){
            // 만약 레벨 3 이상만 추천인 자격이 있다면
            if($partner->level < 3) { // <-- '1'을 '3'으로 변경
                return redirect()->back()->withErrors(["recommander"=>'추천인 자격이 없는 사용자입니다.']) // 메시지도 변경
                ->withInput();
            }            
        }else {            
            return redirect()->back()                        
                            ->withErrors(["recommander"=>'추천인 아이디를 찾을 수 없습니다.'])
                            ->withInput();
        }

        
        $user = $this->create($request->all());

        if(!$user) return redirect()->back()->with('error','회원가입에 실패했습니다.');

        event(new Registered($user));

        $this->guard()->login($user);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}