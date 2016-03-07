<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

/**
 * Description of BaseController
 *
 * @author Administrator
 */
class BaseController extends \Think\Controller{
    //查询数据用于展示
    protected $model="";
    //当构造函数执行后，自动实例化对象模型
    public function _initialize(){
        $this->model=D(CONTROLLER_NAME);
    }
    //用于展示数据表中的数据
    public function index(){
        $wheres=$order='';
        //定义一个钩子方法，改变where里面的条件
        //$this->_setWheres($wheres,$order);
        //去数据库取出数据
        $result=$this->model->page();
        //分配分页数据
        $this->assign($result);
        $this->_before_index_view($result);
        //分配每个页面的主题
        cookie("__forward__",$_SERVER["REQUEST_URI"]);
        $this->display();
    }  
    //实现改变where里面的条件的 钩子方法
    /*
    protected function _setWheres(&$wheres,&$order){

    }
     */
    //需要对分页数据里面的数据进行改造
    protected function _before_index_view($result){
        
    }
    //向数据库中 插入数据的公用方法
    //向对应数据库中插入数据,通用方法
    public function add(){
        if(IS_POST){
            //处理上传图片的钩子方法
            $this->_dealPic();
            if($this->model->create()!==false){
            	if(in_array(CONTROLLER_NAME, array("News","Question")))
            		$this->model->time = $this->model->last_modify = time();
                if($this->model->add()!==false){
                    $this->success("保存成功", cookie("__forward__"));
                    exit();
                }
            }
            $this->error("操作失败".$this->model->getError());
        }else{
            $rows=$this->_before_edit_view();
            $this->assign("row", $rows);
       		$this->assign("cats", D("Category")->select());
            $this->_before_edit_view();
            $this->display("edit");
        }
    }  
    //实现处理上传图片的钩子方法
    protected function _dealPic(){
        
    }
    //当编辑是需要进行回显
    protected function _before_edit_view(){
        
    }
   //根据一个ID查出对应的一条记录
    protected function getItemById($id){
        $row=$this->model->where("id={$id}")->find();
        return $row;
    } 
    //根据ID进行删除一行记录
    public function del(){
        //判断是否是通过Ajax进行删除的 
        if(IS_POST){
            $ids=$_POST["id"];
            $res=$this->model->where("id={$ids}")->delete();
            if($res!==false){
                $this->ajaxReturn(1);
            }else{
                $this->ajaxReturn(0);
            }
        }else{
            $res=$this->model->where("id={$id}")->delete();
            if($res!==false){
                $this->success("操作成功!",cookie("__forward__"));
            }else{
                $this->error("操作失败".$this->model->getError());
            }
        }
    }
}
