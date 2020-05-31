<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Admin;
use App\Http\Requests\StoreAdminPost;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $pageSize = config('app.pageSize');
        $admin = Admin::orderby('admin_id','desc') ->paginate($pageSize);
        return view('admin.admin.index',['admin'=>$admin]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.admin.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreAdminPost $request)
    {
        //接值
        $data = $request ->except('_token','admin_pwd1');
        $data['add_time'] = time();
        $data['admin_pwd'] = encrypt($data['admin_pwd']);
        //文件上传(判断文件在请求中是否存在：)
        if ($request->hasFile('admin_img')) {
            $data['admin_img'] = $this ->upload('admin_img');
        }

        /*$admin = new Admin();
        $admin ->admin_name = $data['admin_name'];
        $admin ->admin_pwd = md5($data['admin_pwd']);
        $admin ->admin_tel = $data['admin_tel'];
        $admin ->admin_img = $data['admin_img'];
        $admin ->admin_email = $data['admin_email'];
        $admin ->add_time = $data['add_time'];
        $res = $admin ->save();
        */
        
        $res = Admin::insert($data);
        if($res){
            return redirect('/admin');
        }
    }

    /* 文件上传 */
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
        //查询id
        $adminInfo = Admin::find($id);
        return view('admin.admin.edit',['adminInfo'=>$adminInfo]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreAdminPost $request, $id)
    {
        //接值
        $post = $request ->except('_token','admin_pwd1');
        $post['add_time'] = time();
        $post['admin_pwd'] = encrypt($post['admin_pwd']);
        //文件上传(判断文件在请求中是否存在：)
        if ($request->hasFile('admin_img')) {
            $post['admin_img'] = $this ->upload('admin_img');
        }

        $res = Admin::where('admin_id',$id) ->update($post);
        if($res!==false){
            return redirect('/admin');
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
        $res = Admin::destroy($id);
        if($res){
            echo json_encode(['code'=>'1','msg'=>'删除成功']);die;
        }
    }

    public function checkName(){
        $admin_name = request() ->admin_name;
        $count = Admin::where('admin_name',$admin_name) ->count();
        echo $count;
    }

}
