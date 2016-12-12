<?php
namespace app\index\common\model;
use think\Model;

class User extends Model{
    //开启自动写入时间戳
    protected $autoWriteTimestamp = true;

    // 一对多 定义关联
    public function products()
    {
        return $this->hasMany('Products');
    }
}