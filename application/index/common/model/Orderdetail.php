<?php
namespace app\index\common\model;
use think\Model;

class Orderdetail extends Model{

    // 定义关联方法
    public function getProducts()
    {
        // return $this->belongsTo('User');
        $Products_id = $this->getData('Products_id');
        $Products_id = Classification::get($Products_id);
        return $Products_id;
    }

}
