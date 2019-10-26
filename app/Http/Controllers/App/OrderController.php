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

    public function showPageList($p = 1){
        $count = Order::where('state', '!=', 'Despachado')->count();

        if($p > 1){
            $skip = ($p - 1) * 20;
            $orders = Order::where('state', '!=', 'Despachado')
                ->orderBy('id_order','desc')
                ->skip($skip)
                ->take(20)
                ->get();
        }else{
            $orders = Order::where('state', '!=', 'Despachado')
                ->orderBy('id_order','desc')
                ->take(20)
                ->get();
        }
        
        return view('app.orders.list', ['orders' => $orders, 'count' => $count, 'p' => $p]);
    }

    public function showAddOrder(){
        $token = strtoupper(Utilities::getToken(10));
        return view('app.orders.new', ['token' => $token]);
    }
    
    public function viewOrder($external){
        $order = Order::with(['details', 'seller', 'client'])->where('external_id', $external)->first();

        $details_array = [];
        
        foreach ($order->details as $detail) {
            $item = ["product" => $detail->product->external_id, "price" => $detail->product->price, "qty" => $detail->quantity];
            array_push($details_array, $item);
        }

        return view('app.orders.complete', ['order' => $order, 'array' => json_encode($details_array)]);
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

    public function cancelOrder(Request $request){
        $order = Order::where('external_id', $request->external)->first();
        $order->state = "Cancelado";
        $order->save();

        return redirect('/orders')->with('success', 'La orden ha sido cancelada correctamente.');
    }
}
