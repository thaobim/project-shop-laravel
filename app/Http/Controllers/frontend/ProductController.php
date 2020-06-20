<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use App\models\Category;
use Illuminate\Http\Request;
use App\models\product;

class ProductController extends Controller
{
    function getShop(request $r) {
        
        if ($r->start!='') {
            $data['categories']=Category::all();
            $data['product']=product::where('img','<>','no-img.jpg')
            ->whereBetween('price',[$r->start,$r->end])->paginate(6);
        } else {
            $data['product']=product::where('img','<>','no-img.jpg')->paginate(6);
            $data['categories']=Category::all();
        }

        return view('frontend.product.shop',$data);
    }

    function getDetail($prdSlug) {
        $arr = explode("-",$prdSlug);
        $id = array_pop($arr);
        $data['prd']= product::find($id);
        return view('frontend.product.detail',$data);
    }

    function getCate($slugCate,Request $r){
        if ($r->start!='') {
            $data['categories']=Category::all();
            $data['product']=Category::where('slug',$slugCate)->first()
            ->product()->whereBetween('price',[$r->start,$r->end])->paginate(3);
        } else {
            $data['categories']=Category::all();
            $data['product']=Category::where('slug',$slugCate)->first()
            ->product()->paginate(3);
        }
        return view('frontend.product.shop',$data);
    }
}
