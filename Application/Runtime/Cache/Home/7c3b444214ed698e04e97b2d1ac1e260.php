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

<div id="menu" class="f14">
	<div class="one">
	<a href="<?php echo U('/userinfo');?>" class="dr">概况</a>
	<a href="<?php echo U('/individual');?>">个人信息</a>
	<a href="<?php echo U('/pass');?>">修改密码</a>
	<a href="<?php echo U('/shenqingtixian');?>">申请提现</a>
    </div>
</div>
<div id="main">
<div id="content">
	<div class="bok"><span>您好：<?php echo ($member["username"]); ?></span><span>上次登录时间：<?php echo ($member["enter_time"]); ?></span><span>上次登录IP：<?php echo ($member["client_ip"]); ?></span><span>登录次数：<?php echo ($member["login_num"]); ?>次</span></div>
    <h2 class="f20">数据报告</h2>
    <div class="bok bheight80">
    	<div class="income fl">昨日收入<br /><i class="f28 color1">￥<?php echo ($money["yesterday"]); ?>元</i></div>
    	<div class="income fl">总收入<br /><i class="f28 color1">￥<?php echo ($money["total"]); ?>元</i></div>
    	<div class="income fl">未支付<br /><i class="f28 color1">￥<?php echo ($money["notpay"]); ?>元</i></div>
    </div>
    <h2 class="f20">付款规则</h2>
    <div class="bok">
        <p>联盟最低付款金额为10元(含)；如果当{日/周}"应付收入(税前)"未达到最低付款额，则联盟会将收入进行累计。</p>
        <p>会员可以选择保留付款方式保留您的收入，期间收入将在账户进行累计。若会员取消保留付款且达到最低支付额度，联盟将在下一付款周期进行支付。</p>
        <p>正常付款日期为每周三至周五，若付款状态显示"付款已经完成"，说明联盟已向银行安排付款，银行正在处理，请耐心等待。</p>
    </div>
    <h2 class="f20">企业会员注意事项</h2>
    <div class="bok">
        <p>企业会员请根据当月发票条目，分别开发票。并将发票号填入至对应的发票详情中，以配合7G联盟付款工作。</p>
        <p>请确保财务公司、信息服务费/技术服务费及金额准确无误。否则7G联盟将不予付款。</p>
        <p>企业付款流程为：开发票→填写发票信息→邮寄发票。</p>
    </div>
</div>
</div>
<div id="footer">
    <p><a target="_blank" href="/news.html">新闻公告</a>|<a target="_blank" href="/question.html">常见问题</a>|<a target="_blank" href="/contact.html">客服中心</a></p>
    <p>Copyright ©2013-2014 Powered by 成都艾华网络科技有限公司 版权所有 蜀ICP备14005370号-1</p>
</div>
</body>
</html>