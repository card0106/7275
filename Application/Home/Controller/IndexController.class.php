<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    //展示首页面
    public function index(){
        if(IS_POST){    //点击”登陆“
            //>>比较验证码
            $verify = new \Think\Verify();
            if($verify->check(I('post.checkcode'))===false){
                //$this->error('验证码错误!',U('Home/Index/index'));
       			//$key = $this->authcode($this->seKey).$id;
                //$this->ajaxReturn($verify->authcode(strtoupper($verify->code))."\r\n".$secode['verify_code']);
                $this->ajaxReturn("验证码错误");
                exit;
            } 
            $membersModel=D("Members");  
            if($membersModel->create()!==false){
                $data=$membersModel->create();
                $result=$membersModel->login();
                 //>>1.登录的结果
                 /**
                  *  1. 如果返回值是一个数组(用户信息): 登录成功
                  *  2. 返回值为 -1: 表示用户名出错
                  *  3. 返回值为-2 :表示密码出错.
                  */
                 if(is_array($result)){
                   //对比成功, 需要将用户信息$result放到session中
                   session('membersinfo',$result); //将数据保存到session中
                   //更新当前ID所对应的登录次数
                   $res=$membersModel->where("id={$result['id']}")->setInc("login_num");
                   $this->ajaxReturn(1);
                   //redirect(U('Home/Userinfo/userInfo'));
                   //$this->success('登录成功!',U('Home/Userinfo/userInfo'));
                 }else{
                     $error = '';
                    if($result==-1){
                        $error = '用户名出错';
                    }elseif($result==-2){
                        $error = '密码错误';
                    }elseif($result==-3){
                        $error = '账号未开通，请联系客服开通后才能正常使用！';
                    }
                    //$this->error('登录失败.'.$error);
                    $this->ajaxReturn($error);
                 }
            }else{
                //$this->error('验证失败!'.$error);
                $this->ajaxReturn("验证失败");
            }         
        }else{
            $this->assign("rows",M("News")->order("time DESC")->select());
            $this->display(T('Home@Index/index'));
        }
    }
    //退出登录
    public function logout(){
        session("membersinfo", null);
        //redirect("Index/index");
       	header("location: /");
       	exit;
        //$this->display("index");
    }
}