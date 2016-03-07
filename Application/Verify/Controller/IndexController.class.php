<?php
namespace Verify\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        echo "hello world";
    }
    //前台生成验证码
    public function verify(){
    	$config =	array(
        	//'seKey'     =>  '7G_Media',   // 验证码加密密钥
      		'imageW'    =>  130,               // 验证码图片宽度
      		'imageH'    =>  45,               // 验证码图片高度
	        'fontSize'  =>  18,              // 验证码字体大小(px)
	        'useCurve'  =>  false,            // 是否画混淆曲线
	        'useNoise'  =>  true            // 是否添加杂点	
	        );
        $Verify = new \Think\Verify($config);
        $Verify->entry();
    }
    
    public function common(){
		die(session('membersinfo')?"location.href='".U('/userinfo')."';":"");
    }
}