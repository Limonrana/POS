<?php

namespace App\Http\Controllers\Pos;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getCart($id)
    {
        $url = $id;
        $user = Auth::id();
//        $explode = explode('/', $url);
        if ($url == "purchase") {
            $type = 1;
        } else {
            $type = 2;
        }
        $cart = Cart::where('user_id', $user)->where('type', $type)->get();
        return response()->json($cart);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $url = $request->url;
        $explode = explode('/', $url);
        $user = Auth::id();
        $product_id = $request->id;
        $product = Product::where('id', $product_id)->first();
        if ($explode[1] == "purchase") {
            $type = 1;
        } else {
            $type = 2;
        }
        $getCart = Cart::where('product_id', $product_id)->where('type', $type)->first();
        if ($getCart) {
            $cartU = Cart::where('id', $getCart->id)->where('user_id', $user)->where('type', $type)->first();
            $cartU->qty = $cartU->qty + 1;
            $cartU->subtotal = $cartU->qty * $getCart->price;
            $cartU->save();
        } else {
            $cart = new Cart();
            $cart->product_id   = $product_id;
            $cart->user_id      = $user;
            $cart->product_name = $product->title;
            if ($explode[1] == "purchase") {
                $cart->qty          = 1;
            } else {
                if ((int)$product->stock < 1) {
                    return response()->json('Product stock out.');
                } else {
                    $cart->qty          = 1;
                }
            }
            if ($explode[1] == "purchase") {
                $cart->price        = $product->buying_price;
                $cart->subtotal     = $product->buying_price;
            } else {
                $cart->price        = $product->selling_price;
                $cart->subtotal     = $product->selling_price;
            }
            $cart->photo_url    = $product->photo->image_path;
            $cart->freight_cost = $product->freight_cost;
            if ($explode[1] == "purchase") {
                $cart->type     = 1;
            } else {
                $cart->type     = 2;
            }
            $cart->save();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update($id)
    {
        $user = Auth::id();
        $cart = Cart::where('id', $id)->where('user_id', $user)->first();
        $qty = $cart->qty + 1;
        $product = Product::find($cart->product_id);
        if ($product->stock < $qty && $cart->type == 2) {
            return response()->json('stock-out');
        }
        else {
            $cart->qty = $cart->qty + 1;
            $cart->subtotal = $cart->qty * $cart->price;
            $cart->save();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cartUpdate(Request $request, $id)
    {
        $user = Auth::id();
        $cart = Cart::where('id', $id)->where('user_id', $user)->first();
        if ($cart->qty == 1) {
            $cart->delete();
        } else {
            $cart->qty = $cart->qty - 1;
            $cart->subtotal = $cart->qty * $cart->price;
            $cart->save();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function qtyUpdate(Request $request, $id, $qty)
    {
        $user = Auth::id();
        $cart = Cart::where('id', $id)->where('user_id', $user)->first();
        $product = Product::find($cart->product_id);
        if ($product->stock < $qty && $cart->type == 2) {
            return response()->json('stock-out');
        }
        else {
            if ($qty == 0) {
                $cart->delete();
            }
            else {
                $cart->qty = $qty;
                $cart->subtotal = $qty * $cart->price;
                $cart->save();
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cartPrice(Request $request, $id)
    {
        $user = Auth::id();
        $cart = Cart::where('id', $id)->where('user_id', $user)->first();
        $cart->price = $request->price;
        $cart->subtotal = $cart->qty * $request->price;
        $cart->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $user = Auth::id();
        $cart = Cart::where('id', $id)->where('user_id', $user)->first();
        $cart->delete();
    }
}
