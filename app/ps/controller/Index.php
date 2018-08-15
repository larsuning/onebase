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

/**
 * 首页控制器
 */
class Index extends PsBase
{
    
    /**
     * 首页方法
     */
    public function index()
    {
        
        // 获取首页数据
        $index_data = $this->logicPsBase->getIndexData();
        
        $this->assign('info', $index_data);
        
        return $this->fetch('index');
    }
}
