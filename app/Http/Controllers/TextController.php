<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TextController extends Controller
{
    //
    public function index(){
    	echo "蜡笔小新";
    }

    //视图
    public function add(){
    	$data = request() ->all();
    	dump($data);
    	return view('add');
    }

    public function adddo(Request $request){
    	//全部接收值all,input,post
    	//$data = $request ->all();
    	//$data = $request ->input();
    	$data = $request ->post();
    	dump($data);


    	//只接受1个值
    	//$name = $request ->name;
    	//$name = $request ->post('name');
    	//$name = $request ->input('name');
    	//dd($name);

    	//排除接收某字段except
    	$data = $request ->except(['name','pwd']);
    	dump($data);


    	//只接收only
    	$data = $request ->only(['name','pwd']);
    	dump($data);

    }

    public function goods($id,$name){
    	echo $id.'!'.$name;
    }

    public function show($name=null){
    	echo $name;
    }

    public function detail($id,$name=null){
    	echo $id.'-'.$name;
    }

    public function list($id=0){
    	echo $id;
    }

}
