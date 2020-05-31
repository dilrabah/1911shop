<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    /**
    * 关联到模型的数据表 
    *
    * @var string 
    */ 
    protected $table = 'brand';

    /**
    * The primary key associated with the table. 
    * 主键
    * @var string 
    */ 
    protected $primaryKey = 'brand_id';

    /**
    * 表明模型是否应该被打上时间戳 
    *
    * @var bool 
    */ 
    public $timestamps = false;

    /**
    * 可以被批量赋值的属性. 
    * 白名单
    * @var array 
    */ 
    //protected $fillable = ['brand_name','brand_url','brand_logo','brand_desc'];

    /**
    * The attributes that aren't mass assignable. 
    * 黑名单
    * @var array 
    */ 
    protected $guarded = [];

    /*封装*/
    public static function getBrandIndex($pageSize,$where){
    	return self::where($where)->orderBy('brand_id','desc') ->paginate($pageSize);
    }







}
