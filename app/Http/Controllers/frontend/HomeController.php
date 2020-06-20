<?php

namespace App\Http\Controllers\frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\models\product;

class HomeController extends Controller
{
    function getIndex() {
        $data['prdNew']= product::where('img','<>','no-img.jpg')
        ->orderBy('id','desc')->take(4)->get();

        $data['prdHot']= product::where('img','<>','no-img.jpg')
        ->where('featured',1)->orderBy('id','desc')->take(4)->get();

        return view('frontend.index',$data);
    }
    function getAbout() {
        return view('frontend.about');
    }

    function getContact() {
        return view('frontend.contact');
    }
}
