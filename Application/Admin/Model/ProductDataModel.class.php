<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Model;

/**
 * Description of ProductDataModel
 *
 * @author Administrator
 */
class ProductDataModel extends BaseModel{
    //根据某一个goods_id查出对应的记录
    public function getRowsByGoodsId($goods_id){
        $rows = $this->alias('data')->join("LEFT JOIN `product` ON `product`.`id`=`data`.`goods_id`")
                ->join("LEFT JOIN `Members` ON `Members`.`id`=`data`.`member_id`")
                ->field('`product`.`goods_name`,`Members`.`username`,`data`.*,`data`.`umoney`-`data`.`money` AS union_price')->select();
        return $rows;
        /*
        $rows=  $this->where(array("goods_id"=>$goods_id))->select();
        //根据$rows里面的goods_id和member_id查出对应的 “产品名”和“会员名”
        $membersModel=D("Members");
        $productModel=D("Product");
        foreach ($rows as &$row) {
            $row["member_name"]=  $membersModel->getFieldById($row["member_id"],"username");
            $row["goods_name"]=  $productModel->getFieldById($row["goods_id"],"goods_name");
//            $row["discount"]=$productModel->getFieldById($row["goods_id"],"discount");
//            $row["up_price_1"]=  $productModel->getFieldById($row["goods_id"],"up_price_1");
//            $row["down_price_1"]=  $productModel->getFieldById($row["goods_id"],"down_price_1");
            $discount=$productModel->getFieldById($row["goods_id"],"discount");
            $up_price_1=  $productModel->getFieldById($row["goods_id"],"up_price_1");
            $down_price_1=  $productModel->getFieldById($row["goods_id"],"down_price_1");
            
            //平台所得利润
            $row["union_price"]=$row["promote_num"]*$up_price_1-$row["promote_num"]*(1-$discount/100)*$down_price_1;
            //渠道所得利润
            $row["finnal_price"]=$row["promote_num"]*(1-$discount/100)*$down_price_1;
        }
        return $rows;
         */
    }
    //根据某个时间段 查询对应的数据记录
    public function getRowsByDate($member_id="",$data1="",$data2=""){
            //没有传入具体的某个用户
            $sql_1="select * from  product_data where time>='{$data1}' and time<='$data2'";
            //传入了具体的某个用户
            $sql_2="select * from  product_data where member_id={$member_id} and time>='{$data1}' and time<='{$data2}'";
            $sql=$member_id==0?$sql_1:$sql_2;
            $rows=$this->query($sql);
            $productModel=D("Product");
            $membersModel=D("Members");
            //总推广量
            $allPromoteNum=0;
            foreach ($rows as &$row) {
                $row["member_name"]=$membersModel->getFieldById($row["member_id"],"username");
                $row["goods_name"]=$productModel->getFieldById($row["goods_id"],"goods_name");
                $row["goods_price"]=$productModel->getFieldById($row["goods_id"],"down_price_1");
                $row["up_price"]=$productModel->getFieldById($row["goods_id"],"up_price_1");
                $row["discount"]=$productModel->getFieldById($row["goods_id"],"discount");
                //算出经过扣量之后的 推广次数
                $num=  floor((1-$row["discount"]/100)*$row["promote_num"]);
                $row["discount_price"]=$row["promote_num"]*($row["discount"]/100)*$row["goods_price"];
                $row["finnal_price"]=$num*$row["goods_price"];
                //联盟平台所获取的费用
                $row["union_price"]=$row["promote_num"]*$row["up_price"];
            }
            return $rows;            
    }
    //获取昨天的利润
    public function yestDayProfits(){
        return $this->where("DATE(FROM_UNIXTIME(`time`))=DATE(DATE_SUB(NOW(),INTERVAL 1 DAY))")->sum("umoney-money") | 0;
        /*
        $productModel=D("Product");
        $time=time();
        $yestDate=date("Y-m-d",$time-24*60*60);
        $sql="select * from product_data where time='{$yestDate}'";
        $rows=$this->query($sql);
        $profits=  $this->conditions($rows);

        return $profits;
         */
    }
    //计算出本周利润
    public function thisWeekProfits(){
        return $this->where("DATE(FROM_UNIXTIME(`time`))>=DATE(DATE_SUB(NOW(),INTERVAL 7 DAY))"
                . " AND DATE(FROM_UNIXTIME(`time`))<=DATE(NOW())")
                ->sum("umoney-money") | 0;
        /*
        $productModel=D("Product");
        $time=  time();
        $currentDate=date("Y-m-d",$time);
        $thisWeekDate=date("Y-m-d",$time-7*24*60*60);
        $sql="select * from product_data where time>='{$thisWeekDate}' and time<='{$currentDate}'";
        $rows=$this->query($sql);
        $profits=  $this->conditions($rows);

        return $profits;
         * 
         */
    }    
    //计算出本月利润
    public function thisMonthProfits(){
        return $this->where("CONCAT(YEAR(FROM_UNIXTIME(`time`)),'-',MONTH(FROM_UNIXTIME(`time`)))=CONCAT(YEAR(NOW()),'-',MONTH(NOW()))")
                ->sum("umoney-money") | 0;
        /*
        $productModel=D("Product");
        $thisDate=date("Y-m",time());
        $sql="select * from product_data where time like '{$thisDate}%'";
        $rows=$this->query($sql);
        $profits=  $this->conditions($rows);
        return $profits;       
         * 
         */
    }
    //获取上月利润
    public function lastMonthProfits(){
        return $this->where("CONCAT(YEAR(FROM_UNIXTIME(`time`)),'-',MONTH(FROM_UNIXTIME(`time`)))="
                . "CONCAT(YEAR(DATE_SUB(NOW(),INTERVAL 1 MONTH)),'-',MONTH(DATE_SUB(NOW(),INTERVAL 1 MONTH)))")
                ->sum("umoney-money") | 0;
        /*
        $productModel=D("Product");
        $lastDate=date("Y-m",time()-30*24*60*60); 
        $sql="select * from product_data where time like '{$lastDate}%'";
        $rows=$this->query($sql); 
        $profits=  $this->conditions($rows);
        return $profits;           
         * 
         */
    }
    //根据$productModel查询条件得到利润
    private function conditions($rows=array()){
        $productModel=D("Product");
        $profits=0;
        foreach ($rows as $row) {
            //根据每一个产品的discount以及价格、num计算出利润
            $discount=$productModel->getFieldById($row["goods_id"],"discount");
            $up_price=$productModel->getFieldById($row["goods_id"],"up_price_1");
            $down_price=$productModel->getFieldById($row["goods_id"],"down_price_1");
            $profits+=($row["promote_num"]*$up_price-$row["promote_num"]*$down_price);
        }
        return $profits;        
    }
}
