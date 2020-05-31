<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Goods;
use App\Cart;

class CarController extends Controller
{
	/*
		
	1 判断是否登录  没登录：提示 跳转到登录  
	2 判断商品是否上架  下架：提示商品下架 
	3 判断库存 购买数量大于库存 提示购买数量大于库存  
	4 判断是否加入过此商品  有此商品（update）：购买数量相加 加完后再次判断库存/没有：add入库

	*/
	//加入购物车
    public function addcar(Request $request){
    	$goods_id = $request ->goods_id;
    	$buy_num = $request ->buy_num;
    	
    	//1: 判断是否登录  没登录：提示 跳转到登录  
    	$user = session('user');
    	if(!$user){
    		echo json_encode(['code'=>'00001','msg'=>"用户未登录"]);die;
    	}
    	//2 判断商品是否上架  下架：提示商品下架 
    	$goods = Goods::find($goods_id);
    	if($goods->is_on_sale!=1){
    		echo json_encode(['code'=>'00002','msg'=>"该商品已下架"]);die;
    	}
    	//3 判断库存 购买数量大于库存 提示购买数量大于库存 提示库存不足
    	if($buy_num>$goods->goods_num){
    		echo json_encode(['code'=>'00003','msg'=>"商品库存不足"]);die;
    	}
    	//4 判断是否加入过此商品  
    	//有此商品（update）：购买数量相加 加完后再次判断库存
    	//没有：add入库
    	$where=['user_id'=>$user->member_id,'goods_id'=>$goods_id];
    	$cart = Cart::where($where) ->first();
    	//dd($cart);
    	if(!$cart){
    		//没有：add入库
    		$data = [
    			'user_id' =>$user->member_id,
    			'goods_id' =>$goods_id,
    			'goods_name' =>$goods->goods_name,
    			'goods_img' =>$goods->goods_img,
    			'goods_price' =>$goods->goods_price,
    			'buy_num' =>$buy_num,
    			'addtime' =>time()
    		];
    		$res = Cart::insert($data);
    	}else{
    		//更新
    		$buy_num += $buy_num+$cart->buy_num;
    		if($buy_num>=$goods->goods_num){
	    		$buy_num = $goods->goods_num;
	    	}
	    	$res = Cart::where($where) ->update(['buy_num'=>$buy_num]);
    	}

    	if($res!==false){
    		echo json_encode(['code'=>'00000','msg'=>"加入购物车成功"]);die;
    	}
    }

    //购物车列表
    public function cartlist(){
    	$user = session('user');

    	$where=['user_id'=>$user->member_id];
    	$cart = Cart::where($where) ->get();
    	//dd($cart);

    	$cart_id = array_column($cart->toArray(),'cart_id');
    	$buy_num = array_column($cart->toArray(),'buy_num');
    	$buyData = array_combine($cart_id, $buy_num);
    	//dd($buyData);
    	//购买数量
    	$buycount = array_sum($buy_num);


    	return view('index.car',compact('cart','buyData','buycount'));
    }


}
