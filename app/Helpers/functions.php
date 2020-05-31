<?php 
	/* 文件上传  */
    function upload($filename){
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


    /* 多文件上传  */
    function Moreupload($filename){
        //接收图片信息
        $files = request() ->$filename;
        if(!count($files)){
            return;
        }
        foreach($files as $k => $v){
            //文件上传
            $path[] = $v->store('upload');
        }
        return $path;
    }

    /* 顶级分类  */
    function CateTree($cate,$p_id=0,$level=0){
        if(!$cate) return;

        static $newArray = [];
        foreach($cate as $k => $v){
            if($v->p_id==$p_id){
                $v->level = $level;
                $newArray[] = $v;
                CateTree($cate,$v->cate_id,$level+1);
            }
        }
        return $newArray;

    }


 ?>