<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

/**
 * Description of CashController
 *
 * @author Administrator
 */
class ApplyController extends \Think\Controller{
    public function index(){
        $goodsApplies = M('goodsApply')->where(['state'=> 0])->select();
        $this->assign('goodsApplies', $goodsApplies);
        $members = M('members')->select();
        $members = subscriptArray($members, 'id');
        $this->assign('members', $members);
        $goods = M('goods')->select();
        $goods = subscriptArray($goods,'id');
        $this->assign('goods',$goods);
        $this->display();
    }

    public function applyAgree(){
    	$flag = 0;
    	$id = I('id', 0);
    	$goodsApply = M('goodsApply');
    	$data = $goodsApply->where("id={$id}")->find();
    	if(isset($data['state']) && $data['state'] == 0){
    		if($goodsApply->where("id={$id}")->save(['state' => 1])){
    			$flag = 1;
    		}
    	}
    	$this->ajaxReturn($flag);
    }

    public function applyRefuse(){
    	$flag = 0;
    	$id = I('id', 0);
    	$goodsApply = M('goodsApply');
    	$data = $goodsApply->where("id={$id}")->find();
    	if(isset($data['state']) && $data['state'] == 0){
    		if($goodsApply->where("id={$id}")->save(['state' => -1])){
    			$flag = 1;
    		}
    	}
    	$this->ajaxReturn($flag);
    }
}
