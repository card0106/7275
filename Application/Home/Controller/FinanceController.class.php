<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;

/**
 * Description of FinanceController
 *财务明细模块
 * @author Administrator
 */
class FinanceController extends \Think\Controller{
    //展示“财务明细”
    public function detail(){
        $member_id=  $this->getMemberId();
        //从提现记录表中 查找出该会员的提现记录
      	
	    $date_begin = $_POST["date_begin"] ? strtotime($_POST["date_begin"]) : mktime(0,0,0)-604800;
	    $date_end = $_POST["date_end"] ? strtotime($_POST["date_end"])+86399 : mktime(0,0,0)+86400;
       	if($date_begin >= $date_end)
       		exit($this->success("结束时间不能大于开始时间！"));
        $cashModel=D("Cash");
       	$totalRows = $cashModel->where("member_id='{$member_id}' AND `withdrawal_date`>='{$date_begin}' AND `withdrawal_date`<'{$date_end}'")
      						 	->count();
        //分页数据
        $page=new \Think\Page($totalRows, C("PAGESIZE"));
        $start=$page->firstRow;
        if($start>=$totalRows)
            $start=$page->totalRows-$page->listRows;
        if($start<=0)
            $start=0;
        //$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $rows = $cashModel->where("member_id='{$member_id}' AND `withdrawal_date`>='{$date_begin}' AND `withdrawal_date`<'{$date_end}'")
      						 	->limit($start,$page->listRows)->select();
      	$page->setConfig('router', true);
        $pageHTML=$page->show();
        //
        $this->assign("date_begin",$date_begin);
        $this->assign("date_end",$date_end);
        
        $this->assign("pageHTML",$pageHTML);
        $this->assign("rows",$rows);
        $this->display();
    }
    //根据某个会员ID以及查询条件的日期 查询出对应的 提现记录
    public function getItemsByDate($date1,$date2){
        $member_id=  $this->getMemberId();
        $withdrawalRecordModel=D("Cash");
        $rows=$withdrawalRecordModel->getRowsByDate($member_id,$date1,$date2);
        $this->ajaxReturn($rows);
    }
    //获取当前会员的memberID
    private function getMemberId(){
        //查询出当前会员 推广数据的总数*单价=钱包总计
        $member_name=$_SESSION["membersinfo"]["username"];
        //根据会员名得到 member_id
        $membersModel=D("Members");
        $member_id=$membersModel->getFieldByUsername($member_name,"id");        
        return $member_id;
    }
}
