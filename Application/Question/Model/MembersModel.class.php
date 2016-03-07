<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Question\Model;

/**
 * Description of MembersModel
 *
 * @author Administrator
 */
class MembersModel extends \Think\Model{
    //重置密码
    public function resetPwd($email){
        $res=$this->where("email='{$email}'")->setField("password", md5(111111));
        return ($res!==false)?1:-1;
    }
}
