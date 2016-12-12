<?php
/**
 * Created by PhpStorm.
 * User: sdaiff
 * Date: 2016/12/2
 * Time: 16:57
 */

namespace app\index\common\model;
use think\Model;

class Products extends Model
{

    // 定义关联方法
    public function getClassifition()
    {
       // return $this->belongsTo('User');
        $Classification_id = $this->getData('Classification_id');
        $Classification = Classification::get($Classification_id);
        return $Classification;
    }
    // 定义关联方法
    public function getProducts()
    {
        // return $this->belongsTo('User');
        $Products_id = $this->getData('Products_id');
        $Products_id = Classification::get($Products_id);
        return $Products_id;
    }


}