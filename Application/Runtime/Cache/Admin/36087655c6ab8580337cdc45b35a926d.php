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
            <a href="<?php echo U('Product/index');?>" class="n3">产品信息</a>
            <a href="<?php echo U('Invoicing/invoicing');?>" class="n4">结算列表</a>
            <a href="<?php echo U('Cash/cash');?>" class="n5">提现列表</a>
            <a href="<?php echo U('News/index');?>" class="dr6">新闻公告</a>
            <a href="<?php echo U('Question/index');?>" class="n7">常见问题</a>            
        </div>
    </div>
    
<!--左边导航部分-->
<!--右边内容部分-->

<div class="right">
    <div class="mtit">
    	<div class="blue f20 fl">渝网传媒</div>
        <div class="fr">
            <div class="userout fl"><a href="#"><?php echo ($_SESSION["userinfo"]["username"]); ?></a></div>
            <div class="out fl"><a href="<?php echo U('Login/Index/logout');?>">退出</a></div>
        </div>
    </div>
	<div class="tit f20">新闻公告<a class="f12 cursor" data-target="#myModal" data-toggle="modal">增加新闻公告</a> </div>
    <div class="con">
    	<table border="0" cellpadding="0" cellspacing="0" class="productTable">
            <tr class="f14">
                    <th width="50%">标题</th>
                    <th width="28%">发布时间</th>
                    <th width="22%">操作</th>
            </tr>
            <?php if(is_array($rows)): $i = 0; $__LIST__ = $rows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><tr>
                    <td><?php echo ($row["title"]); ?></td>
                    <td><?php echo date("Y-m-d",$row["time"]);?></td>
                    <td>
                        <a href="#" class="sb4" data-target="#myModal1" data-toggle="modal" value="<?php echo ($row['id']); ?>" onclick="edit(this)">修改</a>
                        <a href="#" class="sb5" value='<?php echo ($row["id"]); ?>' onclick="return del(this)">删除</a>
                    </td>
            </tr><?php endforeach; endif; else: echo "" ;endif; ?>
        </table>
        <!--分页工具条 开始---->
        <div id="turn-page" class="page">
            <?php echo ($pageHTML); ?>
        </div> 
        <!--分页工具条 结束---->        
    </div>
</div>        
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">增加新闻公告</h4>
              </div>
              <div class="modal-body">
                <form id="form1" name="form1" method="post" action="<?php echo U('Admin/News/add');?>" enctype="multipart/form-data" >
                  <div class="form-group">
                    <lable>标题：</lable>
                      <input type="text" name='title' class="form-control" id="title" placeholder="请输入标题">
                    </div>
        
                    <div class="form-group">
                        <lable>关键字：</lable>
                        <input type="text" name='keyword' class="form-control" id="keyword" placeholder="请输入关键字">
                    </div>
                    
                    <div class="form-group">
                    <lable>内容：</lable>
                      <textarea name="content" rows="10" class="form-control" id="content" placeholder="请输入内容"></textarea>
                    </div>
                    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success" id="confirm">确认提交</button>
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                       <input type="reset" value="重置" class="btn btn-info">
                    </div>
            </form>                
            <!---添加产品的表单------>
            </div>
        </div>
    </div>
</div> 
<!--修改新闻的模态框-->
<div class="modal fade" id="myModal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">编辑新闻公告</h4>
              </div>
              <div class="modal-body" id='destination'>
                <!---修改新闻内容的表单------>
                <!---修改新闻内容的表单------>
              </div>
        </div>
    </div>
</div>
<!--要插入的具体内容-->
<script type="text/html" id='mytemp'>
        <form id="form2"  method="post">
          <div class="form-group">
            <lable>标题：</lable>
              <input type="hidden" name="id" value="${id}">
              <input type="text" name='title' class="form-control" id="title1" value="${title}">
            </div>

            <div class="form-group">
                <lable>关键字：</lable>
                <input type="text" name='keyword' class="form-control" id="keyword1" value="${keyword}">
            </div>

            <div class="form-group">
            <lable>内容：</lable>
              <textarea name="content" rows="10" class="form-control" id="content1">${content}</textarea>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-success" onclick="sub()">确认提交</button>
                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
               <input type="reset" value="重置" class="btn btn-info">
            </div>
    </form>                
</script>
    
<!--右边内容部分-->
</div>
<!--JS自定义部分-->

<script>   
    //执行编辑某个用户的个人信息
    function edit(demo){
        var memberId=$(demo).attr("value");
        $.get(
            "<?php echo U('News/modifyNewsInfo');?>" ,
            {id:memberId},
            function(data){
                $("#destination").html("");
                $('#mytemp').tmpl(data).appendTo('#destination');
            }
        );
    }
    // 编辑修改后的提交表单
    function sub(){
        var title=$("#title1").val();
        var keyword=$("#keyword1").val();
        var content=$("#content1").text();
        if(title.length<1){
            alert("标题长度不对");
            return;
        }
        if(keyword.length<1){
            alert("关键字长度不对");
            return;
        }
        if(content.length<1){
            alert("新闻内容长度不对");
            return;
        }        
        $.post(
            "<?php echo U('Admin/News/updateInfo');?>",
            $("#form2").serialize(),
            function(data){
                if(data==1){
                    alert("更新成功!");
                    location.href="<?php echo U('News/index');?>";
                }else{
                    alert(data);
                }
            }
        );        
    }
    //执行删除命令
    function del(demo){
        var id=$(demo).attr("value");
        if(confirm("你确定要删除吗?")){
            $.post(
                "<?php echo U('Admin/News/del');?>",
                {id:id},
                function(data){
                    if(data==1){
                        alert("删除成功！");
                    }else{
                        alert("删除失败!");
                    }
                    location.href="<?php echo U('News/index');?>";
                }
            );
        }
    return false;
    }    
</script>

</body>
</html>