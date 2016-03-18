<?php
namespace Home\Controller;

/**
 * Description of RegisteController
 *
 * @author Administrator
 */
class RegisteController extends \Think\Controller{
    //展示注册页面，以及处理注册的业务逻辑
    public function index(){
        if(IS_POST){    //点击注册
            $membersModel=D("Members");
            if($membersModel->create()!==false){ //填写符合数据库的字段
           		$mid = $membersModel->add();
                if($mid!==false){
                	$row = $membersModel->getById($mid);
                    $userinfo['id'] = $row['id'];
                    $userinfo['username'] = $row['username'];
                    session('membersinfo',$userinfo);
                    $membersModel->where("id={$mid}")->setInc("login_num");
        			header("location: ".U('Home/Userinfo/userInfo'));
        			
                    //$this->success("恭喜你，注册成功！",U("Home/Userinfo/userInfo"));
                }else{
                    $this->error("注册失败！".$membersModel->getError());                    
                }
            } $this->display(T('Home@Registe/index'));
        }else{
            $this->display(T('Home@Registe/index'));
        }
    }
    public function forget(){
        if(IS_POST){
            $username=I("post.username");
            $email=I("post.email");
            $membersModel=D("Members");
            //验证是否对比成功
            $res=$membersModel->checkByUserEmail($username,$email);
            if($res){   //匹配成功，返回他的ID
                $range= rand(111111, 999999);
                shuffle($range);
                $mes=$membersModel->where("id={$res}")->save(array("password"=>  md5($range)));
                $mail=new \Think\SendMail();
                $res=$mail->index($email, "渝网传媒-找回密码".  date("Y-m-d H:i:s",time() ), "你的密码是".$range."!!请尽快更改密码");
                $mes=$res?"成功发送找回密码的邮件":"邮件暂未发送，请稍候重试";
                $this->success("邮件默认会发送到--垃圾邮箱","/index/index.html");
            }else{
                $this->error("账号和email不匹配");
            }
        }else{
             $this->display();
        }
        //$this->success("请联系客服！",U("Home/Index/index"));
    }//验证用户名是否已经存在
    public function checkUserExist($username){
        $membersModel=M("Members");
        $id=$membersModel->getFieldByUsername($username,"id");
        $response=$id?0:1;
        $this->ajaxReturn($response);
    }
}
