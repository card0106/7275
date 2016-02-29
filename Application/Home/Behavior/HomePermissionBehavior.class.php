<?php
namespace Home\Behavior;
header("Content-Type:text/html;charset=utf-8");
/**
 * Description of CheckPermissionBehavior
 *
 * @author Administrator
 */
class HomePermissionBehavior  extends \Think\Behavior{
    //put your code here
     public function run(&$params){
         $allow=array(
             U('Home/Index/index'),
             U('Home/Registe/index'),
             U('Home/Contact/contact'),
             U('Home/Registe/checkUserExist'),
             U('Home/Registe/forget'),
             "/registe/forget.html",
             "/forget.html",
             "/index/index.html",
             "/"
            );
//         echo "<pre>";
//         die(var_dump($_SERVER["REQUEST_URI"]));
        //先判断用户是否登录
        if(!in_array($_SERVER["REQUEST_URI"], $allow)){
           if(!session('membersinfo')){
               redirect(U('/'),2,"<h1>请先登录,2秒后自动登录</h1>");
           }
        }             
     }
}
