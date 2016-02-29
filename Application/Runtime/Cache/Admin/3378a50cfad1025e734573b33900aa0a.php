<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>渝网传媒 你我同行,成就未来!</title>

<link rel="stylesheet" href="/Public/css/bootstrap.min.css" type="text/css">
<link type="text/css" href="/Public/css/base_1.css" rel="stylesheet" />
<!---引入分页样式------->
<link type="text/css" href="/Public/css/page.css" rel="stylesheet" />
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/jquery.tmpl.min.js"></script>
<script type="text/javascript" src="/Public/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/Public/js/formValidator_min.js"></script>

<!--引入其他的css文件--->

    <link type="text/css" href="/Public/css/jquery-ui.css" rel="stylesheet" />
      <script type="text/javascript" src="http://cdn.hcharts.cn/highcharts/highcharts.js"></script>
  <script type="text/javascript" src="http://cdn.hcharts.cn/highcharts/exporting.js"></script>

    <!--<script type="text/javascript" src="/Public/js/angular.min.js"></script>-->

<!--[if lte IE 6]>
<script src="script/DD_belatedPNG_0.0.8a.js" type="text/javascript"></script>
    <script type="text/javascript">
    DD_belatedPNG.fix('div , a');
</script>
<![endif]--> 
</head>
<body>
<div id="main">
<!--左边导航部分-->

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
    
<!--左边导航部分-->
<!--右边内容部分-->

<div class="right">
<!----顶部有关用户及退出----->
<div ng-controller="data">
    <div class="mtit">
        <div class="blue f20 fl">CMS联盟</div>
        <div class="fr">
                <div class="userout fl"><a href="javascript:void(0)"><?php echo ($_SESSION["userinfo"]["username"]); ?></a></div>
                <div class="out fl"><a href="<?php echo U('Login/Index/logout');?>">退出</a></div>
        </div>
    </div>
<!---查询某个日期段对应的产品数据--->
<!--    <form name="form1" method="post">
            <input type="hidden" name="id" value="<%=id%>">
            <div class="bok" style="_margin-top:20px;">
                <strong>日期：</strong>
                <input type="text" class="form-control" ng-model="search" placeholder="请输入日期2015-05-12" style="width: 300px">
            <div class="time fl">日期：</div>
            <div class="time fl"><input type="text" id="date_1" name="date_1" readonly/></div>
            <div class="time fl">至</div>
            <div class="time fl"><input type="text" id="date_2" name="date_2" readonly /></div>
                    <div class="time1 fl"><input type="submit" name="button" id="button" value="查询" class="but cursor" /></div>
            </div>
    </form> -->
<!----产品数据列表----->
<div class="tit f20"><a class="f12">查看收益走势</a><a href="<?php echo U('top','goods_id='.I('get.goods_id'));?>" class="f12">查看明星渠道</a><a href="<?php echo U('goodsData','goods_id='.I('get.goods_id'));?>" class="f12">查看详细报表</a></div>
    <div class="con">
        <!---统计收入栏---->
    	<div class="tuiguang f12">
            <ul id="screen">
            	<li><p>总利润</p><p><span>￥<?php echo ($total["price"]); ?></span></p></li>
            	<li><p>总收益</p><p><span>￥<?php echo ($total["umoney"]); ?></span></p></li>
            	<li><p>总支出</p><p><span>￥<?php echo ($total["money"]); ?></span></p></li>
            	<li><p>平均利润率</p><p><span><?php echo ($total["money_percent"]); ?>%</span></p></li>
            	<li><p>总注册数</p><p><span><?php echo ($total["real_num"]); ?> 次</span></p></li>
            	<li><p>总激活数</p><p><span><?php echo ($total["promote_num"]); ?> 次</span></p></li>
            	<li><p>每激活收益</p><p><span>￥<?php echo ($total["real_money"]); ?></span></p></li>
            	<li><p>平均激活率</p><p><span><?php echo ($total["real_percent"]); ?>%</span></p></li>
            </ul>
        </div>
        <!--产品推广数据列表-->
    	<!--<table border="0" cellpadding="0" cellspacing="0" class="productTable"></table>-->
        <div id="container" style="min-width:700px;height:400px"></div>
    </div>
</div>
</div>
    
<!--右边内容部分-->
</div>
<!--JS自定义部分-->

<!----angualrJS代码块------->
<script>
//var myapp=angular.module("app",[]);    
//myapp.controller("data",["$scope",function($scope){
//    $scope.datas=<?php echo ($rows); ?>;
//    console.debug($scope.datas);
//}]);
</script>
<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
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
     $(function(){
            $("#date_1").datepicker();
            $("#date_2").datepicker();
    });
    //点击查询的时候需要执行的业务逻辑
    $("#button").click(function(){
        var date_1=$("#date_1").val();
        var date_2=$("#date_2").val();
//        var member_name=$("#name").val();
        var member_name=$("#uname").val();
        if(date_1=="" || date_2==""){
            alert("日期不能为空");
            return;
        }
        $.post(
            "<?php echo U('Product/goodsData');?>",
            {date1:date_1,date2:date_2,member:member_name},
            function(data){
                $("#filter").html("");
                $("#screen").html("");
                $("#mytpl").tmpl(data[0]).appendTo("#filter");
                $("#screenTpl").tmpl(data[1]).appendTo("#screen");
            }
        );
    });
</script>

</body>
</html>