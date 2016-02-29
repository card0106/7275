<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>7G传媒 你我同行,成就未来!</title>

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
    <!----顶部有关用户及退出----->
    <div class="mtit">
        <div class="blue f20 fl">CMS联盟</div>
        <div class="fr">
                <div class="userout fl"><a href="javascript:void(0)"><?php echo ($_SESSION["userinfo"]["username"]); ?></a></div>
                <div class="out fl"><a href="<?php echo U('Login/Index/logout');?>">退出</a></div>
        </div>
    </div>
    <!-----编辑产品区域------->
<div class="con">
    <form id="form1" name="form1" method="post" action="<?php echo U('updateGoods');?>" enctype="multipart/form-data" onsubmit="return jQuery.formValidator.PageIsValid('1')">
    	<input type="hidden" name="id" value="<?php echo ($row["id"]); ?>">
        <dl>
            <dt>平台类型：</dt>
            <dd>
                <select name="category_id" id="pselect" class="text1 fl">
                        <option value="0">请选择平台类型</option>
                        <?php if(is_array($cats)): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cat["id"]); ?>"><?php echo ($cat["category_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                </select>
                <span id="pselectTip"></span>
            </dd>
    	</dl>
        <dl>
            <dt>结算类型：</dt>
            <dd>
                <select name="cash_type" id="cselect" class="text1 fl">
                        <option>请选择结算类型</option>
                        <option value="0">金额</option>
                        <option value="1">比例</option>
                </select>
                <span id="cselectTip"></span>
            </dd>
    	</dl>
    	<dl>
            <dt>产品logo：</dt>
            <dd>
                <input type="file" name="logo" id="logo" class="text" />(<a href="<?php echo ($row["goods_big_img"]); ?>" target="_blank">查看原图</a>)
            </dd>
    	</dl>
    	<dl>
            <dt>产品名称：</dt>
            <dd>
                <input name="goods_name" type="text" class="text" id="pname" value="<?php echo ($row["goods_name"]); ?>" /><span id="pnameTip"></span>
            </dd>
    	</dl>
    	<dl>
            <dt>扣量率：</dt>
            <dd><input name="discount" type="text" class="text" id="amount" value="<?php echo ($row["discount"]); ?>" />%</dd>
    	</dl>
    	<dl>
            <dt>1号数据上游价格：</dt>
            <dd><input name="up_price_1" type="text" class="text" id="goup" value="<?php echo ($row["up_price_1"]); ?>" /><span id="goupTip"></span></dd>
    	</dl>
    	<dl>
            <dt>1号数据下游价格：</dt>
            <dd><input name="down_price_1" type="text" class="text" id="godown" value="<?php echo ($row["down_price_1"]); ?>" /><span id="godownTip"></span></dd>
    	</dl>
    	<dl>
            <dt>2号数据上游价格：</dt>
            <dd><input name="up_price_2" type="text" class="text" id="goup" value="<?php echo ($row["up_price_2"]); ?>" /><span id="goupTip"></span></dd>
    	</dl>
    	<dl>
            <dt>2号数据下游价格：</dt>
            <dd><input name="down_price_2" type="text" class="text" id="godown" value="<?php echo ($row["down_price_2"]); ?>" /><span id="godownTip"></span></dd>
    	</dl>
    	<dl>
            <dt>3号数据上游价格：</dt>
            <dd><input name="up_price_3" type="text" class="text" id="goup" value="<?php echo ($row["up_price_3"]); ?>" /><span id="goupTip"></span></dd>
    	</dl>
    	<dl>
            <dt>3号数据下游价格：</dt>
            <dd><input name="down_price_3" type="text" class="text" id="godown" value="<?php echo ($row["down_price_3"]); ?>" /><span id="godownTip"></span></dd>
    	</dl>
        <dl>
            <dt>结算周期：</dt>
            <dd>
            <div class="fl" style="padding-top:14px; padding-left:20px; padding-right:5px;">
                <label class="radio-inline">
                    <input type="radio" name="invoicing_cycle" value="0" class="optionsRadios1" <?php if($row["invoicing_cycle"] == 0): ?>checked<?php endif; ?>>每日
                </label>
                <label class="radio-inline">
                  <input type="radio" name="invoicing_cycle" value="1"class="optionsRadios1" <?php if($row["invoicing_cycle"] == 1): ?>checked<?php endif; ?>>每周
                </label> 
                <label class="radio-inline">
                  <input type="radio" name="invoicing_cycle" value="2" class="optionsRadios1" <?php if($row["invoicing_cycle"] == 2): ?>checked<?php endif; ?>>双周
                </label>
                <label class="radio-inline">
                  <input type="radio" name="invoicing_cycle" value="3" class="optionsRadios1" <?php if($row["invoicing_cycle"] == 3): ?>checked<?php endif; ?>>每月
                </label>
            </div>
                <div class="fl"></div>
            </dd>
    	</dl>
         <dl>
            <dt>产品状态：</dt>
            <dd>
            <div class="fl" style="padding-top:14px; padding-left:20px; padding-right:5px;">
                <label class="radio-inline">
                    <input type="radio" name="state" class="optionsRadios2" value="1" <?php if($row["state"] == 1): ?>checked<?php endif; ?>>正常
                </label>
                <label class="radio-inline">
                  <input type="radio" name="state" class="optionsRadios2" value="0" <?php if($row["state"] == 0): ?>checked<?php endif; ?>>关闭
                </label>                
            </div>
            </dd>
    	</dl>
        <dl>
            <dt>数据返回：</dt>
            <dd>
            <div class="fl" style="padding-top:14px; padding-left:20px; padding-right:5px;">
                <label class="radio-inline">
                    <input type="radio" name="data_back" class="optionsRadios3"  value="0" <?php if($row["data_back"] == 0): ?>checked<?php endif; ?>>次日
                </label>
                <label class="radio-inline">
                  <input type="radio" name="data_back" class="optionsRadios3"   value="1" <?php if($row["data_back"] == 1): ?>checked<?php endif; ?>>实时
                </label>
                <label class="radio-inline">
                  <input type="radio" name="data_back" class="optionsRadios3" value="2" <?php if($row["data_back"] == 2): ?>checked<?php endif; ?>>每周
                </label>                
            </div>
            <div class="fl"></div>
            </dd>
    	</dl>
        <dl>
            <dt>产品说明：</dt>
            <dd><textarea name="intro" rows="5" class="text2" id="introduction" ><?php echo ($row["intro"]); ?></textarea><span id="introductionTip"></span></dd>
    	</dl><!---
        <dl>
            <dt>规则与数据返回：</dt>
            <dd><textarea name="data_back" rows="5" class="text2" id="sjfh" ><?php echo ($row["data_back"]); ?></textarea><span id="sjfhTip"></span></dd>
    	</dl>--->
        <div class="button"><input type="submit" name="button" id="button" value="提交" class="ibutton" /></div>
    </form>
    </div>    
