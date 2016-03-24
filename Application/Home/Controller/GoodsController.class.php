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
        $goods = M('Goods');
        $rows = $goods->distinct(true)->field('category_id')->where('`state`=1')->select();
        $cats = $catMaps = array();
        foreach($rows as $key => $val){
            $cats[] = $val['category_id'];
        }
        if(count($rows) > 0){
            $catModel = M('Category');
            $cats = $catModel->where("`id` IN (".implode(",", $cats).")")->select();
            foreach($cats AS $key => $val)
                $catMaps[$val['id']] = $val['category_name'];
        }
        $catid = I("get.catid",0,'intval');
        if($catid > 0){
        //$catid = $catid!=0?$catid:2;//兼容路由空get参数，否则可直接使用I("get.catid",2,'intval');
        //$catid = intval($catMaps[$catid-1]==NULL ? $cats[0]['id'] : $catid);        
                $totalRows = $goods->where("category_id = '".$catid."' AND `state`=1")->order('`top_time` DESC')->count();

                $page=new \Think\Page($totalRows, C("PAGESIZE"));
                $start=$page->firstRow;
                if($start>=$totalRows)
                    $start=$page->totalRows-$page->listRows;
                if($start<=0)
                    $start=0;

                $rows = $goods->where("category_id = '".$catid."' AND `state`=1")->order('`top_time` DESC')->limit($start,$page->listRows)->select(); 
        }else{
                $totalRows = $goods->where("`state`=1")->order('`top_time` DESC')->count();
                $page=new \Think\Page($totalRows, C("PAGESIZE"));
                $start=$page->firstRow;
                if($start>=$totalRows)
                    $start=$page->totalRows-$page->listRows;
                if($start<=0)
                    $start=0;

                $rows = $goods->where("`state`=1")->order('`top_time` DESC')->limit($start,$page->listRows)->select();      
                //echo $goods->getLastSql();
        }


        $page->setConfig('router', strtolower('/'.ACTION_NAME.$catid).'_[PAGE]');
        $pageHTML=$page->show();
        
        $member=$_SESSION["membersinfo"]["username"]; 
        $member_id=M("Members")->getFieldByUsername($member,"id");

        $ids = array();
        foreach($rows AS $key => &$val)
            $ids[]=$val['id'];
        $product = M("goodsLink")->where(array("goods_id" => array("IN", implode($ids,","))))->select();//->getField("goods_id,down_price_1");
        
        $product = subscriptArray($product, 'goods_id');

        $condition = [
            'goods_id' => ['in', implode($ids, ",")],
            'state' => 0,
            'members_id' => $member_id
        ];
        $applyList = M('goodsApply')->where($condition)->select();

        $applyList = subscriptArray($applyList, 'goods_id');
        
        foreach($rows as &$val){
            if(isset($product[$val['id']])){
                $val['down_price_1'] = $product[$val['id']]['down_price_1'];
            }
            if(isset($applyList[$val['id']])){
                $val['applying'] = 1;
            }
        }




        
        $this->assign("pageHTML",$pageHTML);
        $this->assign("rows",$rows);
        $this->assign("cats",$cats);
        $this->assign("catid",$catid);
        $this->assign("member_id", $member_id);
        $this->display();

    }

    public function applyGoods(){
        $goods_id = I('goods_id', 0);
        $members_id = I('members_id', 0);
        if($goods_id && $members_id){
            $model = M('goodsApply');
            $model->create();
            $model->goods_id = $goods_id;
            $model->goods_link_id = 0;
            $model->members_id = $members_id;
            $model->processed = 0;
            $model->state = 0;
            if($model->add() !== false){
                echo 1;
                exit;
            }
        }
        echo 0;
    }
}
