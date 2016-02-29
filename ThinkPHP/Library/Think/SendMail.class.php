<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Think;

/**
 * Description of SendMail
 *
 * @author Administrator
 */
class SendMail {
    private $host;
    private $smtpauth;
    private $username;
    private $password;
    private $fromUser;
    private $fromName;
    //put your code here
    public function __construct() {
        $this->host="smtp.163.com";
        $this->username="18650215426@163.com";
        $this->password="LIQIYUAN050600";
        $this->fromUser="18650215426@163.com";
        $this->fromName="RainStorm";
    }
    public function index($addresses,$subject,$body){
        //加载第三方类库
        vendor('PHPMailer.PHPMailerAutoload');
       $mail=new \PHPMailer();

        $mail->isSMTP();  //使用发送邮件的协议                       // Set mailer to use SMTP
        $mail->Host = $this->host;       //连接到哪个服务器上发送邮件                    // Specify main and backup SMTP servers
        $mail->SMTPAuth = true;    //开启权限                            // Enable SMTP authentication
        $mail->Username = $this->username;   //登录服务器的用户名               // SMTP username
        $mail->Password = $this->password;    //登录服务器的密码                      // SMTP password

        $mail->From =$this->fromUser;  //发件人的地址
        $mail->FromName = $this->fromName;

        //$addresses = "657405386@qq.com"; //可以传递多个接收人,每个接收人使用,隔开
        $mail->addAddress($addresses);
        $mail->isHTML(true);  //发送的邮件支持html                                 // Set email format to HTML

        $mail->Subject = $subject; //标题
        $mail->Body    = $body;  //内容
//$mail->AltBody = 'This is the body in plain text for non-HTML mail clients';
        if(!$mail->send()) {
            exit($mail->ErrorInfo);
        } else {
            return true;
        }
    }    
}
