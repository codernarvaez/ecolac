<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use App\Utils\Utilities;

use App\Order;
use App\OrderDetail;

class OrderController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function showPageList(){
        $orders = Order::orderBy('id_order','desc')->take(20)->get();
        return view('app.orders.list', ['orders' => $orders]);
    }

    public function showAddOrder(){
        $token = strtoupper(Utilities::getToken(10));
        return view('app.orders.new', ['token' => $token]);
    }

    public function addOrder(Request $request){
        $auth_user = auth()->user()->person;  

        $order = new Order;
        $order->fill($request->only(['code', 'observations']));
        $order->external_id = Str::uuid();
        $order->customer = $request->customer;
        $order->id_person = $auth_user->id_person;

        $order->save();

        $details = [];

        for ($i = 0; $i < count($request->quantity); $i++) { 
            $detail = new OrderDetail(['quantity' => $request->quantity[$i], 'id_order' => $order->id_order, 'id_product' => $request->id_product[$i]]);
            array_push($details, $detail);
        }

        $order->details()->saveMany($details);

        return redirect('/orders/new')->with('success', 'La orden ha sido guardada correctamente.');
    }
}
