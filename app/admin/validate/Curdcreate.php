<?php
namespace app\admin\validate;
/**
* Curdcreate验证器
*/
class Curdcreate extends AdminBase
{

// 验证规则
protected $rule =   [

'name'              => 'require',
'module'            =>'require',
    'tb_name'     =>'require',
    'url'           =>'require|alpha',
    'list_grid'     =>'require',

];

// 验证提示
protected $message  =   [

'name.require'              => '名称不能为空',
    'module.require'        =>'module不能为空',
    'tb_name.require'         =>'数据表名称不能为空',
    'url.require'           =>'模型标识不能为空',
    'url.alpha'             =>'模型标识只能为字母',
    'list_grid.require'     =>'列表显示定义不能为空',

];

// 应用场景
protected $scene = [

'edit' =>  ['name','module','url','list_grid'],
'add'  =>  ['name','module','url','list_grid','tb_name'],
];

}
