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

    private $_cash_type = [
                '0' => '金额',
                '1' => '分成'
            ];
    private $_states = [
                '0' => '已关闭',
                '1' => '进行中'
            ];
    private $_invoicing_cycle = [
                '0' => '每日',
                '1' => '每周',
                '2' => '双周',
                '3' => '每月'
            ];
    private $_data_back = [
                '0' => '次日',
                '1' => '实时',
                '2' => '每周'
            ];

    private $_measure = [
                  '0'  => '元/千检索',
                  '1'  => '元/千浏览',
                  '2'  => '元/包激活'
             ];
    private $host_url = 'http://xs.7275.com';


    public function myAd(){
        $member=$_SESSION["membersinfo"]["username"];
        $this->assign('member',$member);
        $membersModel=M("Members");
        $member_id=$membersModel->getFieldByUsername($member,"id");
        $goodsLink = M('goodsLink')->where("members_id={$member_id}")->select();
        $goods_ids = [];
        foreach($goodsLink as $value){
            $goods_ids[] = $value['goods_id'];
        }
        $goods_ids = array_unique($goods_ids);
        if($goods_ids){
            $goods_ids = implode(',', $goods_ids);
            $goods = M('goods')->where("id in ({$goods_ids})")->order('id desc')->select();
            $goods = subscriptArray($goods, 'id');
        }
        foreach($goodsLink as $value){
            $goods[$value['goods_id']]['links'][] = $value;
        }
        $this->assign('goods', $goods);

        $cates = M("category")->select();
        $cates = subscriptArray($cates, 'id');
        $this->assign('cates', $cates);
        $this->assign('invoicing_cycle',$this->_invoicing_cycle);
        $this->assign('host_url', $this->host_url);
        $this->display();
    }
}
