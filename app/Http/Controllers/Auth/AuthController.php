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
//        $this->middleware('guest', ['except' => 'getLogout']);
//        $this->middleware('guest', ['except' => 'getLogout']);
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
    
    public function postForget(){
        $user = User::where('email', \Input::get('email'))->first();
        if($user->count()){
            $code = str_random(60);
            $user->code = $code;
//            $password = str_random(10);
            $password = 'password';
            $user->password_temp = bcrypt($password);

            if($user->save()){
                \Mail::queue('emails.auth.forget', [
                    'link' => route('recover', $code),
                    'name' => $user->name,
                    'password' => $password
                ], function($message) use ($user){
                    $message->to($user->email)->subject('Your new password');
                });

                return redirect()->route('login')->with('global', 'We have sent you a new password by email!');
            }
        }
    }

    public function getRegister() {
        return view('auth.register');
    }
    
    public function postRegister(){
        $user = new User;
        $user->name = \Input::get('name');
        $user->email = \Input::get('email');
        $user->password = bcrypt(\Input::get('password'));
        $user->admin = 0;
        $user->active = 0;
        $code = str_random(60);
        $user->code = $code;
        $user->save();
        //Check mail as it's not correct
        //use tinker to test
        \Mail::queue('emails.auth.activate', ['link' => route('activate', $code), 'name' => $user->name], function ($m) use ($user) {
            $m->to($user->email, $user->name)->subject('Activate your account!');
        });
        return redirect()->route('login')->with('global', 'Success. Check your mail for activation mail');
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
    
    public function recover($code){
		$user = User::where('code', '=', $code)->where('password_temp', '!=', '')->first();

		if($user->count()){
			$user->password = $user->password_temp;
			$user->password_temp = '';
			$user->code = '';

			if($user->save()){
				return redirect()->route('login')->withGlobal('Your account has been recovered and you can signin with your new password!');
			}
		}

		return redirect()->route('login')->withWarning('Could not recover your account!');

	}
    
    public function getChangePassword(){
        return view('auth.change-password');
    }
    
    public function postChangePassword(){
        $validator = Validator::make(\Input::all(),[
			'old_password' => 'required',
			'new_password' => 'required|min:6',
			'password_confirmation' => 'required|same:new_password'
		]);

		if($validator->fails()){
			return redirect()->back()->withErrors($validator);
		} else{

			$user = User::find(\Auth::user()->id);

			$old_password = \Input::get('old_password');
			$new_password = \Input::get('new_password');

			if($old_password == $new_password)
                    return redirect()->back()->withErrors(array('new_password' => 'Your new password must be different from the old one.'));

			if(\Hash::check($old_password, $user->getAuthPassword())){
				$user->password = \Hash::make($new_password);
				if($user->save())
					return redirect()->route('index')->withGlobal('Your password has been changed successfully!');
			} else{
				return redirect()->back()->withErrors(array('old_password' => 'Your old password is incorrect!'));
			}

		}
		return redirect()->back()->withWarning('Sorry, your password cannot be changed!');
    }
}
