<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Admin\Model;

/**
 * Description of QuestionModel
 *
 * @author Administrator
 */
class QuestionModel extends BaseModel{
    protected $_validate = array(
       array('title','require','标题名必须填写！'),  // 都有时间都验证
       array('title','','新闻标题名称已经存在！',0,'unique',2),  // 在新增的时候验证name字段是否唯一     
       array('content','require','问题内容必须填写！'), // 当值不为空的时候判断是否在一个范围内
       array('content',"1,1000",'新闻内容不能低于6个长度',0,'length',2), // 当值不为空的时候判断是否在一个范围内
    );  
    protected $_auto     =array(
        array('time','time',3,'function')
    ); 
}
