<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
    <head>
        <meta charset="utf-8">
        <title>渝网传媒 你我同行,成就未来!</title>
        <meta name="description" content="渝网传媒 你我同行,成就未来!" />
        <meta name="keywords" content="渝网传媒 你我同行 成就未来" />
        <link type="text/css" href="/Public/css/base.css" rel="stylesheet" />
        <link type="text/css" href="/Public/css/lrtk.css" rel="stylesheet" />
        <script type="text/javascript" src="/Public/js/jquery.min.js"></script>
        <script type="text/javascript" src="/Public/js/lrtk.js"></script>
        <script type="text/javascript" src="/Verify/Index/common"></script>
        <!--[if lte IE 6]>
            <script src="/Public/js/DD_belatedPNG_0.0.8a.js" type="text/javascript"></script>
            <script type="text/javascript">
                DD_belatedPNG.fix('div , a');
            </script>
            <![endif]--> 
    </head>
    <body>
        <div id="main">
            <div id="content">
                <!--header-->
                <div class="header">
                    <a href="#" class="logo fl"></a>
                    <div class="nav fr f16">
                        <a href="<?php echo U('/');?>" <?php if($menu == 'index'): ?>class="dr"<?php endif; ?> >首页</a>|
                        <a href="<?php echo U('/registe');?>" <?php if($menu == 'registe'): ?>class="dr"<?php endif; ?> >注册</a>|
                        <a href="<?php echo U('/news');?>" <?php if($menu == 'news'): ?>class="dr"<?php endif; ?> >新闻公告</a>|
                        <a href="<?php echo U('/question');?>" <?php if($menu == 'question'): ?>class="dr"<?php endif; ?> >常见问题</a>|
                        <a href="<?php echo U('/contact');?>" <?php if($menu == 'contact'): ?>class="dr"<?php endif; ?> >客服中心</a>
                    </div>
                </div>


<!--banner-->
<div class="banner" id="touchMain">
    <div id="slideContent">
        <div class="slide" id="bgstylea"></div>
        <div class="slide" id="bgstyleb"></div>
    </div>
    <div class="item">
        <a class="cur" stat="item1001" href="javascript:;"></a><a href="javascript:;" stat="item1002"></a>
    </div>


</div>

<!--wlogin-->
<div class="wlogin">
    <form id="form" name="form" method="post" action="<?php echo U('Home/Index/index');?>" onSubmit="return false;" class="fl">
        <div><input id="username" name="username" placeholder="用户名" autocomplete="off" type="text" value="" class="i1" /></div>
        <div><input id="password" name="password" placeholder="密码" autocomplete="off" type="password" value="" class="i2" /></div>
        <div class="key"><input id="checkcode" name="checkcode" placeholder="验证码" autocomplete="off" type="text" value="" class="i3 fl" /><img src="<?php echo U('Verify/Index/verify');?>" class="fr" onClick="this.src='<?php echo U('Verify/Index/verify');?>?randomString='+Math.random()"/></div>
        <div class="textright mtop15"><a href="<?php echo U('/registe');?>">立即注册</a>|<a href="<?php echo U('/forget');?>">忘记密码?</a></div>
        <div class="mtop15"><input type="submit" target-form="login-form" name="button" id="button" value="登录" class="f20 button cursor"></div>
    </form>
</div>

<!--main-->
<div class="main" style="padding-bottom:30px;">
    <div class="process">
        <div class="cursor"><div class="img img_1"></div><p class="f16">填写资料</p><p>填写个人信息及财务信息，以方便准确支付佣金。</p></div>
        <div class="cursor"><div class="img img_2"></div><p class="f16">审核通过</p><p>客服对网站进行审核，或联系客服审核，以更快通过。</p></div>
        <div class="cursor"><div class="img img_3"></div><p class="f16">投放代码</p><p>审核后，可在后台获取代码进行投放，获得更高的点击率。</p></div>
        <div class="cursor"><div class="img img_4"></div><p class="f16">赢取佣金</p><p>余额累计满一定金额即可申请支付，建议使用支付宝作收款账号。</p></div>
    </div>
</div>

<!--main-->
<div class="main bmain">
    <div class="left fl">
        <div class="tit">
            <div class="fl"><strong class="f16">新闻公告</strong><span>/</span>News</div>
            <div class="more fr"><a href="#">MORE</a></div>
        </div>
        <ul class="news">
            <?php if(is_array($rows)): $i = 0; $__LIST__ = $rows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><li><a target="_blank" href="<?php echo U('/news/'.$row['id']);?>"><?php echo ($row["title"]); ?></a><?php echo date("Y-m-d",$row["time"]);?></li><?php endforeach; endif; else: echo "" ;endif; ?>
        </ul>
    </div>
    <div class="right fr">
        <div class="tit"><strong class="f16">合作案例</strong><span>/</span>Cooperation Case</div>
        <div class=""><img src="/Public/images/123.gif" width="330" height="170" /></div>
    </div>
</div>

<div id="footer" class="footer">
    <p>
    	<a target="_blank" href="/about.html">关于我们</a>|
    	<a target="_blank" href="/business.html">商务合作</a>|
    	<a target="_blank" href="/copyright.html">版权声明</a>|
    	<a target="_blank" href="/service.html">服务条款</a>|
    	<a target="_blank" href="/freeStatement.html">免责声明</a>|
    	<a target="_blank" href="/privacy.html">隐私政策</a>|
    	<a target="_blank" href="/intellectual.html">知识产权声明</a>
    </p>
    <p>Copyright © 2013-2016 渝网联盟效果营销平台【赣ICP备15012890号】</p>
</div>

</div>
</div>
<script language="JavaScript" type="text/javascript">
    function $i(obj){
        return document.all ? document.all[obj] : document.getElementById(obj);
    }
$("#button").click(function(){
    var username = $("#username").val();
    var password = $("#password").val();
    if(username.length=='0'){
        alert('请输入你用户名');
        $("#username").focus()
            return false;
    }
    if(password.length=='0'){
        alert('请输入你的密码!');
        $("#password").focus()
            return false;
    }
    try{
        var checkcode = $("#checkcode").value;
        if(checkcode ==''){
            alert('验证码不能为空');
            $("#checkcode").focus()
                return false;
        }
    }catch(e){}  
    $.post(
            "<?php echo U('Home/Index/index');?>",
            $("#form").serialize(),
            function(data){
                if(data!==1){
                    alert(data);
                    $(".fr").attr("src","<?php echo U('Verify/Index/verify');?>");
                }else{
                    location.href="<?php echo U('/userinfo');?>";
                }
            }
          );
});
</script>
</body>
</html>