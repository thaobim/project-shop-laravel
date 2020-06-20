<?php
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

//------------FRONTEND----------------

//index
Route::get('','frontend\HomeController@getIndex');
Route::get('about','frontend\HomeController@getAbout' );
Route::get('contact', 'frontend\HomeController@getContact');

//cart
Route::group(['prefix' => 'cart'], function () {
    Route::get('', 'frontend\CartController@getCart');
    Route::post('', 'frontend\CartController@postCart');
    Route::get('delete/{rowId}', 'frontend\CartController@delCart');
    Route::get('update/{rowId}/{qty}', 'frontend\CartController@updateCart');
});

//checkout
Route::group(['prefix' => 'checkout'], function () {
    Route::get('','frontend\CheckoutController@getCheckout' );
    Route::get('complete/{orderId}','frontend\CheckoutController@getComplete' );
    Route::post('','frontend\CheckoutController@postCheckout' );
});

//product
Route::group(['prefix' => 'product'], function () {
    Route::get('category/{slugCate}','frontend\ProductController@getCate' );
    Route::get('shop','frontend\ProductController@getShop' );

});
Route::get('{prdSlug}.html', 'frontend\ProductController@getDetail');




//----------------BACKEND------------
//login
Route::get('login','backend\LoginController@getLogin')->middleware('CheckLogout');
Route::post('login','backend\LoginController@postLogin');
Route::get('logout','backend\LoginController@getLogout');

//admin
Route::group(['prefix' => 'admin','middleware'=>'CheckLogin'], function () {
    Route::get('','backend\IndexController@getIndex');

    //category
    Route::group(['prefix' => 'category'], function () {
        Route::get('','backend\CategoryController@getCategory');
        Route::get('edit/{idCate}','backend\CategoryController@getEditCategory');
        Route::post('','backend\CategoryController@postCategory');
        Route::post('edit/{idCate}','backend\CategoryController@postEditCategory');
        Route::get('del/{idCate}','backend\CategoryController@delCategory');
    });

    //order
    Route::group(['prefix' => 'order'], function () {
        Route::get('','backend\OrderController@getOrder');
        Route::get('detail/{idOrder}', 'backend\OrderController@getDetail');
        Route::get('processed', 'backend\OrderController@getProcessed');
        Route::get('xuLy/{idOrder}', 'backend\OrderController@xuLy');
    });

    //product
    Route::group(['prefix' => 'product'], function () {
        Route::get('','backend\ProductController@getProduct');
        Route::get('add', 'backend\ProductController@getAddProduct');
        Route::get('edit/{idPrd}','backend\ProductController@getEditProduct' );
        Route::post('add', 'backend\ProductController@postAddProduct');
        Route::post('edit/{idPrd}','backend\ProductController@postEditProduct' );
        Route::get('del/{idPrd}','backend\ProductController@DelProduct' );
    });

    //user
    Route::group(['prefix' => 'user'], function () {
        Route::get('','backend\UserController@getUser');
        Route::get('add', 'backend\UserController@getAddUser');
        Route::get('edit/{idUser}','backend\UserController@getEditUser');
        Route::post('add', 'backend\UserController@postAddUser');
        Route::post('edit/{idUser}','backend\UserController@postEditUser');
        Route::get('del/{idUser}','backend\UserController@delUser');
    });

});







//--------------------LÝ THUYẾT--------------

//SCHEMA

