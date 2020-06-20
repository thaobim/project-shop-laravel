<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\order;

class OrderController extends Controller
{
    function getOrder() {
        $data['order']=order::where('state',1)->orderBy('updated_at','desc')->get();
        return view('backend.order.order',$data);
    }

    function getDetail($idOrder) {
        $data['order']=order::find($idOrder);
        return view('backend.order.detailorder',$data);
    }
    function getProcessed() {
        $data['order']=order::where('state',2)->orderBy('updated_at','desc')->get();
        return view('backend.order.processed',$data);
    }
    function xuLy($idOrder){
        $order = order::find($idOrder);
        $order->state = 2;
        $order->save();
        return redirect('/admin/order/processed');
    }
}