</div>
    
<!--右边内容部分-->
</div>
<!--JS自定义部分-->

<script language="JavaScript" type="text/javascript">
//回选单选框等的函数
$(function(){
    //选中 平台类型
    $("#pselect").val(["<?php echo ($row["category_id"]); ?>"]);
    $("#cselect").val(["<?php echo ($row["cash_type"]); ?>"]);
    //选中 结算周期
    $(".optionsRadios1").val(["<?php echo ($row["invoicing_cycle"]); ?>"]);
    //选中 产品状态
    $(".optionsRadios2").val(["<?php echo ($row["state"]); ?>"]);
    //数据返回
    $(".optionsRadios3").val(["<?php echo ($row["data_back"]); ?>"]);
});
$(document).ready(function(){
	$.formValidator.initConfig({alertMessage:false});
	$("#pselect").formValidator({onshow:"请选择平台类型",onfocus:"请选择平台类型",oncorrect:"填写正确"}).InputValidator({onerror:"请选择平台类型"}).RegexValidator({regexp:"^.*$",onerror:""});
	$("#cselect").formValidator({onshow:"请选择结算类型",onfocus:"请选择结算类型",oncorrect:"填写正确"}).InputValidator({onerror:"请选择结算类型"}).RegexValidator({regexp:"^.*$",onerror:""});
	$("#logo").formValidator({onshow:"产品logo必须是gif|jpg|png图片格式",onfocus:"产品logo必须是gif|jpg|png图片格式",oncorrect:"填写正确"}).InputValidator({min:2,onerror:"产品logo必须是gif|jpg|png图片格式"}).RegexValidator({regexp:"^.*gif|jpg|png$",onerror:"gif|jpg|png图片格式"});
	$("#pname").formValidator({onshow:"请输入产品名称",onfocus:"请输入产品名称",oncorrect:"填写正确"}).InputValidator({min:1,onerror:"请输入一个产品名称"}).RegexValidator({regexp:"^.*$",onerror:"请输入产品名称"});
	$("#amount").formValidator({onshow:"请输入扣量率",onfocus:"请输入扣量率",oncorrect:"填写正确"}).InputValidator({min:1,onerror:"请输入扣量率"}).RegexValidator({regexp:"^\d+(\.\d+)?$",onerror:"扣量率由于数字组成"});
	$("#goup").formValidator({onshow:"请输入上游价格",onfocus:"请输入上游价格",oncorrect:"填写正确"}).InputValidator({min:1,onerror:"请输入上游价格"}).RegexValidator({regexp:"^\d+(\.\d+)?$",onerror:"上游价格由于数字组成"});
	$("#godown").formValidator({onshow:"请输入下游价格",onfocus:"请输入下游价格",oncorrect:"填写正确"}).InputValidator({min:1,onerror:"请输入下游价格"}).RegexValidator({regexp:"^\d+(\.\d+)?$",onerror:" 下游价格由于数字组成"});
	$("#introduction").formValidator({onshow:"产品说明",onfocus:"产品说明",oncorrect:"填写正确"}).InputValidator({min:2,onerror:"产品说明"}).RegexValidator({regexp:"^.*$",onerror:"产品说明"});
	$("#sjfh").formValidator({onshow:"规则与数据返回",onfocus:"规则与数据返回",oncorrect:"填写正确"}).InputValidator({min:2,onerror:"规则与数据返回"}).RegexValidator({regexp:"^.*$",onerror:"规则与数据返回"});
});	
</script>    

</body>
</html>