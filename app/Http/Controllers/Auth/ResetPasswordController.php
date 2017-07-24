<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Auth;

use App\PasswordReset;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }
    
    public function showResetForm(Request $request, $token = null)
    {
    	$scripts = ["js/reset_password.js"];
    	if($request->email === null && $token !== null){
    		$record = PasswordReset::where('token', $token)->first();
    		if($record !== null)
    			$email = $record->email;	
    		else
    			return view('auth.passwords.reset', ['token' => "expired", "scripts" => $scripts]);
    	}
    	else {
    		$email = $request->email;
    	}
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $email , 'scripts' => $scripts]
        );
    }

    public function reset(Request $request)
    {
        $this->validate($request, $this->rules(), $this->validationErrorMessages());

        // Here we will attempt to reset the user's password. If it is successful we
        // will update the password on an actual user model and persist it to the
        // database. Otherwise we will parse the error and return the response.
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $this->resetPassword($user, $password);
            }
        );

        // If the password was successfully reset, we will redirect the user back to
        // the application's home authenticated view. If there is an error we can
        // redirect them back to where they came from with their error message.
        return $response == Password::PASSWORD_RESET
                    ? $this->sendResetResponse($response)
                    : $this->sendResetFailedResponse($request, $response);
    }
    
    protected function resetPassword($user, $password)
    {

       		$user->forceFill([
       		    'password' => bcrypt($password),
       		    'remember_token' => Str::random(60),
       		])->save();

       		return true;
        // $this->guard()->login($user);
    }
    /**
     * Get the response for a successful password reset.
     *
     * @param  string  $response
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function sendResetResponse($response)
    {
        // return redirect($this->redirectPath())
                            // ->with('status', trans($response));
    	return response()->json(true);
    }
}
