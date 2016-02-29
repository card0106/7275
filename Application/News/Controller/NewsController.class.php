<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace News\Controller;

/**
 * Description of NewsController
 *
 * @author Administrator
 */
class NewsController extends \Think\Controller{
    //展示新闻公告页面
    public function index(){
        //查询出新闻信息列表
        $newsModel=M("News");
        $rows=$newsModel->order("time DESC")->select();
        $this->assign("rows",$rows);
        $this->display(T('News@News/index'));
    }
    //展示常见问题下面的链接页面
    public function detail($id=""){
        //根据$id取出对应的id下面的内容
        $newsModel=M("News");
        $rows=$newsModel->where("id={$id}")->find();
        $this->assign("rows",$rows);
        $this->display(T('News@News/detail'));
    }
}
