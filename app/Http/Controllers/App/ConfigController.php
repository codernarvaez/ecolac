<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ConfigController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function showMainPage(){
        return redirect()->route('config-account');
    }

    public function showAccountConfig(){
        return view('app.config.account');
    }

    public function showSystemConfig(){
        return view('app.config.system');
    }

    public function setConfigEmail(Request $request){
        config(['mail.from.name' => $request->name]);
        config(['mail.from.address' => $request->email]);

        return back()->with('success', 'Se han fijado las nuevas configuraciones del sistema.');
    }
}
