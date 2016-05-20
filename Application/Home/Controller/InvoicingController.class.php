<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;

/**
 * Description of InvoicingController
 *提现记录
 * @author Administrator
 */
class InvoicingController extends \Think\Controller{
    //展示“提现记录”
    public function view(){
        //根据会员查出product_data中会员对应的产品，计算出金额
        $membersModel=D("Members");
        $member_name=$_SESSION["membersinfo"]["username"];
        $member_id=$membersModel->getFieldByUsername($member_name,"id");
        
        $productDataModel=M("ProductData");
        //某个会员推广某个产品的数据
        $rows=$productDataModel->where(array("member_id"=>$member_id))->select();
        //根据该会员 所拥有的每个产品ID查出对应的价格，及产品名
        $productModel=M("Product");
        foreach ($rows as &$row) {
            $row["goods_name"]=$productModel->getFieldById($row["goods_id"],"goods_name");
            $row["goods_price"]=$productModel->getFieldById($row["goods_id"],"down_price_1");
//            $row["goods_intro"]=$productModel->getFieldById($row["goods_id"],"intro");
            //扣量，向下取整,会员得到的推广次数
            $row["discount"]=$productModel->getFieldById($row["goods_id"],"discount");
            $num= floor($row["promote_num"]*(1-$row["discount"]/100));
            //$row["finnal_price"]=($row["promote_num"]-$row["discount"])*$row["goods_price"];
            $row["finnal_price"]=$num*$row["goods_price"];
        }
        $this->assign("rows",  json_encode($rows));
        $this->assign("member",$member_name);
        $this->display();
    }
}