Route::group(['prefix' => 'schema'], function () {
    //Tạo bảng
    Route::get('create-table', function () {
        Schema::create('users', function ($table) {
            $table->bigIncrements('id');      //bigint ,tự tăng ,khóa chính ,unsigned
            $table->string('name')->nullable();   //varchar ,255 ký tự , cho phép null
            $table->integer('phone')->unsigned()->nullable();   //int , ko dấu , cho phép null
            $table->string('address', 100)->nullable()->unique();   //varchar , 100 ký tự , cho phép null, duy nhất
            $table->boolean('level')->nullable()->default(1);    // boolean , cho phép null , mặc đinh là 1
            $table->timestamps();             // tự tạo 2 trường created_at , updated_at
        });

        Schema::create('post', function ($table) {
            $table->bigIncrements('id');
            $table->bigInteger('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    });

    //xóa bảng
    Route::get('del-table', function () {
        Schema::dropIfExists('thanh-vien');
    });

    //sửa tên bảng
    Route::get('rename-table', function () {
        Schema::rename('users', 'thanh-vien');
    });


    //tương tác với cột
    //thêm cột
    Route::get('add-col', function () {
        Schema::table('users', function ($table) {
            $table->integer('id_number')->unsigned()->nullable()->after('address');
        });
    });

    //sửa , xóa cột
    //sử dụng thư viện docttrine/dbal
    //composer require doctrine/dbal
    Route::get('edit-col', function () {
        //sửa tên cột
        Schema::table('users', function ($table) {
            $table->renameColumn('name', 'full');
        });

        //xóa cột
        Schema::table('users', function ($table) {
            $table->dropColumn('id_number');
        });

    });
});




// QUERY BUILDER
// tương tác với dữ liệu database
// để tương tác với database dùng DB::

Route::group(['prefix' => 'query'], function () {

    //thêm bản ghi mới
    Route::get('insert', function () {
        //thêm 1 bản ghi
        // DB::table('users')->insert([
        //     'email'=>'A@gmail.com',
        //     'password'=>'123456',
        //     'full'=>'Nguyen Van A',
        //     'phone'=>'123456789',
        //     'address'=>'Ha noi',
        //     'level'=>1
        // ]);
        //thêm nhiều bản ghi
        DB::table('users')->insert([
            ['email'=>'B@gmail.com','password'=>'123456','full'=>'Nguyen Van B','phone'=>'123456789','address'=>'Ha noi','level'=>0],
            ['email'=>'C@gmail.com','password'=>'123456','full'=>'Nguyen Van C','phone'=>'123456789','address'=>'Bac Giang','level'=>0],
            ['email'=>'D@gmail.com','password'=>'123456','full'=>'Nguyen Van D','phone'=>'123456789','address'=>'Hue','level'=>1]
        ]);
    });

    //sửa bản ghi
    Route::get('update', function () {

        //tìm bản ghi theo điều kiện dung where()
        // DB::table('users')->where('address','Ha noi')->update(['password'=>'654321']);

        // DB::table('users')->where('address','Ha noi')->where('level',0)->update(['password'=>'123456','address'=>'Bac Ninh']);

        //sửa hoặc thêm bản ghi : updateOrInsert([điều kiện],[ thay đổi])
        // nếu tồn tại bản ghi đúng điều kiện thì sẽ update , còn không thì insert bản ghi mới
        DB::table('users')->updateOrInsert(['address'=>'Ha noi'],['phone'=>'987654321','address'=>'Bac Giang']);
    });

    //xóa bản ghi
    Route::get('del', function () {
        //xóa 1 bản ghi
        // DB::table('users')->where('id',5)->delete();

        //xóa tất cả bản ghi
        DB::table('users')->delete();

    });


    //nâng cao

    //lấy dữ liệu trong database
    // sử dụng phương thức get() , first() , find()


    Route::get('get', function () {

        //lấy tất cả dữ liệu theo điều kiện trả về dạng mảng
        // $user = DB::table('users')->where('level',2)->get();
        // dd($user->all());

        //lấy 1 bản ghi đầu tiên theo điều kiện
        // $user = DB::table('users')->where('level',2)->first();
        // dd($user);


        //lấy 1 bảng ghi theo id
        $user = DB::table('users')->find(12);
        dd($user);
    });

    //điều kiện where
    Route::get('where', function () {
        //where
        // $user = DB::table('users')->where('level','<>',2)->get();
        // dd($user);

        //where and
        // $user = DB::table('users')->where('level','<>',2)->where('full','vietpro')->get();
        // dd($user);

        //where-or
        // $user = DB::table('users')->where('id','<',11)->orWhere('id','>',12)->get();
        // dd($user);

        //whereBetween
        $user = DB::table('users')->whereBetween('id',[10,12])->get();
        dd($user);

    });

    //lấy một số lượng bản ghi nhất định
    Route::get('take', function () {
        //take
        // $user = DB::table('users')->take(3)->get();
        // dd($user);

        //orderBy : sắp xếp
        // $user = DB::table('users')->orderBy('id','desc')->take(2)->get();
        // dd($user);
        //skip
        $user = DB::table('users')->skip(1)->take(2)->get();
        dd($user);
    });


});


//RELATIONSHIP
    // bảng chính là bảng chứa khóa chính , bảng phụ là bảng chứa khóa ngoại
    // liên kết bắt đầu từ bảng nào thì trong model của bảng đó
    // liên kết từ bảng chính -> phụ là lk xuôi ngược lại là lk ngược


    //liên kết 1-1
        //liên kết 1-1 xuôi : return $this->hasOne(model lk đến, khóa ngoại, khóa chính);
        Route::get('lk-1-1-x', function () {
            $user = App\User::find(2);
            $info = $user->info()->first();
            dd($info->toarray());
        });

        //liên kết 1-1 ngược : return $this->belongsTo(model lk tới, khóa ngoại, khóa bảng phụ);
        Route::get('lk-1-1-n', function () {
            $info = App\models\info::find(2);
            $user = $info->user()->first();
            dd($user->toarray());
        });

    //liên kết 1- nhiều
        //chiều xuôi : return $this->hasMany(model lk tới, khóa ngoại, khóa chính);
        Route::get('lk-1-n', function () {
            $cate = App\models\Category::find(2);
            $prd = $cate->product()->get();
            dd($prd->toarray());
        });
        //chiều ngược chính là liên kết 1-1 ngược

    // liên kết n-n từ bảng 1 sang 2
        //  return $this->belongsToMany('App\Role', 'role_user_table', 'user_id', 'role_id');
                                    //model lk tới    bảng pivot     khóa ngoại 1   khóa ngoại 2
