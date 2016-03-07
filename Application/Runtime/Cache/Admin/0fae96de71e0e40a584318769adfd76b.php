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
        <a href="<?php echo U('Goods/index');?>" class="n3">产品信息</a>
        <a href="<?php echo U('Invoicing/invoicing');?>" class="n4">结算列表</a>
        <a href="<?php echo U('Apply/index');?>" class="n3">申请列表</a>
        <a href="<?php echo U('Cash/cash');?>" class="n5">提现列表</a>
        <a href="<?php echo U('News/index');?>" class="n6">新闻公告</a>
        <a href="<?php echo U('Question/index');?>" class="n7">常见问题</a>
    </div>
</div>
    
<!--左边导航部分-->
<!--右边内容部分-->

<div class="right">
    <div class="mtit">
	<div class="blue f20 fl">渝网传媒</div>
	<div class="fr">
		<div class="userout fl"><a href="javascript:void(0)"><?php echo ($_SESSION["userinfo"]["username"]); ?></a></div>
		<div class="out fl"><a href="<?php echo U('Login/Index/logout');?>">退出</a></div>
	</div>
</div>
    <div class="tit f20">用户信息</div>
    <div class="con">
    	<table border="0" cellpadding="0" cellspacing="0" class="productTable">
            <tr class="f14">
                <th width="8%">用户ID</th>
                <th width="11%">用户名</th>
                <th width="18%">已经审核产品数</th>
                <th width="13%">未审核产品数</th>
                <th width="14%">加入联盟时间</th>
                <th width="12%">状态</th>
                <th width="24%">操作</th>
            </tr>
            <!----循环取出会员信息 开始----->
            <?php if(is_array($rows)): $i = 0; $__LIST__ = $rows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><tr>
                    <td><span><?php echo ($row["id"]); ?></span></td>
                    <td><?php echo ($row["username"]); ?></td>
                    <td><?php if($row['num'] == 0): ?>0<?php else: ?><a class="sb6" href="<?php echo U('MembersProduct/getItems','member_id='.$row['id']);?>"><?php echo ($row["num"]); ?></a><?php endif; ?></td>
                    <td>无此数据</td>
                    <td><?php echo date("Y-m-d H:i:s",$row["enter_time"]);?></td>
                    <td>
                        <?php if($row['state'] == 0): ?><a href="javascript:void(0)" class="sb6" flag="1" onclick="changeState(this)" value="<?php echo ($row["id"]); ?>">禁用</a>    
                            <?php else: ?> <a href="javascript:void(0)" class="sb3" onclick="changeState(this)" flag="0" value="<?php echo ($row["id"]); ?>">正常</a><?php endif; ?>
                    </td>
                    <td>
                        <a href="<?php echo U('Invoicing/invoicing',array('member_id'=>$row['id']));?>" class="sb4">结算记录</a>
                        <a href="<?php echo U('Cash/record',array('member_id'=>$row['id']));?>" class="sb4">提现记录</a>
                        <a href="#" class="sb4" data-target="#myModal" data-toggle="modal" value="<?php echo ($row['id']); ?>" onclick="edit(this)">修改</a>
                        <a href="<?php echo U('Admin/Members/del');?>" value='<?php echo ($row["id"]); ?>' class="sb5" onclick=" return del(this)">删除</a>
                    </td>
                </tr><?php endforeach; endif; else: echo "" ;endif; ?>
            <!----循环取出会员信息 结束----->
        </table>
        
        <!--分页工具条 开始---->
        <div id="turn-page" class="page">
            <?php echo ($pageHTML); ?>
        </div> 
        <!--分页工具条 结束---->
    </div>
</div>
<!--修改用户的模态框-->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">增加产品</h4>
              </div>
              <div class="modal-body" id="destination">
            <!---编辑产品的表单 开始------>
               
            <!---编辑产品的表单 结束------>
              </div>
        </div>
    </div>
