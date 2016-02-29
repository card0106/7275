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
            <a href="<?php echo U('Cash/cash');?>" class="n5">提现列表</a>
            <a href="<?php echo U('News/index');?>" class="n6">新闻公告</a>
            <a href="<?php echo U('Question/index');?>" class="n7">常见问题</a>            
        </div>
    </div>
    
<!--左边导航部分-->
<!--右边内容部分-->

<style>
.text{ color:#7c7c7c; background:#ffffff; border-radius:15px; border:1px solid #e6eff8; padding:0 10px;}
.user{display:inline-block;width:13px;height:15px;background:url(/Public/images/ico2.png) no-repeat center;background-position:-18px 3px;}
.product{display:inline-block;width:13px;height:15px;background:url(/Public/images/ico3.png) no-repeat center;background-position:-18px 3px;}
</style>
<div class="right">
    <div class="mtit">
        <div class="blue f20 fl">CMS联盟</div>
        <div class="fr">
                <div class="userout fl"><a href="#"><?php echo ($_SESSION["userinfo"]["username"]); ?></a></div>
                <div class="out fl"><a href="<?php echo U('Login/Index/logout');?>">退出</a></div>
        </div>
    </div>
<!---列表主体部分---->
    <div class="tit f20">已经审核<?php echo count($rows);?>个产品</div>
    <div class="con">
    	<table border="0" cellpadding="0" cellspacing="0" class="productTable">
            <thead>
                <tr>
                	<th width="11%" colspan=2>用户名</th>
                    <th width="15%">产品名称</th>
                    <th width="10%">结算周期</th>
                    <th width="10%">扣率</th>
                    <th width="10%">1号数据下游价</th>
                    <th width="10%">2号数据下游价</th>
                    <th width="10%">3号数据下游价</th>
                    <th width="15%">操作</th>
                </tr>
            </thead>
            <tbody>
                <?php if(is_array($rows)): $i = 0; $__LIST__ = $rows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><tr>
                    <td style="text-align: right;"><?php echo ($row["username"]); ?></td><td style="text-align: left;"><a class="user" href="<?php echo U('Members/index','member_id='.$row['members_id']);?>"></a>&nbsp;<a class="product" href="<?php echo U('MembersProduct/getItems','member_id='.$row['members_id']);?>"></a></td>
                    <td><?php echo ($row["goods_name"]); ?></td>	
                    <td>
                        <?php if($row['invoicing_cycle'] == 0): ?>每日
                            <?php elseif($row['invoicing_cycle'] == 1): ?>每周
                            <?php elseif($row['invoicing_cycle'] == 2): ?>双周
                            <?php elseif($row['invoicing_cycle'] == 3): ?>每月<?php endif; ?>
                    <td><input name="discount" type="text" class="text" id="discount_<?php echo ($row["id"]); ?>" orgval="<?php echo ($row["discount"]); ?>" userid="<?php echo ($row["id"]); ?>" value="<?php echo ($row["discount"]); ?>"/>%</td>
                    <td><input name="dprice1" type="text" class="text" id="dprice1_<?php echo ($row["id"]); ?>" orgval="<?php echo ($row["dprice1"]); ?>" userid="<?php echo ($row["id"]); ?>" value="<?php echo ($row["dprice1"]); ?>"/></td>
                    <td><input name="dprice2" type="text" class="text" id="dprice2_<?php echo ($row["id"]); ?>" orgval="<?php echo ($row["dprice2"]); ?>" userid="<?php echo ($row["id"]); ?>" value="<?php echo ($row["dprice2"]); ?>"/></td>
                    <td><input name="dprice3" type="text" class="text" id="dprice3_<?php echo ($row["id"]); ?>" orgval="<?php echo ($row["dprice3"]); ?>" userid="<?php echo ($row["id"]); ?>" value="<?php echo ($row["dprice3"]); ?>"/></td>
                    <td><!--<a href="javascript:void(0);" class="sb5" onclick="" value="<?php echo ($row["id"]); ?>">删除</a>--></td>
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
    
<!--右边内容部分-->
</div>
<!--JS自定义部分-->

<script>
$(document).ready(function(){
	$.formValidator.initConfig({alertMessage:false});
	$("input[name='discount']").formValidator().FunctionValidator({fun:control});
	$("input[name='dprice1']").formValidator().FunctionValidator({fun:control});
	$("input[name='dprice2']").formValidator().FunctionValidator({fun:control});
	$("input[name='dprice3']").formValidator().FunctionValidator({fun:control});

	//.RegexValidator({regexp:"^[0-9]{1,2}+$",onerror:"用户名由数字、26个英文字母组成"});
	//.AjaxValidator({addidvalue:false,type:"POST",url:"/Admin/MembersProduct/checkMemberProduct.html",data:"goods_id="+$("#goods_id").val(),buttons:$("#button"),success:function(data){if(data==-1)return "用户名不存在！";if(data==1)return "该会员已经拥有该产品！";return data==0;},error: function(jqXHR,textStatus,errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},onwait:"正在检测用户是否拥有该产品，请稍候..."});
});
function control(val,ele)
{
	var orgval = $(ele).attr('orgval');
	var name = $(ele).attr('name');
	var szTip='',type=0;
	if(name == 'discount'){
		type=1;
		szTip = "你确定要将[扣率]:["+orgval+"%]修改为["+val+"%]吗？";
	}else if(name == 'dprice1'){
		type=2;
		szTip = "你确定要将[1号数据下游价]:["+orgval+"%]修改为["+val+"]吗？";
	}else if(name == 'dprice2'){
		type=3;
		szTip = "你确定要将[2号数据下游价]:["+orgval+"%]修改为["+val+"]吗？";
	}else if(name == 'dprice3'){
		type=4;
		szTip = "你确定要将[3号数据下游价]:["+orgval+"%]修改为["+val+"]吗？";
	}else 
		return false;
	if(type == 0 || orgval == val || !confirm(szTip))
		return false;
	var id=$(ele).attr('userid');
    $.post(
        "<?php echo U('MembersProduct/control');?>",
        {id:id,type:type,val:val},
        function(data){
        	var mes='';
        	if(data==1)
        	{
        		mes = '操作成功！';
				$(ele).attr('orgval', val);
        	}else
        	{
        		mes='操作失败！';
				$(ele).val($(ele).attr('orgval'));
        	}
            alert(mes);
        }
    );
    return true;
}
</script>

</body>
</html>