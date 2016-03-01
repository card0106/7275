<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

/**
 * Description of ProductController
 *
 * @author Administrator
 */
class ProductController extends BaseController{
    //改造查询产品的where条件
        /*
    protected function _setWheres(&$wheres,&$order) {
        $order="`top_time` DESC";//array("state"=>1);
        return $wheres;
    }
         */
    //改造数据
        
    protected function _before_index_view($result) {
        //$result["rows"]=$this->getCategoryName($result["rows"]);
        $this->assign("cats", D("Category")->select());
        //$this->assign($result);
    }
         
        /*
    //根据category_id查出对应的分类的名字
    private function getCategoryName($rows){
        $cats = M("Category")->getField('id,category_name');
        $goods = M("MembersProduct")->group('goods_id')->getField('goods_id,count(id)');
        for($i=0;$i<count($rows);$i++){
        	$rows[$i]["category_name"] = $cats[$rows[$i]["category_id"]];
        	$rows[$i]["have"] = $goods[$rows[$i]["id"]] | 0;
        }
        return $rows;
    }
         */
    //根据ID删除一行记录
    public function delGoods(){
        $productModel=D("Product");
        $id=$_POST["id"];
        $res=$productModel->where("id={$id}")->delete();
        if($res!==false) $this->ajaxReturn (1);
    }   
    //根据ID操作关闭或者置顶
    public function control(){
        $id=I("post.id",0,"intval");
        $type=I("post.type",0,"intval");
        $val=I("post.val",0,"intval");
        if($id==0)exit;
        //$model = D("Product")->where("id={$id}");
        $res = false;
        if($type==1){
       		$res=D("Product")->where("`id`='{$id}'")->setField("top_time",$val==1?time():0);
        }else
        if($type==0){
       		$res=D("Product")->where("`id`='{$id}'")->setField("state",$val==1?1:0);
        }
        $this->ajaxReturn ($res!==false?1:0);
    }   
    //产品展示 页面“增加用户”
    public function addUser(){
        $productModel=D("Product");
        if(IS_POST){
            if($_POST["goods_id"]==""){ //防止用户在地址栏手动输入
                $this->ajaxReturn(0);
            }else{
                //根据members_id查出该会员是否已经被禁用
                $membersModel=D("Members");
                $membersState=$membersModel->getFieldById($_POST["members_id"],"state");
                //根据goods_id查出对应的state
                $state=$productModel->getFieldById($_POST["goods_id"],"state");
                $_POST["state"]=$state;
                $membersProductModel=D("MembersProduct");
                 //还需要判断该 会员是否已经被禁用
                if($membersState==0){ //会员被禁用，不能添加
                        $this->ajaxReturn(-2);
                }else{  //会员未被禁用
                    $row=$membersProductModel->getItemByIds($_POST["goods_id"],$_POST["members_id"]);
                    if(is_array($row)){ //说该会员已经订制该产品
                        $this->ajaxReturn(-1);
                    }else{  //未订制，需要向数据库添加数据
                        if($membersProductModel->create()!==false){
                            $data=$membersProductModel->data();
                            if($membersProductModel->add()!==false){
                                $this->ajaxReturn(1);
                            }else{  //未成功添加数据
                                $this->ajaxReturn(0);
                            }
                        }
                    }                
                }                
            }
        }else{
            $goods_id=$_GET["goods_id"];
            $row=parent::getItemById($goods_id);
            $row["category"]=$_GET["category"];
            $this->assign($row);
            $this->display();
        }
    }
    //修改产品信息
    protected function _before_edit_view() {
        $goods_id=$_GET["goods_id"];
        $row=$this->model->where(array("id"=>$goods_id))->find();
        return $row;
    }
    //该函数用于上传图片之后返回图片路径
    protected function _dealPic(){
            $config=array(    //上传图片的配置
                                    'exts'          =>  array('jpg', 'gif', 'png', 'jpeg'), //允许上传的文件后缀
                                    'autoSub'       =>  true, //自动子目录保存文件
                                    'subName'       =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
                                    'rootPath'      =>  './Uploads/', //保存根路径
                                    'savePath'      =>  'goods/', //保存路径
                                    'saveName'      =>  array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
                            );
            $upload =new \Think\Upload($config);
            $result = $upload->uploadOne($_FILES['logo']);
            
            if($result!==false){
                //上传后的路径... 例如: "/Uploads/goods/2015-01-06/54aba3ea75415.png
               $goods_big_img =  substr($config['rootPath'],1).$result['savepath'].$result['savename'];
               $_POST['goods_big_img'] = $goods_big_img;
                //根据大图片生成小图片..
//                /Uploads/goods/2015-01-06/54aba3ea75415.png
//                /Uploads/goods/2015-01-06/54aba3ea75415_small.png

                //先准备路径
                $pathinfo   = pathinfo($goods_big_img);
                $goods_small_img = $pathinfo['dirname'].'/'.$pathinfo['filename'].'_small.'.$pathinfo['extension'];

                 $image = new \Think\Image();
                //>>1.先打开图片
                 $image->open(ROOT_PATH.$goods_big_img);//它需要的是一个绝对路径(带盘符)
                //>>2.生成缩略图
                $image->thumb(50,50);
                //>>3.保存缩略图
                $image->save(ROOT_PATH.$goods_small_img);//也需要绝对路径

                $_POST['goods_small_img'] = $goods_small_img; //
            }else{
                $this->error("上传失败".$upload->getError());
            }

            //把软件软件包地址也上传了
            $config=array(    //上传图片的配置
                //'exts'          =>  array('jpg', 'gif', 'png', 'jpeg'), //允许上传的文件后缀
                'autoSub'       =>  true, //自动子目录保存文件
                'subName'       =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
                'rootPath'      =>  './Uploads/', //保存根路径
                'savePath'      =>  'app/', //保存路径
                'saveName'      =>  array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
            );
            $upload =new \Think\Upload($config);
            $result = $upload->uploadOne($_FILES['app_path']);
            
            if($result!==false){
                //上传后的路径... 例如: "/Uploads/goods/2015-01-06/54aba3ea75415.png
                $goods_big_img =  substr($config['rootPath'],1).$result['savepath'].$result['savename'];
                $_POST['app_path'] = $goods_big_img;
            }else{
                $this->error("上传失败".$upload->getError());
            }

            return $_POST;
    }    
    //用于处理更新产品
    public function updateGoods(){
        $productModel=D("Product");
        $id=I("post.id");
        if($_FILES['logo']["name"]!==""){   //有上传图片的话，就需要更新图片地址
            $this->_dealPic();
        }
            if($productModel->create()!==false){ //手机数据表对应的数据
                $data=$productModel->data();
                $res=$productModel->where("id={$id}")->save();
                if($res!==false){   //更新成功
                    $this->success("更新产品成功",  cookie("__forward__"));
                }else{
                    $this->error("更新产品失败".$this->model->getError());
                }
            }
    }
    public function charts(){
        $goods_id=I("get.goods_id");
        $date_begin = I("post.date_begin") ? strtotime(I("post.date_begin")) : mktime(0,0,0)-16*86400;
        $date_end = I("post.date_end") ? strtotime(I("post.date_end"))+86399 : mktime(0,0,0)-1;
        $where = $charts = array();
        $where[] = "`data`.`time`>={$date_begin} AND `data`.`time`<={$date_end}";
        if($goods_id){
            $where[] = "`data`.`goods_id`={$goods_id}";
            $charts['series']['name'] = D("Product")->getFieldById($goods_id,"goods_name");
        }else
        {
            $charts['series']['name'] = "全系产品";
        }
        $charts['title'] = "最近15日收益走势";
        $charts['subtitle'] = date("Y-m-d",$date_begin)." 至 ".date("Y-m-d",$date_end);
        $rows=D("ProductData")->alias('data')
                //->join("LEFT JOIN `product` ON `product`.`id`=`data`.`goods_id`")
                //->join("LEFT JOIN `Members` ON `Members`.`id`=`data`.`member_id`")
                ->field('SUM(`data`.`umoney`-`data`.`money`) AS union_price,`data`.`time`'
                        )
                ->where($where)
                ->group("DATE(FROM_UNIXTIME(`data`.`time`))")
                ->order("`data`.`time` ASC")
                ->select();
        foreach($rows AS $val)
        {
            $charts['categories'][] = date("Y-m-d", $val['time']);
            $charts['series']['data'][] = $val['union_price'];
        }
        $charts['categories'] = "'".implode("','",$charts['categories'])."'";
        $charts['series']['data'] = "".implode(",",$charts['series']['data'])."";
        //var_dump($rows);exit;
        $this->assign("charts",$charts);
        $this->assign("total",$this->getTotals($goods_id));
        $this->display();
    }
    //用于处理 查看某个产品的推广数据(id,数据1,导入数据的时间)
    
