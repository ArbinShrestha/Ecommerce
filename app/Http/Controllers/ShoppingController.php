<?php

namespace App\Http\Controllers;

use App\Product;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class ShoppingController extends Controller
{
    public function add_to_cart()
    {

        $pdt = Product::find(request()->pdt_id);

        $cartItem = Cart::add([
            'id'=>$pdt->id,
            'name' => $pdt->name,
            'qty' => request()->qty,
            'price' => $pdt->price,
        ]);

        Cart::associate($cartItem->rowId, 'App\Product');

        Session::flash('success', 'product added to cart');

        return redirect('cart');
    }

    public function cart()
    {

        return view('cart');
    }

    public function cart_delete($id)
    {
        Cart::remove($id);

        Session::flash('success', 'product removed from cart');

        return redirect()->back();
    }

    public function incr($id, $qty)
    {
        Cart::update($id, $qty + 1);

        Session::flash('success', 'product quantity updated');

        return redirect()->back();
    }

    public function decr($id, $qty)
    {
        Cart::update($id, $qty - 1);

        Session::flash('success', 'product quantity updated');

        return redirect()->back();
    }

    public function rapid_add($id)
    {
        $pdt = Product::find($id);

        $cartItem = Cart::add([
            'id'=>$pdt->id,
            'name' => $pdt->name,
            'qty' => 1,
            'price' => $pdt->price,
        ]);

        Cart::associate($cartItem->rowId, 'App\Product');

        Session::flash('success', 'product added to cart');

        return redirect()->route('cart');
    }
}
