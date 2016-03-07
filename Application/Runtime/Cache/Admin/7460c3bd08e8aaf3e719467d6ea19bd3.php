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
        <div class="tit f20">
            <span>产品信息</span>
            <a class="f12 cursor" data-toggle="modal" data-target="#myModal">增加产品</a> 
            <a href="<?php echo U('import');?>" class="f12">导入报表数据</a>
        </div>
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        <h4 class="modal-title" id="myModalLabel">增加产品</h4>
                    </div>
                    <div class="modal-body">
                        <form id="form1" name="form1" method="post" action="<?php echo U('Goods/add');?>" onsubmit="return jQuery.formValidator.PageIsValid('1')" enctype="multipart/form-data" >
                            <div class="form-group">
                                <lable>平台类型：</lable>
                                <select class="form-control" name='category_id'>
                                    <option value="0">请选择平台类型</option>
                                    <?php if(is_array($cats)): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cat["id"]); ?>"><?php echo ($cat["category_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                                </select>
                            </div>
                            <div class="form-group">
                                <lable>结算类型：</lable>
        		                <select class="form-control" name="cash_type" >
                                    <option>请选择结算类型</option>
        		                    <?php if(is_array($cashType)): $i = 0; $__LIST__ = $cashType;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cash): $mod = ($i % 2 );++$i;?><option value="<?php echo ($key); ?>"><?php echo ($cash); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
        		                </select>
                            </div>
                            <div class="form-group">
                                <lable>产品名称：</lable>
                                <input type="text" name='goods_name' class="form-control" placeholder="请输入产品名称">
                            </div>
                            <div class="form-group">
                                <lable>产品logo：</lable>
                                <input type="file" name="logo" class="form-control">
                            </div>                
                            <div class="form-group">
                                <lable>最大接口数：</lable>
                                <input type="text" name='max_links' class="form-control" placeholder="最大接口数">
                            </div>       
                            <div class="radio">
                                <span>产品状态：</span>
                                <?php if(is_array($states)): $i = 0; $__LIST__ = $states;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$state): $mod = ($i % 2 );++$i;?><label class="radio-inline">
                                        <input type="radio" name="state" value="<?php echo ($key); ?>" <?php if($key == '1'): ?>checked<?php endif; ?>><?php echo ($state); ?>
                                    </label><?php endforeach; endif; else: echo "" ;endif; ?>
                            </div>               
                            <div class="radio"> 
                                <span>结算方式：</span>
                                <?php if(is_array($invoicing_cycle)): $i = 0; $__LIST__ = $invoicing_cycle;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cycle): $mod = ($i % 2 );++$i;?><label class="radio-inline">
                                        <input type="radio" name="invoicing_cycle" value="<?php echo ($key); ?>" <?php if($key == '0'): ?>checked<?php endif; ?>><?php echo ($cycle); ?>
                                    </label><?php endforeach; endif; else: echo "" ;endif; ?>
                            </div>       
                            <div class="radio">
                                <span>数据返回：</span>
                                <?php if(is_array($data_back)): $i = 0; $__LIST__ = $data_back;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$dback): $mod = ($i % 2 );++$i;?><label class="radio-inline">
                                        <input type="radio" name="data_back" value="<?php echo ($key); ?>" <?php if($key == '0'): ?>checked<?php endif; ?>><?php echo ($dback); ?>
                                    </label><?php endforeach; endif; else: echo "" ;endif; ?>
                            </div>            
                            <lable>产品说明:</lable>
                            <textarea class="form-control" rows="3" name='intro'></textarea>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success" id="confirm">确认提交</button>
                                <input type="reset" value="重置" class="btn btn-info">
                            </div>
                        </form>                
                    </div>
                </div>
            </div>
        </div>  
        <div class="con">
            <table border="0" cellpadding="0" cellspacing="0" class="productTable" id="data">
                <thead>
                    <tr>
                        <th style="width:70px;">产品ID</th>
                        <th colspan=2>产品名称</th>
                        <!--<th>剩余接口数</th>-->
                        <th>平台类型</th>
                        <th style="width:80px;">结算<br />类型</th>
                        <th style="width:80px;">结算<br />周期</th>
                        <th style="width:80px;">状态</th>
                        <!--<th style="width:80px;">置顶</th>-->
                        <th style="width:250px;">操作</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(is_array($rows)): $i = 0; $__LIST__ = $rows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><tr>
                            <td>
                                <span><?php echo ($row["id"]); ?></span>
                            </td>
                            <td style="text-align: right;">
                                <img src="<?php echo ($row["goods_small_img"]); ?>" width="30" height="30">
                            </td>
                            <td style="text-align: left;">
                                <a href="javascript:;"><?php echo ($row["goods_name"]); ?></a>
                            </td>
                            <!--<td>
                                <?php if($row['have'] == 0): ?>0
                                <?php else: ?>
                                    <a class="sb6" href="<?php echo U('MembersProduct/getItems','goods_id='.$row['id']);?>"><?php echo ($row["have"]); ?></a><?php endif; ?>
                            </td>-->
                            <td>
                                <?php echo ($cats[$row['category_id']]['category_name']); ?>
                            </td>
                            <td>
                                <?php echo ($cashType[$row['cash_type']]); ?>
                            </td>
                            <td>
                                <?php echo ($invoicing_cycle[$row['invoicing_cycle']]); ?>
                            </td>
                            <td>
                                <?php if($row['state'] == 1): ?><a class="sb3" href="javascript:void(0);" onclick="control(<?php echo ($row["id"]); ?>,0,0)">正常</a>
                                <?php else: ?>
                                    <a class="sb5" href="javascript:void(0);" onclick="control(<?php echo ($row["id"]); ?>,0,1)">关闭</a><?php endif; ?>
                            </td>
                            <!--<td>
                                <?php if($row['top_time'] == 0): ?><a class="sb4" href="javascript:void(0);" onclick="control(<?php echo ($row["id"]); ?>,1,1)">置顶</a>
                                <?php else: ?>
                                    <a class="sb3" href="javascript:void(0);" onclick="control(<?php echo ($row["id"]); ?>,1,0)">取消</a><?php endif; ?>
                            </td>-->
                            <td>
                                <!--<a href="<?php echo U('addUser','goods_id='.$row['id'].'&category='.$row['category_name']);?>" class="sb4">增加用户</a>
                                <a href="<?php echo U('goodsData','goods_id='.$row['id']);?>" class="sb4">查看数据</a>-->
                                <a href="<?php echo U('links','id='.$row['id']);?>" class="sb4">添加链接</a>
                                <a href="<?php echo U('edit','id='.$row['id']);?>" class="sb4">修改产品</a>
                                <a href="javascript:void(0);" class="sb5" onclick="delGoods(this)" value="<?php echo ($row["id"]); ?>">删除</a>
                            </td>
                        </tr><?php endforeach; endif; else: echo "" ;endif; ?>
                </tbody>
            </table>
            <div id="turn-page" class="page">
                <?php echo ($pageHTML); ?>
            </div> 
        </div>
    </div> 
    
