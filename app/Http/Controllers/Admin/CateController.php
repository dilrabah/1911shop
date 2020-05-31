<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use App\Cate;

class CateController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //获取父级数据
        //$cate = DB::table('cate') ->get();

        $cate = Cate::all();

        $cate = CateTree($cate);
        return view('admin.cate.index',['cate'=>$cate]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //获取父级数据
        //$cate = DB::table('cate') ->get();
        $cate = Cate::all();
        $cate = CateTree($cate);
        return view('admin.cate.create',['cate'=>$cate]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // $validatedData = $request->validate([ 
        //     'cate_name' => 'required|unique:cate', 
        //     'p_id' => 'required', 
        // ],[
        //     'cate_name.required' =>"分类名称必填",
        //     'cate_name.unique' =>'该分类名称已存在',
        //     'p_id.required' =>'父级分类必选',
        // ]);

        $data = $request ->except('_token');
        //$res = DB::table('cate')->insert($data);
        $res = Cate::insert($data);
        if($res){
            return redirect('/cate');
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
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //获取父级数据
        //$cate = DB::table('cate') ->get();
        $cate = Cate::all();
        $cate = CateTree($cate);
        $cateInfo = DB::table('cate') ->where("cate_id",$id) ->first();
        return view('admin.cate.edit',['cateInfo'=>$cateInfo,'cate'=>$cate]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //接收值
        $post = $request ->except('_token');
        //$res = DB::table('cate') ->where('cate_id',$id) ->update($post);
        $res = Cate::where('cate_id',$id) ->update($post);
        if($res!==false){
            return redirect('/cate');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $count = Cate::where('p_id',$id) ->count();
        if($count>0){
            return redirect('/cate') ->with(['msg'=>'该分类下有数据']); 
        }
        //$res = DB::table('cate')->where('cate_id',$id)->delete();
        $res = Cate::where('cate_id',$id) ->delete();
        if($res){
            return redirect('/cate');
        }
    }
}
