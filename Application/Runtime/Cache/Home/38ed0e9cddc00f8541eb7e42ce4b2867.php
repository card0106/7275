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
    	<a href="<?php echo U('/userinfo');?>" <?php if('goods' == 'info'): ?>class='dr'<?php endif; ?>>我的首页</a>
    	<a href="<?php echo U('/myad');?>" <?php if('goods' == 'ad'): ?>class='dr'<?php endif; ?>>我的广告</a>
    	<a href="<?php echo U('/getgoods');?>"<?php if('goods' == 'goods'): ?>class='dr'<?php endif; ?>>获取产品</a>
    	<a href="<?php echo U('/effect');?>"<?php if('goods' == 'effect'): ?>class='dr'<?php endif; ?>>效果报告</a>
    	<a href="<?php echo U('/detail');?>"<?php if('goods' == 'detail'): ?>class='dr'<?php endif; ?>>提现记录</a>
     </div>
     <div class="out fr"><a href="<?php echo U('/userinfo');?>"><?php echo ($_SESSION["membersinfo"]["username"]); ?></a><font>|</font><a href="<?php echo U('Home/Index/logout');?>">安全退出</a></div>
</div>

<?php if('goods' != 'info' && 'goods' != 'goods'): ?><div id="main">
<div id="content"><?php endif; ?>
<!---引入分页样式------->
<link type="text/css" href="/Public/css/page.css" rel="stylesheet" />
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/tipswindown.js"></script>
<?php if(count($cats) > 1): ?><div id="menu" class="f14">
  <div class="two">
    <?php if(is_array($cats)): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;?><a href="<?php echo U('/getgoods'.$cat['id']);?>" <?php if($catid == $i): ?>class="dr"<?php endif; ?>><?php echo ($cat["category_name"]); ?></a><?php endforeach; endif; else: echo "" ;endif; ?>
    </div>
</div><?php endif; ?>
<div id="main">
<div id="content">
    	<table width="100%" border="1" cellpadding="0" cellspacing="0">
            <tr>
                <th width="19%" colspan=2>产品名称</th>
                <th width="11%">价格</th>
                <th width="12%">结算周期</th>
                <th width="11%">出数据时间</th>
                <th width="37%">说明</th>
                <th width="10%">获取产品</th>
            </tr>
            <?php if(is_array($rows)): $i = 0; $__LIST__ = $rows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><tr <?php if($row["have"] == true): ?>style="background: rgb(220,220,220);"<?php endif; ?>>
            
                <td style="text-align: right;"><img src="<?php echo ($row["goods_small_img"]); ?>" width="30" height="30"></td><td style="text-align: left;"><?php echo ($row["goods_name"]); ?></td>
                <td>
                    <?php if($row["cash_type"] == 0): ?>￥<span class="color1"><?php echo ($row["down_price_1"]); ?></span>
                    <?php elseif($row["cash_type"] == 1): ?>
                    <span class="color1"><?php echo ($row["down_price_1"]); ?></span>%<?php endif; ?>
                </td>
                <td>
                    <?php if($row['invoicing_cycle'] == 0): ?>每日
                        <?php elseif($row['invoicing_cycle'] == 1): ?>每周
                        <?php elseif($row['invoicing_cycle'] == 2): ?>双周
                        <?php elseif($row['invoicing_cycle'] == 3): ?>每月<?php endif; ?>
                </td>
                <td>
                    <?php if($row['data_back'] == 0): ?>次日
                        <?php elseif($row['invoicing_cycle'] == 1): ?>实时
                        <?php else: ?>每周<?php endif; ?>
                </td>
                <td><?php echo ($row["intro"]); ?></td>
                <td>
                    <a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=11507712&site=qq&menu=yes">
                        <img border="0"  src="http://wpa.qq.com/pa?p=2:11507712:42" alt="联系我们!" title="联系我们!" />
                    </a>
                </td>
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
<script type="text/javascript"> 
   //为联系客服注册点击事件
   $(".cursor").click(function(){
       alert("请联系我们的QQ客服！");
   });
</script>
</body>
</html>