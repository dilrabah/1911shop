<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Type;
use App\Article;
use App\Http\Requests\StoreArticlePost;


class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //查询分类
        $type = Type::all();

        //接收搜索关键字
        $name = request() ->name;
        $t_id = request() ->t_id;

        $where = [];
        if($name){
            $where[] = ['name','like',"%$name%"];
        }
        if($t_id){
            $where[] = ['article.t_id','=',$t_id];
        }


        $pageSize = config('app.pageSize');
        $data = type::select('article.*','t_name')
                            ->join('article','article.t_id','=','type.t_id')
                            ->where($where)
                            ->orderby('article_id','desc')
                            ->paginate($pageSize);
        return view('admin.article.index',['data'=>$data,'type'=>$type,'name'=>$name,'t_id'=>$t_id]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $type = Type::all();
        //dd($type);
        return view('admin.article.create',['type'=>$type]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreArticlePost $request)
    {
        //接收表单值
        $data = $request ->except('_token');
        $data['add_time'] = time();
        //文件上传(判断文件在请求中是否存在：)
        if ($request->hasFile('img')) {
            $data['img'] = $this ->upload('img');
        }

        //入库
        $res = Article::insert($data);
        if($res){
            return redirect('/article');
        }
    }

    /* 文件上传  */
    public function upload($filename){
        //判断文件在上传过程中是否出错）
        if (request()->file($filename)->isValid()){
            //接收文件
            $file = request()->$filename;
            //上传文件(路径)
            $path = request()->$filename->store('upload');
            return $path;
        }
        return "文件上传出错";
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
        //查询分类
        $type = Type::all();
        //查询一条数据
        $article = Article::find($id);
        return view('admin.article.edit',['type'=>$type,'article'=>$article]);
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
        //接收表单值
        $data = $request ->except('_token');
        $data['add_time'] = time();
        //文件上传(判断文件在请求中是否存在：)
        if ($request->hasFile('img')) {
            $data['img'] = $this ->upload('img');
        }
        $res = Article::where('article_id',$id) ->update($data);
        if($res!==false){
            return redirect('/article');
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
        $res = Article::destroy($id);
        if($res){
            return redirect('/article');
        }  
    }



}
