<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

/**
 * Description of QuestionController
 *
 * @author Administrator
 */
class QuestionController extends BaseController{
    //修改新闻信息
    public function modifyNewsInfo($id){
        $info=$this->model->where("id={$id}")->find();
        $this->ajaxReturn($info);
    }
    //执行更新新闻新息 
    public function updateInfo(){
        $data=$this->model->create();
        if($this->model->create()!==false){
            $res=$this->model->where("id={$data['id']}")->save($data);
            $mes=($res!==false)?1:$res;
            $this->ajaxReturn($mes);
        }else{
            $error=$this->model->getError();
            $this->ajaxReturn($error);
        }        
    }    
}
