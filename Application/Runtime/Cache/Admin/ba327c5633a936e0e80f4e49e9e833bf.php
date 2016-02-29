<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>渝网传媒 你我同行,成就未来!</title>

<link rel="stylesheet" href="/Public/css/bootstrap.min.css" type="text/css">
<link type="text/css" href="/Public/css/base_1.css" rel="stylesheet" />
<link type="text/css" href="/Public/css/jquery-ui.css" rel="stylesheet" />
<link type="text/css" href="/Public/css/page.css" rel="stylesheet" />
<script type="text/javascript" src="/Public/js/bootstrap.min.js"></script>
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/jquery-ui-datepicker.js"></script>
<script type="text/javascript" src="/Public/js/jquery.tmpl.min.js"></script>

<!--引入其他的css文件--->

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
            <a href="<?php echo U('Product/index');?>" class="n3">产品信息</a>
            <a href="<?php echo U('Invoicing/invoicing');?>" class="dr4">结算列表</a>
            <a href="<?php echo U('Cash/cash');?>" class="n5">提现列表</a>
            <a href="<?php echo U('News/index');?>" class="n6">新闻公告</a>
            <a href="<?php echo U('Question/index');?>" class="n7">常见问题</a>
        </div>
    </div>
    
<!--左边导航部分-->
<!--右边内容部分-->

<div class="right">
    <div class="mtit">
        <div class="blue f20 fl">CMS联盟</div>
        <div class="fr">
                <div class="userout fl"><a href="javascript:void(0)"><?php echo ($_SESSION["userinfo"]["username"]); ?></a></div>
                <div class="out fl"><a href="<?php echo U('Login/Index/logout');?>">退出</a></div>
        </div>
    </div>
    <div class="tit f20">结算列表</div>
        <!---用于区分当前是查询 一个用户还是查询所有的数据----->
        <input type="hidden" id="flag" value="<?php echo ($member_id); ?>">
        <div class="bok" style="_margin-top:20px;">
          <div class="time fl">日期：</div>
          <div class="time fl"><input type="text" id="date_1" name="date_1" style='width: 100px'/></div>
          <div class="time fl">至</div>
                  <div class="time fl"><input type="text" id="date_2" name="date_2" style='width: 100px' /></div>
                        <div class="time1 fl"><input type="button" name="button" id="button" value="查询" class="but cursor" /></div>
        </div>
  
    <div class="con">
        <table border="0" cellpadding="0" cellspacing="0" class="productTable">
            <thead>
                <tr>
                    <th width="15%">用户</th>
                    <th width="15%">产品名</th>
                    <th width="15%">平台收入</th>
                    <th width="9%">平台支出</th>
                    <!--<th width="9%">扣量金额</th>-->
                    <th>推广数</th>
                    <th>扣量数</th>
                    <th>扣量率</th>
                    <th width="20%">时间</th>
                </tr>
            </thead>
            <tbody id="destination">
            <!----内容区域------->
            <?php if(is_array($rows)): $i = 0; $__LIST__ = $rows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($row["username"]); ?></td>
                    <td><?php echo ($row["goods_name"]); ?></td>
                    <td>￥<?php echo ($row["umoney"]); ?></td>
                    <td>￥<?php echo ($row["money"]); ?></td>
                    <!--<td>￥<?php echo ($row["discount_price"]); ?></td>-->
                    <td> <?php echo ($row["promote_num"]); ?></td>
                    <td> <?php echo round($row['promote_num']*$row['discount']/100);?></td>
                    <td> <?php echo ($row["discount"]); ?>%</td>
                    <td><?php echo date("Y-m-d H:i:s", $row['time']);?></td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </tbody>
        </table>
        <!--分页工具条 开始---->
        <div id="turn-page" class="page">
            <?php echo ($pageHTML); ?>
        </div> 
        <!--分页工具条 结束---->        
    </div>
</div>
<!-----返回数据，需要插入------>
<script type="text/html" id="myTemplate">    
    <tr>
        <td>${member_name}</td>
        <td>${goods_name}</td>
        <td>￥${union_price}</td>
        <td>￥${finnal_price}</td>
        <!--<td>￥${discount_price}</td>-->
        <td>当天点击量为: <strong>${promote_num}</strong>次</td>
        <td>${time}</td>
    </tr>
</script>
    
<!--右边内容部分-->
</div>
<!--JS自定义部分-->
   
<script>    
//当通过日期来查询出对应的 数据记录
$(".cursor").click(function(){
    var flag=$("#flag").val();
    var data_1=$("#date_1").val();
    var data_2=$("#date_2").val();
    if(data_1==""||data_2==""){
        alert("查询日期不能为空");
        return false;
    } 
    //发送ajax请求查询某一个会员的信息/或者具体某个时间段的数据,
    $.post(
        "<?php echo U('MembersProduct/getRowsByMemberId');?>",
        {member_id:flag,data1:data_1,data2:data_2},
        function(data){
            console.debug(data);
            //先清除以前的列表数据
            $("#destination").html("");
            //根据取出来的 产品所对应的数据，替换以前的列表
            $('#myTemplate').tmpl(data).appendTo('#destination');            
        }
    );
});    
</script>  
<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script>
     $(function(){         
            $("#date_1").datepicker();
            $("#date_2").datepicker();
    });
</script>

</body>
</html>