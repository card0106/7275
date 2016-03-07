<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Model;

/**
 * Description of ProductDataModel
 *
 * @author Administrator
 */
class ProductDataModel extends \Think\Model{
    //根据会员ID得倒他的 产品报表
    public function getDataById($member_id=""){
        $sql="select * from product_data where member_id={$member_id}";
        $rows=$this->query($sql);
        //通过每一行的goods_id去得倒 产品的单价等
        $productModel=M("Product");
        //像total_money表中插入 “会员ID”和“当前会员下的所有金额”
        $totalMoneyModel=M("TotalMoney");
        //这里需要先判断“当前会员ID是否已经存在total_money表中”
        $id=$totalMoneyModel->getFieldByMemberId($member_id,"id");
        if($id==''){
            $allPrice=0;
            foreach ($rows as &$row) {
                //该会员1号数据所获得的全部 金额
                $down_price_1=$productModel->getFieldById($row["goods_id"],"down_price_1");
                echo "<pre>";
                die(var_dump($row));
                $allPrice+=$down_price_1*($row["promote_num"]-$row["discount"]);
            }
            $data=array("member_id"=>$member_id,"money"=>(string)$allPrice);
            $totalMoneyModel->add($data);
        }else{
            $money=$totalMoneyModel->getFieldByMemberId($member_id,"money");
            $data=array("member_id"=>$member_id,"money"=>$money);
        }
        return $data;
    }
    //根据member_id查询出当前用户的“效果报告”,每天推广了多少
    public function getEffectById($member_id=""){
        $sql="select * from product_data where member_id={$member_id}";
        $rows=$this->query($sql);
        $productModel=M("Product");
        //根据每一个里面的goods-id查询出结算的周期
        foreach ($rows as &$row){
            $row["goods_name"]=$productModel->getFieldById($row["goods_id"],"goods_name");
            $row["invoicing_cycle"]=$productModel->getFieldById($row["goods_id"],"invoicing_cycle");
        }
        return $rows;
    }
    public function getTotals($member_id,$datetime="")
    {
    	if($datetime!=="")$datetime = " AND DATE(FROM_UNIXTIME(`time`))='".$datetime."'";
        return floatval($this->where("`member_id`='".$member_id."'".$datetime)->sum('money'));
        /*
        return floatval($this->join("LEFT JOIN `members_product` ON `members_product`.`goods_id`=`product_data`.`goods_id` AND `members_product`.`members_id`=`product_data`.`member_id`")
        								->where("`member_id`='".$member_id."'".$datetime)
        								->sum('`members_product`.`dprice1`*`promote_num`*(100-`members_product`.`discount`)/100'));
        return floatval($this->join("LEFT JOIN `product` ON `product`.`id`=`product_data`.`goods_id`")
        								->where("`member_id`='".$member_id."'".$datetime)
        								->sum('`product`.`down_price_1`*`promote_num`'));
         * 
         */
    }
}
