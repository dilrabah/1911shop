<?php

use Illuminate\Support\Facades\Route;

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
//闭包路由
// Route::get('/', function () {
// 	//echo '你好';
//    return view('welcome');
// });

Route::get('hi', function () {
	echo '你好';
   //return view('welcome');
});

Route::get('index','TextController@index');

//显示视图的3中方法
//Route::get('add','TextController@add');
/*Route::get('add', function () {
   return view('add');
});*/
///路由视图
Route::view('add','add');

//注册一个路由可以多种方式传参
//Route::any('add','TextController@add');
Route::match(['post','get'],'add','TextController@add');

//post提交
Route::post('adddo','TextController@adddo');

//必选参数
Route::get('user/{id}', function ($id) { 
	return 'User ' . $id; 
});

// Route::get('goods/{id}', function ($id) { 
// 	return 'goods ' . $id; 
// });
Route::get('goods/{id}/{name}','TextController@goods') ->where(['name'=>'[a-zA-Z]+']);

//可选参数
Route::get('show/{name?}','TextController@show');
Route::get('detail/{id}/{name?}','TextController@detail');
//Route::get('list/{id?}','TextController@list');

//练习
Route::get('list','StudentController@lists');
Route::get('create','StudentController@create');
Route::post('store','StudentController@store');

//域名分组
Route::domain('admin.1911.com')->group(function () {
	Route::get('/','Admin\BrandController@index')->middleware('login');
	//商品品牌模块
	Route::prefix('brand')->middleware('login')->group(function () {
		Route::get('/','Admin\BrandController@index');
		Route::get('create','Admin\BrandController@create');
		Route::post('store','Admin\BrandController@store');
		Route::get('edit/{id}','Admin\BrandController@edit');
		Route::post('update/{id}','Admin\BrandController@update');
		Route::get('destroy/{id}','Admin\BrandController@destroy');
		Route::post('checkName','Admin\BrandController@checkName');
	});

	//商品分类
	Route::prefix('cate')->middleware('login')->group(function () {
		Route::get('/','Admin\CateController@index');
		Route::get('create','Admin\CateController@create');
		Route::post('store','Admin\CateController@store');
		Route::get('edit/{id}','Admin\CateController@edit');
		Route::post('update/{id}','Admin\CateController@update');
		Route::get('destroy/{id}','Admin\CateController@destroy');
	});

	//商品
	Route::prefix('goods')->middleware('login')->group(function () {
		Route::get('/','Admin\GoodsController@index');
		Route::get('create','Admin\GoodsController@create');
		Route::post('store','Admin\GoodsController@store');
		Route::get('edit/{id}','Admin\GoodsController@edit');
		Route::post('update/{id}','Admin\GoodsController@update');
		Route::get('destroy/{id}','Admin\GoodsController@destroy');
		Route::post('checkName','Admin\GoodsController@checkName');
	});

	//管理员
	Route::prefix('admin')->middleware('login')->group(function () {
		Route::get('/','Admin\AdminController@index');
		Route::get('create','Admin\AdminController@create');
		Route::post('store','Admin\AdminController@store');
		Route::get('edit/{id}','Admin\AdminController@edit');
		Route::post('update/{id}','Admin\AdminController@update');
		Route::get('destroy/{id}','Admin\AdminController@destroy');
		Route::post('checkName','Admin\AdminController@checkName');
	});

	//登录
	Route::get('/login','Admin\LoginController@index');
	Route::post('/loginDo','Admin\LoginController@loginDo');
	Route::get('/quit','Admin\LoginController@quit');

	//文章练习
	Route::prefix('article')->group(function () {
		Route::get('/','Admin\ArticleController@index');
		Route::get('create','Admin\ArticleController@create');
		Route::post('store','Admin\ArticleController@store');
		Route::get('edit/{id}','Admin\ArticleController@edit');
		Route::post('update/{id}','Admin\ArticleController@update');
		Route::get('destroy/{id}','Admin\ArticleController@destroy');
	});

	//cookie练习
	Route::get('/setcookie','Admin\LoginController@setcookie');
	Route::get('/getcookie','Admin\LoginController@getcookie');
});

Route::domain('www.1911.com')->group(function () {
	//前台首页
	Route::get('/','Index\IndexController@index')->name('shop.index');//前台首页
	Route::get('/login','Index\LoginController@login');//登录
	Route::post('/loginDo','Index\LoginController@loginDo');//执行登录
	Route::get('/reg','Index\LoginController@reg');//注册
	Route::post('/regdo','Index\LoginController@regdo');//执行注册
	Route::get('/sendSms','Index\LoginController@sendSms');//短信发送验证码
	Route::get('/sendEmail','Index\LoginController@sendEmail');//邮箱发送验证码
	Route::get('/quit','Index\IndexController@quit');//退出
	Route::get("/prolist/{id?}","Index\ProController@prolist");//商品列表
	Route::get('/proinfo/{id}','Index\ProController@proinfo')->name('shop.proinfo');//商品详情
	Route::get('/addcar','Index\CarController@addcar');//加入购物车
	Route::get('/cartlist','Index\CarController@cartlist')->middleware('checkmember')->name('shop.cart');//购物车列表
	
	Route::get('/news','Index\NewsController@index');//测试redis
});
