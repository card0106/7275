<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>7G传媒 你我同行,成就未来!</title>
<link type="text/css" href="/Public/css/base_1.css" rel="stylesheet" />
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
<script type="text/javascript" src="http://cdn.hcharts.cn/highcharts/exporting.js"></script>
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
	<div class="left fl">
    <div class="face"></div>
    <div class="nav0">
        <a href="<?php echo U('Index/index');?>" class="n1">基本信息</a>
        <a href="<?php echo U('Members/index');?>" class="n2">用户信息</a>
        <a href="<?php echo U('Goods/index');?>" class="n3">产品信息</a>
        <a href="<?php echo U('Invoicing/invoicing');?>" class="n4">结算列表</a>
        <a href="<?php echo U('Apply/index');?>" class="n3">申请列表</a>
        <a href="<?php echo U('Cash/cash');?>" class="n5">提现列表</a>
        <a href="<?php echo U('News/index');?>" class="n6">新闻公告</a>
        <a href="<?php echo U('Question/index');?>" class="n7">常见问题</a>
    </div>
</div>
</div>
<div class="right">
	<div class="mtit">
	<div class="blue f20 fl">渝网传媒</div>
	<div class="fr">
		<div class="userout fl"><a href="javascript:void(0)"><?php echo ($_SESSION["userinfo"]["username"]); ?></a></div>
		<div class="out fl"><a href="<?php echo U('Login/Index/logout');?>">退出</a></div>
	</div>
</div>
   <div class="tit f20">财务数据</div>
    	<div class="con">
        	<div class="data">
                <a>昨日利润<br /><span><?php echo ($yestDayProfits); ?></span></a>
        	<a>本周利润<br /><span><?php echo ($thisWeekProfits); ?></span></a>
        	<a>本月结算<br /><span><?php echo ($thisMonthProfits); ?></span></a>
        	<a>上月结算<br /><span><?php echo ($lastMonthProfits); ?></span></a>
        	<a href="<?php echo U('Members/index');?>">用户<br /><span><?php echo ($membersNum); ?></span></a>
        	<a href="<?php echo U('Product/index');?>">产品<br /><span><?php echo ($goodsNum); ?></span></a>
        	<a href="<?php echo U('index/make','type=index');?>"><span>生成<br>首页</span></a>
        	<a href="<?php echo U('index/make','type=news');?>"><span>生成新闻公告</span></a>
            </div>
        </div>
    
    <div class="tit f20">近15日收益走势</div>
    <div class="con">
    	<div class="data">
        <div id="container" style="min-width:700px;height:400px"></div>
        </div>
    </div>
</div>

</div>
<script>

$(function () {
    $('#container').highcharts({
        title: {
            text: '<?php echo ($charts["title"]); ?>',
            x: -20 //center
        },
        subtitle: {
            text: '<?php echo ($charts["subtitle"]); ?>',
            x: -20
        },
        xAxis: {
            categories: [<?php echo ($charts["categories"]); ?>]
        },
        yAxis: {
            title: {
                text: '收益'
            },
            plotLines: [{
                value: 0,
                width: 1,
                color: '#808080'
            }]
        },
        tooltip: {
            valueSuffix: ''
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle',
            borderWidth: 0
        },
        series: [{
            name: '<?php echo ($charts["series"]["name"]); ?>',
            data: [<?php echo ($charts["series"]["data"]); ?>]
        }]
    });
});
</script>
</body>
</html>