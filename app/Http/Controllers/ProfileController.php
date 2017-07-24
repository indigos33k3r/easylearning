<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    	$scripts = ["js/profile.js"];
    	if(!Auth::check()) {
    		return redirect('/login');
    	} else {
    		$id = Auth::id();
    		$user = User::find($id);
    		return view('profile', compact('user', 'scripts') );
    	}
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
        $scripts = ["js/profile.js"];
    	if(!Auth::check()) {
    		return redirect('/login');
    	} else {
    		$user = User::find($id);
    		// $user['created_at'] = substr($user['created_at'], 0 ,sizeof($user['created_at']) - 4);
    		return view('profile', compact('user', 'scripts') );
    	}
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
    	$user = User::find($id);
    	if($request->password !== null) {
    		$oldPasword  = $request->old_password;
    		$newPassword = $request->password;
    		if(Hash::check($oldPasword, $user->password)) {
    			$user->password = Hash::make($newPassword);
    			$user->save();
    			// flash session ?
    			session()->flash('change_password', 'Password changed');
    			return response()->json(true);
    		}
    		else {
    			return response()->json("wrong_password");
    		}
    	}
    	else {
    		$user->name = $request->name;
            $user->phone = $request->phone;
    		try {
    			$user->save();
    			session()->flash('profile_update_status', 'Profile updated');
    			return response()->json(true);
    		} catch (Exception $e) {
    			session()->flash('profile_update_status', 'fail');
    			return response()->json(false);	
    		}
    	}
		    
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

    public function remoteCheck(Request $request) 
    {
    	$type 	= $request->input('type');
    	$value 	= $request->input($type);
    	try {
    		if(Auth::check())
    			$user = User::where($type, $value)->where('id', '!=', Auth::id())->first();	
    		else 
    			$user = User::where($type, $value)->first();
    	} catch (Exception $e) {
    			
    	}
    	if($user !== null)
    		return response()->json(false);	
    	else
    		return response()->json(true);
    }
}
