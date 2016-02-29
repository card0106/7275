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
	<a href="<?php echo U('/pass');?>">修改密码</a>
	<a href="<?php echo U('/shenqingtixian');?>" class="dr">申请提现</a>
    </div>
</div>
<div id="main">
<div id="content">
    <h2 class="f20">申请提现</h2>
    <div class="bok bheight240">
    	<form id="form1" name="form1" method="post" action="<?php echo U('/shenqingtixian');?>" onsubmit="return jQuery.formValidator.PageIsValid('1')">
    	  <div class="con">
        	<dl>
           	  <dt>可提现金额：</dt>
                <dd><strong id="totalmoney"><?php echo ($member["notpay"]); ?></strong>元</dd>
            </dl>
        	
            <dl>
                  <dt>申请金额：</dt>
                    <dd><input name="money" type="text" id="jine" class="text" /><span id="jineTip"></span></dd>
                </dl>
                
                <dl>
                  <dt>提款人姓名：</dt>
                    <dd><?php echo ($member["payee"]); ?></dd>
                </dl>
                
                <dl>
                  <dt>提款银行：</dt>
                    <dd><?php echo ($member["bank_name"]); ?></dd>
                </dl>
                
                <dl>
                  <dt>银行卡号：</dt>
                    <dd><?php echo ($member["bank_account"]); ?></dd>
                </dl>
                
                <dl>
                  <dt>开户行地址：</dt>
                    <dd><?php echo ($member["bank_addr"]); ?></dd>
                </dl>
                
        </div>
    	  
		<div class="button"><input type="submit" id="button" value="申请提现" class="ibutton" />
		  <input type="reset" id="button2" value="取消" class="qbutton"  />
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
	var tm = Number($("#totalmoney").text());
	$("#jine").formValidator({onshow:"申请金额必须是整数，例如860，本次可提现最大金额为:"+tm+"元",onfocus:"申请金额必须是整数，例如860。",oncorrect:"填写正确"}).RegexValidator({regexp:"^[0-9]*$",onerror:"申请金额必须是数字且为整数。"}).InputValidator({min:1,max:tm,type:"number",onerrormin:"申请金额必须大于0。",onerrormax:"申请金额必须小于"+tm+"。"});
});	

</script>
</body>
</html>