</div>
<!--action="<?php echo U('test');?>" onSubmit="return jQuery.formValidator.PageIsValid('1')" enctype="multipart/form-data"--> 
<script type="text/html" id="mytemp">
        <form id="form1" name="form1" method="post">

            <div class="form-group">
                <lable>用户ID：</lable>
                ${id}
            </div>

          <div class="form-group">
            <lable>用户名：</lable>
              <input type="hidden" name="id" value="${id}">
              <input type="text" name='username' class="form-control" id="uname" value="${username}">
            </div>

            <div class="form-group">
                <lable>密码：</lable>
                <input type="password" name='password' class="form-control" id="password" value="${password}">
            </div>
    
            <div class="form-group">
                <lable>qq：</lable>
                <input type="text" name='qq' class="form-control" id="qq" value="${qq}">
            </div>
    
           <div class="form-group">
            <lable>EMAIL地址：</lable>
              <input type="text" name='email' class="form-control" id="email" value="${email}">
            </div>

           <div class="form-group">
            <lable>电话号码：</lable>
              <input type="text" name='tel' class="form-control" id="tel" value="${tel}">
            </div>
    
           <div class="form-group">
            <lable>收款人：</lable>
              <input type="text" name='payee' class="form-control" id="payee" value="${payee}">
            </div>    
    
            <div class="form-group">
            <lable>开户银行：</lable>
              <input type="text" name='bank_name' class="form-control" id="bank_name" value="${bank_name}">
            </div>

            <div class="form-group">
            <lable>银行账号：</lable>
              <input type="text" name='bank_account' class="form-control" id="bank_account" value="${bank_account}">
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="sub()">确认提交</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <input type="reset" value="重置" class="btn btn-info">
            </div>
    </form>     
</script>
<!--修改用户的模态框-->
    
<!--右边内容部分-->
</div>
<!--JS自定义部分-->

    <script>   
        //执行编辑某个用户的个人信息
        function edit(demo){
            var memberId=$(demo).attr("value");
            $.get(
                "<?php echo U('Members/modifyMemberInfo');?>" ,
                {id:memberId},
                function(data){
                    $("#destination").html("");
                    $('#mytemp').tmpl(data).appendTo('#destination');
                }
            );
        }
        //执行修改用户个人信息
        function sub(){
            var username=$("#uname").val();
            var password=$("#password").val();
            var email=$("#email").val();
            var tel=$("#tel").val();
            var qq=$("#qq").val();
            var payee=$("#payee").val();
            var bank_account=$("#bank_account").val();
            if(password.length<6){
                alert("密码长度不能低于6位");
                return;
            }
            if(email.length<8){
                alert("邮箱不正确");
                return;
            }
            if(tel.length<11){
                alert("电话号码长度不正确!");
                return;
            }  
            if(payee.length==0){
                alert("收款人不能为空!");
                return;
            }  
            if(bank_account.length!==19){
                alert("收款账号的长度不正确!");
                return;
            }             
//            $.post(
//                "<?php echo U('Admin/Members/getMembersId');?>", 
//                {name:username},
//                function(data){
//                    if(data!==0){
//                        alert("该用户已经存在!");
//                        return;
//                    }
//                }
//            );
            $.post(
                "<?php echo U('Admin/Members/test');?>",
                $("#form1").serialize(),
                function(data){
                    console.debug(data);
                    if(data==1){
                        alert("更新成功!");
                        location.href="<?php echo U('Members/index');?>";
                    }else{
                        alert(data);
                    }
                }
            );
        }

        //执行 开启某用户
        function changeState(demo){
            var flag=$(demo).attr("flag");
            var member_id=$(demo).attr("value");
            var mes=(flag==1)?"你确定要开启该用户吗?":"你确定要禁用该用户吗?";
            if(window.confirm(mes)){
                $.post(
                    "<?php echo U('Members/changeState');?>" ,
                    {id:member_id,flag:flag},
                    function(data){
                       location.href="<?php echo U('index');?>";
                    }
                );
            }                
        }
        //执行删除命令
        function del(demo){
            var id=$(demo).attr("value");
            if(confirm("你确定要删除吗?")){
                $.post(
                    "<?php echo U('Admin/Members/del');?>",
                    {id:id},
                    function(data){
                        if(data==1){
                            alert("删除成功！");
                        }else{
                            alert("删除失败!");
                        }
                        location.href="<?php echo U('Members/index');?>";
                    }
                );
            }
        return false;
        }
</script>  

</body>
</html>