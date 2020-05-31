<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use Illuminate\Support\Facades\Cookie;

class LoginController extends Controller
{
    public function index(){
    	return view('admin.login');
    }

    public function loginDo(){
    	$data = request() ->except('_token');
    	//dd($data);
    	//查询数据库数据
    	$admin = Admin::where('admin_name',$data['admin_name']) ->first();
    	if(!$admin){
    		return redirect('/login') ->with('msg','用户名或密码不正确');
    	}

    	if(decrypt($admin->admin_pwd)!=$data['admin_pwd']){
    		return redirect('/login') ->with('msg','用户名或密码不正确');
    	}

    	//7天免登陆
    	if(isset($data['remember_me'])){
    		Cookie::queue('admin',serialize($admin),60*24*7);
    	}


    	session(['admin'=>$admin]);
    	return redirect('/goods');
    }

    public function setcookie(){
    	//return response('欢迎来到 Lvravel 学院') ->cookie('name','乐宁',1);
    	//以下两种要引入use Illuminate\Support\Facades\Cookie;
    	//Cookie::queue(Cookie::make('name', '湖南', 1));
    	Cookie::queue('name', 'love', 3);
    }

    public function getcookie(){
    	//echo request() ->cookie('name');
    	echo Cookie::get('name');
    }

    //退出
    public function quit(){
    	request() ->session() ->flush();
    	return redirect('/login');
    }

}
