<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

/**
 * Description of CashController
 *123
 * @author Administrator
 */
class CashController extends \Think\Controller{
    //提现模块展示
    public function cash(){
        $cashModel=D("Cash");
        $rows=$cashModel->page();
        $this->assign($rows);
        $this->display();
    }
    //根据 会员信息传过来的member_id查询出对应的cash(提现)表中的数据
    public function record($member_id=""){
        $cashModel=D("Cash");
        $rows=$cashModel->where("member_id={$member_id}")->select();
        //根据member_id查询出对应的会员名
        $member_model=D('Members');
        foreach ($rows as &$row) {
            $row["member_name"]=$member_model->getFieldById($row['member_id'],"username");
        }
        $this->assign("rows",$rows);
        $this->assign("flag",1);
        $this->display("cash");
    }
    //审核会员提现记录
    public function checkedById($id,$checked,$amount){
        $cashModel=D("Cash");
        $totalMoneyModel=M("TotalMoney");
        if($checked!=='0'){ //允许会员提现，同时需要从total_money表中扣除金额
            $money=$totalMoneyModel->getFieldByMemberId($id,"money");
            $money-=$amount;
           $ress=$totalMoneyModel->where("member_id={$id}")->setField('money',  $money);
            if($ress!==false){
                $res=$cashModel->where("member_id={$id}")->setField("checked", $checked);
                $mes=($res!==false)?"操作成功":"操作失败";
                $this->ajaxReturn($mes);
            }else{
                $this->ajaxReturn("操作失败");
            }
        }else{
            $res=$cashModel->where("member_id={$id}")->setField("checked", $checked);
            $mes=($res!==false)?"操作成功":"操作失败";
            $this->ajaxReturn($mes);
        }
    }
    //删除提现记录
    public function delById($id){
        $cashModel=D("Cash");
        $res=$cashModel->where("id={$id}")->delete();
        $mes=($res!==false)?"删除成功":"删除失败";  
        $this->ajaxReturn($mes);
    }
    //根据日期 查询出对应的提现记录
    public function getItemsByDate($date1="",$date2=""){
        $cashModel=D("Cash");
        $rows=$cashModel->getRowsByDate($date1,$date2);
        $this->ajaxReturn($rows);
    }
}
