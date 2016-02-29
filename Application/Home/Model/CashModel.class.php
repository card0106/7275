<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Model;

/**
 * Description of WithdrawalRecordModel
 *
 * @author Administrator
 */
class CashModel extends \Think\Model{
    //为会员提现记录进行分页
    public function page($wheres=array()) {
        $totalRows=  $this->where($wheres)->count();
        //数据开始显示的开始位置
        //开始分页
        $page=new \Think\Page($totalRows, C("PAGESIZE"));
        $start=$page->firstRow;
        if($start>=$totalRows){
            $start=$page->totalRows-$page->listRows;
        }
        if($start<=0){
            $start=0;   
        }
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $rows=$this->where($wheres)->limit($start,$page->listRows)->select();
        //改变数据库查询出来的记录的钩子方法
        $this->_changeItem($rows);
        $pageHTML=$page->show();
        return array("pageHTML"=>$pageHTML,"rows"=>$rows);
    } 
    //实现上面的钩子方法
    public function _changeItem($rows){
        
    }
    //根据会员ID以及需要筛选的日期查询出 提现记录
    public function getRowsByDate($member_id="",$date1="",$date2=""){
        $sql="select * from cash where member_id={$member_id} and withdrawal_formdate>='{$date1}' and withdrawal_formdate<='{$date2}'";
        $rows=$this->query($sql);
        foreach ($rows as &$row) {
            $row["withdrawal_date"]=date("Y-m-d H:i:s",$row["withdrawal_date"]);
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
    public function getTotals($member_id, $checked="")
    {
    	if($checked !== "")$checked = " AND ".$checked;
    	return floatval($this->where("`member_id`='".$member_id."'".$checked)->sum("`withdrawal_amount`"));
    }
}