<!--右边内容部分-->
</div>
<!--JS自定义部分-->

<script type="text/javascript">
    //点击增加用户的时候，触发的函数
    $("#addUsers").click(function(){
        //查出用用户名
        var userName=$(".form-control[name='members_name']").val();
        $.post(
            "<?php echo U('Members/getMembersId');?>",
            {name:userName},
            function(data){
                if(data!==0){   //有对应的会员信息，要提交表单
                    $.ajax({
                        type: 'post',
                        url: '<?php echo U("Members/addMembersProduct");?>',
                        data: $("#form1").serialize(),
                        success: function(mes) {
                            if(mes!==0){   //已经保存成功
                                console.debug(mes);
                                //location.href="<?php echo U('finishSeats');?>"+"?reservation_id="+data;
                            }
                        }
                    });
                }else{
                    alert("该会员不存在！");
                }
            }
        );
        return false;
    });
    function control(id,type,val)
    {
    
        if(type==0 && !confirm("你确定要["+(val==0?"关闭":"开启")+"]这款产品吗？"))
        	return;
            $.post(
                "<?php echo U('Goods/control');?>",
                {id:id,type:type,val:val},
                function(data){
                    var mes=data==1?"操作成功":"操作失败";
                    alert(mes);
                    location.href="<?php echo U('Admin/Goods/index');?>";
                }
            );
    }
    //点击“查看数据”触发的函数
    function checkData(demo){
        var id=$(demo).attr("value");
        alert(id);
    }
    //点击 删除产品 所触发的函数
    function delGoods(demo){
        var id=$(demo).attr("value");
        if(confirm("你确定要删除吗？")){
            $.post(
                "<?php echo U('Goods/delGoods');?>",
                {id:id},
                function(data){
                    var mes=data==1?"删除成功":"删除失败";
                    alert(mes);
                    location.href="<?php echo U('Admin/Goods/index');?>";
                }
            );
        }
    }
</script>

</body>
</html>