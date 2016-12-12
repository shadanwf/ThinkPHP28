<?php
namespace app\index\controller;
use app\index\common\model\User;
use think\Controller;
use think\Request;

class UserController extends Controller{



    //显示数据
    public function index(){
        // 获取查询信息
        $name = input('get.name');
       // dump($username);

        $User = new User();
//        dump($User);
        // 定制查询信息
        if (!empty($name)) {
            $aa=$User->where('name', 'like', '%' . $name . '%');
            //dump($aa);
        }
       // $usera = User::all();
        $pageSize = 10; // 每页显示5条数据
        $klasses = User::paginate($pageSize);
        $this->assign('aa',$klasses);
        //跳转注册表单
        return $this->fetch();
    }

    //显示
    public function register(){
        //跳转注册表单
        return $this->fetch();
    }
    //添加注册用户数据
    public function addUser()
    {
        $Username = Request::instance()->post();
        // dump($Username);

        $username = $Username['name'];
        $email = $Username['email'];
        $password = $Username['password'];
        $password2 = $Username['password2'];
        if ($password!=$password2){
            $this->error("两次密码不同，请重新输入！");
            return ;
        }
        $usera = User::get(["email"=>$email]);
        //dump($usera);
        if ($usera != null){
            return '该邮箱已经被注册，请从新注册！';
        }else{

            $user = new User;
            $user->name = $username;
            $user->email = $email;
            $user->password = $password;
            // $user->save();
            $result = $user->validate(true)->save($user->getData());
            //反馈结果
            if (false===$result){
                return $this->error('注册失败：' . $user->getError());
            }
            else{
                return $this->success('注册成功', url('index'));
            }
        }

    }

    //显示登录页面
    public function login(){
        return $this->fetch();
    }
    //处理登录
    public function loginAction(){


        //接收post传过来的数据
        $postData = Request::instance()->post();
        //dump($postData);
        // 验证email是否存在
        $map = array('email'  => $postData['email']);
        $User = User::get($map);
        // $email 要么是一个对象，要么是null。
        if (!is_null($User)) {
//            // 验证密码是否正确
            if ($User->getData('password') !== $postData['password']) {
//                // 用户名密码错误，跳转到登录界面。
                return $this->error("密码或者邮箱错误，请重新登录！", url('login'));
            } else {
                //
                session('id',$User->getData('id'));
                return $this->success('login success', url('Products/index'));
                // 将登录的用户信息保存到session中，以备需要


            }
       } else {
            // 用户名不存在，跳转到登录界面。
           return $this->error('Email not exist', url('login'));
       }
       //重构
        //Email要么是一个对象，要么是null。
//        if (!is_null($Email) && $Email->getData('password') === $postData['password']) {
//            // 用户名密码正确，将' '存session，并跳转至教师管理界面
//            session(' ', $Teacher->getData('id'));
//            return $this->success('login success', url('Products/index'));
//        } else {
//            // 用户名不存在，跳转到登录界面。
//            return $this->error('Email or password incorrect', url('login'));
//        }

    }

    public function ga(){
        return $this->fetch();
    }


}