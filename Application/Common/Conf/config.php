<?php
define("WEB_URL", '');
return array(
	//'配置项'=>'配置值'
    TMPL_PARSE_STRING  =>array(
     '__CSS__' => WEB_URL.'/Public/css',        // 更改默认的__PUBLIC__ 替换规则
     '__JS__' => WEB_URL.'/Public/js',          // 增加新的JS类库路径替换规则
     '__IMG__' => WEB_URL.'/Public/images',     // 增加新的上传路径替换规则
    ),
    //数据库配置
    'DB_TYPE'               =>  'mysql',        // 数据库类型
    'DB_HOST'               =>  'localhost',    // 服务器地址
    'DB_NAME'               =>  '7g',           // 数据库名
    'DB_USER'               =>  'root',         // 用户名
    'DB_PWD'                =>  'lihuan0106',    // 密码
    'DB_PORT'               =>  '3306',         // 端口
    'DB_PREFIX'             =>  '',             // 数据库表前缀
    'DB_CHARSET'            =>  'utf8',         //设置数据库编码
    "PAGESIZE"              =>  30,
    
    'SHOW_PAGE_TRACE'		=> true,           //ye miantiaoshi
    
    'DEFAULT_MODULE'        =>  'Home',         // 默认模块 
    'MODULE_ALLOW_LIST'		=> array("Admin","Login","Home","Verify","Crontab"),//"News","Question"),
    'URL_MODULE_MAP'    =>    array('amomanager'=>'Admin','amomanagerlogin'=>'Login'),
    
	'URL_MODEL'				=>	2,
	
    'URL_ROUTER_ON'			=> on,
    'URL_ROUTE_RULES'		=> array(
    	'userinfo' => 'Home/Userinfo/userInfo',
    	'individual' => 'Home/Userinfo/individual',
    	'pass' => 'Home/Userinfo/pass',
    	'shenqingtixian' => 'Home/Userinfo/shenqingtixian',
    	'myad' => 'Home/Ad/myAd',
    	'/^getgoods(\d+)_(\d+)$/' => 'Home/Goods/getGoods?catid=:1&p=:2',
    	'/^getgoods(|\d+)$/' => 'Home/Goods/getGoods?catid=:1',
    	'/^effect(|\d+)$/' => 'Home/Report/effect?p=:1',
    	'/^detail(|\d+)$/' => 'Home/Finance/detail?p=:1',
    	'forget' => 'Home/Registe/forget'
    	)
);
