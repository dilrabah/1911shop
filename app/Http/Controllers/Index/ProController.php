<?php

namespace App\Http\Controllers\Index;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Goods;
use App\Cate;
use DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Redis;

class ProController extends Controller
{
    //商品列表
    public function prolist(){
        $id=request()->id;
        if($id){
            $array=Cate::get();
            $cateId=getCateId($array,$id);
            $goodsInfo=Goods::getGoodsInfoPid($cateId);
            return view("index.prolist",["goodsInfo"=>$goodsInfo]);
        }else{
            $goodsInfo=Goods::getGoodsInfo();
            return view("index.prolist",["goodsInfo"=>$goodsInfo]);
        }   
    }
    //商品详情
    public function proinfo($id){
        /*————————————————————Memcache————————————————————————*/
        //当前页面访问量
        //$visit = Cache::add('visit_'.$id,1) ? 1 : Cache::increment('visit_'.$id);

        //$goodsInfoId = Cache::get('goodsInfoId_'.$id);
        //全局辅助
        //$goodsInfoId = cache('goodsInfoId_'.$id);

        /*—————————————————————Redis—————————————————————————————*/
        $goodsInfoId = Redis::get('goodsInfoId');
        //当前页面访问量
        $visit = Redis::setnx('visit_'.$id,1) ? 1 : Redis::incr('visit_'.$id);

        //dump($goodsInfoId);
        if(!$goodsInfoId){
            //echo 'DB';
            $goodsInfoId=Goods::getGoodsInfoId($id);
            /*—————————————————————memcache—————————————————————————————————*/
            //Cache::put('goodsInfoId_'.$id,$goodsInfoId,60);
            //全局辅助
            //cache(['goodsInfoId_'.$id=>$goodsInfoId],60);

            /*————————————————————redis———————————存———————————————*/
            $goodsInfoId = serialize($goodsInfoId);//序列化
            Redis::setex('goodsInfoId',60,$goodsInfoId);
        }
        $goodsInfoId = unserialize($goodsInfoId);//反序列化

        
        $goodsInfoId->goods_imgs=explode("|",$goodsInfoId->goods_imgs);
        return view("index.proinfo",["goodsInfoId"=>$goodsInfoId,'visit'=>$visit]);
    }



}
