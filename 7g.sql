CREATE TABLE `goods` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增长ID',
  `goods_name` varchar(32) NOT NULL DEFAULT '' COMMENT '产品名称',
  `category_id` tinyint(3) unsigned NOT NULL DEFAULT '0' COMMENT '产品所属分类',
  `cash_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '结算类型',
  `max_links` tinyint(3) NOT NULL DEFAULT 0 COMMENT '最大链接数',
  `effective_links` tinyint(3) NOT NULL DEFAULT 0 COMMENT '有效链接数',
  `invoicing_cycle` tinyint(4) NOT NULL DEFAULT '0' COMMENT '结算周期 0：日结; 1:周结; 2:月结',
  `data_back` tinyint(4) NOT NULL DEFAULT '0' COMMENT '0:次日18时; 1:实时数据; 2:隔天18时',
  `top_time` int(11) NOT NULL DEFAULT '0' COMMENT '置顶排序',
  `state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '产品状态 0:已关闭; 1:正在进行',
  `goods_big_img` varchar(255) NOT NULL DEFAULT '' COMMENT '产品的大图片',
  `goods_small_img` varchar(255) NOT NULL DEFAULT '' COMMENT '产品的大图片',
  `intro` text COMMENT '产品介绍及说明',
  `measure` tinyint(1) NOT NULL DEFAULT '0' COMMENT '单位',
  `percent`  decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '百分比',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8 COMMENT='产品表'

drop table `goods_link`;
CREATE TABLE `goods_link` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增长ID',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '产品ID',
  `members_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `link_url` varchar(255) NOT NULL DEFAULT '' COMMENT '链接URL',
  `discount` smallint(6) NOT NULL DEFAULT '0' COMMENT '链接的扣量率',
  `up_price_1` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '数据上游价',
  `down_price_1` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '数据下游价',
  `state` tinyint(1) NOT NULL DEFAULT 0 COMMENT '当前链接状态',
  `site_name` varchar(255) NOT NULL DEFAULT '渝网传媒' COMMENT '网站名称',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8 COMMENT='产品链接表'


CREATE TABLE `goods_apply` (
  `id` int(11) unsigned NOT NULL AUTO_INCREMENT COMMENT '自增长ID',
  `goods_id` int(11) NOT NULL DEFAULT '0' COMMENT '产品ID',
  `goods_link_id` int(11) NOT NULL DEFAULT '0' COMMENT '产品ID',
  `members_id` int(11) NOT NULL DEFAULT '0' COMMENT '用户ID',
  `processed` tinyint(1) NOT NULL DEFAULT 0 COMMENT '是否处理',
  `state` tinyint(1) NOT NULL DEFAULT 0 COMMENT '申请状态',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8 COMMENT='产品链接申请表'

CREATE TABLE `data_list`(
	`id` int(11) unsigned  NOT NULL AUTO_INCREMENT COMMENT '自增长ID',
	`good_link_id` int(11) unsigned NOT NULL ,
	`up_price_1` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '数据上游价',
	`down_price_1` decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '数据下游价',
	`cash_type` tinyint(1) NOT NULL DEFAULT '0' COMMENT '结算类型',
	`percent`  decimal(10,2) NOT NULL DEFAULT '0.00' COMMENT '百分比',
	`data_list` INT(10) NOT NULL DEFAULT '0' COMMENT  '数据量',
	`onfile`  int()  NOT NULL DEFAULT '0' COMMENT '归档',
	`data_time`  DATE   COMMENT  '数据时间',
	`create_time` DATETIME   COMMENT '操作时间',
 	PRIMARY KEY (`id`)
 )ENGINE=InnoDB AUTO_INCREMENT=10000 DEFAULT CHARSET=utf8 COMMENT='数据流量表'

CREATE TABLE `members`(
`id` int(11) unsigned NOT NULL AUTO_INCREMENT,
`username` varchar(32) DEFAULT NULL COMMENT '会员名不能重复',
`password` varchar(255) NOT NULL DEFAULT '' COMMENT '会员密码',
`qq` varchar(16) NOT NULL DEFAULT '' COMMENT '会员QQ号码',
`email` varchar(64) NOT NULL DEFAULT '' COMMENT '会员邮箱',
`tel` varchar(16) NOT NULL DEFAULT '' COMMENT '会员电话号码',
`payee` varchar(32) NOT NULL DEFAULT '' COMMENT '收款人',
`bank_name` varchar(64) NOT NULL DEFAULT '' COMMENT '银行名称', 
`bank_account` varchar(64)  NOT NULL DEFAULT '' COMMENT '银行帐号',
`bank_addr` varchar(255) NOT NULL DEFAULT '' COMMENT '开户行地址',
`client_ip` bigint(20) NOT NULL DEFAULT '0' COMMENT '' COMMENT '会员登陆IP',
`login_num` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员登录的次数',
`money` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员的收益',
`enter_time` int(11) NOT NULL DEFAULT '0' COMMENT '会员加入联盟的时间',
`state` tinyint(4) NOT NULL DEFAULT '1' COMMENT '会员的状态 0:禁用 1:正常',
`zhifubao` varchar(255) NOT NULL DEFAULT '' COMMENT '支付宝',
`photo_url` varchar(255) NOT NULL DEFAULT '' COMMENT '个人照片地址',
`create_date` TIMESTAMP COMMENT '创建时间',
PRIMARY KEY (`id`),
UNIQUE KEY `username` (`username`),
UNIQUE KEY `username_2` (`username`)
)ENGINE=MyISAM AUTO_INCREMENT=17 DEFAULT CHARSET=utf8 COMMENT='会员表' 


CREATE TABLE `category` (
 `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '产品分类ID',
  `category_name` varchar(32) NOT NULL DEFAULT '' COMMENT '产品分类的名称',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=0 DEFAULT CHARSET=utf8 COMMENT='产品分类表';
SET sql_mode='NO_AUTO_VALUE_ON_ZERO'; 

alter table goods add `measure` tinyint(1) NOT NULL DEFAULT '0' COMMENT '单位';
alter table `goods_link` drop column measure;
