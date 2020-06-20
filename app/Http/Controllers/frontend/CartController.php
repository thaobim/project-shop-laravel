<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\models\product;
use Illuminate\Http\Request;
use Cart;

class CartController extends Controller
{
    function getCart() {
        // dd(Cart::content()->toarray());
        $data['cart']= Cart::content();
        return view('frontend.cart.cart',$data);
    }

    function postCart(Request $r){
        $prd = product::find($r->id_product);
        Cart::add(['id' => $prd->id,
                'name' => $prd->name,
                'qty' => $r->quantity,
                'price' => $prd->price,
                'weight' => 0,
                'options' => ['code' => $prd->code,'img'=> $prd->img]]);

        return redirect('/cart');
    }

    function delCart($rowId){
        Cart::remove($rowId);
        return redirect('/cart');
    }

    function updateCart($rowId,$qty){
        Cart::update($rowId,$qty);
        return 'success';
    }
}
