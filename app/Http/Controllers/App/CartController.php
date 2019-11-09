<?php

namespace App\Http\Controllers\App;

use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

use App\Mail\OrderStatus;
use App\Utils\Utilities;

use App\Product;
use App\Order;
use App\OrderDetail;
use App\Person;

class CartController extends Controller
{
    public function addToCart(Request $request){
        $user_id = auth()->user()->person->id_person;
        $product = Product::where('id_product', $request->product)->first();

        \Cart::session($user_id)->add(array(
            'id' => $product->id_product,
            'name' => $product->name,
            'price' => $product->price,
            'quantity' => 1,
            'attributes' => array(
              'image' => $product->images[0]->path
            )
        ));

        $cart = \Cart::session($user_id)->getContent();

        return $cart;
    }

    public function addToItem(Request $request){
        $user_id = auth()->user()->person->id_person;

        \Cart::session($user_id)->update($request->product, array(
            'quantity' => 1,
        ));

        return ['response' => true];
    }

    public function revomeFromItem(Request $request){
        $user_id = auth()->user()->person->id_person;

        \Cart::session($user_id)->update($request->product, array(
            'quantity' => -1,
        ));

        return ['response' => true];
    }

    public function addOrder(Request $request){
        $auth_user = auth()->user()->person;  

        $order = new Order;
        $order->code = strtoupper(Utilities::getToken(10));
        $order->external_id = Str::uuid();
        $order->customer = $auth_user->id_person;
        $order->id_person = $auth_user->id_person;

        $order->save();

        
        $details = [];

        $cart = \Cart::session($auth_user->id_person)->getContent();

        foreach ($cart as $item) { 
            $detail = new OrderDetail(['quantity' => $item->quantity, 'id_order' => $order->id_order, 'id_product' => $item->id]);
            array_push($details, $detail);
        }

        $order->details()->saveMany($details);

        $customer = Person::where('id_person', $order->customer)->first();

        Mail::to($customer->email)
                ->queue(new OrderStatus($order));

        \Cart::session($auth_user->id_person)->clear();

        return redirect('/')->with('success', 'Su orden ha sido registrada correctamente.');
    }
}
