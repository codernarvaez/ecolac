<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class SaleController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function showPageList(){
        return view('app.sales.list');
    }
}
