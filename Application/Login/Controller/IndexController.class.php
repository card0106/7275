<?php
namespace Login\Controller;
use Think\Controller;
class IndexController extends Controller {
    //前台生成验证码
    public function verify(){
        $Verify = new \Think\Verify();
        $Verify->entry();        
    }     
    //展示后台登陆页面，以及处理登录的业务逻辑
    public function index(){
        if(IS_POST){    //点击登陆
            //>>比较验证码
            $verify = new \Think\Verify();
            if($verify->check(I('post.checkcode'))===false){
                //$this->error('验证码错误!',U('Login/Index/index'));
                $this->ajaxReturn("验证码错误");
                exit;
            }            
            $adminModel=D("Admin");  
            if($adminModel->create()!==false){
                $data=$adminModel->create();
                $result=$adminModel->login();
                 //>>1.登录的结果
                 /**
                  *  1. 如果返回值是一个数组(用户信息): 登录成功
                  *  2. 返回值为 -1: 表示用户名出错
                  *  3. 返回值为-2 :表示密码出错.
                  */
                 if(is_array($result)){
                    //对比成功, 需要将用户信息$result放到session中
                    session('userinfo',$result); //将数据保存到session中
                    //更新当前ID所对应的lastip以及lasttime
                    $res=$adminModel->where("id={$result['id']}")->save($data);
                    if($res!==false){
                        //$this->success('登录成功!',U('Admin/Index/index'));
                        $this->ajaxReturn(1);
                    }else{
                        //$this->error('数据更新失败!',U('Login/Index/index'));
                        $this->ajaxReturn("数据更新失败");
                        exit;
                    }
                 }else{
                     $error = '';
                    if($result==-1){
                        $error = '用户名出错';
                    }elseif($result==-2){
                        $error = '密码错误';
                    }
//                    $this->error('登录失败.'.$adminModel->getError());
                    $this->ajaxReturn($error);
                 }
            }else{
//                $this->error('验证失败!'.$adminModel->getError());
                $this->ajaxReturn("验证失败");
            }         
        }else{  //直接展示登录页面即可
            $this->display();
        }
    }
    //安全退出
    public function logout(){
        $_SESSION["userinfo"]="";
        $this->display("index");
    }
}