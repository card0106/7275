<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>渝网传媒 你我同行,成就未来!</title>

<link rel="stylesheet" href="/Public/css/bootstrap.min.css" type="text/css">
<link type="text/css" href="/Public/css/base_1.css" rel="stylesheet" />
<link type="text/css" href="/Public/css/jquery-ui.css" rel="stylesheet" />
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
            <a href="<?php echo U('Invoicing/invoicing');?>" class="n4">结算列表</a>
            <a href="<?php echo U('Cash/cash');?>" class="dr5">提现列表</a>
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
    <div class="tit f20">提现列表</div>
    <?php if($flag == 1): else: ?> 
        <form name="form1" method="post">
                <div class="bok" style="_margin-top:20px;">
                  <div class="time fl">日期：</div>
                  <div class="time fl"><input type="text" id="date_1" name="date_1" readonly></div>
                  <div class="time fl">至</div>
                  <div class="time fl"><input type="text" id="date_2" name="date_2" readonly/></div>
                        <div class="time1 fl"><input type="button" name="button" id="button" value="查询" class="but cursor" /> </div>
                </div>
        </form><?php endif; ?>
  
    <div class="con">
        <table border="0" cellpadding="0" cellspacing="0" class="productTable">
            <thead>
            <tr>
                <th width="15%">用户名</th>
                <th width="15%">提现时间</th>
                <th width="9%">金额</th>
                <th width="9%">审核状态</th>
                <th width="9%">操作</th>
            </tr>
            </thead>
            <tbody id="destination">
            <?php if(is_array($rows)): $i = 0; $__LIST__ = $rows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($row["member_name"]); ?></td>
                    <td><?php echo date("Y-m-d H:i:s",$row["withdrawal_date"]);?></td>
                    <td>￥<?php echo ($row["withdrawal_amount"]); ?></td>
                    <td>
                        <?php if($row['checked'] == 1): ?><a href="javascript:void(0)" class="sb3" flag="1">已通过审核</a> 
                            <?php elseif($row['checked'] == 0): ?><a href="javascript:void(0)" class="sb5" flag="1">未通过审核</a>
                            <?php else: ?> <a href="javascript:void(0)" class="sb3" onclick="check(this)" flag="1" value="<?php echo ($row["id"]); ?>" member='<?php echo ($row["member_id"]); ?>'>允许</a>
                                    <a href="javascript:void(0)" class="sb5" onclick="check(this)" flag="0" value="<?php echo ($row["id"]); ?>" member='<?php echo ($row["member_id"]); ?>'>禁止</a><?php endif; ?>
                    </td>
                    <td>
                        <a href="javascript:void(0)" value='<?php echo ($row["id"]); ?>' class="sb5" onclick=" return del(this)">删除</a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            </tbody>
        </table>
    </div>
</div>
<!-----返回数据，需要插入------>
<script type="text/html" id="myTemplate">    
    <tr>
        <td>${member_name}</td>
        <td>${formdate}</td>
        <td>${withdrawal_amount}</td>
        <td>
                <a href="javascript:void(0)" class="sb3" flag="1">${checked}</a>
<!--            <?php if(${checked} == 1): ?><a href="javascript:void(0)" class="sb3" flag="1">已通过审核</a> 
                <?php elseif(${checked} == -1): ?><a href="javascript:void(0)" class="sb5" flag="1">未通过审核</a>
                <?php else: ?> <a href="javascript:void(0)" class="sb3" onclick="check(this)" flag="1" value="${id}">允许</a>
                        <a href="javascript:void(0)" class="sb5" onclick="check(this)" flag="-1" value="${id}">禁止</a><?php endif; ?>-->
        </td>
        <td>
            <a href="javascript:void(0)" value='${id}' class="sb5" onclick=" return del(this)">删除</a>
        </td>
    </tr>
</script>    
    
<!--右边内容部分-->
</div>
<!--JS自定义部分-->

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
        "<?php echo U('Cash/getItemsByDate');?>",
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
<script>
    //删除一条 提现记录
    function del(demo){
        var id=$(demo).attr("value");
        if(window.confirm("你确定要删除该条提现记录吗?")){
            $.post(
                "<?php echo U('delById');?>",
                {id:id},
                function(data){
                    alert(data);
                    location.href="<?php echo U('cash');?>";
                }
            );
        }
    }
    //改变某一个会员“是否已经通过审核”
    function check(demo){
        var amount=$(demo).closest("td").prev().text();
            amount=amount.substr(1);
        var member_id=$(demo).attr("member");
        var flag=$(demo).attr("flag");
        var mes=(flag==1)?"你确定让该会员通过审核?":"你确定禁止该会员通过审核?";
        if(window.confirm(mes)){
          $.post(
                "<?php echo U('checkedById');?>",
                {id:member_id,checked:flag,amount:amount},
                function(data){
                    alert(data);
                    location.href="<?php echo U('cash');?>";
                }
            );  
        }        
    }
     $(function(){         
            $("#date_1").datepicker();
            $("#date_2").datepicker();
    });
</script>

</body>
</html>