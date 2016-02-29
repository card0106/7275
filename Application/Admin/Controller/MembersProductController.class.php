<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

/**
 * Description of MembersProductController
 *
 * @author Administrator
 */
class MembersProductController extends BaseController{
    //根据会员ID查询出对应的产品
    public function getItems(){
        $members_id=I("get.member_id");
        $goods_id = I("get.goods_id");
        $membersModel=D("MembersProduct");
       	$where = $ids =array();
       	if($goods_id)
       	{
       		$where = array("goods_id"=>$goods_id);
                /*
        	$rows=$membersModel->where($where)->page();
	        foreach($rows['rows'] as $key => $val)
	        	$ids[] = $val['members_id'];
        	$names = D("Members")->where(array("id" => array("IN", implode($ids,","))))->getField("id,username");
        	$product = D("Product")->where("id=%d",$goods_id)->getField("id,goods_name,invoicing_cycle");
                 * 
                 */
       	}else{
       		$where = array("members_id"=>$members_id);
                /*
        	$rows=$membersModel->where($where)->page();
	        foreach($rows['rows'] as $key => $val)
	        	$ids[] = $val['goods_id'];
        	$names = D("Members")->where("id=%d",$members_id)->getField("id,username");
        	$product = D("Product")->where(array("id" => array("IN", implode($ids,","))))->getField("id,goods_name,invoicing_cycle");
                 * 
                 */
       	}
        $rows=$membersModel->join("LEFT JOIN `members` ON `members`.`id`=`members_product`.`members_id`")
                ->join("LEFT JOIN `product` ON `product`.`id`=`members_product`.`goods_id`")
                ->field("members.username,product.goods_name,product.invoicing_cycle,members_product.*")
                ->where($where)
                ->page();
        /*
        foreach($rows['rows'] as $key => &$val)
        {
        	$val['username'] = $names[$val['members_id']];
        	$val['goods_name'] = $product[$val['goods_id']]['goods_name'];
        	$val['invoicing_cycle'] = $product[$val['goods_id']]['invoicing_cycle'];
        }
         *
         */
        $this->assign("pageHTML",$rows["pageHTML"]);
        $this->assign("rows",$rows["rows"]);
        $this->display();
    }
    //根据会员ID查询出对应的 product_data
    public function getRowsByMemberId(){
        //实例化产品数据对象
        $productDataModel=D("ProductData");
        $member_id=$_POST["member_id"];
        $data1=$_POST["data1"];
        $data2=$_POST["data2"];
        if($member_id==0){  
            $rows=$productDataModel->getRowsByDate($member_id,$data1,$data2);
            $this->ajaxReturn($rows);
        }else{  //其他情况要查询出“某一个时间段的”数据，不需要指定具体会员
            $rows=$productDataModel->getRowsByDate($member_id,$data1,$data2);
            $this->ajaxReturn($rows);
        }
    }
    //当在某一个产品下 增加用户的时候，先判断该用户是否已经拥有当前传过来的产品
    public function checkMemberProduct($username="",$goods_id=""){
        $membersModel=D("Members");
        $member_id=$membersModel->getFieldByUsername($username,"id");
        if(!$member_id)
        	$this->ajaxReturn(-1);
        //根据member_id以及goods_id查询出是否有记录
        $membersProductModel=D("MembersProduct");
        $id=$membersProductModel->getRecordByIds($member_id,$goods_id);
        $id=$id?1:0;
        $this->ajaxReturn($id);
    }
    public function control()
    {
        $id=I("post.id",0,"intval");
        $type=I("post.type",0,"intval");
        $field = array("discount","dprice1","dprice2","dprice3");
        $format = array("intval","floatval","floatval","floatval");
        if($id==0 || $type<1||$type>count($field))exit;
        $val=I("post.val",0,$format[$type-1]);
        $res = $res=D("MembersProduct")->where("`id`='{$id}'")->setField($field[$type-1],$val);
        $this->ajaxReturn ($res!==false?1:0);
    }
}
