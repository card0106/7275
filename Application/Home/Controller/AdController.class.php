<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;

/**
 * Description of AdController
 *
 * @author Administrator
 */
class AdController extends \Think\Controller{
    //展示“会员广告”页面
    public function myAd(){
        //根据会员名，查询出对应的产品members_product
        $member=$_SESSION["membersinfo"]["username"];
        //根据用户名找出对应的members_id
        $membersModel=M("Members");
        $member_id=$membersModel->getFieldByUsername($member,"id");
        //根据members_id到members_product表中查出所有的记录
        $membersProductModel=M("MembersProduct");
        $totalRows=$membersProductModel->where(array("members_id"=>$member_id))->count();
        
        //分页数据
        $page=new \Think\Page($totalRows, C("PAGESIZE"));
        $start=$page->firstRow;
        if($start>=$totalRows){
            $start=$page->totalRows-$page->listRows;
        }
        if($start<=0){
            $start=0;   
        }
        //$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $rows=$membersProductModel->where(array("members_id"=>$member_id))->limit($start,$page->listRows)->select();
        
        //循环结果集中的goods_id查出对应的goods_name
        foreach ($rows as &$row) {
            //根据每一行记录里面的goods_id查出对应的goods-name和该产品的invoicing_cycle
            $productModel=M("Product");
            $row["goods_name"]=$productModel->getFieldById($row["goods_id"],"goods_name");
            $row["invoicing_cycle"]=$productModel->getFieldById($row["goods_id"],"invoicing_cycle");
        }        
        $pageHTML=$page->show();

        $this->assign("pageHTML",$pageHTML);
        $this->assign("rows",$rows);
        $this->display();
    }
}
