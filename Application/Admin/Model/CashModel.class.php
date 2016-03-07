<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Model;

/**
 * Description of CashModel
 *123
 * @author Administrator
 */
class CashModel extends BaseModel{
    //通过数据里面的member_id查找出对应的用户名
    public function _changeItem(&$rows) {
        $membersModel=D("Members");
        foreach ($rows as &$row) {
            $row["member_name"]=$membersModel->getFieldById($row["member_id"],"username");
        }
        return $rows;
    }
    //通过日期筛选出 提现数据
    public function getRowsByDate($date1="",$date2=""){
        $sql="select * from cash where withdrawal_formdate>='{$date1}' and withdrawal_formdate<='{$date2}'";
        $rows=$this->query($sql);
        $membersModel=D("Members");
        //根据每一条记录里面的member_id查出对应的 会员名
        foreach ($rows as &$row) {
            $row["member_name"]=$membersModel->getFieldById($row["member_id"],"username");            
            $row["formdate"]=  date("Y-m-d H:i:s", $row["withdrawal_date"]); 
            if($row["checked"]==1){
                $row["checked"]="已通过审核";
            }elseif($row["checked"]==-1){
                $row["checked"]="正在审核";
            }else{
                $row["checked"]="未通过审核";
            }            
        }
        return $rows;
    }
}
