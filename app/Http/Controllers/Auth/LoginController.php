<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }

    public function showLoginForm()
    {
    	$scripts		= ["js/login.js"];
    	return view('auth.login', ["scripts" => $scripts]);
    }

    public function login(Request $request)
    {
    	$remember 	= $request->input('remember');
    	if($remember != true) {
    		$remember = false;
    	}
    	$email		= $request->input('email');
        $user       = User::where('email', '=', $email)->first();
        if (! $user) {
            return response()->json(false);
        }
        if ($user->status != 'active') {
            return response()->json($user->status);
        }

    	$password 	= $request->input('password');
    	if(Auth::attempt(['email' => $email, 'password' => $password])) {
    		return response()->json(true);
    	} else {
    		return response()->json(false);
    	}

    
    }

}
