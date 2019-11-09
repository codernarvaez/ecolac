<?php

namespace App\Http\Controllers\Auth;


use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Controller;

use App\Role;

class LoginController extends Controller{
    public function __construct(){
        $this->middleware('guest')->only('showLogin');
    }

    public function showLogin(){
        return view('auth.login');
    }

    public function login(){
        $credentials = $this->validate(request(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if(Auth::attempt($credentials)){
            if(auth()->user()->person->role->name == "Superadmin" || auth()->user()->person->role->name == "Administrador"){
                return redirect()->route('products');
            }elseif (Auth::user()->person->role->name == "Cliente") {
                return redirect('/');
            }else{
                return redirect()->route('sales');
            }            
        }

        return back()->with('status', 'El usuario o contraseña es incorrecto');
    }

    public function logout(){
        Auth::logout();
        return redirect('/login');
    }
}
