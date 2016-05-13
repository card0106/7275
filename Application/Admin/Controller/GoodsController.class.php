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
                  '1'  => '元/千ip检索',
                  '2'  => '元/千ip搜索',
                  '3'  => '元/激活',
                  '4'  => '元/CPA',
                  '5'  => '元/CPS',
                  '6'  => '元/CPC'
             ];

    public function getAdminId(){
                $userinfo = I('session.userinfo',0);
                $userid = $userinfo['id'];
                return $userid;
    }
    public function index(){
    	$result=$this->model->order('id desc')->page();
        $this->assign($result);
        $this->_before_index_view($result);
        $categories = M('category')->select();
        $categories = subscriptArray($categories, 'id');
     $this->assign('measure',$this->_measure);    
    	$this->assign('cats', $categories);
    	$this->assign('states', $this->_states);
    	$this->assign('invoicing_cycle', $this->_invoicing_cycle);
    	$this->assign('data_back', $this->_data_back);
    	$this->assign('cashType', $this->_cash_type);
    	$this->display(); 

    }
    

    public function add(){
        if(IS_POST){
                //$userinfo = I('session.userinfo',0);
                //$userid = $userinfo['id'];
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
                $res = $model->add();
                if($res !== false){

                        $record2 = serialize($model->where("id=$res")->find());
                        $this->record($this->getAdminId(),1,'goods',$res,'',$record2);
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
             $record1=serialize($model->where("id=$id")->find());
        
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
	    		if($res=$model->where("id={$id}")->save() !== false){
                  $record2=serialize($model->where("id=$id")->find());
	    			$this->record($this->getAdminId(),2,'goods',$id,$record1,$record2);
                  
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
        $record1=serialize($productModel->where("id=$id")->find());       
        $res=$productModel->where("id={$id}")->delete();
        if($res!==false){
            M('goods')->where("id={$goods_id}")->setInc('effective_links', -1);
            $this->record($this->getAdminId(),3,'goods',$id,$record1,'');
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
         $categories = subscriptArray($categories, 'id');
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
                  $res = $model->add();
    				if($res !== false){
                        M('goods')->where("id={$goods_id}")->setInc('effective_links', 1);
                      $record2=serialize($model->where("id=$res")->find()); 
                      $this->record($this->getAdminId(),1,'goods_link',$res,$old_data='0',$record2); 
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
                /*$data['link_url']=I('post.link_url');
                $data['discount']=I('post.discount');
                $data['site_name']=I('post.site_name');
                $data['members_id']=I('post.members_id'); */                          
                // var_dump($data);
                //exit;
                $model=M('goodsLink');

                $record1=serialize($model->where("id=$good_id")->find());
                $model->create(); 
                if($model->where("id=$good_id")->save() !== false){
                    $goods_link['id']=$good_id;
                    $goods_link=M('goodsLink')->where($goods_link)->find();
                    $record2=serialize($goods_link);
                    $this->record($this->getAdminId(),2,'goods_link',$good_id,$record1,$record2);

                    $this->success('修改成功', U('Admin:Goods/links?id='. $goods_link['goods_id']));                   
                }else{
                    $this->error('修改失败');
                }
            }else{
                $this->error('修改失败,上游价格小于下游价格');
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
                $goods = M("goods")->where("id={$goods_link['goods_id']}")->find();
                $this->assign('members', $members);
    			$this->assign('categories',$categories);	
                $this->assign('goods_link',$goods_link);
                $this->assign('goods', $goods);
                $this->display();
            }
        } 
    }
     
    public function editData(){
         //date_default_timezone_set('PRC');
         if(IS_POST){
             $data_time = I('date', 0);                        
             $id = I('id', 0);
             $click_num = I('click_num',0);
             $model = M('dataList');
             
             if($result=$model->where("good_link_id = '$id' and data_time = '$data_time'")->find()){                                             
                     $this->ajaxReturn('-1');
                       exit;   
             }else{
                  $link = M('goodsLink')->where("id=$id")->find();
                  $data['data_list'] = $click_num;
                  $data['good_link_id'] = $id;
                  $data['up_price_1'] = $link['up_price_1'];
                  $data['down_price_1']=$link['down_price_1'];
                  $data['data_time'] = $data_time; 
                  $data['members_id'] = $link['members_id'];
                  $data['discount'] = $link['discount'];
                  $data['create_time'] = date('Y-m-d h:i:s'); 
                  $goods = M('goods');
                  $goods_id = $link['goods_id'];
                  $type = $goods->where("id=$goods_id")->find();
                  $data['cash_type'] = $type['cash_type'];

                 
                  //$data['percent ']=$goods['percent'];
                  $model->create($data);
                  $res = $model->add();
                  if($res !== false){
                       
                       $record1 = serialize($model->where("id=$res")->find());
                       $this->record($this->getAdminId(),1,'data_list',$res,$record1,'');
                       $this->ajaxReturn('1');
                       exit;
                  }else{
                       $this->ajaxReturn('-1');
                       exit;
                  }

             }
             
         }else{
            $link_id = I('get.id');                     
            $link = M('goodsLink')->where("id={$link_id}")->find();
            $this->assign('link',$link);

            $members_id = $link['members_id'];
            $members = M('members')->where("id=$members_id")->find();
            $username = $members['username'];            
            $this->assign('username',$username);

            //$data = M('dataList')->where("good_link_id={$link_id}")->order("data_time  DESC")->select();
            $datalist = M('dataList');
            $count = $datalist->where("good_link_id={$link_id}")->order("data_time  DESC")->count();
            $Page       = new \Think\Page($count,5);
            $show       = $Page->show();
            $list = $datalist->where("good_link_id={$link_id}")->order("data_time  DESC")->limit($Page->firstRow.','.$Page->listRows)->select();
            //dump($show);
            //exit;
            $this->assign('list',$list);
            $this->assign('page',$show);
            $this->display();
         }
    }
    public function dataEdit(){
            if(IS_POST){
                //echo "123456";
                $id = I('post.id');
                $link_id = I('post.link_id');
                //dump($id);
                //exit;
                $data = M('dataList');
                $record1 = serialize($data->where("id=$id")->find());
                $data->create();
                if($data->where("id=$id")->save()!== false){

                    $record2 = serialize($data->where("id=$id")->find());
                    $this->record($this->getAdminId(),2,'data_list',$id,$record1,$record2);
                    $this->success('修改成功', U('Admin:Goods/editData?id='.$link_id));
                }else{
                    $this->error('修改失败');
                }
                
                
            }else{
                $data_id = I('get.id');
                $data = M('dataList')->where("id={$data_id}")->find();
                //dump($data);
                $check['id'] = $data_id;
                $check['good_link_id'] = $data['good_link_id'];
                $check['data_time'] = $data['data_time'];
                $check['click_num'] = $data['click_num'];              
                
                $this->assign('check',$check);
                $this->display();
            }
        }

    public function record($admin_id=0,$record=0,$table,$table_id=0,$old_data='0',$new_data='0'){
            $recordModel = M('Record');
            $data['admin_id'] = $admin_id;
            $data['record'] = $record;
            $data['table'] = $table;
            $data['table_id'] = $table_id;
            $data['old_data'] = $old_data;
            $data['new_data'] = $new_data;
            $data['time'] = date('Y-m-d h:i:s');            
            $list=$recordModel->create($data);
            
            //dump($list);
            //exit;
                if($recordModel->add() !== false){
                //$this->success('保存成功');

            }else{
                $this->error('记录添加失败');
            }

        }
    public function recordList(){

            $model = M('record');
            //$recordList=$model->where("table=goods")->select();
            $cat = M('category')->select();
            $admin = M('admin')->select();
            $admin = subscriptArray($admin, 'id');          
            $cat = subscriptArray($cat,'id');
            $totalRows = $model->where("`table`='goods'")->order("time desc")->count();
            $page=new \Think\Page($totalRows, C("PAGESIZE"));
            $start=$page->firstRow;
            if($start>=$totalRows)
                    $start=$page->totalRows-$page->listRows;
            if($start<=0)
                    $start=0;

            $rows = $model->where("`table`='goods'")->order("time desc")->limit($start,$page->listRows)->select();      
                //echo $goods->getLastSql();
        


            //$page->setConfig('router', strtolower('/'.ACTION_NAME.$catid).'_[PAGE]');
            $pageHTML=$page->show();

            $this->assign('admin',$admin);
            $this->assign('cat',$cat);
            $this->assign('rows',$rows);
            $this->assign('pageHTML',$pageHTML);
            $this->display();
            //$this->assign('goods', $recordList);
           
            /*
            for($i=0;$i<count($recordList); $i++){
                if($recordList[$i]['table']=='goods'){
                    dump($recordList[$i]);

                    $this->assign('goods', $recordList[$i]);
                    
                }
                //dump($recordList[$i]['table']);
                //dump(unserialize($recordList[$i]['old_data']));

                foreach($recordList[$i] as  $key=>$value){
                        echo $value;
                }
            }*/
             }
    public function recordgoodlink(){

            $model = M('record');
            //$recordList=$model->select();
            $cat = M('category')->select();
            $admin = M('admin')->select();
            $admin = subscriptArray($admin, 'id');          
            $cat = subscriptArray($cat,'id');
            $totalRows = $model->where("`table`='goods_link'")->order("time desc")->count();
            $page=new \Think\Page($totalRows, C("PAGESIZE"));
            $start=$page->firstRow;
            if($start>=$totalRows)
                    $start=$page->totalRows-$page->listRows;
            if($start<=0)
                    $start=0;

            $rows = $model->where(`table`=='goods_link')->order("time desc")->limit($start,$page->listRows)->select();      
                //echo $goods->getLastSql();
        


            //$page->setConfig('router', strtolower('/'.ACTION_NAME.$catid).'_[PAGE]');
            $pageHTML=$page->show();

            $this->assign('admin',$admin);
            $this->assign('cat',$cat);
            $this->assign('rows',$rows);
            $this->assign('pageHTML',$pageHTML);
            $this->display();
            } 
    public function recorddatalist(){

            $model = M('record');
            //$recordList=$model->select();
            $cat = M('category')->select();
            $admin = M('admin')->select();
            $admin = subscriptArray($admin, 'id');          
            $cat = subscriptArray($cat,'id');
            $totalRows = $model->where("`table`='data_list'")->order("time desc")->count();
            $page=new \Think\Page($totalRows, C("PAGESIZE"));
            $start=$page->firstRow;
            if($start>=$totalRows)
                    $start=$page->totalRows-$page->listRows;
            if($start<=0)
                    $start=0;

            $rows = $model->where("`table`='data_list'")->order("time desc")->limit($start,$page->listRows)->select();      
                //echo $goods->getLastSql();
        


            //$page->setConfig('router', strtolower('/'.ACTION_NAME.$catid).'_[PAGE]');
            $pageHTML=$page->show();

            $this->assign('admin',$admin);
            $this->assign('cat',$cat);
            $this->assign('rows',$rows);
            $this->assign('pageHTML',$pageHTML);
            $this->display();
            }       

}
