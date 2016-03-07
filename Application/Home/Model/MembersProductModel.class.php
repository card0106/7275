<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Model;

/**
 * Description of MembersProductModel
 *
 * @author Administrator
 */
class MembersProductModel extends \Think\Model{
    //通过会员ID查找出对应的记录
    public function getRowsById($member_id=""){
        $sql="select * from members_product where members_id={$member_id}";
        $rows=$this->query($sql);
        //实例化 产品对象
        $productModel=M("Product");
        $productDataModel=D("ProductData");
        foreach ($rows as &$row) {
            //获取 产品数据product_data
            $row["promote_num"]=$productDataModel->getFieldByMemberId($member_id,"promote_num");
            $row["time"]=$productDataModel->getFieldByMemberId($member_id,"time");
            //$row["member_name"]=$membersModel->getFieldById($row["member_id"],"username");
            $row["goods_name"]=$productModel->getFieldById($row["goods_id"],"goods_name");
            $row["goods_price"]=$productModel->getFieldById($row["goods_id"],"down_price_1");
            $row["discount"]=$productModel->getFieldById($row["goods_id"],"discount");
            //查出结算周期
            $row["invoicing_cycle"]=$productModel->getFieldById($row["goods_id"],"invoicing_cycle");
//            $row["discount_price"]=$row["discount"]*$row["goods_price"];
//            $row["finnal_price"]=($row["promote_num"]-$row["discount"])*$row["goods_price"];
        } 
        return $rows;
    }
}
