<?php

namespace Admin\Controller;
//添加新
/**
 * 
 *
 * @author Administrator
 */
class GoodsController extends BaseController{

	private $_cash_type = [
				'0' => '金额',
				'1' => '分成'
			];
	private $_states = [
				'0' => '已关闭',
				'1' => '进行中'
			];
	private $_invoicing_cycle = [
				'0' => '每日',
				'1' => '每周',
				'2' => '双周',
				'3' => '每月'
			];
	private $_data_back = [
				'0' => '次日',
				'1' => '实时',
				'2' => '每周'
			];


    
    public function index(){
    	$result=$this->model->order('id desc')->page();
        $this->assign($result);
        $this->_before_index_view($result);
        $categories = M('category')->select();
        $categories = subscriptArray($categories, 'id');
    	$this->assign('cats', $categories);
    	$this->assign('states', $this->_states);
    	$this->assign('invoicing_cycle', $this->_invoicing_cycle);
    	$this->assign('data_back', $this->_data_back);
    	$this->assign('cashType', $this->_cash_type);
    	$this->display();
    }

    public function add(){
    	if(IS_POST){
    		$model = D('goods');
    		$model->create();
    		if(isset($_FILES['logo']['name'])){
    			$result = uploadImage($_FILES['logo'], 'goods');
    			if(empty($result['errorInfo']) && $result['filePath']){
    				$model->goods_big_img = $result['filePath'];
    				$model->goods_small_img = thumbImage($result['filePath']);
    			}else{
    				$this->error($result['errorInfo']);
    			}
    		}
    		if($model->add() !== false){
    			$this->success('保存成功', U('Admin:Goods/index'));
    		}
            $this->error("操作失败");
        }
    }

    public function edit(){
    	$id = I('id', 0);
    	if(IS_POST){
    		if($id > 0){
    			$model = M('goods');
	    		$model->create();
	    		if(!empty($_FILES['logo']['tmp_name'])){
	    			$result = uploadImage($_FILES['logo'], 'goods');
	    			if(empty($result['errorInfo']) && $result['filePath']){
	    				$model->goods_big_img = $result['filePath'];
	    				$model->goods_small_img = thumbImage($result['filePath']);
	    			}else{
	    				$this->error($result['errorInfo']);
	    			}
	    		}
	    		if($model->where("id={$id}")->save() !== false){
	    			$this->success('修改成功', U('Admin:Goods/index'));
	    		}else{
	    			$this->error('修改失败');
	    		}
    		}else{
    			$this->error('参数错误');
    		}
    	}else if($id > 0){
    		$condition['id'] = $id;
    		$goods = M('goods')->where($condition)->find();
    		if(empty($goods)){
    			$this->error('该产品不存在');
    		}else{
    			$categories = M('category')->select();
		    	$this->assign('cats', $categories);
		    	$this->assign('states', $this->_states);
		    	$this->assign('invoicing_cycle', $this->_invoicing_cycle);
		    	$this->assign('data_back', $this->_data_back);
		    	$this->assign('cashType', $this->_cash_type);
    			$this->assign('row', $goods);
    			$this->display();
    		}
    	}else{
    		$this->error('参数错误');
    	}
    }

    //根据ID删除一行记录
    public function delGoods(){
        $productModel=D("goods");
        $id=$_POST["id"];
        $res=$productModel->where("id={$id}")->delete();
        if($res!==false) $this->ajaxReturn (1);
    }   

    //根据ID操作关闭或者置顶
    public function control(){
        $id=I("post.id",0,"intval");
        $type=I("post.type",0,"intval");
        $val=I("post.val",0,"intval");
        if($id==0)exit;
        //$model = D("Product")->where("id={$id}");
        $res = false;
        if($type==1){
       		$res=D("goods")->where("`id`='{$id}'")->setField("top_time",$val==1?time():0);
        }else
        if($type==0){
       		$res=D("goods")->where("`id`='{$id}'")->setField("state",$val==1?1:0);
        }
        $this->ajaxReturn ($res!==false?1:0);
    }   

    public function links(){
    	$id = I('id', 0);
    	if($id > 0){
    		$categories = M('category')->select();
	    	$this->assign('cats', $categories);
	    	$this->assign('states', $this->_states);
	    	$this->assign('invoicing_cycle', $this->_invoicing_cycle);
	    	$this->assign('data_back', $this->_data_back);
	    	$this->assign('cashType', $this->_cash_type);
	    	$this->assign('id', $id);
    		$goods = M('goods')->where("id={$id}")->find();
    		$this->assign('goods', $goods);

    		$links = M('goodsLink')->where("goods_id={$id}")->order('id desc')->select();
    		$this->assign('links', $links);

    		$members = M('members')->where("state=1")->select();
    		$members = subscriptArray($members, 'id');
    		$this->assign('members', $members);
    		$this->display();
    	}else{
    		$this->error('参数错误');
    	}
    }

    public function addLink(){
    	if(IS_POST){
    		$goods_id = I('goods_id', 0);
    		if($goods_id > 0){
    			$goods = M('goods')->where("id={$goods_id}")->find();
    			if($goods['max_links'] > $goods['effective_links']){
    				$model = M('goodsLink');
    				$model->create();
    				$model->state = 1;
					if(!empty($_FILES['soft']['tmp_name'])){
    					$result = uploadSoftPack($_FILES['soft'], 'download');
    					if(empty($result['errorInfo']) && $result['filePath']){
		    				$model->link_url = $result['filePath'];
		    			}else{
		    				$this->error($result['errorInfo']);
		    				exit;
		    			}
    				}
    				if($model->add() !== false){
    					$this->success('保存成功');
    					exit;
		    		}else{
		    			$this->error('添加失败');
		    			exit;
		    		}
    			}else{
    				$this->error('超过最大链接数');
    				exit;
    			}
    		}else{
    			$this->error('参数错误');
    			exit;
    		}
        }else{
        	$this->error('请求方式错误');
    }
}
  public function  editLink(){
        if(IS_GET){
            $id=I('get.id',0);
            if($id>0){
                
            }
        }
      $this->assign('id',$id); 
      $this->display();
  } 
       public function editData(){
          $this->display();
       }
}