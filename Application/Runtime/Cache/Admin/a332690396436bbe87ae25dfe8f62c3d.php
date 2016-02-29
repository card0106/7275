<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>7G传媒 你我同行,成就未来!</title>
<link type="text/css" href="/Public/css/base_1.css" rel="stylesheet" />
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<!--[if lte IE 6]>
<script src="script/DD_belatedPNG_0.0.8a.js" type="text/javascript"></script>
    <script type="text/javascript">
    DD_belatedPNG.fix('div , a');
</script>
<![endif]--> 
</head>
<body>
<div id="main">
<div class="left fl">
        <div class="face"></div>
    <div class="nav0">
        <a href="<?php echo U('Index/index');?>" class="n1">基本信息</a>
        <a href="<?php echo U('Members/index');?>" class="n2">用户信息</a>
        <a href="<?php echo U('Product/index');?>" class="dr3">产品信息</a>
        <a href="<?php echo U('Invoicing/invoicing');?>" class="n4">结算列表</a>
        <a href="<?php echo U('Cash/cash');?>" class="n4">提现列表</a>
        <a href="<?php echo U('News/index');?>" class="n6">新闻公告</a>
        <a href="<?php echo U('Question/index');?>" class="n7">常见问题</a>            
    </div>
</div>
<div class="right">
    <div class="mtit">
        <div class="blue f20 fl">CMS联盟</div>
        <div class="fr">
                <div class="userout fl"><a href="javascript:void(0)"><?php echo ($_SESSION["userinfo"]["username"]); ?></a></div>
                <div class="out fl"><a href="<?php echo U('Login/Index/logout');?>">退出</a></div>
        </div>
    </div>
    <div class="tit f20">批量导入安装数据</div>
    <div class="con">
     <form id="form1" name="form1" method="post" action="<?php echo U('import');?>" enctype="multipart/form-data">
    	<dl>
			<dt>批量导入文件：</dt>
			<dd><input type="file" name="data" id="fileField" class="text"></dd>
    	</dl>
       <div class="button"><input type="submit" name="button" id="button" value="提交" class="ibutton" /></div>
      </form>
    	
    </div>

根据扣量计算num数字，根据user_p的数据，在daydata表同时插入dnum，dnum1，dnum2值；
num根据导入数据插入所有，而dnum只插入产品应有的数据。

</div>

</div>
</body>
</html>