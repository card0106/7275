<?php
namespace Home\Tool;


// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2009 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// |         lanfengye <zibin_5257@163.com>
// +----------------------------------------------------------------------
class Page {
    
    // 分页栏每页显示的页数
    public $rollPage = 5;
    // 页数跳转时要带的参数
    public $parameter  ;
    // 默认列表每页显示行数
    public $listRows = 20;
    // 起始行数
    public $firstRow    ;
    // 分页总页面数
    protected $totalPages  ;
    // 总行数
    protected $totalRows  ;
    // 当前页数
    protected $nowPage    ;
    // 分页的栏的总页数
    protected $coolPages   ;
    // 分页显示定制
    protected $config  =    array('header'=>'条记录','prev'=>'上一页','next'=>'下一页','first'=>'第一页','last'=>'最后一页','theme'=>'%upPage% %first%  %prePage%  %linkPage%  %nextPage% %downPage% %end%');
    // protected $config  =    array('header'=>'条记录','prev'=>'上一页','next'=>'下一页','first'=>'第一页','last'=>'最后一页','theme'=>' %totalRow% %header% %nowPage%/%totalPage% 页 %upPage% %downPage% %first%  %prePage%  %linkPage%  %nextPage% %end%');
    // 默认分页变量名
    protected $varPage;
    /**
     * 架构函数
     * @access public
     * @param array $totalRows  总的记录数
     * @param array $listRows  每页显示记录数
     * @param array $parameter  分页跳转的参数
     */
    public function __construct($totalRows,$listRows='',$parameter='') {
        $this->totalRows    =   $totalRows; // 构造函数参数 1，总页数
        $this->parameter    =   $parameter; // 构造函数参数 3，URL 附加参数
        $this->varPage      =   C('VAR_PAGE') ? C('VAR_PAGE') : 'p' ; // 获取分页变量名，如果未定义则定义默认分页变量名
        /**
         * intval() 将变量转成整数类型
         */
        if(!empty($listRows)) { // 构造函数参数 2，获取每页显示的条数，如果每页显示的条数不为空则
            $this->listRows =   intval($listRows); // 转换为整型并赋值给每页显示的条数
        }
        /**
         * ceil() 函数向上舍入为最接近的整数(1.1=2)
         */
        $this->totalPages   =   ceil($this->totalRows/$this->listRows); // 获取总页数，记录集的总数除以每页显示的条数等于总页数
        // 假设有 40 条数据，每页显示 5 条，就是有 8 页，每个页面显示 2 个导航栏，就是有4栏
        $this->coolPages    =   ceil($this->totalPages/$this->rollPage); // 获取总栏数， 总栏数除以每页显示的栏数等于总栏数
        /**
         * empty() 如果参数是非空或非零的值，则返回 FALSE,否则返回 TRUE
         */
        $this->nowPage      =   !empty($_GET[$this->varPage])?intval($_GET[$this->varPage]):1; // 获取当前页数，如果 URL 当前页数参数不为空则转换整型并赋值给当前页数，否则赋值为 1
        if(!empty($this->totalPages) && $this->nowPage>$this->totalPages) { // 如果总页数不为空并且当前页数大于总页数则
            $this->nowPage  =   $this->totalPages; // 赋值当前页数为总页数
        }
        // 假设当前页数为 2，每页显示 5 条数据，当前页面就是从第 (5*(2-1)=5) 条记录开始读取数据,
        // 根据 limit 函数定义，索引从零开始，也就是实际的值是记录集的第六条数据
        $this->firstRow     =   $this->listRows*($this->nowPage-1); // 获取起始页，起始行数等于每页显示的条数乘以当前页面减 1
    }
    /**
     * 自定义导航显示
     * @access public
     * @param String $name 待替换的参数名称
     * @param String $value 替换的参数值
     * isset() 返回  bool 值
     * 若变量不存在则返回 FALSE 
     * 若变量存在且其值为NULL，也返回 FALSE 
     * 若变量存在且值不为NULL，则返回 TURE 
     */    
    public function setConfig($name,$value) {
        if(isset($this->config[$name])) {
            $this->config[$name]    =   $value;
        }
    }
    /**
     * 分页显示输出
     * @access public
     * @author lanfengye <zibin_5257@163.com>
     */
    public function show() {
        if(0 == $this->totalRows) return '';
        $p              =   $this->varPage; // 默认分页变量名
        // 假设 40 条数据，每页显示 5 条，导航每页显示 4 栏，当前为第 3 页，也就是 ceil(3/4)=1
        $nowCoolPage    =   ceil($this->nowPage/$this->rollPage); // 当前分页栏
        
        //获取控制器名和方法名，并判断是否url不区分大小写
        $url_case       =   C('URL_CASE_INSENSITIVE');
        $module_name    =   $url_case?  parse_name(MODULE_NAME) :   MODULE_NAME;
        $action_name    =   $url_case?  parse_name(ACTION_NAME) :   ACTION_NAME;
        
        //替换附加参数中的分隔符
        $parameter      =   str_replace(array('&','='), C('URL_PATHINFO_DEPR'), $this->parameter);
        //增加附加参数
        $url            =   rtrim(".'/'.$module_name.C('URL_PATHINFO_DEPR').$action_name.C('URL_PATHINFO_DEPR').$parameter,C('URL_PATHINFO_DEPR')");
        
        //上翻页字符串
        $upRow          =   $this->nowPage-1; // 上一页等于当前页减 1
        // 假设有 40 条记录，每页显示 5 条，当前页数为 1 的时候，上一页就会出现等于 0 的情况。
        if ($upRow>0){ // 如果上一页大于零，输出上一页的链接，            
            $upPage     =   "<a href='".$url.C('URL_PATHINFO_DEPR').$p.C('URL_PATHINFO_DEPR')."$upRow".C('URL_HTML_SUFFIX')."'>".$this->config['prev']."</a>";
        }else{ // 如果上一页小于零，说明当前已经是第一页，不需要上一页链接输出
            $upPage     =   '';
        }
        
        // 下翻页字符串
        $downRow        =   $this->nowPage+1; // 下一页等于当前页加 1
        // 假设有 40 条记录，每页显示 5 条，当前页数为 7 的时候，下一页就会出现等于总页数的情况。
        if ($downRow <= $this->totalPages){ // 如果下一页小于等于总页数，输出下一页链接
            $downPage   =   "<a href='".$url.C('URL_PATHINFO_DEPR').$p.C('URL_PATHINFO_DEPR')."$downRow".C('URL_HTML_SUFFIX')."'>".$this->config['next']."</a>";
        }else{ // 如果下一页小于零，说明当前已经是最后一页，不需要下一页链接输出
            $downPage   =   '';
        }
        
        // << <
        if($nowCoolPage == 1){ // 如果当前分页栏数为 1 时，当前在第一栏，
            $theFirst   =   '';
            $prePage    =   '';
        }else{ // 否则不在第一栏，输出上一栏链接
            $preRow     =   $this->nowPage-$this->rollPage; // 通过当前页数减去每页显示的条页，获取上一页的链接并，并输出
            $prePage    =   "<a href='".$url.C('URL_PATHINFO_DEPR').$p.C('URL_PATHINFO_DEPR')."$preRow".C('URL_HTML_SUFFIX')."' >上".$this->rollPage."页</a>";
            // 输出第一页的链接
            $theFirst   =   "<a href='".$url.C('URL_PATHINFO_DEPR').$p.C('URL_PATHINFO_DEPR')."1".C('URL_HTML_SUFFIX')."' >".$this->config['first']."</a>";
        }
        
        // > >>
        if($nowCoolPage == $this->coolPages){ // 如果当前栏等于最后一栏，当前栏为最后一栏
            $nextPage   =   '';
            $theEnd     =   '';
        }else{ // 否则不在最后一栏，输出最后一栏链接
            $nextRow    =   $this->nowPage+$this->rollPage; // 通过当前页数加上每页显示的条页，获取下一页的链接并，并输出
            $theEndRow  =   $this->totalPages;
            $nextPage   =   "<a href='".$url.C('URL_PATHINFO_DEPR').$p.C('URL_PATHINFO_DEPR')."$nextRow".C('URL_HTML_SUFFIX')."' >下".$this->rollPage."页</a>";
            // 输出最后一条链接
            $theEnd     =   "<a href='".$url.C('URL_PATHINFO_DEPR').$p.C('URL_PATHINFO_DEPR')."$theEndRow".C('URL_HTML_SUFFIX')."' >".$this->config['last']."</a>";
        }
        
        // 1 2 3 4 5
        $linkPage = "";
        for($i=1;$i<=$this->rollPage;$i++){
            // 在96行定义，假设每页显示 5 条数据，
            // 当栏数为 1 时，公式等于{(1-1)*5+i}，page 值等于 1、2、3、4、5
            // 当栏数为 2 时，公式等于{(2-1)*5+i}，page 值等于 6、7、8、9、10            
            $page       =   ($nowCoolPage-1)*$this->rollPage+$i;
            if($page!=$this->nowPage){ // 当 page 值不等于当前页数的时
                if($page<=$this->totalPages){ // 当 page 值小于等于总页数时，输出链接
                    $linkPage .= " <a href='".$url.C('URL_PATHINFO_DEPR').$p.C('URL_PATHINFO_DEPR')."$page".C('URL_HTML_SUFFIX')."'> ".$page." </a>";
                }else{ // 否则返回
                    break;
                }
            }else{ // 否则并且  page 值不等于 1 输出当前页面数(无链接)
                if($this->totalPages != 1){ // ?????有没有这个判断貌似一样?????
                    $linkPage .= " <span class='current'>".$page."</span>";
                }
            }
        }
        
        $pageStr     =     str_replace(
            array('%header%','%nowPage%','%totalRow%','%totalPage%','%upPage%','%downPage%','%first%','%prePage%','%linkPage%','%nextPage%','%end%'),
            array($this->config['header'],$this->nowPage,$this->totalRows,$this->totalPages,$upPage,$downPage,$theFirst,$prePage,$linkPage,$nextPage,$theEnd),$this->config['theme']);
        return $pageStr;
    }
}