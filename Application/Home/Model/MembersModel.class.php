<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Model;

/**
 * Description of MemberModel
 *
 * @author Administrator
 */
class MembersModel extends \Think\Model{
    //开启自动验证、
    //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
   protected $_validate = array(
       array('username','require','管理员账号必须填写！'), // 在新增的时候验证name字段是否唯一     
       array('password',"require",'管理员密码必需填写！'), // 当值不为空的时候判断是否在一个范围内
       array('qq',"require",'qq号码必须填写！'),
       array('tel',"require",'手机号码必须填写！'),
       array('email',"require",'邮箱必须填写！'),
       array('payee',"require",'收款人必须填写！'),
       array('bank_name',"",'所属银行必须填写！'),
       array('bank_account',"",'银行账户必须填写！'),
       array('bank_addr',"",'开户行地址必须填写！'),
       array('zhifubao',"",'支付宝与银行必须填一个')
    );      
    /**
     * 自动完成规则的语法
     * array(
     *      array(完成字段1,完成规则,[完成条件,附加规则]),
     *      array(完成字段2,完成规则,[完成条件,附加规则]),
     *  ......);
     */
    protected $_auto  =   array(  //被create激活... 自动完成执行...
        array('password','md5',self::MODEL_INSERT,'function'),   //自动完成对密码的加密
        array('client_ip','getIp',self::MODEL_INSERT,'function'),   //自动获取到最后登录的IP
        array('enter_time',"time",self::MODEL_INSERT,'function')   //自动获取加入联盟的时间戳
    );  // 自动完成定义  
    //处理用户登录
    public function login(){
        $username = $this->data['username'];
        $password = $this->data['password'];
        //>>1.先根据用户名查询用户名对应的记录
           $row = $this->getByUsername($username);
           if($row){
               //将用户录入的密码加密后和数据库表中的密码进行对比
//               $password = md5($password);
               //>>2.根据密码和数据库中的密码做比较
               if($row['state']==0){
               	   //账号未开通
                   return -3;
               }elseif($password==$row['password']){
                    $userinfo['id'] = $row['id'];
                    $userinfo['username'] = $row['username'];
                    return $userinfo; //用户的信息
               }else{
                   //密码错误
                   return -2;
               }
           }else{
              //用户名不存在
               return -1;
           }
    }
    //比对用户名和email
    public function checkByUserEmail($user="",$email=""){
        $emails=$this->getFieldByUsername($user,"email");
        if($emails==$email){
            $id=  $this->getFieldByUsername($user,"id");
        }else{
            $id=0;
        }
        return $id;
    }
}
