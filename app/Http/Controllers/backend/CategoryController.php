<?php

namespace App\Http\Controllers\backend;

use App\Http\Controllers\Controller;
use App\Http\Requests\AddCategoryRequest;
use Illuminate\Http\Request;
use App\models\Category;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    function getCategory() {
        $data['categories'] = Category::all();
        return view('backend.category.category',$data);
    }

    function getEditCategory($idCate) {
        $data['categories']=Category::all();
        $data['cate']=Category::find($idCate);
        return view('backend.category.editcategory',$data);
    }

    function postCategory(AddCategoryRequest $r){
        $cate = new Category;
        $cate->name=$r->name;
        $cate->slug=Str::slug($r->name, '-');
        $cate->parent=$r->parent;
        $cate->save();
        return redirect()->back()->with('thongbao','Đã thêm thành công');
    }
    function postEditCategory(request $r,$idCate){
        $cate = Category::find($idCate);
        $cate->name=$r->name;
        $cate->slug=Str::slug($r->name, '-');
        $cate->parent=$r->parent;
        $cate->save();
        return redirect()->back()->with('thongbao','Đã sửa thành công');
    }

    function delCategory($idCate){
        $cate= Category::find($idCate);
        Category::where('parent',$cate->id)->update(['parent'=>$cate->parent]);
        $cate->delete();
        return redirect('/admin/category')->with('thongbao','Đã xóa thành công');
    }
}
