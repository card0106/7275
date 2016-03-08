<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Home\Controller;

/**
 * Description of UserinfoController
 *
 * @author Administrator
 */
class UserinfoController extends \Think\Controller{
    //用户登录成功之后，展示用户相关信息
    public function userInfo($withdrawal_amount=""){

        //查询出当前会员 推广数据的总数*单价=钱包总计
        $member_name=$_SESSION["membersinfo"]["username"];
        //根据会员名得到 member_id
        $membersModel=D("Members");
        $member=$membersModel->getByUsername($member_name);
    	$member["enter_time"] = date("Y-m-d H:i:s", $member["enter_time"]);
        $member["client_ip"] = long2ip($member["client_ip"]);
        $this->assign("member",$member);
        
        //根据会员ID查出他对某一个产品的 推广数
        $productDataModel=D("ProductData");
        //当会员第一次登陆的时候，需要计算出它的总额
        $money = array();
        $money['yesterday'] = $productDataModel->getTotals($member["id"], date("Y-m-d", mktime(0,0,0)-86400));
        	//$productDataModel->join("LEFT JOIN `product` ON `product`.`id`=`product_data`.`goods_id`")
        	//							->where("`member_id`='".$member["id"]."' AND DATE(`time`)='".date("Y-m-d")."'")
        	//							->sum('`product`.`down_price_1`*`promote_num`');
        //$money['yesterday'] = floatval($money['yesterday']);
        
        $money['total'] = $productDataModel->getTotals($member["id"]);
        	//join("LEFT JOIN `product` ON `product`.`id`=`product_data`.`goods_id`")
        	//							->where("`member_id`='".$member["id"]."'")
        	//							->sum('`product`.`down_price_1`*`promote_num`');
        //$money['total'] = floatval($money['total']);
        
        $withdrawalMoneys = D("Cash")->getTotals($member["id"], "`checked`!=-1");
        $totalMoneys = $money['total'];
        
        $money['notpay'] = $totalMoneys - $withdrawalMoneys;
        
	    $this->assign("money",$money);
        //print_r($money);
        $this->display();
    }
    public function individual($edit=""){
        $member_name=$_SESSION["membersinfo"]["username"];
        if(IS_POST){
	        $membersModel=D("Members");

		//$photo=$_POST['photo'];

		if($_FILES['photo']['error']<4){    //查看上传文件错误值
			$cfg= array(
				'rootPath'      =>  './Uploads/', //保存根路径
				'maxSize'       =>  0 //上传的文件大小限制 (0-不做限制)
			);
			$up=new \Think\Upload($cfg);	//实例化上传类
			$z=$up->uploadOne($_FILES['photo']);	//上传方法
			//dump($up->getError());	//获取上传错误信息			
			//dump($z);
			$_POST['photo_url']=$up->rootPath.$z["savepath"].$z["savename"];
			}
		//dump($_FILES);  查看上传文件属性；
		//exit;
	        $data = array(	'qq' => $_POST['qq'],
				'tel' => $_POST['tel'],
				'email' => $_POST['email'],
				'bank_name' => $_POST['bank_name'],
				'bank_account' => $_POST['bank_account'],
				'bank_addr' => $_POST['bank_addr'],
				'zhifubao' =>$_POST['zhifubao'],
				'photo_url'=>$_POST['photo_url']
	        				);
		
	
	        //$data=$membersModel->create();
	        $succeed = $membersModel->where("username='{$member_name}'")->save($data);
	        if($succeed!==false){
	        	$this->success("修改成功！");
	        }else{
	        	$this->success("修改失败！");
	        }
	        exit;
        }else{
	    	$edit = $edit!=="";
	        $this->assign("edit",$edit);
	        
	        $membersModel=D("Members");
	        $member=$membersModel->getByUsername($member_name);
	        
	    	$member["enter_time"] = date("Y-m-d H:i:s", $member["enter_time"]);
	        $member["client_ip"] = long2ip($member["client_ip"]);
	        $this->assign("member",$member);
	        
	        $this->display();
        }
    }
    public function pass(){
        if(IS_POST){
        	$rules = array(
					array('oldpass','require','旧密码必须填写！',1),
					array('oldpass',"6,20",'请设置6位以上的密码',0,'length'),
					array('password','require','新密码必须填写！',1),
					array('password',"6,20",'请设置6位以上的密码',0,'length'),
					array('password',$_POST['oldpass'],'新密码与旧密码相同！',1,'notequal'),
					array('password','passwordre','两次密码输入不一致',1,'confirm')
					);
	        $membersModel=D("Members");
	        if(!$membersModel->validate($rules)->create())
	        	exit($this->success($membersModel->getError()));
	        else
	        {
	        	$username=$_SESSION["membersinfo"]["username"];
	        	$row = $membersModel->getByUsername($username);
	            if($row['password'] !== md5($_POST['oldpass']))
		        	exit($this->success("原始密码错误！"));
	   		    $succeed = $membersModel->where("username='".$username."'")->setField('password', md5($_POST['password']));
	   		    if($succeed){
	        		$this->success("密码修改成功！");
	   		    }else{
	        		$this->success("密码修改失败！");
	   		    }
	   		    exit;
	        }
        }
	    $this->display();
    }
    public function shenqingtixian(){
	   	$username=$_SESSION["membersinfo"]["username"];
	    $membersModel=M("Members");
       	$member=$membersModel->getByUsername($username,"id");
       	
        $withdrawalMoneys = D("Cash")->getTotals($member["id"]);
        $totalMoneys = D("ProductData")->getTotals($member["id"]);
        
        $member['notpay'] = $totalMoneys - $withdrawalMoneys;
	   	if(IS_POST){
        	$money = floatval($_POST['money']);
        	if($money <= 0.0 || $money > $member['notpay'])
	        	exit($this->success("金额错误，本次可提现的最大金额为￥{$member['notpay']}元人民币！"));
            //需要向cash表中添加当前会员的提现数据
            $data=array(
                "member_id"=>$member["id"],
                "withdrawal_amount"=>$money,
                "withdrawal_date"=>  time(),
                "withdrawal_formdate"=> date("Y-m-d",time())
            );
            $withdrawalRecordModel=D("Cash");
            $id=$withdrawalRecordModel->add($data);
            if($id){    //添加提现记录成功
                $this->success("提现申请成功，等待审核！",U("userInfo"));
            }else{
                $this->error("提现申请失败,请稍后在申请！",U("userInfo"));
            }
	   		exit;
        }else{
	        $this->assign("member",$member);
		    $this->display();
        }
    }
}
