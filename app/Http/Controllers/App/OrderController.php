<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Utils\Utilities;

class OrderController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function showPageList(){
        return view('app.orders.list');
    }

    public function showAddOrder(){
        $token = strtoupper(Utilities::getToken(10));
        return view('app.orders.new', ['token' => $token]);
    }
}
