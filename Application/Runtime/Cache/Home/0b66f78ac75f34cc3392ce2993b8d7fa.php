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
    	<a href="<?php echo U('/userinfo');?>" <?php if('effect' == 'info'): ?>class='dr'<?php endif; ?>>我的首页</a>
    	<a href="<?php echo U('/myad');?>" <?php if('effect' == 'ad'): ?>class='dr'<?php endif; ?>>我的广告</a>
    	<a href="<?php echo U('/getgoods');?>"<?php if('effect' == 'goods'): ?>class='dr'<?php endif; ?>>获取产品</a>
    	<a href="<?php echo U('/effect');?>"<?php if('effect' == 'effect'): ?>class='dr'<?php endif; ?>>效果报告</a>
    	<a href="<?php echo U('/detail');?>"<?php if('effect' == 'detail'): ?>class='dr'<?php endif; ?>>提现记录</a>
     </div>
     <div class="out fr"><a href="<?php echo U('/userinfo');?>"><?php echo ($_SESSION["membersinfo"]["username"]); ?></a><font>|</font><a href="<?php echo U('Home/Index/logout');?>">安全退出</a></div>
</div>

<?php if('effect' != 'info' && 'effect' != 'goods'): ?><div id="main">
<div id="content"><?php endif; ?>
<link type="text/css" href="/Public/css/jquery-ui.css" rel="stylesheet" />
<link type="text/css" href="/Public/css/page.css" rel="stylesheet" />
<script type="text/javascript" src="/Public/js/jquery-ui-datepicker.js"></script>

        <div class="bok" style="_margin-top:20px;">
    	<form id="form1" name="form1" method="post" action="<?php echo U('/effect');?>" onsubmit="return jQuery.formValidator.PageIsValid('1')">
       	  <div class="time fl">日期：</div>
          <div class="time fl"><input type="text" id="date_1" name="date_begin" value="<?php echo date('Y-m-d',$date_begin);?>" readonly /></div>
       	  <div class="time fl">至</div>
		  <div class="time fl"><input type="text" id="date_2" name="date_end" value="<?php echo date('Y-m-d',$date_end);?>" readonly /></div>
          <div class="time1 fl">产品：</div>
			<div class="time fl"><input type="text" name="product_name" value="<?php echo ($product_name); ?>" style="width:250px;" /></div>
			<div class="time1 fl"><input type="submit" id="button" value="查询" class="but cursor" /></div>
        </form>
  </div>
    	<table width="100%" border="1" cellpadding="0" cellspacing="0">
            <tr>
                <th width="15%">日期</th>
                <th width="15%">产品名称</th>
                <th width="10%">结算周期</th>
                <th width="10%">推广量</th>
                <th width="10%">单价</th>
                <th width="10%">总收益</th>
            </tr>
            <?php if(is_array($rows)): $i = 0; $__LIST__ = $rows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><tr>
                    <td><strong><?php echo date('Y-m-d',$row['time']);?> </strong></td>	
                    <td><?php echo ($row["goods_name"]); ?></td>	
                    <td>
                        <?php if($row['invoicing_cycle'] == 0): ?>每日
                            <?php elseif($row['invoicing_cycle'] == 1): ?>每周
                            <?php elseif($row['invoicing_cycle'] == 2): ?>双周
                            <?php elseif($row['invoicing_cycle'] == 3): ?>每月<?php endif; ?>
                    </td>
                    <td><?php if($row['promote_num'] == ''): ?>0    <?php else: ?> <?php echo round($row['promote_num']*(100-$row['discount'])/100); endif; ?></strong></td>
                    <td><?php echo ($row["dprice1"]); ?></td>
                    <td><?php echo ($row["money"]); ?></td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
        <!--分页工具条 开始---->
        <div id="turn-page" class="page">
            <?php echo ($pageHTML); ?>
        </div> 
        <!--分页工具条 结束---->
</div>
</div>
<div id="footer">
    <p><a target="_blank" href="/news.html">新闻公告</a>|<a target="_blank" href="/question.html">常见问题</a>|<a target="_blank" href="/contact.html">客服中心</a></p>
    <p>Copyright ©2013-2014 Powered by 成都艾华网络科技有限公司 版权所有 蜀ICP备14005370号-1</p>
</div>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script type="text/javascript">
 $(function(){
	$("#date_1").datepicker();
	$("#date_2").datepicker();
});
</script>

</body>
</html>