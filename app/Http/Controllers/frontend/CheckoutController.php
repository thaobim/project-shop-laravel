<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\Http\Requests\CheckoutRequest;
use Illuminate\Http\Request;
use Cart;
use App\models\order;
use App\models\productOrder;

class CheckoutController extends Controller
{
    function getCheckout() {
        $data['cart'] = Cart::content();
        // dd(Cart::content()->toarray());
        return view('frontend.checkout.checkout',$data);
    }
    function getComplete($orderId) {
        $data['order']=order::find($orderId);
        return view('frontend.checkout.complete',$data);
    }

    function postCheckout(CheckoutRequest $r){
        $order = new order;
        $order->full=$r->full;
        $order->email=$r->email;
        $order->address=$r->address;
        $order->phone=$r->phone;
        $order->total=Cart::total(0,'','');
        $order->state=1;
        $order->save();
        foreach (Cart::content() as $row) {
            $prd = new productOrder;
            $prd->code= $row->options->code;
            $prd->name= $row->name;
            $prd->price= $row->price;
            $prd->qty= $row->qty;
            $prd->img= $row->options->img;
            $prd->order_id=$order->id;
            $prd->save();
        }
        Cart::destroy();
        return redirect('/checkout/complete/'.$order->id);
    }
}
