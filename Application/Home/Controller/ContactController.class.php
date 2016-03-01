<?php

namespace Home\Controller;

/**
 * Description of ContactController
 *
 * @author Administrator
 */
class ContactController extends \Think\Controller{
    //展示帮助中心的页面
    public function contact(){
    	$this->assign('menu', 'contact');
        $this->display(T('Home@Contact/contact'));
    }
}
