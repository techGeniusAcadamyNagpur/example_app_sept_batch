<?php

namespace App\Http\Controllers;

use DB;
use Hash;
use Auth;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function LoginProcced(Request $request){
        $this->validate($request, [
            'email'=>'required',
            'password'=>'required',
        ]);

        $email = $request->input('email');
        $password = $request->input('password');

        

        $credentials=$request->only('email','password');
        
        if(Auth::attempt($credentials)){

            return redirect(url('dashboard'))->with('success', 'Login Successful');

        }else{

            return redirect(url('login'))->with('fail', 'Login Failed');

        }

    }
}
