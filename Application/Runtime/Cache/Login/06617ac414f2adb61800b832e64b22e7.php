<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>7G传媒</title>
<meta name="description" content="7G传媒" />
<meta name="keywords" content="7G传媒介绍" />
<script type="text/javascript" src="/Public/js/jquery.js"></script>
<script type="text/javascript" src="/Public/js/jquery.reg.js"></script>
<script type="text/javascript" src="/Public/js/formValidator_min.js"></script>
<style>
* { margin:0; padding:0; }
.fl { float:left; }
.fr { float:right; }
body , input { font:12px/2.0 "\5FAE\8F6F\96C5\9ED1",Arial,"\5B8B\4F53"; color:#313131; }
.reg { width:377px; height:529px; position:absolute;left:50%;top:40%;margin-left:-180px;margin-top:-220px;z-index:0;display:block; }
.tit { text-align:center; padding-bottom:5px; }
.con { background:url(/Public/images/regbg.gif); width:307px; height:329px; padding:40px 35px; }
.con p { padding:5px 0 0 0; float:left; width:307px; }
.con p strong { font-size:14px; }
input { outline:none; resize:none; background:#f9f9f9; border:1px solid #ececec; line-height:43px; height:43px; padding:0 10px; }
.input0 { width:287px; }
.input1 { width:160px; }
.button { width:307px; cursor:pointer; border:1px solid #ad0000; background:#ad0000; font-size:16px; color:#ffffff; margin-top:15px; }
</style>
</head>
<body>
<div class="reg">
	<div class="tit"><img src="/Public/images/logo.gif" width="309" height="67" /></div>
    <div class="con">
        <form id="form1" name="form1" method="post" action="<?php echo U('Index/index');?>" onsubmit="return false;">
        <p><strong>用户名</strong></p>
        <p><input id="uname" name="username" type="text" class="input0" ><span id="unameTip"></span></p>
        <p class="mtop10"><strong>密码</strong></p>
        <p><input id="password" name="password" type="password" class="input0" ><span id="passwordTip"></span></p>
		<p><strong>验证码</strong></p>
        <p><input id="checkcode" name="checkcode" type="text" class="input1 fl"><img src="<?php echo U('Verify/Index/verify');?>" class="fr" height="43px" alt="验证码,看不清楚?请点击刷新验证码" style="cursor : pointer;" onClick="this.src='<?php echo U('Verify/Index/verify');?>?randomString='+Math.random()"/></p>
        <p>
          <input type="submit" name="button" id="button" value="登陆" class="button">
        </p>
        </form>
    </div>
</div>
<script>
$(document).ready(function(){
        $.formValidator.initConfig({alertMessage:false});
        $("#uname").formValidator({onshow:"",onfocus:"请输入4-16位字符用户名",oncorrect:""}).InputValidator({min:4,max:18,onerror:"请输入4-16位字符用户名"}).RegexValidator({regexp:"^[A-Za-z0-9]+$",onerror:"请输入4-16位字符用户名"});
        $("#password").formValidator({onshow:"",onfocus:"请输入6-16位密码",oncorrect:""}).InputValidator({min:6,max:16,onerror:"请输入6-16位密码"});
});
$("#button").click(function(){
        var username = $("#uname").val();
        var password = $("#password").val();
        if(username.length=='0'){
            alert('请输入你用户名');
            $("#uname").focus()
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
            "<?php echo U('Index/index');?>",
            $("#form1").serialize(),
            function(data){
                console.debug(data);
                if(data!==1){
                    alert(data);
                    $(".fr").attr("src","<?php echo U('Verify/Index/verify');?>");
                }else{
                    location.href="<?php echo U('Admin/Index/index');?>";
                }
            }
        );    
});
</script>
</body>
</html>