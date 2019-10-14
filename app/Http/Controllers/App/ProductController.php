<?php

namespace App\Http\Controllers\App;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use App\Utils\Utilities;

use App\Product;
use App\ProductDetail;
use App\Lot;

class ProductController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function showPageList($p = 1){
        $count = Product::all()->count();
        if($p > 1){
            $skip = ($p - 1) * 20;
            $products = Product::orderBy('id_product','desc')->skip($skip)->take(20)->get();
        }else{
            $products = Product::orderBy('id_product','desc')->take(20)->get();
        }
        
        $token = strtoupper(Utilities::getToken(8));
        return view('app.products.list', ['products' => $products, 'token' => $token, 'count' => $count, 'p' => $p]);
    }

    public function showPageDetail($external){
        $product = Product::where('external_id', $external)->first();

        if($product->size){
            $product->size = json_decode($product->size);
        }

        if($product->presentation){
            $product->presentation = json_decode($product->presentation);
        }

        return view('app.products.detail', ['product' => $product]);
    }

    public function addProduct(Request $request){
        $product = new Product;
        $product->fill($request->only(['code', 'name', 'description', 'price', 'type', 'category']));

        if($request->size){
            $size = explode(",", $request->size);
            $product->size = json_encode($size);
        }

        if($request->presentation){
            $presentation = explode(",", $request->presentation);
            $product->presentation = json_encode($presentation);
        }

        $product->expires = ($request->expires) ? 1:0;       
        $product->has_iva = ($request->iva) ? 1:0;       
        $product->external_id = Str::uuid();

        $product->save();

        return redirect('/products/view/'.$product->external_id)->with('success', 'El producto ha sido añadido correctamente.');
    }

    public function addProductDetail(Request $request){
        $detail = new ProductDetail;

        $detail->description = $request->description;
        $detail->id_product = $request->product;

        $detail->save();

        return redirect('/products/view/'.$request->external)->with('success', 'El detalle ha sido añadido correctamente.');
    }

    public function addProductLot(Request $request){
        $lot = new Lot;

        if ($request->expires == '1' || $request->expires == 1) {
            $lot->elaboration = $request->elaboration;
            $lot->expiry = $request->expiry;
        }else{
            $lot->elaboration = date('Y-m-d H:i:s');
            $lot->expiry = date('Y-m-d H:i:s');
        }        
        
        $lot->quantity = $request->quantity;

        $lot->id_product = $request->product;

        $lot->save();

        return redirect('/products/view/'.$request->external)->with('success', 'El lote ha sido añadido correctamente.');
    }

    public function editProduct(Request $request){
        $product = Product::where('external_id', $request->external_id)->first();

        $product->fill($request->only(['name', 'description', 'price', 'iva', 'type', 'category']));

        if($request->size){
            $size = explode(",", $request->size);
            $product->size = json_encode($size);
        }

        if($request->presentation){
            $presentation = explode(",", $request->presentation);
            $product->presentation = json_encode($presentation);
        }

        $product->has_iva = ($request->iva) ? 1:0;
        $product->expires = ($request->expires) ? 1:0;
        $product->save();

        return redirect('/products/view/'.$product->external_id)->with('success', 'El producto ha sido modificado correctamente.');
    }
}
