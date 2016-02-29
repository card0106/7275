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
    <script type="text/javascript" src="/Public/js/jquery-ui-datepicker.js"></script>
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
    <div class="tit f20"><a href="<?php echo U('charts','goods_id='.I('get.goods_id'));?>" class="f12">查看收益走势</a><a href="<?php echo U('top','goods_id='.I('get.goods_id'));?>" class="f12">查看明星渠道</a><a class="f12">查看详细报表</a></div>
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
        <table border="0" cellpadding="0" cellspacing="0" class="productTable" style="height: 0!important;"></table>
    </div>
    <div class="tit f20">查看数据</div>
	<!--<div class="tit f20">查看数据</div>-->
    
    <div class="bok" style="_margin-top:20px;">
      <div class="time fl" style="padding-left:30px;">会员：</div>
          <div class="time fl"><input type="text" id="uname" /></div>
       	  <div class="time fl">日期：</div>
          <div class="time fl"><input type="text" id="date_1" readonly /></div>
       	  <div class="time fl">至</div>
		  <div class="time fl"><input type="text" id="date_2" readonly  /></div>
        <div class="time1 fl"><input type="button" name="button" id="button" value="查询" class="but cursor" /></div>
    </div>
        <div class="con">
        <!--产品推广数据列表-->
    	<table border="0" cellpadding="0" cellspacing="0" class="productTable">
            <thead>
            <tr>
                <th width="8%">产品名</th>
                <th width="8%">会员</th>
                <th width="8%">子渠道</th>
                <th width="8%">注册数</th>
                <th width="8%">激活数</th>
                <th width="3%">激活率</th>
                <th width="5%">每激活收益</th>
                <th width="10%">平台收入</th>
                <th width="10%">渠道支出</th>
                <th width="10%">利润</th>
                <th width="3%">利润率</th>
                <th width="10%">时间</th>
                <th width="10%">备注</th>
            </tr>
            </thead>
            <tbody id="filter">
                <?php if(is_array($rows)): $i = 0; $__LIST__ = $rows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><tr>
                        <td><?php echo ($row["goods_name"]); ?></td>
                        <td><?php echo ($row["username"]); ?></td>
                        <td><?php echo ($row["flags"]); ?></td>
                        <td><?php echo ($row["real_num"]); ?></td>
                        <td><?php echo ($row["promote_num"]); ?></td>
                        <td style="background-color: <?php if($row['percent'] < $total['real_percent']): ?>yellow<?php elseif($row['percent'] > $total['real_percent']): ?>pink<?php else: ?>inherit<?php endif; ?>"><?php echo ($row["percent"]); ?>%</td>
                        <td>￥<?php echo round($row['umoney']/$row['promote_num'],2);?></td>
                        <td>￥<?php echo ($row["umoney"]); ?></td>
                        <td>￥<?php echo ($row["money"]); ?></td>
                        <td>￥<?php echo ($row["union_price"]); ?></td>
                        <td style="background-color: <?php if($row['money_percent'] < $total['money_percent']): ?>yellow<?php elseif($row['money_percent'] > $total['money_percent']): ?>pink<?php else: ?>inherit<?php endif; ?>"><?php echo ($row["money_percent"]); ?>%</td>
                        <td><?php echo date("Y-m-d H:i:s",$row['time']);?></td>
                        <td><?php echo ($row["comments"]); ?></td>
                    </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
<!-----筛选后的数据返回------>
<script type="text/html" id="mytpl">
    <tr>
        <td>${goods_name}</td>
        <td>${member_name}</td>
        <td>${promote_num}次</td>
        <td>￥${union_price}</td>
        <td>￥${finnal_price}</td>
        <td>${time}</td>
    </tr>    
</script>            
<!--            <tr ng-repeat="data in datas | filter:{time:search}">
                <td>{{data.goods_name}}</td>
                <td>{{data.member_name}}</td>
                <td>{{data.promote_num}}</td>
                <td>{{data.time}}</td>
            </tr>-->
        </table>
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