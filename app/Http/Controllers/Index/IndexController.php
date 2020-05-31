<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Goods;
use App\Cate;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class IndexController extends Controller
{
    public function index(){
        /*——————————————————Memcache——————————————————————*/
        //1先获取看看memcache里缓存有数据吗,没有从数据库
        //$slice = Cache::get('slice');

        //全局辅助函数
        //$slice = cache('slice');

        /*——————————————————Redis—————————————————————————*/
        $slice = Redis::get('slice');
        //dump($slice);
        if(!$slice){
            //echo "db";
        	//首页幻灯片
        	$slice = Goods::getSlice();//2从数据库获取
            /*—————————————————————memcache—————————————————————————————————*/
            //Cache::put('slice',$slice,60*60);//3从数据库里存入memecache里
            //全局辅助存
           // cache(['slice'=>$slice],60);

            /*————————————————————redis———————————存———————————————*/
            $slice = serialize($slice);//序列化
            Redis::setex('slice',60,$slice);
        }
        $slice = unserialize($slice);//反序列化
        
        $cate = Cache::get('cate');
        //dump($cate);
        if(!$cate){
        	//顶级分类
        	$cate = Cate::getCateData();
        	Cache::put('cate',$cate,60*60);
        }

        //商品展示
        $best = Goods::getBestData();

        $new = Goods::getNewData();

    	return view('index.index',compact('slice','cate','best','new'));
    }

    //退出
    public function quit(){
    	request() ->session() ->flush();
    	return redirect('/');
    }



}
