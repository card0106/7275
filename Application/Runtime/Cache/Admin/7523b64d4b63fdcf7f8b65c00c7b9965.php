<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>7G传媒 你我同行,成就未来!</title>
<meta name="description" content="7G传媒 你我同行,成就未来!" />
<meta name="keywords" content="7G传媒 你我同行 成就未来" />
<link type="text/css" href="/Public/css/base.css" rel="stylesheet" />
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
    	|<a href="<?php echo U('/');?>">首页</a>|
    	<a href="<?php echo U('/registe');?>">注册</a>|
        <a href="<?php echo U('/news');?>" class="dr">新闻公告</a>|
        <a href="<?php echo U('/question');?>">常见问题</a>|
    	<a href="<?php echo U('/contact');?>">客服中心</a>|
    </div>
</div>
<!--banner-->
<div class="pbanner p02"></div>
<!--main-->
<div class="main">
	<ul class="pnews f14">
            <?php if(is_array($rows)): $i = 0; $__LIST__ = $rows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><li><a target="_blank" href="<?php echo U('/news/'.$row['id']);?>"><?php echo ($row["title"]); ?></a><?php echo date("Y-m-d",$row["time"]);?></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
</div>
<!--main-->
</div>
</div>

<div class="footer">
  <p><a href="#">新闻公告</a>|<a href="#">常见问题</a>|<a href="#">客服中心</a></p>
    <p>Copyright ©2013-2014 Powered by 成都艾华网络科技有限公司 版权所有 蜀ICP备14005370号-1</p>
</div>
</body>
</html>