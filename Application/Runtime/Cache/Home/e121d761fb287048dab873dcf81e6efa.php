<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>渝网传媒 你我同行,成就未来!</title>
<meta name="description" content="渝网传媒 你我同行,成就未来!" />
<meta name="keywords" content="渝网传媒 你我同行 成就未来" />
<link type="text/css" href="/Public/css/user/base.css" rel="stylesheet" />
<script type="text/javascript" src="/Public/js/jquery.js"></script>

</head>
<body>

<div id="header">
	<div class="logo fl"><img src="/Public/images/user/logo.gif" width="206" height="41" /></div>
    <div class="nav fl f16">
    	<a href="<?php echo U('/userinfo');?>" <?php if('info' == 'info'): ?>class='dr'<?php endif; ?>>我的首页</a>
    	<a href="<?php echo U('/myad');?>" <?php if('info' == 'ad'): ?>class='dr'<?php endif; ?>>我的广告</a>
    	<a href="<?php echo U('/getgoods');?>"<?php if('info' == 'goods'): ?>class='dr'<?php endif; ?>>获取产品</a>
    	<a href="<?php echo U('/effect');?>"<?php if('info' == 'effect'): ?>class='dr'<?php endif; ?>>效果报告</a>
    	<a href="<?php echo U('/detail');?>"<?php if('info' == 'detail'): ?>class='dr'<?php endif; ?>>提现记录</a>
     </div>
     <div class="out fr"><a href="<?php echo U('/userinfo');?>"><?php echo ($_SESSION["membersinfo"]["username"]); ?></a><font>|</font><a href="<?php echo U('Home/Index/logout');?>">安全退出</a></div>
</div>

<?php if('info' != 'info' && 'info' != 'goods'): ?><div id="main">
<div id="content"><?php endif; ?>
<script type="text/javascript" src="/Public/js/jquery.min.js"></script>
<script type="text/javascript" src="/Public/js/formValidator_min.js"></script>
<!--导航栏 结束-----> 
<div id="menu" class="f14">
	<div class="one">
	<a href="<?php echo U('/userinfo');?>">概况</a>
	<a href="<?php echo U('/individual');?>">个人信息</a>
	<a href="<?php echo U('/pass');?>" class="dr">修改密码</a>
	<a href="<?php echo U('/shenqingtixian');?>">申请提现</a>
    </div>
</div>
<div id="main">
<div id="content">
    <h2 class="f20">修改密码</h2>
    <div class="bok bheight240">
    	<form id="form1" name="form1" method="post" action="<?php echo U('/pass');?>" onsubmit="return jQuery.formValidator.PageIsValid('1')">
    	  <div class="con">
        	<dl>
           	  <dt>旧密码：</dt>
                <dd><input name="oldpass" type="password" class="text" id="oldpass" value="" /><span id="oldpassTip"></span></dd>
            </dl>
        	
            <dl>
                  <dt>新密码：</dt>
                    <dd><input name="password" type="password" id="password" class="text" /><span id="passwordTip"></span></dd>
                </dl>
                
                <dl>
                  <dt>确认新密码：</dt>
                    <dd><input name="passwordre" type="password" id="passwordre" class="text" /><span id="passwordreTip"></span></dd>
                </dl>
                
        </div>
    	  
		<div class="button"><input type="submit" id="button" value="提交" class="ibutton" />
		  <input type="reset" id="button2" value="取消" class="qbutton" onclick="history.back(-1)" />
		</div>
        </form>
    </div>
</div>
</div>
<div id="footer">
    <p><a target="_blank" href="/news.html">新闻公告</a>|<a target="_blank" href="/question.html">常见问题</a>|<a target="_blank" href="/contact.html">客服中心</a></p>
    <p>Copyright ©2013-2014 Powered by 成都艾华网络科技有限公司 版权所有 蜀ICP备14005370号-1</p>
</div>
<script>
$(document).ready(function(){
	$.formValidator.initConfig({alertMessage:false});
	$("#oldpass").formValidator({onshow:"请输入旧密码",onfocus:"请输入旧密码",oncorrect:"填写正确"}).InputValidator({min:6,onerror:"请输入旧密码"}).RegexValidator({regexp:"^.*$",onerror:"请输入旧密码"});
	$("#password").formValidator({onshow:"请输入密码",onfocus:"使用英文字母加数字的组合，且在6-16个字符以内",oncorrect:"填写正确"}).InputValidator({min:6,max:16,onerror:"使用英文字母加数字的组合，且在6-16个字符以内"});
	$("#passwordre").formValidator({onshow:"请再输入一遍您上面输入的密码",onfocus:"请再输入一遍您上面输入的密码",oncorrect:"填写正确"}).InputValidator({min:6,max:16,onerror:"请再输入一遍您上面输入的密码"}).CompareValidator({desID:"password",operateor:"=",onerror:"请再输入一遍您上面输入的密码"});

});
</script>
</body>
</html>