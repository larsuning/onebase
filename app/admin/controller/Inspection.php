<?php
// +---------------------------------------------------------------------+
// | OneBase    | [ WE CAN DO IT JUST THINK ]                            |
// +---------------------------------------------------------------------+
// | Licensed   | http://www.apache.org/licenses/LICENSE-2.0 )           |
// +---------------------------------------------------------------------+
// | Author     | Bigotry <3162875@qq.com>                               |
// +---------------------------------------------------------------------+
// | Repository | https://gitee.com/Bigotry/OneBase                      |
// +---------------------------------------------------------------------+

namespace app\ps\controller;
use app\admin\controller\AdminBase;

/**
 * 首页控制器
 */
class Inspection extends AdminBase
{
    
    /**
     * 首页方法
     */
    public function index()
    {
        echo 1;die;
        // 获取首页数据
        $index_data = $this->logicAdminBase->getIndexData();
        
        $this->assign('info', $index_data);
        
        return $this->fetch('index');
    }
}
