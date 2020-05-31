<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cate extends Model
{
    /**
    * 关联到模型的数据表 
    *
    * @var string 
    */ 
    protected $table = 'cate';

    /**
    * The primary key associated with the table. 
    * 主键
    * @var string 
    */ 
    protected $primaryKey = 'cate_id';

    /**
    * 表明模型是否应该被打上时间戳 
    *
    * @var bool 
    */ 
    public $timestamps = false;

    //顶级分类
    public static function getCateData(){
        return self::select('cate_id','cate_name')->where(['p_id'=>0,'is_nav_show'=>1])->orderby('cate_id','desc')->take(4) ->get();

    }



}
