<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Model;

/**
 * Description of MembersModel
 *会员信息的模型层1
 * @author Administrator
 */
class MembersModel extends BaseModel{  
    //array(验证字段1,验证规则,错误提示,[验证条件,附加规则,验证时间]),
   protected $_validate = array(
       array('username','require','管理员账号必须填写！'), // 在新增的时候验证name字段是否唯一     
       array('username','','帐号名称已经存在！',0,'unique',2),  // 在新增的时候验证name字段是否唯一     
       array('password',"6,64",'密码长度为不低于6位',0,'length',2), // 当值不为空的时候判断是否在一个范围内
       array('qq',"require",'qq号码必须填写！'),
       array('tel',"require",'手机号码必须填写！'),
       array('tel',"11,11",'手机号码必须为11位！',0,'length',2),
       array('email',"require",'邮箱必须填写！'),
       array('payee',"require",'收款人必须填写！'),
       array('bank_name',"require",'所属银行必须填写！'),
       array('bank_account',"require",'银行账户必须填写！')
    );     
    protected function _query($action){
        if($action=='index')
            return $this->join("LEFT JOIN `members_product` ON `members_product`.`members_id`=`members`.`id`")
                        ->field("count(members_product.id) AS num,members.*")
                        ->where(I("get.member_id")?"members.id=".I("get.member_id"):'')
                        ->group('`members`.`id`');
        return $this;
    }
    //统计当前会员的总的数量
    public function membersNum(){
        $sql="select count(*) as num from  members";
        $res=$this->query($sql);
        return $res[0]["num"];
    } 
    //后台修改个人信息，根据ID判断是否有更改过密码
    private function checkPassword($id="",$password=""){
        $passwords=$this->getFieldById($id,"password");
        return $passwords==$password?1:0;
    }
    //执行更新
    public function excuteUpdate($data=array()){
        $res=$this->checkPassword($data["id"],$data["password"]);
        $id=$data['id'];
        if($res){
            $mes=$this->where("id={$id}")->save($data);
        }else{
            $data["password"]=md5($data["password"]);
            $mes=$this->where("id={$id}")->save($data);
        }   
        return $mes;
    }
}
