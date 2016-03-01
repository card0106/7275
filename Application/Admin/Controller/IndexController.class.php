<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller{
    //后台首页，默认展示”基本信息“
    public function index(){
        //统计联盟会员的 数量以及 产品的数量
        $membersModel=D("Members");
        $productModel=D("Product");
        $productDataModel=D("ProductData");
        
        $membersNum=$membersModel->count() | 0;//membersNum();
        $goodsNum=$productModel->count() | 0;//goodsNum();
        //需要分配昨日利润、上周利润、本月利润、上月利润
        $yestDayProfits=$productDataModel->yestDayProfits();
        $thisMonthProfits=$productDataModel->thisMonthProfits();
        $lastMonthProfits=$productDataModel->lastMonthProfits();
        $thisWeekProfits=$productDataModel->thisWeekProfits();
        
        
        $date_begin = mktime(0,0,0)-16*86400;
        $date_end = mktime(0,0,0)-1;
        $charts = array();
        $charts['series']['name'] = "全系产品";
        $charts['title'] = "最近15日收益走势";
        $charts['subtitle'] = date("Y-m-d",$date_begin)." 至 ".date("Y-m-d",$date_end);
        $rows=D("ProductData")->alias('data')
                ->field('SUM(`data`.`umoney`-`data`.`money`) AS union_price,`data`.`time`')
                ->group("DATE(FROM_UNIXTIME(`data`.`time`))")
                ->order("`data`.`time` ASC")
                ->select();
        foreach($rows AS $val)
        {
            $charts['categories'][] = date("Y-m-d", $val['time']);
            $charts['series']['data'][] = $val['union_price'];
        }
        $charts['categories'] = "'".implode("','",$charts['categories'])."'";
        $charts['series']['data'] = "".implode(",",$charts['series']['data'])."";
        $this->assign("charts",$charts);

        $this->assign("goodsNum",$goodsNum);
        $this->assign("membersNum",$membersNum);
        $this->assign("yestDayProfits",$yestDayProfits);
        $this->assign("thisMonthProfits",$thisMonthProfits);
        $this->assign("lastMonthProfits",$lastMonthProfits);
        $this->assign("thisWeekProfits",$thisWeekProfits);
        $this->display();
    }
    public function make($type=""){
    	$text = '';
    	if($type == "index"){
    		
			$text.= "首页生成：";
	    	ob_start();
	    	$tpl = new \Home\Controller\IndexController();
	    	$tpl->index();
			$contents = ob_get_contents();
			ob_end_clean();
	        $text.= file_put_contents("index.html", $contents)?"成功":"失败";
	        	
	        
			$text.= "<br>注册页面生成：";
	    	ob_start();
	    	$tpl = new \Home\Controller\RegisteController();
	    	$tpl->index();
			$contents = ob_get_contents();
			ob_end_clean();
	        $text.= file_put_contents("registe.html", $contents)?"成功":"失败";
	        
			$text.= "<br>客服中心页面生成：";
	    	ob_start();
	    	$tpl = new \Home\Controller\ContactController();
	    	$tpl->contact();
			$contents = ob_get_contents();
			ob_end_clean();
	        $text.= file_put_contents("contact.html", $contents)?"成功":"失败";
	        
			$text.= "<br>常见问题页面生成：";
	    	ob_start();
	    	$tpl = new \Question\Controller\QuestionController();
	    	$tpl->index();
			$contents = ob_get_contents();
			ob_end_clean();
	        $text.= file_put_contents("question.html", $contents)?"成功":"失败";
	        
			$text.= "<br>新闻公告页面生成：";
	    	ob_start();
	    	$tpl = new \News\Controller\NewsController();
	    	$tpl->index();
			$contents = ob_get_contents();
			ob_end_clean();
	        $text.= file_put_contents("news.html", $contents)?"成功":"失败";

	        $text.= "<br>关于我们：";
	    	ob_start();
	    	$tpl = new \Home\Controller\IndexController();
	    	$tpl->about();
			$contents = ob_get_contents();
			ob_end_clean();
	        $text.= file_put_contents("about.html", $contents)?"成功":"失败";

	        $text.= "<br>商务合作：";
	    	ob_start();
	    	$tpl = new \Home\Controller\IndexController();
	    	$tpl->business();
			$contents = ob_get_contents();
			ob_end_clean();
	        $text.= file_put_contents("business.html", $contents)?"成功":"失败";

	        $text.= "<br>版权声明：";
	    	ob_start();
	    	$tpl = new \Home\Controller\IndexController();
	    	$tpl->copyright();
			$contents = ob_get_contents();
			ob_end_clean();
	        $text.= file_put_contents("copyright.html", $contents)?"成功":"失败";

	        $text.= "<br>服务条款：";
	    	ob_start();
	    	$tpl = new \Home\Controller\IndexController();
	    	$tpl->service();
			$contents = ob_get_contents();
			ob_end_clean();
	        $text.= file_put_contents("service.html", $contents)?"成功":"失败";

	        $text.= "<br>免费声明：";
	    	ob_start();
	    	$tpl = new \Home\Controller\IndexController();
	    	$tpl->freeStatement();
			$contents = ob_get_contents();
			ob_end_clean();
	        $text.= file_put_contents("freeStatement.html", $contents)?"成功":"失败";

	        $text.= "<br>隐私政策：";
	    	ob_start();
	    	$tpl = new \Home\Controller\IndexController();
	    	$tpl->privacy();
			$contents = ob_get_contents();
			ob_end_clean();
	        $text.= file_put_contents("privacy.html", $contents)?"成功":"失败";

	        $text.= "<br>知识产权声明：";
	    	ob_start();
	    	$tpl = new \Home\Controller\IndexController();
	    	$tpl->intellectual();
			$contents = ob_get_contents();
			ob_end_clean();
	        $text.= file_put_contents("intellectual.html", $contents)?"成功":"失败";
	        
	        $this->success($text, U("Admin/Index/index"), 5);
        }elseif($type == "news"){
        	$rows=M("News")->getField("id,last_modify", true);
	    	$tpl = new \News\Controller\NewsController();
	    	$total = count($rows);
	    	$changed = $error = 0;
	    	foreach($rows AS $key => $val)
	    	{
	    		$mtime = filemtime("news/".$key.".html");
	    		if($mtime === false || intval($val) > $mtime)
	    		{
	    			$changed++;
			    	ob_start();
			    	$tpl->detail($key);
					$contents = ob_get_contents();
					ob_end_clean();
					if(file_put_contents("news/".$key.".html", $contents) == false)
						$error++;
	    		}
	    	}
	       	$this->success("新闻公告分页生成成功！总数：{$total}，已修改：{$changed}".($error==0?"。":"，失败数：{$error}，请检测目录权限！"), U("Admin/Index/index"), 5);
        }
    }
}