    public function top(){
        $goods_id=I("get.goods_id");
        $rows=D("ProductData")->alias('data')->join("LEFT JOIN `product` ON `product`.`id`=`data`.`goods_id`")
                ->join("LEFT JOIN `Members` ON `Members`.`id`=`data`.`member_id`")
                ->field('`product`.`goods_name`,`Members`.`username`,SUM(`data`.`umoney`-`data`.`money`) AS union_price,'
                        . 'SUM(`data`.`promote_num`) AS promote_num,SUM(`data`.`real_num`) AS real_num,'
                        . 'SUM(`data`.`money`) AS money,SUM(`data`.`umoney`) AS umoney'
                        )
                ->where($goods_id?"`data`.`goods_id`=".$goods_id:'')
                ->group("`data`.`member_id`")
                ->order("union_price DESC")
                ->select();
        //var_dump($rows);exit;
        $this->assign("rows",$rows);
        $this->assign("total",$this->getTotals($goods_id));
        $this->display();
    }
    public function goodsData(){
        $productModel=D("ProductData");
        if(IS_POST){
            $date1=$_POST["date1"];
            $date2=$_POST["date2"];
            $memberName=$_POST["member"];
            $membersModel=D("Members");
            $member_id=$membersModel->getFieldByUsername($memberName,"id");
            $rows=$productModel->getRowsByDate($member_id,$date1,$date2);
            
//            if($memberName!==-1){   //如果有传用户名
//                $membersModel=D("Members");
//                $member_id=$membersModel->getFieldByUsername($memberName,"id");
//                $this->ajaxReturn($member_id);
//                $rows=$productModel->getRowsByDate($member_id,$date1,$date2);
//            }else{  //没传用户名，则需要查询出对应日期的数据
//                $membersModel=D("Members");
//                $this->ajaxReturn($_POST["member"]);
//                $member_id=$membersModel->getFieldByUsername($memberName,"id");
//                $rows=$productModel->getRowsByDate(0,$date1,$date2);
//            }
           
            $rows_1=$this->getProfits($rows);
            $this->ajaxReturn(array($rows,$rows_1));
        }else{
            $goods_id=I("get.goods_id");//$_GET["goods_id"];
            //查看product_data中的数据，根据具体的某一个goods_id
            $rows=$productModel->alias('data')->join("LEFT JOIN `product` ON `product`.`id`=`data`.`goods_id`")
                    ->join("LEFT JOIN `Members` ON `Members`.`id`=`data`.`member_id`")
                    ->field('`product`.`goods_name`,`Members`.`username`,`data`.*,`data`.`umoney`-`data`.`money` AS union_price,'
                            . 'ROUND(`data`.`promote_num`/`data`.`real_num`*100,2) AS percent,100-ROUND(`data`.`money`/`data`.`umoney`*100,2) AS money_percent')
                    ->where("`data`.`goods_id`=%d",array($goods_id))
                    ->order("`time` DESC")
                    ->select();
            $this->assign("rows",$rows);
            $this->assign("total",$this->getTotals($goods_id));
    //        $this->assign("rows",  json_encode($rows));
            $this->display();
        }
    }
    //统计当前数据
    public function getTotals($goods_id){
        $total=D("ProductData")->field('SUM(`promote_num`) AS promote_num,SUM(`real_num`) AS real_num,'
                . 'SUM(`money`) AS money,SUM(`umoney`) AS umoney,SUM(`umoney`-`money`) AS price')
                ->where("`goods_id`=%d",array($goods_id))
                ->select();
        if(is_array($total[0]))
        {
            $total = $total[0];
            $total['money_percent'] = 100-round($total['money']/$total['umoney']*100,2);
            $total['real_percent'] = round($total['promote_num']/$total['real_num']*100,2);
            $total['real_money'] = round($total['umoney']/$total['promote_num'],2);
        }else
            $total = false;
        return $total;
    }    
    //查询出总的推广数以及总的利润
    public function getProfits($rows=array()){
        $allPromoteNum=0;
        $allUninProfits=0;
        foreach ($rows as $row) {
            $allPromoteNum+=$row["promote_num"];
            $allUninProfits+=$row["union_price"];
        }
        return array("allPromoteNum"=>$allPromoteNum,"allUninProfits"=>$allUninProfits);
    }
    //用于处理批量导入安装数据的业务逻辑
    public function import(){
        require_once 'test/test.php';
        if(IS_POST){    //处理上传的excel文件
            $config=array(    //上传图片的配置
                        'exts'          =>  array('xlsx','xls'), //允许上传的文件后缀
                        'autoSub'       =>  true, //自动子目录保存文件
                        'subName'       =>  array('date', 'Y-m-d'), //子目录创建方式，[0]-函数名，[1]-参数，多个参数使用数组
                        'rootPath'      =>  './Uploads/', //保存根路径
                        'savePath'      =>  'productData/', //保存路径
                        'saveName'      =>  array('uniqid', ''), //上传文件命名规则，[0]-函数名，[1]-参数，多个参数使用数组
            );  
            $upload =new \Think\Upload($config);
            $result = $upload->uploadOne($_FILES['data']);
            if($result!==false){
                //上传后的路径下的该文件
                $pathFile=substr($config['rootPath'],2).$result['savepath'].$result['savename'];
                $rows = $data = $mids = $mnames = $pids = $pnames = $mpds = array();
                $changeFileds = array("discount", "dprice1");
                $exl = readexcel($pathFile);
                array_shift($exl);
                foreach($exl AS $val)
                {
                    $tmp = array('goods_name' => trim(strval($val[0])),
                        'member_name' => trim(strval($val[1])),
                        'promote_num' => intval($val[2]),
                        'real_num' => intval($val[3]),
                        'time' => strtotime($val[4]),
                        'discount' => floatval($val[5]),// | null,
                        'dprice1' => floatval($val[6]),// | null
                        'flags' => strval($val[7]),
                        'comments' => strval($val[8]),
                        'priority_type' => 0
                    );
                    if(strlen($tmp['goods_name'])==0)
                        break;
                    $mnames[] = $tmp['member_name'];
                    $pnames[] = $tmp['goods_name'];
                    $data[] = $tmp;
                }
        	$mnames = D("Members")->where(array("username" => array("IN", implode(array_unique($mnames),","))))->getField("username,id");
                $mids = array_values($mnames);
                $pnames = D("Product")->where(array("goods_name" => array("IN", implode(array_unique($pnames),","))))->getField("goods_name,id,cash_type,up_price_1");
                foreach ($pnames AS $val)
                    $pids[] = $val['id'];
        	$rows = D("MembersProduct")->where(array("members_id" => array("IN", implode(array_unique($mids),","))))->select();
                foreach ($rows AS $val)
                    $mpds[$val['members_id']][$val['goods_id']][$val['flags']] = $val;
                $pd = D("ProductData");
                foreach($data AS &$val)
                {
                    $val['member_id'] = $mnames[$val['member_name']];
                    $val['goods_id'] = $pnames[$val['goods_name']]['id'];
                    $val['cash_type'] = $pnames[$val['goods_name']]['cash_type'];
                    $val['uprice1'] = $pnames[$val['goods_name']]['up_price_1'];
                    
                    $fined = $pd->where("`goods_id`=%d AND `member_id`=%d AND `flags`='%s' AND `time`='%s' AND `promote_num`=%d AND `real_num`=%d", 
                        array($val['goods_id'], $val['member_id'], $val['flags'], $val['time'], $val['promote_num'], $val['real_num']))->find();
                    if($fined){
                        echo $val['member_name']."已经录入".$val['goods_name'];
                        continue;
                    }
                    if(!is_array($mpds[$val['member_id']][$val['goods_id']]))
                            die($val['member_name']."没有订购此产品".$val['goods_name']);
                    if(!is_array($mpds[$val['member_id']][$val['goods_id']][$val['flags']]))
                            die($val['member_name']."没有找到".$val['goods_name']."子产品标识".$val['flags']);
                    
                    unset($val['member_name'],$val['goods_name']);
                    
                    foreach($changeFileds AS $chg)
                    {
                        //if(!array_key_exists($mpds[$val['member_id']], $mpds))
                        //        die("没有订购此产品");
                        if(!$val[$chg])
                            $val[$chg] = $mpds[$val['member_id']][$val['goods_id']][$val['flags']][$chg];
                        else{
                            if($val[$chg] == $mpds[$val['member_id']][$val['goods_id']][$val['flags']][$chg]){
                                //录入价格与当前用户价格一致，可以忽略。
                            }else{
                                //录入价格与当前用户价格不一致，可以忽略。
                                $val['priority_type'] = 1;
                            }
                        }
                    }
                    $val['umoney'] = $val['real_num'] * $val['uprice1'];
                    if($val['cash_type']==0)
                        $val['money'] = round($val['promote_num'] * (100-$val['discount']) / 100) * $val['dprice1'];
                    else if($val['cash_type']==1)
                        $val['money'] = round($val['promote_num'] * (100-$val['discount']) / 100) * ($val['dprice1']/100);
                }
                //var_dump($data);exit;
                $id=$pd->addAll($data);
                
                /*
                $arr = readexcel($pathFile);
                $temp=array();
                foreach($arr as $k=>$row){
                    $temp[$k]=preg_split('/\s+/is',$row[0]);
                }
                unset($temp[0]);
                //循环每一条数据，拼好之后，加入到product_data数据表中
                foreach ($temp as $row){
                    var_dump($row);
                    $data=array();
                    //根据会员名和产品名分别获取到对应的ID
                    //$data["goods_id"]=iconv('GB2312', 'UTF-8',$row[0]);
                    $data["goods_id"]=$row[0];
                    $data["member_id"]=$membersModel->getFieldByUsername($row[1],"id");
                    $data["promote_num"]=$row[2];
                    //由于excel表中的日期是2015/12/12，需要转换成2015-12-12
                    if(strpos($row[3], "\\")!==false){
                        $arr1=explode("\\",$row[3]);
                        $data["time"]=implode("-",$arr1); 
                    }else{
                        $data["time"]=$row[3];
                    }
                    //实例化product-data模型
                    //$productDataModel=D("ProductData");
                    //$id=$productDataModel->add($data);
                    //$this->addMoney($id);
                }
                */
                //exit;
                $this->success("导入文件成功");
            }else{
                $this->error("导入文件失败".$upload->getError());
            }
        }else{
            $this->display();
        }
    }  
    //导入数据成功之后，就需要往total_money表中插入数据
    public function addMoney($id){
        $productDataModel=D("ProductData");
        $productModel=D("Product");
        $row=$productDataModel->where("id={$id}")->select();
        $totalMoneyModel=M("TotalMoney");
        //foreach ($rows as $row) {
            $data=array();
            //通过每一个goods_id查询出对应的down_price_1和discount
            $price=$productModel->getFieldById($row[0]["goods_id"],"down_price_1");
            $discount=$productModel->getFieldById($row[0]["goods_id"],"discount");
            //扣量，向下取整,会员得到的推广次数
            $num= floor($row[0]["promote_num"]*(1-$discount/100));
            //$promoteNum=$row["promote_num"]-$discount;
            $data["money"]=$price*$num;
            $data["member_id"]=$row[0]["member_id"];

            $id=$totalMoneyModel->getFieldByMemberId($row[0]["member_id"],"id");
            //如果存在该member_id对应的一条记录，那么就只是更新
            if($id==''){    //需要添加记录
                $totalMoneyModel->add($data);
            }else{  //更新数据表
                $money=$totalMoneyModel->getFieldByMemberId($row[0]["member_id"],"money");
                $data["money"]+=$money;
                $totalMoneyModel->where("member_id={$row[0]['member_id']}")->save($data);
            }
       // }
        
    }
}
