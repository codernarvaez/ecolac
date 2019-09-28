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
        return view('app.config.main');
    }
}
