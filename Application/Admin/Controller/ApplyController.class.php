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
        $this->display();
    }
}
