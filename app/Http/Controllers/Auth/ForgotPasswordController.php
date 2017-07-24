<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\User;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
    	$scripts = ["js/reset_password.js"];
    	return view('auth.passwords.email', ["scripts" => $scripts]);
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
    		return response()->json(true);	
    	else
    		return response()->json(false);
    }
}
