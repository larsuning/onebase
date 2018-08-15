<?php

namespace app\{$module}\controller;

use app\common\controller\ControllerBase;
use think\Hook;
// 解决跨域问题
//@header('Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept, Connection, User-Agent, Cookie');
// 指定允许其他域名访问
header('Access-Control-Allow-Origin:*');
// 响应类型
//header('Access-Control-Allow-Methods:*');
// 响应头设置
header('Access-Control-Allow-Headers:x-requested-with,content-type');

/**
* 接口基类控制器
*/
class {$modules}Base extends ControllerBase
{

    /**
    * 基类初始化
    */
    public function __construct()
    {
        parent::__construct();

        $this->logic{$modules}Base->checkParam($this->param);

        // 接口控制器钩子
        Hook::listen('hook_controller_api_base', $this->request);

        debug('api_begin');
    }

    /**
    * API返回数据
    */
    public function apiReturn($code_data = [], $return_data = [], $return_type = 'json')
    {

        $result = $this->logic{$modules}Base->apiReturn($code_data, $return_data, $return_type);

        debug('api_end');

        write_exe_log('api_begin', 'api_end', DATA_NORMAL);

        return $result;
    }
}