<?php
namespace Admin\Behavior;
header("Content-Type:text/html;charset=utf-8");
/**
 * Description of CheckPermissionBehavior
 *
 * @author Administrator
 */
class CheckPermissionBehavior  extends \Think\Behavior{
     public function run(&$params){
         //先判断用户是否登录
        if(!session('userinfo')){
            redirect(U('Login/Index/index'));//,2,"<h1>请先登录,2秒后自动登录</h1>");
        }
     }
}
