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

namespace app\ps\validate;

/**
 * API验证器
 */
class InspectionArea extends PsBase
{
	// 验证规则
		protected $rule =   [

			'name'     => 'require',
			'times'         => 'require|number',
			'sort'          => 'require|number',
		];

		// 验证提示
		protected $message  =   [

			'name.require'                 => '区域名称尚未填写',
			'times.require'                => '巡查次数尚未选择',
			'sort.require'                 => '区域排序不能为空',
			'sort.number'                  => '区域排序要为整数',

		];

		// 应用场景的
		protected $scene = [
			'add' => ['name','times','sort'],
		];
}