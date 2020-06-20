<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Auth;

class LoginController extends Controller
{
    function getLogin() {
        return view('backend.login.login');
    }

    function postLogin(LoginRequest $r){
        $email=$r->email;
        $password=$r->password;
        if (Auth::attempt(['email' => $email, 'password' => $password])) {
            return redirect('/admin');
        }else{
            return redirect()->back()->withInput()->withErrors(['email'=>'Email hoặc password không chính xác !']);
        }
    }
    function getLogout(){
        Auth::logout();
        return redirect('/login');
    }
}
