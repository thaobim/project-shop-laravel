<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\models\order;
use Carbon\Carbon;
use Illuminate\Http\Request;

class IndexController extends Controller
{
    function getIndex() {
        $monthNow = Carbon::now()->month;
        $yearNow = Carbon::now()->year;
        $data['month']=$monthNow;
        $data['order']=order::where('state',2)
        ->whereMonth('updated_at',$monthNow)
        ->whereYear('updated_at',$yearNow);


        for ($i=1; $i <= $monthNow; $i++) {
            $data['dT']['Tháng '.$i]=order::where('state',2)
            ->whereMonth('updated_at',$i)
            ->whereYear('updated_at',$yearNow)->sum('total');
        }
        return view('backend.index',$data);
    }
}
