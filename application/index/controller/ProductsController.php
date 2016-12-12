<?php
/**
 * Created by PhpStorm.
 * User: sdaiff
 * Date: 2016/12/2
 * Time: 16:56
 */

namespace app\index\controller;
use app\index\common\controller\BasedController;
use app\index\common\model\Classification;
use app\index\common\model\Products;
use app\index\common\model\User;
use think\Request;
use think\Controller;
use app\index\common\model\Orderdetail;


class ProductsController extends BasedController
{
//    public function _initialize()
//    {
//        if (!isset($_SESSION['id'])) {
//            $this->redirect("http://localhost/Myshopping/public/index/user/login.html");
//        }
//    }

    //显示商品页面
    public function index()
    {
        // 获取查询信息
        $name = input('get.name');
        // dump($username);

        $instantiation = new Products();
//        dump($User);
        // 定制查询信息
        if (!empty($name)) {
            $aa = $instantiation->where('name', 'like', '%' . $name . '%');
            //dump($aa);
        }
        // $usera = User::all();
        $pageSize = 8; // 每页显示5条数据
        $klasses = Products::paginate($pageSize);
        // dump($klasses);
        //$klasses = $User->select();
        $this->assign('aa', $klasses);
        //跳转登录表单
        return $this->fetch();
    }

    //显示商品添加页面
    public function addProducts()
    {
        //获取所有分类信息
        $Classification = Classification::all();
        // dump($Classification);
        $this->assign('Classification', $Classification);
        return $this->fetch();
    }

    //商品处理添加
    public function addProductsAction()
    {

        $Products = Request::instance()->post();
        //$Products = $this->request->post();//和上面接收数据的方法一样的
        // dump($Products);
        $instantiation = new Products;
        $instantiation->name = $Products['name'];
        $instantiation->description = $Products['description'];
        $instantiation->color = $Products['color'];
        $instantiation->price = $Products['price'];
        $instantiation->publishon = $Products['publishon'];
        $instantiation->Classification_id = $Products['Classification_id'];
        $cc = $instantiation->validate(true)->save($instantiation->getData());
        if ($cc) {
            return '商品新增成功';
        }
    }

    //商品编辑页面
    public function editProducts()
    {
        // (查找)获取传入ID
        $id = Request::instance()->param('id/d');//d表示将数值转化为 整形
        // 在Teacher表模型中获取当前记录
        $Products = Products::get($id);
        // dump($Products);
        //获取所有分类信息
        $Classification = Classification::all();
        $this->assign('Products', $Products);
        $this->assign('Classification', $Classification);
        return $this->fetch();
    }

    //商品处理编辑页面
    public function editProductsAction()
    {
        // $Products = Request::instance()->post();
        // dump($Products);
        //第一种数据更新的方法，是数组
//        //接收数据
//        $teacher = Request::instance()->post();
//        //将数据存入Products表
//        $Teacher = new Products();
//        $state = $Teacher->validate(true)->isUpdate(true)->save($teacher);
//        dump($state);
//        //依据状态定制提示信息
//        if ($state) {
//            return '更新成功';
//        } else {
//            return '更新失败';
//        }

        // 接收数据，取要更新的关键字信息
        $id = Request::instance()->post('id/d');//d表示将数值转化为 整形
        // 获取当前对象
        //dump($id);
        //获取传入的商品信息
        $klass = Products::get($id);
        if (is_null($klass)) {
            return $this->error('系统为找到id为' . $id . '的数据');
        }
        //数据更新
        $klass->name = Request::instance()->post('name');
        $klass->description = Request::instance()->post('description');
        $klass->color = Request::instance()->post('color');
        $klass->price = Request::instance()->post('price');
        $klass->publishon = Request::instance()->post('publishon');
        $klass->Classification_id = Request::instance()->post('Classification_id');
        $result = $klass->validate(true)->save($klass->getData());
        //反馈结果
        if (false === $result) {
            return '更新失败' . $klass->getError();
        } else {
            return $this->success('更新成功', url('index'));

        }

    }

    //商品删除
    public function deleteProductsAction()
    {
        //接受传入数据(id)
        //$postData = Request::instance()->post();
        //获取pathinfo传入的id值
        $id = Request::instance()->param('id/d'); //d表示将数值转化为 整形
        if (is_null($id) || 0 === $id) {
            return $this->error('未获取到id信息');
        }
        //获取要删除的对象
        $ProductsAction = Products::get($id);
        //要删除的对象不存在
        if (is_null($ProductsAction)) {
            return $this->error('不存在id为' . $id . '的分类，删除失败');
        }
        //删除对象
        if (!$ProductsAction->delete()) {
            return $this->error('商品删除失败:' . $ProductsAction->getError());
        }
        return $this->success('商品删除成功');
    }

    //添加到购物车
    //显示编辑分类（更新）
    public function CheAction(){
        //接受传入数据(id)
        //$postData = Request::instance()->post();
        //获取pathinfo传入的id值
        $id = Request::instance()->param('id/d'); //d表示将数值转化为 整形
        if (is_null($id) || 0 === $id){
            return $this->error('未获取到id信息');
        }
        //获取要删除的对象
        $ProductsAction = Products::get($id);
        //要删除的对象不存在
        if (is_null($ProductsAction)){
            return $this->error('不存在id为'.$id.'的分类，删除失败');
        }
        //删除对象
        $ss = new Orderdetail();
        if (!$ss->save()){
            return $this->error('商品删除失败:'.$ProductsAction->getError());
        }
        return $this->success('商品删除成功');
    }

}