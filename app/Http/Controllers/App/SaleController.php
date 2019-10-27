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

    public function showPageList($p = 1){
        $count = Sale::all()->count();
            
        if($p > 1){
            $skip = ($p - 1) * 20;
            $sales = Sale::orderBy('id_sale','desc')
                    ->skip($skip)
                    ->take(20)
                    ->get();
        }else{
            $sales = Sale::orderBy('id_sale','desc')->take(20)->get();
        }
        
        return view('app.sales.list', ["sales" => $sales, 'count' => $count, 'p' => $p, 'search' => '']);
    }

    public function searchSales(Request $request, $p = 1){
        if(strlen($request->text) >= 3){
            $count = Sale::where('code', 'regexp', $request->text)->count();

            if($p > 1){
                $skip = ($p - 1) * 20;
                $sales = Sale::where('code', 'regexp', $request->text)
                        ->orderBy('id_sale','desc')
                        ->skip($skip)
                        ->take(20)
                        ->get();
            }else{
                $sales = Sale::where('code', 'regexp', $request->text)->orderBy('id_sale','desc')->take(20)->get();
            }
            
            return view('app.sales.list', ["sales" => $sales, 'count' => $count, 'p' => $p, 'search' => $request->text]);
        }else{
            return redirect()->route('sales');
        }
        
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

    public function setPaid(Request $request){
        $sale = Sale::where('external_id', $request->external)->first();
        $sale->paid = true;
        $sale->save();

        return redirect('/sales')->with('success', 'La venta ha sido pagada correctamente.');
    }
}
