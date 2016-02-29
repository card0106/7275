<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Model;

/**
 * Description of ProductModel
 *产品表 model
 * @author Administrator
 */
class ProductModel extends BaseModel{
    //统计当前产品的总的数量
    public function goodsNum(){
        $sql="select count(*) as num from  product";
        $res=$this->query($sql);
        return $res[0]["num"];
    }
    public function _query($action){
        if($action=='index')
            return $this->join("LEFT JOIN `members_product` ON `members_product`.`goods_id`=`product`.`id`")
                        ->join("LEFT JOIN `category` ON `category`.`id`=`product`.`category_id`")
                         ->field("count(members_product.id) AS have,category.category_name,product.*")->group('`product`.`id`')->order("`top_time` DESC");
        return $this;
    }
    //根据product_data里面的数据改造数据
    /*
    public function changeRows($rows="",$member_name=""){
        $membersModel=D("Members");
        foreach ($rows as &$row) {
            $row["goods_name"]=  $this->getFieldById($row["goods_id"],"goods_name");
            //下游价是给会员的
            $row["goods_price"]=$this->getFieldById($row["goods_id"],"down_price_1");
            //上游价是给平台的
            $row["up_price"]=$this->getFieldById($row["goods_id"],"up_price_1");
//            $row["goods_intro"]=$productModel->getFieldById($row["goods_id"],"intro");
            $row["discount"]=$this->getFieldById($row["goods_id"],"discount");
            //扣量，向下取整,会员得到的推广次数
            $num= floor($row["promote_num"]*(1-$row["discount"]/100));
            //扣量金额，由该平台“添加产品”是决定
            //$row["discount_price"]=$row["discount"]*$row["goods_price"];
            $row["discount_price"]= ($row["discount"]/100)*$row["promote_num"]*$row["goods_price"];
            //扣量后的总金额
            $row["finnal_price"]=$num*$row["goods_price"];
            //联盟拿到的金额
            $row["union_price"]=$row["promote_num"]*$row["up_price"];
            $row["member_name"]=($member_name!=="")?$member_name:$membersModel->getFieldById($row["member_id"],"username");
        }
        return $rows;
    }
     * 
     */
}
