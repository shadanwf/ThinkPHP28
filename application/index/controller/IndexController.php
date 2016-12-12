<?php
namespace app\index\controller;

use app\index\common\controller\AuthController;
use think\Collection;

class IndexController extends Collection
{
    public function index()
    {
        echo 'Thinkphp28' . "<br>";
        echo date("Y/m/d-w H-i-s	") . "<br>";

session_start();

if(isset($_SESSION['views']))
{
    $_SESSION['views']=$_SESSION['views']+1;
}
else
{
    $_SESSION['views']=1;
}
echo "浏览量：". $_SESSION['views'];
        //销毁session
        //session_destroy();
    }

}
