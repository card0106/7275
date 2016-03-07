<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

/**
 * Description of InvoicingController
 *结算列表模块123
 * @author Administrator
 */
class InvoicingController extends \Think\Controller{
    //展示结算列表
    public function invoicing($member_id=""){
        if($member_id!==""){
            $membersModel=D("Members");
            $member_name=$membersModel->getFieldById($member_id,"username");
            //某个会员推广某个产品的数据的条件
            $where=array("member_id"=>$member_id);
            $rows=$this->goodsData($where,$member_name);
            //传递一个memberID到页面用于 判断当通过日期查询的=时候，具体是全部查出还是 查找某个会员的所有记录
            $this->assign("member_id",$member_id);
            $this->assign($rows);
            $this->display();
        }else{
            $rows=  $this->goodsData();
            //标记，用于判断是否是查询 某一个用户的数据
            $this->assign("member_id",0);
            $this->assign($rows);
            $this->display();
        }
    }
    //推广广告的数据
    public function goodsData($where="",$member_name=""){
        $productDataModel=D("ProductData");
        $rows=$productDataModel->join("LEFT JOIN `product` ON `product`.`id`=`product_data`.`goods_id`")
                                ->join("LEFT JOIN `members` ON `members`.`id`=`product_data`.`member_id`")
                                ->field("product.goods_name,members.username,product_data.*")
                                ->where($where)
                                ->page();
        
        //$rows=$productDataModel->where(array("member_id"=>$member_id))->select();
        //改造$rows里面的数据,要得到对应的goods_name以及price
        //$productModel=D("Product");
        //$items=$productModel->changeRows($rows["rows"],$member_name);
        //$rows["rows"]=$items;
        return $rows;
    }
}
