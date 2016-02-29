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
    	<a href="<?php echo U('/userinfo');?>" <?php if('detail' == 'info'): ?>class='dr'<?php endif; ?>>我的首页</a>
    	<a href="<?php echo U('/myad');?>" <?php if('detail' == 'ad'): ?>class='dr'<?php endif; ?>>我的广告</a>
    	<a href="<?php echo U('/getgoods');?>"<?php if('detail' == 'goods'): ?>class='dr'<?php endif; ?>>获取产品</a>
    	<a href="<?php echo U('/effect');?>"<?php if('detail' == 'effect'): ?>class='dr'<?php endif; ?>>效果报告</a>
    	<a href="<?php echo U('/detail');?>"<?php if('detail' == 'detail'): ?>class='dr'<?php endif; ?>>提现记录</a>
     </div>
     <div class="out fr"><a href="<?php echo U('/userinfo');?>"><?php echo ($_SESSION["membersinfo"]["username"]); ?></a><font>|</font><a href="<?php echo U('Home/Index/logout');?>">安全退出</a></div>
</div>

<?php if('detail' != 'info' && 'detail' != 'goods'): ?><div id="main">
<div id="content"><?php endif; ?>
<link type="text/css" href="/Public/css/tipswindown.css" rel="stylesheet" />
<link type="text/css" href="/Public/css/page.css" rel="stylesheet" />
<script type="text/javascript" src="/Public/js/jquery.tmpl.min.js"></script>
<script type="text/javascript" src="/Public/js/tipswindown.js"></script>

<link type="text/css" href="/Public/css/jquery-ui.css" rel="stylesheet" />
<script type="text/javascript" src="/Public/js/jquery-ui-datepicker.js"></script>

   	<form id="form1" name="form1" method="post" action="<?php echo U('/detail');?>" onsubmit="return jQuery.formValidator.PageIsValid('1')">
        <div class="bok" style="_margin-top:20px;">
       	  <div class="time fl">日期：</div>
          <div class="time fl"><input type="text" id="date_1" name="date_begin" value="<?php echo date('Y-m-d',$date_begin);?>" readonly /></div>
       	  <div class="time fl">至</div>
		  <div class="time fl"><input type="text" id="date_2" name="date_end" value="<?php echo date('Y-m-d',$date_end);?>" readonly /></div>
			<div class="time1 fl"><input type="submit" id="button" value="查询" class="but cursor" /></div>
        </div>
	</form>
    	<table width="100%" border="1" cellpadding="0" cellspacing="0">
            <thead>
            <tr>
                <th width="15%">提交申请时间</th>
                <th width="9%">金额</th>
                <th width="9%">状态</th>
            </tr>
            </thead>
            <tbody id="destination">
            <?php if(is_array($rows)): $i = 0; $__LIST__ = $rows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><tr>
                <td align="right"><?php echo date("Y-m-d H:i:s",$row["withdrawal_date"]);?></td>
                <td align="right">￥<span class="color1"><?php echo ($row["withdrawal_amount"]); ?></span></td>
                <td align="right">
                    <?php if($row['checked'] == 0): ?>未通过审核
                        <?php elseif($row['checked'] == 1): ?>已通过审核
                        <?php else: ?> 正在审核<?php endif; ?>
                </td>
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
<div id="footer">
    <p><a target="_blank" href="/news.html">新闻公告</a>|<a target="_blank" href="/question.html">常见问题</a>|<a target="_blank" href="/contact.html">客服中心</a></p>
    <p>Copyright ©2013-2014 Powered by 成都艾华网络科技有限公司 版权所有 蜀ICP备14005370号-1</p>
</div>
<!-----筛选出来的数据------>    
<!-----返回数据，需要插入------>
<script type="text/html" id="myTemplate">    
    <tr>
        <td>${withdrawal_date}</td>
        <td>${withdrawal_amount}</td>
        <td>${checked}</td>
    </tr>
</script> 
<!----通过日期查询出对应的会员提现记录---->
<script>
//当通过日期来查询出对应的 数据记录
$(".cursor").click(function(){
    var data_1=$("#date_1").val();
    var data_2=$("#date_2").val();
    if(data_1==""||data_2==""){
        alert("查询日期不能为空");
        return false;
    }    
    //发送ajax请求查询某一个会员的信息/或者具体某个时间段的数据,
    $.post(
        "<?php echo U('Finance/getItemsByDate');?>",
        {date1:data_1,date2:data_2},
        function(data){
            console.debug(data);
            //先清除以前的列表数据
            $("#destination").html("");
//            //根据取出来的 产品所对应的数据，替换以前的列表
            $('#myTemplate').tmpl(data).appendTo('#destination');            
        }
    );
});
</script> 
<script src="http://code.jquery.com/jquery-migrate-1.2.1.js"></script>
<script type="text/javascript">
 $(function(){
	$("#date_1").datepicker();
	$("#date_2").datepicker();
});
</script>
</body>
</html>