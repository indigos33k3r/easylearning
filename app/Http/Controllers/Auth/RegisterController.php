<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Str;
use App\User;
use Validator;
use Mail;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after login / registration.
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
            'name' => 'required|max:255',
            'phone' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            'password' => 'required|min:6|confirmed'
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $activation_token = Str::random('10');
        $status = "unconfirmed";
        $link   = url('/') . "/register/confirm?e=". $data['email'] . "&t=" . $activation_token;
        Mail::send('emails.registration', ["link" => $link], function ($m) use ($data) {
            $m->from('david@app.com', 'Your Application');
            $m->to($data['email'], $data['name'])->subject('Confirm your account!');
        });
        return User::create([
            'name' => $data['name'],
            'phone' => $data['phone'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'status' => $status,
            'activation_token' => $activation_token
        ]);
    }

    public function confirm(Request $request) {
        $user = User::where("email", '=', $request->input('e'))->first();
        if ($user->activation_token == $request->input('t')) {
            $scripts        = ['js/auth/activated.js'];
            $user->status = 'active';
            $user->save();
            Auth::login($user);
            return view('auth.activated', ['scripts' => $scripts]);
        }
    }

    public function showRegistrationForm()
    {
    	$scripts		= ['js/register.js'];
    	$styleSheets	= [];

    	return view('auth.register', ['scripts' => $scripts, 'styleSheets' => $styleSheets]);
    }

    public function remoteCheck(Request $request) 
    {
    	$type 	= $request->input('type');
    	$value 	= $request->input($type);
    	try {
    		$user 	= User::where($type, $value)->first();	
    	} catch (Exception $e) {
    			
    	}
    	if($user !== null)
    		return response()->json(false);	
    	else
    		return response()->json(true);
    }
}
