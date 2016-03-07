<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Model;

/**
 * Description of BaseModel
 *123
 * @author Administrator
 */
class BaseModel extends \Think\Model{
    //put your code here
    protected $_validate        =   array(
            );  // 自动验证定义  
    
    protected $_auto     =array(
       );    
    //分页模型层
    public function page() {
        $query = clone $this->_query(ACTION_NAME);
        //var_dump($this);
        //var_dump(ACTION_NAME);
        //exit;
        $totalRows = $query->count();
        //数据开始显示的开始位置
        //开始分页
        $page=new \Think\Page($totalRows, C("PAGESIZE"));
        $start=$page->firstRow;
        if($start>=$totalRows){
            $start=$page->totalRows-$page->listRows;
        }
        if($start<=0){
            $start=0;   
        }
        $page->setConfig('theme','%FIRST% %UP_PAGE% %LINK_PAGE% %DOWN_PAGE% %END%');
        $rows=$this->limit($start,$page->listRows)->select();
        //改变数据库查询出来的记录的钩子方法
        $this->_changeItem($rows);
        $pageHTML=$page->show();
        return array("pageHTML"=>$pageHTML,"rows"=>$rows);
    } 
    protected function _query($action){
        return $this;
    }
    //实现>>2的钩子方法
    protected function _changeItem(&$rows){
        
    }
}
