<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>渝网传媒 你我同行,成就未来!</title>
        <meta name="description" content="渝网传媒 你我同行,成就未来!" />
        <meta name="keywords" content="渝网传媒 你我同行 成就未来" />
        <link type="text/css" href="/Public/css/base.css" rel="stylesheet" />
        <link type="text/css" href="/Public/css/lrtk.css" rel="stylesheet" />
        <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
        <script type="text/javascript" src="/Public/js/lrtk.js"></script>
        <script type="text/javascript" src="/Verify/Index/common"></script>
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
                        <a href="<?php echo U('/');?>" <?php if($menu == 'index'): ?>class="dr"<?php endif; ?> >首页</a>|
                        <a href="<?php echo U('/registe');?>" <?php if($menu == 'registe'): ?>class="dr"<?php endif; ?> >注册</a>|
                        <a href="<?php echo U('/news');?>" <?php if($menu == 'news'): ?>class="dr"<?php endif; ?> >新闻公告</a>|
                        <a href="<?php echo U('/question');?>" <?php if($menu == 'question'): ?>class="dr"<?php endif; ?> >常见问题</a>|
                        <a href="<?php echo U('/contact');?>" <?php if($menu == 'contact'): ?>class="dr"<?php endif; ?> >客服中心</a>
                    </div>
                </div>


<div class="pbanner p02"></div>
<!--main-->
<div class="main">
    <ul class="pnews f14">
        <?php if(is_array($rows)): $i = 0; $__LIST__ = $rows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><li><a target="_blank" href="<?php echo U('/news/'.$row['id']);?>"><?php echo ($row["title"]); ?></a></li><?php endforeach; endif; else: echo "" ;endif; ?>
    </ul>
</div>
<!--main-->
</div>
</div>

<div id="footer" class="footer">
    <p>
    	<a target="_blank" href="/about.html">关于我们</a>|
    	<a target="_blank" href="/business.html">商务合作</a>|
    	<a target="_blank" href="/copyright.html">版权声明</a>|
    	<a target="_blank" href="/service.html">服务条款</a>|
    	<a target="_blank" href="/freeStatement.html">免责声明</a>|
    	<a target="_blank" href="/privacy.html">隐私政策</a>|
    	<a target="_blank" href="/intellectual.html">知识产权声明</a>
    </p>
    <p>Copyright © 2013-2016 渝网联盟效果营销平台【赣ICP备15012890号】</p>
</div>
</div>
</body>
</html>