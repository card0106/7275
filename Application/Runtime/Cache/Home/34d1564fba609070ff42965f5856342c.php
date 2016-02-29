<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>7G传媒 你我同行,成就未来!</title>
<meta name="description" content="7G传媒 你我同行,成就未来!" />
<meta name="keywords" content="7G传媒 你我同行 成就未来" />
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
	<a href="<?php echo U('/individual');?>" class="dr">个人信息</a>
	<a href="<?php echo U('/pass');?>">修改密码</a>
	<a href="<?php echo U('/shenqingtixian');?>">申请提现</a>
    </div>
</div>
<div id="main">
<div id="content">
<?php if($edit == false): ?><h2 class="f20">个人信息<a href="<?php echo U('/individual','edit=1');?>">修改</a></h2>
    <div class="bok bheight590">
    	<div class="tit f14">基本信息</div> 
        <div class="con">
        	<dl>
            	<dt>用户名：</dt>
                <dd><?php echo ($member["username"]); ?></dd>
            </dl>
        	<dl>
            	<dt>QQ：</dt>
                <dd><?php echo ($member["qq"]); ?></dd>
            </dl>
        	<dl>
            	<dt>手机：</dt>
                <dd><?php echo ($member["tel"]); ?></dd>
            </dl>
        	<dl>
            	<dt>邮箱：</dt>
                <dd><?php echo ($member["email"]); ?></dd>
            </dl>
        	<dl>
            	<dt>注册日期：</dt>
                <dd><?php echo ($member["enter_time"]); ?></dd>
            </dl>
        </div>
        <div class="tit f14 mtop10">基本信息</div>
        <div class="con">
        	<dl>
            	<dt>收款人：</dt>
                <dd><?php echo ($member["payee"]); ?></dd>
            </dl>
        	<dl>
            	<dt>银行信息：</dt>
                <dd><?php echo ($member["bank_name"]); ?></dd>
            </dl>
        	<dl>
            	<dt>银行账户：</dt>
                <dd><?php echo ($member["bank_account"]); ?></dd>
            </dl>
        	<dl>
            	<dt>开户行地址：</dt>
                <dd><?php echo ($member["bank_addr"]); ?></dd>
            </dl>
        </div>
    </div>
<?php else: ?>
    <h2 class="f20">修改个人信息</h2>
    <div class="bok bheight590">
    	<form id="form1" name="form1" method="post" action="#" onsubmit="return jQuery.formValidator.PageIsValid('1')">
    	<div class="tit f14">基本信息</div> 
        <div class="con">
        	<dl>
            	<dt>用户名：</dt>
                <dd><?php echo ($member["username"]); ?></dd>
            </dl>
        	<dl>
           	  <dt>QQ：</dt>
                <dd><input name="qq" type="text" class="text" id="qq" value="<?php echo ($member["qq"]); ?>" /><span id="qqTip"></span></dd></dd>
            </dl>
        	<dl>
            	<dt>手机：</dt>
                <dd><input name="tel" type="text" class="text" id="tel" value="<?php echo ($member["tel"]); ?>" /><span id="telTip"></span></dd>
            </dl>
        	<dl>
            	<dt>邮箱：</dt>
                <dd><input name="email" type="text" class="text" id="email" value="<?php echo ($member["email"]); ?>" /><span id="emailTip"></span></dd>
            </dl>
        </div>
        <div class="tit f14 mtop10">基本信息</div>
        <div class="con">
        	<dl>
            	<dt>收款人：</dt>
                <dd><?php echo ($member["payee"]); ?></dd>
            </dl>
        	<dl>
            	<dt>银行信息：</dt>
                <dd><input name="bank_name" type="text" class="text" id="bank_name" value="<?php echo ($member["bank_name"]); ?>" /><span id="bank_nameTip"></span></dd>
            </dl>
        	<dl>
            	<dt>银行账户：</dt>
                <dd><input name="bank_account" type="text" class="text" id="bank_account" value="<?php echo ($member["bank_account"]); ?>" /><span id="bank_accountTip"></span></dd>
            </dl>
        	<dl>
            	<dt>开户行地址：</dt>
                <dd><input name="bank_addr" type="text" class="text" id="bank_addr" value="<?php echo ($member["bank_addr"]); ?>" /><span id="bank_addrTip"></span></dd>
            </dl>
        </div>
		<div class="button"><input type="submit" id="button" value="提交" class="ibutton" />
		  <input type="reset" id="button2" value="取消" class="qbutton" onclick="history.back(-1)" />
		</div>
        </form>
    </div><?php endif; ?>
<script>

$(document).ready(function(){
	$.formValidator.initConfig({alertMessage:false});
	$("#qq").formValidator({onshow:"QQ由数字组成",onfocus:"QQ由数字组成",oncorrect:"填写正确"}).InputValidator({min:5,max:11,onerror:"由数字组成"}).RegexValidator({regexp:"^[0-9]*$",onerror:"QQ由数字组成"});
	
	$("#tel").formValidator({onshow:"由11位数字组成",onfocus:"由11位数字组成",oncorrect:"填写正确"}).InputValidator({min:11,max:11,onerror:"由11位数字组成"}).RegexValidator({regexp:"^[0-9]*$",onerror:"由11位数字组成"});
	
	$("#email").formValidator({onshow:"请输入您的邮箱",onfocus:"请确保他的真实有效",oncorrect:"填写正确"}).InputValidator({min:6,max:100,onerror:"Email地址长度为6至100个字符"}).RegexValidator({regexp:"^([\w-.]+)@(([[0-9]{1,3}.[0-9]{1,3}.[0-9]{1,3}.)|(([\\w-]+.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(]?)$",onerror:"邮箱格式不正确"});
	
	$("#bank_name").formValidator({onshow:"银行信息",onfocus:"银行信息",oncorrect:"填写正确"}).InputValidator({min:2,onerror:"银行信息"}).RegexValidator({regexp:"^.*$",onerror:"银行信息"});
	
	$("#bank_account").formValidator({onshow:"请输入银行账号，由6位以上字符组成",onfocus:"银行账号长度最少需要6个字符",oncorrect:"填写正确"}).InputValidator({min:6,onerror:"银行账号长度最少需要6个字符"}).RegexValidator({regexp:"^[0-9]",onerror:"由6位以上字符组成"});

	$("#bank_addr").formValidator({onshow:" xx省xx市xx分行xx支行",onfocus:" xx省xx市xx分行xx支行",oncorrect:"填写正确"}).InputValidator({min:2,onerror:" xx省xx市xx分行xx支行"}).RegexValidator({regexp:"^.*$",onerror:" xx省xx市xx分行xx支行"});
	});
</script>
</div>
</div>
<div id="footer">
    <p><a target="_blank" href="/news.html">新闻公告</a>|<a target="_blank" href="/question.html">常见问题</a>|<a target="_blank" href="/contact.html">客服中心</a></p>
    <p>Copyright ©2013-2014 Powered by 成都艾华网络科技有限公司 版权所有 蜀ICP备14005370号-1</p>
</div>
</body>
</html>