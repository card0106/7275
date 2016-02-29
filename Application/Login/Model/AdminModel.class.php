<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Login\Model;

/**
 * Description of AdminModel
 *
 * @author Administrator
 */
class AdminModel extends \Think\Model{
    //开启自动验证、
    //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
   protected $_validate = array(
       array('checkcode','require','验证码必须填写！'), //默认情况下用正则进行验证     
       array('username','require','管理员账号必须填写！'), // 在新增的时候验证name字段是否唯一     
       array('password',"require",'管理员密码必需填写！') // 当值不为空的时候判断是否在一个范围内
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
        array('lasttime',NOW_TIME,self::MODEL_INSERT),   //自动生成最后完成时间
        array('lastip','getIp',self::MODEL_INSERT,'function'),   //自动获取到最后登录的IP
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
               if($password==$row['password']){
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
}
