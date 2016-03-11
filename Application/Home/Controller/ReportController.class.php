<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;

/**
 * Description of ReportController
 *效果报告控制器 
 * @author Administrator
 */
class ReportController extends \Think\Controller{
    //展示“效果报告”
    public function  effect(){
        //根据当前 登录的会员，查出他所对应的产品
        $member_name = $_SESSION["membersinfo"]["username"];
	      $membersModel = D("Members");
        $member_id = $membersModel->getFieldByUsername($member_name,"id");
	    //$date_begin = date("Y-m-d", $_POST["date_begin"] ? strtotime($_POST["date_begin"]) : time()-604800);
	    //$date_end = date("Y-m-d", $_POST["date_end"] ? strtotime($_POST["date_end"]) : time());
        $date_begin = $_POST["date_begin"] ? strtotime($_POST["date_begin"]) : mktime(0,0,0)-604800;
	      $date_end = $_POST["date_end"] ? strtotime($_POST["date_end"])+86399 : mktime(0,0,0)+86400;
	      $product_name = strval($_POST['product_name']) | '';

  		    $productDataModel=D("ProductData");
    	    $rules = array(
				array('date_begin','require','日期必须填写！',1),
				array('date_begin','strtotime','日期格式不正确！',1,'function'),
				array('date_end','require','日期必须填写！',1),
				array('date_end','strtotime','日期格式不正确！',1,'function')
				);
        //if(!$membersModel->validate($rules)->create())
        //	exit($this->success($membersModel->getError()));
        //	$date_begin = date("Y-m-d", strtotime($_POST["date_begin"]));
        //	$date_end = date("Y-m-d", strtotime($_POST["date_end"]));
        
       	if($date_begin >= $date_end)
       		   exit($this->success("结束时间不能大于开始时间！"));
       	$totalRows = $productDataModel->alias('data')->join("LEFT JOIN `product` ON `product`.`id`=`goods`.`goods_id`")
                                      //->join("LEFT JOIN `members_product` ON `members_product`.`members_id`=`product_data`.`member_id` AND `members_product`.`goods_id`=`product_data`.`goods_id`")
       					->field('product.goods_name,data.*')
                                        ->where("`data`.`member_id`='{$member_id}' AND `data`.`time`>='{$date_begin}' AND `data`.`time`<'{$date_end}'".(strlen($product_name)>0?" AND `product`.`goods_name` LIKE '%".$product_name."%'":""))
      					->order("`data`.`time` DESC")
                                        ->count();

                        

        //分页数据
        $page=new \Think\Page($totalRows, C("PAGESIZE"));
        $start=$page->firstRow;
        if($start>=$totalRows)
            $start=$page->totalRows-$page->listRows;
        if($start<=0)
            $start=0;
        //$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $rows = $productDataModel->alias('data')->join("LEFT JOIN `product` ON `product`.`id`=`data`.`goods_id`")
                                      //->join("LEFT JOIN `members_product` ON `members_product`.`members_id`=`product_data`.`member_id` AND `members_product`.`goods_id`=`product_data`.`goods_id`")
       					->field('product.goods_name,data.*')
                                        ->where("`data`.`member_id`='{$member_id}' AND `data`.`time`>='{$date_begin}' AND `data`.`time`<'{$date_end}'".(strlen($product_name)>0?" AND `product`.`goods_name` LIKE '%".$product_name."%'":""))
      					->order("`data`.`time` DESC")
                                        ->limit($start,$page->listRows)->select();
      	$page->setConfig('router', true);
        $pageHTML=$page->show();
      	
    	//var_dump($rows);
    	//var_dump(strtotime($_POST["date_begin"]));
    	//var_dump(date("Y-m-d",strtotime($_POST["date_begin"])));
    	//exit;
        //$membersModel=D("Members");
        //$member_id=$membersModel->getFieldByUsername($member_name,"id");
        //通过member_id去product_data表中查询出 当前会员所拥有的goods
        //$productDataModel=D("ProductData");
        //$rows=$productDataModel->getEffectById($member_id);
//        $membersProductModel=D("MembersProduct");      
//        $rows=$membersProductModel->getRowsById($member_id);

        $this->assign("date_begin",$date_begin);
        $this->assign("date_end",$date_end);
        $this->assign("product_name",$product_name);
        
        $this->assign("pageHTML",$pageHTML);
        $this->assign("rows",$rows);
        $this->display();
    }
}
