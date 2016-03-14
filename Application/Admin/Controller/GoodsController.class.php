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

    private $_measure = [
                  '0'  => '元/千检索',
                  '1'  => '元/千浏览',
                  '2'  => '元/包激活'
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
            if($model->cash_type == 0){
                $model->percent = 0;
            }
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
                if($model->cash_type == 0){
                    $model->percent = 0;
                }
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
        if($res!==false){
            M('goods')->where("id={$goods_id}")->setInc('effective_links', -1);
            $this->ajaxReturn (1);
        }
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

         $measure=M('measure')->select();
         $this->assign('mesure',$measure); 

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
                        M('goods')->where("id={$goods_id}")->setInc('effective_links', 1);
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
        $good_id=I('id',0);      
        if(IS_POST){                
            $data['up_price_1']=I('post.up_price_1');
            $data['down_price_1']=I('post.down_price_1');
            //echo $down_price_1;
            //$goods=M('goods')->where('{id=$goodid}')->find();
                                        
            if($data['up_price_1']>$data['down_price_1']){ 
                $data['link_url']=I('post.link_url');
                $data['discount']=I('post.discount');
                $data['site_name']=I('post.site_name');
                $data['members_id']=I('post.members_id');                           
                // var_dump($data);
                //exit;
                $model=M('goodsLink');
                $model->create(); 
                if($model->where("id=$good_id")->save($data) !== false){
                    $goods_link['id']=$good_id;
                    $goods_link=M('goodsLink')->where($goods_link)->find();
                    $this->success('修改成功', U('Admin:Goods/links?id='. $goods_link['goods_id']));                   
                }else{
                    $this->error('修改失败');
                }
            }else{
                echo "jiagebudi";
            }
        }else if($good_id>0){
            $goods_link['id']=$good_id;
            $goods_link=M('goodsLink')->where($goods_link)->find();
            $categories = M('category')->select();
            if(!$goods_link){
                $this->error('该产品id不存在');
            }else{
                $members = M('members')->where("state=1")->select();
                $members = subscriptArray($members, 'id');
                $this->assign('members', $members);
    			$this->assign('categories',$categories);	
                $this->assign('goods_link',$goods_link);
                $this->display();
            }
        } 
    }
     
    public function editData(){
         
         if(IS_POST){
             $data_time = I('date', 0);                        
             $id = I('id', 0);
             $click_num = I('click_num',0);
             $model = M('dataList');
             if($model->where("good_link_id = '$id' and data_time = '$data_time'")->find()){
                       $this->ajaxReturn('-1');
                       exit;
             }else{
                  $link = M('goodsLink')->where("id=$id")->find();
                  $data['data_list'] = $click_num;
                  $data['good_link_id'] = $id;
                  $data['up_price_1'] = $link['up_price_1'];
                  $data['down_price_1']=$link['down_price_1'];
                  $data['data_time'] = $data_time; 
                  $goods = M('goods');
                  $goods_id=$link['goods_id'];
                  $type=$goods->where("id=$goods_id")->find();
                  $data['cash_type']=$type['cash_type'];
                  //$data['percent ']=$goods['percent'];
                  $model->create($data);
                  $res = $model->add();
                  if($res !== false){
                       $this->ajaxReturn('1');
                       exit;
                  }else{
                       $this->ajaxReturn('-1');
                       exit;
                  }

             }
             
         }else{
            $link_id=I('get.id');                     
            $link=M('goodsLink')->where("id={$link_id}")->find();
            $this->assign('link',$link);
            $this->display();
         }
    }
}
