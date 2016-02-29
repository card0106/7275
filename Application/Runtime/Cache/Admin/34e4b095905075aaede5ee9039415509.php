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

<div class="right">
	<div class="mtit">
            <div class="blue f20 fl">CMS联盟</div>
            <div class="fr">
                    <div class="userout fl"><a href="javascript:void(0)"><?php echo ($_SESSION["userinfo"]["username"]); ?></a></div>
                    <div class="out fl"><a href="<?php echo U('Login/Index/logout');?>">退出</a></div>
            </div>
        </div>
        <!---添加产品的 模态框 开始------->
        <!-- Button trigger modal -->
        <div class="tit f20">
            产品信息
            <a class="f12 cursor" data-toggle="modal" data-target="#myModal">增加产品</a> <a href="<?php echo U('import');?>" class="f12">导入报表数据</a>
            <!--<button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#myModal">增加产品</button>-->
        </div>
        
        <!-- Modal -->
        <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
          <div class="modal-dialog">
            <div class="modal-content">
              <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">增加产品</h4>
              </div>
              <div class="modal-body">
                <!---添加产品的表单------>
                <form id="form1" name="form1" method="post" action="<?php echo U('Product/add');?>" onsubmit="return jQuery.formValidator.PageIsValid('1')" enctype="multipart/form-data" >
                    <div class="form-group">
                        <lable>平台类型：</lable>
                        <select class="form-control" id="pselect" name='category_id'>
                            <option value="0">请选择平台类型</option>
                            <?php if(is_array($cats)): $i = 0; $__LIST__ = $cats;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$cat): $mod = ($i % 2 );++$i;?><option value="<?php echo ($cat["id"]); ?>"><?php echo ($cat["category_name"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <lable>结算类型：</lable>
		                <select class="form-control" id="cselect" name="cash_type" >
		                        <option>请选择结算类型</option>
		                        <option value="0">金额</option>
		                        <option value="1">比例</option>
		                </select>
                    </div>
                    <div class="form-group">
                        <lable>产品logo：</lable>
                        <input type="file" class="form-control" name="logo" id="logo">
                    </div>                   
                    <div class="form-group">
                        <lable>产品名称：</lable>
                        <input type="text" name='goods_name' class="form-control" id="pname" placeholder="请输入产品名称">
                    </div>
                    <div class="form-group">
                        <lable>扣量率：</lable>
                        <input type="text" name='discount' class="form-control" id="amount" placeholder="请输入扣量率">
                    </div>
                    <div class="form-group">
                        <lable>1号数据上游价格：</lable>
                        <input type="text" name='up_price_1' class="form-control" id="goup" placeholder="请输入价格">
                    </div>
                    <div class="form-group">
                        <lable>1号数据下游价格：</lable>
                        <input type="text" name='down_price_1' class="form-control" id="godown" placeholder="请输入价格">
                    </div>                    
                    <div class="form-group">
                        <lable>2号数据上游价格：</lable>
                        <input type="text" name='up_price_2' class="form-control" id="goup1" placeholder="请输入价格">
                    </div>                    
                    <div class="form-group">
                        <lable>2号数据下游价格：</lable>
                        <input type="text" name="down_price_2" class="form-control" id="godown1" placeholder="请输入价格">
                    </div>                    
                    <div class="form-group">
                        <lable>3号数据上游价格：</lable>
                        <input type="text" name='up_price_3' class="form-control" id="goup2" placeholder="请输入价格">
                    </div>                    
                    <div class="form-group">
                        <lable>3号数据下游价格：</lable>
                        <input type="text" name='down_price_3' class="form-control" id="godown2" placeholder="请输入价格">
                    </div>                    
                <!----结算周期的 单选按钮------>
                    <div class="radio">                       
                        结算方式:&nbsp;
                        <label class="radio-inline">
                          <input type="radio" name="invoicing_cycle" value="0" id="optionsRadios1" checked>每日
                        </label>
                        <label class="radio-inline">
                          <input type="radio" name="invoicing_cycle" value="1" id="optionsRadios1" >每周
                        </label> 
                        <label class="radio-inline">
                          <input type="radio" name="invoicing_cycle" value="2" id="optionsRadios1" >双周
                        </label>
                        <label class="radio-inline">
                          <input type="radio" name="invoicing_cycle" value="3" id="optionsRadios1" >每月
                        </label>
                    </div>                      
                <!---产品状态------>
                    <div class="radio">
                        产品状态:&nbsp;
                        <label class="radio-inline">
                            <input type="radio" name="state" id="optionsRadios1" value="1" checked="">进行中
                        </label>
                        <label class="radio-inline">
                          <input type="radio" name="state" id="optionsRadios1" value="0">已关闭
                        </label>
                    </div>                       
                <!-----数据返回-------->
                    <div class="radio">
                        数据返回:&nbsp;
                        <label class="radio-inline">
                            <input type="radio" name="data_back" id="optionsRadios1" value="0"  checked="">次日
                        </label>
                        <label class="radio-inline">
                          <input type="radio" name="data_back" id="optionsRadios1" value="1">实时
                        </label>
                        <label class="radio-inline">
                          <input type="radio" name="data_back" id="optionsRadios1" value="2">每周
                        </label>
                    </div>                     
                <!---产品说明----->
                    <lable>产品说明:</lable>
                    <textarea class="form-control" rows="3" name='intro'></textarea>
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
<!---添加产品的 模态框 结束------->
        <div class="con">
            <table border="0" cellpadding="0" cellspacing="0" class="productTable" id="data">
                <thead>
                    <tr>
                        <th width="7%">产品ID</th>
                        <th width="13%" colspan=2>产品名称</th>
                        <th width="5%">已订购</th>
                        <th width="7%">结算类型</th>
                        <th width="7%">平台类型</th>
                        <th width="11%">结算周期</th>
                        <th width="5%">单价1</th>
                        <th width="5%">单价2</th>
                        <th width="5%">单价3</th>
                        <th width="5%">状态</th>
                        <th width="5%">置顶</th>
                        <th>操作</th>
                    </tr>
                </thead>
                <!---展示产品列表------->
                <tbody>
                <?php if(is_array($rows)): $i = 0; $__LIST__ = $rows;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$row): $mod = ($i % 2 );++$i;?><tr>
                        <td><span><?php echo ($row["id"]); ?></span></td>
                        <td style="text-align: right;"><img src="<?php echo ($row["goods_small_img"]); ?>" width="30" height="30"></td>
                        <td style="text-align: left;"><a href="<?php echo U('charts','goods_id='.$row['id']);?>"><?php echo ($row["goods_name"]); ?></a></td>
                        <td><?php if($row['have'] == 0): ?>0<?php else: ?><a class="sb6" href="<?php echo U('MembersProduct/getItems','goods_id='.$row['id']);?>"><?php echo ($row["have"]); ?></a><?php endif; ?>
                        </td>
                        <td>
                            <?php if($row['cash_type'] == 0): ?>金额
                                <?php elseif($row['invoicing_cycle'] == 1): ?>比例<?php endif; ?>
                        </td>
                        <td width="7%"><?php echo ($row["category_name"]); ?></td>
                        <td>
                            <?php if($row['invoicing_cycle'] == 0): ?>每日
                                <?php elseif($row['invoicing_cycle'] == 1): ?>每周
                                <?php elseif($row['invoicing_cycle'] == 2): ?>双周
                                <?php elseif($row['invoicing_cycle'] == 3): ?>每月<?php endif; ?>
                        </td>
                        <td><span><?php echo ($row["up_price_1"]); if($row['cash_type'] == 1): ?>%<?php endif; ?></span></td>
                        <td><span><?php echo ($row["up_price_2"]); if($row['cash_type'] == 1): ?>%<?php endif; ?></span></td>
                        <td><span><?php echo ($row["up_price_3"]); if($row['cash_type'] == 1): ?>%<?php endif; ?></span></td>
                        <td>
		                        <?php if($row['state'] == 1): ?><a class="sb3" href="javascript:void(0);" onclick="control(<?php echo ($row["id"]); ?>,0,0)">正常</a>
		                        <?php else: ?>
		                            <a class="sb5" href="javascript:void(0);" onclick="control(<?php echo ($row["id"]); ?>,0,1)">关闭</a><?php endif; ?>
                        </td>
                        <td>
                        <?php if($row['top_time'] == 0): ?><a class="sb4" href="javascript:void(0);" onclick="control(<?php echo ($row["id"]); ?>,1,1)">置顶</a>
                        <?php else: ?>
                            <a class="sb3" href="javascript:void(0);" onclick="control(<?php echo ($row["id"]); ?>,1,0)">取消</a><?php endif; ?>
                        </td>
                        <td>
                            <a href="<?php echo U('addUser','goods_id='.$row['id'].'&category='.$row['category_name']);?>" class="sb4">增加用户</a>
                    <!----查看数据 单独页面------->
                            <a href="<?php echo U('goodsData','goods_id='.$row['id']);?>" class="sb4">查看数据</a>
                            <!--<button type="button" class="btn btn-info btn-sm" onclick="checkData(this)" value="<?php echo ($row["id"]); ?>">查看数据</button>-->
                    <!--------修改产品--------------->
                            <a href="<?php echo U('add','goods_id='.$row['id']);?>" class="sb4">修改产品</a>
                    <!------删除产品------------->
                            <a href="javascript:void(0);" class="sb5" onclick="delGoods(this)" value="<?php echo ($row["id"]); ?>">删除</a>
                            <!--<button type="button" class="btn btn-danger btn-sm" onclick="delGoods(this)" value="<?php echo ($row["id"]); ?>">删除</button>-->
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
                "<?php echo U('Product/control');?>",
                {id:id,type:type,val:val},
                function(data){
                    var mes=data==1?"操作成功":"操作失败";
                    alert(mes);
                    location.href="<?php echo U('Admin/Product/index');?>";
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
                "<?php echo U('Product/delGoods');?>",
                {id:id},
                function(data){
                    var mes=data==1?"删除成功":"删除失败";
                    alert(mes);
                    location.href="<?php echo U('Admin/Product/index');?>";
                }
            );
        }
    }
</script>

</body>
</html>