<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;

use App\Sale;
use App\SaleDetail;

use App\Order;

class SaleController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function showPageList(){
        return view('app.sales.list');
    }

    public function addSale(Request $request){
        $auth_user = auth()->user()->person; 
        
        $sale = new Sale([
            "code" => $request->code,
            "total" => $request->total,
            "payment_method" => $request->payment_method
        ]);

        $sale->external_id = Str::uuid();
        $sale->customer = $request->customer;
        $sale->id_person = $auth_user->id_person;

        $sale->save();

        $details = [];

        for ($i = 0; $i < count($request->quantity); $i++) { 
            $detail = new SaleDetail(['quantity' => $request->quantity[$i], 'parcial' => $request->parcial[$i], 'id_sale' => $sale->id_sale, 'id_product' => $request->id_product[$i]]);
            array_push($details, $detail);
        }

        $sale->details()->saveMany($details);

        $order = Order::where('code', $request->code)->first();
        $order->state = "Despachado";
        $order->save();

        return redirect('/orders')->with('success', 'La orden ha sido despachada correctamente.');
    }
}
