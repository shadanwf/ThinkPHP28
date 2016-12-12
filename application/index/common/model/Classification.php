<?php
/**
 * Created by PhpStorm.
 * User: sdaiff
 * Date: 2016/12/2
 * Time: 15:48
 */

namespace app\index\common\model;
use think\Model;

class Classification extends Model
{
    //开启自动写入时间戳
    protected $autoWriteTimestamp = true;

    // 一对多 定义关联
//    public function products()
//    {
//        return $this->hasMany('Products');
//    }
}