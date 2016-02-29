<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>渝网传媒</title>
<meta name="description" content="渝网传媒" />
<meta name="keywords" content="渝网传媒介绍" />
<link type="text/css" href="/Public/css/base.css" rel="stylesheet" />
<script type="text/javascript" src="/Public/js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/js/formValidator_min.js"></script>
<!--[if lte IE 6]>
<script src="/Public/js/DD_belatedPNG_0.0.8a.js" type="text/javascript"></script>
    <script type="text/javascript">
    DD_belatedPNG.fix('div , a');
</script>
<![endif]--> 
</head>
<body>
<div id="main">
<div id="content">
<!--header-->
<div class="header">
	<a href="#" class="logo fl"></a>
    <div class="nav fr f16">
    	|<a href="<?php echo U('Index/index');?>">首页</a>|
    	<a href="<?php echo U('Registe/index');?>">注册</a>|
        <a href="<?php echo U('News/index');?>">新闻公告</a>|
        <a href="<?php echo U('Question/index');?>">常见问题</a>|
    	<a href="<?php echo U('Contact/contact');?>">客服中心</a>|
    </div>
</div>

<!--main-->
<div class="main">
	<div class="login">
   	  <div class="fleft fl">
        	<h2>忘记密码</h2>
            <form name="form1" method="post" action="<?php echo U('Registe/forget');?>" onsubmit="return jQuery.formValidator.PageIsValid('1')">
            <dl>
            	<dt>您的用户名：</dt>
                <dd><input type="text" name="username" id="username" class="forgotinput"><br><span id="usernameTip"></span></dd>
            </dl>
            <dl>
            	<dt>您的邮箱：</dt>
                <dd><input type="text" name="email" id="email" class="forgotinput"><br><span id="emailTip"></span></dd>
            </dl>
            <div class="next fl"><input type="submit" name="button" id="button" value="提交" /></div>
           </form>
        </div>
   	  <div class="fright fr">
        没有忘记密码<br /><br /><a href="<?php echo U('Index/index');?>">我要登陆</a></div>
    </div>
</div>
</div>

<div class="footer">
  <p><a href="#">新闻公告</a>|<a href="#">常见问题</a>|<a href="#">客服中心</a></p>
    <p>Copyright ©2013-2014 Powered by 成都艾华网络科技有限公司 版权所有 蜀ICP备14005370号-1</p>
</div>
</div>
<script>
$(document).ready(function(){
	$.formValidator.initConfig({alertMessage:false});
	$("#username").formValidator({onshow:"请输入用户名,4-18位数字或字母组成",onfocus:"请输入用户名,4-18位数字或字母组成",oncorrect:"填写正确"}).InputValidator({min:4,max:18,onerror:"请输入一个4-18位的用户名"}).RegexValidator({regexp:"^[A-Za-z0-9]+$",onerror:"用户名由数字、26个英文字母组成"});
	$("#email").formValidator({onshow:"请输入您的邮箱",onfocus:"请确保他的真实有效",oncorrect:"填写正确"}).InputValidator({min:6,max:100,onerror:"Email地址长度为6至100个字符"}).RegexValidator({regexp:"^([\w-.]+)@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.)|(([\\w-]+.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(]?)$",onerror:"邮箱格式不正确"});
});	
//$("#button").click(function(){
//    var username=$("#username").val();
//    var email=$("#email").val();
//    $.post(
//        "<?php echo U('Registe/forget');?>",
//        {username:username,email:email},
//        function(data){
//            console.debug(data);
//        }
//    );
//    return false;
//});
</script>
</body>
</html>