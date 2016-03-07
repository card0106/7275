<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;

/**
 * Description of GoodsController
 *
 * @author Administrator
 */
class GoodsController extends \Think\Controller{
    //展示获取产品
    public function getGoods(){
        //根据会员名，查询出对应的产品members_product
//        $member=$_SESSION["membersinfo"]["username"]; 
//        //根据用户名找出对应的members_id
//        $membersModel=M("Members");
//        $member_id=$membersModel->getFieldByUsername($member,"id");
//        
//        //根据members_id到members_product表中查出所有的记录
        $productModel=M("Product");
		$rows = $productModel->distinct(true)->field('category_id')->where('`state`=1')->select();
		$cats = $catMaps = array();
		foreach($rows AS $key => $val)
			$cats[] = $val['category_id'];
		if(count($rows)>0){
       		$catModel=M("Category");
			$cats = $catModel->where("`id` IN (".implode(",", $cats).")")->select();
			foreach($cats AS $key => $val)
				$catMaps[$val['id']] = $val['category_name'];
		}
		$catid = I("get.catid",0,'intval');
		$catid = $catid!=0?$catid:2;//兼容路由空get参数，否则可直接使用I("get.catid",2,'intval');
		$catid = intval($catMaps[$catid-1]==NULL ? $cats[0]['id'] : $catid);
        //$productModel=M("Product");
        $totalRows=$productModel->where("category_id = '".$catid."' AND `state`=1")->order('`top_time` DESC')->count();
        /*
		$rows = $productModel->distinct(true)->field('category_id')->select();
		$cats = array();
		foreach($rows AS $key => $val)
			$cats[] = $val['category_id'];
        $catModel=M("Category");
        */
        //分页数据
        $page=new \Think\Page($totalRows, C("PAGESIZE"));
        $start=$page->firstRow;
        if($start>=$totalRows)
            $start=$page->totalRows-$page->listRows;
        if($start<=0)
            $start=0;
        //$page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $rows=$productModel->where("category_id = '".$catid."' AND `state`=1")->order('`top_time` DESC')->limit($start,$page->listRows)->select(); 
//        echo "<pre>";
//        die(var_dump($rows));
//        //循环结果集中的goods_id查出对应的goods_name
//        foreach ($rows as &$row) {
//            //根据每一行记录里面的goods_id查出对应的goods-name和该产品的invoicing_cycle
//            $row["goods_name"]=$productModel->getFieldById($row["goods_id"],"goods_name");
//            $row["invoicing_cycle"]=$productModel->getFieldById($row["goods_id"],"invoicing_cycle");
//            $row["data_back"]=$productModel->getFieldById($row["goods_id"],"data_back");
//            $row["intro"]=$productModel->getFieldById($row["goods_id"],"intro");
//        } 
		$page->setConfig('router', strtolower('/'.ACTION_NAME.$catid).'_[PAGE]');
        $pageHTML=$page->show();
        
        $member=$_SESSION["membersinfo"]["username"]; 
        $member_id=M("Members")->getFieldByUsername($member,"id");
        $ids = array();
        foreach($rows AS $key => &$val)
        	$ids[]=$val['id'];
        $product = D("MembersProduct")->where(array("members_id"=>$member_id,"goods_id" => array("IN", implode($ids,","))))->getField("goods_id,dprice1,dprice2,dprice3");
		foreach($product AS $key => &$val)
		{
			$row = &$rows[array_search($key, $ids)];
			$row['down_price_1'] = $val['dprice1'];
			$row['down_price_2'] = $val['dprice2'];
			$row['down_price_3'] = $val['dprice3'];
			$row['have'] = true;
		}
        $this->assign("pageHTML",$pageHTML);
        $this->assign("rows",$rows);
        $this->assign("cats",$cats);
        $this->assign("catid",$catid);
        $this->display();
    }
}
