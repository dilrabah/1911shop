<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Cate;
use App\Brand;
use App\Goods;
use App\Http\Requests\StoreGoodsPost;
use DB;

class GoodsController extends Controller
{
    /**
     * Display a listing of the resource.
     * 展示列表
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        
        /*/session的操作
        //存储
        $request->session()->put('name','admin');
        session(['class'=>'1911']);

        //获取
        echo $request->session()->get('name');
        echo session('class');

        //删除
        $request->session()->forget('name');
        session(['class'=>null]);

        dump($request->session()->get('name'));
        dump($request->session()->get('class'));

        //判断 session里有没有此键
        dump($request->session()->has('name'));
        dump($request->session()->exists('class'));
        */



        //获取分类数据
        $cateInfo = Cate::all();
        $cateInfo = CateTree($cateInfo);

        //接收搜索关键字
        $name = request() ->name;
        $cate_id = request() ->cate_id;
        $min = request() ->min;
        $max = request() ->max;
        $where = [];
        if($name){
            $where[] = ['goods_name','like',"%$name%"];
        }
        if($cate_id){
            $where[] = ['goods.cate_id','=',$cate_id];
        }
        if($min){
            $where[] = ['goods.goods_price','>=',$min];
        }
        if($max){
            $where[] = ['goods.goods_price','<=',$max];
        }

        //DB::connection()->enableQueryLog();
        $pageSize = config('app.pageSize');
        $goodsInfo = Goods::select('goods.*','cate_name','brand_name')
                            ->leftjoin('cate','goods.cate_id','=','cate.cate_id')
                            ->leftjoin('brand','goods.brand_id','=','brand.brand_id')
                            ->where($where)
                            ->orderBy('goods_id','desc')
                           ->paginate($pageSize);
        // $logs = DB::getQueryLog();
        // dump($logs);
        //dd($goodsInfo);
        return view('admin.goods.index',compact('goodsInfo','name','cateInfo','cate_id','min','max'));
    }

    /**
     * Show the form for creating a new resource.
     *  添加页面
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获取品牌数据
        $brandInfo = Brand::all();
        //获取分类数据
        $cateInfo = Cate::all();
        $cateInfo = CateTree($cateInfo);
        
        return view('admin.goods.create',['brandInfo'=>$brandInfo,'cateInfo'=>$cateInfo]);
    }

    

    /**
     * Store a newly created resource in storage.
     * 执行添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreGoodsPost $request)
    {
        // $validatedData = $request->validate([ 
        //     'goods_name' => 'required|unique:goods', 
        //     'cate_id' => 'required', 
        //     'brand_id' => 'required',
        //     'goods_num' => 'required',
        //     'goods_price' => 'required',
        // ],[
        //     'goods_name.required' =>"商品名称必填",
        //     'goods_name.unique' =>'商品名称已存在',
        //     'cate_id.required' =>'商品分类必填',
        //     'brand_id.required' => '商品品牌必填',
        //     'goods_num.required' => '商品库存必填',
        //     'goods_price.required' => '商品价格必填',
        // ]);

        //接收值
        $data = $request ->except('_token');
        //文件上传(判断文件在请求中是否存在：)
        if ($request->hasFile('goods_img')) {
            $data['goods_img'] = upload('goods_img');
        }

        //多文件上传
        if(isset($data['goods_imgs'])){
            $data['goods_imgs'] = Moreupload('goods_imgs');
            $data['goods_imgs'] = implode('|',$data['goods_imgs']);
            //dd($data['goods_imgs']);
        }

        //入库
        $res = Goods::insert($data);
        if($res){
            return redirect('/goods');
        }
    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     * 修改页面
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        
        //获取品牌数据
        $brandInfo = Brand::all();
        //获取分类数据
        $cateInfo = Cate::all();
        $cateInfo = CateTree($cateInfo);
        //查询id
        $goods = Goods::find($id);
        return view('admin.goods.edit',['goods'=>$goods,'cateInfo'=>$cateInfo,'brandInfo'=>$brandInfo]);
    }

    /**
     * Update the specified resource in storage.
     * 执行修改
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreGoodsPost $request, $id)
    {
        //接收值
        $data = $request ->except('_token');
        //文件上传
        if ($request->hasFile('goods_img')) {
            $data['goods_img'] = upload('goods_img');
        }

        //多文件上传
        if(isset($data['goods_imgs'])){
            $data['goods_imgs'] = Moreupload('goods_imgs');
            $data['goods_imgs'] = implode('|',$data['goods_imgs']);
        }
        //dd($data);

        $res = Goods::where("goods_id",$id) ->update($data);

        if($res!==false){
            return redirect('/goods');
        }

    }

    /**
     * Remove the specified resource from storage.
     * 删除
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $res = Goods::destroy($id);
        if($res){
            echo json_encode(['code'=>'1','msg'=>"删除成功"]);die;
        }
    }

    public function checkName(){
        $goods_name = request() ->goods_name;
        $count = Goods::where('goods_name',$goods_name) ->count();
        echo $count;
    }

}
