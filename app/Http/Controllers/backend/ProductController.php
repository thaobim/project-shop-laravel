<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\AddProductRequest;
use App\Http\Requests\EditProductRequest;
use App\models\Category;
use App\models\product;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    function getProduct() {
        $data['products']=product::paginate(4);
        return view('backend.product.listproduct',$data);
    }

    function getAddProduct() {
        $data['categories']=Category::all();
        return view('backend.product.addproduct',$data);
    }

    function getEditProduct($idPrd) {
        $data['categories']=Category::all();
        $data['prd']=product::find($idPrd);
        return view('backend.product.editproduct',$data);
    }

    function postAddProduct(AddProductRequest $r) {
       $prd = new product;
        $prd->code=$r->code;
        $prd->name=$r->name;
        $prd->slug=Str::slug($r->name, '-');
        $prd->price=$r->price;
        $prd->featured=$r->featured;
        $prd->state=$r->state;
        $prd->info=$r->info;
        $prd->describe=$r->describe;

        if ($r->hasFile('img')) {
            $file=$r->img;    //lấy file ảnh
            $fileName=Str::slug($r->name, '-').'.'.$file->getClientOriginalExtension(); //lấy tên ảnh
            $prd->img=$fileName;    //lưu tên ảnh vào database
            $file->move('backend/img',$fileName);  //lưu vào public/backend/img
        } else {
            $prd->img='no-img.jpg';
        }

        $prd->category_id=$r->category;
        $prd->save();
        return redirect('/admin/product')->with('thongbao','Đã thêm thành công');
    }

    function postEditProduct(EditProductRequest $r,$idPrd) {
        $prd= product::find($idPrd);
        $prd->code=$r->code;
        $prd->name=$r->name;
        $prd->slug=Str::slug($r->name, '-');
        $prd->price=$r->price;
        $prd->featured=$r->featured;
        $prd->state=$r->state;
        $prd->info=$r->info;
        $prd->describe=$r->describe;

        if ($r->hasFile('img')) {
            if ($prd->img!='no-img.jpg') {
                unlink('backend/img/'.$prd->img);
            }
            $file=$r->img;    //lấy file ảnh
            $fileName=Str::slug($r->name, '-').'.'.$file->getClientOriginalExtension(); //lấy tên ảnh
            $prd->img=$fileName;    //lưu tên ảnh vào database
            $file->move('backend/img',$fileName);  //lưu vào public/backend/img
        }else{
            if ($r->name!='') {
                $oldName=$prd->img;
                $arr= explode(".",$oldName);   //cắt chuỗi thành các phần tử trong 1 mảng
                $newName=Str::slug($r->name, '-').'.'.array_pop($arr);   // array_pop() : lấy phần tử cuối trong mảng
                rename(public_path('backend/img/'.$oldName), public_path('backend/img/'.$newName));
                $prd->img=$newName;
            }
        }

        $prd->category_id=$r->category;
        $prd->save();
        return redirect('/admin/product')->with('thongbao','Đã sửa thành công');
    }
    function DelProduct($idPrd){
        product::find($idPrd)->delete();
        return redirect('/admin/product')->with('thongbao','Đã xóa thành công');
    }
}
