<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Question\Controller;

/**
 * Description of QuestionController
 *
 * @author Administrator
 */
class QuestionController extends \Think\Controller{
    //展示常见问题
    public function index(){
        $questionModel=M("Question");
        $rows=$questionModel->order("time DESC")->select();
        $this->assign("rows",$rows);
        $this->display(T('Question@Question/index'));
    }
    //处理忘记密码的功能
    public function forget(){
        if(IS_POST){
            $addresses=I("post.email");
            //通过这些找到对应的记录，并修改密码
            $memberModel=D("Members");
            $res=$memberModel->resetPwd($addresses);
            if($res!==-1){
                $mail=new \Think\SendMail();
                $result=$mail->index($addresses, "重置密码", "重置密码为111111，请登录之后迅速更改!!");
                $mes=$result?"发送重置密码的邮件成功,注意查收":"邮件未发送成功！请稍后重试!";
                $this->success($mes);
            }else{
                $this->error("密码未更新成功!!");
            }
        }else{
           $this->display(); 
        }
    }
}
