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
            <a href="<?php echo U('Cash/cash');?>" class="n4">提现列表</a>
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
    <!---添加用户的区域------>
 <div class="con">
    	<form id="form1" method="post" action="" onsubmit="return jQuery.formValidator.PageIsValid('1')">
            <input type="hidden" name="goods_id" value="<?php echo ($id); ?>" id="goods_id">
        <dl>
            <dt>平台类型：</dt>
            <dd><?php echo ($category); ?></dd>
    	</dl>
    	<dl>
            <dt>产品名称：</dt>
            <dd><?php echo ($goods_name); ?></dd>
    	</dl>
    	<dl>
            <dt>用户名：</dt>
            <dd>
                <input type="hidden" name="members_id" id="members_id">
                <input name="username" type="text" class="text" id="username" /><span id="usernameTip"></span>
            </dd>
    	</dl>
    	<dl>
            <dt>扣率：</dt>
            <dd><input name="discount" type="text" class="text" id="kou" value="<?php echo ($discount); ?>" />%</dd>
    	</dl>
    	<dl>
            <dt>1号数据下游价：</dt>
            <dd><input name="dprice1" type="text" class="text" id="dnum" value="<?php echo ($down_price_1); ?>" /></dd>
    	</dl>
        <div class="button">
            <input type="submit" name="button" id="button" value="提交后并查看" class="ibutton" />
        </div>
    </form>
    </div>    
</div>
    
<!--右边内容部分-->
</div>
<!--JS自定义部分-->

<script language="JavaScript" type="text/javascript">	
$(".ibutton").click(function(){
    // 根据用户名查询是否有这个用户
    var members_name=$("#username").val();
    $.post(
        "<?php echo U('Members/getMembersId');?>",
        { name:members_name},
        function(data){
            if(data!==0){
                $("#members_id").val(data);
                $.ajax({
                    type: 'post',
                    url: '<?php echo U("addUser");?>',
                    data: $("#form1").serialize(),
                    success: function(data) {
                        if(data==1){   //已经保存成功
                            alert("成功为会员添加产品!");
                            location.href="<?php echo U('Product/index');?>";
                        }else if(data==-1){
                            alert("该会员已经拥有该产品!");
                        }else if(data==-2){
                            alert("该会员已经被禁用!");
                        }
                        else{
                            alert("添加会员产品失败!");
                        }
                    }
                });                
            }else{
                alert("不存在该会员！");
            }
        }
    );
    return false;
});
$(document).ready(function(){
	$.formValidator.initConfig({alertMessage:false});
	$("#username").formValidator({onshow:"请输入用户名,4-18位数字或字母组成",onfocus:"请输入用户名,4-18位数字或字母组成",oncorrect:"填写正确"}).InputValidator({min:4,max:18,onerror:"请输入一个4-18位的用户名"}).RegexValidator({regexp:"^[A-Za-z0-9]+$",onerror:"用户名由数字、26个英文字母组成"}).AjaxValidator({addidvalue:false,type:"POST",url:"/Admin/MembersProduct/checkMemberProduct.html",data:"goods_id="+$("#goods_id").val(),buttons:$("#button"),success:function(data){if(data==-1)return "用户名不存在！";if(data==1)return "该会员已经拥有该产品！";return data==0;},error: function(jqXHR,textStatus,errorThrown){alert("服务器没有返回数据，可能服务器忙，请重试"+errorThrown);},onwait:"正在检测用户是否拥有该产品，请稍候..."});
});
/*
// 输入会员的时候，要判断是否已经为该会员添加了当前产品
$("#una11me").blur(function(){
    var members_name=$("#uname").val();
    var goods_id=$("#goods_id").val();
    $.post(
        "<?php echo U('MembersProduct/checkMemberProduct');?>",
        {member_name:members_name,goods_id:goods_id},
        function(data){
            if(data!==0){
                alert("该会员已经拥有该产品");
                $("#uname").focus();
            }
        }
    );
   
});*/
</script>

</body>
</html>