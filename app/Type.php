<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    /*** 关联到模型的数据表 ** @var string */ 
    protected $table = 'type';

    /*** The primary key associated with the table. ** @var string */ 
    protected $primaryKey = 't_id';

    /*** 表明模型是否应该被打上时间戳 ** @var bool */ 
    public $timestamps = false;
}
