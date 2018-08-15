<?php
namespace app\admin\validate;
/**
* Test验证器
*/
class Test extends AdminBase
{

// 验证规则
protected $rule =   [

'name'              => 'require',

];

// 验证提示
protected $message  =   [

'name.require'              => '名称不能为空',

];

// 应用场景
protected $scene = [

'edit' =>  ['name'],
'add'  =>  ['name'],
];

}
