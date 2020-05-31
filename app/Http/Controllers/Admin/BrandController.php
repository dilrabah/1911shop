<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Http\Requests\StoreBrandPost;
use Validator;
use App\Brand;
use Illuminate\Support\Facades\Cache;
class BrandController extends Controller
{
    /**
     * Display a listing of the resource.
     * 列表页
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $page = request() ->page??1;
        $brand_name = request() ->brand_name;
        //dump('brand_'.$page.'_'.$brand_name);
        
        $brand = Cache::get('brand_'.$page.'_'.$brand_name);
        if(!$brand){
            echo "db";
            $where = [];
            if($brand_name){
                $where[] = ['brand_name','like',"%$brand_name%"];
            }
            $pageSize = config('app.pageSize');
            //$brand = DB::table('brand')->orderBy('brand_id','desc') ->paginate($pageSize);

            /*ORM  --调用brand里的方法*/
            $brand = Brand::getBrandIndex($pageSize,$where);
            Cache::put('brand_'.$page.'_'.$brand_name,$brand,60);
        }
        

        //无刷新分页
        if(request()->ajax()){
            return view('admin.brand.ajaxindex',['brand'=>$brand,'brand_name'=>$brand_name]);
        }

        return view('admin.brand.index',['brand'=>$brand,'brand_name'=>$brand_name]);
    }

    /**
     * Show the form for creating a new resource.
     * 添加页面
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.brand.create');
    }

    /**
     * Store a newly created resource in storage.
     * 执行添加
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    
    public function store(Request $request)
    /*public function store(StoreBrandPost $request) 第二种表单验证*/
    {
        //第一种表单验证
        /*$validatedData = $request->validate([ 
            'brand_name' => 'required|unique:brand', 
            'brand_url' => 'required', 
        ],[
            'brand_name.required' =>"品牌名称必填",
            'brand_name.unique' =>'品牌名称已存在',
            'brand_url.required' =>'品牌网址必填',
        ]);*/

        $data = $request ->except('_token');
        //第3种表单验证
        $validator = Validator::make($data, [ 
                'brand_name' => 'required|unique:brand', 
                'brand_url' => 'required',  
            ],[
            'brand_name.required' =>"品牌名称必填",
            'brand_name.unique' =>'品牌名称已存在',
            'brand_url.required' =>'品牌网址必填',
        ]);

        if ($validator->fails()) { 
            return redirect('/brand/create') 
                            ->withErrors($validator) 
                            ->withInput(); 
        }


        //文件上传(判断文件在请求中是否存在：)
        if ($request->hasFile('brand_logo')) {
            $data['brand_logo'] = $this ->upload('brand_logo');
        }
        
        //$res = DB::table('brand')->insert($data);

        /*ORM 第一种
        $brand = new Brand();
        $brand ->brand_name = $data['brand_name'];
        $brand ->brand_url = $data['brand_url'];
        $brand ->brand_logo = $data['brand_logo'];
        $brand ->brand_desc = $data['brand_desc'];
        $res = $brand ->save();
        */
        /*ORM 第2种
        $res = Brand::insert($data);
        */

        /*ORM 第3种 这个需要设置黑名单*/
        $res = Brand::create($data);


        if($res){
            return redirect('/brand');
        }
    }

    /*文件上传*/
    public function upload($filename){
        //判断文件在上传过程中是否出错）
        if (request()->file($filename)->isValid()){
            //接收文件
            $file = request()->$filename;
            //上传文件(路径)
            $path = request()->$filename->store('uploads');
            return $path;
        }
        return "文件上传出错";

    }

    /**
     * Display the specified resource.
     * 展示
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
        //根据id获取数据
        //$brand = DB::table('brand') ->where("brand_id",$id) ->first();

        /*ORM*/
        //查询id
        $brand = Brand::find($id);
        return view('admin.brand.edit',['brand'=>$brand]);
    }

    /**
     * Update the specified resource in storage.
     * 执行修改
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //接收值
        $post = $request ->except('_token');
        if ($request->hasFile('brand_logo')) {
            $post['brand_logo'] = $this ->upload('brand_logo');
        }

        //$res = DB::table('brand') ->where("brand_id",$id) ->update($post);
        /*ORM 1种
        //查询id
        $brand = Brand::find($id);
        $brand ->brand_name = $post['brand_name'];
        $brand ->brand_url = $post['brand_url'];
        if(isset($post['brand_logo'])){
            $brand ->brand_logo = $post['brand_logo'];
        }
        $brand ->brand_desc = $post['brand_desc'];
        $res = $brand ->save();
        */
        /* ORM 2种*/
        $res = Brand::where("brand_id",$id) ->update($post);

        if($res!==false){
            return redirect('/brand');
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
        //$res = DB::table('brand') ->where('brand_id',$id) ->delete();

        /*ORM*/
        $res = Brand::destroy($id);

        if($res){
            return redirect('/brand');
        }
    }


    public function checkName(){
        $brand_name = request() ->brand_name;
        $count = Brand::where('brand_name',$brand_name) ->count();
        echo $count;
    }

    
}
