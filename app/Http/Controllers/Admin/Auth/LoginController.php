<?php

namespace App\Http\Controllers\Admin\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest.admin', ['except' => 'logout']);
    }

    public function index() {
        $scripts  = ["adm/js/login.js"];
        return view('admin.auth.login', ["scripts" => $scripts]);
    }

    public function logout() {
        $auth = Auth::guard('admins');
        $auth->logout();
        return redirect('admin/login');
    }
    

    public function store(Request $request) {
        $auth       = Auth::guard('admins');
        $remember   = $request->input('remember');
        if ($remember != true) {
            $remember = false;
        }
        $email      = $request->input('email');
        $password   = $request->input('password');
        if ($auth->attempt(["email" => $email, "password" => $password], $remember)) {
            return response()->json(true);
        } else {
            return response()->json('false');
        }
    }


    /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admins');
    }
}
