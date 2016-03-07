<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Controller;

/**
 * Description of UserinfoController
 *123
 * @author Administrator
 */
class MembersController extends BaseController{
    //实现改变where里面的条件的 钩子方法
    protected function _setWheres(&$wheres,&$order){
    	if($id = I("get.member_id"))
    	$wheres = array("id"=>$id);
		//var_dump($where);
    }
    //根据用户名 查出对应的会员ID
    public function getMembersId(){
        $name=$_POST["name"];
        $membersModel=D("Members");
        $id=$membersModel->getFieldByUsername($name,'id');
        $mes=$id?$id:0;
        $this->ajaxReturn($mes);
    }
    //在会员界面显示的时候，还需要查询出当前会员所对应的 产品数量
    /*
    protected function _before_index_view($result) {
        //根据result里面的id去查询出对应的 产品数量
        $goods = M("MembersProduct")->group('members_id')->getField('members_id,count(goods_id)');
        foreach ($result["rows"] as &$row){
            $row["num"]=$goods[$row['id']] | 0;
        }
        $this->assign($result);
    }
     */
    //改变 会员状态
    public function changeState($id,$flag){
        $this->model->where("id={$id}")->setField('state',$flag);
        $this->ajaxReturn(1);
    }
    //修改会员的信息 
    public function modifyMemberInfo($id=""){
            $info=$this->model->where("id={$id}")->find();
            $this->ajaxReturn($info);
    }
    public function test(){
        $data=I("post.");
        //执行更新
        if($this->model->create()!==false){
            $res=$this->model->excuteUpdate($this->model->data());
            $mes=($res!==false)?1:$res;
            $this->ajaxReturn($mes);
        }else{
            $error=$this->model->getError();
            $this->ajaxReturn($error);
        }
//        $res=$this->model->excuteUpdate($data);
//        $mes=($res!==false)?1:$res;
//        $this->ajaxReturn($data);
    }
}
