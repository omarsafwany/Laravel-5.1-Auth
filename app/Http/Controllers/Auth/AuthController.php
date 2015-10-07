<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Validator;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Foundation\Auth\AuthenticatesAndRegistersUsers;
use App\Http\Requests\auth\LoginRequest;

class AuthController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Registration & Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users, as well as the
    | authentication of existing users. By default, this controller uses
    | a simple trait to add these behaviors. Why don't you explore it?
    |
    */

    use AuthenticatesAndRegistersUsers, ThrottlesLogins;
    protected $redirectPath = '/dashboard';
    protected $loginPath = '/login';

    /**
     * Create a new authentication controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'getLogout']);
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
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|confirmed|min:6',
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
//    protected function create(array $data)
//    {
////        return 'y';
////        $code = str_random(60);
////        \Mail::queue('emails.auth.activate', [
////                'link' => route('activate', $code),
////                'name' => $data['name']],
////                function($message) use ($user){
////                    $message->to($user->email, $user->name)->subject('Activate your account');
////                }
////            );
////        return 'x';
////        return \User::create([
////            'name' => $data['name'],
////            'email' => $data['email'],
////            'password' => bcrypt($data['password']),
////            'active' => 0,
////            'admin' => 0,
////            'code' => $code
////        ]);
//    }
    
    public function getLogin() {
        return view('auth.login');
    }
    
    public function postLogin(LoginRequest $request)
    {
        if (\Auth::attempt(['email' => \Input::get('email'), 'password' => (\Input::get('password')), 'active' => 1])) {
            // Authentication passed...
            if(\Auth::user()->admin){
                return redirect()->intended('admin');
            }else{
                return redirect()->intended('dashboard');
            } 
        }else{
            return redirect()->route('login')->with('activate', 'Accout not acctivated');
        }
    }
    
    public function getForget() {
        return view('auth.forget-password');
    }

    public function getRegister() {
        return view('auth.register');
    }
    
    public function postRegister(){
//        return \Input::all();
        $user = new User;
        $user->name = \Input::get('name');
        $user->email = \Input::get('email');
        $user->password = bcrypt(\Input::get('password'));
        $user->admin = 0;
        $user->active = 0;
        $code = str_random(60);
        $user->code = $code;
        $user->save();
        \Mail::queue('emails.auth.activate', [
                'link' => route('activate', $code),
                'name' => \Input::get('name')],
                function($message) use ($user){
                    $message->to($user->email, $user->name)->subject('Activate your account');
                }
            );
        return 'x';
//        return \User::create([
//            'name' => $data['name'],
//            'email' => $data['email'],
//            'password' => bcrypt($data['password']),
//            'active' => 0,
//            'admin' => 0,
//            'code' => $code
//        ]);
    }
    
    public function activate($code){
		$user = User::where('code' ,'=', $code)->where('active', '=', 0);

		if($user->count()){
			$user = $user->first();
			$user->active = 1;
			$user->code = '';

			if($user->save()){
				return redirect()->route('login');
			}
		}

		return redirect()->route('/');
	}
}
