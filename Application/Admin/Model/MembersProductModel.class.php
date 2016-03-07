<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Model;

/**
 * Description of MembersProductModel
 *
 * @author Administrator
 */
class MembersProductModel extends BaseModel{
    //根据goods_id和members_id查出是否有对应的记录，有就说明该会员已经定制该产品
    public function getItemByIds($goods_id,$members_id){
        $row=$this->where(array("goods_id"=>$goods_id,"members_id"=>$members_id))->find();
        return $row;
    }
    //根据一个members_id查询出对应的记录条数
    public function getNumById($id){
        $sql="select count(*) as num from members_product where members_id={$id}";
        $res=$this->query($sql);
        return $res[0]["num"];
    }
    //改变查询出来的数据
    /*
    public function _changeItem(&$rows) {
        //循环结果集中的goods_id查出对应的goods_name
        foreach ($rows as &$row) {
            //根据每一行记录里面的goods_id查出对应的goods-name和该产品的invoicing_cycle
            $productModel=D("Product");
            $row["goods_name"]=$productModel->getFieldById($row["goods_id"],"goods_name");
            $row["invoicing_cycle"]=$productModel->getFieldById($row["goods_id"],"invoicing_cycle");
        } 
        return $rows;
    }  */
    //根据用户id以及goods_id查询出是否有记录
    public function getRecordByIds($member_id="",$goods_id=""){
        $sql="select id from members_product where members_id={$member_id} and goods_id={$goods_id}";
        $row=$this->query($sql);
        //返回ID
        return $row[0]["id"];
    }
}
