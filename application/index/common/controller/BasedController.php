<?php
/**
 * Created by PhpStorm.
 * User: sdaiff
 * Date: 2016/12/12
 * Time: 0:28
 */

namespace app\index\common\controller;


use app\index\controller\UserController;

class BasedController extends UserController
{
    public function _initialize()
    {
        if (!isset($_SESSION['id'])) {
            $this->redirect("http://localhost/Myshopping/public/index/user/login.html");
        }
    }
}